<div class="container-fluid">
  <div class="row">
    <div class="col">
      <ul class="nav justify-content-center nav-assessment">
        <li class="nav-item">
          <a class="nav-link" href="#">
            <span class="not-small">
              <?= __('Passo'); ?>
            </span>
            1
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link active" href="#">
            <span class="not-small">
              <?= __('Passo'); ?>
            </span>
            2
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">
            <span class="not-small">
              <?= __('Passo'); ?>
            </span>
            3
          </a>
        </li>
      </ul>
    </div>
  </div>
  <div class="row">
    <div class="col-12 col-md-8">
      <h2>
        <?=$assessment->title; ?>
        <?php if($assessment->status == 'preparation'): ?>
          <span class="badge badge-success"><?= __('Em preparação') ?></span>
        <?php elseif($assessment->status == 'open'): ?>
          <span class="badge badge-warning"><?= __('Aberto') ?></span>
        <?php else: ?>
          <span class="badge badge-danger"><?= __('Encerrado') ?></span>
        <?php endif; ?>
      </h2>
    </div>
    <div class="col-12 col-md-4 text-right">
    <?php if ($assessment->status == 'preparation' && count($assessment->assessment_rubrics) != 0): ?>
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
    <?php endif; ?>
    <?php if ($assessment->status == 'preparation'): ?>
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
<?php //debug($assessment); ?>
  <div class="row py-3">
    <div class="col">
        <div class="card">
          <div class="card-body">
            <div class="row">
              <div class="col-12 col-md-6">
                <label for="team" class="mb-0"><?= __('Turma') ?> </label>
                <input type="text" readonly class="form-control-plaintext pt-0" id="team" value="<?= $assessment->team->name ?>">
              </div>
              <div class="col-12 col-md-6">
                <label for="team" class="mb-0"><?= __('Disciplina') ?> </label>
                <input type="text" readonly class="form-control-plaintext pt-0" id="team" value="<?= $assessment->team->discipline->name ?>">
              </div>
            </div>

            <div class="row">
              <div class="col-12 col-md-4">
                <div class="form-group">
                  <label for="startAt" class="mb-0"><?= __('Início') ?></label>
                  <input type="text" readonly class="form-control-plaintext pt-0" id="startAt" value="<?= $assessment->startAt ?>">
                </div>
              </div>
              <div class="col-12 col-md-4">
                <div class="form-group">
                  <label for="endAt" class="mb-0"><?= __('Encerramento') ?> </label>
                  <input type="text" readonly class="form-control-plaintext pt-0" id="endAt" value="<?= $assessment->endAt ?>">
                </div>
              </div>
              <div class="col-12 col-md-4">
                <div class="form-group">
                  <label for="score" class="mb-0"><?= __('Nota máxima') ?> </label>
                  <input type="text" readonly class="form-control-plaintext pt-0" id="score" value="<?= $assessment->maximum_score ?>">
                </div>
              </div>
            </div>

            
          </div>
        </div>
    </div>
  </div>


  <div class="row">
    <div class="col-12 col-md-6">
      <div class="card">
        <div class="card-header">
          <div class="row">
            <div class="col-8">
              <?= __('Escalas')  ?>: <?= $assessment->scale ?>
            </div>
            <div class="col-4 text-right">
              <?php if ($assessment->status == 'preparation'): ?>
                <button class="btn btn-sm btn-secondary"  type="button" data-toggle="modal" data-target="#modalChangeScales">
                  <i class="fas fa-pencil-alt"></i>
                  <?= __('Alterar') ?>
                </button>
              <?php endif; ?>
            </div>
          </div>
        </div>
        <div class="card-body">

          <div class="row">
            <div class="col list-scales">
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
                    <?= $label ?>
                  </div>
                </div>
              <?php endforeach; ?>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-12 col-md-6">
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
          <?php foreach($assessment->assessment_rubrics as $ar): ?>
            <div class="row py-2 list-rubrics">
              <div class="col-10">
                [<?= $ar->weight; ?>]
                <?= $ar->rubric->title; ?>
              </div>
              <div class="col-2 text-right">
                <?php if ($assessment->status == 'preparation'): ?>
                <?=$this->Form->postLink(
                  '<i class="fas fa-trash-alt"></i> ',
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
