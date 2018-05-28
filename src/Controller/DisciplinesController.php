<?php

/**
 * @author Robertino Mendes Santiago Junior
 */

namespace App\Controller;

use Cake\Controller\Exception\AuthSecurityException;
use Cake\Event\Event;
use Cake\ORM\TableRegistry;

/**
 * Disciplines Controller
 */
class DisciplinesController extends AppController
{

 /**
  * Configure pagination
  */
 public $paginate = [
  'limit' => 25,
  'order' => [
   'Discipline.created' => 'desc',
   'discipline.name' => 'asc',
  ],
 ];

 /**
  * Load components on initialization
  */
 public function initialize()
 {
  parent::initialize();

 }

 /**
  * List disciplines
  */
 public function index()
 {
  $data = $this->Disciplines->find('all')->where(['user_id' => $this->Auth->user('id'), 'deleted' => false]);
  $disciplines = $this->Paginator->paginate($data);
  $this->set('disciplines', $disciplines);
 }

 /**
  * Add new discipline
  */
 public function add()
 {
  $discipline = $this->Disciplines->newEntity();
  if ($this->request->is('post')) {
   $discipline = $this->Disciplines->patchEntity($discipline, $this->request->getData());

   $discipline->user_id = $this->Auth->user('id');

   $team = $this->Disciplines->Teams->newEntity();
   $team->name = "Default team";
   $team->description = "Default team";

   $discipline->teams = [$team];

   if ($this->Disciplines->save($discipline)) {
    $this->Flash->success(__('Saved successfully'));
    return $this->redirect(['action' => 'index']);
   }
   $this->Flash->error(__('An error has occurred'));
  }
  $this->set('discipline', $discipline);
 }

 /**
  * Edit a discipline
  * @param uuid $id id of discipline
  */
 public function edit($id)
 {
  $session = $this->getRequest()->getSession();
  if ($this->request->is('get')) {
   $session->write('App.referer', $this->request->referer());
  }

  $discipline = $this->Disciplines->findById($id)->where(['user_id' => $this->Auth->user('id')])->firstOrFail();

  if ($this->request->is(['post', 'put'])) {
   $this->Disciplines->patchEntity($discipline, $this->request->getData());

   if ($discipline->user_id != $this->Auth->user('id')) {
    throw new AuthSecurityException(__('You don\'t have permission to change this record'));
   }

   if ($this->Disciplines->save($discipline)) {
    $this->Flash->success(__('Saved successfully'));
    return $this->redirect($session->read('App.referer'));
   }
   $this->Flash->error(__('An error has occurred'));
  }
  $this->set('discipline', $discipline);
 }

 /**
  * Delete a discipline
  */
 public function delete($id)
 {
  $discipline = $this->Disciplines->findById($id)->where(['user_id' => $this->Auth->user('id')])->firstOrFail();
  if ($this->request->is('delete')) {
   if ($discipline->user_id != $this->Auth->user('id')) {
    throw new AuthSecurityException(__('You do not have permission to change this record'));
   }

   $discipline->deleted = true;

   if ($this->Disciplines->save($discipline)) {
    $this->Flash->success(__('Deleted successfully'));
    return $this->redirect(['action' => 'index']);
   }
  }
  $this->Flash->error(__('An error has occurred'));
  return $this->redirect(['action' => 'controls', $id]);
 }

 /**
  * Central control of disciplines
  * @param uuid $id id of discipline
  */
 public function controls($id)
 {
  $this->viewBuilder()->setLayout('controls');
  $discipline = $this->Disciplines
                        ->findById($id)
                        ->contain(['Teams' => ['Students' => ['Users']]])
                        ->firstOrFail();

  if ($discipline->user_id != $this->Auth->user('id')) {
   throw new AuthSecurityException(__('You don\'t have permission to change this record'));
  }

  $users_count = TableRegistry::get('Students')
                                    ->find()
                                    ->contain(['Teams' =>['Disciplines']])
                                    ->where(['Teams.discipline_id' => $discipline->id])
                                    ->count();
  $this->set('discipline', $discipline);
  $this->set('users_count', $users_count);

 }

 /**
  * Load the default layout when users are logged
  */
 public function beforeFilter(Event $event)
 {
  parent::beforeFilter($event);
  $this->viewBuilder()->setLayout('logged');
 }

 public function isAuthorized($user)
 {
  $action = $this->request->getParam('action');
  // The add and tags actions are always allowed to logged in users.
  if (in_array($action, ['index', 'add', 'edit', 'delete', 'controls'])) {
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
