<div class="container">
  <div class="row">
    <div class="col">
      <div class="input-group mb-3">
        <input type="text" class="form-control" id="user-search" placeholder="<?= __('Pesquisar') ?>" value="<?= $search ?>">
        <div class="input-group-append">
          <button class="btn btn-secondary" type="button" id="btn-user-search"  title="<?= __('Pesquisar') ?>">
            <i class="fas fa-search"></i>
          </button>
        </div>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col">
      <table class="table table-striped table-sm table-hover">
        <thead>
          <th></th>
          <th><?= __('Nome'); ?></th>
          <th><?= __('E-mail'); ?></th>
          <th></th>
        </thead>
        <tbody>
          <?php if(empty($users)): ?>
            <tr>
              <td colspan="4">
                <?= __('Não há dados para exibir'); ?>
              </td>
            </tr>
          <?php else: ?>
            <?php foreach($users as $user): ?>
              <tr>
                <td>
                  <img width="32" src="<?= ($user->avatar != null ? $user->avatar : $this->Url->image('user-icon.png', ['fullBase' => true])) ?>" alt="<?= __('Avatar') ?>" class="img-fluid rounded">
                </td>
                <td><?= $user->first_name; ?> <?= $user->last_name; ?></td>
                <td><?= $user->email; ?></td>
                <td class="text-center">
                  <button class="btn btn-success btn-sm select-user" value="<?= $user->id ?>" title="<?= __('Adicionar') ?>">
                    <i class="fas fa-check-circle"></i>  <span class="not-small"><?= __('Adicionar') ?></span>
                  </button>
                </td>
              </tr>
            <?php endforeach; ?>
          <?php endif; ?>
        </tbody>
        <?php if ($pages > 1): ?>
          <tfoot>
            <tr>
              <td colspan="3" class="text-center">
                <div class="btn-group" role="group" aria-label="<?= __('Paginação'); ?>">
                  <?php for($i = 1; $i <= $pages; $i++): ?>
                    <button type="button"
                    class="btn btn-user-paginate <?= ($i == $start) ? 'btn-primary disabled' : 'btn-secondary' ?>"
                    value="<?= $i ?>">
                    <?= $i ?>
                  </button>
                <?php endfor; ?>
              </div>
            </td>
          </tr>
        </tfoot>
      <?php endif; ?>
    </table>
    </div>
  </div>
</div>
