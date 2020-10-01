<?php $url = $this->Url->build(["prefix" => false, "controller" => '/'], true);

use Vimeo\Vimeo;

$client = new Vimeo("0af46bd862c619713814e571961d0c3f276fb58c", "I1w+gCaPsU49Wpy0JfsZCepYD/9hT88kJGkpnF4ko+MYhpTMYj+Un1kCpyFlGB8rvG59eAcIHKX103U8xP4zKBIzY1M612nXw+K/0hg5YITsvs/3eEFzbzojRXAIfKVg", "1c4b57b035d803815e1a0e13794815bc");

$uri = 'http://api.vimeo.com/me/albums/7542594/videos';
$response = $client->request('/videos/462578115',['muted' => 1, 'title' => 0, 'autoplay' => 1], 'GET');

?>

<!-- Header -->
<header style='background-image: url("<?= $url?>/img/banner5.jpg")'>
  <div class="container text-center">
    <span class='prelabel'>EKOS - Formar para a especialidade</span>
    <h1>A plataforma ideal para o teu treino</h1>
    <span class='prelabel'>Lançamento a 1 de Novembro</span>

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
   

   
    <section id="recruting" class='text-center' style="background: #f5f5f5;">
      <div class="container">
        <div class="row">
          <div class="col-md-8 col-md-offset-2">
            <h1>O nosso Studio</h1>
            <p>Queres estudar quando e onde quiseres? Procuras uma alternativa digital para aprender, rever e praticar? A EKOS traz-te uma nova ferramente digital e interativa para cresceres no teu estudo. <br>Vem conhecer o EKOS Studio - a plataforma que desenvolvemos para ti!<br> <br>
            </p>
          </div>
          <div class="col-md-12">
            <img style="width:100%; margin-bottom:20px; margin-top:20px" src="<?= $url?>/img/Perguntas.jpg" alt="Vídeos"></img>
            <p style="width: 80%; text-align:center; margin-bottom:30px; font-size:1.1em">Personaliza o teu Studio | Perguntas <br> Escolhe as fáceis, as difíceis, as novas ou as que erraste, as de ansiedade generalizada ou as tuas favoritas. Ou podes sempre escolher todas. Tudo isto em sessões com o número de perguntas que quiseres e podes ainda cronometrar cada sessão ou definir um tempo limite! </p>
          </div>
        </div>
      </div>
    </section>

    <section class='text-sm-left text-center no-gutters about'>
      <div class="row is-flex">
          <div class="col-sm-6 studio studioL" style='background-image: url("<?= $url?>/img/Perguntas2.jpg?>"); background-size: contain;background-color: white;background-repeat: no-repeat; background-position: center;justify-content: center; align-items: center; color:white; font-weight: bold; font-size:120%; margin-right:15px'>
          </div>
          <div class="col-sm-6 bibliography_box" style="background: white; color: #152133">
              <h2>Perguntas.</h2>
              <p>Pratica e simula o que te espera na prova com as centenas de perguntas e casos clínicos que temos para ti! <br> São mais de 1000 perguntas, incluindo perguntas das provas, exames de simulação da EKOS e centenas de perguntas originais organizadas por módulos e temas da matriz. </p>
          </div>
      </div>
    </section>

    <section class='text-sm-left text-center no-gutters about'>
      <div class="row is-flex">
          <div class="col-sm-6 bibliography_box" style="background: #f5f5f5; color: #152133">
              <h2>Flashcards.</h2>
              <p>O nosso deck de 2400 flashcards tem como objetivo ajudar-te a testares e reforçares o teu conhecimento! <br>Podes também criar os teus próprios flashcards, organizados por módulo e tema, para construires o teu banco personalizado de flashcards.
              
              </p>
              
          </div>
          <div class="col-sm-6 studio studioR" style='background-image: url("<?= $url?>/img/Flashcards.jpg?>"); background-size: contain;background-color: #f5f5f5;background-repeat: no-repeat; background-position: center;justify-content: center; align-items: center; color:white; font-weight: bold; font-size:120%; margin-right:15px'>
            
          </div>
      </div>
    </section>

    <section class='text-sm-left text-center no-gutters about'>
      <div class="row is-flex">
          <div class="col-sm-6 studio studioL" style='background-image: url("<?= $url?>/img/Videos.jpg?>"); background-size: contain;background-color: white;background-repeat: no-repeat; background-position: center;justify-content: center; align-items: center; color:white; font-weight: bold; font-size:120%; margin-left:15px'>
            
          </div>
          <div class="col-sm-6 bibliography_box" style="background: #152335; color: white">
              <h2>Vídeos.</h2>
              <p>Assiste aos nossos vídeos curtos dirigidos a temas chave que te vão permitir aprender e rever a matéria de forma sucinta e eficaz antes de mergulhares de cabeça nas centenas de casos clínicos que temos para ti!
              </p>
          </div>

      </div>
    </section>

    <section class='text-sm-left text-center no-gutters about'>
      <div class="row is-flex">
          <div class="col-sm-6 bibliography_box" style="background: #f5f5f5; color: #152133; ">
              <h2>Fórum de Dúvidas.</h2>
              <p>Coloca as tuas dúvidas sobre os temas de cada módulo para esclarecer todas as tuas questões com os nossos formadores! Consulta ainda as dúvidas colocadas pelos teus colegas e participa em discussões sobre a matéria.</p>
          </div>
          <div class="col-sm-6 studioR" style='background-image: url("<?= $url?>/img/Forum.jpg?>"); justify-content: center; align-items: center; color:white; font-weight: bold; font-size:120%; background-origin: content-box;'>
            
          </div>
      </div>
    </section>
    

     <section id="services" class="text-center">
      <div class="container">
        <div class="row" style='margin-bottom:75px'>
          <div class="col-md-8 col-md-offset-2 tab-content">
            <h1 style='text-align:center'>Informações</h1>
            <p>O EKOS Studio dá-te acesso à nossa plataforma digital construida para te ajudar a preparar e estudar para a prova. Uma ferramente assente em 4 pilares, constituída por <b>vídeos curtos e interativos</b>, uma base de <b>perguntas-tipo em modelo de caso-clínico </b> (formato do exame), um extenso conjunto de <b><em>flashcards</em> para revisão e treino</b> dos conteúdos previamente estudados e um <b>fórum de dúvidas</b>. A plataforma traz-te uma abordagem nova e interativa com ênfase na personalização das tuas preferências, desde a dificuldade das perguntas e selecão de conteúdos favoritos.</p>
            <p>À data de lançamento, a <b>1 de Novembro de 2020</b>, existirão 1000 perguntas, incluindo a anterior PNA e prova-piloto, 2400 flashcards e mais de uma dezena de vídeos. Novos conteúdos serão ainda adicionados ao longo do ano, durante o decorrer dos módulos, totalizando mais de 100 vídeos interativos.  </p>
            <p> A inscrição terá validade até à data da prova nacional de acesso de 2021</b>. O método de inscrição é semelhante ao dos restantes módulos, cujo procedimento se encontra descrito na página Informações.</p> 
            <p> A inscrição no EKOS Studio é gratuita para todos os alunos da EKOS inscritos no curso anual.</p>
          </div>
        </div>
      </div>
    </section>

    <section id="recruting" class='bg-light text-center'>
      <div class="container">
        <div class="row">
          <div class="col-md-8 col-md-offset-2">
            <h1>Inscrição EKOS Studio.</h1>
            <p>O lançamento da plataforma terá lugar no dia 1 de Novembro, encontrando-se aberto o período de pré-inscrições!<br> A inscrição no EKOS Studio tem o <strike>valor de 150€</strike>.
            </p>
            <p style="font-size: 25px; color: #FEB000;">Valor promocional até 15 de Novembro | 100€</p>

		        <?php if (!isset($Auth['id'])): echo '<button class="btn btn-black" data-toggle="modal" data-target="#login" >INSCREVER</button>'; else: ?> 
              <button class="btn btn-black" onClick='window.location.href = "<?= $this->Url->build(["controller" => 'reserved', 'action' => 'inscription', 1]) ?>"'>PRÉ-INSCRIÇÃO</button>
            <?php endif; ?>
		
          </div>
        </div>
      </div>
    </section>


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
      max-height:720px;
    }
  }
  @media(max-width:991px){
    div.col-sm-6.bibliography_box{
      padding: 15px;
    }
  }
  div.row.is-flex div.col-sm-6:first-child{
    margin-left: 15px;
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

<?php if(isset($_GET['c'])): ?>
$('.dependency.d<?= $_GET['c'] ?>').removeClass('closed');
$('#arrow_<?= $_GET['c'] ?>').removeClass('fa-chevron-down').addClass('fa-chevron-up');
$("#arrow_<?= $_GET['c']?>").get(0).scrollIntoView();

setTimeout(function(){$('html, body').animate({
                    scrollTop: $("#arrow_<?= $_GET['c']?>").offset().top-100
                }, 500)}, 500);
<?php endif;?>
</script>