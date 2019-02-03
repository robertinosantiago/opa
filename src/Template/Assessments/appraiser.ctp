<div class="container-fluid">
  <div class="row mb-2">
    <div class="col">
      <h2><?= __('Avaliar submissão') ?></h2>
    </div>
  </div>
  <?= $this->Form->create(null, ['type' => 'file', 'id' => 'form-appraiser']); ?>
  <div class="row mb-2">
    <div class="col">
      <div class="form-group row mb-0">
        <label for="staticTitle" class="col-sm-2 col-form-label"><?= __('Avaliação:') ?></label>
        <div class="col-sm-10">
          <input type="text" readonly class="form-control-plaintext" id="staticTitle" value="<?= $assessmentUser->assessment->title ?>">
          <strong><?= $assessmentUser->assessment->team->name ?> - <?= $assessmentUser->assessment->team->discipline->name ?></strong>
        </div>
      </div>
    </div>
  </div>
  <div class="row mb-2">
    <div class="col">
      <div class="card">
        <div class="card-header">
          <?= __('Prazos') ?>
        </div>
        <div class="card-body">
          <div class="row">
            <div class="col-12 col-md-4">
              <div class="form-group mb-0">
                <label for="startAt" class="mb-0"><?= __('Início da submissão') ?></label>
                <input type="text" readonly class="form-control-plaintext" id="startAt" value="<?= $assessmentUser->assessment->startAt->i18nFormat($dateFormat) ?>">
              </div>
            </div>
            <div class="col-12 col-md-4">
              <div class="form-group mb-0">
                <label for="endAt" class="mb-0"><?= __('Encerramento da submissão') ?></label>
                <input type="text" readonly class="form-control-plaintext" id="endAt" value="<?= $assessmentUser->assessment->endAt->i18nFormat($dateFormat) ?>">
              </div>
            </div>
            <div class="col-12 col-md-4">
              <div class="form-group mb-0">
                <label for="modified" class="mb-0"><?= __('Submetido para avaliação') ?></label>
                <input type="text" readonly class="form-control-plaintext" id="modified" value="<?= $assessmentUser->modified->i18nFormat($dateFormat) ?>">
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-12 col-md-4">
              <div class="form-group mb-0">
                <label for="startAt" class="mb-0"><?= __('Início da avaliação') ?></label>
                <input type="text" readonly class="form-control-plaintext" id="startAt" value="<?= $assessmentUser->assessment->start_assessment->i18nFormat($dateFormat) ?>">
              </div>
            </div>
            <div class="col-12 col-md-4">
              <div class="form-group mb-0">
                <label for="endAt" class="mb-0"><?= __('Encerramento da avaliação') ?></label>
                <input type="text" readonly class="form-control-plaintext" id="endAt" value="<?= $assessmentUser->assessment->end_assessment->i18nFormat($dateFormat) ?>">
              </div>
            </div>
            <div class="col-12 col-md-4">

            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="row mb-2">
    <div class="col">
      <div class="card">
        <div class="card-header">
          <?= __('Descrição da avaliação') ?>
        </div>
        <div class="card-body">
          <div class="row">
            <div class="col">
              <?= $assessmentUser->assessment->description ?>
            </div>
          </div>
          <?php if($assessmentUser->assessment->file): ?>
            <div class="row">
              <div class="col">
                <a class="btn btn-info" title="<?= __('Baixar anexo'); ?>" href="<?= $this->Url->build(['controller' => 'Assessments', 'action' => 'getFile', $assessmentUser->assessment->file]); ?>">
                  <i class="fas fa-download"></i> <?= __('Baixar anexo') ?>
                </a>
              </div>
            </div>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>
  <div class="row mb-2">
    <div class="col">
      <div class="card">
        <div class="card-header">
          <?= __('Avaliação submetida') ?>
        </div>
        <div class="card-body">
          <?php if ($assessmentUser->document_text): ?>
            <div class="row">
              <div class="col">
                <?= $assessmentUser->document_text ?>
              </div>
            </div>
          <?php endif; ?>
          <?php if($assessmentUser->file): ?>
            <div class="row">
              <div class="col">
                <a class="btn btn-info" title="<?= __('Baixar arquivo'); ?>" href="<?= $this->Url->build(['controller' => 'Assessments', 'action' => 'getFile', $assessmentUser->file]); ?>">
                  <i class="fas fa-download"></i> <?= __('Baixar arquivo') ?>
                </a>
              </div>
            </div>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>
  <div class="row mb-2">
    <div class="col">
      <div class="card">
        <div class="card-header">
          <?= __('Rubricas') ?>
        </div>
        <div class="card-body">
          <?php foreach ($assessmentUser->assessment->assessment_rubrics as $ar): ?>
            <div class="row mb-2">
              <div class="col-12 col-md-6">
                <strong><?= $ar->rubric->title; ?></strong>
                <small><?= $ar->rubric->description ?></small>
              </div>
              <div class="col-12 col-md-3 text-center">
                <div class="form-group required">
                  <select class="form-control" name="score[]" required>
                    <option value=""><?= __('Selecione') ?></option>
                    <?php foreach (json_decode($assessmentUser->assessment->labels) as $key => $label): ?>
                      <option value="<?= $key ?>"><?= $label ?></option>
                    <?php endforeach; ?>
                  </select>
                  <input type="hidden" name="rubric[]" value="<?= $ar->rubric->id ?>">
                </div>
              </div>
              <div class="col-12 col-md-3">
                <div class="form-group">
                  <textarea name="rubric_comments[]" class="form-control" placeholder="<?= __('Comentários') ?>"></textarea>
                </div>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
      </div>
    </div>
  </div>
  <div class="row mb-2">
    <div class="col">
      <div class="form-group">
        <label for="editor"><?php echo __('Comentários'); ?></label>
        <i tabindex="0" class="fas fa-question-circle help" data-container="body" data-toggle="popover" data-placement="right" data-content="<?= __('Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.') ?>"></i>
        <div id="editor"></div>
        <?php echo $this->Form->hidden('comments', ['id' => 'comments']) ?>
      </div>
    </div>
  </div>
  <?= $this->Form->hidden('assessment_user_id', ['value' => $assessmentUser->id]) ?>
  <button type="submit" class="btn btn-success">
    <i class="fas fa-check"></i> <?= __('Submeter') ?>
  </button>
  <?= $this->Form->end(); ?>
</div>

<?php $this->start('css'); ?>
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
<style media="screen">
.ql-editor.ql-blank::before {
  font-style: normal;
}
</style>
<?php $this->end(); ?>

<?php $this->start('script'); ?>
<script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
<script type="text/javascript">
$(document).ready(function(){
  $('[data-toggle="popover"]').popover({
    trigger: 'focus'
  });

  let options = [
    ['bold', 'italic', 'underline'],
    [{ 'list': 'ordered'}, { 'list': 'bullet' }],
    [{ 'indent': '-1'}, { 'indent': '+1' }],
    [{ 'align': [] }],
  ];

  let editor = new Quill('#editor', {
    theme: 'snow',
    modules: {
      toolbar: options
    },
    placeholder: '<?= __('Comentários sobre a avaliação') ?>',
  });

  editor.on('editor-change', function(eventName, ...args) {
    $('#comments').val($('#editor .ql-editor').html());
  });
});
</script>
<?php $this->end(); ?>
