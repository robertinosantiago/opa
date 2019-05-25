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

    <!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB"
      crossorigin="anonymous"> -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" integrity="sha384-gfdkjb5BdAXd+lj+gudLWI+BXq4IuLW5IT+brZEZsLFm++aCMlF1V92rMkPaX4PP" crossorigin="anonymous">
    <?=$this->Html->css('main.css'); ?>
    <?=$this->fetch('meta'); ?>
    <?=$this->fetch('css'); ?>
  </head>

  <body class="app">
    <?= $this->element('navbar'); ?>
    <div class="sidebar-overlay"></div>
    <aside class="sidebar">
      <ul class="sidebar-menu list-unstyled">
        <li>
          <a class="menu-link" href="<?=$this->Url->build('/Home'); ?>" title="<?=__('Início'); ?>">
            <i class="fas fa-home"></i>
            <span class="menu-label">
              <?=__('Início'); ?>
            </span>
          </a>
        </li>
        <li>
          <a class="menu-link" href="<?=$this->Url->build(['controller' => 'Disciplines', 'action' => 'controls', $discipline->id]); ?>" title="<?=__('Visão geral da Disciplina'); ?>">
            <i class="fas fa-school"></i>
            <span class="menu-label">
              <?=__('Visão geral da Disciplina'); ?>
            </span>
          </a>
        </li>
        <li>
          <a class="menu-link" href="<?=$this->Url->build(['controller' => 'Teams', 'action' => 'index', $discipline->id]); ?>" title="<?=__('Turmas'); ?>">
            <i class="fas fa-user-friends"></i>
            <span class="menu-label">
              <?=__('Turmas'); ?>
            </span>
          </a>
        </li>


      </ul>
    </aside>
    <main class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col">
            <?=$this->Flash->render() ?>
            <?=$this->Flash->render('auth') ?>
            <?=$this->fetch('content') ?>
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
    <?=$this->Html->script('sidebar.js'); ?>
    <?=$this->Html->script('script.js'); ?>
    <?=$this->fetch('script'); ?>
  </body>

  </html>
