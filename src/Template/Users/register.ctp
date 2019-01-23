 <div class="container">
   <div class="row">
     <div class="col-md-6 offset-md-3">
       <div class="card card-login">
         <div class="card-header">
           <?= __('Por favor, informa seus dados') ?>
         </div>
         <div class="card-body">
           <?= $this->Form->create($user); ?>
           <div class="row">
             <div class="col">
               <?= $this->Form->control('first_name', ['label' => __('Nome'), 'required' => true, 'class' => 'form-control', 'templates' => ['inputContainer' => '<div class="form-group">{{content}}</div>']]) ?>
               <?= $this->Form->control('last_name', ['label' => __('Sobrenome'), 'required' => true, 'class' => 'form-control', 'templates' => ['inputContainer' => '<div class="form-group">{{content}}</div>']]) ?>
               <?= $this->Form->control('username', ['label' => __('Usuário'), 'required' => true, 'class' => 'form-control', 'templates' => ['inputContainer' => '<div class="form-group">{{content}}</div>']]) ?>
               <?= $this->Form->control('email', ['label' => __('E-mail'), 'required' => true, 'class' => 'form-control', 'templates' => ['inputContainer' => '<div class="form-group">{{content}}</div>']]) ?>
               <?= $this->Form->control('password', ['label' => __('Senha'), 'required' => true, 'class' => 'form-control', 'templates' => ['inputContainer' => '<div class="form-group">{{content}}</div>']]) ?>
               <?= $this->Form->control('password_confirm', ['type' => 'password', 'label' => __('Confirmar senha'), 'class' => 'form-control', 'templates' => ['inputContainer' => '<div class="form-group">{{content}}</div>']]);  ?>

               <?= $this->Form->button(__('Submit'), ['class' => 'btn btn-success btn-block text-light btn-login']); ?>
             </div>
           </div>

           <?= $this->Form->end(); ?>
         </div>
       </div>
     </div>
   </div>
 </div>
