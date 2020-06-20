<section id="services" class="text-center ">
    <form method='post'>
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

            <?php if(isset($courses)): ?>

            <div class="row" style='position:relative;'>
                <div class="reserved-background"></div>
                <div class="col-md-10 col-md-offset-1" style='padding-top: 75px'>
                    <h1>Olá <?= $Auth['first_name']; ?>!</h1>
                    <p>Seleciona os temas, dificuldade e número das perguntas que desejas fazer.</p>
                    <a href='#' onClick="event.preventDefault(); $('.c').prop('checked', !$('.t').prop('checked'));$('.t').prop('checked', !$('.t').prop('checked'));">Selecionar todos os temas</a>
                    <div class="row" id="options">
                        <div class="col-xs-3 col-xs-offset-3"> 
                            <div class="well well-sm" id="difficulty">
                                <div>Dificuldade:</div>
                                <div>
                                    <input type="checkbox" name="difficulty[]" value="1" checked>Fácil
                                </div>
                                <div>
                                    <input type="checkbox" name="difficulty[]" value="2" checked> Intermédio
                                </div>
                                <div> 
                                    <input type="checkbox" name="difficulty[]" value="3" checked> Difícil
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-3">
                            
                            <div class="well well-sm" id="number">
                                <div>Número de <br>perguntas:</div>
                                <div>
                                    <input type="radio" name="number" value="10"> 10 perguntas
                                </div>
                                <div>
                                    <input type="radio" name="number" value="25"> 25 perguntas
                                </div>
                                <div>
                                    <input type="radio" name="number" value="50" checked> 50 perguntas
                                </div>
                                <div>
                                    <input type="radio" name="number" value="100"> 100 perguntas
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php if(isset($question_list2) && isset($pointer)): ?>
                    <p class="small" style="margin-top: 30px">
                        <a href="<?= $this->Url->build(["action" => "question", $pointer]) ?>" >
                            <i class="fa  fa-play-circle"></i> 
                            <b>Continuar Perguntas</b> 
                        </a>
                    </p>
                    <?php endif;?>
                </div>
             
                <div class='col-md-10 col-md-offset-1'>
                    <table class='courses-list' style='margin-top: 20px; margin-bottom:20px'>
                        <?php foreach ($courses as $key => $themes) { ?>
                        <tr class='primary' id="<?= $key?>">
                            <td width='40px'><input type="checkbox" id="<?= $key?>" class='c c_<?= $key?>' name='courses[]' value="<?= $key ?>"  ></td>
                            <td class='clickable'><?= $course_names[$key] ?></td>
                            <td width='50px' class='clickable'><i class="fa fa-chevron-down" id='arrow_<?= $key?>'></i></td>
                        </tr>    
                        <tr>
                            <td colspan='3' style='padding:0; background-color: #f5f5f5'>
                                <div class='dependency d<?= $key?> closed'>
                                    <table style='width: 100%;'>
                                        <?php if(count($themes) > 0) {
                                            foreach ($themes as $theme_id => $theme) { ?>
                                        <tr>
                                            <td style='padding: 5px' width='30px'><input type="checkbox" name="themes[]" value="<?= $theme_id ?>"  style='width:15px; height:15px' class="t_<?= $key?> t"></td>
                                            <td style='padding: 5px'><span class='small'><?= $theme ?></span></td>
                                        </tr>
                                        <?php  } } ?>
                                    </table>
                                </div>
                            </td>
                        </tr>
                        <?php } ?>
                    </table>
                </div>
                
                <button class='btn btn-black' type="submit" >COMEÇAR</button> 
            </div>
    
            <?php else: ?>

            <div class="row" style='position:relative;'>
                <div class="reserved-background"></div>
                <div class="col-md-10 col-md-offset-1" style='padding-top: 75px'>
                    <h1>Olá <?= $Auth['first_name']; ?>!</h1>
                    <p>Ainda não efetuaste nenhuma inscrição. </p>
                    <br>
                    <button class="btn btn-black" onclick="window.location.href='/users/logout'">LOGOUT</button>
                </div>
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
input[type='checkbox'],input[type="radio"] {
        -webkit-appearance: none;
        width: 30px;
        height: 30px;
        outline: none;
        border: 2px solid gray;
        margin-left: 3px
}
input[type='checkbox']:before, input[type="radio"]:before{
        content: '';
        display: block;
        width: 50%;
        height: 50%;
        margin: 25% auto;
}
input[type="checkbox"]:checked:before, input[type="radio"]:checked:before {
        background: #FEB000;
}
input[type='checkbox']:checked, input[type="radio"]:checked {
    border: 2px solid #152335;
}
#difficulty, #number{
    padding-top: 45px;
    position:relative;
    display: flex;
    flex-direction: column;
    align-content: space-between;
    height:90%;
    font-size:12pt;
    margin-top:10px;
    text-align: left;
    background: rgb(44, 57, 73, 0.2);
}
#difficulty input[type='checkbox'], #number input[type='radio']{
    width:20px; 
    height:20px; 
    position:relative; 
    top:5px;
    margin-right: 5px;
}
#difficulty div, #number div{
    height:100%;
}
#difficulty div:first-child, #number div:first-child{
    font-weight: bold;
    position: absolute;
    top: 5px;
    text-align: center;
    left:0;
    right:0;
}
.row#options{
    display: flex;
    flex-flow: row wrap;
}
.row#options::before{
    display: block;
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

  