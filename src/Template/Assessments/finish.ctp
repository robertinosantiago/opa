<div class="container-fluid">
  <div class="row mb-3">
    <div class="col">
      <h2><?= __('Encerrar avaliação') ?></h2>
    </div>
  </div>
  <div class="row mb-3">
    <div class="col">
        <div class="card">
          <div class="card-body">
            <div class="row mb-2">
              <div class="col-12 col-md-6">
                <label for="team" class="mb-0"><?= __('Disciplina') ?> </label>
                <input type="text" readonly class="form-control" id="team" value="<?= $assessment->team->discipline->name ?>">
              </div>
              <div class="col-12 col-md-4">
                <label for="team" class="mb-0"><?= __('Turma') ?> </label>
                <input type="text" readonly class="form-control" id="team" value="<?= $assessment->team->name ?>">
              </div>
              <div class="col-12 col-md-2">
                <div class="form-group">
                  <label for="score" class="mb-0"><?= __('Nota máxima') ?> </label>
                  <input type="text" readonly class="form-control" id="score" value="<?= $assessment->maximum_score ?>">
                </div>
              </div>
            </div>

            <div class="row mb-2">
              <div class="col-12 col-md-3">
                <div class="form-group">
                  <label for="startAt" class="mb-0"><?= __('Início da submissão') ?></label>
                  <input type="text" readonly class="form-control" id="startAt" value="<?= $assessment->startAt->i18nFormat($dateFormat) ?>">
                </div>
              </div>
              <div class="col-12 col-md-3">
                <div class="form-group">
                  <label for="endAt" class="mb-0"><?= __('Encerramento da submissão') ?> </label>
                  <input type="text" readonly class="form-control" id="endAt" value="<?= $assessment->endAt->i18nFormat($dateFormat) ?>">
                </div>
              </div>
              <div class="col-12 col-md-3">
                <div class="form-group">
                  <label for="startassessment" class="mb-0"><?= __('Início da avaliação') ?></label>
                  <input type="text" readonly class="form-control" id="startassessment" value="<?= $assessment->start_assessment->i18nFormat($dateFormat) ?>">
                </div>
              </div>
              <div class="col-12 col-md-3">
                <div class="form-group">
                  <label for="endassessment" class="mb-0"><?= __('Encerramento da avaliação') ?> </label>
                  <input type="text" readonly class="form-control" id="endassessment" value="<?= $assessment->end_assessment->i18nFormat($dateFormat) ?>">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-12">
                <?php if($assessment->file): ?>
                  <a class="btn btn-info" title="<?= __('Baixar anexo'); ?>" href="<?= $this->Url->build(['controller' => 'Assessments', 'action' => 'getFile', $assessment->file]); ?>">
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
          <?= __('Participantes') ?>
        </div>
        <div class="card-body">
          <?php if (empty($assessment->team->team_users)): ?>
            <?= __('Não há pares ou avaliações submitidas') ?>
          <?php else: ?>
          <?= $this->Form->create(null, ['id' => 'form-finish']); ?>
          <table class="table table-hover table-striped">
            <thead>
              <tr>
                <th><?= __('Par avaliado') ?></th>
                <th><?= __('Nota obtida') ?></th>
                <th><?= __('Par(es) avaliador(es) e Notas') ?></th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($assessment->team->team_users as $teamUser): ?>
                <tr>
                  <td>
                    <?php if ($teamUser->assessment_user == null): ?>
                      <?= $teamUser->user->first_name ?> <?= $teamUser->user->last_name ?>
                    <?php else: ?>
                      <a href="#" class="viewSubmit" data-submit="<?= $teamUser->assessment_user->id ?>">
                        <?= $teamUser->user->first_name ?> <?= $teamUser->user->last_name ?>
                      </a>
                    <?php endif; ?>
                  </td>
                  <td>
                    <div class="form-group">
                      <?php
                      $msg = null;
                      $score = null;
                      ?>
                      <?php if ($teamUser->assessment_user == null): ?>
                        <?php $msg = __('Não submeteu a atividade') ?>
                      <?php elseif(empty($teamUser->assessment_user->peers)): ?>
                        <?php $msg = __('Não foi avaliado') ?>
                      <?php else: ?>
                        <?php $score = $teamUser->assessment_user->score ?>
                      <?php endif; ?>
                      <?php $score = preg_replace('/(\.\d\d).*/', '$1', $score); ?>
                      <input required class="form-control" type="number" name="score[]" min="0" max="<?= $assessment->maximum_score ?>" step="0.1" value="<?= ($score != null ? sprintf('%01.2f', $score) : '') ?>">
                      <?= $this->Form->hidden('AssessmentUsers.id[]', ['value' => ($teamUser->assessment_user == null ? '' : $teamUser->assessment_user->id)]); ?>
                      <?= $this->Form->hidden('Users.id[]', ['value' => $teamUser->user->id]); ?>
                      <?php if ($msg != null): ?>
                        <small class="form-text text-muted"><?= $msg ?></small>
                      <?php endif; ?>
                    </div>
                  </td>
                  <td>
                    <?php if ($teamUser->assessment_user != null && !empty($teamUser->assessment_user->peers)):?>
                      <table class="table table-striped table-hover table-sm">
                        <?php foreach ($teamUser->assessment_user->peers as $peer): ?>
                          <?php foreach ($peer->assessment_peers as $ap): ?>
                            <tr>
                              <td>
                                <a href="#" class="viewAppraiser" data-appraiser="<?= $ap->id ?>">
                                  <?= $peer->user->first_name ?> <?= $peer->user->last_name ?>
                                </a>
                              </td>
                              <td>
                                <a href="#" class="viewAppraiser" data-appraiser="<?= $ap->id ?>">
                                  <?= $ap->score ?>
                                </a>
                              </td>
                            </tr>
                          <?php endforeach; ?>
                        <?php endforeach; ?>
                      </table>
                    <?php else: ?>
                      <?= $msg ?>
                    <?php endif; ?>
                  </td>
                </tr>
              <?php endforeach; ?>
            </tbody>
            <tfoot>
              <tr>
                <td colspan="3">
                  <?= $this->Form->hidden('Assessment.id', ['value' => $assessment->id]) ?>
                  <button type="submit" class="btn btn-success">
                    <i class="fas fa-save"></i> <?= __('Encerrar e publicar notas') ?>
                  </button>
                </td>
              </tr>
            </tfoot>
          </table>
          <?= $this->Form->end(); ?>
        <?php endif; ?>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="submitModal" tabindex="-1" role="dialog" aria-labelledby="submitModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="submitModalLabel">
          <?= __('Submissão do par avaliado') ?>
        </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="<?= __('Fechar') ?>">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">
          <i class="fas fa-sign-out-alt"></i>
          <?= __('Fechar') ?>
        </button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="appraiserModal" tabindex="-1" role="dialog" aria-labelledby="appraiserModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="appraiserModalLabel">
          <?= __('Avaliação do par avaliador') ?>
        </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="<?= __('Fechar') ?>">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">
          <i class="fas fa-sign-out-alt"></i>
          <?= __('Fechar') ?>
        </button>
      </div>
    </div>
  </div>
</div>

<?php $this->start('script'); ?>
<script type="text/javascript">
$(document).ready(function(){
    $('.viewSubmit').on('click', function(e) {
      e.preventDefault();
      const $id = $(this).data('submit');

      $.ajax({
        url: '<?= $this->Url->build('/assessments/viewSubmit') ?>',
        method: 'POST',
        data: {
          id: $id
        }
      })
      .done(function(html) {
        $('#submitModal .modal-body').html(html);
        $('#submitModal').modal('show');
      });
    });

    $('.viewAppraiser').on('click', function(e) {
      e.preventDefault();
      const $id = $(this).data('appraiser');

      $.ajax({
        url: '<?= $this->Url->build('/assessments/viewAppraiser') ?>',
        method: 'POST',
        data: {
          id: $id
        }
      })
      .done(function(html) {
        $('#appraiserModal .modal-body').html(html);
        $('#appraiserModal').modal('show');
      });
    });
});
</script>
<?php $this->end(); ?>
