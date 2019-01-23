<?php

namespace App\View\Helper;

use Cake\View\Helper;
use Cake\Controller\Component\AuthComponent;

class UserInfoHelper extends Helper {
    public $helpers = ['Html', 'Url'];

    public function avatar()
    {
        $session = $this->request->getSession();
        $user = $session->read('Auth.User');
        $image = $this->Url->image('user-icon.png', ['fullBase' => true]);
        if ($user && !empty($user['avatar'])) {
            $image = $user['avatar'];
        }
        return '<img src="'.$image.'" alt="'.__('User avatar').'" class="user-avatar">';
    }

    public function fullName() {
        $session = $this->request->getSession();
        $user = $session->read('Auth.User');
        return $user['first_name'] . ' ' . $user['last_name'];
    }

}
