<div class="container">
  <div class="row">
    <div class="col-md-6 offset-md-3">
      <div class="card card-login">
        <div class="card-header">
          <?= __('Please enter your username and password') ?>
        </div>
        <div class="card-body">
          <?= $this->Form->create(); ?>
          <div class="row">
            <div class="col">
              <?= $this->Form->control('email', ['label' => __('E-mail'), 'required' => true, 'class' => 'form-control', 'templates' => ['inputContainer' => '<div class="form-group">{{content}}</div>']]) ?>
              <?= $this->Form->control('password', ['label' => __('Password'), 'required' => true, 'class' => 'form-control', 'templates' => ['inputContainer' => '<div class="form-group">{{content}}</div>']]) ?>
              <?= $this->Html->link(__('Register'), ['action' => 'register']); ?> |
              <?= $this->Html->link(__('Reset Password'), ['action' => 'requestResetPassword']); ?>
              <?= $this->Form->button(__('Login'), ['class' => 'btn btn-success btn-block text-light btn-login']); ?>
            </div>
          </div>
          <?= $this->Form->end(); ?>
          <div class="row social">
            <div class="col">
              <?= $this->Form->postLink(
                  '<i class="fa fa-facebook"></i> <span class="not-small">' . __('Login with') . '</span> ' . __('Facebook'),
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
                    'title' => __('Login with Facebook'),
                    'escape' => false
                  ]
              ); ?>
            </div>
            <div class="col">
              <?= $this->Form->postLink(
                  '<i class="fa fa-google"></i> <span class="not-small">' . __('Login with') . '</span> ' . __('Google'),
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
                    'title' => __('Login with Google'),
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
