<div class="container-fluid">
  <div class="row">
    <div class="col">
      <h2><?= __('Minhas notas') ?></h2>
    </div>
  </div>

  <div class="row">
    <div class="col">
      <table class="table table-striped table-hover">
        <tbody>
          <?php foreach ($assessments as $assessment): ?>
          <tr>
            <td>
              <?= $this->Html->link(
                  $assessment->Assessments['title'],
                  ['controller' => 'Scores', 'action' => 'view', $assessment->Assessments['id']],
                  ['class' => '', 'title' => __('Visualizar a avaliação')]
              ); ?>
            </td>
            <td style="width: 65px">
              <?= $this->Html->link(
                  sprintf('%01.2f', preg_replace('/(\.\d\d).*/', '$1', $assessment->score)),
                  ['controller' => 'Scores', 'action' => 'view', $assessment->Assessments['id']],
                  ['class' => '', 'title' => __('Visualizar a avaliação')]
              ); ?>
            </td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
