<?= $this->Form->control(
  'discipline_id',
  [
    'label' => false,
    'required' => true,
    'class' => 'custom-select',
    'id' => 'new-discipline-id',
    'default' => $discipline->id,
    'templates' => [
      'inputContainer' => '{{content}}'
    ]
  ]
); ?>
<div class="input-group-append">
  <button id="bt-new-discipline" class="btn btn-outline-secondary" type="button" data-toggle="modal" data-target="#newDisciplineModal" title="<?= __('Cadastrar nova disciplina') ?>">
      <i class="fas fa-plus"></i> <?= __('Nova disciplina') ?>
  </button>
</div>
