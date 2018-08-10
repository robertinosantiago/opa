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
            $this->Flash->error(__('Invalid credentials.'));
        }
        $this->set(compact('user'));


        // if ($this->request->is('post')) {
        //     $user = $this->Auth->identify();
        //     debug($user);
        //     if ($user) {
        //         $this->Auth->setUser($user);

        //         return $this->redirect($this->Auth->redirectUrl());
        //     }
        //     $this->Flash->error('Your username or password is incorrect.');
        // }
    }

    public function register()
    {
        $user = $this->Users->newEntity();
        if ($this->request->is('post')) {
            $this->Users->patchEntity($user, $this->request->getData());
            if ($this->Users->save($user)) {
                $this->Flash->success('Cadastrado');
                return $this->redirect(['action' => 'login']);
            }
        }

        $this->set('user', $user);
    }

    public function logout()
    {
        $this->Flash->success('You are now logged out.');
        $this->request->getSession()->delete('Auth.User');
        return $this->redirect($this->Auth->logout());
    }

    public function isAuthorized($user)
    {
        $action = $this->request->getParam('action');
        // The add and tags actions are always allowed to logged in users.
        if (in_array($action, ['index', 'tags'])) {
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
