<table class="table table-hover table-striped">
  <thead>
    <tr>
      <th><?= __('Par avaliado') ?></th>
      <th><?= __('Par(es) avaliador(es)') ?></th>
    </tr>
  </thead>
  <tbody >
    <?php if ($users->isEmpty()): ?>
      <tr>
        <td colspan="2"><?= __('Não há pares atribuídos') ?></td>
      </tr>
    <?php else: ?>
      <?php foreach ($users as $user): ?>
        <tr>
          <td><?= $user->Users['first_name'] ?> <?= $user->Users['last_name'] ?></td>
          <td>
            <?php foreach ($user->appraisers as $appraiser): ?>
              <div class="row pb-2">
                <div class="col-10">
                  <?= $appraiser->Users['first_name'] ?> <?= $appraiser->Users['last_name'] ?>
                </div>
                <div class="col-2 text-right">
                  <button type="button" value="<?= $appraiser->id ?>" class="btn btn-sm btn-danger btn-remove-appraiser" title="<?= __('Remover par avaliador') ?>">
                    <i class="fas fa-trash"></i>
                  </button>
                </div>
              </div>
            <?php endforeach; ?>
          </td>
        </tr>
      <?php endforeach; ?>
    <?php endif; ?>
  </tbody>
  <tfoot>
    <tr>
      <td colspan="2">
        <?php if (!$users->isEmpty()): ?>
          <button type="button" id="btn-remove-all" class="btn btn-danger" value="<?= $assessment->id ?>" title="<?= __('Remover todas as atribuições de pares') ?>">
            <i class="fas fa-trash"></i> <?= __('Remover todos'); ?>
          </button>
        <?php endif; ?>
      </td>
    </tr>
  </tfoot>
</table>
