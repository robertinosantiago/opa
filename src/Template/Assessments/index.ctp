<div class="container-fluid">
    <div class="row">
        <div class="col-10 col-md-8">
            <h2>
                <?=__('Minhas avaliações'); ?>
            </h2>
        </div>
        <div class="col-2 col-md-4 text-right">
            <?=$this->Html->link(
                '<i class="fas fa-plus"></i> <span class="not-small">' . __('Nova avaliação') . '</span>',
                [
                'controller' => 'Assessments',
                'action' => 'add',
                ],
                [
                'class' => 'btn btn-success',
                'title' => __('Nova avaliação'),
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
                    <?php foreach ($assessments as $assessment): ?>
                    <tr>
                        <td>
                            <?=$this->Html->link(
                                $assessment->title,
                                ['controller' => 'Assessments', 'action' => 'controls', $assessment->id],
                                ['class' => '', 'title' => __('Editar a avaliação {0}', $assessment->name)]
                            ); ?>
                            <?php if($assessment->status == 'preparation'): ?>
                              <span class="badge badge-success"><?= __('Em preparação') ?></span>
                            <?php elseif($assessment->status == 'open'): ?>
                              <span class="badge badge-warning"><?= __('Aberto') ?></span>
                            <?php else: ?>
                              <span class="badge badge-danger"><?= __('Encerrado') ?></span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?= $assessment->team->name ?>: <?= $assessment->team->discipline->name ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
