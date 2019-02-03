<?php
    /**
     * @author Robertino Mendes Santiago Junior
     */
?>
<div class="container">
    <div class="row">
        <div class="col">
            <h1><?php echo __('Disciplina'); ?></h1>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <?php
                echo $this->Form->create($discipline);
            ?>
            <?php
                echo $this->Form->control(
                    'name',
                    [
                        'label' => __('Nome'),
                        'required' => true,
                        'class' => 'form-control',
                        'templates' => [
                            'inputContainer' => '<div class="form-group required">{{content}}</div>',
                        ],
                    ]
                );
            ?>
<?php echo $this->Form->control(
        'description',
        [
            'label' => __('Descrição'),
            'required' => true,
            'class' => 'form-control',
            'type' => 'textarea',
            'row' => '5',
            'templates' => [
                'inputContainer' => '<div class="form-group">{{content}}</div>',
            ],
        ]
); ?>
<?php echo $this->Form->hidden('id'); ?>
<?php echo $this->Form->button(
        __('Salvar'),
        [
            'class' => 'btn btn-success btn-block text-light btn-login',
        ]
); ?>
<?php echo $this->Form->end(); ?>
        </div>
    </div>
</div>
