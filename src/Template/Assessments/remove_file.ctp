<?php if ($removed): ?>
  <label for="attachment"><?= __('Adicionar um arquivo'); ?></label>
  <i tabindex="0" class="fas fa-question-circle help" data-container="body" data-toggle="popover" data-placement="right" data-content="<?= __('Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.') ?>"></i>
  <?= $this->Form->control(
    'attachment',
    [
      'label' => false,
      'required' => false,
      'type' => 'file',
      'class' => 'form-control-file form-control',
    ]
  ); ?>
<?php else: ?>
  <div class="alert alert-danger" role="alert">
    <?= __('Ocorreu um erro. Tente novamente mais tarde.') ?>
  </div>
<?php endif; ?>
