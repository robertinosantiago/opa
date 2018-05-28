<?php

namespace App\Controller;

use Cake\Event\Event;
use Cake\ORM\TableRegistry;

/**
* Classe utilizada para controlar as páginas do site, as quais não precisam de
* autenticação do usuário para funcionar.
* @author Robertino Mendes Santiago Junior
*/
class HomeController extends AppController
{

  /**
  * Página inicial do site
  *
  */
  public function index()
  {
    if ($this->Auth->user()) {
      $this->viewBuilder()->setLayout('logged');
    }
  }



  public function beforeFilter(Event $event)
  {
    parent::beforeFilter($event);
    $this->Auth->allow();
  }

}
