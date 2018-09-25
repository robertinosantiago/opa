<?php
$session = $this->request->getSession();
$userInfo = $session->read('userInfo');
?>
<nav class="navbar navbar-expand">
      <a class="sidebar-toggle mr-2">
        <i class="fas fa-bars"></i>
      </a>

      <a class="navbar-brand" href="#">
        <?=__('OPA'); ?>
      </a>

      <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
        <ul class="navbar-nav ml-auto">
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true"
              aria-expanded="false">
              <i class="fas fa-user-circle"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
              <div class="text-center">
                <?= $this->UserInfo->avatar(); ?>
                <p><strong class="user-name"><small><?= $this->UserInfo->fullName(); ?></small></strong></p>
              </div>
              <a class="dropdown-item" href="#"><?=__('Perfil'); ?></a>
              <a class="dropdown-item" href="#"><?=__('Configurações'); ?></a>
              <div class="dropdown-divider"></div>
              <a class="dropdown-item" href="<?=$this->Url->build('/users/logout'); ?>"><?=__('Sair'); ?></a>
            </div>
          </li>
        </ul>
      </div>
    </nav>
