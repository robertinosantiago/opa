<?php
/**
 * @author Robertino Mendes Santiago Junior
 */
?>

  <!DOCTYPE html>
  <html>

  <head>
    <?=$this->Html->charset() ?>
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <meta http-equiv="x-ua-compatible" content="ie=edge">
      <title>
        <?=__('OPA'); ?>:<?=$this->fetch('title') ?>
      </title>

      <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB"
        crossorigin="anonymous">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" integrity="sha384-gfdkjb5BdAXd+lj+gudLWI+BXq4IuLW5IT+brZEZsLFm++aCMlF1V92rMkPaX4PP" crossorigin="anonymous">

      <?=$this->Html->css('bootstrap-social.css'); ?>
      <?=$this->Html->css('main.css'); ?>
      <?=$this->fetch('meta'); ?>
      <?=$this->fetch('css'); ?>
  </head>

  <body class="app not-logged">
    <nav class="navbar navbar-expand">
      <div class="container">
        <a class="navbar-brand" href="#">
          <?=__('OPA'); ?>
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false"
          aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
          <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
              <a class="nav-link" href="<?php echo $this->Url->build('/'); ?>">
                <?php echo __('Início'); ?>
                <span class="sr-only">(current)</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">
                <?php echo __('Funcionalidades'); ?>
              </a>
            </li>
          </ul>
          <ul class="navbar-nav ml-auto">
            <li class="nav-item">
              <?php echo $this->Html->link(__('Acessar'), ['controller' => 'Users', 'action' => 'login'], ['class' => 'nav-link']); ?>
            </li>
          </ul>
        </div>
      </div>
    </nav>
    <main class="content">
      <?=$this->Flash->render() ?>
      <?=$this->Flash->render('auth') ?>
      <?=$this->fetch('content') ?>
    </main>


    <footer></footer>

    <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
      crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49"
      crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js" integrity="sha384-smHYKdLADwkXOn1EmN1qk/HfnUcbVRZyYmZ4qpPea6sjB/pTJ0euyQp0Mk8ck+5T"
      crossorigin="anonymous"></script>
    <script src="js/sidebar.js" charset="utf-8"></script>
    <script type="text/javascript">
    $(document).ready(function(){
      window.setTimeout(function() {
        $(".alert-dismissible").fadeTo(500, 0).slideUp(500, function(){
          $(this).remove();
        });
      }, 4000);
    })
    </script>
  </body>

  </html>
