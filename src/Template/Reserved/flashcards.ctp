<?php $url = $this->Url->build(["prefix" => false, "controller" => '/'], true); ?>
<link rel="preload" href="<?= $url?>/img/spiner.gif">

<link rel="stylesheet" href="<?= $url; ?>/css/style_fc.css">

<section id="services" class="text-center ">
    <div class="container">
        <div class="row">
          <div class="col-md-20">
            <div class="panel with-nav-tabs panel-default">
                <div class="panel-heading">
                        <?php if(!isset($trial)): ?>
                        <ul class="nav nav-tabs" id='submenu'>
                            <li <?=  @$this->request->params['action'] == 'index' ? 'class="active"': ''?>><a href="<?= $this->Url->build(["prefix" => false, "controller" => 'reserved', "action" => "index"]) ?>">Cursos</a></li>
                            <li <?=  @$this->request->params['action'] == 'qbank' ? 'class="active"': ''?>><a href="<?= $this->Url->build(["prefix" => false, "controller" => 'reserved', "action" => "qbank"]) ?>">Perguntas</a></li>
                            <li <?=  @$this->request->params['action'] == 'fbank' ? 'class="active"': ''?>><a href="<?= $this->Url->build(["prefix" => false, "controller" => 'reserved', "action" => "fbank"]) ?>">Flashcards</a></li>
                            <li <?=  @$this->request->params['action'] == 'forum' ? 'class="active"': ''?>><a href="<?= $this->Url->build(["prefix" => false, "controller" => 'reserved', "action" => "forum"]) ?>">Dúvidas</a></li>
                            <?php if($isStudio): ?> <li <?=  @$this->request->params['action'] == 'videobank' ? 'class="active"': ''?>><a href="<?= $this->Url->build(["prefix" => false, "controller" => 'reserved', "action" => "videobank"]) ?>">Vídeos</a></li> <?php endif; ?>
                            <?php if(in_array(16, $courses) || in_array(15, $courses) || in_array(1, $courses)): ?> <li <?=  @$this->request->params['action'] == 'ebank' ? 'class="active"': ''?>><a href="<?= $this->Url->build(["prefix" => false, "controller" => 'reserved', "action" => "ebank"]) ?>">Exames</a></li> <?php endif; ?>
                            <li <?=  @$this->request->params['action'] == 'payments' ? 'class="active"': ''?>><a href="<?= $this->Url->build(["prefix" => false, "controller" => 'reserved', "action" => "payments"]) ?>">Pagamentos</a></li>                     
                        </ul>
                        <?php endif ?>
                </div>
              </div>
          </div>
        </div>

        <?php if(empty($flashcards)): ?>

        <div class="row">
            <div class="reserved-background"></div>
            <div class="col-md-10 col-md-offset-1" style='padding-top: 75px'>
                <h1>Olá <?= $Auth['first_name']; ?>!</h1>
                <p>Infelizmente, não encontrámos flashcards para os temas selecionados.</p><p> Estamos continuamente a aumentar a nossa base de dados, podes tentar novamente outro dia. Até lá, experimenta selecionar outros temas.</p><p><b>Bom estudo!</b></p><br>
                <button class='btn-black btn' onClick='window.location.href="<?= $this->Url->build(["action" => "fbank"])?>"'> NOVA PESQUISA </button> 
            </div>
        </div>

        <?php else: ?>

        <div class="row">
            <div class="reserved-background"></div>       
            <div class="col-md-4 col-md-offset-4">
                <a href='#' class='navi' onClick="$('#deck').cycle('prev');"><i class="fa fa-angle-left"></i></a>
                <input type="number" id="selector"> 
                <span> / </span> 
                <?= count($flashcards) ?> 
                <a href='#' class='navi' onClick="$('#deck').cycle('next');">
                  <i class="fa fa-angle-right"></i>
                </a>
            </div>
            <div class="col-md-2" id="favselDiv">
                <i class="fa fa-star" id="favsel" onClick='favorite()'></i>
                <span class="hovertext">Marcar como favorito!</span>
            </div>
            <div class="col-md-2" id="flashlessDiv">
                <i class="fa fa-thumbs-down" style="margin-left:10px;" id="flashless" onClick='flashWarning()'></i>
                <span class="hovertext">Ver menos flashcards como este!</span>

            </div>
        </div>

        <!--<div class="row">
            <div class="reserved-background"></div>
            <div class="col-md-4 col-md-offset-4">
                <div class="panel panel-default">
                    <div class="panel-heading text-left">
                        <br>
                        <?php  /* foreach ($flashcards as $key => $value) { $i = $key + 1;
                        if($key == 0){$class=" active";} else {$class = '';}
                        ?>
                        <a href="#" class='number <?= $class ?>' id='n<?= $key ?>' onClick='jump(event,<?= $key ?>)'><?= $i ?></a>
                        <?php }; */
                        ?>                 
                    </div>
                </div>
            </div>
        </div>-->

        <?php 
            $singlefc = false;
            if(count($flashcards) == 1){
              array_push($flashcards, $flashcards[0]);
              $singlefc = true ;
            }
        ?>

        <div class="row">
            <div id='loader'>          
                <img src='<?= $url?>/img/spiner.gif'/>
            </div>
            <div class="reserved-background"></div>
            <div id = "deckDiv" class="col-md-10 col-md-offset-1">       
                <ul id="deck">
                    <?php foreach ($flashcards as $key => $value): ?>
                    <?php $key = $singlefc ? 0 : $key; ?>
                    <li class="card" data-id='<?= $key ?>'>
                        <div class="side_one">
                            <span><b>FRENTE</b></span>
                            <span id="theme">
                              <b><?= $value['theme']['name']?></b>
                            </span>
                            <p><?= $value['front']?></p>
                        </div>
                        <div class="side_two">
                            <span><b>VERSO</b></span>
                            <p><?= $value['verse']?></p>
                        </div>
                    </li>
                    <?php endforeach; ?>
                </ul>
                <span class="fa-stack fa-3x button" onClick='correct()'>
                    <i class="fa fa-circle fa-stack-2x text-primary right"></i>
                    <i class="fa fa-check fa-stack-1x fa-inverse"></i>
                </span>
                <span class="fa-stack fa-3x button" onClick='wrong()'>
                    <i class="fa fa-circle fa-stack-2x text-primary wrong" ></i>
                    <i class="fa fa-times fa-stack-1x fa-inverse"></i>
                </span>               
            </div>
        </div>

        <?php endif; ?>
    </div>
</section>

<script src="<?= $url; ?>/bower_components/jquery-sparkline/dist/jquery.sparkline.min.js"></script>
<script src="<?= $url; ?>/js/flash_cards.js"></script>
<script src="<?= $url; ?>/js/jquery.cycle.js"></script>
<script src="<?= $url; ?>/js/modernizr-2.5.3.min.js"></script>
<script> 
var fav = []; 
<?php 
    foreach ($flashcards as $key => $value) { 
        if (@$value['users_flashcard']['favorite'] == 1) 
            echo "fav[$value[id]] = 1;"; 
        else 
            echo " fav[$value[id]] = 0;"; 
    }
    $js_array = json_encode($flashcards);
    echo "var flashcards = ". $js_array . ";\n"; 
?>

function favorite(){
    if($("#favsel").hasClass('fav'))
        $("#favsel").removeClass('fav');
    else
        $("#favsel").addClass('fav');
    
    if(fav[flashcards[selected]['id']] == 1) 
      fav[flashcards[selected]['id']] = 0; 
    else
      fav[flashcards[selected]['id']] = 1;

    <?php if(isset($Auth['id'])): ?>
    
    $.post( "<?= $url?>/reserved/flash-fav", { 
      id: flashcards[selected]['id'], 
      answer: fav[flashcards[selected]['id']]
    }).done(function( data ) {});

    <?php endif ?>
}


var less = []; 
<?php 
    foreach ($flashcards as $key => $value) { 
        if (@$value['users_flashcard']['flashWarning'] == 1) 
            echo "less[$value[id]] = 1;"; 
        else 
            echo " less[$value[id]] = 0;"; 
    }
    $js_array = json_encode($flashcards);
    echo "var flashcards = ". $js_array . ";\n"; 
?>

function flashWarning(){
    if($("#flashless").hasClass('less'))
        $("#flashless").removeClass('less');
    else
        $("#flashless").addClass('less');
    
    if(less[flashcards[selected]['id']] == 1) 
      less[flashcards[selected]['id']] = 0; 
    else
      less[flashcards[selected]['id']] = 1;
    
    <?php if(isset($Auth['id'])): ?>
    
    $.post( "<?= $url?>/reserved/flash-warning", { 
      id: flashcards[selected]['id'],
      name: <?= $Auth['id']; ?>,
      identidade: "<?= $Auth['first_name']." ".$Auth['last_name']; ?>", 
      answer: less[flashcards[selected]['id']]
    }).done(function( data ) {});
    
    <?php endif ?>
}

function correct(){
  $('#n'+id).removeClass('wrong');
  $('#n'+id).addClass('correct');
  $.post( "<?= $url?>/reserved/flash-answer", { 
    id: flashcards[selected]['id'], 
    answer: "1"
  }).done(function( data ) {
  });
  $('#deck').cycle('next');
}

function wrong(){
  $('#n'+id).removeClass('correct');
  $('#n'+id).addClass('wrong');
  $.post( "<?= $url?>/reserved/flash-answer", { 
    id: flashcards[selected]['id'], 
    answer: "0"
  }).done(function( data ) {
  });
  $('#deck').cycle('next');
}

$('#selector').on('change', function(){ 
    jump(event,parseInt($(this).val()-1))
});

$(document).ready(function() {
    $('#loader').fadeOut();
    $('#deckDiv').css('visibility', 'visible');
});
</script>






