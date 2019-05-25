<div class="container-fluid">
  <?php if ($assessmentUser->from_teacher): ?>
    <div class="row mb-2">
      <div class="col">
        <p><strong><?= __('Atividade não enviada') ?></strong></p>
        <p><?= __('Nota atribuída pelo professor') ?></p>
      </div>
    </div>
  <?php else: ?>
    <div class="row mb-2">
      <div class="col">
        <div class="card">
          <div class="card-header">
            <?= __('Avaliação submetida') ?>
          </div>
          <div class="card-body">
            <?php if ($assessmentUser->document_text): ?>
              <div class="row">
                <div class="col">
                  <?= $assessmentUser->document_text ?>
                </div>
              </div>
            <?php endif; ?>
            <?php if($assessmentUser->file): ?>
              <div class="row">
                <div class="col">
                  <a class="btn btn-info" title="<?= __('Baixar arquivo'); ?>" href="<?= $this->Url->build(['controller' => 'Assessments', 'action' => 'getFile', $assessmentUser->file]); ?>">
                    <i class="fas fa-download"></i> <?= __('Baixar arquivo') ?>
                  </a>
                </div>
              </div>
            <?php endif; ?>
          </div>
        </div>
      </div>
    </div>
    <div class="row mb-2">
      <div class="col">
        <?php $labels = json_decode($assessmentUser->assessment->labels); ?>
        <?php foreach ($peers as $peer): ?>
          <div class="card mb-2">
            <div class="card-header">
              <?= __('Par avaliador ') ?>: <?= $peer->user->first_name . ' ' . $peer->user->last_name ?>
            </div>
            <div class="card-body">
              <?php $score = 0; $totalWeight = 0; ?>
              <?php foreach ($peer->assessment_peers as $ap): ?>

                <table class="table table-hover table-striped table-sm">
                  <thead>
                    <tr>
                      <th><?= __('Rubrica') ?></th>
                      <th><?= __('Peso') ?></th>
                      <th><?= __('Escala') ?></th>
                      <th><?= __('Comentários') ?></th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php foreach ($ap->assessment_peer_rubrics as $apr): ?>
                      <tr>
                        <td>
                          <strong><?= $apr->rubric->title; ?></strong>
                          <small><?= $apr->rubric->description ?></small>
                        </td>
                        <td class="text-center"><?= $apr->weight ?></td>
                        <td class="text-center">
                          <?= $apr->label ?><br>
                          <small>(<?= $apr->score ?>)</small>
                        </td>
                        <td><?= $apr->comments ?></td>
                      </tr>
                      <?php $score += ($apr->weight * $apr->score); $totalWeight += $apr->weight; ?>
                    <?php endforeach; ?>
                  </tbody>
                </table>
                <?php // TODO: trocar por $ap->score ?>
                <?php $score = ($score/$totalWeight)*$assessmentUser->assessment->maximum_score; ?>
                <p><strong><?= __('Nota') ?>:</strong> <?= sprintf('%01.2f', preg_replace('/(\.\d\d).*/', '$1', $score)) ?></p>
                <p><strong><?= __('Comentários') ?>:</strong> <?= $ap->comments; ?></p>
              <?php endforeach; ?>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  <?php endif; ?>
</div>
