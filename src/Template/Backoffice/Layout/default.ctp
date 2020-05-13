<?php
/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @since         0.10.0
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */

$cakeDescription = 'Área de Administração';
?>
<!DOCTYPE html>
<html>
<head>
    <?= $this->Html->charset() ?>
    <meta http-equiv="X-UA-Compatible" content="">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title>
        <?= $cakeDescription ?>:
        <?= $this->fetch('title') ?>
    </title>
    <?= $this->Html->meta('icon') ?>


    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <?= $this->fetch('script') ?>

<?php $url = $this->Url->build(["prefix" => false, "controller" => '/'], true); ?>

  <link rel="stylesheet" href="<?= $url; ?>/bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?= $url; ?>/bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="<?= $url; ?>/bower_components/Ionicons/css/ionicons.min.css">
  <!-- Theme style -->
  <?= $this->Html->css('AdminLTE.min.css') ?>
  <?= $this->Html->css('skins/skin-blue.min.css') ?>

  <script src="<?= $url; ?>/bower_components/jquery/dist/jquery.min.js"></script>


  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
  <style>
  td a i {color:black;}
  td a i:hover {color:#333;}
  </style>
</head>

<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">
    <!-- Main Header -->
  <header class="main-header">

    <!-- Logo -->
    <a href="<?= $url ?>/backoffice" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>EKOS</b></span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b>Admin</b>EKOS</span>
    </a>

    <!-- Header Navbar -->
    <nav class="navbar navbar-static-top" role="navigation">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>
      <!-- Navbar Right Menu -->
      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <!-- User Account Menu -->
          <li class="dropdown user user-menu">
            <!-- Menu Toggle Button -->
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <!-- The user image in the navbar-->
              <img src="<?= $Auth['pic']?>" class="user-image" alt="User Image">
              <!-- hidden-xs hides the username on small devices so only the image appears. -->
              <span class="hidden-xs"><?= $Auth['first_name']?></span>
            </a>
            <ul class="dropdown-menu">
              <!-- The user image in the menu -->
              <li class="user-header">
                <img src="<?= $Auth['pic']?>" class="img-circle" alt="User Image">

                <p>
                  <?= $Auth['first_name']." ".$Auth['last_name']?>
                  <small><?= $Auth['role_description']?></small>
                </p>
              </li>
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-left">
                  <a href="#" class="btn btn-default btn-flat">Perfil</a>
                </div>
                <div class="pull-right">
                  <a href="<?= $this->Url->build(["prefix" => false, "controller" => "Users", "action" => "logout"]) ?>" class="btn btn-default btn-flat">Logout</a>
                </div>
              </li>
            </ul>
          </li>
        </ul>
      </div>
    </nav>
  </header>


<!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

      <!-- Sidebar Menu -->
      <ul class="sidebar-menu" data-widget="tree">
        <li class="header">Administração</li>
        <!-- Optionally, you can add icons to the links -->
        <?php if($Auth['role'] == 3): ?>
          <li id='Users'><a href="<?= $this->Url->build(["controller" => "Users", "action" => "index"]) ?>"><i class="fa fa-users"></i> <span>Utilizadores</span></a></li>   
        <?php endif; ?>  
        <?php if($Auth['role'] > 1): ?>   
        <li class="treeview" id="Courses">
          <a href="#"><i class="fa fa-medkit"></i> <span>Cursos</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
          </a>
          <ul class="treeview-menu">
            <?php foreach ($Courses as $key => $value) {
              if(in_array($key, $Auth['moderator']) || $Auth['role'] == 3 || ($Auth['role'] == 4 && $key != 1)):
              ?>
                <li id='<?= $key ?>'><a href="<?= $this->Url->build(["controller" => "Courses", "action" => "view", $key]) ?>"><?= $value?></a></li>
            <?php endif; }?>
          </ul>
        </li>
         <li id='Notifications'><a href="<?= $this->Url->build(["controller" => "Notifications", "action" => "index"]) ?>"><i class="fa fa-warning"></i> <span>Avisos</span></a></li> 
        <?php endif; ?>  
        <?php if($Auth['role'] == 3): ?>
          <li id='Sales'><a href="<?= $this->Url->build(["controller" => "Sales", "action" => "index"]) ?>"><i class="fa fa-money"></i> <span>Contabilidade</span> 
          <?php if ($Pending > 0): ?>
          <span class="pull-right-container">
              <small class="label pull-right bg-yellow"><?= $Pending?></small>
            </span><?php endif;?></a></li> 

        <?php endif; ?>  

        <li class="treeview" id="Feedback">
          <a href="#"><i class="fa fa-medkit"></i> <span>Avaliação</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
          </a>
          <ul class="treeview-menu">
                <?php if($Auth['role'] == 3): ?>
                <li id='F1'><a href="<?= $this->Url->build(["controller" => "feedback", "action" => "questions"]) ?>">Lista de Perguntas</a></li>
                <li id='F3'><a href="<?= $this->Url->build(["controller" => "feedback", "action" => "teachers"]) ?>">Resultados por Formador</a></li>
               <?php endif; ?>

              <?php if($Auth['role'] > 1): ?>
               <li id='F2'><a href="<?= $this->Url->build(["controller" => "feedback", "action" => "courses"]) ?>">Resultados por Módulo</a></li>
             <?php endif; ?>

               <li id='F4'><a href="<?= $this->Url->build(["controller" => "feedback", "action" => "teacher", $Auth['id']]) ?>">Ver a minha avaliação</a></li>
          </ul>
        </li>

        <li id='Uploader'><a href="<?= $this->Url->build(["controller" => "Uploader", "action" => "index"]) ?>"><i class="fa fa-files-o"></i> <span>Gestor de Ficheiros</span></a></li> 
        <li id='Questions'><a href="<?= $this->Url->build(["controller" => "Questions", "action" => "index"]) ?>"><i class="fa fa-question-circle"></i> <span>Banco de Perguntas</span></a></li> 
        <li id='Flashcards'><a href="<?= $this->Url->build(["controller" => "Flashcards", "action" => "index"]) ?>"><i class="fa fa-random"></i> <span>Banco de Flashcards</span></a></li> 
        <?php if($Auth['role'] == 3): ?>  
        <li class="header">Área Pública</li>
        <li class="treeview" id="Frontend">
          <a href="#"><i class="fa fa-question-circle"></i> <span>Informações</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
          </a>
          <ul class="treeview-menu">
                <li id='i1'><a href="<?= $this->Url->build(["controller" => "Frontend", "action" => "edit", 1]) ?>">Inscrições</a></li>
                <li id='i2'><a href="<?= $this->Url->build(["controller" => "Frontend", "action" => "edit", 2]) ?>">Exame</a></li>
                <li id='i3'><a href="<?= $this->Url->build(["controller" => "Frontend", "action" => "edit", 3]) ?>">FAQ</a></li>
          </ul>
        </li>
         <li id='matrix'><a href="<?= $this->Url->build(["controller" => "Frontend", "action" => "matrix"]) ?>"><i class="fa fa-server"></i> <span>Matriz</span></a></li>  
         <li id='Documents'><a href="<?= $this->Url->build(["controller" => "Uploader", "action" => "documents"]) ?>"><i class="fa fa-files-o"></i> <span>Documentos</span></a></li>  

        <?php endif; ?>  
      </ul>
      <!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
     <?= $this->Flash->render() ?>
    <!-- Main content -->
      <?= $this->request->params['controller'] == 'Feedback' ? '<a id="buttontop"></a>' : '' ?>
    <section class="content container-fluid">

      <?= $this->fetch('content') ?>

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- Main Footer -->
  <footer class="main-footer">
    <!-- To the right -->
    <div class="pull-right hidden-xs">
     
    </div>
    <!-- Default to the left -->
   
  </footer>
</div>
<!-- ./wrapper -->

<!-- REQUIRED JS SCRIPTS -->

<!-- jQuery 3 -->

<!-- Bootstrap 3.3.7 -->
<script src="<?= $url; ?>/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- AdminLTE App -->
<?= $this->Html->script('adminlte.min.js'); ?>


<!-- Optionally, you can add Slimscroll and FastClick plugins.
     Both of these plugins are recommended to enhance the
     user experience. -->


<?php if ($this->request->params['controller'] != "Frontend") :  ?>
<script>
$("li#<?= $this->request->params['controller']; ?>").addClass('active');
$("li#<?= $this->request->params['controller']; ?> ul li#<?= @$this->request->getParam('pass')['0'] ?>").addClass('active');
</script>
<script>
var btn = $('#buttontop');

$(window).scroll(function() {
  if ($(window).scrollTop() > 300) {
    btn.addClass('show');
  } else {
    btn.removeClass('show');
  }
});

btn.on('click', function(e) {
  e.preventDefault();
  $('html, body').animate({scrollTop:0}, '300');
});
</script>
<?php endif; ?>
</body>

</html>
