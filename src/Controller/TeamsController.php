<?php

namespace App\Controller;

use Cake\ORM\TableRegistry;
use Cake\Controller\Exception\AuthSecurityException;
use Cake\Log\Log;
use Cake\Mailer\Email;
use Cake\I18n\Time;
use Cake\Event\Event;

/**
 * Classe utilizada para controlar as ações referentes às Turmas das
 * disciplinas
 *
 * @author Robertino Mendes Santiago Jr
 */
class TeamsController extends AppController {

  // public function initialize() {
  //   parent::initialize();
  // }

  /**
   * Listagem das turmas que pertencem ao usuário
   *
   * TODO: Adicionar a listagem das disciplinas que usuário participa
   */
  public function index($discipline_id = null)
  {
    $this->viewBuilder()->setLayout('controls');
    $discipline = TableRegistry::get('Disciplines')->get($discipline_id);

    $teams = $this->Teams->find('all')
    ->contain(['Disciplines', 'TeamUsers' => ['Users']])
    ->where(['discipline_id' => $discipline->id]);

    $this->set('teams', $teams);
    $this->set('discipline', $discipline);
  }

  public function selectTeam() {
    $query = $this->request->getData();

    $team_id = $query['team_id'];

    $team = $this->Teams->find('all')
      ->select(['Teams.id', 'Teams.name', 'Disciplines.name'])
      ->contain(['Disciplines'])
      ->where(['Disciplines.user_id' => $this->Auth->user('id'), 'Teams.id' => $team_id])
      ->first();

    $data = [
        'id' => $team->id,
        'name' => $team->name . ' - ' . $team->discipline->name
    ];

    $this->set(['data' => $data, '_serialize' => 'data']);
  }

  public function teamsTable() {

    $this->request->allowMethod(['post', 'ajax']);

    $query = $this->request->query();
    $search = (array_key_exists('search', $query)) ? $query['search'] : '';
    $start = (array_key_exists('start', $query)) ? $query['start'] : 1;
    $length = (array_key_exists('length', $query)) ? $query['length'] : 2;

    $teams = $this->Teams->find('table', [
      'user_id' => $this->Auth->user('id'),
      'search' => $search,
      'start' => $start,
      'length' => $length
    ]);

    $pages = ceil($teams->count() / $length);

    $this->set(compact('pages', 'teams', 'start', 'search'));

  }

  public function ajaxSave() {
    $this->request->allowMethod(['post', 'ajax']);

    $data = $this->request->getData();

    $team = $this->Teams->newEntity();
    $team->name = $data['name'];
    $team->description = $data['description'];
    $team->discipline_id = $data['discipline_id'];

    if ($this->Teams->save($team)) {
      $this->set(['message' => 'Salvo', '_serialize' => 'message']);
    } else {
      throw new \Exception("Error Processing Request", 1);

    }

  }

  public function listUsers() {
    $this->request->allowMethod(['get', 'ajax']);
    $this->viewBuilder()->layout('ajax');
    $data = $this->request->query();

    $teamUsersTable = TableRegistry::get('TeamUsers');

    $users = $teamUsersTable->find()
      ->select(['Users.id', 'Users.first_name', 'Users.last_name'])
      ->contain(['Users'])
      ->where(['TeamUsers.team_id' => $data['team_id']]);

    $this->set(compact('users'));
  }

  public function ajaxScales() {
    $this->viewBuilder()->layout('ajax');
    $this->request->allowMethod(['post', 'ajax']);


    $data = $this->request->getData();

    $scale = $data['scale'];

    if ($scale >= 2 && $scale <= 10) {
      $this->set('scale', $scale);
    } else {
      throw new \Exception("Error Processing Request", 1);
    }
  }

  public function addUser() {
    $this->request->allowMethod(['post', 'ajax']);

    $data = $this->request->getData();

    if (empty($data['user_id']) && empty($data['team_id'])) {
      throw new \Exception("Error Processing Request", 1);
    }

    $team = $this->Teams->find()
      ->contain(['Disciplines'])
      ->where([
        'Teams.id' => $data['team_id'],
        'Disciplines.user_id' => $this->Auth->user('id')
      ]);

    if ($team->isEmpty()) {
      throw new \Exception(__('Você não está autorizado a acessar essa avaliação.'), 1);
    }

    $teamUsersTable = TableRegistry::get('TeamUsers');

    $teamUser = $teamUsersTable->find()
      ->where([
        'TeamUsers.user_id' => $data['user_id'],
        'TeamUsers.team_id' => $data['team_id']
      ]);

    if ($teamUser->isEmpty()) {
      $teamUser = $teamUsersTable->newEntity([
        'user_id' => $data['user_id'],
        'team_id' => $data['team_id']
      ]);
      $teamUsersTable->save($teamUser);
    }

    $this->set(['message' => 'ok', '_serialize' => 'message']);

  }

  /**
   * Método utilizado para enviar convites para usuários participarem
   * disciplinas
   *
   * @param $discipline_id int Código da disciplina
   * @param $team_id int Código da turma
   *
   * TODO: enviar emails utilizando Cronjob
   * TODO: alterar o template do email
   */
  public function invite($discipline_id, $team_id) {
    $this->viewBuilder()->setLayout('controls');

    if ($this->request->is('post')) {

      $data = $this->request->getData();
      $emails = preg_split("/[,;]/",$data['email']);
      $mailValid = array();

      for ($i=0; $i < sizeof($emails); $i++) {
        $mail = $this->_validEmail($emails[$i]);
        if ($mail) {
          array_push($mailValid, $mail);
        }
      }

      if (!empty($mailValid)) {
        $inviteTable = TableRegistry::get('Invites');
        $team = $this->Teams->get($team_id, ['contain' => ['Disciplines']]);
        $email = new Email();
        foreach ($mailValid as $mail) {
          $invite = $inviteTable->newEntity();
          $invite->email = $mail;
          $invite->hash = $this->_randomString(20);
          $invite->team_id = $team_id;
          if ($inviteTable->save($invite)) {
            $email
              ->to($invite->email)
              ->subject(__('Convite para ingressar no OPA'))
              ->emailFormat('html')
              ->template('invite')
              ->viewVars(['email' => $invite->email, 'hash' => $invite->hash, 'team' => $team])
              ->helpers(['Html', 'Url'])
              ->send();
          }
        }
      }

      $this->Flash->success(__('Email(s) enviados com sucesso'));
      return $this->redirect(['action' => 'invites', $discipline_id, $team_id]);

    }

    $discipline = TableRegistry::get('Disciplines')->get($discipline_id);
    $team = $this->Teams->get($team_id);

    $this->set('team', $team);
    $this->set('discipline', $discipline);
  }

  /**
   * Método utilizado para listar os convites enviados aos usuários, indicando
   * o link de confirmação de aceite do convite
   *
   * @param $discipline_id int Código da disciplina
   * @param $team_id int Código da turma
   */
  public function invites($discipline_id, $team_id) {
    $this->viewBuilder()->setLayout('controls');

    $discipline = TableRegistry::get('Disciplines')->get($discipline_id);
    $team = $this->Teams->get($team_id);

    $this->set('team', $team);
    $this->set('discipline', $discipline);

    $invites = TableRegistry::get('Invites')->find();
    $invites->select(['Invites.email', 'confirm' => 'MAX(Invites.confirm)', 'count_invites' => $invites->func()->count('Invites.email')])
       ->where(['Invites.team_id' => $team_id])
       ->group(['Invites.email', 'Invites.team_id']);

    $this->set('invites', $invites);
  }

  /**
   * Método utilizado para confirmar um convite recebido. Realiza a verificação
   * se o convite pertence ao usuário logado
   *
   * @param $hash string Código do convite recebido pelo usuário
   */
  public function confirmInvite($hash) {
    if ($hash) {
      $inviteTable = TableRegistry::get('Invites');
      $invite = $inviteTable->findByHash($hash);

      if (!$invite->isEmpty() && $invite->first()->email == $this->Auth->user('email')) {
        $teamUserTable = TableRegistry::get('TeamUsers');

        $query = $teamUserTable->find()
          ->where([
            'TeamUsers.user_id' => $this->Auth->user('id'),
            'TeamUsers.team_id' => $invite->first()->team_id
          ]);
        if ($query->isEmpty()) {
          $teamUser = $teamUserTable->newEntity([
            'user_id' => $this->Auth->user('id'),
            'team_id' => $invite->first()->team_id
          ]);
          if ($teamUserTable->save($teamUser)) {
            $invite = $invite->first();
            $invite->confirm = true;
            $inviteTable->save($invite);

            $this->Flash->success(__('Seja bem vindo(a)!'));
            return $this->redirect(['controller' => 'Home', 'action' => 'index']);
          } else {
            $this->Flash->error(__('Erro'));
            // return $this->redirect(['controller' => 'Users', 'action' => 'login']);
          }
        } else {
          $this->Flash->error(__('Este convite não é valido'));
          // return $this->redirect(['controller' => 'Users', 'action' => 'login']);
        }
      } else {
        $this->Flash->error(__('Este convite não esta associado ao seu email'));
        return $this->redirect(['controller' => 'Home', 'action' => 'index']);
      }
    }
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
    if (in_array($action, ['selectTeam', 'teamsTable', 'ajaxSave', 'ajaxScales', 'confirmInvite', 'addUser', 'listUsers'])) {
      return true;
    }

    $discipline_id = $this->request->getParam('pass.0');

    if (!$discipline_id) {
        return false;
    }

    $discipline = TableRegistry::get('Disciplines')->get($discipline_id);
    if ($discipline->user_id === $user['id']) {
      $this->Auth->config('authError', __('Você não tem permissão para acessar este conteúdo'));
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

    $action = $this->request->getParam('action');
    if ($action == 'confirmInvite' && !$this->Auth->user()) {
      $this->Auth->config('authError', __('Você precisa ter uma conta para continuar'));
    }

    parent::beforeFilter($event);

  }

  /**
   * Função utilizada para verficar se um email é válido
   *
   * @param $email string Email
   * @return string|boolean Se for válido, retorna o email. Caso contrário, retorna falso.
   */
  private function _validEmail($email) {
    if(is_array($email) || is_numeric($email) || is_bool($email) || is_float($email) || is_file($email) || is_dir($email) || is_int($email)) return false;

    $email=trim(strtolower($email));

    if(filter_var($email, FILTER_VALIDATE_EMAIL)!==false) return $email;

    $pattern = '/^(?!(?:(?:\\x22?\\x5C[\\x00-\\x7E]\\x22?)|(?:\\x22?[^\\x5C\\x22]\\x22?)){255,})(?!(?:(?:\\x22?\\x5C[\\x00-\\x7E]\\x22?)|(?:\\x22?[^\\x5C\\x22]\\x22?)){65,}@)(?:(?:[\\x21\\x23-\\x27\\x2A\\x2B\\x2D\\x2F-\\x39\\x3D\\x3F\\x5E-\\x7E]+)|(?:\\x22(?:[\\x01-\\x08\\x0B\\x0C\\x0E-\\x1F\\x21\\x23-\\x5B\\x5D-\\x7F]|(?:\\x5C[\\x00-\\x7F]))*\\x22))(?:\\.(?:(?:[\\x21\\x23-\\x27\\x2A\\x2B\\x2D\\x2F-\\x39\\x3D\\x3F\\x5E-\\x7E]+)|(?:\\x22(?:[\\x01-\\x08\\x0B\\x0C\\x0E-\\x1F\\x21\\x23-\\x5B\\x5D-\\x7F]|(?:\\x5C[\\x00-\\x7F]))*\\x22)))*@(?:(?:(?!.*[^.]{64,})(?:(?:(?:xn--)?[a-z0-9]+(?:-+[a-z0-9]+)*\\.){1,126}){1,}(?:(?:[a-z][a-z0-9]*)|(?:(?:xn--)[a-z0-9]+))(?:-+[a-z0-9]+)*)|(?:\\[(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){7})|(?:(?!(?:.*[a-f0-9][:\\]]){7,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?)))|(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){5}:)|(?:(?!(?:.*[a-f0-9]:){5,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3}:)?)))?(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))(?:\\.(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))){3}))\\]))$/iD';

    return (preg_match($pattern, $email) === 1) ? $email : false;

  }

  /**
   * Função utilizada para gerar uma string aleatória com letras, maiúsculas e
   * minúsculas, e números. O início da string aleatória é a string gerada
   * pelo representação do horário gerado pelo linux
   *
   * @param $lenght int Tamanho da string que será gerada, desconsiderando o início da string
   * @return string
   */
  private function _randomString($lenght = 10) {
    $mi = (int)($lenght  / 3);
    $ma = (int)($lenght  / 3);
    $nu = $lenght - ($mi + $ma);
    $character_set_array = array();
    $character_set_array[] = array('count' => $mi, 'characters' => 'abcdefghijklmnopqrstuvwxyz');
    $character_set_array[] = array('count' => $ma, 'characters' => 'ABCDEFGHIJKLMNOPQRSTUVWXYZ');
    $character_set_array[] = array('count' => $nu, 'characters' => '0123456789');
    $temp_array = array();
    foreach ($character_set_array as $character_set) {
        for ($i = 0; $i < $character_set['count']; $i++) {
            $temp_array[] = $character_set['characters'][rand(0, strlen($character_set['characters']) - 1)];
        }
    }
    shuffle($temp_array);
    $time = new Time();
    return $time->toUnixString() . implode('', $temp_array);
  }

}
