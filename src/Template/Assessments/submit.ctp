<div class="container-fluid">
  <div class="row mb-2">
    <div class="col">
      <h2><?= __('Submeter avaliação') ?></h2>
    </div>
  </div>
  <?= $this->Form->create(null, ['type' => 'file', 'id' => 'form-submit']); ?>
  <div class="row mb-2">
    <div class="col">
      <div class="form-group row mb-0">
        <label for="staticTitle" class="col-sm-2 col-form-label"><?= __('Avaliação:') ?></label>
        <div class="col-sm-10">
          <input type="text" readonly class="form-control-plaintext" id="staticTitle" value="<?= $assessment->title ?>">
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
            <div class="col-12 col-md-6">
              <div class="form-group mb-0">
                <label for="startAt" class="mb-0"><?= __('Início da submissão') ?></label>
                <input type="text" readonly class="form-control-plaintext" id="startAt" value="<?= $assessment->startAt->i18nFormat($dateFormat) ?>">
              </div>
            </div>
            <div class="col-12 col-md-6">
              <div class="form-group mb-0">
                <label for="endAt" class="mb-0"><?= __('Encerramento da submissão') ?></label>
                <input type="text" readonly class="form-control-plaintext" id="endAt" value="<?= $assessment->endAt->i18nFormat($dateFormat) ?>">
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-12 col-md-6">
              <div class="form-group mb-0">
                <label for="startAt" class="mb-0"><?= __('Início da avaliação') ?></label>
                <input type="text" readonly class="form-control-plaintext" id="startAt" value="<?= $assessment->start_assessment->i18nFormat($dateFormat) ?>">
              </div>
            </div>
            <div class="col-12 col-md-6">
              <div class="form-group mb-0">
                <label for="endAt" class="mb-0"><?= __('Encerramento da avaliação') ?></label>
                <input type="text" readonly class="form-control-plaintext" id="endAt" value="<?= $assessment->end_assessment->i18nFormat($dateFormat) ?>">
              </div>
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
              <?= $assessment->description ?>
            </div>
          </div>
          <?php if($assessment->file): ?>
            <div class="row">
              <div class="col">
                <a class="btn btn-info" title="<?= __('Baixar anexo'); ?>" href="<?= $this->Url->build(['controller' => 'Assessments', 'action' => 'getFile', $assessment->file]); ?>">
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
          <?= __('Critérios de avaliação') ?>
        </div>
        <div class="card-body">
          <?php foreach ($assessment->assessment_rubrics as $ar): ?>
            <div class="row">
              <div class="col">
                <strong><?= $ar->rubric->title ?></strong><br>
                <small><?= $ar->rubric->description ?></small>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
      </div>
    </div>
  </div>
  <div class="row mb-2">
    <div class="col">
      <div class="card">
        <div class="card-header">
          <?= __('Sua avaliação') ?>
        </div>
        <div class="card-body">
          <div class="form-group" id="file-container">
            <?php if ($assessmentUser && $assessmentUser->file): ?>
              <label for="attachment"><?= __('Visualizar arquivo enviado') ?></label>
              <div class="form-control">
                <a class="btn btn-info" id="attachment" title="<?= __('Visualizar'); ?>" href="<?= $this->Url->build(['controller' => 'Assessments', 'action' => 'getFile', $assessmentUser->file]); ?>">
                  <i class="fas fa-eye"></i> <?= __('Visualizar') ?>
                </a>
                <button class="btn btn-danger" type="button" id="remove-file" title="<?= __('Excluir arquivo'); ?>" value="<?= $assessmentUser->id ?>">
                  <i class="fas fa-trash"></i> <?= __('Excluir arquivo') ?>
                </button>
              </div>
            <?php else: ?>
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
            <?php endif; ?>
          </div>
          <div class="form-group">
            <label for="editor"><?= __('Texto'); ?></label>
            <i tabindex="0" class="fas fa-question-circle help" data-container="body" data-toggle="popover" data-placement="right" data-content="<?= __('Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.') ?>"></i>
            <div id="editor"><?= ($assessmentUser) ? $assessmentUser->document_text : '' ?></div>
            <?= $this->Form->hidden('document_text', ['id' => 'description', 'required' => false, 'value' => ($assessmentUser) ? $assessmentUser->document_text : '']) ?>
          </div>

          <?= $this->Form->hidden('AssessmentUsers.id', ['value' => ($assessmentUser) ? $assessmentUser->id : '']) ?>
          <button type="submit" class="btn btn-success" name="action" value="finish">
            <i class="fas fa-check"></i> <?= __('Submeter') ?>
          </button>
          <button type="submit" class="btn btn-secondary" name="action" value="save">
            <i class="fas fa-save"></i> <?= __('Salvar rascunho') ?>
          </button>
        </div>
      </div>
    </div>
  </div>
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
      placeholder: '<?= __('Lorem ipsum') ?>',
    });

    editor.on('editor-change', function(eventName, ...args) {
      $('#description').val($('#editor .ql-editor').html());
    });

    let buttonAction = 'save';
    $('button[type=submit]').on('click', function(){
      buttonAction = $(this).val();
    });


    $('#form-submit').on('submit', function(e) {
      let ok = true;

      if (buttonAction === 'finish') {
        ok = confirm('<?= __('Após submeter não será possível realizar alterações, até que seu par-avaliador(a) conclua a avaliação.') ?>')
      }

      if (!ok) {
        e.preventDefault();
        e.stopPropagation();
      }

    });

    $('#remove-file').on('click', function(e) {
      e.preventDefault();
      let ok = confirm('Deseja realmente excluir este arquivo?');
      let id = $(this).val();
      if (ok) {
        $.ajax({
          url: '<?= $this->Url->build('/assessments/removeFile') ?>',
          method: 'DELETE',
          data: {
            au_id: id,
          }
        })
        .done(function(html) {
          $('#file-container').html(html);
        });
      }
    });
  });
</script>
<?php $this->end(); ?>
