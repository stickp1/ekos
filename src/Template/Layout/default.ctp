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

$cakeDescription = 'EKOS - Formar para a Especialidade';
?>

<!DOCTYPE html>
<html>
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?= $cakeDescription ?>
    </title>
    <?= $this->Html->meta('icon') ?>

    <?php $url = $this->Url->build(["prefix" => false, "controller" => '/'], true); ?>

    <link rel="stylesheet" href="<?= $url; ?>/bower_components/bootstrap/dist/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?= $url; ?>/bower_components/font-awesome/css/font-awesome.min.css">

    <?= $this->Html->css('style.css') ?>
   
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:400,400i,600,600i" rel="stylesheet">

    <link rel="apple-touch-icon" sizes="57x57" href="/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192"  href="/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <link rel="manifest" href="/manifest.json">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">

    <meta property="og:url"                content="http://ekos.pt/" />
    <meta property="og:locale"             content="pt_PT" />
    <meta property="og:title"              content="EKOS - Formar para a Especialidade" />
    <meta property="og:description"        content="A EKOS é um projeto de aulas de preparação para a nova Prova Nacional de Acesso que surgiu da necessidade de criar um modelo de aulas que se adapte aos desafios que esta nova prova acarreta." />
    <meta property="og:image"              content="http://ekos.pt/fb_banner.jpg" />

    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <?= $this->fetch('script') ?>

    <script src="<?= $url; ?>/bower_components/jquery/dist/jquery.min.js"></script>
    <script src="<?= $url; ?>/js/validate.min.js"></script>
    <script src="<?= $url; ?>/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src='https://www.google.com/recaptcha/api.js'></script>

    <?php $flash = $this->Flash->render();
    if($flash): ?>
    
    <style>
    .navbar-fixed-top {
        top: 40px;
        -moz-transition: top 500ms ease-out;
        -webkit-transition: top 500ms ease-out;
        -o-transition: top 500ms ease-out;
        transition: top 500ms ease-out;
    }
    </style>

    <?php endif; ?>

    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-125010222-1"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());
        gtag('config', 'UA-125010222-1');
    </script>
</head>

<body id="page-top" class="index">

    <?= $flash ?>

    <!-- Navigation -->
    <nav id="mainNav" class="navbar navbar-default navbar-custom navbar-fixed-top">
        <div style='width:87.5%; margin: auto'>
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header page-scroll">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span> <i id="toggle-icon" class="fa fa-bars"></i>
                </button>
                <a class="page-scroll" href="<?= $url ?>"><img src='<?= $url?>/img/logo.png' class='logo' /></a>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav navbar-right">
                    <li>
                        <a href="<?= $this->Url->build(["prefix" => false, "controller" => '/', "action" => "sobre"]) ?>" <?= $this->request->params['action'] == 'sobre' ? "class='active'" : ""?> >Quem Somos</a>
                    </li>
                    <li>
                        <a href="<?= $this->Url->build(["prefix" => false, "controller" => '/', "action" => "cursos"]) ?>" <?= $this->request->params['action'] == 'cursos' ? "class='active'" : ""?> >Cursos</a>
                    </li>
                    <li class="dropdown-toggle" data-toggle="dropdown">
                        <a href=# value="<?= $this->Url->build(["prefix" => false, "controller" => '/', "action" => "informacoes"]) ?>" <?= $this->request->params['action'] == 'informacoes' ? "class='active'" : ""?>  >Informações</a>
                         <ul class="dropdown-menu" role="menu">
                            <li><a onClick="window.location.href='<?= $this->Url->build(["prefix" => false, "controller" => '/', "action" => "informacoes"]) ?>'" href='#' class="dropdown-item">Inscrições</a></li>
                            <li><a onClick="window.location.href='<?= $this->Url->build(["prefix" => false, "controller" => '/', "action" => "informacoes", "exame"]) ?>'" href='#' class="dropdown-item">Exame</a></li>
                            <li><a onClick="window.location.href='<?= $this->Url->build(["prefix" => false, "controller" => '/', "action" => "informacoes", "matriz"]) ?>'" href='#' class="dropdown-item">Bibliografia</a></li>
                            <li><a onClick="window.location.href='<?= $this->Url->build(["prefix" => false, "controller" => '/', "action" => "informacoes", "docs"]) ?>'" href='#' class="dropdown-item">Documentos</a></li>
                            <li><a onClick="window.location.href='<?= $this->Url->build(["prefix" => false, "controller" => '/', "action" => "informacoes", "faq"]) ?>'" href='#' class="dropdown-item">FAQs</a></li>
                        </ul>
                    </li>
                    <!--
                    <li>
                        <a href="<?= $this->Url->build(["prefix" => false, "controller" => '/', "action" => "banco"]) ?>" <?= $this->request->params['action'] == 'perguntas' ? "class='active'" : ""?> >Perguntas & Flashcards</a>
                    </li>
                    -->
                    <li>
                        <a href="<?= $this->Url->build(["prefix" => false, "controller" => '/', "action" => "formacao"]) ?>" <?= $this->request->params['action'] == 'formacao' ? "class='active'" : ""?> >Formação Profissional</a>
                    </li>
                    <li class="dropdown-toggle">
                        <a class="page-scroll" href="#" data-toggle="modal" data-target="#login" <?= isset($Auth['id']) ? "value=\"".$this->Url->build(["prefix" => false, "controller" => "reserved", "action" => "index"])."\"" : "" ?> >Área Reservada</a>
                        <?php if(isset($Auth['id'])): ?>
                        <ul class="dropdown-menu">
                          <!-- The user image in the menu -->
                          <li class="user-header">
                            <img src="<?= $Auth['pic']?>" class="img-circle" alt="User Image">

                            <p>
                              <?= $Auth['first_name']." ".$Auth['last_name']?>
                              <small><?= $Auth['role_description']?></small><br>
                              
                            </p>
                          </li>
                          <!-- Menu Footer-->
                          <li class="user-footer">
                            <div style='text-align:center'>
                                <button class="btn btn-black" onClick="window.location.href='<?= $this->Url->build(["prefix" => false, "controller" => "Reserved", "action" => "profile"]) ?>'" style='padding: 5px 10px; margin: 0; width:49%'>PERFIL</button>

                              <button class="btn btn-black" onClick="window.location.href='<?= $this->Url->build(["prefix" => false, "controller" => "Users", "action" => "logout"]) ?>'" style='padding: 5px 10px; margin: 0;  width:49%'>LOGOUT</button>
                            </div>
                          </li>
                        </ul>
                        <?php endif; ?>
                    </li>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container-fluid -->
    </nav>

    <div class="modal fade" id="report">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h1 class="modal-title text-center">Erro/Sugestão</h1>
                    </div>
                    <div class="modal-body">
                        <?= $this->Form->create('Form', ['url' => ['controller' => 'frontend', 'action' => 'report'], 'id' => 'report-form']) ?>
                            <div id="textDiv">
                                <input type="hidden" class="form-control" name="report-url" value=<?php echo $this->request->here; ?>/>
                                <input type="hidden" class="form-control" name="report-param" id="report-param"/>
                                <textarea class="form-control" id="report-message" name="report-message" rows="5" placeholder="Escreve aqui o erro/sugestão" required></textarea>
                                <textarea class="form-control" id="report-contact" name="report-contact" rows=1 placeholder="Contacto (opcional)"></textarea>
                            </div>
                            <div class="modal-footer row">
                                <div id="report-captcha" class="g-recaptcha col-sm-6 col-xs-12" data-sitekey="6LciqvoUAAAAANAzl6QIzMvVVdcwsqrHiYtPcMlU" style='display: none'>
                                </div>
                                <div class="col-sm-6 col-sm-offset-6 col-xs-12 text-sm-right text-center">
                                    <button type="submit" class="btn btn-black">Submeter</button>
                                </div> 
                            </div>
                        <?= $this->Form->end() ?>
                    </div>
                    
                </div>
            </div>
        </div>
    
    <div id='main_container'>
        <?= $this->fetch('content') ?>
    </div>

    <section class='footer'>
        <div class='container'>
            <div class='row text-center'>
                <div class="col-md-3 col-sm-6">
                    <h5>ACESSO RÁPIDO</h5>
                        <p> <a href="<?= $this->Url->build(["prefix" => false, "controller" => '/', "action" => "sobre"]) ?>"> Equipa da EKOS </a><br> <a href="<?= $this->Url->build(["prefix" => false, "controller" => '/', "action" => "informacoes"]) ?>"> Inscrições </a><br> <a href="<?= $this->Url->build(["prefix" => false, "controller" => '/', "action" => "informacoes", "matriz"]) ?>"> Matriz & Bibliografia </a>
                        </p>
                </div>
                <div class="col-md-3 col-sm-6">
                    <h5><a href="<?= $this->Url->build(["prefix" => false, "controller" => '/', "action" => "contactos"]) ?>" <?= $this->request->params['action'] == 'contactos' ? "class='active'" : ""?>>INSTALAÇÕES</a></h5>
                        <p>Direção e Atendimento Geral <br> Rua Jorge Colaço 16-A, <br> 1700-253 Lisboa 
                        </p>
                </div>
                <!--</div>
                <div class="col-md-3 col-sm-6">
                    <h5>FMUL</h5>
                        <p>Faculdade de Medicina de Lisboa <br> Av. Professor Egas Moniz, <br> 1649-028 Lisboa 
                        </p>
                </div>-->
                <!--<div class="col-md-3 col-sm-6">
                    
                            <h5>NMS|FCM</h5>
                            <p>NOVA Medical School <br> Campo Mártires da Pátria 130, <br> 1169-056 Lisboa </p>     
                </div>-->
                <div class="col-md-3 col-sm-6" id="contactDiv">
                            <h5><a href="<?= $this->Url->build(["prefix" => false, "controller" => '/', "action" => "contactos"]) ?>" <?= $this->request->params['action'] == 'contactos' ? "class='active'" : ""?>>Contactos</a></h5>
                            <p>geral@ekos.pt <br> 
                                <a href='https://www.facebook.com/EKOSFormarParaAEspecialidade/' target="_blank"><i class="fa fa-facebook"></i></a>  
                                <a href='https://www.instagram.com/ekos_especialidade/' target="_blank"><i class="fa fa-instagram"></i></a>
                            </p>
                </div>
                <div class="col-md-3 col-sm-6" id="reportDiv">
                    <h5>SUGESTÕES</h5>
                    <a class="page-scroll" href="#" data-toggle="modal" data-target="#report" <?= isset($Auth['id']) ? "value=\"".$this->Url->build(["prefix" => false, "controller" => "reserved", "action" => "index"])."\"" : "" ?>>
                        <i class="fa fa-lightbulb-o"></i>
                    </a>
                    <p>
                        Clica aqui para reportar um bug e/ou sugerir novas funcionalidades
                        <br>
                    </p>
                </div>


            </div>
        </div>
    </section>

    <footer>
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-xs-6 text-sm-left">
                    <span class="copyright">&copy; EKOS - Formar para a Especialidade 2018</span>
                </div>
                <div class="col-md-3 col-md-offset-3 col-xs-6 text-sm-center">
                    <ul class="list-inline quicklinks">
                        <li><a href="/privacy_policy.pdf">Política de Privacidade</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </footer>


    <?php if(!isset($Auth['id'])): ?>
        <div class="modal fade" id="login">
                <div class="vertical-alignment-helper">
                    <div class="modal-dialog vertical-align-center">
                        <div class="modal-content">
                            <div class="modal-body">

                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                <br>
                                <h1>Login</h1>
                        
                                <?= $this->Form->create('Form', [ 'url' => ['controller' => 'users', 'action' => 'login'], 'id' => 'login_form']) ?>
                            
                                <fieldset>
                                    <?php if(@$_GET['e'] == 1): ?>
                                    <div class="alert alert-danger" role="alert"> Utilizador ou password incorretos. </div>
                                    <?php endif; ?>
                                    <div class="form-group">
                                        <div class="label">Email</div>
                                        <input type="text" class="form-control" placeholder="Inserir email" name='email' required/>
                                    </div>
                            
                                    <div class="form-group">
                                        <div class="label">Password</div>
                                        <input type="password" class="form-control" placeholder="Inserir password" name='password' required/>
                                        <p style='font-size:14px; margin-top:5px; text-align: right'><a href='<?= $url ?>/users/reset'>Esqueceste a password?</a></p>
                                    </div>

                                    <div align="center">
                                        <button class="btn btn-black" type='submit'>ENTRAR</button>
                                    </div>
                                </fieldset>

                                <?= $this->Form->end() ?>
                                <br>
                                <p>Ainda não tens conta?</p>
                            
                                <div align="center" style='margin-bottom:30px'>
                                    <button type="button" class="btn btn-black" id='register_button'>CRIAR REGISTO</button>
                                </div>
                            </div>
                        <!-- /.modal-content -->
                        </div>
                    <!-- /.modal-dialog -->
                    </div>
                </div>
        </div>

        <?php if ($scity): ?>
        <div class="modal fade" id="city">
            <div class="vertical-alignment-helper">
                <div class="modal-dialog vertical-align-center">
                    <div class="modal-content" style='width: 75%'>
                        <div class="modal-body">

                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span></button>
                            <br>
                            <h2>Selecionar a Cidade</h2>
                            <hr>
                            
                            <div class="wrapper" style='margin-bottom:30px'>
                                <?php foreach ($cities as $city) { ?>
                                <div class="media">
                                    <div class="layer" onClick='window.location.href="<?= $this->Url->build([ "controller" => 'frontend', 'action' => 'city', $city['id']], true)?>"'>
                                        <p>+ <?= $city['name']; ?></p>
                                    </div>
                                    <img src="<?= $city['url'] ?>" alt="" />
                                </div>
                                <?php } ?>
                            </div>
                        </div>
                        <!-- /.modal-content -->
                    </div>
                    <!-- /.modal-dialog -->
                </div>
            </div>
        </div>
        <?php endif; ?>

        <div class="modal fade" id="register" >
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-body">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <br>
                        <h1>Registar</h1>
                        <?= $this->Form->create('Form', [ 'url' => ['controller' => 'users', 'action' => 'register'], 'id' => 'register_form' ]) ?> 
                        <fieldset>
                            <?php if(@$_GET['e'] == 2): ?>
                            <div class="alert alert-danger" role="alert"> <?= $this->Session->read('error') ?> </div>
                            <?php endif; ?>
                            <div class="form-group">
                                <div class="label">Nome</div>
                                <input type="text" class="form-control" placeholder="Inserir nome" name='first_name' data-minlength="3" data-error="O nome inserido não é válido."  required />
                                <div class="help-block with-errors"></div>
                            </div>
                            <div class="form-group">
                                <div class="label">Apelido(s)</div>
                                <input type="text" class="form-control" placeholder="Inserir apelido(s)" name='last_name' data-minlength="3" data-error="O nome inserido não é válido."  required />
                                <div class="help-block with-errors"></div>
                            </div>
                            <div class="form-group">
                                <div class="label">Email</div>
                                <input type="email" class="form-control" placeholder="Inserir email" name='email' id='email1' data-error="O email inserido não é válido."  required />
                                <div class="help-block with-errors"></div>
                            </div>
                            <div class="form-group">
                                <div class="label">Confirmar email</div>
                                <input type="text" class="form-control" placeholder="Confirmar email" id='email2' data-match="#email1"data-match-error="Os emails inseridos não são iguais." required />
                                <div class="help-block with-errors"></div>
                            </div>
                            <div class="form-group">
                                <div class="label">Password</div>
                                <input type="password" class="form-control" placeholder="Inserir password" name='password' id='password1' data-minlength="6" data-error="Mínimo de 6 caracteres." required />
                                <div class="help-block with-errors"></div>
                            </div>
                            <div class="form-group">
                                <div class="label">Confirmar Password</div>
                                <input type="password" class="form-control" placeholder="Confirmar password" id='password2' data-match="#password1" data-match-error="As passwords inseridas não são iguais." required />
                                <div class="help-block with-errors"></div>
                            </div>
                            <div class="form-group">
                                <div class="label">Telemóvel</div>
                                <input type="number" class="form-control" placeholder="Inserir telemóvel (facultativo)" data-minlength="O número inserido não é válido" data-minlength='8' name='phone_number' />
                                <div class="help-block with-errors"></div>
                            </div>
                            <div class="form-group">
                                <div class="label">Número de Identificação Fiscal</div>
                                <input type="text" class="form-control" placeholder="Inserir NIF" data-error="O NIF inserido não é válido. Insere 999999990, caso não desejes facultar NIF" data-remote='<?= $url;?>/users/validaNIF/' name='vat_number' required />
                                <div class="help-block with-errors"></div>
                            </div>
                            <div align="center">
                                <button class="btn btn-black" type='submit'>CRIAR UTILIZADOR</button>
                            </div>
                        </fieldset>    
                        <?= $this->Form->end() ?>
                        <br>
                        <p>Já tens conta?</p>
                        <div align="center" style='margin-bottom:30px'>
                            <button class="btn btn-black" id='login_button' >LOGIN</button>
                        </div>    
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
        </div>
    <?php endif;?>

        <div class="modal fade" id="suc">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-body">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <br>
                        <div style='padding: 100px 0'>
                            <h1>A mensagem foi enviada com sucesso.</h1>
                            <p>Receberás uma resposta assim que possível.</p>
                          </div>
                        <div align="center" style='margin-bottom:30px'>
                            <button type="button" class="btn btn-black" data-dismiss="modal">COMPREENDI</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.3/jquery.easing.min.js"></script>
<script>
(function($) {
    "use strict"; // Start of use strict


    $('.dropdown-toggle').hover(function(){
        var screenWidth = window.innerWidth;
        if(screenWidth > 900)
            $(this).addClass('open');
        }, function(){
            var screenWidth = window.innerWidth;
            if(screenWidth > 900)
                $(this).removeClass('open');
    });

    $('.dropdown-toggle a').click(function(event){
        var screenWidth = window.innerWidth;
        var dropdown = $(this).parent();
        if($(this).attr('value')){
            if(screenWidth > 900 || dropdown.hasClass('open'))
                window.location.href = $(this).attr('value');
            else
                dropdown.addClass('open');
        }

    /*
        if(screenWidth <= 900){
            if(dropdown.hasClass('open'))
                window.location.href = $(this).attr('value');
            else if ($(this).attr('value'))
                dropdown.addClass('open');
        }
        if(screenWidth > 900 && $(this).attr('value'))
            window.location.href = $(this).attr('value');*/
    });

    // Closes the Responsive Menu on Menu Item Click
    // $('.navbar-collapse ul li a').click(function(){ 
    //         $('.navbar-toggle:visible').click();
    // });

    // Offset for Main Navigation
    $('#mainNav').affix({
        offset: {
            top: 100
        }
    });

    $('#register_button').on('click', function(){
        $("#login").modal('hide');
        setTimeout(function(){ $("#register").modal('show'); }, 500);
    });

    $('#login_button').on('click', function(){
        $("#register").modal('hide');
        setTimeout(function(){ $("#login").modal('show'); }, 500);
    });

    $('form').validator();

	$('#city_selector').on('change', function(){
        window.location.href= "<?= $this->Url->build([ "controller" => 'frontend', 'action' => 'city'], true)?>"+"/"+$(this).val();
    });

    $('.navbar-toggle').on('click', function(){
        if($('#bs-example-navbar-collapse-1').is(':visible'))
            $('#toggle-icon').removeClass("fa-close").addClass("fa-bars");
        else 
            $('#toggle-icon').removeClass("fa-bars").addClass("fa-close");
    });

    $('.navbar a, .navbar .btn').mousedown(function(event){
        event.preventDefault();
    });

    $('.navbar a, .navbar .btn').click(function(event){
        document.activeElement = false;
        $(this).click();
    });

    $('.navbar-toggle').blur(function(event){
        var screenWidth = window.innerWidth;
        if (screenWidth < 900){
            console.log(screenWidth);
            $('#bs-example-navbar-collapse-1').collapse('hide');
            $('#toggle-icon').removeClass("fa-close").addClass("fa-bars");
        }
    });

    $('#report-form').on('valid.bs.validator', function(event){
        var screenWidth = window.innerWidth;
        if(event.relatedTarget.id == 'report-message') {
            $('.modal-footer .col-sm-6').addClass('captcha-push');
            $('#report-captcha').slideDown();
        }
    });

    $("#report form").submit(function(event) {
        var recaptcha = $(".modal #g-recaptcha-response").val();
        if (recaptcha === "") {
            event.preventDefault();
            alert("Por favor, confirma que não és um robô.");
        }
    });    

    <?php if(@$_GET['e'] == 1): ?>
        $("#login").modal();
    <?php endif ;?>

    <?php if(@$_GET['e'] == 2): ?>
        $("#register").modal();
    <?php endif ;?>

    <?php if(@$contact2 == 'success'): ?>
    $("#suc").modal();

    <?php endif; ?>

    <?php if (!$scity): ?>
    $("#city").modal();

    <?php endif; ?>

})(jQuery);

</script>

<style>

.fa-close{
    font-size: 1.3em;
    -webkit-text-stroke: 1.6px white;
    color: #FEB000;
}
.control {
    color:#000;
    margin:10px;
}
div#main_container {
    min-height: calc(100vh - 255px);
}
#city .wrapper  > * {
    margin: 5px;
}
#city .media {
  width: 300px;
  height: 200px;
  overflow: hidden;
  position: relative;
  display: inline-block;
  img {
      max-width: 100%;
      height: auto;
    }
}
#city .layer {
  opacity: 0;
  position: absolute;
  margin:auto;
  width: 0px;
  left:5%;
  top: 5%;
  height: 90%;
  background: #FFF;
  color: #151E3F;
  transition: all 0.9s ease;
  padding-top: 75px
}
#city p {
  text-align: center;
  font-size: 15px;
  letter-spacing:1px; 
    transition: all 0.9s ease;
    transform: scale(0.1)
}
#city .media:hover .layer {
  opacity: 0.8;
  width: 90%;
  transition: all 0.5s ease;
  cursor: pointer;
  p {
    transform: scale(1);
    transition: all 0.9s ease;
  }
}

#city .media:hover .layer p {
    transform: scale(1);
    transition: all 0.9s ease;
}
<?php if (!$scity): ?>
.modal-backdrop
{
    opacity:0.7 !important;
}
<?php endif; ?>

.modal{
    padding-right: 0 !important;
    margin: 10px;
}
.navbar-nav>li.dropdown-toggle li{
    text-align:center;
}  
@media (max-width:768px) {
    .navbar-nav .open .dropdown-menu > li > a {
    padding-left: 15px;
    }
}
@media (max-width:991px) {
    .footer #contactDiv{
        margin-top: 30px;
    }
}

    /* STYLING FOR REPORT MODAL (move to style.css...?) */

#reportDiv .fa-lightbulb-o{
    font-size: 6em;
    color: #FEB000;
    margin-bottom: 10px;
    border: 1px solid #FEB000;
    padding: 10px;
    border-radius: 15px;
}
#report textarea{
    width: 100%;
    margin: 30px 0 20px 0;
    resize: none;
}
#report .modal-footer .btn-black{
    margin-top: 0;
}
#report #textDiv{
    margin-left: 15px;
    margin-right: 15px;
}
#report .modal-header{
    padding-left: 45px;
    padding-right: 45px;
}
#report .g-recaptcha iframe{
    padding-left: 0;
    padding-right: 0;
}
@media (min-width: 768px){
    #report .modal-footer .captcha-push{
        float: none;
        display: table-cell;
        vertical-align: bottom;
    }
}
@media (max-width: 767px){
    #report .modal-footer{
        padding: 0;
    }
    #report .modal-footer .col-sm-offset-6{
        margin-top: 10px;
    }
    #report .modal-footer .g-recaptcha{
        margin-top:15px;
        padding: 0;
    }
    #report .modal-footer .g-recaptcha div{
        margin: auto;
        margin-bottom: 15px;
    }
}

</style>
</body>
</html>
