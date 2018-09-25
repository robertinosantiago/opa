<div class="container-fluid">
    <div class="row">
        <div class="col-10 col-md-8">
            <h2>
                <?=__('Minhas disciplinas'); ?>
            </h2>
        </div>
        <div class="col-2 col-md-4 text-right">
            <?=$this->Html->link(
                '<i class="fas fa-plus"></i> <span class="not-small">' . __('Nova disciplina') . '</span>',
                [
                'controller' => 'Disciplines',
                'action' => 'add',
                ],
                [
                'class' => 'btn btn-success',
                'title' => __('Nova disciplina'),
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
                    <?php foreach ($disciplines as $discipline): ?>
                    <tr>
                        <td>
                            <?=$this->Html->link(
                                $discipline->name,
                                ['controller' => 'Disciplines', 'action' => 'controls', $discipline->id],
                                ['class' => '', 'title' => __('Editar a disciplina {0}', $discipline->name)]
                            ); ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
