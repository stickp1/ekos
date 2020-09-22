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
    			<?php if(isset($videos[$video['name']])): ?>
	    			<div id="<?=$key?>" class="thumbvideo col-xs-4 col-sm-3 col-lg-2">
						<div class="thumbvideo-frame">
							<?= $video['embed']['html'] ?>
						</div>
						<?php 
							foreach($videos[$video['name']] as $t => $d):
								$title = $t;
								$description = $d;
								break;
							endforeach 
						?>
						<input type="hidden" name="title" value="<?= $title ?>">
						<input type="hidden" name="description" value="<?= $description ?>">	
						<?php if(isset($video_themes[$video['name']]) && isset($video_courses[$video['name']])): ?>
							<?php foreach(@$video_themes[$video['name']] as $theme => $theme_name): ?>
								<input type="hidden" name="themes[]" value="<?= $theme ?>">
							<?php endforeach ?>
							<?php foreach(@$video_courses[$video['name']] as $course => $course_name): ?>
								<input type="hidden" name="courses[]" value="<?= $course ?>">
							<?php endforeach ?>
						<?php endif ?>
						<div class="thumbvideo-framebtn"></div>
						<div class="thumbvideo-buttons">
							<button class="play-pause-btn"><i class="fa fa-play"></i></button>
							<button class="mute-btn" ><i class="fa fa-volume-off"></i></button>
							<button id="save">
								<i class="fa fa-start"></i>
								<i class="fa fa-start"></i>
								<i class="fa fa-start"></i>
								<i class="fa fa-start"></i>
								<i class="fa fa-start"></i>
								<i class="fa fa-start"></i>
								<i class="fa fa-start"></i>
								<i class="fa fa-start"></i>
								<i class="fa fa-start"></i>
								<i class="fa fa-start"></i>
							</button>
						</div>
					</div> 
				<?php endif ?>       		
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

<div class="modal fade" id="fullvideo">
    <div class="modal-dialog">
        <div class="modal-content">
	        <div class="modal-header">
	            <div id="fullvideo-frame">	
	            </div>
	            <h1 class="modal-title">title</h1>
	            <p id="fullvideo-description"></p>
	        </div>
	        <div class="modal-body">
	                <div id="fullvideo-related">
	                	<div class="row" style="border-top: 1px solid #152133">
	                		<div class="col-xs-12">
	                			Perguntas sobre este assunto
	                		</div>
	                	</div>
	                	<div class="row" id="options">
	                		<form id="qbank" method="post" target="_blank" action="<?= $this->Url->build(["action" => 'qbank']); ?>">
		                        <div class="col-xs-4"> 
		                            <div class="well well-sm q-options" id="difficulty">
		                                <div>Dificuldade</div>
		                                <div>
		                                    <input type="checkbox" name="difficulty[]" value="1" checked>Fácil
		                                </div>
		                                <div>
		                                    <input type="checkbox" name="difficulty[]" value="2" checked> Intermédio
		                                </div>
		                                <div> 
		                                    <input type="checkbox" name="difficulty[]" value="3" checked> Difícil
		                                </div>
		                            </div>
		                        </div>
		                        <div class="col-xs-4">   
		                            <div class="well well-sm q-options" id="filter">
		                                <div>Perguntas</div>
		                                <div>
		                                    <input type="checkbox" name="filter[]" class="filter-q" value="0">Novas
		                                </div>
		                                <div>
		                                    <input type="checkbox" name="filter[]" class="filter-q" value="1">Incorretas
		                                </div>
		                                <div>
		                                    <input type="checkbox" name="filter[]" class="filter-q" value="2">Favoritas
		                                </div>
		                                <div>
		                                    <input type="checkbox" name="filter[]" class="all-q" value="3" checked>Todas
		                                </div>
		                            </div>
		                        </div>
		                        <div class="col-xs-4">   
		                            <div class="well well-sm q-options" id="time">
			                            	<div>Temporizador</div>
			                                <div>
			                                    <input type="radio" name="timer" id="chronometer" value="0"> Cronómetro
			                                </div>
			                                <div>
			                                    <input type="radio" name="timer" class="timer" id="no-lim" value="1">
			                                </div>
			                                <div id="tempo_input">
			                                    <input type="text" name="time-lim" class="timer" value="60"> min
			                                </div>
			                               	<hr id="separator">
			                               	<div>
			                               		<button id="questionGo" type="submit">Start</button>
			                                </div>
		                            </div>
		                        </div>
	                    	</form>
	                    </div>
	                	<div class="row" style="border-top: 1px solid #152133">
	                		<div class="col-xs-12">
	                			Flashcards sobre este assunto
	                		</div>
	                	</div>
	                </div>
	                <div class="modal-footer row">
	                    <div class="col-sm-6 col-sm-offset-6 col-xs-12 text-sm-right text-center">
	                    </div> 
	                </div>
	        </div>
        </div>
    </div>
</div>
<?php endif ?>

<style>
#main_container{
	background: #152133;
}
#mainNav{
	background: #ffdf80;
}
div.panel.with-nav-tabs{
	background: transparent;
	border-bottom: 1px solid #FEB;
}
div.panel.with-nav-tabs li a{
	color: #ffdf80;
}
section.footer{
	color: #152133;
	background: #ffdf80;
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
div.thumbvideo .thumbvideo-frame, .thumbvideo-framebtn{
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
div.thumbvideo .thumbvideo-framebtn{
	background: transparent;
}
div.thumbvideo .thumbvideo-frame.hover, .thumbvideo-framebtn.hover{
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
	height: 80%;
	width: 20%;
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
	left: 35%;
	top: 0;
	bottom: 0;
	margin: auto;
	position: absolute;
}
div.thumbvideo .thumbvideo.buttons button .fa-star{
	position: relative;
	justify-content: space-between;
}
@media (max-width:576px){
	div.thumbvideo .thumbvideo-buttons button .fa{
		font-size: 10px;
		left: 35%;
		right: none;
		top: 25%;
		bottom: none;
	}
}
@media (max-width:768px){  /* apparently max-width is not included....*/
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
.modal-header{
	height:  fit-content;
	padding: 0;
	border-bottom: none;
}
#fullvideo-frame{
	height: 340px;
	border: 1px solid black;
}
@media(max-width:767px){
	#fullvideo-frame{
		height: calc(53vw);
	}
}
#fullvideo-frame iframe{
	height: 100%;
	width: 100%;
}
.modal-title{
	font-size: 1.8em;
	padding-top: 10px;
	padding-left: 15px;
}
#fullvideo-description{
	font-size: 1em;
	padding-top: 10px;
	padding-left: 15px;
}
.modal-content{
	border-radius: 10px;
	background: #FFDF80;
}
.modal-footer{
	border: none;
}


#fullvideo input[type='checkbox'], #fullvideo input[type="radio"], #fullvideo input[type="text"]{
        -webkit-appearance: none;
        outline: none;
        border: 2px solid gray;
        margin-left: 3px
}
#fullvideo input[type='checkbox']:before, #fullvideo input[type="radio"]:before{
        content: '';
        display: block;
        width: 50%;
        height: 50%;
        margin: 25% auto;
}
#fullvideo input[type="checkbox"]:checked:before, #fullvideo input[type="radio"]:checked:before{
        background: #FEB000;
}
#fullvideo input[type='checkbox']:checked, #fullvideo input[type="radio"]:checked{
    border: 2px solid #152335;
}
#fullvideo input[type='checkbox']:disabled, #fullvideo input[type="text"]:disabled{
    border: 2px solid grey;
    background: grey!important;
}
.q-options{
    padding-top: 45px;
    position:relative;
    display: flex;
    flex-direction: column;
    align-content: space-between;
    height:90%;
    font-size:12pt;
    margin-top:10px;
    text-align: left;
    border: 2.2px solid #152335;
    border-radius: 10px;
}
.q-options#time{
	padding-bottom: 35px;
}
.q-options input[type='checkbox'], .q-options input[type='radio']{
    width:20px; 
    height:20px; 
    position:relative; 
    top:5px;
    margin-right: 5px;
}
.q-options input[type='text']{
    width:35px; 
    height:auto; 
    text-align: center;
    position:relative; 
    background-color: transparent;
}
.q-options #tempo_input{
    text-align:center;
    margin-top:-22px;
}
.q-options div:first-child{
    font-weight: bold;
    position: absolute;
    top: 15px;
    text-align: center;
    left:0;
    right:0;
}
#fullvideo hr#separator{
    margin: 18px 0 10px 0;
    border: 0.5px solid black;
    background: black;
}
#fullvideo .row#options{
    display: block;
}
@media(min-width: 1200px){
    .row#options{
        display: flex;
    }
}
@media(max-width: 768px){
    .row#options>.col-lg-3:nth-child(odd) .q-options{
        float:right;
    }
    .row#options>.col-lg-3:nth-child(even) .q-options{
        float:left;
    }
}
.row#options::before{
    display: block;
}
@media(max-width: 500px){
    .q-options{
        width:100%;
    }
    .col-xs-6{
        padding-right: 5px;
        padding-left: 5px;
    }
}
#questionGo{
	position: absolute;
	bottom: 8px;
	left: 0;
	right: 0;
	margin: auto;
	background: #ffdf80;
	border-radius: 5px;
	width: 60%;
}
@media(max-width:590px){
	#qbank .col-xs-4{
		padding-left: 5px;
		padding-right: 5px;
	}
}
@media(max-width:506px){
	#qbank .col-xs-4{
		width:100%;
	}
	#qbank .q-options{
		flex-direction: row;
		justify-content: space-around;
	}
	#qbank .q-options#time{
		padding-bottom: 5px;
		margin-bottom: 40px;
	}
	hr#separator{
		display:none;
	}
	#qbank #tempo_input{
		margin-top: 5px;
		margin-left: -30px;
	}
	#qbank #questionGo{
		bottom: -35px;	
	}
}
@media(max-width:360px){
	#qbank .q-options{
		flex-direction: column;
	}
	#qbank #tempo_input{
		margin-top: -23px;
		margin-left: -90px;
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
	var videoNr = <?= count($response['body']['data']) ?>;

	function play(){
		timeoutId = null;
		player = new Vimeo.Player(element[0]);
		element.children('.thumbvideo-frame').addClass('hover');
		element.children('.thumbvideo-framebtn').addClass('hover');
		element.children('.thumbvideo-buttons').addClass('hover');
		element.children('.thumbvideo-buttons').children('.play-pause-btn').trigger('click');
	}

	function pause(){
		console.log('pausing...?');
		element.children('.thumbvideo-frame').removeClass('hover');
		element.children('.thumbvideo-framebtn').removeClass('hover');
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
		if(player && element && $(this) != element)
			pause();
	    if (!timeoutId){
	    	element = $(this);
	        timeoutId = window.setTimeout(play, 500);
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

	$('.thumbvideo-framebtn').click(function(){
		selected = $(this).siblings('.thumbvideo-frame');
		selected.children('iframe').detach().appendTo($('#fullvideo-frame'));
		src = $('#fullvideo-frame iframe').attr('src');
		src2 = src.substring(0, src.indexOf('background') + 11) + 0 + src.substring(src.indexOf('background') + 12, src.length);
		$('#fullvideo-frame iframe').attr('src', src2);
		
		$('#fullvideo .modal-title').text($(this).siblings('input[name="title"]').val());
		$('#fullvideo-description').text($(this).siblings('input[name="description"]').val());
		$(this).siblings('input[name="courses[]"]').detach().appendTo('#qbank');
		$(this).siblings('input[name="themes[]"]').detach().appendTo('#qbank');
		$('#fullvideo').modal('show');
	});

	$('#fullvideo').on('hidden.bs.modal', function(){
		$('#fullvideo-frame iframe').attr('src', src);
		$('#fullvideo-frame iframe').detach().appendTo(selected);
		$('#fullvideo input[name="courses[]"]').detach().appendTo(selected.parent());
		$('#fullvideo input[name="themes[]"]').detach().appendTo(selected.parent());
	});

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

	$('.all-q').on('click', function(){
    if($(this).prop('checked'))
        $('.filter-q').prop('checked', false);
	});
	$('.filter-q').on('click', function(){
	    $('.all-q').prop('checked', false);
	});


	/*$('#questionGo').on('click', function(){
		courses = $('#qbank input[name="courses[]"]').val();
		themes = $('#qbank input[name="themes[]"]').val();
		difficulty = $('#qbank input[name="difficulty[]"]').val();
		filter = $('qbank input')
		$.post("<?= $url?>/reserved/message-table-get", {
			courses: ,
    		themes: ,
    		difficulty: ,
    		filter: ,
    		timer: 
    		time-lim: 
		})
	});*/

</script>