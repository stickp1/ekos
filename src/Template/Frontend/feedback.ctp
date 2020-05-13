<?php $url = $this->Url->build(["prefix" => false, "controller" => '/'], true); ?>

<style>
h2{
	padding-bottom: 5px;
	border-bottom: 2px solid #3a6592;
	margin-bottom: 20px;
	color: #3a6592;
	font-weight: 500
}

legend{
	color: #3a6592;
	border-bottom: 1px solid #3a6592;

}

.btn {
	padding: 10px 40px;
}

div.radio-div{
    text-align: center;
}

div.questionline input[type="radio"] {
  position: relative;
  -webkit-appearance: none;
  -moz-appearance:    none;
  appearance:         none;
  margin:0 6px;
  width: 15px;
  height: 15px;
  background: #eeeeee;
  box-shadow:
    inset 0 0 0 .2em white,
    0 0 0 .1em;
  border-radius: 50%;
  transition: .2s;
  cursor:pointer;
  color: #363945;

}

div.questionline input[type="radio"]:hover,
div.questionline input[type="radio"]:checked {
    background: #363945;
    box-shadow:
    inset 0 0 0 .3em white,
    0 0 0 .2em;
  }
  
div.questionline input[type="radio"][value="0"]:checked {
    background: #1c84c6;
    box-shadow:
      inset 0 0 0 .2em white,
      0 0 0 .2em #1c84c6;
  } 

div.questionline input[type="radio"][value="1"]:checked,
div.questionline input[type="radio"][value="2"]:checked {
    background: #EF5352;
    box-shadow:
      inset 0 0 0 .2em white,
      0 0 0 .2em #EF5352;
  } 

div.questionline input[type="radio"][value="3"]:checked,
div.questionline input[type="radio"][value="4"]:checked {
    background: #F8AC59;
    box-shadow:
      inset 0 0 0 .2em white,
      0 0 0 .2em #F8AC59;
  } 

div.questionline input[type="radio"][value="5"]:checked,
div.questionline input[type="radio"][value="6"]:checked {
    background: #56be8e;
    box-shadow:
      inset 0 0 0 .2em white,
      0 0 0 .2em #56be8e;
  } 

  

div.questionline input[type="radio"]:focus { outline: 0; }


div.questionline input[value='0'] {
    margin-left: 25px;
}

input[value='0']::before {
    content: '0';
    position: absolute;
    left:22px;
    font-size: 10pt;
}

input[value='1']::before {
    content: '1';
    position: absolute;
    right:22px;
    font-size: 10pt;
}

input[value='6']::before {
    content: '6';
    position: absolute;
    left:22px;
    font-size: 10pt;
}

div.questionline {
    border-bottom: 1px solid #f1f1f1;
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    justify-content: center;
}

div.group {
	margin-bottom: 35px;
}

div.group div.questionline:last-child  {
	border-bottom: 0;
}

div.questionline>div {
	padding: 15px 10px;
}

div.hidden{
    display: none;
}

div.group div.teacher{
	margin-top: 25px;
	font-weight: 600
}

</style>

<div class='row'>
<div class="col-md-8 col-sm-12 col-md-offset-2" style='background-color: white; padding-top: 75px'>
<div style='padding: 50px 50px'>
<?= $this->Form->create('survey', ['id' => 'form'])?> 
<div class="row" style='margin-bottom: 20px'> 
<h2>Avaliação Módulo <?= $survey['lecture']['group']['course']['name'] ?> - <?= $survey['lecture']['description']?> <br> <span class='small'><b><?= $survey['lecture']['user']['first_name']." ".$survey['lecture']['user']['last_name']?></b><?php if($themes): echo " <br> ".implode(" | ", $themes); endif; ?></span> </h2>


</div>

<div class='group'>
<div class="row"> </div>
<?php 
$i = 1;
foreach ($questions as $key => $value) { ?>

<div class='row questionline'>
    <div class='col-sm-12 col-md-6 col-lg-7'>
        <b><?= $i?>.</b> <?= $value['name']; ?>
    </div>
    <div class='col-sm-12 col-md-5 col-lg-4 radio-div'>
        <?= $this->Form->radio("q[".$value['id']."]", [1 => 1,2 => 2,3 => 3,4 => 4,5 => 5,6 => 6,0 => 0], ['label' => false, 'required']); ?>
    </div>
</div>

<?php $i++;  }  ?>


<div class='row questionline' style='background-color: #f2f2f2'>
    <div class='col-sm-12 col-md-6 col-lg-7'>
        <b><?= $i?>.</b> Satisfação Global com a Aula
    </div>
    <div class='col-sm-12 col-md-5 col-lg-4 radio-div'>
        <?= $this->Form->radio("q[1]", [1 => 1,2 => 2,3 => 3,4 => 4,5 => 5,6 => 6,0 => 0], ['label' => false, 'required']); ?>
    </div>
</div>
<?php $i++;?>
</div>


<div class='group'>
<div class="row"> <legend>Comentário Livre </legend>
<textarea name="comments" rows="5" class='form-control'></textarea> </div>
</div>

<div class="row" style='text-align:center;'> <button class="btn btn-black"  id='submit-btn' type='submit'  >ENVIAR</button> 


<?= $this->Form->end(); ?>
</div>
</div>
</div>



<div class="modal fade" id="warning">
      <div class="vertical-alignment-helper">
        <div class="modal-dialog vertical-align-center">
            <div class="modal-content">
                <div class="modal-header" style='background-color: #d9534f; border-bottom: 0; color: white; text-align: center; font-weight: 400'><div class="bootstrap-dialog-header"><div class="bootstrap-dialog-close-button" style="display: block;"><button class="close">×</button></div><div class="bootstrap-dialog-title">Todas as perguntas de escala são obrigatórias.</div></div></div>
          </div>
          <!-- /.modal-dialog -->
        </div></div>
    </div>


<script src="<?= $url; ?>/js/validate.min.js"></script>
<script>


$('#form').validator().on('submit', function (e) {
  if (e.isDefaultPrevented()) {
    	$('#warning').modal('show');
  } else {
    // everything looks good!
  }
})

 
</script>

