<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;

/**
* Rubrics Controller
*
* @property \App\Model\Table\RubricsTable $Rubrics
*
* @method \App\Model\Entity\Rubric[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
*/
class RubricsController extends AppController
{
  public $paginate = [
      'limit' => 25,
      'order' => [
          'Rubrics.title' => 'ASC'
      ],
  ];

  public function initialize()
  {
    parent::initialize();
    $this->loadComponent('RequestHandler');
    $this->Auth->allow();
  }

  /**
  * Index method
  *
  * @return \Cake\Http\Response|void
  */
  public function index()
  {

    $data = $this->Rubrics
      ->find('all')
      ->where(['user_id' => $this->Auth->user('id')]);
    $rubrics = $this->paginate($data);

    $this->set(compact('rubrics'));
  }

  /**
  * View method
  *
  * @param  string|null                                        $id  Rubric id.
  * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
  * @return \Cake\Http\Response|void
  */
  public function view($id = null)
  {
    $rubric = $this->Rubrics->get($id, [
      'contain' => ['Users', 'Questions'],
    ]);

    $this->set('rubric', $rubric);
  }

  /**
  * Add method
  *
  * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
  */
  public function add($id = null)
  {
    $rubric = $this->Rubrics->newEntity();
    $exist = false;
    if ($this->request->is('post')) {
      $rubric = $this->Rubrics->patchEntity($rubric, $this->request->getData());
      $rubric->user_id = $this->Auth->user('id');
      if ($this->Rubrics->save($rubric)) {
        $this->Flash->success(__('Salvo com sucesso.'));

        return $this->redirect(['action' => 'index']);
      }
      $this->Flash->error(__('Ocorreu um erro.'));
    }


    $this->set(compact('rubric'));
  }

  /**
  * Edit method
  *
  * @param  string|null                               $id       Rubric id.
  * @throws \Cake\Network\Exception\NotFoundException When record not found.
  * @return \Cake\Http\Response|null                  Redirects on successful edit, renders view otherwise.
  */
  public function edit($id = null)
  {
    $rubric = $this->Rubrics->get($id, [
      'contain' => [],
    ]);
    if ($this->request->is(['patch', 'post', 'put'])) {
      $rubric = $this->Rubrics->patchEntity($rubric, $this->request->getData());
      if ($this->Rubrics->save($rubric)) {
        $this->Flash->success(__('Salvo com sucesso.'));

        return $this->redirect(['action' => 'index']);
      }
      $this->Flash->error(__('Ocorreu um erro.'));
    }
    $users = $this->Rubrics->Users->find('list', ['limit' => 200]);
    $this->set(compact('rubric', 'users'));
  }

  /**
  * Delete method
  *
  * @param  string|null                                        $id       Rubric id.
  * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
  * @return \Cake\Http\Response|null                           Redirects to index.
  */
  public function delete($id = null)
  {
    $this->request->allowMethod(['post', 'delete']);
    $rubric = $this->Rubrics->get($id);
    if ($this->Rubrics->delete($rubric)) {
      $this->Flash->success(__('Excluído com sucesso.'));
    } else {
      $this->Flash->error(__('Ocorreu um erro.'));
    }

    return $this->redirect(['action' => 'index']);
  }

  public function saveInfoRubric() {
    $this->RequestHandler->respondAs('json');
    $this->response->type('application/json');
    $this->autoRender = false;

    if ($this->request->is(['ajax', 'post'])) {
      $this->viewBuilder()->enableAutoLayout(false);
      $rubric = $this->Rubrics->newEntity();
      $rubric = $this->Rubrics->patchEntity($rubric, $this->request->getData());
      $rubric->user_id = $this->Auth->user('id');
      if ($this->Rubrics->save($rubric)) {
        // $this->log($rubric);
        echo json_encode($rubric);
      }
    }

  }

  public function saveQuestionsRubric() {
    $this->RequestHandler->respondAs('json');
    $this->response->type('application/json');
    $this->autoRender = false;
    if ($this->request->is(['ajax', 'post'])) {
      $this->viewBuilder()->enableAutoLayout(false);
      $data = $this->request->getData();
      $question = $this->Rubrics->Questions->newEntity();
      $question->type = $data['type'];
      $question->description = $data['description'];
      $question->rubric_id = $data['rubric_id'];
      if (key_exists('scales', $data)) {
        $values = [];
        foreach ($data['scales'] as $key => $value) {
          $this->log($value);
          array_push($values, ['value' => $value]);
        }
        $question->options = json_encode($values);
      }
      $this->log($question);
      $this->Rubrics->Questions->save($question);
    }

  }

  public function loadQuestionsByRubric() {
    $this->viewBuilder()->enableAutoLayout(false);
    $rubric_id = $this->request->getQuery('rubric_id');
    $questions = $this->Rubrics->Questions->find()
         ->where(['rubric_id' => $rubric_id]);
    $this->set('questions', $questions);
    //debug($questions);
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
  */
  public function isAuthorized($user)
  {
    $action = $this->request->getParam('action');
    if (in_array($action, ['index', 'add', 'saveInfoRubric', 'saveQuestionsRubric', 'loadQuestionsByRubric'])) {
      return true;
    }
    return false;
  }
}
