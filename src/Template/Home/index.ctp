<div class="container-fluid">
    <div class="row">
        <div class="col">
            <h1>Home</h1>
        </div>
    </div>
    <?php // Início da exibição dos convites recebidos para participar de turmas ?>
    <?php if ($invites): ?>
      <div class="row">
        <div class="col">
          <div class="card">
            <div class="card-header">
              <h3><?= __('Convites recebidos para ingressar em turmas') ?></h3>
            </div>
            <div class="card-body">
              <table class="table table-striped table-hover">
                <tbody>
                  <?php foreach ($invites as $invite): ?>
                    <tr>
                      <td><?= $invite->Teams['name'] ?> [ <?= $invite->Disciplines['name'] ?> ]</td>
                      <td class="text-right">
                        <?=$this->Html->link(
                        '<i class="fas fa-check"></i> <span class="not-small">' . __('Aceitar') . '</span>',
                        [
                           'controller' => 'Teams',
                           'action' => 'confirm_invite',
                           $invite->hash,
                        ],
                        [
                           'class' => 'btn btn-sm btn-success',
                           'title' => __('Aceitar convite'),
                           'escape' => false,
                        ]
                        ); ?>
                      </td>
                    </tr>

                  <?php endforeach; ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    <?php endif; ?>
    <?php // Fim da exibição dos convites recebidos para participar de turmas ?>

</div>
