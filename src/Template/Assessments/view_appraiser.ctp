<div class="card mb-3">
  <div class="card-header">
    <?= __('Rubricas') ?>
  </div>
  <div class="card-body">
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
        <?php foreach ($assessmentPeer->assessment_peer_rubrics as $apr): ?>
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
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>

<div class="card mb-3">
  <div class="card-header">
    <?= __('Comentários') ?>
  </div>
  <div class="card-body">
    <?= $assessmentPeer->comments ?>
  </div>
</div>

<div class="row mb-3">
  <div class="col">
    <div class="row">
      <div class="col">
        <small><?= __('Avaliado em') ?>:</small>
      </div>
    </div>
    <div class="row">
      <div class="col">
        <small><?= $assessmentPeer->modified->i18nFormat($dateFormat) ?></small>
      </div>
    </div>
  </div>
</div>
