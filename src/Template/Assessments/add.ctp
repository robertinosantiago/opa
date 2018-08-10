<?php
/**
 * @author Robertino Mendes Santiago Junior
 */
?>
<div class="container">
    <div class="row">
        <div class="col">
        <h1><?=__('Assessment');?></h1>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <?= $this->Form->create(); ?>

            <?= $this->Form->control(
                'title',
                [
                    'label' => __('Title'),
                    'required' => true,
                    'class' => 'form-control',
                    'templates' => [
                        'inputContainer' => '<div class="form-group">{{content}}</div>'
                    ]
                ]
            ); ?>

            <div class="form-group">
              <label for="editor"><?php echo __('Description'); ?></label>
              <div id="editor"></div>
              <?php echo $this->Form->hidden('description', ['id' => 'description']) ?>
            </div>

            <?= $this->Form->control(
                'maximum_score',
                [
                    'label' => __('Maximum score (min 1 and max 100)'),
                    'required' => true,
                    'type' => 'number',
                    'min' => 1,
                    'max' => 100,
                    'class' => 'form-control',
                    'templates' => [
                        'inputContainer' => '<div class="form-group">{{content}}</div>'
                    ]
                ]
            ); ?>

            <div class="row">
              <div class="col-12 col-md-6">
                <label for="startat"><?php echo __('Start at');  ?></label>
                <div class="input-group date" id="startatpicker" data-target-input="nearest">
                    <?= $this->Form->control(
                      'startAt',
                      [
                        'label' => false,
                        'required' => true,
                        'class' => 'form-control datetimepicker-input',
                        'data-target' => '#startatpicker',
                        'templates' => [
                          'inputContainer' => '{{content}}'
                        ]
                      ]
                    ); ?>

                    <div class="input-group-append" data-target="#startatpicker" data-toggle="datetimepicker">
                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                    </div>
                </div>

              </div>
              <div class="col-12 col-md-6">
                <label for="endat"><?php echo __('End at');  ?></label>
                <div class="input-group date" id="endatpicker" data-target-input="nearest">
                    <?= $this->Form->control(
                      'endAt',
                      [
                        'label' => false,
                        'required' => true,
                        'class' => 'form-control datetimepicker-input',
                        'data-target' => '#endatpicker',
                        'templates' => [
                          'inputContainer' => '{{content}}'
                        ]
                      ]
                    ); ?>

                    <div class="input-group-append" data-target="#endatpicker" data-toggle="datetimepicker">
                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                    </div>
                </div>
              </div>
            </div>

            <?= $this->Form->control(
                'team_id',
                [
                    'label' => __('Team'),
                    'required' => true,
                    'class' => 'form-control',
                    'templates' => [
                        'inputContainer' => '<div class="form-group">{{content}}</div>'
                    ]
                ]
            ); ?>

            <?= $this->Form->control(
                'scale',
                [
                    'label' => __('Quantity of scales (min 3 and max 10)'),
                    'required' => true,
                    'class' => 'form-control',
                    'type' => 'number',
                    'min' => 3,
                    'max' => 10,
                    'templates' => [
                        'inputContainer' => '<div class="form-group">{{content}}</div>'
                    ]
                ]
            ); ?>

            <button type="submit" class="btn btn-success">
              <?php echo __('Save'); ?>
            </button>

            <?= $this->Form->end(); ?>
        </div>
    </div>
</div>

<?php $this->start('css'); ?>
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.0.0-alpha14/css/tempusdominus-bootstrap-4.min.css" />
<?php $this->end(); ?>

<?php $this->start('script'); ?>
<script src="https://momentjs.com/downloads/moment-with-locales.min.js" charset="utf-8"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.0.0-alpha14/js/tempusdominus-bootstrap-4.min.js"></script>
<script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
<script type="text/javascript">
  $(document).ready(function(){
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
      }
    });

    editor.on('editor-change', function(eventName, ...args) {
      $('#description').val($('#editor .ql-editor').html());
    });

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

    $('#startatpicker').datetimepicker({
      locale: '<?= $locale; ?>'
    });
    $('#endatpicker').datetimepicker({
      locale: '<?= $locale; ?>',
      useCurrent: false
    });

    $("#startatpicker").on("change.datetimepicker", function (e) {
        $('#endatpicker').datetimepicker('minDate', e.date);
    });
    $("#endatpicker").on("change.datetimepicker", function (e) {
        $('#startatpicker').datetimepicker('maxDate', e.date);
    });

  });
</script>
<?php $this->end(); ?>
