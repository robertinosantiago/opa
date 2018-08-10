<?php

namespace App\Controller;

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

    /**
     * @param $user
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
