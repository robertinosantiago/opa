<div class="container-fluid">
  <div class="row mb-3">
    <div class="col">
      <h2><?= __('Notas') ?></h2>
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
          </div>
        </div>
    </div>
  </div>
  <div class="card mb-3">
    <div class="card-header">
      <?= __('Participantes') ?>
    </div>
    <div class="card-body">
      <table class="table table-striped table-hover">
        <thead>
          <tr>
            <th><?= __('Nome') ?></th>
            <th class="text-center"><?= __('Nota') ?></th>
            <th><?= __('Observação') ?></th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($assessment->assessment_users as $au): ?>
            <tr>
              <td>
                <a href="#" class="viewAssessment" data-assessment="<?= $assessment->id ?>" data-user="<?= $au->user->id ?>">
                  <?= $au->user->first_name ?> <?= $au->user->last_name ?></td>
                </a>
              <td class="text-center"><?= sprintf("%.2f", $au->score) ?></td>
              <td>
                <?= $au->from_teacher == 0 ? '' : __('Atividade não enviada') ?>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<div class="modal fade" id="assessmentModal" tabindex="-1" role="dialog" aria-labelledby="assessmentModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="assessmentModalLabel">
          <?= __('Avaliação') ?>
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
    $('.viewAssessment').on('click', function(e) {
      e.preventDefault();
      const $assessment_id = $(this).data('assessment');
      const $user_id = $(this).data('user');

      $.ajax({
        url: '<?= $this->Url->build('/assessments/viewAssessmentUser') ?>',
        method: 'POST',
        data: {
          assessment_id: $assessment_id,
          user_id: $user_id
        }
      })
      .done(function(html) {
        $('#assessmentModal .modal-body').html(html);
        $('#assessmentModal').modal('show');
      });
    });

});
</script>
<?php $this->end(); ?>
