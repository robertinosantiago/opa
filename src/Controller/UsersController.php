<?php

namespace App\Controller;
/**
 * Users controller
 * @author Robertino Mendes Santiago Junior
 */
class UsersController extends AppController
{

    public function initialize()
    {
        parent::initialize();
        $this->Auth->allow(['logout', 'register']);
    }

    public function index()
    {
        $users = $this->Users->find()->contain(['SocialProfiles']);
        //debug($users);
    }

    public function login()
    {
        $user = $this->Users->newEntity();
        if ($this->request->is('post')) {
            $user = $this->Users->patchEntity($user, $this->request->data);

            $auth = $this->Auth->identify();
            if ($auth) {
                $this->Auth->setUser($auth);
                return $this->redirect($this->Auth->redirectUrl());
            }
            $this->Flash->error(__('Credenciais inválidas.'));
        }
        $this->set(compact('user'));
    }

    public function register()
    {
        $user = $this->Users->newEntity();
        if ($this->request->is('post')) {
            $this->Users->patchEntity($user, $this->request->getData());
            if ($this->Users->save($user)) {
                $this->Flash->success('Cadastrado com sucesso');
                return $this->redirect(['action' => 'login']);
            }
        }

        $this->set('user', $user);
    }

    public function logout()
    {
        $this->Flash->success('Obrigado por acessar o OPA.');
        $this->request->getSession()->delete('Auth.User');
        return $this->redirect($this->Auth->logout());
    }

    /**
    * Método utilizado para exibir, via Ajax, a listagem de usuários
    * a serem inseridos em uma determinada turma.
    *
    * Utilizado em:
    * - /disciplines/controls/$id
    */
    public function usersTable() {

      $this->request->allowMethod(['get', 'ajax']);

      $query = $this->request->query();
      $team = (array_key_exists('team', $query)) ? $query['team'] : '';
      $search = (array_key_exists('search', $query)) ? $query['search'] : '';
      $start = (array_key_exists('start', $query)) ? $query['start'] : 1;
      $length = (array_key_exists('length', $query)) ? $query['length'] : 10;

      $users = $this->Users->find('table', [
        'team' => $team,
        'search' => $search,
        'start' => $start,
        'length' => $length
      ]);

      $pages = ceil($users->count() / $length);

      $this->set(compact('pages', 'users', 'start', 'search'));

    }

    public function isAuthorized($user)
    {
        $action = $this->request->getParam('action');
        // The add and tags actions are always allowed to logged in users.
        if (in_array($action, ['index', 'tags', 'usersTable'])) {
            return true;
        }

        // All other actions require a slug.
        $slug = $this->request->getParam('pass.0');
        if (!$slug) {
            return false;
        }

        // Check that the article belongs to the current user.
        $article = $this->Articles->findBySlug($slug)->first();

        return $article->user_id === $user['id'];
    }

}
