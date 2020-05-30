<?php $url = $this->Url->build(["prefix" => false, "controller" => '/'], true); ?>
<!-- Header -->
    
<header style='background-image: url("<?= $url?>/img/banner1.jpg")'>
    <div class="container text-center">
        <span class='prelabel'>EKOS - Formar para a especialidade</span>
        <h1>Ajudamos a preparar o teu futuro</h1>
    </div>
</header>

<section id="intro" class='text-center'>
    <div class="container">
        <div class="row">
          <div class="col-md-10 col-md-offset-1">
            <h1>Um projeto formativo para um novo exame.</h1>
            <p>A EKOS ambiciona <b>contribuir para a formação médica em Portugal</b>, desenvolvendo um projeto formativo para estudantes e profissionais na área da medicina com o objetivo de transmitir <b>competências médicas e científicas</b> úteis para o seu percurso profissional e em particular para o <b>sucesso na prova nacional de acesso</b> à especialização médica. </p>
          </div>
        </div>

        <div class="row text-center" style='margin-top:50px'>
          <div class="col-md-4 animation-element">
            <span class="fa-stack fa-5x ">
              <i class="fa fa-circle fa-stack-2x text-primary"></i>
              <i class="fa fa-users fa-stack-1x fa-inverse"></i>
            </span>
            <h3>Objetivos formativos</h3>
            <p class='small text-muted'>Ajudar os nossos alunos a adquirir conhecimentos e competências técnicas que valorizem o seu desenvolvimento pessoal e profissional e contribuam para o sucesso na prova nacional de acesso.</p>
          </div>
          <div class="col-md-4 animation-element">
            <span class="fa-stack fa-5x">
              <i class="fa fa-circle fa-stack-2x text-primary"></i>
              <i class="fa fa-user-md fa-stack-1x fa-inverse"></i>
            </span>
            <h3>Metodologia pedagógica</h3>
            <p class='small text-muted'>Aulas presenciais com o limite máximo de 30 alunos construídas de raiz para estimular técnicas de organização e raciocínio clínico através da utilização de casos práticos e interação entre formador e alunos.</p>
          </div>
          <div class="col-md-4 animation-element">
            <span class="fa-stack fa-5x">
              <i class="fa fa-circle fa-stack-2x text-primary"></i>
              <i class="fa fa-random fa-stack-1x fa-inverse"></i>
            </span>
            <h3>Áreas de formação</h3>
            <p class='small text-muted'>A EKOS oferece formação destinada à preparação e aprendizagem médica e ao desenvolvimento de competências pessoais, procurando capacitar os alunos para o seu sucesso profissional.</p>
          </div>
        </div>
    </div>
</section>

<section class='text-sm-left text-center no-gutters about'>
    <div class="row is-flex">
        <div class="col-sm-4" style='background-image: url("<?= $url?>/img/sub_banner1.jpg?>"); justify-content: center; align-items: center; color:white; font-weight: bold; font-size:120%;'>
           
        </div>
        <div class="col-sm-8 bibliography_box">
            <h2>Visão.</h2>
            <p>Providenciar uma educação de excelência na área da medicina.</p>
            <button class='btn btn-black' style='margin-top:20px; width: 150px; color: #152335' onClick='window.location.href="<?= $this->Url->build(["prefix" => false, "controller" => 'informacoes']); ?>"'>SABE MAIS</button>
        </div>
    </div>
</section>

<section id="courses" class='text-center'>
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
              <h1>Os nossos cursos.</h1>
              <p>Para melhor te preparares para o novo exame, mais clínico e integrado, construímos para ti módulos pensados à medida: organizados por aparelhos funcionais, e não por secções da matriz, de forma a manter presente a integração clínica que é o foco do exame.<br> Estes são os cursos que temos preparados para ti!<br>
              <br> <strong>Curso de Preparação Anual | </strong><span style='font-size: 16px'>a decorrer || próxima edição em outubro 2020<br>(informações adicionais serão divulgadas em setembro)</span>
              <br> <strong>Curso de Preparação de Verão | </strong><span style='font-size: 16px'>inscrições em breve </span>
              <br> <strong>Curso de Gestão de Tarefas e Tempo | </strong><span style='font-size: 16px'>inscrições em breve </span>
              </p>
              <p><?= $this->Form->intpu('city', ['type' => 'select', 'options' => $cities2, 'style' => 'font-size: 12pt; margin-top:20px; visibility:hidden', 'value' => $scity, 'id' => 'city_selector'])?>
              </p>
            </div>
        </div>
        <div class="row hidden-sm hidden-xs">
            <div class="col-sm-4">
              <h2><span style='font-size:20px;'>Preparação para a PNA</span><br>Curso Anual</h2>
              <p class='small' style='margin-top: 30px'><a href='/programa_integrado.pdf' target="_blank"> <i class="fa fa-download"></i> Programa Integrado </a></p>
            </div>
            <div class="col-sm-4">
              <h2><span style='font-size:20px;'>Preparação para a PNA</span><br>Curso de Verão</h2>
              <p class='small' style='margin-top: 30px'><a href='/programa_integrado.pdf' target="_blank"> <i class="fa fa-download"></i> Programa Integrado </a></p>
            </div>
            <div class="col-sm-4">
              <h2>Curso de Gestão <br>de Tarefas e de Tempo</h2>
              <p class='small' style='margin-top: 30px'><a href='/programa_integrado.pdf' target="_blank"> <i class="fa fa-download"></i> Programa Integrado </a></p>
            </div>
        </div>
        <div class="row hidden-sm hidden-xs">
            <div class="col-sm-4">
              <table class='courses-list'>
                <?php 
                $count = count($courses);
                foreach ($courses as $key => $value) { 
                //if (--$count < 6) break;
                ?>
                <tr class='primary' id="<?= $key?>" onClick='window.location.href="<?= $this->Url->build(["prefix" => false, "controller" => 'cursos', 'c' => $value['id']]) ?>"'>
                    <td ><?= $value['name'] ?></td>
                    <td width='50px'><i class="fa fa-arrow-right"></i></td>
                </tr>
                <?php } ?>
              </table>
            </div>
            <div class="col-sm-4">
              <table class='courses-list'>
                <?php 
                foreach ($courses2 as $key => $value) { 
                ?>
                <tr class='primary' id="<?= $key?>" onClick='window.location.href="<?= $this->Url->build(["prefix" => false, "controller" => 'cursos', 'c' => 's'.$key]) ?>"'>
                    <td ><?= $value ?></td>
                    <td width='50px'><i class="fa fa-arrow-right"></i></td>
                </tr>
                <?php } ?>
              </table>
            </div>
            <div class="col-sm-4">
              <table class='courses-list'>
                <?php 
                foreach ($courses3 as $key => $value) { 
                ?>
                <tr class='primary' id="<?= $key?>" onClick='window.location.href="<?= $this->Url->build(["prefix" => false, "controller" => 'cursos', 'c' => 't'.$key]) ?>"'>
                    <td><?= $value ?></td>
                    <td width='50px'><i class="fa fa-arrow-right"></i></td>
                </tr>
                <?php } ?>
              </table>
            </div>
        </div>
        <div id="accordion" class="visible-sm visible-xs">
            <div class="card">
                <div class="card-header" id="headingOne" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne" >
                    <button class="btn btn-link">Curso Anual
                    </button>
                    <i class="fa fa-chevron-down" id='arrow_collapseOne' style='float:right; margin-right: 20px; margin-top:5px'>
                    </i>
                </div>
                <div id="collapseOne" class="collapse " aria-labelledby="headingOne" data-parent="#accordion">
                    <div class="box-body table-responsive no-padding">
                        <table class='courses-list'>
                            <?php 
                              $count = count($courses);
                              foreach ($courses as $key => $value) { 
                                //if (--$count < 6) break;
                              ?>
                            <tr class='primary' id="<?= $key?>" onClick='window.location.href="<?= $this->Url->build(["prefix" => false, "controller" => 'cursos', 'c' => $value['id']]) ?>"'>
                                <td ><?= $value['name'] ?></td>
                                <td><i class="fa fa-arrow-right"></i></td>
                            </tr>
                            <?php } ?>
                        </table>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header" id="headingTwo" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo" >
                    <button class="btn btn-link">Curso de Verão
                    </button>
                    <i class="fa fa-chevron-down" id='arrow_collapseTwo' style='float:right; margin-right: 20px; margin-top:5px'>
                    </i>
                </div>
                <div id="collapseTwo" class="collapse " aria-labelledby="headingTwo" data-parent="#accordion">
                    <div class="box-body table-responsive no-padding">
                        <table class='courses-list'>
                            <?php 
                              foreach ($courses2 as $key => $value) { 
                            ?>
                            <tr class='primary' id="<?= $key?>" onClick='window.location.href="<?= $this->Url->build(["prefix" => false, "controller" => 'cursos', 'c' => 's'.$key]) ?>"'>
                                <td ><?= $value?></td>
                                <td><i class="fa fa-arrow-right"></i></td>
                            </tr>
                            <?php } ?>
                        </table>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header" id="headingThree" data-toggle="collapse" data-target="#collapseThree" aria-expanded="true" aria-controls="collapseThree" >
                    <button class="btn btn-link">Curso de Gestão de Tarefas e de Tempo
                    </button>
                    <i class="fa fa-chevron-down" id='arrow_collapseThree' style='float:right; margin-right: 20px; margin-top:5px'>
                    </i>
                </div>
                <div id="collapseThree" class="collapse " aria-labelledby="headingThree" data-parent="#accordion">
                    <div class="box-body table-responsive no-padding">
                        <table class='courses-list'>
                            <?php 
                              foreach ($courses3 as $key => $value) { 
                            ?>
                            <tr class='primary' id="<?= $key?>" onClick='window.location.href="<?= $this->Url->build(["prefix" => false, "controller" => 'cursos', 'c' => 't'.$key]) ?>"'>
                                <td ><?= $value?></td>
                                <td><i class="fa fa-arrow-right"></i></td>
                            </tr>
                            <?php } ?>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
</section>
<!--   
<section id="recruting" class='bg-light text-center'>
    <div class="container">
        <div class="row">
          <div class="col-md-8 col-md-offset-2">
            <h1>Perguntas Exemplo.</h1>
            <p>Não sabes que tipo de perguntas vão sair na nova prova? A EKOS preparou para ti 25 perguntas-tipo, baseadas no modelo de vinheta clínica, para que possas saber o que te espera.</p>
            <button class="btn btn-black" onClick="window.open('http://ekos.pt/reserved/exam')" >COMEÇAR</button>
          </div>
        </div>
    </div>
</section>
    -->
<section id="contacts" class='bg-light text-sm-left text-center  no-gutters '>
    
      <div class="row is-flex">
        <!--<div class="col-sm-6" id="map">
          <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3111.7367055275845!2d-9.16313408465406!3d38.74680377959412!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xd1932e2ab3ac5a9%3A0x2c08088081f9689c!2sFaculdade%20de%20Medicina%20da%20Universidade%20de%20Lisboa!5e0!3m2!1spt-PT!2spt!4v1589802423263!5m2!1spt-PT!2spt" width="100%" height="100%" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>
        </div>-->
        <div class="col-sm-6" style='background-image: url("<?= $url?>/img/mapa2.png");'>
        </div>
        <div class="col-sm-6 bibliography_box" style='background-color:#eee; color: #152335'>
            <h2>Detalhes da nossa atividade formativa.</h2>
            <!--
            <p><b>Metodologia</b><br>Existirá uma turma semanal e uma turma ao sábado</p>
            <p><b>Avaliação</b><br>Na turma da semana, as aulas terão, normalmente, lugar às 2ª/4ª/5ª entre as 18h e as 20h. Na turma do sábado, as aulas terão lugar entre as 8h30 e às 16h00 </p>
            -->
            <p><b>Departamento de Formação</b><br><span style='font-size:16px;'>Gestor e Coordenador da Formação |</span><span style='font-size:14px;'> David Alves Berhanu</span><br><span style='font-size:16px;'>Responsável pelo Atendimento Diário |</span> <span style='font-size:14px;'> Ana Pereira Dagge</span></p>
            <button class="btn btn-black" onClick='window.location.href="<?= $this->Url->build(["prefix" => false, "controller" => 'matriz-ekos.pdf']); ?>"' >REGULAMENTO ATIVIDADE FORMATIVA</button>
        </div>
      </div>
    
</section>


 
<style>
section#contacts p{
	margin-bottom: 25px;
}

#map {
  margin-right: -15px;
}
@media (max-width:768px){
  #map {
    height:200px;
    margin-right: 0px;
  }
  iframe{
    padding-left:15px;
    padding-right: 15px;
  }
}
#accordion table{
  border-bottom: 0;
}
#accordion .table-responsive{
  border: none;
}
table.courses-list td:last-child{
  text-align: right;
  padding-right: 20px;
}
#accordion table tr{
  margin-left: 5px;
}
#accordion table.courses-list tr.primary td{
  padding-left: 10px;
}
.courses-list{
  margin-top: 35px;
}
</style>

<script>
var $animation_elements = $('.animation-element');
var $window = $(window);

function check_if_in_view() {
  var window_height = $window.height();
  var window_top_position = $window.scrollTop();
  var window_bottom_position = (window_top_position + window_height);

  var time = 100;

  $.each($animation_elements, function() {
    var $element = $(this);
    var element_height = $element.outerHeight();
    var element_top_position = $element.offset().top;
    var element_bottom_position = (element_top_position + element_height);

    //check to see if this current container is within viewport
    if ((element_bottom_position >= window_top_position) &&
      (element_top_position <= window_bottom_position)) {
      setTimeout( function(){ $element.addClass('in-view'); }, time)
      time += 150;
    }
  });
}

$window.on('scroll resize', check_if_in_view);
$window.trigger('scroll');

</script>
