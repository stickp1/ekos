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
            <h1>Um novo exame, uma nova abordagem.</h1>
            <p>A nova Prova Nacional de Acesso baseia-se num novo paradigma que pretende, mais do que uma simples memorização, estimular o raciocínio clínico. A EKOS foi pensada desde início para este novo modelo de prova. Eis algumas das características que nos distinguem: </p>
          </div>
        </div>

        <div class="row text-center" style='margin-top:50px'>
          <div class="col-md-4 animation-element">
            <span class="fa-stack fa-5x ">
              <i class="fa fa-circle fa-stack-2x text-primary"></i>
              <i class="fa fa-users fa-stack-1x fa-inverse"></i>
            </span>
            <h3>Turmas pequenas</h3>
            <p class='small text-muted'>Para um ambiente mais pedagógico e que estimule a interação, na EKOS todas as turmas são formadas por um máximo de 30 alunos.</p>
          </div>
          <div class="col-md-4 animation-element">
            <span class="fa-stack fa-5x">
              <i class="fa fa-circle fa-stack-2x text-primary"></i>
              <i class="fa fa-user-md fa-stack-1x fa-inverse"></i>
            </span>
            <h3>Casos clínicos</h3>
            <p class='small text-muted'>Todas as aulas da EKOS são baseadas na estimulação do raciocínio clínico através de casos práticos. No final de cada módulo, terás uma aula dedicada para reforçar esta aprendizagem e integrar conhecimentos.</p>
          </div>
          <div class="col-md-4 animation-element">
            <span class="fa-stack fa-5x">
              <i class="fa fa-circle fa-stack-2x text-primary"></i>
              <i class="fa fa-random fa-stack-1x fa-inverse"></i>
            </span>
            <h3>Integração de temas</h3>
            <p class='small text-muted'>Os nossos cursos encontram-se organizados por sistemas de órgãos, e não por temas da matriz, de forma a melhor integrares os conhecimentos adquiridos.</p>
          </div>
        </div>
    </div>
</section>

<section class='text-sm-left text-center no-gutters about'>
    <div class="row is-flex">
        <div class="col-sm-6" style='background-image: url("<?= $url?>/img/sub_banner1.jpg");    justify-content: center; align-items: center; color:white; font-weight: bold; font-size:120%; max'>
           
        </div>
        <div class="col-sm-6 bibliography_box">
            <h2>Análise Prova-Piloto.</h2>
            <p>A EKOS preparou para ti a análise da prova-piloto, para te ajudar a orientar o estudo!</p>
            <button class='btn btn-black' style='margin-top:20px; width: 150px; color: #152335' onClick='window.location.href="<?= $this->Url->build(["prefix" => false, "controller" => 'analise-pp.pdf']); ?>"'>VER ANÁLISE</button>
        </div>
    </div>
</section>

<section id="courses" class='text-center'>
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
              <h1>Os nossos cursos.</h1>
              <p>Para melhor te preparares para o novo exame, mais clínico e integrado, construímos para ti módulos pensados à medida: organizados por aparelhos funcionais, e não por secções da matriz, de forma a manter presente a integração clínica que é o foco do exame.<br> Estes são os cursos que temos preparados para ti!
              </p>
              <p><?= $this->Form->intpu('city', ['type' => 'select', 'options' => $cities2, 'style' => 'font-size: 12pt; margin-top:20px', 'value' => $scity, 'id' => 'city_selector'])?>
              </p>
            </div>
        </div>
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
              <table class='courses-list' style='margin-top:35px'>
                <?php 
                foreach ($courses as $key => $value) { 
                ?>
                <tr class='primary' id="<?= $key?>" onClick='window.location.href="<?= $this->Url->build(["prefix" => false, "controller" => 'cursos', 'c' => $value['id']]) ?>"'>
                    <td ><?= $value['name'] ?></td>
                    <td style='font-size:16px; padding-left:30px'><?php
                    if($value['e'] != 1){
                      echo $value['min_date']->i18nFormat('dd.MM.yyyy')." - ".$value['max_date']->i18nFormat('dd.MM.yyyy');} ?> </td>
                    <td width='50px'><i class="fa fa-arrow-right"></i></td>
                </tr>
                <?php } ?>
              </table>
            </div>
        </div>
    </div>
</section>
   
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
    
<section id="contacts" class='bg-light text-sm-left text-center  no-gutters '>
    
      <div class="row is-flex">
        <div class="col-sm-6" id="map">
          <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3111.7367055275845!2d-9.16313408465406!3d38.74680377959412!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xd1932e2ab3ac5a9%3A0x2c08088081f9689c!2sFaculdade%20de%20Medicina%20da%20Universidade%20de%20Lisboa!5e0!3m2!1spt-PT!2spt!4v1589802423263!5m2!1spt-PT!2spt" width="100%" height="100%" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>
        </div>
        <!--<div class="col-sm-6" style='background-image: url("<?= $url?>/img/mapa2.png");'>
        </div>-->
        <div class="col-sm-6 bibliography_box" style='background-color:#eee; color: #152335'>
            <h2>As nossas aulas.</h2>
            <p><b>Turmas</b><br>Existirá uma turma semanal e uma turma ao sábado</p>
            <p><b>Horário</b><br>Na turma da semana, as aulas terão, normalmente, lugar às 2ª/4ª/5ª entre as 18h e as 20h. Na turma do sábado, as aulas terão lugar entre as 8h30 e às 16h00 </p>
            <p><b>Local</b><br>As aulas terão lugar na FMUL e/ou na NMS|FCM</p>
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
