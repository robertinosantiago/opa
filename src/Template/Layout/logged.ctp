<?php

/**
* @author Robertino Mendes Santiago Junior
*/

?>
<!DOCTYPE html>
<html>

<head>
  <?php echo $this->Html->charset() ?>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <title>
    <?php echo __('OPA'); ?>:<?php echo $this->fetch('title') ?>
  </title>

  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB"
  crossorigin="anonymous">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp"
  crossorigin="anonymous">
  <?php echo $this->Html->css('main.css'); ?>
  <?php echo $this->fetch('meta'); ?>
  <?php echo $this->fetch('css'); ?>
</head>

<body class="app">
  <?php echo $this->element('navbar'); ?>
  <div class="sidebar-overlay"></div>
  <aside class="sidebar">
    <ul class="sidebar-menu list-unstyled">
      <li>
        <a class="menu-link" href="<?php echo $this->Url->build('/Home'); ?>" title="<?php echo __('Home'); ?>">
          <i class="fas fa-home"></i>
          <span class="menu-label">
            <?php echo __('Home'); ?>
          </span>
        </a>
      </li>
      <li>
        <a class="menu-link" href="<?php echo $this->Url->build('/Assessments'); ?>" title="<?php echo __('Assessments'); ?>">
          <i class="fas fa-clipboard-list"></i>
          <span class="menu-label">
            <?php echo __('Assessments'); ?>
          </span>
        </a>
      </li>
      <li>
        <a class="menu-link" href="<?php echo $this->Url->build('/Disciplines'); ?>" title="<?php echo __('Disciplines'); ?>">
          <i class="fas fa-school"></i>
          <span class="menu-label">
            <?php echo __('Disciplines'); ?>
          </span>
        </a>
      </li>
      <li>
        <a class="menu-link" href="<?php echo $this->Url->build('/Rubrics'); ?>" title="<?php echo __('Rubrics'); ?>">
          <i class="fas fa-file-alt"></i>
          <span class="menu-label">
            <?php echo __('Rubrics'); ?>
          </span>
        </a>
      </li>
      <li class="sidebar-menu-dropdown">
        <a class="menu-link" href="#" title="Link" data-toggle="submenu">
          <i class="fas fa-link"></i>
          <span class="menu-label">Dropdown</span>
        </a>
        <ul class="submenu list-unstyled">
          <li>
            <a class="submenu-link" href="#" title="Sublink">
              <i class="fas fa-link"></i> Submenu Link
            </a>
          </li>
          <li>
            <a class="submenu-link" href="#" title="Sublink">
              <i class="fas fa-link"></i> Submenu Link
            </a>
          </li>
          <li>
            <a class="submenu-link" href="#" title="Sublink">
              <i class="fas fa-link"></i> Submenu Link
            </a>
          </li>
          <li>
            <a class="submenu-link" href="#" title="Sublink">
              <i class="fas fa-link"></i> Submenu Link
            </a>
          </li>
        </ul>
      </li>
      <li class="sidebar-menu-dropdown">
        <a class="menu-link" href="#" title="Link" data-toggle="submenu">
          <i class="fas fa-link"></i>
          <span class="menu-label">Dropdown</span>
        </a>
        <ul class="submenu list-unstyled">
          <li>
            <a class="submenu-link" href="#" title="Sublink">
              <i class="fas fa-link"></i>
              Submenu Link
            </a>
          </li>
          <li>
            <a class="submenu-link" href="#" title="Sublink">
              <i class="fas fa-link"></i>
              Submenu Link
            </a>
          </li>
          <li>
            <a class="submenu-link" href="#" title="Sublink">
              <i class="fas fa-link"></i>
              Submenu Link
            </a>
          </li>
          <li>
            <a class="submenu-link" href="#" title="Sublink">
              <i class="fas fa-link"></i>
              Submenu Link
            </a>
          </li>
        </ul>
      </li>

    </ul>
  </aside>
  <main class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col">
          <?php echo $this->Flash->render() ?>
          <?php echo $this->Flash->render('auth') ?>
          <?php echo $this->fetch('content') ?>
        </div>
      </div>
    </div>

  </main>



  <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
  crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49"
  crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js" integrity="sha384-smHYKdLADwkXOn1EmN1qk/HfnUcbVRZyYmZ4qpPea6sjB/pTJ0euyQp0Mk8ck+5T"
  crossorigin="anonymous"></script>
  <?php echo $this->Html->script('sidebar.js'); ?>
  <script type="text/javascript">
  $(document).ready(function(){
    window.setTimeout(function() {
      $(".alert-dismissible").fadeTo(500, 0).slideUp(500, function(){
        $(this).remove();
      });
    }, 4000);
  })
  </script>
  <?php echo $this->fetch('script'); ?>
</body>

</html>
