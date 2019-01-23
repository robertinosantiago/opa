<?php

?>
<div class="container-fluid">
   <div class="row">
      <div class="col-9 col-md-8">
         <h2><?=$discipline->name; ?></h2>
      </div>
      <div class="col-3 col-md-4 text-right">

         <?=$this->Html->link(
         '<i class="fas fa-pencil-alt"></i> <span class="not-small">' . __('Editar') . '</span>',
         [
            'controller' => 'Disciplines',
            'action' => 'edit',
            $discipline->id,
         ],
         [
            'class' => 'btn btn-sm btn-warning',
            'title' => __('Editar disciplina'),
            'escape' => false,
         ]
         ); ?>
         <?=$this->Form->postLink(
         '<i class="fas fa-trash-alt"></i> <span class="not-small">' . __('Excluir') . '</span>',
         [
            'controller' => 'Disciplines',
            'action' => 'delete',
            $discipline->id,
         ],
         [
            'class' => 'btn btn-sm btn-danger',
            'title' => __('Excluir disciplina'),
            'confirm' => __('Você tem certeza?'),
            'method' => 'delete',
            'escape' => false,
         ]
         ); ?>
      </div>
   </div>
   <div class="row">
      <div class="col">
        <?php foreach($discipline->teams as $team): ?>
          <?php //debug($team) ?>
          <div class="card mb-3">
            <div class="card-header">
              <div class="container-fluid">
                 <div class="row">
                    <div class="col-12 col-md-6">
                       <h5 class="card-title">
                          <?=__('Turma'); ?>:
                          <?= $team->name; ?>
                       </h5>
                       <small><?= $team->description; ?></small>
                    </div>
                    <div class="col-12 col-md-6 text-right">
                       <?=$this->Html->link(
                       '<i class="fas fa-plus"></i> <span class="not-small">' . __('Convidar usuários') . '</span>',
                       [
                          'controller' => 'Teams',
                          'action' => 'invite',
                          $discipline->id,
                          $team->id,
                       ],
                       [
                          'class' => 'btn btn-sm btn-success',
                          'title' => __('Convidar usuários'),
                          'escape' => false,
                       ]
                       ); ?>
                       <?=$this->Html->link(
                       '<i class="fas fa-mail-bulk"></i> <span class="not-small">' . __('Convites enviados') . '</span>',
                       [
                          'controller' => 'Teams',
                          'action' => 'invites',
                          $discipline->id,
                          $team->id,
                       ],
                       [
                          'class' => 'btn btn-sm btn-info',
                          'title' => __('Convites enviados'),
                          'escape' => false,
                       ]
                       ); ?>
                    </div>
                 </div>
              </div>
            </div>
            <div class="card-body">
              <h5><?= __('Alunos da turma')  ?></h5>
                <table class="table table-striped table-hover table-sm">
                    <tbody>
                      <?php foreach($team->team_users as $team_user): ?>
                      <tr>
                        <td><?= $team_user->user->first_name . ' ' . $team_user->user->last_name  ?></td>
                      </tr>
                      <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
          </div>
        <?php endforeach;  ?>
      </div>
   </div>

</div>
