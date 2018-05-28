<?php
/**
 * @author Robertino Mendes Santiago Junior
 */
?>
<div class="container">
    <div class="row">
        <div class="col">
        <h1><?=__('Discipline');?></h1>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <?= $this->Form->create($discipline); ?>
            <?= $this->Form->control(
                'name', 
                [
                    'label' => __('Name'), 
                    'required' => true, 
                    'class' => 'form-control', 
                    'templates' => [
                        'inputContainer' => '<div class="form-group">{{content}}</div>'
                    ]
                ]
            ); ?>
            <?= $this->Form->control(
                'description', 
                [
                    'label' => __('Description'), 
                    'required' => true, 
                    'class' => 'form-control',
                    'type' => 'textarea',
                    'row' => '5',
                    'templates' => [
                        'inputContainer' => '<div class="form-group">{{content}}</div>'
                    ]
                ]
            ); ?>
            <?= $this->Form->hidden('id'); ?>
            <?= $this->Form->button(
                __('Save'), 
                [
                    'class' => 'btn btn-success btn-block text-light btn-login'
                ]
            ); ?>
            <?= $this->Form->end(); ?>
        </div>
    </div>
</div>
