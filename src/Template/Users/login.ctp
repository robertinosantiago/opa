<div class="container">
  <div class="row">
    <div class="col-md-6 offset-md-3">
      <div class="card card-login">
        <div class="card-header">
          <?= __('Por favor, informe seu email e sua senha') ?>
        </div>
        <div class="card-body">
          <?= $this->Form->create(); ?>
          <div class="row">
            <div class="col">
              <?= $this->Form->control('email', ['label' => __('E-mail'), 'required' => true, 'class' => 'form-control', 'templates' => ['inputContainer' => '<div class="form-group">{{content}}</div>']]) ?>
              <?= $this->Form->control('password', ['label' => __('Senha'), 'required' => true, 'class' => 'form-control', 'templates' => ['inputContainer' => '<div class="form-group">{{content}}</div>']]) ?>
              <?= $this->Html->link(__('Registrar'), ['action' => 'register']); ?> |
              <?= $this->Html->link(__('Esqueci a senha'), ['action' => 'requestResetPassword']); ?>
              <?= $this->Form->button(__('Entrar'), ['class' => 'btn btn-success btn-block text-light btn-login']); ?>
            </div>
          </div>
          <?= $this->Form->end(); ?>
          <div class="row social">
            <div class="col">
              <?= $this->Form->postLink(
                  '<i class="fa fa-facebook"></i> <span class="not-small">' . __('Entrar com') . '</span> ' . __('Facebook'),
                  [
                      'prefix' => false,
                      'plugin' => 'ADmad/SocialAuth',
                      'controller' => 'Auth',
                      'action' => 'login',
                      'provider' => 'facebook',
                      '?' => ['redirect' => $this->request->getQuery('redirect')]
                  ],
                  [
                    'class' => 'btn btn-block btn-social btn-facebook',
                    'title' => __('Entrar com Facebook'),
                    'escape' => false
                  ]
              ); ?>
            </div>
            <div class="col">
              <?= $this->Form->postLink(
                  '<i class="fa fa-google"></i> <span class="not-small">' . __('Entrar com') . '</span> ' . __('Google'),
                  [
                      'prefix' => false,
                      'plugin' => 'ADmad/SocialAuth',
                      'controller' => 'Auth',
                      'action' => 'login',
                      'provider' => 'google',
                      '?' => ['redirect' => $this->request->getQuery('redirect')]
                  ],
                  [
                    'class' => 'btn btn-block btn-social btn-google',
                    'title' => __('Entrar com Google'),
                    'escape' => false
                  ]
              ); ?>
            </div>
          </div>

        </div>
      </div>
    </div>
  </div>
</div>
