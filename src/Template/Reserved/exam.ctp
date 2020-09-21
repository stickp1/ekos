<?php $url = $this->Url->build(["prefix" => false, "controller" => '/'], true); ?>


<?php if($exam['id'] == 1): ?>

    <section id="services" class="text-center ">
        <div class="container">
            <div class="row">
                <div class="col-md-10 col-md-offset-1">
                    <div class="panel panel-default" style='background:transparent'>
                        <div class="panel-heading text-left">
                            <br>
                            <h1 style='text-align: center'>Perguntas Exemplo</h1>
                            <div id="question-slider">
                                <?php foreach ($exam['questions'] as $key => $value): ?>
                                    <?php $i = $key + 1; ?>
                                    <a href="#q<?= $i?>" class='number' data-toggle="tab" id='n<?= $i ?>'>
                                        <?= $i ?>
                                    </a>
                                <?php endforeach ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row" style='position:relative;'>
                <div class="col-md-10 col-md-offset-1">
                    <div class="panel-body">
                        <div class="tab-content">
                            <?php foreach ($exam['questions'] as $key => $value) { $i = $key + 1; ?>
                                <div class="tab-pane fade in" id="q<?= $i ?>"> <b><?= $i.". ".$value['question']; ?></b>
                                    <br> 
                                    <br>
                                    <?php if ($value['op1'] != ''){?>
                                        <input type='radio' name='q<?= $i ?>' value='1' class='radio-btn' /> 
                                        <span id='l<?= $i ?>_1'> <?= $value['op1']; ?> 
                                        </span>
                                        <br> 
                                    <?php } ?>
                                    <?php if ($value['op2'] != ''){?>
                                        <input type='radio' name='q<?= $i ?>' value='2' /> 
                                        <span id='l<?= $i ?>_2'><?= $value['op2']; ?> 
                                        </span>
                                        <br> 
                                    <?php } ?>
                                    <?php if ($value['op3'] != ''){?>
                                        <input type='radio' name='q<?= $i ?>' value='3' /> 
                                        <span id='l<?= $i ?>_3'><?= $value['op3']; ?> 
                                        </span>
                                        <br> 
                                    <?php } ?>
                                    <?php if ($value['op4'] != ''){?> 
                                        <input type='radio' name='q<?= $i ?>' value='4' /> 
                                        <span id='l<?= $i ?>_4'><?= $value['op4']; ?> 
                                        </span>
                                        <br> 
                                    <?php } ?>
                                    <?php if ($value['op5'] != ''){?>
                                        <input type='radio' name='q<?= $i ?>' value='5' /> 
                                        <span id='l<?= $i ?>_5'><?= $value['op5']; ?> 
                                        </span>
                                        <br> 
                                    <?php } ?>
                                    <br> 
                                    <div class='answer q<?= $i ?>'>
                                      <label><b>Justificação</b></label><br>
                                      <em><?= $value['justification']?></em>
                                    </div>
                                    <p style='text-align: center'> 
                                        <button class='prev btn-black btn' id='p<?= $i ?>'> « 
                                        </button>  
                                        <button class='submit validate btn-black btn' id='b<?= $i ?>'> Validar 
                                        </button> 
                                        <button class='next btn-black btn' id='nn<?= $i ?>'> » 
                                        </button> 
                                    </p>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

<?php elseif($user_exams['finished'] == 0 && !in_array(15, $courses)) : ?>

    <section id="services" class="text-center ">
        <div class="container">
            <div class="row">
                <div class="col-md-10 col-md-offset-1">
                    <div class="panel panel-default" style='background:transparent'>
                        <div class="panel-heading text-left">
                            <br>
                            <h2 style='text-align: center; margin-bottom: 15pt'><?= $exam['name'] ?></h2>
                      	    <div id="getting-started" style='text-align:center; font-size: 14pt;'></div>
                            <div id="question-slider">
                                <?php foreach ($exam['questions'] as $key => $value): ?>
                                    <?php $i = $key + 1; ?>
                                    <a href="#q<?= $i?>" class='number' data-toggle="tab" id='n<?= $i ?>'>
                                        <?= $i ?>
                                    </a>
                                <?php endforeach ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row" style='position:relative;'>
                <?= $this->Form->create('exam', ['id' => 'exam_f']) ?>
                <input type="hidden" name="userid" value="<?=$Auth['id']?>">
                <div class="col-md-10 col-md-offset-1">
                    <div class="panel-body">
                        <div class="tab-content">
                            <?php foreach ($exam['questions'] as $key => $value): ?> 
                                <?php $i = $key + 1; ?>
                                <div class="tab-pane fade in" id="q<?= $i ?>"> <b><?= $i.". ".$value['question']; ?></b>
                                    <br> 
                                    <br>
                                    <?php if($value['pic'] != '') {
                                        echo "<p style='text-align:center'> <img src='$url/img/questions/$value[pic]' style='max-width: 90%; max-height: 400px;' /> </p><br><br>";
                                    }
                                    ?>
                                    
                                    <?php if ($value['op1'] != ''){?><input type='radio' name='q<?= $value['id'] ?>' value='1' class='radio-btn' /> <span id='l<?= $i ?>_1'> <?= $value['op1']; ?> </span><br> <?php } ?>
                                    <?php if ($value['op2'] != ''){?><input type='radio' name='q<?= $value['id'] ?>' value='2' /> <span id='l<?= $i ?>_2'><?= $value['op2']; ?> </span><br> <?php } ?>
                                    <?php if ($value['op3'] != ''){?><input type='radio' name='q<?= $value['id'] ?>' value='3' /> <span id='l<?= $i ?>_3'><?= $value['op3']; ?> </span><br> <?php } ?>
                                    <?php if ($value['op4'] != ''){?> <input type='radio' name='q<?= $value['id'] ?>' value='4' /> <span id='l<?= $i ?>_4'><?= $value['op4']; ?> </span><br> <?php } ?>
                                    <?php if ($value['op5'] != ''){?><input type='radio' name='q<?= $value['id'] ?>' value='5' /> <span id='l<?= $i ?>_5'><?= $value['op5']; ?> </span><br> <?php } ?>
                                    <br> 
                                    <p style='text-align: center'> 
                                        <button class='prev btn-black btn' id='p<?= $i ?>' type='button'> « 
                                        </button>  
                                        <button class='submit btn-black btn' type='submit' onclick='return confirm("Tens a certeza que pretendes terminar o exame? Não poderás tornar a repeti-lo após a submissão.")'> Terminar exame 
                                        </button> 
                                        <button type='button' class='next btn-black btn' id='nn<?= $i ?>'> » 
                                        </button> 
                                    </p>
                                </div>
                            <?php endforeach ?>
                        </div>
                    </div>
                </div>
                <?= $this->Form->end() ?>
            </div>
        </div>
    </section>

<?php else: ?>

    <?php if(empty($answers))
            foreach($exam['questions'] as $key => $value)
              $answers['q'.$value['id']] = 'wrong'; 
    ?>

    <section id="services" class="text-center ">
        <div class="container">
            <div class="row">
                <div class="col-md-10 col-md-offset-1">
                    <div class="panel panel-default" style='background:transparent'>
                        <div class="panel-heading text-left">
                            <br>
                            <h2 style='text-align: center; margin-bottom: 15pt'><?= $exam['name'] ?></h2>
                          	<div id="getting-started" style='text-align:center; font-size: 14pt;'>Resultado: <?= $user_exams['result'] ?></div>
                          	<div id="getting-started" style='text-align:center; font-size: 14pt;'>Média: <?= round($user_exams['avg'][0]['result'])."/".count($exam['questions'])?> 
                            </div>
                            <div id="question-slider">
          				              <?php foreach ($exam['questions'] as $key => $value): ?>
                                    <?php $i = $key + 1; ?>
                                    <a href="#q<?= $i?>" class='number <?= $value['correct'] != $answers['q'.$value['id']] ? 'wrong' : 'correct' ?>' data-toggle="tab" id='n<?= $i ?>'>
                                        <?= $i ?>
                                    </a>
                                <?php endforeach ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row" style='position:relative;'>
                <div class="col-md-10 col-md-offset-1">
                    <div class="panel-body">
                        <div class="tab-content">
                            <?php foreach ($exam['questions'] as $key => $value): ?> 
                                <?php $i = $key + 1; ?>
                                <div class="tab-pane fade in" id="q<?= $i ?>"> <b><?= $i.". ".$value['question']; ?></b>
                                    <br> 
                                    <br>
                                    <?php if ($value['op1'] != ''): ?>
                                        <input type='radio' value='1' class='radio-btn' <?= $answers['q'.$value['id']] == 1 ? 'checked="checked"' : '' ?> disabled /> 
                                        <span <?= $value['correct'] == 1 ? 'class="correct"' : '' ?>> <?= $value['op1']; ?> <?= $value['correct'] != 1 && $answers['q'.$value['id']] == 1 ? 'class="wrong"' : '' ?>                            
                                        </span><br> 
                                    <?php endif ?>
                                    <?php if ($value['op2'] != ''): ?>
                                        <input type='radio' value='2' <?= $answers['q'.$value['id']] == 2 ? 'checked="checked"' : '' ?> disabled /> 
                                        <span <?= $value['correct'] != 2 && $answers['q'.$value['id']] == 2 ? 'class="wrong"' : '' ?> <?= $value['correct'] == 2 ? 'class="correct"' : '' ?>><?= $value['op2']; ?> 
                                        </span><br> 
                                    <?php endif ?>
                                    <?php if ($value['op3'] != ''): ?>
                                        <input type='radio' value='3' <?= $answers['q'.$value['id']] == 3 ? 'checked="checked"' : '' ?> disabled /> 
                                        <span <?= $value['correct'] != 3 && $answers['q'.$value['id']] == 3 ? 'class="wrong"' : '' ?><?= $value['correct'] == 3 ? 'class="correct"' : '' ?>><?= $value['op3']; ?> 
                                        </span><br> 
                                    <?php endif ?>
                                    <?php if ($value['op4'] != ''): ?> 
                                        <input type='radio' value='4' <?= $answers['q'.$value['id']] == 4 ? 'checked="checked"' : '' ?> disabled /> 
                                        <span <?= $value['correct'] != 4 && $answers['q'.$value['id']] == 4 ? 'class="wrong"' : '' ?><?= $value['correct'] == 4 ? 'class="correct"' : '' ?>><?= $value['op4']; ?> 
                                        </span><br> 
                                    <?php endif ?>
                                    <?php if ($value['op5'] != ''): ?>
                                        <input type='radio' value='5' <?= $answers['q'.$value['id']] == 5 ? 'checked="checked"' : '' ?> disabled /> 
                                        <span <?= $value['correct'] != 5 && $answers['q'.$value['id']] == 5 ? 'class="wrong"' : '' ?><?= $value['correct'] == 5 ? 'class="correct"' : '' ?>><?= $value['op5']; ?> 
                                        </span>
                                        <br> 
                                    <?php endif ?>
                                    <br> 
                                    <div class='answer q<?= $i ?>'>
                                        <label><b>Justificação</b></label><br>
                                        <em><?= $value['justification']?></em>
                                    </div>
                                    <p style='text-align: center'> 
                                        <button class='prev btn-black btn' id='p<?= $i ?>' type='button'> « 
                                        </button>  
                                        <button style='display: none' class='submit validate btn-black btn' id='b<?= $i ?>'> Validar 
                                        </button> 
                                        <button type='button' class='next btn-black btn' id='nn<?= $i ?>'> » 
                                        </button> 
                                    </p>
                                </div>
                            <?php endforeach ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php endif; ?>

<style>
div.answer{
  display: none;
}
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
body {
  background-color: #f5f5f5;
}
#question-slider::-webkit-scrollbar{
  display:none;
}
#question-slider{
  margin-top: 10px;
  overflow-x: auto;
  flex-wrap: nowrap;
  white-space: nowrap;
  box-shadow: inset 30px 0px 10px -20px #2C3949, inset -30px 0px 10px -20px #2C3949;
}
</style>

<?= $this->Html->script('jquery.countdown.js'); ?>
<script>

var a = [];
<?php foreach ($exam['questions'] as $key => $value): ?>
  <?php $i = $key + 1; ?> 
  a[<?= $i?>] = <?= $value['correct']?>;
<?php endforeach ?>

$('.validate').on('click', function(){
  id = $(this).attr('id').match(/\d/g);
  id = id.join("");
  selected = $('input[name=q'+id+']:checked').val();
  $('#l'+id+"_"+a[id]).addClass('correct');
  $('.answer.q'+id).slideDown();
  $(this).prop('disabled', true);
  if(a[id] != selected){
    $('#l'+id+"_"+selected).addClass('wrong');
    $('#n'+id).addClass('wrong');
  } else {
    $('#n'+id).addClass('correct');
  }
})

<?php if(array_key_exists('finished', $user_exams) && $user_exams['finished'] != 1): ?>

$("#getting-started").countdown("<?= date('Y/m/d H:i:s', strtotime("+120 minutes", strtotime($user_exams['timestamp'])));?>" , {elapse: true})
  .on('update.countdown', function(event) {
      var $this = $(this);
      if (event.elapsed) {
          $('#exam_f').submit();
      } else {
          $this.html(event.strftime('<span>%H:%M:%S</span>'));
      }
}); 
<?php endif ?>       

$("a.number").on('click', function () {
  $("a.number").removeClass('active');
  $(this).addClass('active');
})

$('.prev').on('click', function(){
  id = $(this).attr('id').match(/\d/g);
  id = id.join("") - 1;
  $('#n'+id).trigger('click');
  setTimeout(function(){$('html, body').animate({scrollTop: $(".panel-body").offset().top-150})}, 200);
})

$('.next').on('click', function(){
  id = $(this).attr('id').match(/\d/g);
  id = id.join("") - 0 + 1;
  $('#n'+id).trigger('click');
  setTimeout(function(){$('html, body').animate({scrollTop: $(".panel-body").offset().top-150})}, 200);
})

$("#p1").prop('disabled', true);
$("#nn<?= count($exam['questions'])?>").prop('disabled', true);
$("#n1").trigger('click');
$("#q1").addClass('active');

<?php if(!in_array($exam['id'], [1, 4, 5, 6, 7]) && $user_exams['finished'] == 1): ?>
    $( ".validate" ).trigger( "click" );
<?php endif ?>

</script>











    



