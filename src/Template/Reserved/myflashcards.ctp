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
                                  <li <?=  @$this->request->params['action'] == 'forum' ? 'class="active"': ''?>><a href="<?= $this->Url->build(["prefix" => false, "controller" => 'reserved', "action" => "forum"]) ?>">Dúvidas</a></li>
                                  <?php if($isStudio): ?> <li <?=  @$this->request->params['action'] == 'videobank' ? 'class="active"': ''?>><a href="<?= $this->Url->build(["prefix" => false, "controller" => 'reserved', "action" => "videobank"]) ?>">Vídeos</a></li> <?php endif; ?>
                                  <?php if(in_array(16, $courses_) || in_array(15, $courses_) || in_array(1, $courses_)): ?> <li <?=  @$this->request->params['action'] == 'ebank' ? 'class="active"': ''?>><a href="<?= $this->Url->build(["prefix" => false, "controller" => 'reserved', "action" => "ebank"]) ?>">Exames</a></li> <?php endif; ?>
                                  <li <?=  @$this->request->params['action'] == 'payments' ? 'class="active"': ''?>><a href="<?= $this->Url->build(["prefix" => false, "controller" => 'reserved', "action" => "payments"]) ?>">Pagamentos</a></li>
                                  
                              </ul>
                      </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12">
                    <div class="box">
                        <div class="box-header">
                            <div class="box-tools">
                                <ul class="pagination pagination-sm no-margin">
                                    <?= $this->Paginator->first('«') ?>
                                    <?= $this->Paginator->prev('‹') ?>
                                    <?= $this->Paginator->numbers() ?>
                                    <?= $this->Paginator->next('›') ?>
                                    <?= $this->Paginator->last('»') ?>
                                </ul>
                            </div>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body table-responsive no-padding">
                            <table class="table table-hover">
                                <tbody>
                                    <tr>
                                        <th>Frente</th>
                                        <th>Verso</th>
                                        <th style="display: none"></th>
                                        <th>Tema</th>
                                        <th width='100px'></th>
                                    </tr>
                                    <?php if($flashcards->count() > 0): ?>
                                        <?php foreach ($flashcards as $question): ?>
                                            <tr id="tr<?=$question->id ?>">
                                                <td><?= $question->front ?></td>
                                                <td><?= $question->verse ?></td>
                                                <td id="<?= $question->course_id ?>" style="display: none"><?= $question->course['name']?></td>
                                                <td id="<?= $question->theme_id ?>"><?= $question->theme['name']?></td>
                                                
                                                <td style='text-align:right'> 
                                                    <a href="#" id="edit<?= $question->id ?>" class="editFlash" style="margin-right:10px" data-toggle="modal" data-target="#editFlash-modal"><i class="fa fa-edit"></i></a>
                                                    <a href="#" id="del<?= $question->id ?>" class="delFlash" style="margin-right:10px"><i class="fa fa-trash"></i></a>
                                                </td>
                                            </tr>
                                        <?php endforeach ?> 
                                    <?php else: ?>
                                        <tr> 
                                            <td colspan='5' style='text-align:center'><em>Sem Flashcards a apresentar.</em>
                                            </td>
                                        </tr>
                                    <?php endif ?>
                                </tbody>
                            </table>
                        </div>
                        <!-- /.box-body -->
                    </div>
                    <!-- /.box -->
                </div>
            </div>
        </div>
    </form>
</section>

<div class="modal fade" id="editFlash-modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h1 class="modal-title text-center">Editar Flashcard</h1>
            </div>
            <div class="modal-body">
              <?= $this->Form->create('Form', ['id' => 'create_flashcard_form' ]) ?> 
                    <div id="textDiv">
                        <input type="hidden" name="id">
                        <div class="form-group">
                            <textarea class="form-control" name="front" rows="5" placeholder="Escreve aqui a pergunta" data-minlength="3" data-error="Insere uma pergunta" required></textarea> 
                            <div class="help-block with-errors"></div>
                        </div>
                        <div class="form-group">
                            <textarea class="form-control" name="verse" rows=5 placeholder="Escreve aqui a resposta" data-minlength="3" data-error="Insere uma resposta"></textarea>
                            <div class="help-block with-errors"></div>
                        </div>
                        <div class="form-group">
                            <?php echo $this->Form->select('course', $options, ['empty' => 'Seleciona o curso']); ?>
                            <?php echo $this->Form->select('theme', ['empty' => 'Seleciona o tema']); ?>
                            <div class="help-block with-errors"></div>
                        </div>                                                    
                    </div>
                    <div class="modal-footer row">
                        <div class="col-sm-6 col-sm-offset-6 col-xs-12 text-sm-right text-center">
                            <button id="editFlash-submit" type="submit" class="btn btn-black">Submeter</button>
                        </div> 
                    </div>
              <?= $this->Form->end() ?>
            </div>
            
        </div>
    </div>
</div>



<style>
table tr:first-child{
    height: 40px;
    color: #F5F5F5;
}
table tr:first-child th{
    background: #152335;
    font-size: 18px;
    text-align: center;
    border: 1px solid #F5F5F5;
}
table{
    text-align: left;
}
td p{
    font-size: 14px;
}
section{
    padding-bottom: 0;
}
.pagination{
    margin-top: 0;
    display: flex;
    justify-content: center;
}
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

.form-group{
  margin-bottom: 20px;
}
#editFlash-modal textarea, #editFlash-modal select{
  width: 100%;
}
#editFlash-modal select{
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
</style>

<script>

courses = [];
<?php foreach($courses as $key => $course): ?>
  courses[<?=$course['id']?>] = <?= json_encode(array_column($course['themes'],'name', 'id')) ?>;
<?php endforeach ?>

$('.editFlash').on('click', function(){
    id = $(this).attr('id').match(/\d+/g);
    $('#editFlash-modal input[name="id"]').val(id);
    $('#editFlash-modal textarea[name="front"]').val($('#tr'+id+' td:nth-child(1)').text());
    $('#editFlash-modal textarea[name="verse"]').val($('#tr'+id+' td:nth-child(2)').text());
    $('#editFlash-modal select[name="course"]').val($('#tr'+id+' td:nth-child(3)').attr('id'));
    $('#editFlash-modal select[name="course"]').change();
    $('#editFlash-modal select[name="theme"]').val($('#tr'+id+' td:nth-child(4)').attr('id'));
});

$('.delFlash').on('click', function(){
    flash_id = $(this).attr('id').match(/\d+/g);
    console.log(flash_id[0]);
    if(confirm("Tens a certeza que pretender eliminar o flashcard?"))
      $.post( "<?= $url?>/reserved/flash-delete", {
        id: flash_id[0]
      }).done(function(data){
        location.reload();
      });
});

setTimeout(function(){
  $('.message.success').hide();  
  $('#mainNav').addClass('flash_timeout');
}, 5000);

$('select[name="course"]').change(function(){
  course_id = $(this).val();
  themeSelect = $('select[name="theme"]');
  themeSelect.empty();
  $.each(courses[course_id], function(index, value) {
    themeSelect.append($('<option></option').attr('value',index).text(value));
  });
  themeSelect.append($('<option></option').attr('value',0).text('Outro'));
});

$("#editFlash-submit").on('click', function(){
  event.preventDefault();
    $.post( "<?= $url?>/reserved/flash-create", { 
        id: $('input[name="id"]').val(), 
        front:  $('textarea[name="front"]').val(), 
        verse:  $('textarea[name="verse"]').val(),
        course: $('select[name="course"]').val(),
        theme:  $('select[name="theme"]').val()
    }).done(function( data ) {
      location.reload();
    });
    $("#editFlash-modal").modal('hide');
});

</script>