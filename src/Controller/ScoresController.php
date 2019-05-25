<?php

namespace App\Controller;

use Cake\Event\Event;
use Cake\ORM\TableRegistry;
use Cake\ORM\Query;

/**
 * Scores controller
 * @author Robertino Mendes Santiago Junior
 */
class ScoresController extends AppController {

    public function initialize() {
        parent::initialize();
    }

   /**
    * Função que exibe as notas dos alunos que perticiparam de avaliações
    */
    public function index() {
      $assessments = TableRegistry::get('AssessmentUsers')
        ->find()
        ->select(['Assessments.id', 'Assessments.title', 'AssessmentUsers.score'])
        ->join([
          'Assessments' => [
            'table' => 'assessments',
            'type' => 'inner',
            'conditions' => 'Assessments.id = AssessmentUsers.assessment_id'
          ]
        ])
        ->where([
          'Assessments.status LIKE' => 'finish',
          'AssessmentUsers.user_id' => $this->Auth->user('id'),
          'AssessmentUsers.score IS NOT' => null
        ]);

      $this->set('assessments', $assessments);

    }

    /**
    * Função utilizada para visualizar as notas dadas em um avaliação
    *
    * @param $id int Código da avaliação
    */
    public function view($id) {
      $assessment = TableRegistry::get('AssessmentUsers')
      ->find()
      ->join([
        'Assessments' => [
          'table' => 'assessments',
          'type' => 'inner',
          'conditions' => 'Assessments.id = AssessmentUsers.assessment_id'
        ],
        'Teams' => [
          'table' => 'teams',
          'type' => 'inner',
          'conditions' => 'Teams.id = Assessments.team_id'
        ],
        'TeamUsers' => [
          'table' => 'team_users',
          'type' => 'inner',
          'conditions' => 'Teams.id = TeamUsers.team_id'
        ]
      ])
      ->contain([
        'Assessments' => ['Teams' => ['Disciplines']]
      ])
      ->where([
        'Assessments.status LIKE' => 'finish',
        'AssessmentUsers.user_id' => $this->Auth->user('id'),
        'AssessmentUsers.assessment_id' => $id,
        'AssessmentUsers.score IS NOT' => null,
        'TeamUsers.user_id' => $this->Auth->user('id')
      ])
      ->first();

      $peers = TableRegistry::get('Peers')
      ->find()
      ->join([
        'Assessments' => [
          'table' => 'assessments',
          'type' => 'inner',
          'conditions' => [
            'Assessments.id = Peers.assessment_id',
            'Assessments.status LIKE' => 'finish'
          ]
        ]
      ])
      ->contain([
        'Users', 'AssessmentPeers' => ['AssessmentPeerRubrics' => 'Rubrics']
      ])
      ->where([
        // 'Assessments.status LIKE' => 'finish',
        'Peers.user_id' => $this->Auth->user('id'),
        'Peers.assessment_id' => $id,
      ]);

      $this->set('assessment', $assessment);
      $this->set('peers', $peers);

      if (empty($assessment)) {
        $this->Flash->error(__('Você não está autorizado a acessar essa avaliação.'));
        return $this->redirect(['controller' => 'Scores', 'action' => 'index']);
      }

      // debug($assessment);
      // debug($peers->toList());
    }

    /**
     * Função utilizada para autorizar usuários logados a acessarem
     * determinadas funções da classe controladora.
     *
     * @param $user Array dados do usuário logado
     * @return boolean
     */
    public function isAuthorized($user)
    {
      $action = $this->request->getParam('action');
      if (in_array($action, ['index', 'view'])) {
        return true;
      }

      return false;
    }

    /**
     * Esta função é chamada antes que cada requisição.
     * Vefifica se o usuário está tentando acessar um convite e muda a mensagem
     * da autenticação.
     */
    public function beforeFilter(Event $event) {
      parent::beforeFilter($event);
      $this->viewBuilder()->setLayout('logged');

      $dateFormat = 'dd/MM/yyyy HH:mm';
      if (strtolower($this->Auth->user('locale')) == 'en'){
        $dateFormat = 'MM/dd/yyyy hh:mm a';
      }
      $this->set('dateFormat', $dateFormat);
    }

}
