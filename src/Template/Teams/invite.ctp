<div class="container-fluid">
  <div class="row">
    <div class="col">
      <h1><?= __('Convidar usuários'); ?></h1>
    </div>
  </div>
  <div class="row">
    <div class="col">
      <?= $this->Form->create(); ?>
      <?php echo $this->Form->control(
        'email',
        [
          'label' => __('E-mail') . ' ' . __('(separar e-mails por vírgula)'),
          'required' => true,
          'class' => 'form-control',
          'type' => 'textarea',
          'rows' => 3,
          'templates' => [
            'inputContainer' => '<div class="form-group">{{content}}</div>',
          ],
        ]
      ); ?>
      <input type="hidden" name="discipline_id" value="<?= $discipline->id ?>">
      <input type="hidden" name="team_id" value="<?= $team->id ?>">
      <button type="submit" class="btn btn-success">
        <?php echo __('Convidar'); ?>
      </button>
      <?= $this->Form->end(); ?>
    </div>
  </div>
</div>
