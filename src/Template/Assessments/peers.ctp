<div class="container-fluid">
  <div class="row">
    <div class="col">
      <h2><?= __('Atribuição de pares') ?></h2>
      <h5><?= __('Avaliação') ?>: <?= $assessment->title ?></h5>
      <h6><?= $assessment->team->name ?> - <?= $assessment->team->discipline->name ?></h6>
    </div>
  </div>
  <div class="row">
    <div class="col">
      <nav>
        <div class="nav nav-tabs" id="nav-tab" role="tablist">
          <a class="nav-item nav-link active" id="nav-random-tab" data-toggle="tab" href="#nav-random" role="tab" aria-controls="nav-random" aria-selected="true"><?= __('Aleatório');  ?></a>
          <a class="nav-item nav-link" id="nav-manual-tab" data-toggle="tab" href="#nav-manual" role="tab" aria-controls="nav-manual" aria-selected="false"><?= __('Manual');  ?></a>
        </div>
      </nav>
      <div class="tab-content" id="nav-tabContent">
        <div class="tab-pane fade show active py-3" id="nav-random" role="tabpanel" aria-labelledby="nav-random-tab">
          <form id="form-random">
            <div class="form-group form-check">
              <input type="checkbox" class="form-check-input" id="auto">
              <label class="form-check-label" for="auto"><?= __('Permitir auto-avaliação') ?></label>
            </div>
            <div class="form-group required">
              <label for="number"><?= __('Número de avaliações para cada participante') ?></label>
              <select class="form-control" id="number" required>
                <option><?= __('Selecione') ?></option>
                <?php if ($countStudents > 0): ?>
                  <?php foreach(range(1, $countStudents) as $n): ?>
                    <option value="<?= $n ?>"><?= $n ?></option>
                  <?php endforeach; ?>
                <?php endif; ?>
              </select>
            </div>
            <button type="submit" id="generate-random" class="btn btn-success">
              <?= __('Realizar atribuição aleatoriamente') ?>
            </button>
          </form>
        </div>
        <div class="tab-pane fade py-3" id="nav-manual" role="tabpanel" aria-labelledby="nav-manual-tab">
          <form id="form-manual">
            <div class="row">
              <div class="col-12 col-md-6">
                <div class="form-group required">
                  <label for="user"><?= __('Par avaliado') ?></label>
                  <select class="form-control" id="user" required>
                    <option><?= __('Selecione') ?></option>
                    <?php foreach ($users as $data): ?>
                      <option value="<?= $data->user->id ?>">
                        <?= $data->user->first_name ?> <?= $data->user->last_name ?>
                      </option>
                    <?php endforeach; ?>
                  </select>
                </div>
              </div>
              <div class="col-12 col-md-6">
                <div class="form-group required">
                  <label for="appraiser"><?= __('Par avaliador') ?></label>
                  <select class="form-control" id="appraiser" required>
                    <option><?= __('Selecione') ?></option>
                    <?php foreach ($users as $data): ?>
                      <option value="<?= $data->user->id ?>">
                        <?= $data->user->first_name ?> <?= $data->user->last_name ?>
                      </option>
                    <?php endforeach; ?>
                  </select>
                </div>
              </div>
            </div>
            <input type="hidden" id="assessment-manual" value="<?= $assessment->id ?>">
            <button type="submit" id="add-manual" class="btn btn-success">
              <?= __('Realizar atribuição') ?>
            </button>
          </form>
        </div>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col list-peers">
      <div class="text-center">
        <i class="fas fa-3x fa-spinner fa-spin"></i>
      </div>
    </div>
  </div>
</div>

<?php $this->start('script'); ?>
<script type="text/javascript">
/**
* Função que carrega a listagem de pares atribuídos
*/
const listPeers = function() {
  $.ajax({
    url: '<?= $this->Url->build('/assessments/listPeers') ?>',
    method: 'POST',
    data: {assessment_id: <?= $assessment->id ?>}
  })
  .done(function(html){
    $('.list-peers').html(html);
  });
};

const stringWait = '<div class="text-center"><i class="fas fa-3x fa-spinner fa-spin"></i></div>';

$(document).ready(function(){

  listPeers();

  $('#auto').on('change', function() {
    if (<?= $countStudents ?>  > 0) {
      if ($(this).is(':checked')) {
        $('#number').append('<option value="<?= ($countStudents + 1) ?>"><?= ($countStudents + 1) ?></option>');
      } else {
        $('#number option').last().remove();
      }
    }
  });

  $('#form-manual').on('submit', function(e) {
    e.preventDefault();

    if ($('#user').val() == 'Selecione') {
        alert('<?= __('Selecione um par avaliado') ?>')
        return false;
    }

    if ($('#appraiser').val() == 'Selecione') {
        alert('<?= __('Selecione um par avaliador') ?>')
        return false;
    }

    $('#add-manual').prop('disabled', true);

    $.ajax({
      url: '<?= $this->Url->build('/assessments/addPeerManual') ?>',
      method: 'POST',
      data: {
        assessment_id: <?= $assessment->id ?>,
        user_id: $('#user').val(),
        appraiser_id: $('#appraiser').val()
      }
    })
    .done(function(html) {
      $('.list-peers').html(stringWait);
      listPeers();
      $("#user").prop("selectedIndex", 0);
      $("#appraiser").prop("selectedIndex", 0);
      $('#add-manual').prop('disabled', false);
    });
  });

  $(document).on('click', '.btn-remove-appraiser', function() {
    let ok = confirm("<?= __('Tem certeza?') ?>");
    if (ok) {
      let $elem = $(this);
      $elem.prop('disabled', true);
      $.ajax({
        url: '<?= $this->Url->build('/assessments/removeAppraiser') ?>',
        method: 'POST',
        data: {
          peer_id: $elem.val(),
        }
      })
      .done(function(html) {
        $('.list-peers').html(stringWait);
        listPeers();
        $elem.prop('disabled', false);
      });
    }
  });

  $(document).on('click', '#btn-remove-all', function() {
    let ok = confirm("<?= __('Tem certeza?') ?>");
    if (ok) {
      let $elem = $(this);
      $elem.prop('disabled', true);
      $.ajax({
        url: '<?= $this->Url->build('/assessments/removeAllPeers') ?>',
        method: 'POST',
        data: {
          assessment_id: $elem.val(),
        }
      })
      .done(function(html) {
        $('.list-peers').html(stringWait);
        listPeers();
        $elem.prop('disabled', false);
      });
    }
  });

  $('#form-random').on('submit', function(e) {
    e.preventDefault();

    if ($('#number').val() == 'Selecione') {
        alert('<?= __('Selecione o número de avaliações para cada participante') ?>')
        return false;
    }

    let ok = confirm("<?= __('Esta ação remove todas atribuições já estabelecidas. Confirma?') ?>");
    if (ok) {
      $('#generate-random').prop('disabled', true);

      $.ajax({
        url: '<?= $this->Url->build('/assessments/peersRandom') ?>',
        method: 'POST',
        data: {
          assessment_id: <?= $assessment->id ?>,
          auto: $('#auto').is(':checked'),
          number: $('#number').val()
        }
      })
      .done(function(html) {
        $('.list-peers').html(stringWait);
        listPeers();
        $('#generate-random').prop('disabled', false);
      });
    }
  });


});
</script>
<?php $this->end(); ?>
