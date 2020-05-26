<?php $url = $this->Url->build(["prefix" => false, "controller" => '/'], true); ?>
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

span.correct{ color: green; font-weight: bold;}

span.wrong{ color: red; font-weight: bold;}

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


<?php if(isset($none)): ?>


  <div class="row" style='position:relative;'>
          <div class="reserved-background"></div>
          <div class="col-md-10 col-md-offset-1" style='padding-top: 75px'>
            <h1>Olá <?= $Auth['first_name']; ?>!</h1>
            <p>Infelizmente, não encontrámos perguntas para os temas selecionados.</p><p> Estamos continuamente a aumentar a nossa base de dados de perguntas, podes tentar novamente outro dia. Até lá, experimenta selecionar outros temas.</p><p><b>Bom estudo!</b></p><br>
          <button class='btn-black btn' onClick='window.location.href="<?= $this->Url->build(["action" => "qbank"])?>"'> NOVA PESQUISA </button> 
          </div>
        </div>

      </div>
    </section>

<?php else: ?>

<div class="row" style='position:relative;'>
  <?php foreach ($question_list as $key => $value) { $i = $key + 1; 
                    if($value['status'] == 1){$class = 'correct';} elseif($value['status'] == 2){$class = 'wrong';} else {$class='';}
                    if($value['id'] == $question['id']){$qk = $i; $class.=" active";}
                    ?>
                   <!--  <a href="<?= $this->Url->build(["action" => "question", $value['id']])?>" class='number <?= $class ?>' id='n<?= $i ?>'><?= $i ?></a>  -->
                  <?php }; ?>
 <div style='background-color: #2C3949; left: -300px; top: -31px; right:-300px; min-height:50px; position: absolute; z-index: 2; text-align: center; padding-top:6px; color: white; font-size:12pt'>

<div class="col-md-4 col-md-offset-4">
          
            <?php if($qk - 1 > 0): ?>
              <a href='#' class='navi' onClick='window.location.href="<?= $this->Url->build(["action" => "question", $question_list[$qk-2]['id']])?>"'><i class="fa fa-angle-left" ></i></a>
           <?php endif ?>

            <input type="number" id="selector" value="<?= $qk ?>" style="
    text-align: center;
    width: 50px;
    color: white;
    background-color: #2C3949;
    border: 1px solid #929dab;
    padding: 4px 0px;
    border-radius: 8px;

"> <span style='color: #929dab; font-size:17pt'> / </span> <?= count($question_list) ?> 

   <?php if($qk <= count($question_list) - 1): ?>
   <a href='#' class='navi' onClick='window.location.href="<?= $this->Url->build(["action" => "question", $question_list[$qk]['id']])?>"'><i class="fa fa-angle-right"></i></a>
 <?php endif; ?>
           </div>

<?php 
$tot = $question['a1']+$question['a2']+$question['a3']+$question['a4']+$question['a5'];
if($tot > 50):  $corr = $question['a'.$question['correct']] / $tot; ?>
<div class="col-md-1" style='font-size:18pt; padding-top: 1px; color: #929dab'>
  <i class="fa fa-lightbulb-o" style='color: #FEB000'></i>    <i class="fa fa-lightbulb-o" <?= $corr < $stat75 ? "style='color: #FEB000'" : '' ?>></i>    <i class="fa fa-lightbulb-o" <?= $corr < $stat25 ? "style='color: #FEB000'" : '' ?>></i>
</div>
<?php endif; ?>
         </div>


  </div>

        <div class="row" style='position:relative;'>
           <div class="reserved-background"></div>
          <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default" style='background:transparent'>
                <div class="panel-heading text-left" >
                  <br>
                  
                  </ul>
                        
                </div>
              </div>
          </div>
        </div>

        <div class="row"  style='position:relative;'>
            <div class="reserved-background"></div>
            <div class="col-md-10 col-md-offset-1">


               
                  <div class='panel-body tab-content'> <b><?= $qk.". ".$question['question']; ?></b>
                    <br> <br>

                    <?php if($question['pic'] != '') {
                        echo "<p style='text-align:center'> <img src='$url/img/questions/$question[pic]' style='max-width: 90%; max-height: 400px;' /> </p><br><br>";
                    }
                    ?>

                    <?php if ($question['op1'] != ''){?><input type='radio' name='q' value='1' class='radio-btn' <?= @$question_list[$qk-1]['answer'] == 1 ?  "checked" : "" ?> /> <span id='l_1'> <?= $question['op1']; ?> </span><br> <?php } ?>
                    <?php if ($question['op2'] != ''){?><input type='radio' name='q' value='2' <?= @$question_list[$qk-1]['answer'] == 2 ?  "checked"  : ""?>  /> <span id='l_2'><?= $question['op2']; ?> </span><br> <?php } ?>
                    <?php if ($question['op3'] != ''){?><input type='radio' name='q' value='3' <?= @$question_list[$qk-1]['answer'] == 3 ?  "checked"  : ""?>  /> <span id='l_3'><?= $question['op3']; ?> </span><br> <?php } ?>
                    <?php if ($question['op4'] != ''){?> <input type='radio' name='q' value='4' <?= @$question_list[$qk-1]['answer'] == 4 ?  "checked"  : ""?> /> <span id='l_4'><?= $question['op4']; ?> </span><br> <?php } ?>
                    <?php if ($question['op5'] != ''){?><input type='radio' name='q' value='5' <?= @$question_list[$qk-1]['answer'] == 5 ?  "checked"  : ""?> /> <span id='l_5'><?= $question['op5']; ?> </span><br> <?php } ?>
                    <br> 
                    <div class='answer' <?= $question_list[$qk-1]['status'] > 0 ?  "style='display: block'" : "" ?>>

                      <div id="graph" style='text-align: center; padding: 20px;' ></div>

                      <label><b>Justificação</b></label><br>
                      <em><?= $question['justification']?></em>
                    </div>
                     <p style='text-align: center'> 

                     <?php if($qk - 1 == 0): ?>
                      <button class='next btn-black btn' disabled> « </button> 
                    <?php else: ?>
                       <button class='prev btn-black btn' onClick='window.location.href="<?= $this->Url->build(["action" => "question", $question_list[$qk-2]['id']])?>"'> « </button>  
                    <?php endif; ?>


                      <button class='submit btn-black btn' id='b<?= $qk ?>' <?= $question_list[$qk-1]['status'] > 0 ?  "disabled" : "" ?>> Validar </button> 

                    <?php if($qk > count($question_list) - 1): ?>
                      <button class='next btn-black btn' disabled> » </button> 
                    <?php else: ?>
                      <button class='next btn-black btn' onClick='window.location.href="<?= $this->Url->build(["action" => "question", $question_list[$qk]['id']])?>"'> » </button> 
                    <?php endif; ?>
                    </p>
                  </div>


            
          </div>
        </div>
      </div>


    </section>


<script src="<?= $url; ?>/bower_components/jquery-sparkline/dist/jquery.sparkline.min.js"></script>


<script>



$('.submit').on('click', function(){
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

  $.post( '<?= $this->Url->build(["action" => "answer"])?>', { id: <?= $question['id']?>, answer: selected, qk: <?= $qk - 1 ?>})
  .done(function( data ) {
    eval(data)
  });

})

<?php if($question_list[$qk-1]['status'] > 0 ): ?>
  $('#l_<?= $question["correct"]?>').addClass('correct');

  $("#graph").sparkline([ <?= $question['a1'] ? $question['a1'] : '0' ?>, <?= $question['a2'] ? $question['a2'] : '0'?>, <?= $question['a3'] ? $question['a3'] : '0' ?>, <?= $question['a4'] ? $question['a4'] : '0' ?>, <?= $question['a5'] ? $question['a5'] : '0' ?> ], { 
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

          ] });

  $("#graph").fadeIn();

<?php endif; ?>

var question_list = [];
<?php foreach ($question_list as $key => $value) {?>
  question_list[<?= intval($key)+1 ?>] = <?= $value['id'] ?>;
<?php }?>


$('#selector').on('change', function(){ 
    val = parseInt($(this).val());
    if(val <= <?= count($question_list) ?> ){
      window.location.href='<?= $this->Url->build(["action" => "question"])?>/'+question_list[val];
    }
  });

</script>


<?php endif; ?>

