<?php if (!empty($assessmentUser->document_text)): ?>
<div class="card mb-3">
  <div class="card-header">
    <?= __('Texto') ?>
  </div>
  <div class="card-body">
    <?= $assessmentUser->document_text; ?>
  </div>
</div>
<?php endif; ?>

<?php if (!empty($assessmentUser->file)): ?>
  <div class="row mb-3">
    <div class="col">
      <a class="btn btn-info" title="<?= __('Baixar anexo'); ?>" href="<?= $this->Url->build(['controller' => 'Assessments', 'action' => 'getFile', $assessmentUser->file]); ?>">
        <i class="fas fa-download"></i> <?= __('Baixar anexo') ?>
      </a>
    </div>
    <div class="col">
      <div class="row">
        <div class="col">
          <?= __('Enviado como rascunho?') ?>
        </div>
      </div>
      <div class="row">
        <div class="col">
          <?= ($assessmentUser->draft ? __('Sim') : __('Não')) ?>
        </div>
      </div>
    </div>
  </div>
<?php endif; ?>

<div class="row mb-3">
  <div class="col">
    <div class="row">
      <div class="col">
        <small><?= __('Criado em') ?>:</small>
      </div>
    </div>
    <div class="row">
      <div class="col">
        <small><?= $assessmentUser->created->i18nFormat($dateFormat) ?></small>
      </div>
    </div>
  </div>
  <div class="col">
    <div class="row">
      <div class="col">
        <small><?= __('Modificado em') ?>:</small>
      </div>
    </div>
    <div class="row">
      <div class="col">
        <small><?= $assessmentUser->modified->i18nFormat($dateFormat) ?></small>
      </div>
    </div>
  </div>
</div>
