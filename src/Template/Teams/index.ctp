<div class="container-fluid">
    <div class="row">
        <div class="col">
            <h2>
                <?= __('Turmas') ?>
            </h2>
            <h5><?= $discipline->name; ?></h5>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <?php foreach($teams as $team): ?>
            <div class="card">
            <div class="card-header">
               <div class="container">
                  <div class="row">
                     <div class="col-8">
                        <h5 class="card-title">
                           <?= $team->name; ?>
                        </h5>
                     </div>
                     <div class="col-4 text-right">
                        <?=$this->Html->link(
                        '<i class="fas fa-plus"></i> <span class="not-small">' . __('Convidar usuários') . '</span>',
                        [
                           'controller' => 'Teams',
                           'action' => 'invite',
                           $team->id,
                        ],
                        [
                           'class' => 'btn btn-sm btn-success',
                           'title' => __('Convidar usuários'),
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

                    </tbody>
                </table>
            </div>
         </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>
