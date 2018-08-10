<div class="container-fluid">
    <div class="row">
        <div class="col-10 col-md-8">
            <h2>
                <?=__('My rubrics'); ?>
            </h2>
        </div>
        <div class="col-2 col-md-4 text-right">
            <?=$this->Html->link(
                '<i class="fas fa-plus"></i> <span class="not-small">' . __('New rubric') . '</span>',
                [
                'controller' => 'Rubrics',
                'action' => 'add',
                ],
                [
                'class' => 'btn btn-success',
                'title' => __('New rubric'),
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
                                ['class' => '', 'title' => __('Edit the rubric {0}', $rubric->title)]
                            ); ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
