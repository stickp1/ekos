<?php $url = $this->Url->build(["prefix" => false, "controller" => '/'], true); ?>
<header style='background-image: url("<?= $url?>/img/banner2.jpg");'>
      <div class="container text-center">
        <span class='prelabel'>EKOS - Formar para a especialidade</span>
        <h1>Um novo exame, uma nova equipa.</h1>
      </div>
    </header>

    <section id="about" class='text-center'>
      <div class="container">
        <div class="row">
          <div class="col-md-8 col-md-offset-2">
            <h1>EKOS:</h1>
            <p>Do dialeto Yoruba, significa educação e aprendizagem, expressões que traduzem a base do nosso projeto.</p>
          </div>
        </div>
      </div>
    </section>

    <section id="services" class="bg-light text-center">
      <div class="container">
        <div class="row" style='margin-bottom:75px'>
          <div class="col-md-8 col-md-offset-2">
            <h1>A Equipa.</h1>
            <p>Juntámos uma equipa motivada e competente para te ajudar na preparação deste desafio. Vem conhecê-los!</p>
            <p><?= $this->Form->intpu('city', ['type' => 'select', 'options' => $cities2, 'style' => 'font-size: 12pt; margin-top:20px; display:none;', 'value' => $scity, 'id' => 'city_selector'])?></p>
          </div>
        </div>
        <div class='row is-flex'>
        	<?php 
          foreach ($teachers as $key => $value) { ?>
        	<div class="col-md-3 col-sm-6 animation-element" style='margin: 15px auto; max-width: 375px'>
        		<div class='team'>
        			<div class='row'>
	                 <div class="col-sm-12">
                      <div style='width:100%; max-width: 375px; display: inline-block;'>
		                  <img src="<?= $value['pic'] ?>" alt="User Image" style='width: 100%'>
                      </div>
                    </div>
		              </div>
	              <div class='row'>
	              	<div class="col-sm-12 text-left user-block" style='padding: 20px 35px'>
                    <span class="description" style="display:none;"><?= implode(", ", $value['moderators']) ?></span>
                    <span class="username"><?= $value['first_name']." ".$value['last_name'] ?></span>
                      
	              	<p class='bio' style="display: none;"><?= nl2br($value['description']) ?></p>
	              	</div>
                  </div>
                </div>
                
            </div>

             <?php } ?>


        </div>
      </div>
    </section>

    <section id="recruting" class='text-center'>
      <div class="container">
        <div class="row">
          <div class="col-md-8 col-md-offset-2">
            <h1>Junta-te à equipa.</h1>
            <p>Identificas-te com o nosso projeto e gostas de ensinar? </br>Acreditamos que ter pessoas motivadas a trabalhar connosco é a chave do sucesso. Se ficaste interessado e gostavas de colaborar com a EKOS, entra em contacto connosco.</p>

            <button class="btn btn-black" onClick="window.open('https://docs.google.com/forms/d/e/1FAIpQLSfHBU2zk3cuiRP0xND33cyQKQIPQzOfZQJHmEOAIK522AK-FQ/viewform')" >CANDIDATAR-ME</button>
          </div>
        </div>
      </div>
    </section>


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