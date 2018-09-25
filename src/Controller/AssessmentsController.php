<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;
use Cake\I18n\Time;
use Cake\ORM\TableRegistry;
use Cake\Log\Log;

/**
* Assessments Controller
*
* @property \App\Model\Table\AssessmentsTable $Assessments
*
* @method \App\Model\Entity\Assessment[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
*/
class AssessmentsController extends AppController
{

  public $paginate = [
      'limit' => 25,
      'order' => [
        'Assessments.status' => 'ASC',
        'Assessments.title' => 'ASC'
      ],
      'contain' => ['Teams' => ['Disciplines'], 'Users'],
  ];

  public function initialize()
  {
    parent::initialize();

  }

  /**
  * Index method
  *
  * @return \Cake\Http\Response|void
  */
  public function index()
  {

    // $this->paginate = [
    //   'contain' => ['Teams' => ['Disciplines'], 'Users'],
    //   'where' => ['Assessments.user_id' => $this->Auth->user('id')]
    // ];
    $data = $this->Assessments
      ->find('all')
      // ->contain(['Teams', 'Users'])
      ->where(['Assessments.user_id' => $this->Auth->user('id')]);
    $assessments = $this->paginate($data);

    $this->set(compact('assessments'));
  }

  /**
  * View method
  *
  * @param string|null $id Assessment id.
  * @return \Cake\Http\Response|void
  * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
  */
  public function view($id = null)
  {
    $assessment = $this->Assessments->get($id, [
      'contain' => ['Teams', 'Users', 'AssessmentRubrics']
    ]);


    $this->set('assessment', $assessment);
  }

  /**
  * Add method
  *
  * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
  */
  public function add()
  {
    $assessment = $this->Assessments->newEntity();
    if ($this->request->is('post')) {
      $data = $this->request->getData();
      Log::write('debug', $data);
      debug($data);
      $assessment = $this->Assessments->patchEntity($assessment, $data);
      $assessment->user_id = $this->Auth->user('id');
      $assessment->status = 'preparation';
      $assessment->file = $data['attachment'];

      $array = [];
      for($i = 0; $i < $assessment->scale; $i++) {
        $array[] = ($i+1);
      }
      $assessment->labels = json_encode($array);

      $dateFormat = 'm/d/Y g:i A';
      if (strtolower($this->Auth->user('locale')) == 'pt-br'){
        $dateFormat = 'd/m/Y H:i';
      }

      $assessment->startAt = Time::createFromFormat($dateFormat, $data['startAt']);
      $assessment->endAt = Time::createFromFormat($dateFormat, $data['endAt']);

      if ($this->Assessments->save($assessment)) {
        $this->Flash->success(__('A avaliação foi criada com sucesso.'));
        $this->set('assessment', $assessment);
        return $this->redirect(['action' => 'controls', $assessment->id]);
      }
      $this->Flash->error(__('Não foi possível salvar a avaliação. Por favor, tente novamente.'));
      debug($assessment->getErrors());
    }

    // TODO: Mudar para buscar na Table
    $teamsTable = TableRegistry::get('Teams');
    $teams = $teamsTable
      ->find('list', [
        'keyField' => 'id',
        'valueField' => function($teamsTable) {
          return $teamsTable->get('name') . ': ' . $teamsTable->discipline->get('name');
        }
      ])
      ->contain(['Disciplines'])
      ->where(['Disciplines.user_id' => $this->Auth->user('id')])
      ->order(['Disciplines.name' => 'ASC', 'Teams.name' => 'ASC']);

    $locale = (strtolower($this->Auth->user('locale')) == 'pt-br') ? 'pt-br' : 'en';

    $this->set(compact('assessment', 'teams', 'locale'));
  }

  public function controls($id) {
    $assessment = $this->Assessments->get($id, [
      'contain' => ['AssessmentRubrics' => ['Rubrics'], 'Teams' => ['Disciplines']]
    ]);
    $rubricsTable = TableRegistry::get('Rubrics');
    $rubrics = $rubricsTable
      ->find('list')
      ->where(['user_id' => $this->Auth->user('id')])
      ->order(['title' => 'ASC']);

    $this->set(compact('assessment', 'rubrics'));
  }

  public function addRubric() {
    $this->request->allowMethod(['post']);
    $data = $this->request->getData();

    $rubricsTable = TableRegistry::get('Rubrics');
    $rubric = $rubricsTable->get($data['rubric']);
    if ($rubric->user_id != $this->Auth->user('id')) {
      $this->Flash->error(__('Você não está autorizado a acessar essa rubrica.'));
      return $this->redirect(['action' => 'index']);
    }

    $assessment = $this->Assessments->get($data['assessment_id']);
    if ($assessment->user_id != $this->Auth->user('id')) {
      $this->Flash->error(__('Você não está autorizado a acessar essa avaliação.'));
      return $this->redirect(['action' => 'index']);
    }

    $assessmentRubricsTable = TableRegistry::get('AssessmentRubrics');
    $assessmentRubric = $assessmentRubricsTable->newEntity();
    $assessmentRubric->assessment = $assessment;
    $assessmentRubric->rubric = $rubric;
    $assessmentRubric->weight = ((empty($data['weight']) || $data['weight'] <= 0) ? 1 : $data['weight']);

    if ($assessmentRubricsTable->save($assessmentRubric)) {
      $this->Flash->success(__('Rubrica adicionada com sucesso.'));
      return $this->redirect(['action' => 'controls', $assessment->id]);
    }

    // TODO: Veriricar tipos de erros que podem ocorrer aqui.
    $this->Flash->error(__('Ocorreu um erro'));
    return $this->redirect(['action' => 'index']);
  }

  public function removeRubric($assessment_rubric_id) {
    $this->request->allowMethod(['post', 'delete']);
    $assessmentRubricsTable = TableRegistry::get('AssessmentRubrics');
    $assessmentRubric = $assessmentRubricsTable->get($assessment_rubric_id, ['contain' => ['Assessments']]);

    if ($assessmentRubric->assessment->user_id != $this->Auth->user('id')) {
      $this->Flash->error(__('Você não está autorizado a acessar essa avaliação.'));
      return $this->redirect(['action' => 'index']);
    }

    if ($assessmentRubric->assessment->status != 'preparation') {
      $this->Flash->error(__('Você não pode remover essa rubrica. Esta avaliação já foi publicada.'));
      return $this->redirect(['action' => 'controls', $assessmentRubric->assessment->id]);
    }

    if ($assessmentRubricsTable->delete($assessmentRubric)) {
      $this->Flash->success(__('Rubrica removida com sucesso.'));
      return $this->redirect(['action' => 'controls', $assessmentRubric->assessment->id]);
    }

    $this->Flash->error(__('Error'));
    return $this->redirect(['action' => 'index']);
  }

  public function changeScales() {
    $this->request->allowMethod(['post']);
    $data = $this->request->getData();

    $assessment = $this->Assessments->get($data['assessment_id']);

    if ($assessment->user_id != $this->Auth->user('id')) {
      $this->Flash->error(__('Você não está autorizado a acessar essa avaliação.'));
      return $this->redirect(['action' => 'index']);
    }

    $array = [];
    foreach($data['scales'] as $scale) {
      $array[] = $scale;
    }
    $assessment->labels = json_encode($array);

    if ($this->Assessments->save($assessment)) {
      $this->Flash->success(__('Etiquetas alteradas com sucesso.'));
      return $this->redirect(['action' => 'controls', $assessment->id]);
    }

    // TODO: Veriricar tipos de erros que podem ocorrer aqui.
    $this->Flash->error(__('Ocorreu um erro'));
    return $this->redirect(['action' => 'index']);
  }

  public function publish($id) {
    $this->request->allowMethod(['post']);

    $assessment = $this->Assessments->get($id);
    $assessment->status = 'open';

    if ($this->Assessments->save($assessment)) {
      $this->Flash->success(__('Avaliação publicada com sucesso.'));
    } else {
      $this->Flash->error(__('Ocorreu um erro.'));
    }

    return $this->redirect(['action' => 'index']);
  }

  /**
  * Edit method
  *
  * @param string|null $id Assessment id.
  * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
  * @throws \Cake\Network\Exception\NotFoundException When record not found.
  */
  public function edit($id = null)
  {
    $assessment = $this->Assessments->get($id, [
      'contain' => []
    ]);
    if ($this->request->is(['patch', 'post', 'put'])) {
      $assessment = $this->Assessments->patchEntity($assessment, $this->request->getData());
      if ($this->Assessments->save($assessment)) {
        $this->Flash->success(__('A avaliação foi salva com sucesso.'));

        return $this->redirect(['action' => 'index']);
      }
      $this->Flash->error(__('Não foi possível salvar a avaliação. Por favor, tente novamente.'));
    }
    $teams = $this->Assessments->Teams->find('list', ['limit' => 200]);
    $users = $this->Assessments->Users->find('list', ['limit' => 200]);
    $this->set(compact('assessment', 'teams', 'users'));
  }

  /**
  * Delete method
  *
  * @param string|null $id Assessment id.
  * @return \Cake\Http\Response|null Redirects to index.
  * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
  */
  public function delete($id = null)
  {
    $this->request->allowMethod(['post', 'delete']);
    $assessment = $this->Assessments->get($id);
    if ($this->Assessments->delete($assessment)) {
      $this->Flash->success(__('A avaliação foi excluída com sucesso.'));
    } else {
      $this->Flash->error(__('Não foi possível excluir a avaliação. Por favor, tente novamente.'));
    }

    return $this->redirect(['action' => 'index']);
  }

  /**
  * Load the default layout when users are logged
  */
  public function beforeFilter(Event $event)
  {
    parent::beforeFilter($event);
    $this->viewBuilder()->setLayout('logged');
  }

  /**
  * @param $user
  * @return mixed
  */
  public function isAuthorized($user)
  {
    $action = $this->request->getParam('action');
    if (in_array($action, ['index', 'add', 'addRubric', 'removeRubric', 'changeScales'])) {
      return true;
    }

    $assessment_id = $this->request->getParam('pass.0');
    if (!$assessment_id) {
      return false;
    }

    $assessment = $this->Assessments->findById($assessment_id)->first();

    return $assessment->user_id === $user['id'];
  }
}
