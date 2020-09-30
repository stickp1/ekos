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
   
   <section id="recruting" class='bg-light text-center'>
      <div class="container">
        <div class="row">
          <div class="col-md-8 col-md-offset-2">
            <h1>Banco de Perguntas e Flashcards.</h1>
            <p>Não podes assistir aos nossos cursos presenciais, mas gostarias de ter acesso ao nosso Banco de Perguntas e Flashcards? Agora já é possível!<br> <strike>Pelo preço de 150€</strike>, podes inscrever-te na Ekos Studio
            </p>
            <p style="font-size: 30px; color: #FEB000;">Promoção até 15 de Novembro | 100€</p>

		        <?php if (!isset($Auth['id'])): echo '<button class="btn btn-black" data-toggle="modal" data-target="#login" >INSCREVER</button>'; else: ?> 
              <button class="btn btn-black" onClick='window.location.href = "<?= $this->Url->build(["controller" => 'reserved', 'action' => 'inscription', 1]) ?>"'>INSCREVER</button>
            <?php endif; ?>
		
          </div>
        </div>
      </div>
    </section>

   
    <section id="recruting" class='text-center'>
      <div class="container">
        <div class="row">
          <div class="col-md-8 col-md-offset-2">
            <h1>O que é o EKOS Studio?</h1>
            <p>Não podes assistir aos nossos cursos presenciais, mas gostarias de ter acesso ao nosso Banco de Perguntas e Flashcards? Agora já é possível!<br> <strike>Pelo preço de 150€</strike>, podes inscrever-te na Ekos Studio
            </p>
            <img style="width:100%; margin-bottom:50px" src="<?= $url?>/img/Perguntas2.jpg" alt="Vídeos"></img>
          </div>
        </div>
      </div>
    </section>

    <section class='text-sm-left text-center no-gutters about'>
      <div class="row is-flex">
          <div class="col-sm-6 studio studioL" style='background-image: url("<?= $url?>/img/Perguntas.jpg?>");'>
          </div>
          <div class="col-sm-6 bibliography_box" style="background:#f5f5f5; color:#152133">
              <h2>Perguntas.</h2>
              <p>De entre as mais de 1000 perguntas, escolhe as fáceis, as difíceis, as novas, as que erraste, as de Perturbação de Ansiedade generalizada, as tuas favoritas. Ou podes sempre escolher todas. Há sessões de 10, 25, 50 ou 100 perguntas (que podem ser estendidas indefinidamente). Podes ainda cronometrar cada sessão ou definir um tempo limite!</p>
          </div>
      </div>
    </section>

    <section class='text-sm-left text-center no-gutters about'>
      <div class="row is-flex">
          <div class="col-sm-6 bibliography_box" style="background: white; color:#152133">
              <h2>Vídeos.</h2>
              <p>Vídeos curtos dirigidos a temas chave para reveres a matéria e aprenderes da melhor forma! Vídeos curtos dirigidos a temas chave para reveres a matéria e aprenderes da melhor forma!
              </p>
              <br>
              <br>
              <br>
              <br>
              
          </div>
          <div class="col-sm-6 studio studioR" style='background-image: url("<?= $url?>/img/Videos.jpg?>"); background-size: contain;background-color: white;background-repeat: no-repeat; background-position: center;justify-content: center; align-items: center; color:white; font-weight: bold; font-size:120%; margin-right:15px'>
            
          </div>
      </div>
    </section>

    <section class='text-sm-left text-center no-gutters about'>
      <div class="row is-flex">
          <div class="col-sm-6 studio studioL" style='background-image: url("<?= $url?>/img/Flashcards.jpg?>"); background-size: contain;background-color: #f5f5f5;background-repeat: no-repeat; background-position: center;justify-content: center; align-items: center; color:white; font-weight: bold; font-size:120%; margin-left:15px'>
            
          </div>
          <div class="col-sm-6 bibliography_box" style="background: #f5f5f5; color: #152133">
              <h2>Flashcards.</h2>
              <p>Para perguntas curtas e específicas com respostas diretas podes utilizar o nosso extenso deck de flashcards, marcando cada flashcard como certo, errado ou favorito. Podes também adicionar os teus próprios flashcards, organizados por módulo e tema, que ficarão numa secção separada. Assim podes treinar alternadamente utilizando os nossos, os teus, ou todos juntos!
              
              </p>
          </div>

      </div>
    </section>

    <section class='text-sm-left text-center no-gutters about'>
      <div class="row is-flex">
          <div class="col-sm-6 bibliography_box" style="background: #f5f5f5; color:#152133; box-shadow: inset 0px 100px 50px -115px, inset 0px -100px 50px -115px ">
              <h2>Fórum de Dúvidas.</h2>
              <p>Coloca as tuas dúvidas sobre os temas de cada módulo em que estás inscrito, e os nossos formadores irão assim que possível responder a cada dúvida colocada. Consulta ainda as dúvidas colocadas pelos teus colegas e participa em discussões sobre a matéria.</p>
          </div>
          <div class="col-sm-6 studioR" style='background-image: url("<?= $url?>/img/Forum.jpg?>"); justify-content: center; align-items: center; color:white; font-weight: bold; font-size:120%; background-origin: content-box;'>
            
          </div>
      </div>
    </section>
    

     <section id="services" class="text-center">
      <div class="container">
        <div class="row" style='margin-bottom:75px'>
          <div class="col-md-8 col-md-offset-2 tab-content">
            <h1 style='text-align:center'>o que tem a EKOS Studio?</h1>
            <p>Este módulo fornece acesso à nossa base de <b>perguntas-tipo em modelo de caso-clínico </b> (formato do exame) e conjunto de <b><em>flashcards</em> para revisão e treino</b> dos conteúdos previamente estudados. A plataforma foi atualizada com um <b>novo layout e interação</b>, incluindo personalização da dificuldade das perguntas e selecão de conteúdos favoritos, e com <b>novas perguntas</b>, incluindo a anterior PNA e prova-piloto. Novos conteúdos serão ainda adicionados ao longo do ano, durante o decorrer dos módulos, totalizando mais de <b>1000 perguntas e 2400 <em>flashcards</em></b>.  </p>
            <p> A inscrição terá o custo de <b>100€</b> e <b>validade até à data da prova nacional de acesso de 2020</b>, garantido o acesso à base de perguntas e <em>flashcards</em>. O método de inscrição é semelhante ao dos restantes módulos, cujo procedimento se encontra descrito na página Informações.</p> 
            <p>Este método foi pensado como um complemento ao estudo e que achamos que poderá ser útil depois de um primeiro contacto com os conteúdos do exame, não pretendendo substituir a sua leitura. </p> 
            <p> Os alunos inscritos num módulo terão acesso aos casos clínicos e flashcards do respetivo módulo.</p>
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