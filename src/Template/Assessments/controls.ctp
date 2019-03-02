<div class="container-fluid">

  <div class="row">
    <div class="col-12 col-md-12 col-lg-7">
      <h2>
        <?=$assessment->title; ?>
        <?php if($assessment->status == 'preparation'): ?>
          <small><span class="badge badge-success"><?= __('Em preparação') ?></span></small>
        <?php elseif($assessment->status == 'open'): ?>
          <small><span class="badge badge-warning"><?= __('Aberto') ?></span></small>
        <?php else: ?>
          <small><span class="badge badge-danger"><?= __('Encerrado') ?></span></small>
        <?php endif; ?>
      </h2>
    </div>
    <div class="col-12 col-md-12 col-lg-5 text-right">

    <?php if ($assessment->status == 'open' && count($assessment->assessment_rubrics) != 0): ?>
      <?=$this->Html->link(
        '<i class="fas fa-user-friends"></i> ' . __('Atribuir pares'),
        [
          'controller' => 'Assessments',
          'action' => 'peers',
          $assessment->id,
        ],
        [
          'class' => 'btn btn-sm btn-info',
          'title' => __('Atribuir pares avaliadores'),
          'escape' => false,
        ]
      ); ?>
      <button class="btn btn-sm btn-success" disabled><i class="fas fa-share-square"></i> <?= __('Publicar'); ?></button>
      <button class="btn btn-sm btn-warning" disabled><i class="fas fa-pencil-alt"></i> <?= __('Editar'); ?></button>
      <button class="btn btn-sm btn-danger" disabled><i class="fas fa-trash-alt"></i> <?= __('Excluir'); ?></button>
    <?php endif; ?>

    <?php if ($assessment->status == 'preparation'): ?>
      <button class="btn btn-sm btn-info" disabled><i class="fas fa-user-friends"></i> <?= __('Atribuir pares'); ?></button>
      <?php if (count($assessment->assessment_rubrics) != 0): ?>
        <?=$this->Form->postLink(
          '<i class="fas fa-share-square"></i> ' . __('Publicar'),
          [
            'controller' => 'Assessments',
            'action' => 'publish',
            $assessment->id,
          ],
          [
            'class' => 'btn btn-sm btn-success',
            'title' => __('Publicar a avaliação'),
            'confirm' => __('Você tem certeza?'),
            'method' => 'post',
            'escape' => false,
          ]
        ); ?>
      <?php else: ?>
        <button class="btn btn-sm btn-success" disabled><i class="fas fa-share-square"></i> <?= __('Publicar'); ?></button>
      <?php endif; ?>
      <?=$this->Html->link(
        '<i class="fas fa-pencil-alt"></i> ' . __('Editar'),
        [
          'controller' => 'Assessments',
          'action' => 'edit',
          $assessment->id,
        ],
        [
          'class' => 'btn btn-sm btn-warning',
          'title' => __('Editar avaliação'),
          'escape' => false,
        ]
      ); ?>
      <?=$this->Form->postLink(
        '<i class="fas fa-trash-alt"></i> ' . __('Excluir'),
        [
          'controller' => 'Assessments',
          'action' => 'delete',
          $assessment->id,
        ],
        [
          'class' => 'btn btn-sm btn-danger',
          'title' => __('Excluir avaliação'),
          'confirm' => __('Você tem certeza?'),
          'method' => 'delete',
          'escape' => false,
        ]
      ); ?>
    <?php endif; ?>
    </div>
  </div>

  <div class="row py-3">
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
    <div class="col-12">
      <div class="card">
        <div class="card-header">
          <div class="row">
            <div class="col-8">
              <?= __('Escalas')  ?>: <?= $assessment->scale ?>
            </div>
            <div class="col-4 text-right">
              <?php if ($assessment->status == 'preparation'): ?>
                <button title="<?= __('Alterar') ?>" class="btn btn-sm btn-secondary"  type="button" data-toggle="modal" data-target="#modalChangeScales">
                  <i class="fas fa-pencil-alt"></i>
                  <?= __('Alterar') ?>
                </button>
              <?php endif; ?>
            </div>
          </div>
        </div>
        <div class="card-body">
          <div class="row mb-3">
            <div class="col-12 text-center">
              <?= __('Menor') ?> <i class="fas fa-arrow-right"></i> <?= __('Maior') ?>
            </div>
          </div>
          <div class="row">
            <div class="col-12">
              <ul class="likert">
                <?php foreach(json_decode($assessment->labels) as $index => $label): ?>
                  <li>
                    <span><i class="fas fa-circle"></i></span>

                    <span><?= $label ?></span>
                  </li>
                <?php endforeach; ?>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header">
          <div class="row">
            <div class="col-8">
              <?= __('Rubricas')  ?>
            </div>
            <div class="col-4 text-right">
              <?php if ($assessment->status == 'preparation'): ?>
                <button class="btn btn-sm btn-secondary" type="button" data-toggle="modal" data-target="#modalAddRubric">
                  <i class="fas fa-plus"></i>
                  <?= __('Adicionar') ?>
                </button>
              <?php endif; ?>
            </div>
          </div>
        </div>
        <div class="card-body">
          <?php if ($assessment->assessment_rubrics): ?>
            <div class="row border-bottom">
              <div class="col-8">
                <?= __('Rubrica') ?>
              </div>
              <div class="col-2 text-center">
                <?= __('Peso') ?>
              </div>
              <div class="col-2">

              </div>
            </div>
          <?php endif; ?>
          <?php foreach($assessment->assessment_rubrics as $ar): ?>
            <div class="row py-2 list-rubrics">
              <div class="col-12 col-md-8">
                <strong><?= $ar->rubric->title; ?></strong>
                <small><?= $ar->rubric->description ?></small>
              </div>
              <div class="col-6 col-md-2 text-center">
                <?= $ar->weight; ?>
              </div>
              <div class="col-6 col-md-2 text-right">
                <?php if ($assessment->status == 'preparation'): ?>
                  <?=$this->Form->postLink(
                    '<i class="fas fa-trash-alt"></i> ' . __('Remover'),
                    [
                      'controller' => 'Assessments',
                      'action' => 'removeRubric',
                      $ar->id,
                    ],
                    [
                      'class' => 'btn btn-sm btn-danger',
                      'title' => __('Excluir rubrica'),
                      'confirm' => __('Você tem certeza?'),
                      'method' => 'delete',
                      'escape' => false,
                    ]
                  ); ?>
                <?php endif; ?>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
      </div>
    </div>

  </div>
</div>

<div class="modal" tabindex="-1" role="dialog" id="modalAddRubric">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <?= $this->Form->create(null, ['url' => ['controller' => 'Assessments', 'action' => 'addRubric']]); ?>
      <div class="modal-header">
        <h5 class="modal-title"><?= __('Selecione uma rubrica') ?></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="<?= __('Fechar') ?>">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <?= $this->Form->control(
            'rubric',
            [
                'label' => __('Rubrica'),
                'required' => true,
                'options' => $rubrics,
                'class' => 'form-control',
                'templates' => [
                    'inputContainer' => '<div class="form-group">{{content}}</div>'
                ]
            ]
        ); ?>
        <?= $this->Form->control(
          'weight',
          [
            'label' => __('Peso'),
            'required' => true,
            'type' => 'number',
            'class' => 'form-control',
            'templates' => [
              'inputContainer' => '<div class="form-group">{{content}}</div>'
            ]
          ]
        ); ?>
        <?= $this->Form->hidden('assessment_id', ['value' => $assessment->id]); ?>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-success"><?= __('Adicionar') ?></button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal"><?= __('Cancelar') ?></button>
      </div>
      <?= $this->Form->end();  ?>
    </div>
  </div>
</div>

<div class="modal" tabindex="-1" role="dialog" id="modalChangeScales">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <?= $this->Form->create(null, ['url' => ['controller' => 'Assessments', 'action' => 'changeScales']]); ?>
      <div class="modal-header">
        <h5 class="modal-title"><?= __('Alterar os valores das etiquetas') ?></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="<?= __('Fechar') ?>">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <?php foreach(json_decode($assessment->labels) as $index => $label): ?>
          <div class="row mt-2">
            <div class="col-4 col-md-4">
              <?php if($index == 0): ?>
                <?= __('Menor') ?>
              <?php elseif ($index == count(json_decode($assessment->labels))-1): ?>
                <?= __('Maior') ?>
              <?php endif; ?>
            </div>
            <div class="col-8 col-md-8">
              <?= $this->Form->control(
                'scales[]',
                [
                  'label' => false,
                  'required' => true,
                  'value' => $label,
                  'class' => 'form-control',
                  'templates' => [
                    'inputContainer' => '<div class="form-group">{{content}}</div>'
                  ]
                ]
              ); ?>
            </div>
          </div>
        <?php endforeach; ?>
        <?= $this->Form->hidden('assessment_id', ['value' => $assessment->id]); ?>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-success"><?= __('Alterar') ?></button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal"><?= __('Cancelar') ?></button>
      </div>
      <?= $this->Form->end();  ?>
    </div>
  </div>
</div>

<?php $this->start('css'); ?>
<style media="screen">
.likert::before {
  left: <?= (99 / count(json_decode($assessment->labels)))/2  ?>%;
  width: <?= (count(json_decode($assessment->labels)) - 1) * (99 / count(json_decode($assessment->labels)))  ?>%;
}

.likert li {
  width: <?= (95 / count(json_decode($assessment->labels)))  ?>%;
}

</style>
<?php $this->end(); ?>
