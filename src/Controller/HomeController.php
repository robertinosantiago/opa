<?php

namespace App\Controller;
use Cake\ORM\TableRegistry;
use Cake\I18n\Time;

/**
 * Classe utilizada para controlar a página inicial do site, quando o usuário
 * está logado.
 *
 * @author Robertino Mendes Santiago Junior
 */
class HomeController extends AppController
{

    /**
     * Página inicial do site
     *
     * Verifica que há algum convite enviado para o usuário participar de
     * disciplinas.
     *
     * Exibe as avaliações que estão disponíveis para submissão
     *
     * Exibe as submissões que o usuário pode avaliar
     */
    public function index()
    {
      $this->viewBuilder()->setLayout('logged');

      // TODO: Está aparecendo o convite duas vezes na tela inicial
      $invites = TableRegistry::get('Invites')
          ->find()
          ->select(['Invites.id', 'Invites.hash', 'Invites.team_id', 'Teams.name', 'Disciplines.name', 'TeamUsers.id'])
          ->join([
            'Users' => [
              'table' => 'users',
              'type' => 'inner',
              'conditions' => 'Users.email = Invites.email'
            ],
            'TeamUsers' => [
              'table' => 'team_users',
              'type' => 'left',
              'conditions' => ['Users.id = TeamUsers.user_id', 'TeamUsers.team_id = Invites.team_id']
            ],
            'Teams' => [
              'table' => 'teams',
              'type' => 'left',
              'conditions' => 'Teams.id = Invites.team_id'
            ],
            'Disciplines' => [
              'table' => 'disciplines',
              'type' => 'left',
              'conditions' => 'Disciplines.id = Teams.discipline_id'
            ]
          ])
          ->where([
            'Invites.email' => $this->Auth->user('email'),
            'Invites.confirm' => false,
            'TeamUsers.id is' => null
          ]);

      if ($invites->isEmpty()) $invites = false;
      $this->set('invites', $invites);

      $assessments = TableRegistry::get('Assessments')
        ->find()
        ->select([
          'Assessments.id', 'Assessments.title', 'Assessments.description',
          'Assessments.startAt', 'Assessments.endAt', 'Teams.name', 'Disciplines.name',
          'AssessmentUsers.id'
        ])
        ->join([
          'Teams' => [
            'table' => 'teams',
            'type' => 'inner',
            'conditions' => 'Teams.id = Assessments.team_id'
          ],
          'Disciplines' => [
            'table' => 'disciplines',
            'type' => 'inner',
            'conditions' => 'Disciplines.id = Teams.discipline_id'
          ],
          'TeamUsers' => [
            'table' => 'team_users',
            'type' => 'inner',
            'conditions' => 'Teams.id = TeamUsers.team_id'
          ],
          'AssessmentUsers' => [
            'table' => 'assessment_users',
            'type' => 'left',
            'conditions' => [
              'Assessments.id = AssessmentUsers.assessment_id',
              'AssessmentUsers.user_id' => $this->Auth->user('id')
            ]
          ]
        ])
        ->where([
          'Assessments.status' => 'open',
          'Assessments.startAt <=' => Time::now(),
          'Assessments.endAt >=' => Time::now(),
          'TeamUsers.user_id' => $this->Auth->user('id'),
          'OR' => [
            'AssessmentUsers.id IS' => null,
            'AssessmentUsers.draft' => true
            ]
        ]);

        if ($assessments->isEmpty()) $assessments = false;
        $this->set('assessments', $assessments);

        $appraisers = TableRegistry::get('Assessments')
          ->find()
          ->select(['Assessments.id', 'Assessments.title',
            'Assessments.start_assessment', 'Assessments.end_assessment',
            'Teams.name', 'Disciplines.name', 'AssessmentUsers.id'
          ])
          ->join([
            'Teams' => [
              'table' => 'teams',
              'type' => 'inner',
              'conditions' => 'Teams.id = Assessments.team_id'
            ],
            'Disciplines' => [
              'table' => 'disciplines',
              'type' => 'inner',
              'conditions' => 'Disciplines.id = Teams.discipline_id'
            ],
            'Peers' => [
              'table' => 'peers',
              'type' => 'inner',
              'conditions' => [
                'Assessments.id = Peers.assessment_id',
                'Peers.appraiser_id' => $this->Auth->user('id')
              ]
            ],
            'AssessmentUsers' => [
              'table' => 'assessment_users',
              'type' => 'inner',
              'conditions' => ['Peers.user_id = AssessmentUsers.user_id']
            ],
            'AssessmentPeers' => [
              'table' => 'assessment_peers',
              'type' => 'left',
              'conditions' => ['Peers.id = AssessmentPeers.peer_id']
            ]
          ])
          ->where([
            'AssessmentUsers.draft' => false, //O professor deve habilitar se pode avaliar se estiver no rascunho ainda
            'Assessments.start_assessment <=' => Time::now(),
            'Assessments.end_assessment >=' => Time::now(),
            'AssessmentPeers.id IS' => null
          ])
          ->order(['Assessments.end_assessment' => 'ASC']);

        if ($appraisers->isEmpty()) $appraisers = false;
        $this->set('appraisers', $appraisers);

        $dateFormat = 'dd/MM/yyyy HH:mm';
        if (strtolower($this->Auth->user('locale')) == 'en') {
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
    public function isAuthorized($user)
    {
        $action = $this->request->getParam('action');
        if (in_array($action, ['index'])) {
            return true;
        }
        return false;
    }

}
