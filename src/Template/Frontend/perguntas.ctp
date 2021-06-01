<?php $url = $this->Url->build(["prefix" => false, "controller" => '/'], true);

use Vimeo\Vimeo;

$client = new Vimeo("0af46bd862c619713814e571961d0c3f276fb58c", "I1w+gCaPsU49Wpy0JfsZCepYD/9hT88kJGkpnF4ko+MYhpTMYj+Un1kCpyFlGB8rvG59eAcIHKX103U8xP4zKBIzY1M612nXw+K/0hg5YITsvs/3eEFzbzojRXAIfKVg", "1c4b57b035d803815e1a0e13794815bc");

$uri = 'http://api.vimeo.com/me/albums/7542594/videos';
$response = $client->request('/videos/462578115',['muted' => 1, 'title' => 0, 'autoplay' => 1], 'GET');

$demo = $client->request('/videos/547440347',['muted' => 1, 'title' => 0, 'autoplay' => 0], 'GET');
?>

<!-- Header -->
<header style='background-image: url("<?= $url?>/img/banner5.jpg")'>
  <div class="container text-center">
    <span class='prelabel'>EKOS - Formar para a especialidade</span>
    <h1>A plataforma ideal para o teu treino</h1>
    <p class='prelabel'>Inscreve-te já!</p>
    <?php if(!isset($Auth['id'])): ?>
      <button class="btn btn-black" data-toggle="modal" data-target="#login" >INSCRIÇÃO</button>
    <?php else: ?>
      <button class="btn btn-black" onClick='window.location.href = "<?= $this->Url->build(["controller" => 'reserved', 'action' => 'inscription', 1]) ?>"'>INSCRIÇÃO</button>
    <?php endif; ?>

  </div>
</header>

<header id="trailer">
    <?= $response['body']['embed']['html'] ?><br>
</header>

    
  
<!--
<section id="recruting" class='text-center'>
      <div class="container">
        <div class="row">
          <div class="col-md-8 col-md-offset-2">
            <h1>Perguntas Exemplo.</h1>
            <p>Não sabes que tipo de perguntas vão sair na nova prova? A EKOS preparou para ti 25 perguntas-tipo, baseadas no modelo de vinheta clínica, para que possas saber o que te espera.</p>

            <button class="btn btn-black" onClick="window.open('http://ekos.pt/reserved/exam')" >COMEÇAR</button>
          </div>
        </div>
      </div>
    </section>
-->
   

   
    <section id="recruting" class='text-center' style="background: #f5f5f5">
      <div class="container">
        <div class="row">
          <div class="col-md-8 col-md-offset-2">
            <h1>O nosso Studio</h1>
            <p style="margin-bottom: 50px">Queres estudar quando e onde quiseres? Procuras uma alternativa digital para aprender, rever e praticar? A EKOS traz-te uma nova ferramente digital e interativa para cresceres no teu estudo.<br> Vem conhecer o EKOS Studio - a plataforma que desenvolvemos para ti!</p>
            <img style="width:100%; margin-bottom:10px" src="<?= $url?>/img/Perguntas.jpg" alt="Vídeos"></img>
            <p style="font-size:15px;"><b>Personaliza o teu Studio | Perguntas</b><br>Escolhe as fáceis, as difíceis, as novas ou as que erraste, as de ansiedade generalizada ou as tuas favoritas. Ou podes sempre escolher todas. Tudo isto em sessões com o número de perguntas que quiseres e podes ainda cronometrar cada sessão ou definir um tempo limite!</p>
          </div>
        </div>
      </div>
    </section>

    <section class='text-sm-left text-center no-gutters about'>
      <div class="row is-flex">
          <div class="col-sm-6 studio studioL" style='background-image: url("<?= $url?>/img/Perguntas2.jpg?>");background-color: #fefefe'>
          </div>
          <div class="col-sm-6 bibliography_box" style="background:#fefefe; color:#152133">
              <h2>Perguntas.</h2>
              <p>Pratica e simula o que te espera na prova com as centenas de perguntas e casos clínicos que temos para ti!<br> São mais de 1000 perguntas, incluindo perguntas das provas, exames de simulação da EKOS e centenas de perguntas originais organizadas por módulos e temas da matriz.</p>
              <button class="btn btn-black" onClick='window.location.href = "<?= $this->Url->build(["controller" => 'reserved', 'action' => 'trial', 0]) ?>"'>Experimenta aqui!</button>
          </div>
      </div>
    </section>

    <section class='text-sm-left text-center no-gutters about'>
      <div class="row is-flex">
          <div class="col-sm-6 bibliography_box" style="background: #f5f5f5; color: #152133">
              <h2>Flashcards.</h2>
              <p>O nosso deck de 2400 flashcards tem como objetivo ajudar-te a testares e reforçares o teu conhecimento!<br> Podes também criar os teus próprios flashcards, organizados por módulo e tema, para construires o teu banco personalizado de flashcards.
              </p>
              <button class="btn btn-black" onClick='window.location.href = "<?= $this->Url->build(["controller" => 'reserved', 'action' => 'trial', 1]) ?>"'>Experimenta aqui!</button>
          </div>
          <div class="col-sm-6 studio studioR" style='background-image: url("<?= $url?>/img/Flashcards.jpg?>");'>
            
          </div>

      </div>
    </section>

    <section class='text-sm-left text-center no-gutters about'>
      <div class="row is-flex">
          <div class="col-sm-6 studio studioL" style='background-image: url("<?= $url?>/img/Videos.jpg?>"); background-color: white'>
          </div>
          <div class="col-sm-6 bibliography_box" id="studioV" style="background:#152133; color:white">
              <h2>Vídeos.</h2>
              <p>Assiste aos nossos vídeos curtos dirigidos a temas chave que te vão permitir aprender e rever a matéria de forma sucinta e eficaz antes de mergulhares de cabeça nas centenas de casos clínicos que temos para ti!
              </p>
              <button id="show-video" class="btn btn-black">Experimenta aqui!</button>
          </div>
      </div>
    </section>

    <section class='text-sm-left text-center no-gutters about'>
      <div class="row is-flex">
          <div class="col-sm-6 bibliography_box" id="studioF" style="background: #f5f5f5; color:#152133;">
              <h2>Fórum de Dúvidas.</h2>
              <p>Coloca as tuas dúvidas sobre os temas de cada módulo para esclarecer todas as tuas questões com os nossos formadores! Consulta ainda as dúvidas colocadas pelos teus colegas e participa em discussões sobre a matéria.</p>
          </div>
          <div class="col-sm-6 studioR studio" style='background-image: url("<?= $url?>/img/Forum.jpg?>");'>
            
          </div>
      </div>
    </section>
    

     <section id="services" class="text-center">
      <div class="container">
        <div class="row" style='margin-bottom:75px'>
          <div class="col-md-8 col-md-offset-2 tab-content">
            <h1 style='text-align:center'>Informações</h1>
            <p>O EKOS Studio dá-te acesso à nossa plataforma digital construída para te ajudar a preparar e estudar para a prova. Uma ferramente assente em 4 pilares, constituída por <b>vídeos curtos e interativos</b>, uma base de <b>perguntas-tipo em modelo de caso-clínico</b> (formato do exame), um extenso conjunto de <b><em>flashcards</em> para revisão e treino</b> dos conteúdos previamente estudados e um <b>fórum de dúvidas</b>. A plataforma traz-te uma abordagem nova e interativa com ênfase na personalização das tuas preferências, desde a dificuldade das perguntas à selecão dos teus conteúdos favoritos.</p>
            <p> À data de lançamento, a <b>1 de Novembro de 2020</b>, existirão 1000 perguntas, incluindo a anterior PNA e prova-piloto, 2400 flashcards e mais de uma dezena de vídeos. Novos conteúdos serão ainda adicionados ao longo do ano e durante o decorrer dos módulos.</p>
            <p> A inscrição terá <b>validade até à data da prova nacional de acesso de 2021</b>. A inscrição pode ser realizada através do botão 'Inscrever' no início desta página, encontrando-se o procedimento de inscrição descrito na página Informações.</p>
          </div>
        </div>
      </div>
    </section>

<div class="modal fade" id="fullvideo">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            <div id="fullvideo-frame">
                <?= $demo['body']['embed']['html'] ?>
            </div>
              <h1 class="modal-title">Demências</h1>
              <p id="fullvideo-description">Demências</p>
          </div>
          <div class="modal-body">
                  <div id="fullvideo-related">
                    <div class="row" style="border-top: 1px solid #152133">
                      <div class="col-xs-12">
                        Perguntas sobre este assunto
                      </div>
                    </div>
                    <div class="row" id="q_options">
                      <div id="qbank">
                            <div class="col-xs-4"> 
                                <div class="well well-sm options" id="difficulty">
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
                            <div class="col-xs-4">   
                                <div class="well well-sm options" id="filter">
                                    <div>Perguntas</div>
                                    <div>
                                        <input type="checkbox" name="filter[]" class="filter-q" value="0">Novas
                                    </div>
                                    <div>
                                        <input type="checkbox" name="filter[]" class="filter-q" value="1">Incorretas
                                    </div>
                                    <div>
                                        <input type="checkbox" name="filter[]" class="filter-q" value="2">Favoritas
                                    </div>
                                    <div>
                                        <input type="checkbox" name="filter[]" class="all-q" value="3" checked>Todas
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-4">   
                                <div class="well well-sm options" id="time">
                                    <div>Temporizador</div>
                                      <div>
                                          <input type="radio" name="timer" id="chronometer" value="0"> Cronómetro
                                      </div>
                                      <div>
                                          <input type="radio" name="timer" class="timer" id="no-lim" value="1">
                                      </div>
                                      <div id="tempo_input">
                                          <input type="text" name="time-lim" class="timer" value="60"> min
                                      </div>
                                      <hr id="separator">
                                      <div>
                                        <button id="questionGo" onClick='window.location.href = "<?= $this->Url->build(["controller" => 'reserved', 'action' => 'trial', 0]) ?>"'>Iniciar</button>
                                      </div>
                                </div>
                            </div>
                        </div>
                      </div>
                    <div class="row" style="border-top: 1px solid #152133">
                      <div class="col-xs-12">
                        Flashcards sobre este assunto
                      </div>
                    </div>
                    <div class="row" id="f_options">
                      <div id="fbank">
                          <div class="col-12"> 
                                <div class="well well-sm options" id="f_difficulty">
                                    <div>Perguntas</div>
                                    <div>
                                        <input type="radio" name="wrong" value="0" checked>Todas
                                    </div>
                                    <div>
                                        <input type="radio" name="wrong" value="1"> Incorretas
                                    </div>
                                    <div> 
                                        <input type="radio" name="wrong" value="2"> Favoritas
                                    </div>
                                <button id="flashcardGo" onClick='window.location.href = "<?= $this->Url->build(["controller" => 'reserved', 'action' => 'trial', 1]) ?>"'>Iniciar</button> 
                                </div>
                            </div>
                        </div>
                    </div>
                  </div>
                  <div class="modal-footer row">
                      <div class="col-sm-6 col-sm-offset-6 col-xs-12 text-sm-right text-center">
                      </div> 
                  </div>
          </div>
        </div>
    </div>
</div>


<style>
  header#trailer iframe{
      width: 100%;
      height: -webkit-fill-available;
  }
  header#trailer{
    box-shadow: none;
    background: #152133;
    padding-top: 0;
    padding-bottom: 0;
  }
  @media(max-width:1580px){
    header#trailer iframe{
      height: 60vw;
      max-height:650px;
    }
  }
  @media(max-width:991px){
    div.col-sm-6.bibliography_box{
      padding: 15px;
    }
  }
  @media(min-width:992px){
    header#trailer iframe{
      min-height: 500px;
    }
  }
  div.row.is-flex div.col-sm-6:first-child{
    margin-left: 15px;
  }
  div.row.is-flex div.col-sm-6{
    padding-left: 40px;
    padding-right: 40px;
  }
  div.studio{
    background-size: contain!important; 
    background-color: #f5f5f5; 
    background-repeat: no-repeat;
    background-position: center; 
    background-origin: content-box;
    justify-content: center; 
    align-items: center; 
    color:white; 
    font-weight: bold; 
    font-size:120%; 

  }
  div.studioL{
    margin-left: 15px;
  }
  div.studioR{
    margin-right: 15px;
  }
  @media(max-width:992px){
    div.row.is-flex div.col-sm-6{
      padding-left: 15px;
      padding-right:15px;
    }
  }
  @media(max-width: 768px){
    div.row.is-flex{
      display: flex;
      flex-flow: column;
    }
    div.studio{
      order: 2;
      padding-bottom: 20px!important;
    }
    div.row.is-flex div.col-sm-6.bibliography_box{
      box-shadow: inset 0px 100px 50px -115px!important;
      padding: 40px;
    }
    div#studioV{
      background: white!important;
      color: #152133!important;
    }
  }
  .btn-black{
    background-color: #FEB000!important;
    color: #152335!important;
    margin: auto;
    margin-top: 20px;
  }
  .btn-black:hover{
    background-color: !#152335!important;
    color: white!important;
  }
  
  /* VIDEO DEMO */

  .modal-header{
  height:  fit-content;
  padding: 0;
  border-bottom: none;
}
.modal-header button.close{
  position: absolute;
  right: 10px;
  top: 10px;
  color: #ffdf80;
}
#fullvideo-frame{
  height: 340px;
  border: 1px solid black;
}
@media(max-width:767px){
  #fullvideo-frame{
    height: calc(53vw);
  }
}
#fullvideo-frame iframe{
  height: 100%;
  width: 100%;
}
.modal-title{
  font-size: 1.8em;
  padding-top: 10px;
  padding-left: 15px;
}
#fullvideo-description{
  font-size: 1em;
  padding-top: 10px;
  padding-left: 15px;
}
.modal-content{
  border-radius: 10px;
  background: #FFDF80;
}

.modal-footer{
  border: none;
}


#fullvideo .modal-content{
  border-top-left-radius: 0;
  border-top-right-radius: 0;
}
#fullvideo input[type='checkbox'], #fullvideo input[type="radio"], #fullvideo input[type="text"]{
        -webkit-appearance: none;
        outline: none;
        border: 2px solid gray;
        margin-left: 3px
}
#fullvideo input[type='checkbox']:before, #fullvideo input[type="radio"]:before{
        content: '';
        display: block;
        width: 50%;
        height: 50%;
        margin: 25% auto;
}
#fullvideo input[type="checkbox"]:checked:before, #fullvideo input[type="radio"]:checked:before{
        background: #FEB000;
}
#fullvideo input[type='checkbox']:checked, #fullvideo input[type="radio"]:checked{
    border: 2px solid #152335;
}
#fullvideo input[type='checkbox']:disabled, #fullvideo input[type="text"]:disabled{
    border: 2px solid grey;
    background: grey!important;
}
.options{
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
.options#time{
  padding-bottom: 35px;
}
.options input[type='checkbox'], .options input[type='radio']{
    width:20px; 
    height:20px; 
    position:relative; 
    top:5px;
    margin-right: 5px;
}
.options input[type='text']{
    width:35px; 
    height:auto; 
    text-align: center;
    position:relative; 
    background-color: transparent;
}
.options #tempo_input{
    text-align:center;
    margin-top:-22px;
}
.options div:first-child{
    font-weight: bold;
    position: absolute;
    top: 15px;
    text-align: center;
    left:0;
    right:0;
}
#fullvideo hr#separator{
    margin: 18px 0 10px 0;
    border: 0.5px solid black;
    background: black;
}
#fullvideo .row#q_options{
    display: block;
}
@media(min-width: 1200px){
    .row#q_options{
        display: flex;
    }
}
@media(max-width: 768px){
    .row#q_options>.col-lg-3:nth-child(odd) .options{
        float:right;
    }
    .row#q_options>.col-lg-3:nth-child(even) .options{
        float:left;
    }
}
.row#q_options::before{
    display: block;
}
#fbank .options{
  padding-bottom: 50px;
}
@media(max-width: 500px){
    .options{
        width:100%;
    }
    .col-xs-6{
        padding-right: 5px;
        padding-left: 5px;
    }
    #questionGo{
      bottom: 8px;
    }
    .options#time{
    padding-bottom: 45px;
    margin-bottom: 15px;
  }
}
#questionGo, #flashcardGo{
  position: absolute;
  bottom: 8px;
  left: 0;
  right: 0;
  margin: auto;
  background: #ffdf80;
  border-radius: 5px;
  width: 60%;
}
#fbank .options{
  flex-direction: row;
  justify-content: space-evenly;
}
@media(max-width:590px){
  #qbank .col-xs-4{
    padding-left: 5px;
    padding-right: 5px;
  }
}
@media(max-width:506px){
  #qbank .col-xs-4{
    width:100%;
  }
  #qbank .options{
    flex-direction: row;
    justify-content: space-around;
  }
  hr#separator{
    display:none;
  }
  #qbank #tempo_input{
    margin-top: 5px;
    margin-left: -30px;
  }
}
@media(max-width:360px){
  #qbank .options{
    flex-direction: column;
  }
  #qbank #tempo_input{
    margin-top: -23px;
    margin-left: -90px;
  }
}
#login input{
  background: #ffdf80;
}

</style>
<script>
$('.primary').on('click', function(){
  id = $(this).attr('id');
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

$('#show-video').click(function(){
    $('#fullvideo').modal('show');
  });

<?php if(isset($_GET['c'])): ?>
$('.dependency.d<?= $_GET['c'] ?>').removeClass('closed');
$('#arrow_<?= $_GET['c'] ?>').removeClass('fa-chevron-down').addClass('fa-chevron-up');
$("#arrow_<?= $_GET['c']?>").get(0).scrollIntoView();

setTimeout(function(){$('html, body').animate({
                    scrollTop: $("#arrow_<?= $_GET['c']?>").offset().top-100
                }, 500)}, 500);
<?php endif;?>
</script>