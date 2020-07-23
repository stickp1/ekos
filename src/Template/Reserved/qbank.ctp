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
                    <p>Seleciona os temas que desejas fazer e personaliza a tua sessão de treino.</p>
                    <div class="row" id="options">
                        <div class="col-lg-3"> 
                            <div class="well well-sm q-options" id="difficulty">
                                <div>
                                    <input type="checkbox" id="all-themes">Todos os temas
                                </div>
                                <hr id="separator">
                                <div>Dificuldade</div>
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
                        <div class="col-lg-3">   
                            <div class="well well-sm q-options" id="filter">
                                <div>Filtros</div>
                                <div>
                                    <input type="checkbox" name="filter[]" class="filter-q" value="0"> Perguntas novas
                                </div>
                                <div>
                                    <input type="checkbox" name="filter[]" class="filter-q" value="1"> Perguntas incorretas
                                </div>
                                <div>
                                    <input type="checkbox" name="filter[]" class="filter-q" value="2"> Perguntas favoritas
                                </div>
                                <div>
                                    <input type="checkbox" name="filter[]" class="all-q" value="3" checked> Todas as perguntas
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 ">   
                            <div class="well well-sm q-options" id="number">
                                <div>Número</div>
                                <div>
                                    <input type="radio" name="number" value="10"> 10 perguntas
                                </div>
                                <div>
                                    <input type="radio" name="number" value="25" checked> 25 perguntas
                                </div>
                                <div>
                                    <input type="radio" name="number" value="50"> 50 perguntas
                                </div>
                                <div>
                                    <input type="radio" name="number" value="100"> 100 perguntas
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3">   
                            <div class="well well-sm q-options" id="time">
                                <div>Temporizador</div>
                                <div>
                                    <input type="radio" name="timer" id="chronometer" value="0"> Cronómetro
                                </div>
                                <div>
                                    <input type="radio" name="timer" class="timer" id="no-lim" value="1"> Duração da sessão: 
                                </div>
                                <div id="tempo_input">
                                    <input type="text" name="time-lim" class="timer" value="60"> minutos
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php if(isset($question_list) && isset($pointer)): ?>
                    <p class="small" style="margin-top: 30px">
                        <a href="<?= $this->Url->build(["action" => "question", $pointer]) ?>" >
                            <i class="fa  fa-play-circle"></i> 
                            <b>Continuar Sessão de Treino</b> 
                        </a>
                    </p>
                    <?php endif;?>
                </div>
             
                <div class='col-md-10 col-md-offset-1'>
                    <table class='courses-list' style='margin-top: 20px; margin-bottom:20px'>
                        <?php foreach ($courses as $key => $themes): ?>
                        <tr class='primary' id="<?= $key?>">
                            <td width='40px'><input type="checkbox" id="<?= $key?>" class='c c_<?= $key?>' name='courses[]' value="<?= $key ?>"  ></td>
                            <td class='clickable'><?= $course_names[$key] ?></td>
                            <td width='50px' class='clickable'><i class="fa fa-chevron-down" id='arrow_<?= $key?>'></i></td>
                        </tr>    
                        <tr>
                            <td colspan='3' style='padding:0; background-color: #f5f5f5'>
                                <div class='dependency d<?= $key?> closed'>
                                    <table style='width: 100%;'>
                                        <?php if(count($themes) > 0): ?>
                                            <?php foreach ($themes as $theme_id => $theme): ?>
                                                <?php if(isset($questions[$theme_id])): ?>
                                                <tr>
                                                    <td style='padding: 5px' width='30px'><input type="checkbox" name="themes[]" value="<?= $theme_id ?>"  style='width:15px; height:15px' class="t_<?= $key?> t"></td>
                                                    <td style='padding: 5px'><span class='small'><?= $theme ?></span></td>
                                                    <td style='padding: 5px: width: 50px'>
                                                        <span class='small' style='color: 
                                                          <?= @$answered[$theme_id] / $questions[$theme_id] < 0.5 ? 'red' : ''?> 
                                                          <?= @$answered[$theme_id] / $questions[$theme_id] > 0.9 ? 'green' : ''?>' 
                                                        >
                                                          <?= $this->Number->toPercentage(@$answered[$theme_id] / $questions[$theme_id] * 100, 0);?>
                                                        </span>
                                                    </td>
                                                </tr>
                                                <?php endif; ?>
                                            <?php  endforeach ?>
                                        <?php endif ?>
                                    </table>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach ?>
                    </table>
                </div>
                
                <button class='btn btn-black' type="submit" >INICIAR SESSÃO DE TREINO</button> 
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
.col-lg-3{
    padding-left: 8px;
    padding-right: 8px;
}
input[type='checkbox'],input[type="radio"], input[type="text"]{
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
input[type="checkbox"]:checked:before, input[type="radio"]:checked:before{
        background: #FEB000;
}
input[type='checkbox']:checked, input[type="radio"]:checked{
    border: 2px solid #152335;
}
input[type='checkbox']:disabled, input[type="text"]:disabled{
    border: 2px solid grey;
    background: grey!important;
}
.q-options{
    padding-top: 45px;
    position:relative;
    display: flex;
    flex-direction: column;
    align-content: space-between;
    height:90%;
    font-size:12pt;
    margin-top:10px;
    text-align: left;
    border: 2.2px solid #152335;
    border-radius: 10px;
}
.q-options input[type='checkbox'], .q-options input[type='radio']{
    width:20px; 
    height:20px; 
    position:relative; 
    top:5px;
    margin-right: 5px;
}
.q-options input[type='text']{
    width:35px; 
    height:25px; 
    text-align: center;
    position:relative; 
    background-color: transparent;
}
.q-options #no-lim{
    margin-top:25px;
}

.q-options #tempo_input{
    text-align:center;
    margin-top:5px;
}
/*.q-options div{
    height:100%;
}*/
.q-options div:first-child{
    font-weight: bold;
    position: absolute;
    top: 15px;
    text-align: center;
    left:0;
    right:0;
}
hr#separator{
    margin: 10px 0 10px 0;
    border: 0.5px solid black;
    background: black;
}
#difficulty{
    padding-top: 5px;
}
#difficulty div:first-child{
    position: relative;
    top: 0px;
}
#difficulty div:nth-child(3){
    font-weight: bold;
    text-align: center;
}
.row#options{
    display: inline-flex;
    flex-flow: row wrap;
    flex-direction: row;
    align-content: space-between;
}
@media(min-width: 1200px){
    .row#options{
        display: flex;
    }
}
@media(max-width: 768px){
    .q-options{
        width: 200px
    }
    .row#options>.col-lg-3:nth-child(odd) .q-options{
        float:right;
    }
    .row#options>.col-lg-3:nth-child(even) .q-options{
        float:left;
    }
}
.row#options::before{
    display: block;
}
@media(max-width: 500px){
    .q-options{
        width:100%;
    }
    .col-xs-6{
        padding-right: 5px;
        padding-left: 5px;
    }
}
</style>

<script>

function optionStyle(){
    if($(this).width() < 752)
        $('.col-lg-3').addClass('col-xs-6');
    else 
        $('.col-lg-3').removeClass('col-xs-6');
}

$('#all-themes').on('click', function(){
    if($(this).prop('checked'))
        $('.c, .t').prop('checked', true);
    else
        $('.c, .t').prop('checked', false);
        
})

$('#chronometer').on('click', function(){
    if($(this).prop('checked')){
        $('.timer').attr('disabled', false);
    }
    else{
        $('.timer').attr('disabled', true);
    }
});
$('.all-q').on('click', function(){
    if($(this).prop('checked'))
        $('.filter-q').prop('checked', false);
});
$('.filter-q').on('click', function(){
    $('.all-q').prop('checked', false);
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
});

$('.c').on('change', function(){
  id = $(this).attr('id');
  if($(this).prop('checked') > 0){
    $(".t_"+id).prop('checked', true);
  } else {
    $(".t_"+id).prop('checked', false);
  }
});


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
});

$(window).resize(optionStyle);

$(document).ready(optionStyle());
</script>

  