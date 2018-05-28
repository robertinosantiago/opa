<?php

?>
<div class="container-fluid">
   <div class="row">
      <div class="col-9 col-md-8">
         <h2><?=$discipline->name; ?></h2>
      </div>
      <div class="col-3 col-md-4 text-right">
         <?=$this->Html->link(
         '<i class="fas fa-pencil-alt"></i> <span class="not-small">' . __('Edit') . '</span>',
         [
            'controller' => 'Disciplines',
            'action' => 'edit',
            $discipline->id,
         ],
         [
            'class' => 'btn btn-sm btn-warning',
            'title' => __('Edit discipline'),
            'escape' => false,
         ]
         ); ?>
         <?=$this->Form->postLink(
         '<i class="fas fa-trash-alt"></i> <span class="not-small">' . __('Delete') . '</span>',
         [
            'controller' => 'Disciplines',
            'action' => 'delete',
            $discipline->id,
         ],
         [
            'class' => 'btn btn-sm btn-danger',
            'title' => __('Delete discipline'),
            'confirm' => __('Are you sure?'),
            'method' => 'delete',
            'escape' => false,
         ]
         ); ?>
      </div>
   </div>
   <div class="row">
      <div class="col">
         <p><small><strong><?=__('Identification') ?>:</strong> <?=$discipline->id; ?></small></p>
      </div>
   </div>
   <div class="row">
      <div class="col">
         <div class="card">
            <div class="card-header">
               <div class="container-fluid">
                  <div class="row">
                     <div class="col-8">
                        <h5 class="card-title">
                           <?=__('Users'); ?>

                        </h5>
                     </div>
                     <div class="col-4 text-right">
                        <?=$this->Html->link(
                        '<i class="fas fa-plus"></i> <span class="not-small">' . __('Invite users') . '</span>',
                        [
                           'controller' => 'Disciplines',
                           'action' => 'invite',
                           $discipline->id,
                        ],
                        [
                           'class' => 'btn btn-sm btn-success',
                           'title' => __('Invite users'),
                           'escape' => false,
                        ]
                        ); ?>
                     </div>
                  </div>
               </div>
            </div>
            <div class="card-body">
                <table class="table table-striped table-hover table-sm">
                    <tbody>
                        <?php foreach($discipline->teams as $team): ?>
                            <?php foreach($team->students as $student): ?>
                                <tr>
                                    <td><?= $student->user->full_name; ?></td>
                                    <td><?= $team->name; ?></td>
                                </tr>
                           <?php endforeach; ?>
                        <?php endforeach; ?>
                    </tbody>
                </table>

            </div>
         </div>
      </div>
   </div>

</div>
