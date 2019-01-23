<?php for ($i=0; $i < $scale; $i++): ?>
  <div class="col-12 col-md mb-3">
    <input type="text" class="form-control" name="scales[]" value="<?= ($i + 1) ?>" required placeholder="<?= __('Informe um valor') ?>">
  </div>
  <?php if ($i == 4): ?>
    <div class="w-100"></div>
  <?php endif;  ?>
<?php endfor; ?>
