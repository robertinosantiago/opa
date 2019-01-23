<?php if($rubric): ?>
<div class="col-12 rubrics-item">
  <div class="row mb-3">
    <div class="col-12 col-md-8 mb-3">
      <input type="text" disabled class="form-control" value="<?= $rubric->full_info; ?>">
      <input type="hidden" name="rubrics_id[]" value="<?= $rubric->id; ?>">
    </div>
    <div class=" col-8 col-md-2">
      <input type="number" class="form-control" required name="rubrics_weight[]" value="">
    </div>
    <div class="col-2 col-md-2 text-right">
      <button class="btn btn-danger btn-remove-rubric" title="<?= __('Remover') ?>">
          <i class="fas fa-trash"></i>  <span class="not-small"><?= __('Remover') ?></span>
      </button>
    </div>
  </div>
</div>
<?php endif; ?>
