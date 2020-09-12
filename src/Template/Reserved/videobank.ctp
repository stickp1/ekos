<?php $url = $this->Url->build(["prefix" => false, "controller" => '/'], true); ?>

<?php

use Vimeo\Vimeo;

$client = new Vimeo("0af46bd862c619713814e571961d0c3f276fb58c", "I1w+gCaPsU49Wpy0JfsZCepYD/9hT88kJGkpnF4ko+MYhpTMYj+Un1kCpyFlGB8rvG59eAcIHKX103U8xP4zKBIzY1M612nXw+K/0hg5YITsvs/3eEFzbzojRXAIfKVg", "1c4b57b035d803815e1a0e13794815bc");

$uri = 'http://api.vimeo.com/me/albums/7542594/videos';
$response = $client->request('/albums/7542594/videos',['background' => 1], 'GET');
?>

<?php if(@$e != 1): ?>
<section id="services" class="text-center ">
    <div class="container-fluid">
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
        <div class="row showcase">
    		<?php foreach($response['body']['data'] as $key=>$video): ?>

    			<div id="<?=$key?>" class="thumbvideo col-xs-4 col-sm-3 col-lg-2">
					<div class="thumbvideo-frame">
						<?= $video['embed']['html'] ?>
					</div>
					<div class="thumbvideo-buttons">
						<button class="play-pause-btn"><i class="fa fa-play"></i></button>
						<button class="mute-btn" ><i class="fa fa-volume-off"></i></button>
						<button id="save"><i class="fa fa-save"></i></button>
					</div>
				</div>        		
    		<?php endforeach ?>
    		<div class="showcase-scroll scroll-left hide">
    			<button>
    				<i class="fa fa-angle-left"></i>
    			</button>
    		</div>
    		<div class="showcase-scroll scroll-right">
    			<button>
    				<i class="fa fa-angle-right"></i>
    			</button>
    		</div>
        </div>
    </div>
</section>
<?php endif ?>


<style>
#main_container{
	background: #152133;
}
#mainNav{
	background: #FEB;
}
div.panel.with-nav-tabs{
	background: transparent;
	border-bottom: 1px solid #FEB;
}
div.panel.with-nav-tabs li a{
	color: #FEB;
}
section.footer{
	color: #152133;
	background: #FEB;
}
section.footer a{
	color: inherit;
}
section.footer #reportDiv .fa-lightbulb-o{
	color: #152133;
	border-color: #152133;
}
section.footer #reportDiv .fa-lightbulb-o:hover{
	color: #FEB000;
}
section.footer a:hover{
	color: #FEB000;
}
section#services{
	padding-bottom: 200px;
}
div.showcase{
	position: relative;
	overflow-x: auto;
	overflow-y: hidden;
	flex-wrap: nowrap;
	white-space: nowrap;
	padding-left: 30px;
	padding-right: 30px;
	margin-top: 100px;
	overflow: visible;
	-moz-transition: all 1s;
    -webkit-transition: all 1s;
    -o-transition: all 1s;
    transition: all 1s;
    font-size: 0; /* remove space between inline elements */
}
div.showcase::-webkit-scrollbar{
  	display:none;
}
div.showcase.hover{
	height:300px;
}
div.showcase-scroll{
	position:absolute;
	height: calc(100% - 5px);
	width: 27.5px;
	bottom: 5px;
	visibility: visible;
}
div.scroll-right{
	right: 0;
}
div.scroll-left{
	left: 0;
}
div.showcase-scroll.hide{
	visibility: hidden;
}
div.showcase-scroll button{
	width: 100%;
	height: 100%;
	border-radius: 10px 0 0 10px;
	border: none;
	background: #feb00082;
	box-shadow: 0 0px 20px 10px #FEB000;
}
div.showcase-scroll .fa{
	font-size: 50px;
	-webkit-text-stroke: 3px black;
	color: white;
}
div.thumbvideo{
	padding-left: 0;
	padding-right: 0;
	height: 100%;
	display: inline-block;
	position: relative;
	float: none;
	border-radius: 10px;
	left: 0;
	-moz-transition: all 0.5s;
    -webkit-transition: all 0.5s;
    -o-transition: all 0.5s;
    transition: all 0.5s;
}
div.thumbvideo .hover{
	overflow: visible;
}
div.thumbvideo .thumbvideo-frame{
	height: calc(100% - 5px);
	width: calc(100% - 5px);
	position: absolute;
	background: #152335;
	border-radius: 10px;
	overflow: hidden;
	-moz-transition: all 0.5s;
    -webkit-transition: all 0.5s;
    -o-transition: all 0.5s;
	transition: all 0.5s;
	left: 0;
	right: 0;
	margin: auto;
}
div.thumbvideo .thumbvideo-frame.hover{
	transform: scale(2);
	z-index: 2;
	border-radius: 10px 10px 0 0;
}
div.thumbvideo:first-child .hover{
	left: 50%;
}
div.thumbvideo iframe{
	position: relative;
	left: 0;
	right: 0;
	width: 100%;
	height: 100%;
}
div.thumbvideo .thumbvideo-buttons{
	border: 1px solid black;
	position: absolute;
	width: calc(100% - 5px);
	display: flex;
	visibility: hidden;
	flex-flow: row nowrap;
	justify-content: space-evenly;
	background: #FEB;
	border-radius: 0 0 10px 10px;
	left: 0;
	right: 0;
	border:0;
}
div.thumbvideo .thumbvideo-buttons.hover{
	visibility: visible;
	transform: scale(2);
	-moz-transition: all 0.5s;
    -webkit-transition: all 0.5s;
    -o-transition: all 0.5s;
	transition: all 0.5s;
}
div.thumbvideo .thumbvideo-buttons button{
	display: inline-block;
	justify-content: space-between;
	text-align: justify;
	height: 90%;
	width: 36px;
	background: transparent;
	border: 1px solid #152133;
	margin-top: auto;
	margin-bottom: auto;
	border-radius: 20px;
	position: relative;
}
div.thumbvideo .thumbvideo-buttons button .fa{
	font-size: 15px;
	color: #152133;
	width: 10px;
	height: 14px;
	left: 0;
	right: 0;
	top: 0;
	bottom: 0;
	margin: auto;
	position: absolute;

}
@media (max-width:767px){
	div.showcase{
		height: calc(100vw * 0.17);
	}
	div.thumbvideo .thumbvideo-buttons{
		height: calc(30vw * 0.17);
		bottom: calc(30vw * -0.17);
	}
	div.thumbvideo .thumbvideo-buttons.hover{
		bottom: calc(90vw * -0.17);
	}
	div.thumbvideo:nth-child(3n) .hover{
		left: -50%;
		right: 50%;
	}
}
@media (min-width:768px) and (max-width:1199px){
	div.showcase{
		height: calc(100vw * 0.13);
	}
	div.thumbvideo .thumbvideo-buttons{
		height: calc(30vw * 0.13);
		bottom: calc(30vw * -0.13);
	}
	div.thumbvideo .thumbvideo-buttons.hover{
		bottom: calc(90vw * -0.13);
	}
	div.thumbvideo:nth-child(4n) .hover{
		left: -50%;
		right: 50%;
	}
}
@media (min-width:1200px){
	div.showcase{
		height: calc(100vw * 0.09);
	}
	div.thumbvideo .thumbvideo-buttons{
		height: calc(30vw * 0.09);
		bottom: calc(30vw * -0.09);
	}
	div.thumbvideo .thumbvideo-buttons.hover{
		bottom: calc(90vw * -0.09);
	}
	div.thumbvideo:nth-child(6n) .hover{
		left: -50%;
		right: 50%;
	}
}

</style>

<script src="https://player.vimeo.com/api/player.js"></script>
<script>

	var player;
	var iframe = document.querySelector('div.thumbvideo iframe');
	var element;
	var timeoutId;
	var page = 0;

	function play(){
		timeoutId = null;
		player = new Vimeo.Player(element[0]);
		element.children('.thumbvideo-frame').addClass('hover');
		element.children('.thumbvideo-buttons').addClass('display');
		element.children('.thumbvideo-buttons').addClass('hover');
		element.children('.thumbvideo-buttons').children('.play-pause-btn').trigger('click');
	}

	function pause(){
		console.log('pausing...?');
		element.children('.thumbvideo-frame').removeClass('hover');
		element.children('.thumbvideo-buttons').removeClass('display');
		element.children('.thumbvideo-buttons').removeClass('hover');
		button = element.children('.thumbvideo-buttons').children('.play-pause-btn');
		player.getPaused().then(function(paused){
			if(!paused)
				button.trigger('click');
		});
		element = null;
	}

	$(document).ready(function(){
		console.log('ready');
		$('div.thumbvideo iframe').each(function(){
			$(this).attr('src', $(this).attr('src') + '&autoplay=0');
		});
	});

	$('div.thumbvideo').hover(function() {
		console.log(element);
		console.log($(this));
		if(player && element && $(this) != element)
			pause();
	    if (!timeoutId){
	    	element = $(this);
	        timeoutId = window.setTimeout(play, 1000);
	    }
	},
	function () {
	    if (timeoutId) {
	        window.clearTimeout(timeoutId);
	        timeoutId = null;
	    }
	    else pause();
	});

	$('.scroll-right button').click(function(){
		page++;
		$('div.thumbvideo').removeClass('move');
		$('<style>.move{ left: calc( '+ page +' * -100%)!important; }</style>').appendTo('head');
		$('div.thumbvideo').addClass('move');
		$('.scroll-left').removeClass('hide');

	});

	$('.scroll-left button').click(function(){
		page--;
		$('div.thumbvideo').removeClass('move');
		$('<style>.move{ left: calc( '+ page +' * -100%)!important; }</style>').appendTo('head');
		$('div.thumbvideo').addClass('move');
		$('.scroll-left').removeClass('hide');
		if(page == 0)
			$(this).parents('.showcase-scroll').addClass('hide');

	});

	
/*

	$('div.thumbvideo').hover(function(){
		element = $(this);
		player = new Vimeo.Player(element[0]);
		setTimeout(play, 1000);
		//$(this).siblings('.thumbvideo-buttons').show();	
		//$(this).children('iframe').addClass('hovered');
		
		//player.play();
		//player.setCurrentTime(50);
		
	}, function(){
		element.children('.thumbvideo-frame').removeClass('hover');
		element.children('.thumbvideo-buttons').removeClass('hover');
		//element.parents('.showcase').removeClass('hover');
		button = $(this).children('.thumbvideo-buttons').children('.play-pause-btn');
		player.getPaused().then(function(paused){
			console.log(paused);
			if(!paused)
				button.trigger('click');
		})
		//$(this).siblings('.thumbvideo-buttons').hide();	
	});
*/

	$('.thumbvideo-buttons').on('click', '.play-pause-btn', function(){
		if($(this).children('.fa').hasClass('fa-pause'))
		{
			player.pause();
			$(this).children('.fa').removeClass('fa-pause').addClass('fa-play');
		}
		else
		{
			player.play();
			$(this).children('.fa').removeClass('fa-play').addClass('fa-pause');
		}
	});

	$('.thumbvideo-buttons').on('click', '.mute-btn', function(){
		if($(this).children('.fa').hasClass('fa-volume-off'))
		{
			player.setVolume(0.5);
			$(this).children('.fa').removeClass('fa-volume-off').addClass('fa-volume-up');
		}
		else
		{
			player.setVolume(0);
			$(this).children('.fa').removeClass('fa-volume-up').addClass('fa-volume-off');
		}	
	});

</script>