<?php $url = $this->Url->build(["prefix" => false, "controller" => '/'], true); ?>
<!-- Header -->
    <header style='background-image: url("<?= $url?>/img/banner4.jpg")'>
      <div class="container text-center">
        <span class='prelabel'>EKOS - Formar para a especialidade</span>
        <!--<h1>Testa o teu conhecimento.</h1>-->
        <h1>Testa o teu conhecimento.</h1>
      </div>
    </header>

    
  

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

   
   <section id="recruting" class='bg-light text-center'>
      <div class="container">
        <div class="row">
          <div class="col-md-8 col-md-offset-2">
            <h1>Banco de Perguntas e Flashcards.</h1>
            <p>Não podes assistir aos nossos cursos presenciais, mas gostarias de ter acesso ao nosso Banco de Perguntas e Flashcards? Agora já é possível!</p>

		        <?php if (!isset($Auth['id'])): echo '<button class="btn btn-black" data-toggle="modal" data-target="#login" >INSCREVER</button>'; else: ?> 
              <button class="btn btn-black" onClick='window.location.href = "<?= $this->Url->build(["controller" => 'reserved', 'action' => 'inscription', 1]) ?>"'>INSCREVER</button>
            <?php endif; ?>
		
          </div>
        </div>
      </div>
    </section>
    
     <section id="services" class="text-center">
      <div class="container">
        <div class="row" style='margin-bottom:75px'>
          <div class="col-md-8 col-md-offset-2 tab-content">
            <h1 style='text-align:center'>Informações.</h1>
            <p>Este módulo fornece acesso à nossa base de <b>perguntas-tipo em modelo de caso-clínico </b> (formato do exame) e conjunto de <b><em>flashcards</em> para revisão e treino</b> dos conteúdos previamente estudados. A plataforma foi atualizada com um <b>novo layout e interação</b>, incluindo personalização da dificuldade das perguntas e selecão de conteúdos favoritos, e com <b>novas perguntas</b>, incluindo a anterior PNA e prova-piloto. Novos conteúdos serão ainda adicionados ao longo do ano, durante o decorrer dos módulos, totalizando mais de <b>1000 perguntas e 2400 <em>flashcards</em></b>.  </p>
            <p> A inscrição terá o custo de <b>100€</b> e <b>validade até à data da prova nacional de acesso de 2020</b>, garantido o acesso à base de perguntas e <em>flashcards</em>. O método de inscrição é semelhante ao dos restantes módulos, cujo procedimento se encontra descrito na página Informações.</p> 
            <p>Este método foi pensado como um complemento ao estudo e que achamos que poderá ser útil depois de um primeiro contacto com os conteúdos do exame, não pretendendo substituir a sua leitura. </p> 
            <p> Os alunos inscritos num módulo terão acesso aos casos clínicos e flashcards do respetivo módulo.</p>
          </div>
        </div>
      </div>
    </section>



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