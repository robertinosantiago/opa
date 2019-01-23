<div class="container-fluid">
    <div class="row">
        <div class="col-10 col-md-8">
            <h2>
                <?=__('Turmas da disciplina'); ?> <?= $discipline->name; ?>
            </h2>
        </div>
        <div class="col-2 col-md-4 text-right">
            <?=$this->Html->link(
                '<i class="fas fa-plus"></i> <span class="not-small">' . __('Nova turma') . '</span>',
                [
                'controller' => 'Teams',
                'action' => 'add',
                $discipline->id
                ],
                [
                'class' => 'btn btn-success',
                'title' => __('Nova turma'),
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
                    <?php foreach ($teams as $team): ?>
                    <tr>
                        <td>
                            <?=$this->Html->link(
                                $team->name,
                                ['controller' => 'Teams', 'action' => 'controls', $team->id],
                                ['class' => '', 'title' => __('Editar a turma')]
                            ); ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
