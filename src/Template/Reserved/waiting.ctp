
    <section id="services" class="text-center " style='padding-top:150px'>
      <div class="container">

        <div class="row" style='position:relative'>
          <div class="reserved-background"></div>
          <div class="col-md-10 col-md-offset-1 text-left">
            <br>
            <h2 style='text-align:center'>Lista de Espera</h2>
            <p style='text-align:center'>Infelizmente, as inscrições para o <b>Curso <?php if($course['name'] != 'Anual') echo 'de' ?> <?= $course['name']?></b> encontram-se esgotadas.</p>
            <br>
            <p class='small'>Na EKOS acreditamos num ensino personalizado através de turmas pequenas que possam promover a discussão e interação, pelo que não nos é possível aceitar mais alunos na turma em questão.</p>
            <p class='small'>Contudo, poderá surgir a <b>hipótese de fazer o curso connosco</b>! Caso estejas interessado, poderás inscrever o teu nome na lista de espera, sem qualquer compromisso, para que possamos entrar em contacto contigo no caso de desistências ou trocas de turma. Esperamos poder contar contigo nas nossas aulas em breve!</p>
            <form method='post'>
              <p style='text-align:center'>
            <button class='btn btn-black' type='submit'  >INSCREVER NA LISTA DE ESPERA</button></p>
           <br> <p class='small'><b>ATENÇÃO:</b> A lista de espera serve apenas para contabilização do número de interessados e para contacto caso existam novas vagas. A inscrição em lista de espera não constitui uma reserva de lugar.</p>
            </form>
          </div>
        </div>
       </div>
    </section>

<style>
#main_container{background-color: #f5f5f5;}

</style>