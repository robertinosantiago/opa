<?php
/**
 * @author Robertino Mendes Santiago Junior
 */
?>
<div class="container">
    <div class="row">
        <div class="col">
        <h1><?=__('Disciplina');?></h1>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <?= $this->Form->create(); ?>
            <?= $this->Form->control(
                'name',
                [
                    'label' => __('Nome'),
                    'required' => true,
                    'class' => 'form-control',
                    'templates' => [
                        'inputContainer' => '<div class="form-group">{{content}}</div>'
                    ]
                ]
            ); ?>

            <div class="form-group">
              <label for="editor"><?php echo __('Descrição'); ?></label>
              <div id="editor"></div>
              <?php echo $this->Form->hidden('description', ['id' => 'description']) ?>
            </div>

            <button type="submit" class="btn btn-success">
              <?php echo __('Salvar'); ?>
            </button>

            <?= $this->Form->end(); ?>
        </div>
    </div>
</div>

<?php $this->start('css'); ?>
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
<?php $this->end(); ?>

<?php $this->start('script'); ?>
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

  });
</script>
<?php $this->end(); ?>
