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
          <div class="card mb-3" data-team="<?= $team->id ?>">
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
                       <button type="button" class="btn btn-sm btn-primary add-user" data-toggle="modal" data-target="#addUserModal" data-team="<?= $team->id ?>" title="<?= __('Adicionar usuários') ?>">
                         <i class="fas fa-user-plus"></i>
                         <span class="not-small">
                           <?= __('Adicionar') ?>
                         </span>
                       </button>
                       <?=$this->Html->link(
                       '<i class="fas fa-plus"></i> <span class="not-small">' . __('Convidar') . '</span>',
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

<div class="modal fade" id="addUserModal" tabindex="-1" role="dialog" aria-labelledby="addUserModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addUserModalLabel">
          <?= __('Adicionar usuários existentes') ?>
        </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="<?= __('Fechar') ?>">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">
          <i class="fas fa-sign-out-alt"></i>
          <?= __('Fechar') ?>
        </button>
      </div>
    </div>
  </div>
</div>

<?php $this->start('script'); ?>
<script type="text/javascript">
  $(document).ready(function(){
    let $team = null;
    let $elem = null;

    const usersTeam = function($team) {
      $.ajax({
        url: '<?= $this->Url->build('/teams/listUsers'); ?>',
        method: 'GET',
        data: {
          team_id: $team,
        }
      })
      .done(function(html){
        $elem.children('.card-body').html(html);
      });
    }

    const usersTable = function($team, $search = null, $start = 1) {
      const $elem = $('#addUserModal .modal-body');
      $elem.html('<div class="loading text-center"><i class="fas fa-spinner fa-spin"></i></div>');
      $.ajax({
        url: '<?= $this->Url->build('/users/usersTable'); ?>',
        method: 'GET',
        data: {
          team: $team,
          search: $search,
          start: $start
        }
      })
      .done(function(html){
        $elem.html(html);
      })
      .fail(function(jqXHR, textStatus) {
        $elem.html(textStatus);
      });
    };

    $('#addUserModal').on('shown.bs.modal', function (e) {
      const $button = $(e.relatedTarget);
      $team = $button.data('team');
      $elem = $button.closest('.card');

      usersTable($team);
    });

    $(document).on('click', '#btn-user-search', function(){
      const $term = $('#user-search').val();
      usersTable($team, $term);
    });

    $(document).on('click', '.btn-user-paginate', function(){
      const $start = $(this).val();
      const $term = $('#user-search').val();
      usersTable($team, $term, $start);
    });

    $(document).on('click', '.select-user', function(){
      const $user = $(this).val();
      $.ajax({
        url: '<?= $this->Url->build('/teams/addUser.json');  ?>',
        method: 'POST',
        data: {
          team_id: $team,
          user_id: $user
        }
      })
      .done(function(data){

      })
    });

    $('#addUserModal').on('hide.bs.modal', function (e) {
      usersTeam($team);
    });

  })
</script>
<?php $this->end(); ?>
