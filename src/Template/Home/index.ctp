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
          <div class="card mb-2">
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

    <?php // Início da exibição das avaliações a serem respondidas ?>
    <?php if ($assessments): ?>
      <div class="row">
        <div class="col">
          <div class="card mb-2">
            <div class="card-header">
              <h3><?= __('Avaliações pendentes para responder') ?></h3>
            </div>
            <div class="card-body">
              <table class="table table-striped table-hover">
                <tbody>
                  <?php foreach ($assessments as $assessment): ?>
                    <tr>
                      <td>
                        <strong><?= $assessment->title ?></strong><br>
                        <?= $assessment->Teams['name'] ?> [ <?= $assessment->Disciplines['name'] ?> ] <br>
                        <?= __('De') ?>: <?= $assessment->startAt->i18nFormat($dateFormat) ?> - <?= __('Até') ?>: <?= $assessment->endAt->i18nFormat($dateFormat) ?>
                      </td>
                      <td class="text-right">
                        <?=$this->Html->link(
                        '<i class="fas fa-user-check"></i> <span class="not-small">' . __('Enviar') . '</span>',
                        [
                           'controller' => 'Assessments',
                           'action' => 'submit',
                           $assessment->id,
                        ],
                        [
                           'class' => 'btn btn-sm btn-success',
                           'title' => __('Enviar avaliação'),
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
    <?php // Fim da exibição das avaliações a serem respondidas ?>

    <?php // Início da exibição das submissões a serem avaliadas ?>
    <?php if ($appraisers): ?>
      <div class="row">
        <div class="col">
          <div class="card mb-2">
            <div class="card-header">
              <h3><?= __('Submissões pendentes para avaliar') ?></h3>
            </div>
            <div class="card-body">
              <table class="table table-striped table-hover">
                <tbody>
                  <?php foreach ($appraisers as $assessment): ?>
                    <tr>
                      <td>
                        <?= __('Submissão') ?> : <?= $assessment->AssessmentUsers['id'] ?> <br>
                        <strong><?= $assessment->title ?></strong><br>
                        <?= $assessment->Teams['name'] ?> [ <?= $assessment->Disciplines['name'] ?> ] <br>
                        <?= __('De') ?>: <?= $assessment->start_assessment->i18nFormat($dateFormat) ?> - <?= __('Até') ?>: <?= $assessment->end_assessment->i18nFormat($dateFormat) ?>
                      </td>
                      <td class="text-right">
                        <?=$this->Html->link(
                        '<i class="fas fa-user-check"></i> <span class="not-small">' . __('Avaliar') . '</span>',
                        [
                           'controller' => 'Assessments',
                           'action' => 'appraiser',
                           $assessment->AssessmentUsers['id'],
                        ],
                        [
                           'class' => 'btn btn-sm btn-success',
                           'title' => __('Avaliar submissão'),
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

    <?php // Fim da exibição das submissões a serem avaliadas ?>

</div>
