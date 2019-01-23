<div class="container-fluid">
    <div class="row">
        <div class="col-10 col-md-8">
            <h2>
                <?=__('Minhas rubricas'); ?>
            </h2>
        </div>
        <div class="col-2 col-md-4 text-right">
            <?=$this->Html->link(
                '<i class="fas fa-plus"></i> <span class="not-small">' . __('Nova rubrica') . '</span>',
                [
                'controller' => 'Rubrics',
                'action' => 'add',
                ],
                [
                'class' => 'btn btn-success',
                'title' => __('Nova rubrica'),
                'escape' => false,
                ]
                ); ?>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <table class="table table-striped table-hover">
                <tfoot>
                    <tr>
                        <td colspan="6"></td>
                    </tr>
                </tfoot>
                <tbody>
                    <?php foreach ($rubrics as $rubric): ?>
                    <tr>
                        <td>
                            <?=$this->Html->link(
                                $rubric->title,
                                ['controller' => 'Rubrics', 'action' => 'controls', $rubric->id],
                                ['class' => '', 'title' => __('Editar a rubrica')]
                            ); ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
