<?php $url = $this->Url->build(["prefix" => false, "controller" => '/'], true); ?>
<link rel="preload" href="<?= $url?>/img/spiner.gif">

<style>
a.number{
  padding: 3px 5px;
  margin: 5px;
  display: inline-block;
  width: 30px;
  height: 30px;
  text-align: center;
}
a.number.active{
  font-weight: 600;
  color: black;
  border-bottom: 3px solid #FEB000; 
}
a.number.wrong{
  border-bottom: 3px solid red;
}
a.number.correct{
  border-bottom: 3px solid green;
}
.panel-body {
  font-size: 18px;
}
 .panel-body input{
  margin-right: 12px;
  position: relative;
  top: 8px;
}
.btn-black {
  padding:11px 20px; 
}
div.answer{
  display: none;
}
span.correct{ 
  color: green; 
  font-weight: bold;
}
span.wrong{ 
  color: red; 
  font-weight: bold;
}
span.button:hover {
  cursor: pointer;
}
span.button i {
  -webkit-transition:all 0.2s ease-in-out;
  -moz-transition:all 0.2s ease-in-out;
  -ms-transition:all 0.2s ease-in-out;
  -o-transition:all 0.2s ease-in-out;
  transition:all 0.2s ease-in-out
}
span.button:hover i.text-primary.right{
  color: green;
}
span.button:hover i.text-primary.wrong{
  color: red;
}
a.navi{
  color: #929dab;
  font-size: 18pt;
  margin: 0px 4px;
  position: relative;
  top: 3px;
}
a.navi:hover{
  color: white;
  font-weight: bold;
}
#favsel {
  transition: all 0.2s ease-in-out;
}
#favsel:hover{
  cursor: pointer;
  color: white;
}
#favsel.fav{
  color: #FEB000;
}
#loaderr img{
  top: 80px!important;
  left: 0!important;
  right: 0!important;
  margin: auto;

}
#deckDiv{
  visibility: hidden;
  /*z-index: -1;*/
}
</style>



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
                            <?php if(in_array(16, $courses) || in_array(15, $courses)): ?> <li <?=  @$this->request->params['action'] == 'ebank' ? 'class="active"': ''?>><a href="<?= $this->Url->build(["prefix" => false, "controller" => 'reserved', "action" => "ebank"]) ?>">Exames</a></li> <?php endif; ?>
                            <li <?=  @$this->request->params['action'] == 'payments' ? 'class="active"': ''?>><a href="<?= $this->Url->build(["prefix" => false, "controller" => 'reserved', "action" => "payments"]) ?>">Pagamentos</a></li>                     
                        </ul>
                </div>
              </div>
          </div>
        </div>

        <?php if(empty($flashcards)): ?>

        <div class="row" style='position:relative;'>
            <div class="reserved-background"></div>
            <div class="col-md-10 col-md-offset-1" style='padding-top: 75px'>
                <h1>Olá <?= $Auth['first_name']; ?>!</h1>
                <p>Infelizmente, não encontrámos flashcards para os temas selecionados.</p><p> Estamos continuamente a aumentar a nossa base de dados, podes tentar novamente outro dia. Até lá, experimenta selecionar outros temas.</p><p><b>Bom estudo!</b></p><br>
                <button class='btn-black btn' onClick='window.location.href="<?= $this->Url->build(["action" => "fbank"])?>"'> NOVA PESQUISA </button> 
            </div>
        </div>
    </div>
</section>

        <?php else: ?>

        <div class="row" style='position:relative;'>
            <div class="reserved-background"></div>       
            <div class="col-md-4 col-md-offset-4">
                <a href='#' class='navi' onClick="$('#deck').cycle('prev');"><i class="fa fa-angle-left"></i></a>
                    <input type="number" id="selector" style="
                          text-align: center;
                          width: 50px;
                          color: white;
                          background-color: #2C3949;
                          border: 1px solid #929dab;
                          padding: 4px 0px;
                          border-radius: 8px;
                    "> <span style='color: #929dab; font-size:17pt'> / </span> <?= count($flashcards) ?> 

                <a href='#' class='navi' onClick="$('#deck').cycle('next');"><i class="fa fa-angle-right"></i></a>
            </div>
            <div class="col-md-1" style='font-size:18pt; padding-top: 1px; color: #929dab'>
                <i class="fa fa-star" id="favsel" onClick='favorite()'></i>   
            </div>
        </div>

        <div class="row" style='position:relative;'>
            <div class="reserved-background"></div>
            <div class="col-md-4 col-md-offset-4">
                <div class="panel panel-default" style='background:transparent'>
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
        </div>

        <div class="row"  style='position:relative; '>

            <div id='loaderr' style = '/*height: 250px*/'>          
                <img src='<?= $url?>/img/spiner.gif' style='position: absolute; top: 35%; left: 47%; width:100px'/>
            </div>
            <div class="reserved-background"></div>
            <div id = "deckDiv" class="col-md-10 col-md-offset-1">       
                <ul id="deck">
                    <?php foreach ($flashcards as $key => $value) { $i = $key + 1; ?>
                    <li class="card" style='background-color: #f5f5f5' data-id='<?= $key ?>'>
                        <div class="side_one">
                            <span><b>FRENTE</b></span>
                            <span style='ddisplay:block;left: auto;right: 5px;background: #fff;border-radius:5px'><b><?= $value['theme']['name']?></b></span>
                            <p><?= $value['front']?></p>
                        </div>
                        <div class="side_two">
                            <span><b>VERSO</b></span>
                            <p><?= $value['verse']?></p>
                        </div>
                    </li>
                    <?php } ?>
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
    </div>
</section>

<script> 
var fav = []; 
<?php 
    foreach ($flashcards as $key => $value) { 
        if (@$value['flashcards_user'.$Auth['id']]['favorite'] == 1) 
            echo "fav[$value[id]] = 1;"; 
        else 
            echo " fav[$value[id]] = 0;"; 
    }
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
    
    $.post( "<?= $url?>/reserved/flash-fav", { 
      id: flashcards[selected]['id'], 
      answer: fav[flashcards[selected]['id']]
    }).done(function( data ) {});
 }

</script>

<script src="<?= $url; ?>/bower_components/jquery-sparkline/dist/jquery.sparkline.min.js"></script>
<script src="<?= $url; ?>/js/flash_cards.js"></script>
<script src="<?= $url; ?>/js/jquery.cycle.js"></script>
<script src="<?= $url; ?>/js/modernizr-2.5.3.min.js"></script>
<link rel="stylesheet" href="<?= $url; ?>/css/style_fc.css">

<script>
<?php 
    $js_array = json_encode($flashcards);
    echo "var flashcards = ". $js_array . ";\n"; 
?>

function correct(){
  $('#n'+id).removeClass('wrong');
  $('#n'+id).addClass('correct');
  $.post( "<?= $url?>/reserved/flash-answer", { id: flashcards[selected]['id'], answer: "1"})
  .done(function( data ) {

  });
  $('#deck').cycle('next');
}

function wrong(){
  $('#n'+id).removeClass('correct');
  $('#n'+id).addClass('wrong');
  $.post( "<?= $url?>/reserved/flash-answer", { id: flashcards[selected]['id'], answer: "0"})
  .done(function( data ) {

  });
  $('#deck').cycle('next');
}

$('#selector').on('change', function(){ 
    jump(event,parseInt($(this).val()-1))
});

$(document).ready(function() {
    $('#loaderr').fadeOut();
    $('#deckDiv').css('visibility', 'visible');
});
</script>


<?php endif; ?>




