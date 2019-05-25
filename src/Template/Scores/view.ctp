<div class="container-fluid">
  <div class="row mb-3">
    <div class="col">
      <h2><?= __('Notas') ?>: <?= $assessment->assessment->title ?></h2>
    </div>
  </div>

  <div class="row mb-3">
    <div class="col">
        <div class="card">
          <div class="card-body">
            <div class="row mb-2">
              <div class="col-12 col-md-6">
                <label for="team" class="mb-0"><?= __('Disciplina') ?> </label>
                <input type="text" readonly class="form-control" id="team" value="<?= $assessment->assessment->team->discipline->name ?>">
              </div>
              <div class="col-12 col-md-6">
                <label for="team" class="mb-0"><?= __('Turma') ?> </label>
                <input type="text" readonly class="form-control" id="team" value="<?= $assessment->assessment->team->name ?>">
              </div>

            </div>

            <div class="row mb-2">
              <div class="col-12 col-md-3">
                <div class="form-group">
                  <label for="startAt" class="mb-0"><?= __('Início da submissão') ?></label>
                  <input type="text" readonly class="form-control" id="startAt" value="<?= $assessment->assessment->startAt->i18nFormat($dateFormat) ?>">
                </div>
              </div>
              <div class="col-12 col-md-3">
                <div class="form-group">
                  <label for="endAt" class="mb-0"><?= __('Encerramento da submissão') ?> </label>
                  <input type="text" readonly class="form-control" id="endAt" value="<?= $assessment->assessment->endAt->i18nFormat($dateFormat) ?>">
                </div>
              </div>
              <div class="col-12 col-md-3">
                <div class="form-group">
                  <label for="startassessment" class="mb-0"><?= __('Início da avaliação') ?></label>
                  <input type="text" readonly class="form-control" id="startassessment" value="<?= $assessment->assessment->start_assessment->i18nFormat($dateFormat) ?>">
                </div>
              </div>
              <div class="col-12 col-md-3">
                <div class="form-group">
                  <label for="endassessment" class="mb-0"><?= __('Encerramento da avaliação') ?> </label>
                  <input type="text" readonly class="form-control" id="endassessment" value="<?= $assessment->assessment->end_assessment->i18nFormat($dateFormat) ?>">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-12 col-md-6">
                <div class="form-group">
                  <label for="score" class="mb-0"><?= __('Nota máxima') ?> </label>
                  <input type="text" readonly class="form-control" id="score" value="<?= sprintf('%01.2f', $assessment->assessment->maximum_score) ?>">
                </div>
              </div>
              <div class="col-12 col-md-6">
                <div class="form-group">
                  <label for="score" class="mb-0"><?= __('Minha nota') ?> </label>
                  <input type="text" readonly class="form-control" id="score" value="<?= sprintf('%01.2f', $assessment->score) ?>">
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-12">
                <?php if($assessment->assessment->file): ?>
                  <a class="btn btn-info" title="<?= __('Baixar anexo'); ?>" href="<?= $this->Url->build(['controller' => 'Assessments', 'action' => 'getFile', $assessment->assessment->file]); ?>">
                    <i class="fas fa-download"></i> <?= __('Baixar anexo') ?>
                  </a>
                <?php endif; ?>
              </div>
            </div>
          </div>
        </div>
    </div>
  </div>

  <div class="row mb-3">
    <div class="col">
      <div class="card">
        <div class="card-header">
          <?= __('Sua atividade') ?>
        </div>
        <div class="card-body">
          <?php if($assessment->file): ?>
            <div class="row mb-3">
              <div class="col">
                <a class="btn btn-info" title="<?= __('Baixar anexo'); ?>" href="<?= $this->Url->build(['controller' => 'Assessments', 'action' => 'getFile', $assessment->file]); ?>">
                  <i class="fas fa-download"></i> <?= __('Baixar anexo') ?>
                </a>
              </div>
            </div>
          <?php endif; ?>
          <div class="row mb-3">
            <div class="col text-justify">
              <?= $assessment->document_text ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="row mb-3">
    <div class="col">
      <div class="card">
        <div class="card-header">
          <?= __('Avaliação dos Pares Avaliadores') ?>
        </div>
        <div class="card-body">
          <?php foreach ($peers as $i => $peer): ?>
          <div class="card mb-2">
            <div class="card-header">
              <?= __('Avaliador:') ?> <?= $i+1 ?>
            </div>
            <div class="card-body">
              <?php if (empty($peer->assessment_peers)): ?>
                <p><?= __('Este avaliador não submeteu sua avaliação') ?></p>
              <?php else: ?>
                <?php foreach ($peer->assessment_peers as $ap): ?>
                  <div class="row">
                    <div class="col">
                      <strong><?= __('Nota do avaliador') ?>:</strong> <?= sprintf('%01.2f', $ap->score) ?>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col">
                      <strong><?= __('Comentários') ?>:</strong> <?= $ap->comments ?>
                    </div>
                  </div>
                  <?php if (!empty($ap->assessment_peer_rubrics)): ?>
                    <div class="row border-bottom">
                      <div class="col-4">
                        <?= __('Rubrica') ?>
                      </div>
                      <div class="col-2 text-center">
                        <?= __('Peso') ?>
                      </div>
                      <div class="col-3 text-center">
                        <?= __('Nota') ?>
                      </div>
                      <div class="col-3">
                        <?= __('Comentários') ?>
                      </div>
                    </div>
                    <?php foreach ($ap->assessment_peer_rubrics as $apr): ?>
                      <div class="row py-2 list-rubrics">
                        <div class="col-12 col-md-4">
                          <strong><?= $apr->rubric->title; ?></strong>
                          <small><?= $apr->rubric->description ?></small>
                        </div>
                        <div class="col-6 col-md-2 text-center">
                          <?= $apr->weight; ?>
                        </div>
                        <div class="col-6 col-md-3 text-center">
                          <?= $apr->label ?>
                        </div>
                        <div class="col-12 col-md-3 text-justify">
                          <?= $apr->comments ?>
                        </div>
                      </div>
                    <?php endforeach; ?>
                  <?php endif; ?>
                <?php endforeach; ?>
              <?php endif; ?>
            </div>
          </div>
          <?php endforeach; ?>
        </div>
      </div>
    </div>
  </div>

</div>
