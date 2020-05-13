

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
          <div style='background-color: #f5f5f5; left: -300px; top:-30px; right:-300px; bottom:-100px; position: absolute; z-index: -2'></div>
          <div class="col-md-10 col-md-offset-1" style='padding-top: 75px'>
            <h1>Olá <?= $Auth['first_name']; ?>!</h1>
            <p>Seleciona os temas dos <em>Flashcards</em> que desejas fazer.</p>
            <p style="margin-top: 30px"><?= $this->Form->intpu('wrong', ['options' => [0 => 'Todos os flashcards', 1 => 'Apenas os que errei', 2 => 'Apenas os favoritos'], 'default' => 0, 'type' => 'radio'])?></p>
            <a href='#' onClick="event.preventDefault(); $('.c').prop('checked', !$('.t').prop('checked'));$('.t').prop('checked', !$('.t').prop('checked'));">Selecionar todos os temas</a>
            <br>

          </div>




        <div class='row' >
          <div class='col-md-10 col-md-offset-1'>
            <table class='courses-list' style='margin-top: 20px; margin-bottom:20px'>
             <?php 
          foreach ($courses as $key => $course) { ?>
            <tr class='primary' id="<?= $key?>">
              <td width='40px'><input type="checkbox" id="<?= $key?>" class='c c_<?= $key?>' name='courses[]' value="<?= $course['id'] ?>"  ></td>
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
                                    <td style='padding: 5px' width='30px'><input type="checkbox" name="themes[]" value="<?= $theme['id']?>"  style='width:15px; height:15px' class="t_<?= $key?> t"></td></td>
                                    <td style='padding: 5px'><span class='small'><?= $theme['name']?></td>
                                    <td style='padding: 5px: width: 50px'><span class='small' style='color: <?= @$answered[$theme['id']] / $flashcards[$theme['id']] < 0.5 ? 'red' : ''?> <?= @$answered[$theme['id']] / $flashcards[$theme['id']] > 0.9 ? 'green' : ''?>' ><?= $this->Number->toPercentage(@$answered[$theme['id']] / $flashcards[$theme['id']] * 100, 0);?></td>
                                  </tr>
                                  <?php endif; } } ?>
                          </table>
                </div>
              </td>
            </tr>



             <?php } ?>
            </table>
            
          </div>
        </div>
    <button class='btn btn-black' type="submit" >COMEÇAR</button> 
          
        </div>
       </div>

<?php else: ?>

<div class="row" style='position:relative;'>
          <div style='background-color: #f5f5f5; left: -300px; top:-30px; right:-300px; bottom:-100px; position: absolute; z-index: -2'></div>
          <div class="col-md-10 col-md-offset-1" style='padding-top: 75px'>
            <h1>Olá <?= $Auth['first_name']; ?>!</h1>
            <p>Ainda não efetuaste nenhuma inscrição. </p>
            <br>
            <button class="btn btn-black" onclick="window.location.href='<?= $this->Url->build(["controller" => 'users', "action" => 'logout'], true); ?>'">LOGOUT</button>
          </div>
          
          
<?php endif; ?>

       
       
       </div>
     </form>
    </section>


  

  <style>
.courses-list a span{
  opacity: 0.85
}

.courses-list a:hover span{
  opacity: 1
}

input[type='checkbox'] {
        -webkit-appearance: none;
        width: 30px;
        height: 30px;

        outline: none;
        border: 2px solid gray;
        margin-left: 3px
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
  </style>

<script>
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
</script>

  