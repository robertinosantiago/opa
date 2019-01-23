<?php

namespace App\Controller;
use Cake\ORM\TableRegistry;

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
     * disciplinas
     */
    public function index()
    {
      $this->viewBuilder()->setLayout('logged');

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
