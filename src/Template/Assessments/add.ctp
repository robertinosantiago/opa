<?php
/**
 * @author Robertino Mendes Santiago Junior
 */
?>
<div class="container">

    <div class="row">
        <div class="col">
          <h1><?=__('Avaliação');?></h1>
          <div class="alert alert-info" role="alert">
            <?= __('Os campos identificados com asterisco (*) são obrigatórios') ?>
          </div>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <?= $this->Form->create(null,['type' => 'file', 'id' => 'form-add']); ?>

            <div class="form-group required">
              <label for="title"><?= __('Título') ?></label>
              <i tabindex="0" class="fas fa-question-circle help" data-container="body" data-toggle="popover" data-placement="right" data-content="<?= __('Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.') ?>"></i>
              <?= $this->Form->control(
                'title',
                [
                  'label' => false,
                  'required' => true,
                  'class' => 'form-control',
                  'placeholder' => __('Título')
                ]
              ); ?>
            </div>

            <div class="form-group required">
              <label for="editor"><?php echo __('Descrição'); ?></label>
              <i tabindex="0" class="fas fa-question-circle help" data-container="body" data-toggle="popover" data-placement="right" data-content="<?= __('Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.') ?>"></i>
              <div id="editor"></div>
              <?php echo $this->Form->hidden('description', ['id' => 'description', 'required' => true]) ?>
            </div>

            <div class="form-group">
              <label for="attachment"><?= __('Anexo'); ?></label>
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
            </div>

            <div class="row">
              <div class="col-12 col-md-12 col-lg-3">

                <div class="form-group required">
                  <label for="maximum_score"><?= __('Nota máxima'); ?></label>
                  <i tabindex="0" class="fas fa-question-circle help" data-container="body" data-toggle="popover" data-placement="right" data-content="<?= __('Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.') ?>"></i>
                  <?= $this->Form->control(
                    'maximum_score',
                    [
                      'label' => false,
                      'required' => true,
                      'type' => 'number',
                      'min' => 1,
                      'max' => 100,
                      'class' => 'form-control',
                      'placeholder' => __('Entre 1 e 100')
                    ]
                  ); ?>

                </div>
              </div>
              <div class="col-12 col-md-12 col-lg-9 mb-3">
                <div class="form-group required">
                  <label for="team-name"><?php echo __('Turma'); ?></label>
                  <i tabindex="0" class="fas fa-question-circle help" data-container="body" data-toggle="popover" data-placement="right" data-content="<?= __('Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.') ?>"></i>
                  <div class="input-group">
                    <input type="text" required readonly id="team-name" class="form-control" placeholder="<?= __('Selecione uma turma'); ?>" aria-label="<?= __('Selecione uma turma'); ?>" aria-describedby="bt-open-team-modal">
                    <div class="input-group-append">
                      <button class="btn btn-outline-secondary" type="button" id="bt-open-team-modal" data-toggle="modal" data-target="#teamModal" title="<?= __('Selecione uma turma') ?>">
                          <i class="fas fa-search"></i> <span class="not-small"><?= __('Selecionar') ?></span>
                      </button>
                    </div>
                  </div>
                </div>

                <?= $this->Form->control('team_id', ['type' => 'hidden', 'required' => true]); ?>
              </div>
            </div>

            <div class="row">
              <div class="col-12">
                <div class="card mb-3">
                  <div class="card-header">
                    <?= __('Prazos')  ?>
                    <i tabindex="0" class="fas fa-question-circle help" data-container="body" data-toggle="popover" data-placement="right" data-content="<?= __('Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.') ?>"></i>
                  </div>
                  <div class="card-body">
                    <div class="row">
                      <div class="col-12 col-md-12 col-lg-6">
                        <div class="row">
                          <div class="col-12 required">
                            <label for="datestartat"><?php echo __('Início da submissão');  ?></label>
                            <i tabindex="0" class="fas fa-question-circle help" data-container="body" data-toggle="popover" data-placement="right" data-content="<?= __('Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.') ?>"></i>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-12 col-md-6 mb-3">
                            <input type="text" id="datestartatpicker" placeholder="dd/mm/yyyy" name="datestart" required class="form-control datetimepicker-input" data-toggle="datetimepicker" data-target="#datestartatpicker"/>
                          </div>
                          <div class="col-12 col-md-6 mb-3">
                            <input type="text" id="timestartatpicker" placeholder="hh:mm"  name="timestart" required class="form-control datetimepicker-input" data-toggle="datetimepicker" data-target="#timestartatpicker"/>
                          </div>
                        </div>
                      </div>

                      <div class="col-12 col-md-12 col-lg-6">
                        <div class="row">
                          <div class="col-12 required">
                            <label for="dateendat"><?php echo __('Encerramento da submissão');  ?></label>
                            <i tabindex="0" class="fas fa-question-circle help" data-container="body" data-toggle="popover" data-placement="right" data-content="<?= __('Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.') ?>"></i>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-12 col-md-6 mb-3">
                            <input type="text" id="dateendatpicker" placeholder="dd/mm/yyyy" name="dateend" required class="form-control datetimepicker-input" data-toggle="datetimepicker" data-target="#dateendatpicker"/>
                          </div>
                          <div class="col-12 col-md-6 mb-3">
                            <input type="text" id="timeendatpicker" placeholder="hh:mm" name="timeend" required class="form-control datetimepicker-input" data-toggle="datetimepicker" data-target="#timeendatpicker"/>
                          </div>
                        </div>
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-12 col-md-12 col-lg-6">
                        <div class="row">
                          <div class="col-12 required">
                            <label for="datestartassessmentpicker"><?php echo __('Início da avaliação');  ?></label>
                            <i tabindex="0" class="fas fa-question-circle help" data-container="body" data-toggle="popover" data-placement="right" data-content="<?= __('Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.') ?>"></i>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-12 col-md-6 mb-3">
                            <input type="text" id="datestartassessmentpicker" placeholder="dd/mm/yyyy" name="datestartassessment" required class="form-control datetimepicker-input" data-toggle="datetimepicker" data-target="#datestartassessmentpicker"/>
                          </div>
                          <div class="col-12 col-md-6 mb-3">
                            <input type="text" id="timestartassessmentpicker" placeholder="hh:mm"  name="timestartassessment" required class="form-control datetimepicker-input" data-toggle="datetimepicker" data-target="#timestartassessmentpicker"/>
                          </div>
                        </div>
                      </div>

                      <div class="col-12 col-md-12 col-lg-6">
                        <div class="row">
                          <div class="col-12 required">
                            <label for="dateendassessmentpicker"><?php echo __('Encerramento da avaliação');  ?></label>
                            <i tabindex="0" class="fas fa-question-circle help" data-container="body" data-toggle="popover" data-placement="right" data-content="<?= __('Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.') ?>"></i>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-12 col-md-6 mb-3">
                            <input type="text" id="dateendassessmentpicker" placeholder="dd/mm/yyyy" name="dateendassessment" required class="form-control datetimepicker-input" data-toggle="datetimepicker" data-target="#dateendassessmentpicker"/>
                          </div>
                          <div class="col-12 col-md-6 mb-3">
                            <input type="text" id="timeendassessmentpicker" placeholder="hh:mm" name="timeendassessment" required class="form-control datetimepicker-input" data-toggle="datetimepicker" data-target="#timeendassessmentpicker"/>
                          </div>
                        </div>
                      </div>
                    </div>

                  </div>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-12">
                <div class="card mb-3">
                  <div class="card-header">
                    <?= __('Escalas')  ?>
                    <i tabindex="0" class="fas fa-question-circle help" data-container="body" data-toggle="popover" data-placement="right" data-content="<?= __('Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.') ?>"></i>
                  </div>
                  <div class="card-body">
                    <div class="row">
                      <div class="col">
                        <div class="form-group required">
                          <label for="scale"><?php echo __('Quantidade de escalas (Entre 2 e 10)'); ?></label>
                          <div class="input-group">
                            <input type="number" name="scale" value="3" min="2" max="10" required id="scale" class="form-control" placeholder="<?= __('Informe um número entre 2 e 10'); ?>" >
                            <div class="input-group-append">
                              <button class="btn btn-outline-secondary" type="button" id="bt-change-scale" title="<?= __('Definir a escala de respostas') ?>">
                                  <i class="fas fa-check"></i> <span class="not-small"><?= __('Definir') ?></span>
                              </button>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row list-scales">
                      <div class="col-12 col-md mb-3">
                        <input type="text" class="form-control" name="scales[]" value="<?= __('Ruim') ?>" required placeholder="<?= __('Informe um valor') ?>">
                      </div>
                      <div class="col-12 col-md mb-3">
                        <input type="text" class="form-control" name="scales[]" value="<?= __('Regular') ?>" required placeholder="<?= __('Informe um valor') ?>">
                      </div>
                      <div class="col-12 col-md mb-3">
                        <input type="text" class="form-control" name="scales[]" value="<?= __('Bom') ?>" required placeholder="<?= __('Informe um valor') ?>">
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-12">
                <div id="card-rubrics" class="card mb-3">
                  <div class="card-header">
                    <?= __('Rubricas')  ?>
                    <i tabindex="0" class="fas fa-question-circle help" data-container="body" data-toggle="popover" data-placement="right" data-content="<?= __('Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.') ?>"></i>
                  </div>
                  <div class="card-body">
                    <div class="row mb-3">
                      <div class="col-12">
                        <div class="row">
                          <div class="col-12 col-md-8">
                            <strong><?= __('Rubrica'); ?></strong>
                          </div>
                          <div class="col-12 col-md-2">
                            <strong><?= __('Peso'); ?></strong>
                          </div>
                          <div class="col-12 col-md-2">

                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row rubrics">

                    </div>
                    <div class="row">
                      <div class="col">
                        <div class="form-group">

                          <div class="input-group">
                            <input type="text" id="rubric" autocomplete="off" class="typeahead form-control" placeholder="<?= __('Informe o nome da rubrica'); ?>" >
                            <div class="input-group-append">
                              <button class="btn btn-outline-secondary" type="button" id="bt-list-rubrics" data-toggle="modal" data-target="#rubricModal" title="<?= __('Listar todas a rubricas cadastradas') ?>">
                                  <i class="fas fa-th-list"></i> <span class="not-small"><?= __('Listar todas') ?></span>
                              </button>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>




            <button type="submit" class="btn btn-success">
              <?php echo __('Salvar'); ?>
            </button>

            <?= $this->Form->end(); ?>
        </div>
    </div>
</div>




<div class="modal fade" id="rubricModal" tabindex="-1" role="dialog" aria-labelledby="rubricModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="rubricModalLabel"><?= __('Rubricas'); ?></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="<?= __('Fechar'); ?>">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

      </div>
      <div class="modal-footer">
        <button type="button" title="<?= __('Cancelar') ?>" class="btn btn-secondary" data-dismiss="modal"><?= __('Cancelar') ?></button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="rubricNewModal" tabindex="-1" role="dialog" aria-labelledby="rubricNewModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="rubricNewModalLabel"><?= __('Nova rubrica'); ?></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="<?= __('Fechar'); ?>">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="form-group">
          <label for="title-new-rubric"><?= __('Título') ?></label>
          <input type="text" class="form-control" id="title-new-rubric" value="">
        </div>
        <div class="form-group">
          <label for="editor-description-new-rubric"><?= __('Descrição') ?></label>
          <div id="editor-description-new-rubric"></div>
          <input id="description-new-rubric" type="hidden">
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-success" id="btn-save-new-rubric"><?= __('Salvar') ?></button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal"><?= __('Cancelar') ?></button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="teamModal" tabindex="-1" role="dialog" aria-labelledby="teamModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="teamModalLabel"><?= __('Turmas'); ?></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="<?= __('Fechar'); ?>">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal"><?= __('Cancelar') ?></button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="teamNewModal" tabindex="-1" role="dialog" aria-labelledby="teamNewModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <form id="form-new-team">
        <div class="modal-header">
          <h5 class="modal-title" id="teamNewModalLabel"><?= __('Nova turma'); ?></h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="<?= __('Fechar'); ?>">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="form-group required">
            <label for="new-team-name"><?= __('Nome') ?></label>
            <input type="text" required class="form-control" id="new-team-name">
          </div>
          <div class="form-group">
            <label for="new-team-description"><?= __('Descrição') ?></label>
            <textarea rows="4" class="form-control" id="new-team-description"></textarea>
          </div>
          <div class="form-group required">
            <label for="new-team-name"><?= __('Disciplina') ?></label>
            <div class="input-group mb-3" id="list-disciplines">
              <?= $this->Form->control(
                'discipline_id',
                [
                  'label' => false,
                  'required' => true,
                  'class' => 'custom-select',
                  'id' => 'new-discipline-id',
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
            </div>
          </div>

        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-success" id="saveNewTeam"><?= __('Salvar') ?></button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal"><?= __('Cancelar') ?></button>
        </div>
      </form>
    </div>
  </div>
</div>

<div class="modal fade" id="newDisciplineModal" tabindex="-1" role="dialog" aria-labelledby="newDisciplineModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <form>
        <div class="modal-header">
          <h5 class="modal-title" id="teamModalLabel"><?= __('Nova disciplina'); ?></h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="<?= __('Fechar'); ?>">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="form-group required">
            <label for="new-discipline-name"><?= __('Nome') ?></label>
            <input type="text" required class="form-control" id="new-discipline-name">
          </div>
          <div class="form-group">
            <label for="new-discipline-description"><?= __('Descrição') ?></label>
            <textarea rows="4" class="form-control" id="new-discipline-description"></textarea>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-success" id="saveNewDiscipline"><?= __('Salvar') ?></button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal"><?= __('Cancelar') ?></button>
        </div>
      </form>
    </div>
  </div>
</div>

<?php $this->start('css'); ?>
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.0.0-alpha14/css/tempusdominus-bootstrap-4.min.css" />
<style media="screen">
.ql-editor.ql-blank::before {
  font-style: normal;
}
</style>
<?php $this->end(); ?>

<?php $this->start('script'); ?>
<script src="https://momentjs.com/downloads/moment-with-locales.min.js" charset="utf-8"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.0.0-alpha14/js/tempusdominus-bootstrap-4.min.js"></script>
<script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
<?php echo $this->Html->script('bootstrap3-typeahead.min.js'); ?>
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
      placeholder: '<?= __('Descrição da avaliação') ?>',
    });

    let editorRubric = new Quill('#editor-description-new-rubric', {
      theme: 'snow',
      modules: {
        toolbar: options
      }
    });

    editor.on('editor-change', function(eventName, ...args) {
      $('#description').val($('#editor .ql-editor').html());
    });

    editorRubric.on('editor-change', function(eventName, ...args) {
      $('#description-new-rubric').val($('#editor-description-new-rubric .ql-editor').html());
    });
  });
</script>
<script type="text/javascript">
  $(document).ready(function(){
    $.fn.datetimepicker.Constructor.Default = $.extend({}, $.fn.datetimepicker.Constructor.Default, {
            icons: {
                time: 'fas fa-clock',
                date: 'fas fa-calendar',
                up: 'fas fa-arrow-up',
                down: 'fas fa-arrow-down',
                previous: 'fas fa-chevron-left',
                next: 'fas fa-chevron-right',
                today: 'fas fa-calendar-check-o',
                clear: 'fas fa-trash',
                close: 'fas fa-times'
            } });

    $('#datestartatpicker').datetimepicker({
      locale: '<?= $locale; ?>',
      format: 'L'
    });
    $('#timestartatpicker').datetimepicker({
      locale: '<?= $locale; ?>',
      format: 'LT'
    });
    $('#dateendatpicker').datetimepicker({
      locale: '<?= $locale; ?>',
      format: 'L',
      useCurrent: false
    });
    $('#timeendatpicker').datetimepicker({
      locale: '<?= $locale; ?>',
      format: 'LT'
    });

    $("#datestartatpicker").on("change.datetimepicker", function (e) {
        $('#dateendatpicker').datetimepicker('minDate', e.date);
    });
    $("#dateendatpicker").on("change.datetimepicker", function (e) {
        $('#datestartatpicker').datetimepicker('maxDate', e.date);
    });

    $('#datestartassessmentpicker').datetimepicker({
      locale: '<?= $locale; ?>',
      format: 'L'
    });
    $('#timestartassessmentpicker').datetimepicker({
      locale: '<?= $locale; ?>',
      format: 'LT'
    });
    $('#dateendassessmentpicker').datetimepicker({
      locale: '<?= $locale; ?>',
      format: 'L',
      useCurrent: false
    });
    $('#timeendassessmentpicker').datetimepicker({
      locale: '<?= $locale; ?>',
      format: 'LT'
    });

    $("#datestartassessmentpicker").on("change.datetimepicker", function (e) {
        $('#dateendassessmentpicker').datetimepicker('minDate', e.date);
    });
    $("#dateendassessmentpicker").on("change.datetimepicker", function (e) {
        $('#datestartassessmentpicker').datetimepicker('maxDate', e.date);
    });

  });
</script>
<script type="text/javascript">
  const teamsTable = function(search = null, start = 1) {
    $('#teamModal .modal-body').html('<div class="loading text-center"><i class="fas fa-spinner fa-spin"></i></div>');
    $.ajax({
      url: '<?= $this->Url->build('/teams/teamsTable'); ?>',
      method: 'GET',
      data: {
        search: search,
        start: start
      }
    })
    .done(function(html){
      $('#teamModal .modal-body').html(html);
    })
    .fail(function(jqXHR, textStatus){
      $('#teamModal .modal-body').html(textStatus);
    });
  };

  const rubricsTable = function(search = null, start = 1) {
    $('#rubricModal .modal-body').html('<div class="loading text-center"><i class="fas fa-spinner fa-spin"></i></div>');
    $.ajax({
      url: '<?= $this->Url->build('/rubrics/rubricsTable'); ?>',
      method: 'GET',
      data: {
        search: search,
        start: start
      }
    })
    .done(function(html){
      $('#rubricModal .modal-body').html(html);
    })
    .fail(function(jqXHR, textStatus){
      $('#rubricModal .modal-body').html(textStatus);
    });
  }

  const $input = $(".typeahead");

  const appendRubric = function(id) {
    $.ajax({
      url: '<?= $this->Url->build('/rubrics/ajaxGetInfo'); ?>',
      method: 'POST',
      data: {id: id}
    })
    .done(function(html){
      $('.rubrics').append(html);
      $(".typeahead").val('');
      $('#card-rubrics > .card-header').removeClass('bg-danger text-white');
    });
  };

  const saveRubric = function(append = false) {
    $.ajax({
      url: '<?= $this->Url->build('/Rubrics/ajaxSave.json') ?>',
      data: {
        title: $('#title-new-rubric').val(),
        description: $('#description-new-rubric').val()
      },
      method: 'POST'
    })
    .done(function(data){
      if (append) {
        appendRubric(data.id);
      } else {
        rubricsTable();
      }
      $('#title-new-rubric').val('');
      $('#description-new-rubric').val('');
      $('#rubricNewModal').modal('hide');
    })

  };

</script>
<script type="text/javascript">
  $(document).ready(function(){

    $('#teamModal').on('shown.bs.modal', function () {
      teamsTable();
    });

    $('#rubricModal').on('shown.bs.modal', function () {
      rubricsTable();
    });

    $(document).on('click', '#btn-team-search', function(){
      let term = $('#team-search').val();
      teamsTable(term);
    });

    $(document).on('click', '#btn-rubric-search', function(){
      let term = $('#rubric-search').val();
      rubricsTable(term);
    });

    $(document).on('click', '.btn-team-paginate', function(){
      let start = $(this).val();
      let term = $('#team-search').val();
      teamsTable(term, start);
    });

    $(document).on('click', '.btn-rubric-paginate', function(){
      let start = $(this).val();
      let term = $('#rubric-search').val();
      rubricsTable(term, start);
    });

    $(document).on('click', '.select-team', function(){
      let id = $(this).val();
      $.ajax({
        url: '<?= $this->Url->build('/teams/selectTeam.json');  ?>',
        method: 'POST',
        data: {
          team_id: id
        }
      })
      .done(function(data){
        $('#team-name').val(data.name);
        $('#team-id').val(data.id);
        $('#teamModal').modal('hide');
      })
    });

    $(document).on('click', '.select-rubric', function(){
      let id = $(this).val();
      appendRubric(id);
      $('#rubricModal').modal('hide');
    });

    $(document).on('hide.bs.modal', '#teamNewModal', function(e){
      teamsTable();
    });

    $(document).on('submit', '#form-new-team', function(e){
      e.preventDefault();
      let name = $('#new-team-name').val();
      let description = $('#new-team-description').val();
      let discipline_id = $('#new-discipline-id').val();

      $.ajax({
        url: '<?= $this->Url->build('/teams/ajaxSave.json') ?>',
        method: 'POST',
        data: {
          name: name,
          description: description,
          discipline_id: discipline_id
        }
      })
      .done(function(data){
        $('#teamNewModal').modal('hide');
      })
      .fail(function(jqXHR, textStatus){
        console.log(textStatus);
      });
    });

    $('#bt-change-scale').on('click', function(){
      let scale = $('#scale').val();
      if (scale >= 2 && scale <= 10) {
        $.ajax({
          url: '<?= $this->Url->build('/teams/ajaxScales') ?>',
          method: 'POST',
          data: {scale: scale}
        })
        .done(function(html){
          $('.list-scales').html(html);
        });
      }
    });

    $input.typeahead({
      source: function (query, process) {
        return $.get(
          '<?= $this->Url->build('/rubrics/listRubricsAjax.json'); ?>',
          {term: query},
          function(data){
            return process(data);
          }
        )
      },
      afterSelect: function(item) {
        appendRubric(item.id);
      },
      afterEmptySelect: function(item) {
        $('#rubricNewModal').modal('show');
        $('#title-new-rubric').val($input.val());
      },
      addItem: {id: '', name: '<?= __('Nova rubrica') ?>'},
      autoSelect: false
    });

    $input.change(function() {
      var current = $input.typeahead("getActive");
      if (current) {
        if (current.name == '<?= __('Nova rubrica') ?>') {
          $('#rubricNewModal').modal('show');
        }
      }
    });

    $(document).on('click', '#btn-save-new-rubric', function(){
      let append = $('#rubricModal').hasClass('show');
      saveRubric(!append);
    });

    $(document).on('click', '.btn-remove-rubric', function(){
      $(this).closest('.rubrics-item').remove();
    });

    $('#newDisciplineModal').on('shown.bs.modal', function () {
      $('#new-discipline-name').val('');
      $('#new-discipline-description').val('');
    });

    $(document).on('click', '#saveNewDiscipline', function(e) {
      e.preventDefault();
      let name = $('#new-discipline-name').val();
      let description = $('#new-discipline-description').val();

      $.ajax({
        url: '<?= $this->Url->build('/disciplines/newAjax');  ?>',
        method: 'POST',
        data: {
          name: name,
          description: description
        }
      })
      .done(function(data){
        $('#list-disciplines').html(data);
        $('#newDisciplineModal').modal('hide');
      })
    })

  });
</script>

<script type="text/javascript">
  $(document).ready(function(){

    const validaForm = function() {
      let rubrics = $('.rubrics').html();
      if ($.trim(rubrics) === '') {
        $('#card-rubrics > .card-header').addClass('bg-danger text-white');
        $('#rubric').focus();
        alert('<?= __('Você deve informar pelo menos uma rubrica') ?>');

        return false;
      } else {
        $('#card-rubrics > .card-header').removeClass('bg-danger text-white');
      }

      let team = $('#team-id').val();
      if ($.trim(team) === '') {
        $('#team-name').addClass('is-invalid');
        let elem = $('#team-name');
        console.log(elem.offset().top);
        $('html, body').animate({scrollTop: elem.offset().top - 110}, 600, function(){
          $('#team-name').focus();
        });
        // $('#team-name').focus();
        alert('<?= __('Você deve selecionar uma turma') ?>')
        return false;
      } else {
        $('#team-name').removeClass('is-invalid');
      }

      return true;
    };

    const submitForm = function(e) {
      e.preventDefault();

      if (validaForm()) {
        $(this).off('submit', submitForm);
        $(this).submit();
      }
    };

    $('#form-add').on('submit', submitForm);

    $('form input').keydown(function (e) {
        if (e.keyCode == 13) {
            var inputs = $(this).parents("form").eq(0).find(":input");
            if (inputs[inputs.index(this) + 1] != null) {
                inputs[inputs.index(this) + 1].focus();
            }
            e.preventDefault();
            return false;
        }
    });
  });
</script>


<?php $this->end(); ?>
