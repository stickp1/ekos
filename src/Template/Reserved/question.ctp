<?php $url = $this->Url->build(["prefix" => false, "controller" => '/'], true); ?>
<style>
section#services{
  padding-bottom: 130px;
}
a.number, a.pointer{
  padding: 3px 5px;
  margin: 5px;
  display: inline-block;
  width: 30px;
  height: 30px;
  text-align: center;
  color: #F5F5F5;
  border: 1px solid #929dab;
  border-radius: 8px;
}
a.number.active{
  font-weight: 600;
  color: #FEB000;
  border-bottom: 2px solid #FEB000; 
  border-right: 1px solid #FEB000;
}
a.number.wrong{
  border-bottom: 3px solid red;
  border-right: 1px solid red;
}

a.number.correct{
  border-bottom: 3px solid green;
  border-right: 1px solid green;
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
input[type='radio'] {
      -webkit-appearance: none;
      width: 30px;
      height: 30px;
      border-radius: 50%;
      outline: none;
      border: 2px solid gray;
  }

input[type='radio']:before {
      content: '';
      display: block;
      width: 50%;
      height: 50%;
      margin: 25% auto;
      border-radius: 50%;
  }

input[type="radio"]:checked:before {
      background: #FEB000;
  }

input[type='radio']:checked {
  border: 3px solid #152335;
}
#graph{
  display: none
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
#banner{
  background-color: #2C3949; 
  position: relative;
  top: -31px;  
  min-height:50px;
  width: 100vw;
  margin-left: -50vw; 
  left: 50%; 
  z-index: 2; 
  padding-top:6px; 
  padding-bottom: 10px;
  text-align: center; 
  color: white; 
  font-size:12pt
}
div#question-selector{
  float: none;
}
input#selector{
    text-align: center;
    width: 50px;
    color: white;
    background-color: #2C3949;
    border: 1px solid #929dab;
    padding: 4px 0px;
    border-radius: 8px;
}
input#selector + span{
  color: #929dab; 
  font-size:17pt;
}
#difficulty{
  position: absolute;
  right: 0;
  top: -88px;
  z-index: 2;
  font-size:18pt; 
  padding-top: 1px; 
  color: #929dab;
  text-align: right;
  width: auto;
}
#question-body{
  margin-top: -10px;
}
#question-body img{
  max-width: 90%; 
  max-height: 400px;
  margin-bottom: 30px;
}
div#question-image{
  text-align: center;
}
#question-slider::-webkit-scrollbar{
  display:none;
}
#question-slider{
  margin-top: 5px;
  margin-bottom: 10px;
  overflow-x: auto;
  flex-wrap: nowrap;
  white-space: nowrap;
  box-shadow: inset 30px 0px 10px -20px #FEB000, inset -30px 0px 10px -20px #FEB000;
}
#question-slider a:first-child{
  margin-left: 20px;
}
#question-slider a:last-child{
  margin-right: 20px;
}
#question-slider a.pointer:first-child, #question-slider a.pointer:last-child{
  width: auto;
}

<?php if(count($question_list[$pointer])==100): ?>

#question-slider a:last-child{
  width: auto;
}
#question-slider a:nth-last-child(2){
  width: auto;
}

<?php endif ?>

.tab-pane{
  position: relative;
}
a.pointer{
  font-style: italic;
}
#timer{
  position: absolute;
  top:-62px;
  left:0;
  margin-left:30px;
  z-index: 2;
  color: white;
  font-size: 17px;
}
.favorite{
  position: absolute;
  z-index: 2;
  left: 0;
  top: -85px;
  font-size:18pt; 
  padding-top: 1px; 
  color: #929dab;
}
<?php if(isset($timer0) && $timer != -1): ?>

.favorite{
  top: -35px;
}

<?php endif ?>
.favorite i{
  transition: all 0.2s ease-in-out;
}
.favorite i:hover{
  cursor: pointer;
  color: #FEB000;
}
.favorite .fav{
  color: #FEB000;
}
@media(max-width:500px){
  .favorite span{
    display: none;
  }
}
#minutes{
  display: none;
}
#finishBtn{
  position: absolute;
  right: 0;
  left: 0;
  margin-left: auto;
  margin-right: auto;
  bottom: -70px;
  width: 180px;
}
</style>



<section id="services" class="text-center ">
    <div class="container">
        <div class="row" id="reserved-tabs">
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

        <?php if(isset($none)): ?>

        <div class="row" id="nothing-found" style='position:relative;'>
            <div class="reserved-background"></div>
            <div class="col-md-10 col-md-offset-1" style='padding-top: 75px'>
                <h1>Olá <?= $Auth['first_name']; ?>!</h1>
                <p>Infelizmente, não encontrámos perguntas para os temas selecionados.</p><p> Estamos continuamente a aumentar a nossa base de dados de perguntas, podes tentar novamente outro dia. Até lá, experimenta selecionar outros temas.</p><p><b>Bom estudo!</b></p><br>
                <button class='btn-black btn' onClick='window.location.href="<?= $this->Url->build(["action" => "qbank"])?>"'> NOVA PESQUISA </button> 
            </div>
        </div>

        <?php else: ?>

        <div class="row" id="question-header" style='position:relative;'>
            <div id="banner">
                <div id="question-slider">
                    <?php if($pointer > 0): ?>
                        <a class="pointer" href="#" id="n_prev">
                            anteriores <?=count($question_list[$pointer-1])?> perguntas 
                        </a>
                    <?php endif ?>
                    <?php for($counter = 0; $counter < count($question_list[$pointer]); $counter++): ?>  
                    <?php $i = $question_ids[$counter] ?>
                        <a href="#q<?= $i?>" class="number" data-toggle="tab" id="n<?= $counter + 1 ?>">
                            <?= $counter + 1  ?>
                        </a>
                    <?php endfor ?>
                    <?php if(count($question_list) > $pointer + 1): ?>
                        <a class="pointer" href="#" id="n_next">
                            próximas <?=count($question_list[$pointer+1])?> perguntas
                        </a>
                    <?php endif ?>
                </div>
                <div id="question-selector" class="col-md-4 col-md-offset-4">
                    <a href="#" class="navi prev">
                        <i class="fa fa-angle-left" ></i>
                    </a>
                    <input type="number" id="selector" value="1"> 
                    <span> / </span> 
                    <?= count($question_list[$pointer]) ?> 
                    <a href='#' class='navi next'>
                      <i class="fa fa-angle-right"></i>
                    </a>
                </div>
            </div>
        </div>

        <div class="row" id="new-question-body" style='position:relative;'>
            <div class="col-md-10 col-md-offset-1">
                <div id="timer"></div>
                <input type="hidden" id="minutes" value="<?= $timer?>" />
                <div class="panel-body">
                    <div class="tab-content">
                        <?php $counter = 0; ?>
                        <?php foreach ($questions as $key => $value): ?>
                            <?php $i = $value['id']; $counter++; ?>
                            <div class="tab-pane fade in" id="q<?= $i ?>"> <b><?= $value['question']; ?></b>
                                <?php $corr = $question_list[$pointer][$value['id']]['corr'] ?>
                                <?php if($corr): ?>
                                    <div id="difficulty" class="col-md-1">
                                        <i class="fa fa-lightbulb-o" style='color: #FEB000'></i>    
                                        <i class="fa fa-lightbulb-o" <?= $corr > 1 ? "style='color: #FEB000'" : '' ?>></i>    
                                        <i class="fa fa-lightbulb-o" <?= $corr > 2 ? "style='color: #FEB000'" : '' ?>></i>
                                    </div>
                                <?php endif; ?>
                                <div class="favorite" style="display: flex; justify-content: center; align-items: center;">
                                  <i class="fa fa-star <?= $question_list[$pointer][$i]['fav'] ? 'fav' : ''?>" id="fav<?= $i ?>"></i><span style="font-size: 0.5em; font-style:italic; margin-left: 10px;"> marcar como favorito</span>   
                                </div>
                                <br> 
                                <br>
                                <?php if($value['pic'] != '') {
                                    echo "<p style='text-align:center'> <img src='$url/img/questions/$value[pic]' style='max-width: 90%; max-height: 400px;' /> </p><br><br>";
                                }
                                ?>       
                                <?php if ($value['op1'] != ''): ?>
                                    <input type='radio' name='q<?= $i ?>' value='1' <?= @$question_list[$pointer][$i]['answer']==1 ? "checked" : ""?> class='radio-btn'/> 
                                    <span id='l<?= $i ?>_1'> <?= $value['op1']; ?> </span><br> 
                                <?php endif ?>
                                <?php if ($value['op2'] != ''): ?>
                                    <input type='radio' name='q<?= $i ?>' value='2' <?= @$question_list[$pointer][$i]['answer']==2 ? "checked" : ""?>/> 
                                    <span id='l<?= $i ?>_2'><?= $value['op2']; ?> </span><br> 
                                <?php endif ?>
                                <?php if ($value['op3'] != ''): ?>
                                    <input type='radio' name='q<?= $i ?>' value='3' <?= @$question_list[$pointer][$i]['answer']==3 ? "checked" : ""?>/> 
                                    <span id='l<?= $i ?>_3'><?= $value['op3']; ?> </span><br> 
                                <?php endif ?>
                                <?php if ($value['op4'] != ''): ?> 
                                    <input type='radio' name='q<?= $i ?>' value='4' <?= @$question_list[$pointer][$i]['answer']==4 ? "checked" : ""?>/> 
                                    <span id='l<?= $i ?>_4'><?= $value['op4']; ?> </span><br> 
                                <?php endif ?>
                                <?php if ($value['op5'] != ''): ?>
                                    <input type='radio' name='q<?= $i ?>' value='5' <?= @$question_list[$pointer][$i]['answer']==5 ? "checked" : ""?>/> 
                                    <span id='l<?= $i ?>_5'><?= $value['op5']; ?> </span><br> 
                                <?php endif ?>
                                <br> 
                                <div class='answer' id="a<?= $i ?>" <?= $question_list[$pointer][$i]['answer'] > 0 ?  "style='display: block'" : ($timer==-1 ? "style='display: block'" : "") ?>>
                                    <div id="graph" style='text-align: center; padding: 20px;' ></div>
                                    <label><b>Justificação</b></label>
                                    <br>
                                    <em><?= $value['justification']?></em>
                                </div>
                                <p style='text-align: center'> 
                                    <button class='prev btn-black btn' id='p<?= $i?>'> « </button>  
                                    <button class='submit btn-black btn' id='b<?= $i ?>' <?= $question_list[$pointer][$i]['answer'] > 0 ?  "disabled" : "" ?>> Validar 
                                    </button>
                                    <button class='next btn-black btn' id='nn<?= $i ?>'> » </button> 
                                </p>
                                <input type="hidden" id="solution<?= $i ?>" value="<?= $value['correct']?>"/>
                                <?php for($option=1;$option<6;$option++): ?>
                                    <input type="hidden" id="a<?= $option ?>_<?= $i ?>" value="<?= $value['a'.$option]?>" />
                                <?php endfor ?>
                            </div>
                        <?php endforeach ?>
                    </div>
                    <button class='btn-black btn' id='finishBtn'> Terminar 
                    </button> 
                </div>
            </div>            
        </div>

        <?php endif; ?>
    </div>
</section>

<div class="modal fade" id="finished">
    <div class="vertical-alignment-helper">
        <div class="modal-dialog vertical-align-center">
            <div class="modal-content">
                <div class="modal-body">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <br>
                    <h3>Perguntas concluídas!</h3>
                    <p> A tua fração de perguntas certas foi: </p>
                    <?php $color = @$cans/(@$wans + @$nans + @$cans) > 32.5 ? (@$cans/(@$wans + @$nans + @$cans) > 55 ? 'green' : 'olive') : 'maroon'; ?>
                    <p id="grade" style="<?="color: $color"?>"> <b> <?= @$cans ?> / <?= (@$wans + @$nans + @$cans) ?> </b></p>
                    <p> Perguntas erradas: <?= @$wans ?></p>
                    <p> Perguntas por reponder: <?= @$nans ?></p>
                    <p> As tuas respostas foram registadas com sucesso.</p>  
                    <br> 
                </div>
            </div>
        </div>
    </div>
</div>


<script src="<?= $url; ?>/bower_components/jquery-sparkline/dist/jquery.sparkline.min.js"></script>
<?= $this->Html->script('jquery.countdown.js'); ?>
<script>

all_ids = <?php echo json_encode(array_flip($question_ids)); ?>;
all_qids = <?php echo json_encode($question_ids); ?>;
question_list = <?php echo json_encode($question_list[$pointer]); ?>;
today = new Date();
console.log(question_list);

<?php foreach($questions as $key => $value): ?>
    <?php $i = $value['id']; ?>
    <?php if($question_list[$pointer][$i]['answer'] > 0 || $timer==-1): ?>
    
        $('#l'+<?= $i ?>+'_<?=$value['correct']?>').addClass('correct');
        question_nr = all_ids[<?= $i ?>]+1;

        <?php if($value['correct'] != $question_list[$pointer][$i]['answer']): ?>
          $('#l<?= $i."_".$question_list[$pointer][$i]['answer'] ?>').addClass('wrong');
          $('#n'+question_nr).addClass('wrong');
        <?php else: ?>
          $('#n'+question_nr).addClass('correct');
        <?php endif ?>

        doGraph(<?= $i ?>);
    <?php endif; ?>
<?php endforeach; ?>


<?php if($timer==-1): ?>
  $("#finished").modal();
<?php elseif($timer0): ?>
  today.setMinutes(today.getMinutes() + <?= floor($timer) ?>);
  today.setSeconds(today.getSeconds() + <?= ($timer - floor($timer)) * 60 ?>);
  $("#timer").countdown(today).on('update.countdown', function(event) {
        var $this = $(this);
        $this.html(event.strftime('<span>%H:%M:%S</span>'));
        $this.next().val((event.offset.hours * 60 + event.offset.minutes + event.offset.seconds/60).toFixed(2));
  }); 
  $("#timer").countdown(today).on('finish.countdown', function(event) {
      unvalidated(<?= $pointer ?>, -1);
  });
<?php elseif(isset($timer0)): ?>
  today.setMinutes(today.getMinutes() - <?= floor($timer) ?>);
  today.setSeconds(today.getSeconds() - <?= ($timer - floor($timer)) * 60 ?>);
  $("#timer").countdown(today, {elapse: true})
    .on('update.countdown', function(event) {
        var $this = $(this);
        if (event.elapsed) {
           $this.html(event.strftime('<span>%H:%M:%S</span>'));
           $this.next().val(event.offset.hours * 60 + event.offset.minutes + event.offset.seconds/60);
        }
  }); 
<?php endif ?>

// INITIAL VALUES //
$('#q<?= $question_ids[0] ?>').addClass('active');
$('#p<?= $question_ids[0] ?>').prop('disabled', true);
$("#n1").addClass('active');
$("#nn<?= end($question_ids) ?>").prop('disabled', true);
$('#report-param').val($('.tab-pane.active').attr('id').match(/\d+/g));
// -------------- //

function doGraph(id){ 
  a1 = $('#a1_'+id).val() ? $('#a1_'+id).val() : 0;
  a2 = $('#a2_'+id).val() ? $('#a2_'+id).val() : 0;
  a3 = $('#a3_'+id).val() ? $('#a3_'+id).val() : 0;
  a4 = $('#a4_'+id).val() ? $('#a4_'+id).val() : 0;
  a5 = $('#a5_'+id).val() ? $('#a5_'+id).val() : 0;
  solution = $('#solution'+id).val();
  answer = question_list[id]['answer']!=0 ? question_list[id]['answer'] : $('.active input:checked').val(); 
  if(!answer) answer = 0;

  $('#a'+id+' #graph').sparkline([a1,a2,a3,a4,a5], { 
      type: 'bar',
      width: "97%",
      height: "125px",
      barWidth: "20",
      barSpacing: "17",
      colorMap: [
          solution == 1 ? 'green' : (answer == 1) ? 'red' : '#999',
          solution == 2 ? 'green' : (answer == 2) ? 'red' : '#999',
          solution == 3 ? 'green' : (answer == 3) ? 'red' : '#999',
          solution == 4 ? 'green' : (answer == 4) ? 'red' : '#999',
          solution == 5 ? 'green' : (answer == 5) ? 'red' : '#999'
      ] 
  });

  $('#a'+id+' #graph').fadeIn();
}

function unvalidated(pointer, timer){
  console.log(question_list);
  $('input:checked').each(function(){
        id = $(this).attr('name').match(/\d+/g);
        question_list[id]['answer'] = $(this).val();
  });

  $.post( "<?= $url?>/reserved/qunvalidated", { 
    answers: question_list
  }).done(function(data) {
    document.location = ("<?= $url ?>/reserved/question/"+pointer+"/"+timer);
  });
}

// CHANGE QUESTION //
$('#selector').on('change', function(){
    id = parseInt($(this).val());
    if(id <= <?= count($question_ids) ?> && id > 0){
      $('#n'+id).trigger('click');
    }
})

$('.prev').on('click', function(){
  id = $('a.number.active').attr('id').match(/\d+/g);
  if(id > 1){
    id = id.join("") - 1;
    $('#n'+id).trigger('click');
    $('#selector').val(id);
  } else console.log("can't get lower than low");
})

$('.next').on('click', function(){
  id = $('a.number.active').attr('id').match(/\d+/g);
  if(id < <?= count($question_ids) ?>){
    id = id.join("") - 0 + 1;
    $('#n'+id).trigger('click');
    $('#selector').val(id);
  } else console.log("can't get higher than high");
})

$('a.number').on('click', function () {
  id = $(this).attr('id').match(/\d+/g);
  $("a.number").removeClass('active');
  $(this).addClass('active');
  $('#selector').val(id); 
  setTimeout(function(){
    $('#report-param').val($('.tab-pane.active').attr('id').match(/\d+/g));
  }, 5000);
  console.log($('#report-param').val());
})


// -------------- //

// MARK AS FAVORITE //
$('.favorite i').on('click', function() {
  id = $(this).attr('id').match(/\d+/g);
  if($(this).hasClass('fav'))
      $(this).removeClass('fav');
  else
      $(this).addClass('fav');
  question_list[id]['fav'] = !question_list[id]['fav']; 
  $.post( "<?= $url?>/reserved/qfav", { 
    id: id[0], 
    fav: question_list[id]['fav'] ? 1 : 0
  }).done(function( data ){});
})

// VALIDATE QUESTION //
$('.submit').on('click', function(){
  
  id = $('.tab-pane.active').attr('id').match(/\d+/g);
  question_nr = all_ids[id]+1;
  solution = $('#solution'+id).val();
  selected = $('.active input:checked').val();
  $('#l'+id+'_'+solution).addClass('correct');
  $('#a'+id).slideDown();
  $(this).prop('disabled', true);
  if(solution != selected){
    $('#l'+id+'_'+selected).addClass('wrong');
    $('#n'+question_nr).addClass('wrong');
  
  } else {
    $('#n'+question_nr).addClass('correct');
  }
  question_list[id]['answer'] = selected;
  
  $.post( "<?= $url?>/reserved/qanswer", { 
    question_id: id[0], 
    answer: selected,
  }).done(function(data) {
    eval(data);
  });

  doGraph(id);
})

// CHANGE SET OF QUESTIONS //
$('#n_next').on('click', function() {
  pointer = <?= $pointer ?> + 1;
  timer = $('#minutes').val();
  <?php if($timer==-1): ?> timer = -1; <?php endif?> 
  unvalidated(pointer, timer);
})

$('#n_prev').on('click', function() {
  pointer = <?= $pointer ?> -1 ;
  timer = $('#minutes').val();
  <?php if(@$timer==-1): ?> timer = -1; <?php endif?> 
  unvalidated(pointer, timer);
})
// ---------------------- //

// TERMINATE //
$('#finishBtn').on('click', function() {
  unvalidated(<?= $pointer ?>, -1)
})

</script>




