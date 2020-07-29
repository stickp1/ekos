<?php $url = $this->Url->build(["prefix" => false, "controller" => '/'], true); ?>
<section id="services" class="text-center ">
    <form method='post' action='<?= $this->Url->build(["action" => 'flashcards'], true) ?>'>
        <div class="container">
            <div class="row">
                <div class="col-md-20">
                  <div class="panel with-nav-tabs panel-default" style='background:transparent'>
                      <div class="panel-heading">
                              <ul class="nav nav-tabs" id='submenu'>
                                  <li <?=  @$this->request->params['action'] == 'index' ? 'class="active"': ''?>><a href="<?= $this->Url->build(["prefix" => false, "controller" => 'reserved', "action" => "index"]) ?>">Cursos</a></li>
                                  <li <?=  @$this->request->params['action'] == 'qbank' ? 'class="active"': ''?>><a href="<?= $this->Url->build(["prefix" => false, "controller" => 'reserved', "action" => "qbank"]) ?>">Perguntas</a></li>
                                  <li <?=  @$this->request->params['action'] == 'fbank' ? 'class="active"': ''?>><a href="<?= $this->Url->build(["prefix" => false, "controller" => 'reserved', "action" => "fbank"]) ?>">Flashcards</a></li>
                                  <?php if(in_array(16, $courses_) || in_array(15, $courses_)): ?> <li <?=  @$this->request->params['action'] == 'ebank' ? 'class="active"': ''?>><a href="<?= $this->Url->build(["prefix" => false, "controller" => 'reserved', "action" => "ebank"]) ?>">Exames</a></li> <?php endif; ?>
                                  <li <?=  @$this->request->params['action'] == 'payments' ? 'class="active"': ''?>><a href="<?= $this->Url->build(["prefix" => false, "controller" => 'reserved', "action" => "payments"]) ?>">Pagamentos</a></li>
                                  
                              </ul>
                      </div>
                    </div>
                </div>
            </div>

            <?php if($courses != ''): ?>
            <div class="row" style='position:relative;'>
                <div class="reserved-background"></div>
                <div class="col-md-10 col-md-offset-1" style='padding-top: 75px'>
                    <h1>Olá <?= $Auth['first_name']; ?>!</h1>
                    <p>Seleciona os temas dos <em>Flashcards</em> que desejas fazer.</p>
                    <p style="margin-top: 30px"><?= $this->Form->intpu('wrong', ['options' => [0 => 'Todos os flashcards', 1 => 'Apenas os que errei', 2 => 'Apenas os favoritos'], 'default' => 0, 'type' => 'radio'])?>
                    </p>
                    <a href='#' id="all-themes">Selecionar todos os temas</a>
                    <br>
                </div>

                <div class='col-md-10 col-md-offset-1'>
                    <table id="ekosFlashcards" class='courses-list' style='margin-top: 20px; margin-bottom:20px'>
                        <?php foreach ($courses as $key => $course) { ?>
                        <tr class='primary' id="<?= $key?>">
                            <td width='40px'><input type="checkbox" id="<?= $key?>" class='c c_<?= $key?>' name='courses[]' value="<?= $course['id'] ?>" ></td>
                            <td class='clickable'><?= $course['name'] ?></td>
                            <td width='50px' class='clickable'><i class="fa fa-chevron-down" id='arrow_<?= $key?>'></i></td>
                        </tr>    
                        <tr>
                            <td colspan='3' style='padding:0; background-color: #f5f5f5'>
                                <div class='dependency d<?= $key?> closed'>
                                    <table style='width: 100%;'>
                                        <?php if(count($course['themes']) > 0) {
                                          foreach ($course['themes'] as $theme) {if(isset($flashcards[$theme['id']])): ?>
                                        <tr>
                                            <td style='padding: 5px' width='30px'><input type="checkbox" name="themes[]" value="<?= $theme['id']?>"  style='width:15px; height:15px' class="t_<?= $key?> t"></td>
                                            <td style='padding: 5px'><span class='small'><?= $theme['name']?></td>
                                            <td style='padding: 5px: width: 50px'>
                                                <span class='small' style='color: 
                                                  <?= @$answered[$theme['id']] / $flashcards[$theme['id']] < 0.5 ? 'red' : ''?> 
                                                  <?= @$answered[$theme['id']] / $flashcards[$theme['id']] > 0.9 ? 'green' : ''?>' 
                                                >
                                                  <?= $this->Number->toPercentage(@$answered[$theme['id']] / $flashcards[$theme['id']] * 100, 0);?>
                                                </span>
                                            </td>
                                        </tr>
                                        <?php endif; } } ?>
                                    </table>
                                </div>
                            </td>
                        </tr>
                        <?php } ?>
                    </table>
                    <?php if(!empty($myFlashcards)): ?>
                      <p>Os meus <i>Flashcards</i>:</p>
                      <a href='#' id="all-mythemes">Selecionar todos os temas</a>
                      <div class="panel panel-info well well-sm" id="myFlashcards">
                        <table class='courses-list' style='margin-top: 20px; margin-bottom:20px'>
                            <?php foreach ($myFlashcards as $key => $themes): ?>
                                <?php if(array_key_exists($key, $courses)): ?>
                                    <tr class='primary' id="my<?= $key?>">
                                        <td width='40px'><input type="checkbox" id="my<?= $key?>" class='c c_my<?= $key?>' name='mycourses[]' value="<?= $key ?>"  ></td>
                                        <td class='clickable'><?= $courses[$key]['name'] ?></td>
                                        <td width='50px' class='clickable'><i class="fa fa-chevron-down" id='arrow_my<?= $key?>'></i></td>
                                    </tr>    
                                    <tr>
                                        <td colspan='3' style='padding:0; background-color: #f5f5f5'>
                                            <div class='dependency dmy<?= $key?> closed'>
                                                <table style='width: 100%;'>
                                                    <?php foreach ($themes as $theme_id => $theme_name) { ?>
                                                    <tr>
                                                        <td style='padding: 5px' width='30px'><input type="checkbox" name="mythemes[]" value="<?= $theme_id ?>"  style='width:15px; height:15px' class="t_my<?= $key?> t"></td>
                                                        <td style='padding: 5px'><span class='small'><?= $theme_name ?></td>
                                                        <td style='padding: 5px: width: 50px'>
                                                            <span class='small' style='color: 
                                                              <?= 0.3 < 0.5 ? 'red' : ''?> 
                                                              <?= 0.3 > 0.9 ? 'green' : ''?>' 
                                                            >
                                                              <?= $this->Number->toPercentage(0.3 * 100, 0);?>
                                                            </span>
                                                        </td>
                                                    </tr>
                                                    <?php } ?>
                                                </table>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endif ?>
                            <?php endforeach ?>
                        </table>
                      </div>
                      <div id="newFlash">
                          <a href="#" id="newFlash-btn" data-toggle="modal" data-target="#newFlash-modal" class="btn"><i class="fa fa-credit-card"></i></a>
                          <br>
                          <span style="left: 34px">Criar</span>
                          <a href="#" id="editFlash-btn" onclick="event.preventDefault(); window.location.href='<?= $this->Url->build(["controller" => 'reserved', "action" => 'myflashcards'], true); ?>'" class="btn"><i class="fa fa fa-pencil-square-o"></i></a>
                          <br>
                          <span style="right: 35px">Editar</span>
                      </div>
                    <?php else: ?>
                        <div id="newFlashNone">
                          <a href="#" id="newFlash-btn" data-toggle="modal" data-target="#newFlash-modal" class="btn"><i class="fa fa-credit-card"></i></a>
                          <br>
                          <span>Criar novo flashcard</span>
                        </div>
                    <?php endif ?>
                    
                </div>
                <div id="startSession" >
                    <button class='btn btn-black' type="submit" >INICIAR SESSÃO DE TREINO</button>
                </div> 
            </div>
        </div>

            <?php else: ?>

            <div class="row" style='position:relative;'>
                <div class="reserved-background"></div>
                <div class="col-md-10 col-md-offset-1" style='padding-top: 75px'>
                    <h1>Olá <?= $Auth['first_name']; ?>!</h1>
                    <p>Ainda não efetuaste nenhuma inscrição. </p>
                    <br>
                    <button class="btn btn-black" onclick="window.location.href='<?= $this->Url->build(["controller" => 'users', "action" => 'logout'], true); ?>'">LOGOUT</button>
                </div>
            </div>
            <?php endif; ?>
       </div>
    </form>
</section>

<div class="modal fade" id="newFlash-modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h1 class="modal-title text-center">Criar novo Flashcard</h1>
            </div>
            <div class="modal-body">
              <?= $this->Form->create('Form', ['id' => 'create_flashcard_form' ]) ?> 
                    <div id="textDiv">
                        <div class="form-group">
                            <textarea class="form-control" id="newFlash-front" name="front" rows="5" placeholder="Escreve aqui a pergunta" data-minlength="3" data-error="Insere uma pergunta" required></textarea> 
                            <div class="help-block with-errors"></div>
                        </div>
                        <div class="form-group">
                            <textarea class="form-control" id="newFlash-verse" name="verse" rows=5 placeholder="Escreve aqui a resposta" data-minlength="3" data-error="Insere uma resposta"></textarea>
                            <div class="help-block with-errors"></div>
                        </div>
                        <div class="form-group">
                            <?php echo $this->Form->select('course', $options, ['empty' => 'Seleciona o curso']); ?>
                            <?php echo $this->Form->select('theme', ['empty' => 'Seleciona o tema']); ?>
                            <div class="help-block with-errors"></div>
                        </div>                                                    
                    </div>
                    <div class="modal-footer row">
                        <div id="report-captcha" class="g-recaptcha col-sm-6 col-xs-12" data-sitekey="6LdAL20UAAAAAJOZy5YPgXQR_u26zrk1Y8hEfuM2" style='display: none'>
                        </div>
                        <div class="col-sm-6 col-sm-offset-6 col-xs-12 text-sm-right text-center">
                            <button id="newFlash-submit" type="submit" class="btn btn-black">Submeter</button>
                        </div> 
                    </div>
              <?= $this->Form->end() ?>
            </div>
            
        </div>
    </div>
</div>

<style>
.btn-black{
  margin-top: 0;
}
.courses-list a span{
  opacity: 0.85;
}
.courses-list a:hover span{
  opacity: 1;
}
input[type='checkbox'] {
  -webkit-appearance: none;
  width: 30px;
  height: 30px;
  outline: none;
  border: 2px solid gray;
  margin-left: 3px;
}
input[type='checkbox']:before {
  content: '';
  display: block;
  width: 50%;
  height: 50%;
  margin: 25% auto;
}
input[type="checkbox"]:checked:before {
  background: #FEB000;
}
input[type='checkbox']:checked {
  border: 2px solid #152335;
}
input[type='radio'] {
  -webkit-appearance: none;
  width: 20px;
  height: 20px;
  margin-left: 15px;
  margin-right: 5px;
  outline: none;
  border: 1px solid gray;
  border-radius: 50%;
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
  border: 2px solid #152335;
}
label {
  display: inline-flex;
  align-items: center;
}
#newFlash{
  width: 170px;
  height: 120px;
  margin-right: 40px;
  position: relative;
  top: -45px;
  border: 5px solid #152335;
  border-radius: 20px;
  float: right;
}
#newFlash > span{
  position: absolute;
  bottom: 5px;
}
#newFlash > .btn{
  position: absolute;
  top: 30px;
  width: 70px;
  padding-left:0;
  padding-right:0;
  padding-top:12px;
  height:52px;
}
#newFlashNone > .btn{
  border-top-right-radius: 30px;
  border-bottom-right-radius: 30px;
  width: 80px;
  height: 50px;
}
#newFlashNone > i{
  margin-top: 4px;
  margin-left: -3px;
}
#newFlashNone{
  margin-bottom: 30px;
  margin-top: 30px;
}
#newFlash-btn{
  left: 10px;
  background: #FEB000;
  border-radius: 0;
  border-top-left-radius: 30px;
  border-bottom-left-radius: 30px;
}
#editFlash-btn{
  right: 10px;
  background: #152335;
  border-radius: 0;
  border-top-right-radius: 30px;
  border-bottom-right-radius: 30px;
}
.fa-credit-card{
  font-size: 2em;
}
.fa-pencil-square-o{
  font-size: 2em;
  color: #F5F5F5;
  margin-top: 1px;
}
.fa-pencil-square-o:hover{
  color: #FEB000;
}

.form-group{
  margin-bottom: 20px;
}
#newFlash-modal textarea, #newFlash-modal select{
  width: 100%;
}
#newFlash-modal select{
  margin-bottom: 20px;
  height: 40px;
}
#myFlashcards{
  background: #152335;
  color: #F5F5F5;
  padding-left: 30px;
  padding-right: 30px;
  border-radius: 30px;
  margin-top: 10px;
}
#myFlashcards tr{
  background: #152335;
  color: #F5F5F5;
}
#myFlashcards tr.primary{
  border-top: 2px solid #F5F5F5;
}
#myFlashcards table{
  border-bottom: 2px solid #F5F5F5;
}
#myFlashcards input[type='checkbox']:checked {
  border: 1px solid #F5F5F5;
}
<?php if(!empty($myFlashcards)): ?>

@media (max-width:991px) {
  #startSession{
    margin-top: 140px;
  }
}

<?php endif ?>
</style>

<script>

allThemesSelected = false;
allMyThemesSelected = false;

courses = [];
<?php foreach($courses as $key => $course): ?>
  courses[<?=$course['id']?>] = <?= json_encode(array_column($course['themes'],'name', 'id')) ?>;
<?php endforeach ?>

setTimeout(function(){
  $('.message.success').hide();  
  $('#mainNav').addClass('flash_timeout');
}, 5000);

$('#all-themes').on('click', function(){
    event.preventDefault();
    if(!allThemesSelected)
        $('#ekosFlashcards .c, #ekosFlashcards .t').prop('checked', true);
    else
        $('#ekosFlashcards .c, #ekosFlashcards .t').prop('checked', false);
    allThemesSelected = !allThemesSelected;
});

$('#all-mythemes').on('click', function(){
    event.preventDefault();
    if(!allMyThemesSelected)
        $('#myFlashcards .c, #myFlashcards .t').prop('checked', true);
    else
        $('#myFlashcards .c, #myFlashcards .t').prop('checked', false);
    allMyThemesSelected = !allMyThemesSelected;
});

$('.clickable').on('click', function(){
  id = $(this).parent().attr('id');
  if($('.dependency.d'+id).hasClass('closed')){
    $('.dependency').addClass('closed');
    $('.fa-chevron-up').removeClass('fa-chevron-up').addClass('fa-chevron-down');
    $('.dependency.d'+id).removeClass('closed');
    $('#arrow_'+id).removeClass('fa-chevron-down').addClass('fa-chevron-up');
  } else {
    $('.dependency').addClass('closed');
    $('#arrow_'+id).removeClass('fa-chevron-up').addClass('fa-chevron-down');
  }  
})

$('.c').on('change', function(){
  id = $(this).attr('id');
  if($(this).prop('checked') > 0){
    $(".t_"+id).prop('checked', true);
  } else {
    $(".t_"+id).prop('checked', false);
  }
})

$('.t').on('change', function(){
  id = $(this).attr('class').match(/\d+/);
  var checked = 0;
  $(".t_"+id).each(function( index ) {
    if($(this).prop('checked')){checked = checked +1};
  });

  if(checked > 0){
    $(".c_"+id).prop('checked', true);
  } else {
    $(".c_"+id).prop('checked', false);
  }
})

$('select[name="course"]').change(function(){
  id = $(this).val();
  themeSelect = $('select[name="theme"]');
  themeSelect.empty();
  $.each(courses[id], function(index, value) {
    themeSelect.append($('<option></option').attr('value',index).text(value));
  });
  themeSelect.append($('<option></option').attr('value',0).text('Outro'));
})

$("#newFlash-submit").on('click', function(){
  event.preventDefault();
    $.post( "<?= $url?>/reserved/flash-create", { 
      front:  $('textarea[name="front"]').val(), 
      verse:  $('textarea[name="verse"]').val(),
      course: $('select[name="course"]').val(),
      theme:  $('select[name="theme"]').val()
    }).done(function( data ) {
      location.reload();
    });
    $("#newFlash-modal").modal('hide');
})

</script>

  