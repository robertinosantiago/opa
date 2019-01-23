<div class="container-fluid">
  <div class="row">
    <div class="col">
      <h2><?= __('Convites enviados'); ?></h2>
    </div>
  </div>
  <div class="row">
    <div class="col">
      <table class="table table-striped table-hover">
        <thead>
          <tr>
            <th><?= __('E-mail') ?></th>
            <th><?= __('Convites enviados') ?></th>
            <th><?= __('Convite aceito') ?></th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($invites as $invite): ?>
            <tr>
              <td><?= $invite->email ?></td>
              <td><?= $invite->count_invites ?></td>
              <td><?= $invite->confirm == false ? __('Não'): __('Sim') ?></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
