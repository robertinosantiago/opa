<div class="container">
  <div class="row">
    <div class="col">
      <div class="input-group mb-3">
        <input type="text" class="form-control" id="rubric-search" placeholder="<?= __('Pesquisar') ?>" value="<?= $search ?>">
        <div class="input-group-append">
          <button class="btn btn-secondary" type="button" id="btn-rubric-search" title="<?= __('Pesquisar')  ?>">
            <i class="fas fa-search"></i>
          </button>
          <button class="btn btn-outline-secondary" type="button"  data-toggle="modal" data-target="#rubricNewModal" title="<?= __('Criar nova rubrica') ?>">
            <i class="fas fa-plus"></i> <?= __('Nova rubrica') ?>
          </button>
        </div>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col">
      <table class="table table-striped table-sm table-hover">
        <thead>
          <th><?= __('Rubrica'); ?></th>
          <th></th>
        </thead>
        <tbody>
          <?php if(empty($rubrics)): ?>
            <tr>
              <td colspan="2">
                <?= __('Não há dados para exibir'); ?>
              </td>
            </tr>
          <?php else: ?>
            <?php foreach($rubrics as $rubric): ?>
              <tr>
                <td><?= $rubric->full_info; ?></td>
                <td class="text-center">
                  <button class="btn btn-success btn-sm select-rubric" value="<?= $rubric->id ?>" title="<?= __('Selecionar') ?>">
                    <i class="fas fa-check-circle"></i> <span class="not-small"><?= __('Selecionar') ?></span>
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
                    class="btn btn-rubric-paginate <?= ($i == $start) ? 'btn-primary disabled' : 'btn-secondary' ?>"
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
