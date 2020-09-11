<?php $url = $this->Url->build(["prefix" => false, "controller" => '/'], true); ?>

<?php

use Vimeo\Vimeo;

$client = new Vimeo("0af46bd862c619713814e571961d0c3f276fb58c", "I1w+gCaPsU49Wpy0JfsZCepYD/9hT88kJGkpnF4ko+MYhpTMYj+Un1kCpyFlGB8rvG59eAcIHKX103U8xP4zKBIzY1M612nXw+K/0hg5YITsvs/3eEFzbzojRXAIfKVg", "1c4b57b035d803815e1a0e13794815bc");

$uri = 'http://api.vimeo.com/me/albums/7542594/videos';
$response = $client->request('/albums/7542594/videos', array(), 'GET');
print_r($response);

//$response = $client->request('/tutorial', array(), 'GET');
//print_r($response);

?>
<?php if(@$e != 1): ?>
<section id="services" class="text-center ">
    <div class="container">
        <div class="row">
            <div class="col-md-20">
              <div class="panel with-nav-tabs panel-default" style='background:transparent'>
                  <div class="panel-heading">
                          <ul class="nav nav-tabs" id='submenu'>
                              <li <?=  @$this->request->params['action'] == 'index' ? 'class="active"': ''?>><a href="<?= $this->Url->build(["prefix" => false, "controller" => 'reserved', "action" => "index"]) ?>">Cursos</a></li>
                              <li <?=  @$this->request->params['action'] == 'qbank' ? 'class="active"': ''?>><a href="<?= $this->Url->build(["prefix" => false, "controller" => 'reserved', "action" => "qbank"]) ?>">Perguntas</a></li>
                              <li <?=  @$this->request->params['action'] == 'fbank' ? 'class="active"': ''?>><a href="<?= $this->Url->build(["prefix" => false, "controller" => 'reserved', "action" => "fbank"]) ?>">Flashcards</a></li>
                              <li <?=  @$this->request->params['action'] == 'forum' ? 'class="active"': ''?>><a href="<?= $this->Url->build(["prefix" => false, "controller" => 'reserved', "action" => "forum"]) ?>">Dúvidas</a></li>
                              <?php if(in_array(16, $courses) || in_array(15, $courses)): ?> <li <?=  @$this->request->params['action'] == 'ebank' ? 'class="active"': ''?>><a href="<?= $this->Url->build(["prefix" => false, "controller" => 'reserved', "action" => "ebank"]) ?>">Exames</a></li> <?php endif; ?>
                              <li <?=  @$this->request->params['action'] == 'payments' ? 'class="active"': ''?>><a href="<?= $this->Url->build(["prefix" => false, "controller" => 'reserved', "action" => "payments"]) ?>">Pagamentos</a></li>
                          </ul>
                  </div>
              </div>
            </div>
        </div>
        <div class="row">
        	 <!--<iframe src="https://player.vimeo.com/video/454322606" width="640" height="360" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>-->

        	<!--<iframe src="https://player.vimeo.com/video/454322606" width="640" height="360" frameborder="0" allow="autoplay" allowfullscreen>
 			</iframe>-->
 			<div style='padding:56.25% 0 0 0;position:relative;'><iframe src='https://vimeo.com/showcase/7542594/embed' allowfullscreen frameborder='0' style='position:absolute;top:0;left:0;width:100%;height:100%;'></iframe></div>


 			<!--<iframe src="https://player.vimeo.com/video/349093088" width="640" height="360" frameborder="0" allow="autoplay; fullscreen" allowfullscreen></iframe>-->

 			<!--<div id='title1'></div>
 			<div id='title2'></div>-->
        </div>
    </div>
</section>
<?php endif ?>




<script src="https://player.vimeo.com/api/player.js"></script>
<script>
/*
	var options01 = {
		id:454322606,
		width: 640
	};
	var options02 = {
		id:454322606,
		width: 640
	};

	var video01Player = new Vimeo.Player('title1', options01);
	var video02Player = new Vimeo.Player('title2', options02);

	video01Player.setVolume(0);
	video02Player.setVolume(0);

	video01Player.on('play', function(){
		console.log('Played video 1');
	});
	video02Player.on('play', function(){
		console.log('Played video 2');
	});*/
	$.ajax(
  		"https://api.vimeo.com/users/122823513/albums/7542594",
  		function(data){ console.log(data.html); }, 
  		"json"
  	);


	var iframe = document.querySelector('iframe');
    var player = new Vimeo.Player(iframe);

    player.setVolume(0);

    iframe.onmouseover = function(){
    	player.play();
    }

    player.on('play', function() {
      console.log('Played the video');
    });

    player.getVideoTitle().then(function(title) {
      console.log('title:', title);
    });

</script>