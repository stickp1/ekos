<?php $url = $this->Url->build(["prefix" => false, "controller" => '/'], true); ?>
<style>
a.number{
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
  width: auto;
}
.tab-pane{
  position: relative;
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
            <?php foreach ($question_list as $key => $value): ?> 
                <?php $i = $key + 1; ?> 
                <?php switch($value['status']):
                        case 1:   $class = 'correct'; 
                        case 2:   $class = 'wrong'; 
                        default:  $class='';
                      endswitch;
                      
                      if($value['id'] == $question['id']): 
                        $qk = $i;
                        $class.=" active";
                      endif;
                      
                ?>
            <?php endforeach; ?>
            <div id="banner">
                <div id="question-slider">
                    <?php for($counter = 0; $counter < count($question_list2[$pointer]); $counter++): ?>  
                    <?php $i = $question_ids[$counter] ?>
                        <a href="#q<?= $i?>" class='number' data-toggle="tab" id='n<?= $counter + 1 ?>'>
                            <?= $counter + 1  ?>
                        </a>
                    <?php endfor ?>
                </div>
                <div id="question-selector" class="col-md-4 col-md-offset-4">
                        <a href='#' class='navi prev'>
                            <i class="fa fa-angle-left" ></i>
                        </a>
                    <input type="number" id="selector" value="1"> 
                    <span> / </span> 
                    <?= count($question_list2[$pointer]) ?> 
                    <a href='#' class='navi next'>
                      <i class="fa fa-angle-right"></i>
                    </a>
                </div>
            </div>
        </div>

        <div class="row" id="new-question-body" style='position:relative;'>
            <div class="col-md-10 col-md-offset-1">
                <div class="panel-body">
                    <div class="tab-content">
                        <?php $counter = 0; ?>
                        <?php foreach ($questions as $key => $value): ?>
                            <?php $i = $value['id']; $counter++; ?>
                            <div class="tab-pane fade in" id="q<?= $i ?>"> <b><?= $value['question']; ?></b>

                                <?php if($value['total'] > 50): ?>
                                    <?php $corr = $value['a'.$value['correct']] / $value['total']; ?>
                                    <div id="difficulty" class="col-md-1">
                                        <i class="fa fa-lightbulb-o" style='color: #FEB000'></i>    
                                        <i class="fa fa-lightbulb-o" <?= $corr < $stat75 ? "style='color: #FEB000'" : '' ?>></i>    
                                        <i class="fa fa-lightbulb-o" <?= $corr < $stat25 ? "style='color: #FEB000'" : '' ?>></i>
                                    </div>
                                <?php endif; ?>
                                <br> 
                                <br>
                                <?php if($value['pic'] != '') {
                                    echo "<p style='text-align:center'> <img src='$url/img/questions/$value[pic]' style='max-width: 90%; max-height: 400px;' /> </p><br><br>";
                                }
                                ?>       
                                <?php if ($value['op1'] != ''): ?>
                                    <input type='radio' name='q<?= $i ?>' value='1' <?= @$question_list2[$pointer][$i]['answer']==1 ? "checked" : ""?> class='radio-btn'/> 
                                    <span id='l<?= $i ?>_1'> <?= $value['op1']; ?> </span><br> 
                                <?php endif ?>
                                <?php if ($value['op2'] != ''): ?>
                                    <input type='radio' name='q<?= $i ?>' value='2' <?= @$question_list2[$pointer][$i]['answer']==2 ? "checked" : ""?>/> 
                                    <span id='l<?= $i ?>_2'><?= $value['op2']; ?> </span><br> 
                                <?php endif ?>
                                <?php if ($value['op3'] != ''): ?>
                                    <input type='radio' name='q<?= $i ?>' value='3' <?= @$question_list2[$pointer][$i]['answer']==3 ? "checked" : ""?>/> 
                                    <span id='l<?= $i ?>_3'><?= $value['op3']; ?> </span><br> 
                                <?php endif ?>
                                <?php if ($value['op4'] != ''): ?> 
                                    <input type='radio' name='q<?= $i ?>' value='4' <?= @$question_list2[$pointer][$i]['answer']==4 ? "checked" : ""?>/> 
                                    <span id='l<?= $i ?>_4'><?= $value['op4']; ?> </span><br> 
                                <?php endif ?>
                                <?php if ($value['op5'] != ''): ?>
                                    <input type='radio' name='q<?= $i ?>' value='5' <?= @$question_list2[$pointer][$i]['answer']==5 ? "checked" : ""?>/> 
                                    <span id='l<?= $i ?>_5'><?= $value['op5']; ?> </span><br> 
                                <?php endif ?>
                                <br> 
                                <div class='answer' id="a<?= $i ?>" <?= $question_list2[$pointer][$i]['status'] > 0 ?  "style='display: block'" : "" ?>>
                                    <div id="graph" style='text-align: center; padding: 20px;' ></div>
                                    <label><b>Justificação</b></label>
                                    <br>
                                    <em><?= $value['justification']?></em>
                                </div>
                                <p style='text-align: center'> 
                                    <button class='prev btn-black btn' id='p<?= $i?>'> « </button>  
                                    <button class='submit btn-black btn' id='b<?= $i ?>' <?= $question_list2[$pointer][$i]['status'] > 0 ?  "disabled" : "" ?>> Validar 
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
                </div>
            </div>            
        </div>

        <?php endif; ?>
    </div>
</section>


<script src="<?= $url; ?>/bower_components/jquery-sparkline/dist/jquery.sparkline.min.js"></script>
<script>

/*$('.submit').on('click', function(){
  selected = $('input[name=q]:checked').val();
  $('#l_<?= $question["correct"]?>').addClass('correct');
  $('.answer').slideDown();
  $(this).prop('disabled', true);
  if(<?= $question["correct"]?> != selected){
    $('#l_'+selected).addClass('wrong');
    $('#n<?= $qk?>').addClass('wrong');
  } else {
    $('#n<?= $qk?>').addClass('correct');
  }

  $.post( '<?= $this->Url->build(["action" => "answer"])?>', { 
    id: <?= $question['id']?>, 
    answer: selected, 
    qk: <?= $qk - 1 ?>
  }).done(function( data ) {
    eval(data)
  });

})*/

all_ids = <?php echo json_encode(array_flip($question_ids)); ?>;
question_list = <?php echo json_encode($question_list2[$pointer]); ?>;

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
  
  $.post( "<?= $url?>/reserved/answer", { 
    question_id: id[0], 
    answer: selected,
  }).done(function(data) {
    console.log('success');
    eval(data);
  });

  doGraph(id);
})

<?php if($a = 10001 && $question_list[$qk-1]['status'] > 0 ): ?>

    $('#l_<?= $question["correct"]?>').addClass('correct');

    $("#graph").sparkline([ 
      <?= $question['a1'] ? $question['a1'] : '0' ?>, 
      <?= $question['a2'] ? $question['a2'] : '0'?>, 
      <?= $question['a3'] ? $question['a3'] : '0' ?>, 
      <?= $question['a4'] ? $question['a4'] : '0' ?>, 
      <?= $question['a5'] ? $question['a5'] : '0' ?> ], { 
            type: 'bar',
            width: "97%",
            height: "125px",
            barWidth: "20",
            barSpacing: "17",
            colorMap: [
              <?=  $question['correct'] == 1 ? "'green'"  :  ($question_list[$qk-1]['answer'] == 1 ? "'red'" : "'#999'") ?>, 
              <?=  $question['correct'] == 2 ? "'green'"  :  ($question_list[$qk-1]['answer'] == 2 ? "'red'" : "'#999'") ?>, 
              <?=  $question['correct'] == 3 ? "'green'"  :  ($question_list[$qk-1]['answer'] == 3 ? "'red'" : "'#999'") ?>, 
              <?=  $question['correct'] == 4 ? "'green'"  :  ($question_list[$qk-1]['answer'] == 4 ? "'red'" : "'#999'") ?>, 
              <?=  $question['correct'] == 5 ? "'green'"  :  ($question_list[$qk-1]['answer'] == 5 ? "'red'" : "'#999'") ?>
              ] 
    });

    $("#graph").fadeIn();
<?php endif; ?>

<?php foreach($questions as $key => $value): ?>
    <?php $i = $value['id']; ?>

    <?php if($question_list2[$pointer][$i]['status'] > 0 ): ?>
    
        $('#l'+<?= $i ?>+'_<?=$value['correct']?>').addClass('correct');
        question_nr = all_ids[<?= $i ?>]+1;

        <?php if($value['correct'] != $question_list2[$pointer][$i]['answer']): ?>
          $('#l<?= $i."_".$question_list2[$pointer][$i]['answer'] ?>').addClass('wrong');
          $('#n'+question_nr).addClass('wrong');
        <?php else: ?>
          $('#n'+question_nr).addClass('correct');
        <?php endif ?>

        doGraph(<?= $i ?>);
    <?php endif; ?>
<?php endforeach; ?>

$('#q<?= $question_ids[0] ?>').addClass('active');
$('#p<?= $question_ids[0] ?>').prop('disabled', true);
$("#n1").addClass('active');
$("#nn<?= end($question_ids) ?>").prop('disabled', true);

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
})

function doGraph(id){

  

  a1 = $('#a1_'+id).val() ? $('#a1_'+id).val() : 0;
  a2 = $('#a2_'+id).val() ? $('#a2_'+id).val() : 0;
  a3 = $('#a3_'+id).val() ? $('#a3_'+id).val() : 0;
  a4 = $('#a4_'+id).val() ? $('#a4_'+id).val() : 0;
  a5 = $('#a5_'+id).val() ? $('#a5_'+id).val() : 0;
  solution = $('#solution'+id).val();
  answer = question_list[id]['answer']!=0 ? question_list[id]['answer'] : $('.active input:checked').val(); 


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

$('.answer').on('slideDown', function(){
  ax = <?php echo json_encode($i); ?>;
  console.log(ax);  
  /*
  $("#graph").sparkline([ 
          <?= $value['a1'] ? $value['a1'] : '0' ?>, 
          <?= $value['a2'] ? $value['a2'] : '0'?>, 
          <?= $value['a3'] ? $value['a3'] : '0' ?>, 
          <?= $value['a4'] ? $value['a4'] : '0' ?>, 
          <?= $value['a5'] ? $value['a5'] : '0' ?> ], { 
                type: 'bar',
                width: "97%",
                height: "125px",
                barWidth: "20",
                barSpacing: "17",
                colorMap: [
                  <?=  $value['correct'] == 1 ? "'green'" : ($question_list2[$pointer][$i]['answer'] == 1 ? "'red'" : "'#999'") ?>, 
                  <?=  $value['correct'] == 2 ? "'green'" : ($question_list2[$pointer][$i]['answer'] == 2 ? "'red'" : "'#999'") ?>, 
                  <?=  $value['correct'] == 3 ? "'green'" : ($question_list2[$pointer][$i]['answer'] == 3 ? "'red'" : "'#999'") ?>, 
                  <?=  $value['correct'] == 4 ? "'green'" : ($question_list2[$pointer][$i]['answer'] == 4 ? "'red'" : "'#999'") ?>, 
                  <?=  $value['correct'] == 5 ? "'green'" : ($question_list2[$pointer][$i]['answer'] == 5 ? "'red'" : "'#999'") ?>
                  ] 
        });

        $("#graph").fadeIn();
*/
})

</script>




