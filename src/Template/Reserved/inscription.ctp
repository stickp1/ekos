
    <section id="services" class="text-center " style='padding-top:150px'>
      <div class="container">

        <div class="row" style='position:relative'>
          <div style='background-color: #f5f5f5; left: -300px; top:-30px; right:-300px; bottom:-100px; position: absolute; z-index: -1'></div>
          <div class="col-md-10 col-md-offset-1"><form method='post'>
            <br>
            <h2>Confirmar Inscrição</h2>
            <p><?= $group['course']['name']?> - <?= $group['name']?> </p>
            <p><b id='pri'><?= $group['course']['price'] ?> €</b></p>
            <br>
            <?php if($group['course']['id'] == 5): ?>
            <p> <input type="checkbox" name='promotion' value="1" > Quero inscrever-me também no módulo de: </br> <b>Aparelho Músculo-Esquelético</b> + <b>Aparelho Endocrinológico e Metabólico</b> <small style='color: rgb(180,0,0)'><b>[PREÇO ESPECIAL]</b></small></p>
           <p> <input type="checkbox" name='promotion' value="2" > Quero inscrever-me no <b>Curso Anual Completo</b> (11 módulos - 107 aulas) <small style='color: rgb(180,0,0)'><b>[PREÇO ESPECIAL]</b></small></p> 
		   <?php endif;?>
            <?php if($group['course']['id'] == 6): ?>
            <p> <input type="checkbox" name='promotion' value="3" > Quero inscrever-me também no módulo de: </br> <b>Doenças Infecciosas</b> + <b>Aparelho Digestivo</b> <small style='color: rgb(180,0,0)'><b>[PREÇO ESPECIAL]</b></small></p>
           <p> <input type="checkbox" name='promotion' value="2" > Quero inscrever-me no <b>Curso Anual Completo</b> (11 módulos - 107 aulas) <small style='color: rgb(180,0,0)'><b>[PREÇO ESPECIAL]</b></small></p> 
		   <?php endif;?>

            <input type='hidden' name='payment_type' value='2' />
            <button class='btn btn-black' type='submit' >INSCREVER</button>

            </form>
          </div>
        </div>
       </div>
    </section>

<style>
#main_container{background-color: #f5f5f5;}

input[type='checkbox'] {
        -webkit-appearance: none;
        width: 20px;
        height: 20px;
        border-radius: 50%;
        position: relative;
        top: 3px;

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
        border-radius: 50%;

    }

 input[type="checkbox"]:checked:before {
        background: #FEB000;
    }

 input[type='checkbox']:checked {
    border: 2px solid #152335;
 }
  </style>

<script>

$('input:checkbox').on('click', function () {

  if($(this).prop('checked')){
    $('input:checkbox').prop('checked', false);
    $(this).prop('checked', true);
    if($(this).val() == 1){
      $('#pri').html('204 €');
    } else if($(this).val() == 2) {
      $('#pri').html('840 €')
    } else if($(this).val() == 3) {
      $('#pri').html('255 €')
    }

  } else {
    $('#pri').html("<?= $group['course']['price'] ?> €");
  }
})
</script>