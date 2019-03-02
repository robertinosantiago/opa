<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;
use Cake\I18n\Time;
use Cake\ORM\TableRegistry;
use Cake\ORM\Query;
use Cake\Log\Log;
use Cake\Filesystem\File;

/**
* Classe utilizada para controlar as avaliações
*
* @author Robertino Mendes Santiago Junior
*/
class AssessmentsController extends AppController {

  public $paginate = [
      'limit' => 25,
      'order' => [
        'Assessments.status' => 'ASC',
        'Assessments.title' => 'ASC'
      ],
      'contain' => ['Teams' => ['Disciplines'], 'Users'],
  ];

  /**
  * Método que lista todas as avaliações do usuário
  */
  public function index()
  {
    $data = $this->Assessments
      ->find('all')
      ->where(['Assessments.user_id' => $this->Auth->user('id')]);
    $assessments = $this->paginate($data);

    $this->set(compact('assessments'));
  }

  /**
  * Método utilizado para criar uma nova avaliação
  * Se a requisição vier via POST, os dados serão salvos no banco de dados.
  * Caso contrário, será exibido o formulário para informar os dados
  */
  public function add()
  {
    $assessment = $this->Assessments->newEntity();

    if ($this->request->is('post')) {
      $data = $this->request->getData();

      $assessment = $this->Assessments->patchEntity($assessment, $data);
      $assessment->user_id = $this->Auth->user('id');
      $assessment->status = 'preparation';
      if ($data['attachment']['tmp_name'] != '')
        $assessment->file = $data['attachment'];

      $array = [];
      for($i = 0; $i < $assessment->scale; $i++) {
        $array[] = $data['scales'][$i];
      }
      $assessment->labels = json_encode($array);

      $dateFormat = 'd/m/Y H:i';
      if (strtolower($this->Auth->user('locale')) == 'en'){
        $dateFormat = 'm/d/Y g:i A';
      }

      $assessment->startAt = Time::createFromFormat($dateFormat, $data['datestart'] . ' ' . $data['timestart']);
      $assessment->endAt = Time::createFromFormat($dateFormat, $data['dateend'] . ' ' . $data['timeend']);

      $assessment->start_assessment = Time::createFromFormat($dateFormat, $data['datestartassessment'] . ' ' . $data['timestartassessment']);
      $assessment->end_assessment = Time::createFromFormat($dateFormat, $data['dateendassessment'] . ' ' . $data['timeendassessment']);

      $rubricsTable = TableRegistry::get('Rubrics');
      $assessmentRubricsTable = TableRegistry::get('AssessmentRubrics');

      $array = [];

      for ($i = 0; $i < count($data['rubrics_id']); $i++) {
        $assessmentRubric = $assessmentRubricsTable->newEntity();
        $assessmentRubric->rubric = $rubricsTable->get($data['rubrics_id'][$i]);
        $assessmentRubric->weight = ((empty($data['rubrics_weight'][$i]) || $data['rubrics_weight'][$i] <= 0) ? 1 : $data['rubrics_weight'][$i]);
        $array[] = $assessmentRubric;
      }

      $assessment->assessment_rubrics = $array;

      if ($this->Assessments->save($assessment)) {
        $this->Flash->success(__('A avaliação foi criada com sucesso.'));
        $this->set('assessment', $assessment);
        return $this->redirect(['action' => 'controls', $assessment->id]);
      }
      $this->Flash->error(__('Não foi possível salvar a avaliação. Por favor, tente novamente.'));
      debug($assessment->getErrors());
    }

    $teamsTable = TableRegistry::get('Teams');
    $teams = $teamsTable->find('byUserAuth', ['user_id' => $this->Auth->user('id')]);

    $locale = (strtolower($this->Auth->user('locale')) == 'en') ? 'en' : 'pt-br';

    $disciplinesTable = TableRegistry::get('Disciplines');

    $disciplines = $disciplinesTable
      ->find('list')
      ->where([
        'Disciplines.user_id' => $this->Auth->user('id'),
        'Disciplines.deleted' => false
      ])
      ->order(['Disciplines.name' => 'ASC']);

    $this->set(compact('assessment', 'teams', 'disciplines', 'locale'));
  }

  /**
  * Método utilizado para acessar os dados da avaliação. Neste área é possível
  * alterar, excluir, publicar ou definir os pares da avaliação
  *
  * @param $id int Código da avaliação
  */
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

  /**
  * Função utilizada para alterar o status da avaliação para PUBLICADA.
  * Ao alterar o status, não é permitido alterar ou excluir a avaliação.
  * A opção de atribuição dos pares é habilitada quando o status é alterado.
  *
  * @param $id int Código da avaliação
  */
  public function publish($id) {
    $this->request->allowMethod(['post']);

    $assessment = $this->Assessments->get($id);
    $assessment->status = 'open';

    if ($this->Assessments->save($assessment)) {
      $this->Flash->success(__('Avaliação publicada com sucesso.'));
    } else {
      $this->Flash->error(__('Não foi possível alterar o status para avaliação.'));
    }

    return $this->redirect(['action' => 'index']);
  }

  /**
  * Método utilizado para alterar as informações da avaliação
  *
  * TODO: Terminar a implementação deste método.
  *
  * @param string $id Código da avaliação
  */
  public function edit($id)
  {
    $assessment = $this->Assessments->get($id);
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
  * Método utilizado para excluir uma avaliação
  *
  * @param int $id Código da avaliação
  */
  public function delete($id)
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
  * Método utilizado para acessar um arquivo disponibilizado pela avaliação.
  *
  * @param string $filename Nome do arquivo a ser acessado
  * @return mixed $response
  */
  public function getFile($filename) {
    $dir = ROOT . DIRECTORY_SEPARATOR . 'files' . DIRECTORY_SEPARATOR;
    $file = new File($dir . $filename, false, 0644);
    $response = $this->response->withFile($file->path, ['download' => true]);
    return $response;
  }

  /**
  * Método utilizado para realizar a distribuição dos pares avaliadores e
  * pares avaliados
  *
  * @param int $id Código da avaliação
  */
  public function peers($id) {
    $assessment = $this->Assessments
        ->get($id, ['contain' => ['AssessmentRubrics' => ['Rubrics'], 'Teams' => ['Disciplines', 'TeamUsers' => 'Users']]]);

    $users = $assessment->team->team_users;
    $countStudents = count($users) > 0 ? count($users) - 1 : 0;
    // debug($countStudents);

    $this->set(compact('assessment', 'users', 'countStudents'));
  }

  /**
  * Método utilizado para recuperar, via Ajax, a lista de pares avaliados e
  * pares avaliadores de uma determinada avaliação.
  *
  * Recebe via POST o código da avaliação e renderiza a tabela com a listagem
  *
  * Este método está sendo usado em:
  * - /assessments/peers/$id
  */
  public function listPeers() {
    $this->request->allowMethod(['post']);
    $this->viewBuilder()->layout('ajax');

    $data = $this->request->getData();

    $assessment = $this->Assessments->get($data['assessment_id']);

    if ($assessment->user_id != $this->Auth->user('id')) {
      $this->Flash->error(__('Você não está autorizado a acessar essa avaliação.'));
      return $this->redirect(['action' => 'index']);
    }

    $peersTable = TableRegistry::get('Peers');

    $users = $peersTable->find()
      ->select(['Peers.user_id', 'Users.first_name', 'Users.last_name'])
      ->join([
        'Users' => [
          'table' => 'users',
          'type' => 'inner',
          'conditions' => 'Users.id = Peers.user_id'
        ],
      ])
      ->where(['Peers.assessment_id' => $assessment->id])
      ->group(['Peers.user_id']);

    foreach ($users as $user) {
      $user['appraisers'] = $peersTable->find()
        ->select(['Peers.id', 'Users.id', 'Users.first_name', 'Users.last_name'])
        ->join([
          'Users' => [
            'table' => 'users',
            'type' => 'inner',
            'conditions' => 'Users.id = Peers.appraiser_id'
          ],
        ])
        ->where(['Peers.assessment_id' => $assessment->id, 'Peers.user_id' => $user->user_id])
        ->toList();
    }
    // debug($users->toList());
    $this->set(compact('assessment', 'users'));

  }

  /**
  * Método utilizado para atribuir, via Ajax, um par avaliado a um par
  * avaliador.
  *
  * Recebe via POST o código da avaliação, o código do par avaliado e
  * o código do par avaliador
  *
  * Este método está sendo usado em:
  * - /assessments/peers/$id
  */
  public function addPeerManual() {
    $this->viewBuilder()->layout('ajax');
    $this->autoRender = false;

    $data = $this->request->getData();

    $assessment = $this->Assessments->get($data['assessment_id']);

    if ($assessment->user_id != $this->Auth->user('id')) {
      $this->Flash->error(__('Você não está autorizado a acessar essa avaliação.'));
      return $this->redirect(['action' => 'index']);
    }

    $peersTable = TableRegistry::get('Peers');

    $user_id = $data['user_id'];
    $appraiser_id = $data['appraiser_id'];

    $contain = $peersTable
      ->find('peers', [
        'user_id' => $user_id,
        'appraiser_id' => $appraiser_id,
        'assessment_id' => $assessment->id
      ])
      ->count() != 0;

    if (!$contain) {
        $peer = $peersTable->newEntity([
          'user_id' => $user_id,
          'appraiser_id' => $appraiser_id,
          'assessment_id' => $assessment->id
        ]);
        $peersTable->save($peer);
    }

  }

  /**
  * Método utilizado para remover, via Ajax, a relação de um par avaliado
  * e um par avaliador.
  *
  * Recebe via POST o código da atribuição
  *
  * Este método está sendo usado em:
  * - /assessments/peers/$id
  */
  public function removeAppraiser() {
    $this->viewBuilder()->layout('ajax');
    $this->autoRender = false;

    $data = $this->request->getData();

    $peersTable = TableRegistry::get('Peers');

    $peer = $peersTable->find()
      ->contain(['Assessments'])
      ->where(['Peers.id' => $data['peer_id'], 'Assessments.user_id' => $this->Auth->user('id')])
      ->first();

    if ($peer) {
      $peersTable->delete($peer);
    }

  }

  /**
  * Método utilizado para remover, via Ajax, todos os pares avaliados e pares
  * avaliadores atribuídos.
  *
  * Recebe via POST o código da avaliação
  *
  * Este método está sendo usado em:
  * - /assessments/peers/$id
  */
  public function removeAllPeers() {
    $this->viewBuilder()->layout('ajax');
    $this->autoRender = false;

    $data = $this->request->getData();

    $assessment = $this->Assessments->get($data['assessment_id']);

    if ($assessment->user_id != $this->Auth->user('id')) {
      $this->Flash->error(__('Você não está autorizado a acessar essa avaliação.'));
      return $this->redirect(['action' => 'index']);
    }

    $peersTable = TableRegistry::get('Peers');

    $peersTable->deleteAll(['Peers.assessment_id' => $assessment->id]);

  }

  /**
  * Método utilizado para atribuir de forma aleatória, via Ajax, pares avaliados
  *   pares avaliadores.
  *
  * Recebe via POST o código da avaliação, se será permitido a auto-avaliação e
  * a quantidade de avaliações que cada par avaliado irá receber;
  *
  * Este método está sendo usado em:
  * - /assessments/peers/$id
  */
  public function peersRandom() {
    $this->viewBuilder()->layout('ajax');
    $this->autoRender = false;

    $data = $this->request->getData();

    $assessment = $this->Assessments
        ->get($data['assessment_id'], ['contain' => ['Teams' => ['TeamUsers']]]);

    if ($assessment->user_id != $this->Auth->user('id')) {
      $this->Flash->error(__('Você não está autorizado a acessar essa avaliação.'));
      return $this->redirect(['action' => 'index']);
    }

    $auto = filter_var($data['auto'], FILTER_VALIDATE_BOOLEAN);
    $number = $data['number'];

    $users = $assessment->team->team_users;

    $idUsers = [];
    foreach ($users as $user) {
      array_push($idUsers, $user->user_id);
    }

    if ($number < 1 || $number > count($idUsers)) {
      $number = 1;
    }

    $data = [];

    $peersTable = TableRegistry::get('Peers');

    foreach ($idUsers as $id) {
      $copy = $idUsers;

      if (!$auto) $copy = array_diff($copy, [$id]);

      $keys = array_rand($copy, $number);


      if (is_int($keys)) {
        $data[] = [
          'assessment_id' => $assessment->id,
          'user_id' => $id,
          'appraiser_id' => $copy[$keys]
        ];
      } else {
        foreach ($keys as $value) {
          $data[] = [
            'assessment_id' => $assessment->id,
            'user_id' => $id,
            'appraiser_id' => $copy[$value]
          ];
        }
      }
    }

    $peersTable->deleteAll(['Peers.assessment_id' => $assessment->id]);

    $entities = $peersTable->newEntities($data);
    $result = $peersTable->saveMany($entities, ['validate' => false]);

  }

  /**
  * Método utilizado para que o par avaliado faça a submissão de sua avaliação.
  *
  * @param int $assessment_id Código da avaliação
  * @param int $submit_id Código da submissão da avaliação
  */
  public function submit($assessment_id, $submit_id = null) {

    // TODO: Verificar se está no prazo para enviar a avaliação

    $auTable = TableRegistry::get('AssessmentUsers');

    $assessment = $this->Assessments->get($assessment_id,
      [
        'contain' => ['Teams' => ['TeamUsers', 'Disciplines'], 'AssessmentRubrics' => ['Rubrics']],
        'where' => ['TeamUsers.user_id' => $this->Auth->user('id')]
      ]
    );

    if (!$assessment) {
      $this->Flash->error(__('Você não está autorizado a acessar essa avaliação.'));
      return $this->redirect(['controller' => 'Home', 'action' => 'index']);
    }

    $existAssessmentUser = $auTable->find()
      ->where([
        'AssessmentUsers.assessment_id' => $assessment->id,
        'AssessmentUsers.user_id' => $this->Auth->user('id')
      ])
      ->first();

    $assessmentUser = false;

    if ($existAssessmentUser) {
      if (!$existAssessmentUser->draft) {
        $this->Flash->error(__('Você já respondeu essa avaliação.'));
        return $this->redirect(['controller' => 'Home', 'action' => 'index']);
      }
      $assessmentUser = $existAssessmentUser;
    }

    if ($this->request->is('post')) {
      $data = $this->request->getData();

      if (!$existAssessmentUser) {
        $assessmentUser = $auTable->newEntity();
      }
      $assessmentUser->document_text = $data['document_text'];
      $assessmentUser->user_id = $this->Auth->user('id');
      $assessmentUser->assessment_id = $assessment->id;

      if ($data['action'] == 'finish')
        $assessmentUser->draft = false;
      else {
        $assessmentUser->draft = true;
      }

      if (key_exists('attachment', $data) && $data['attachment']['tmp_name'] != '')
        $assessmentUser->file = $data['attachment'];

      if ($auTable->save($assessmentUser)) {
        if ($assessmentUser->draft) {
          $this->Flash->success(__('Sua avaliação foi salva como rascunho.'));
          return $this->redirect(['action' => 'submit', $assessment->id]);
        } else {
          $this->Flash->success(__('Sua avaliação foi enviada com sucesso.'));
          return $this->redirect(['controller' => 'Home', 'action' => 'index']);
        }
      } else {
        $this->Flash->error(__('Não foi possível salvar sua avaliação.'));
      }

    }

    $this->set('assessment', $assessment);
    $this->set('assessmentUser', $assessmentUser);

  }

  /**
  * Método utilizado para excluir, via Ajax, um arquivo enviado na avaliação.
  * A exclusão é permitida enquanto a avaliação está em modo rascunho e no
  * período de submissão.
  *
  * Este método está sendo usado em:
  * - /assessments/submit/$id
  */
  public function removeFile() {
    $this->viewBuilder()->layout('ajax');
    $this->request->allowMethod(['post', 'delete']);

    $data = $this->request->getData();

    $auTable = TableRegistry::get('AssessmentUsers');

    $assessmentUser = $auTable->find()
      ->contain(['Assessments'])
      ->where([
        'AssessmentUsers.id' => $data['au_id'],
        'AssessmentUsers.user_id' => $this->Auth->user('id'),
        'AssessmentUsers.draft' => true,
        'Assessments.startAt <=' => Time::now(),
        'Assessments.endAt >=' => Time::now(),
      ])
      ->first();
    $removed = false;
    if ($assessmentUser) {
      $dir = ROOT . DIRECTORY_SEPARATOR . 'files' . DIRECTORY_SEPARATOR;
      if (unlink($dir . $assessmentUser->file)) {
          $assessmentUser->file = '';
          $removed = $auTable->save($assessmentUser);
      }
    }
    $this->set('removed', $removed);
  }

  /**
   * Método utilizado para exibir as submissões que o par avaliador deverá
   * avaliar
   *
   * @param int $id Código da avaliação submetida
   */
  public function appraiser($id) {
    $assessmentUserTable = TableRegistry::get('AssessmentUsers');

    $data = null;
    if ($this->request->is('post')) {
      $data = $this->request->getData();
      $id = $data['assessment_user_id'];
    }

    $assessmentUser =  $assessmentUserTable
      ->find()
      ->join([
        'Peers' => [
          'table' => 'peers',
          'type' => 'inner',
          'conditions' => [
            'Peers.user_id = AssessmentUsers.user_id',
            'Peers.appraiser_id' => $this->Auth->user('id')
          ]
        ],
      ])
      ->contain([
        'Peers', 'Users', 'Assessments' => ['AssessmentRubrics' => 'Rubrics', 'Teams' => 'Disciplines']
      ])
      ->where([
        'AssessmentUsers.id' => $id,
        'AssessmentUsers.draft' => false, //O professor deve habilitar se pode avaliar se estiver no rascunho ainda
        'Assessments.start_assessment <=' => Time::now(),
        'Assessments.end_assessment >=' => Time::now(),
      ])->first();

      if (!$assessmentUser) {
        $this->Flash->error(__('Você não está autorizado a acessar essa avaliação.'));
        return $this->redirect(['controller' => 'Home', 'action' => 'index']);
      }

      if ($this->request->is('post')) {
        $peerTable = TableRegistry::get('Peers');

        $peer = $peerTable
          ->find()
          ->where([
            'Peers.user_id' => $assessmentUser->user_id,
            'Peers.appraiser_id' => $this->Auth->user('id'),
            'Peers.assessment_id' => $assessmentUser->assessment->id
          ])
          ->first();
        $peer->assessment_user_id = $assessmentUser->id;
        $peerTable->save($peer);

        $assessmentPeerTable = TableRegistry::get('AssessmentPeers');
        $values = [
          'comments' => $data['comments'],
          'peer_id' => $peer->id,
          'assessment_peer_rubrics' => []
        ];

        $labels = json_decode($assessmentUser->assessment->labels);

        $rubricTable = TableRegistry::get('AssessmentRubrics');
        foreach ($data['rubric'] as $k => $v) {
          $rubric = $rubricTable->find()->where([
            'AssessmentRubrics.rubric_id' => $data['rubric'][$k],
            'AssessmentRubrics.assessment_id' => $assessmentUser->assessment->id
          ])->first();

          $values['assessment_peer_rubrics'][] = [
            'rubric_id' => $rubric->rubric_id,
            'weight' => $rubric->weight,
            'comments' => $data['rubric_comments'][$k],
            'label' => ($data['score'][$k] > count($labels) - 1 ? $labels[0] : $labels[$data['score'][$k]]),
            'score' => ($data['score'][$k] > count($labels) - 1 ? 0 : ($data['score'][$k] * 1.0) / (count($labels) - 1))
          ];
        }

        $assessmentPeer = $assessmentPeerTable->newEntity($values, ['validate' => false]);

        if ($assessmentPeerTable->save($assessmentPeer)) {
          $this->Flash->success(__('Sua avaliação foi enviada com sucesso.'));
        } else {
          $this->Flash->error(__('Ocorreu um erro ao tentar salvar sua avaliação.'));
        }
        return $this->redirect(['controller' => 'Home', 'action' => 'index']);

      }

      $this->set('assessmentUser', $assessmentUser);


      //debug($assessmentUser);


  }

  /**
   * Método utilizado para encerrar uma avaliação que está aberta e divulgar
   * as notas obtidas por cada par avaliado
   *
   * @param int $id Código da avaliação
   */
  public function finish($id) {
    $assessmentUserTable = TableRegistry::get('AssessmentUsers');

    $assessment = $this->Assessments->get($id, [
      'contain' => [
        'AssessmentRubrics' => ['Rubrics'],
        'Teams' => ['Disciplines', 'TeamUsers' => 'Users'],
      ]
    ]);

    if ($this->request->is(['post'])) {
      $data = $this->request->getData();

      // debug($data);
      if ($data['Assessment']['id'] != $assessment->id) {
        $this->Flash->error(__('Você não está autorizado a acessar essa avaliação.'));
        return $this->redirect(['controller' => 'Home', 'action' => 'index']);
      }

      $insert = [];
      $update = [];

      foreach ($data['score'] as $key => $score) {
        if ($data['AssessmentUsers']['id'][$key] == '') {
          $insert[] = [
            'user_id' => $data['Users']['id'][$key],
            'assessment_id' => $assessment->id,
            'score' => $score,
            'from_teacher' => 1
          ];
        } else {
            $registry = $assessmentUserTable->get($data['AssessmentUsers']['id'][$key]);
            $registry->score = ($score < 0 || $score > $assessment->maximum_score) ? 0 : $score;
            $update[] = $registry;
        }
      }

      if (!empty($insert)) {
        $insertEntities = $assessmentUserTable->newEntities($insert);
        $assessmentUserTable->saveMany($insertEntities);
      }

      if (!empty($update)) {
        $assessmentUserTable->saveMany($update, ['validate' => false]);
      }

      $assessment->status = 'finish';

      if ($this->Assessments->save($assessment)) {
        $this->Flash->success(__('Sua avaliação foi encerrada com sucesso.'));
        return $this->redirect(['controller' => 'Assessments', 'action' => 'controls', $assessment->id]);
      }

    }


    foreach ($assessment->team->team_users as $key => $teamUser) {
      $assessmentUser = $assessmentUserTable
        ->find()
        ->contain([
          'Peers' => ['Users', 'AssessmentPeers' => 'AssessmentPeerRubrics']
        ])
        ->where([
          'AssessmentUsers.user_id' => $teamUser->user_id,
          'AssessmentUsers.assessment_id' => $assessment->id
        ])
        ->first();
      $teamUser['assessment_user'] = $assessmentUser;
      $scoreAssessmentUser = 0.0;
      $appraisers = 0;

      if ($teamUser->assessment_user) {
        foreach($teamUser->assessment_user->peers as $peer) {
          $appraisers += 1;
          foreach ($peer->assessment_peers as $ap) {
            $sum_weight = 0;
            $score_ap = 0.0;
            foreach ($ap->assessment_peer_rubrics as $apr) {
              // TODO: Corrigir para pegar os pesos da tabela assessment_rubrics
              $sum_weight += $apr->weight;
              $score_ap += ($apr->score * $apr->weight) * $assessment->maximum_score;
            }
            $ap->score = $score_ap / $sum_weight;
            $scoreAssessmentUser += $ap->score;
          }
        }
        $teamUser->assessment_user->score = ($appraisers == 0 ? 0 : $scoreAssessmentUser / $appraisers);

      }

    }

    $this->set(compact('assessment'));
  }

  /**
  * Método utilizado para visualizar, via Ajax, a submissão do par avaliado.
  *
  * Este método está sendo usado em:
  * - /assessments/finish/$id
  */
  public function viewSubmit() {
    $this->viewBuilder()->layout('ajax');
    $this->request->allowMethod(['post']);

    $data = $this->request->getData();

    $assessmentUser = TableRegistry::get('AssessmentUsers')->get($data['id']);

    $this->set(compact('assessmentUser'));
  }

  /**
  * Método utilizado para visualizar, via Ajax, a avaliação do par avaliador.
  *
  * Este método está sendo usado em:
  * - /assessments/finish/$id
  */
  public function viewAppraiser() {
    $this->viewBuilder()->layout('ajax');
    $this->request->allowMethod(['post']);

    $data = $this->request->getData();

    $assessmentPeer = TableRegistry::get('AssessmentPeers')
      ->get($data['id'], [
        'contain' => ['AssessmentPeerRubrics' => 'Rubrics', 'Peers' => 'Assessments']
      ]);

    $this->set(compact('assessmentPeer'));
  }

  /**
   * Método utilizado para visualizar as notas obtidas na avaliação
   *
   * @param int $id Código da avaliação
   */
  public function scores($id) {
    $assessment = $this->Assessments->get($id, [
      'contain' => [
        'AssessmentRubrics' => ['Rubrics'],
        'AssessmentUsers' => ['Users' => ['sort' => ['Users.first_name' => 'ASC', 'Users.last_name' => 'ASC']]],
        'Teams' => ['Disciplines']
      ]
    ]);

    $this->set(compact('assessment'));
  }

  /**
   * Esta função é chamada antes que cada requisição.
   * Altera o layout padrão para o LOGGED
   */
  public function beforeFilter(Event $event)
  {
    parent::beforeFilter($event);
    $action = $this->request->getParam('action');
    if (in_array($action, ['controls', 'peers', 'finish', 'scores'])) {
        $this->viewBuilder()->setLayout('controlAssessments');
    } else {
      $this->viewBuilder()->setLayout('logged');
    }

    $dateFormat = 'dd/MM/yyyy HH:mm';
    if (strtolower($this->Auth->user('locale')) == 'en'){
      $dateFormat = 'MM/dd/yyyy hh:mm a';
    }
    $this->set('dateFormat', $dateFormat);
  }

  /**
   * Função utilizada para autorizar usuários logados a acessarem
   * determinadas funções da classe controladora.
   *
   * @param $user Array dados do usuário logado
   * @return boolean
   */
  public function isAuthorized($user) {

    $action = $this->request->getParam('action');
    if (in_array($action, [
      'index', 'add', 'addRubric', 'removeRubric', 'changeScales', 'getFile',
      'listPeers', 'addPeerManual', 'removeAppraiser', 'removeAllPeers',
      'peersRandom', 'submit', 'removeFile', 'appraiser', 'viewSubmit',
      'viewAppraiser'
    ])) {
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
