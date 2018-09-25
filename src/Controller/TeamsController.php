<?php

namespace App\Controller;

use Cake\ORM\TableRegistry;
use Cake\Controller\Exception\AuthSecurityException;

class TeamsController extends AppController
{

    public function initialize()
    {
        parent::initialize();
    }

    public function index($discipline_id = null)
    {
        $this->viewBuilder()->setLayout('controls');
        $discipline = TableRegistry::get('Disciplines')->get($discipline_id);

        if ($discipline->user_id != $this->Auth->user('id')) {
            throw new AuthSecurityException(__('Você não tem permissão para acessar este registro.'));
        }

        $teams = $this->Teams->find('all')
            ->contain(['Disciplines', 'TeamUsers' => ['Users']])
            ->where(['discipline_id' => $discipline->id]);


        $this->set('teams', $teams);
        $this->set('discipline', $discipline);
    }

    public function isAuthorized($user)
  {
      $action = $this->request->getParam('action');
      // The add and tags actions are always allowed to logged in users.
      if (in_array($action, ['index'])) {
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
