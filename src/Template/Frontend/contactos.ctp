<?php $url = $this->Url->build(["prefix" => false, "controller" => '/'], true); ?>
<script src='https://www.google.com/recaptcha/api.js'></script>

<!-- Header -->
<header style='background-image: url("<?= $url?>/img/mapa.png"); box-shadow: none'>
    <div class="container text-center">
    </div>
</header>


<section>
    <div class="container text-center">
        <div class="row">
            <div class="col-sm-4 text-sm-left">
                <p>Instalações da EKOS</p>
                <p class='small' style='margin-bottom: 50px'>Direção e Atendimento Geral <br> Rua Jorge Colaço 16, <br> 1700-253 Lisboa <br> <br> Horário de Atendimento<br> 2ª a 6ª feira | 17h-21h<br><span style="font-size: 12px;">AVISO: Face às restrições <!--e medidas de segurança -->impostas pela epidemia COVID-19, o atendimento estará temporariamente sujeito a marcação prévia.</span></p>
                
                <p>Locais da Formação</p>
                <p class='small' style='margin-bottom: 50px'>Faculdade de Medicina de Lisboa <br> Avenida Professor Egas Moniz, <br> 1649-028 Lisboa <br> <span style="font-size: 12px;">Indicações específicas disponíveis na área reservada</span></br></br>Faculdade de Fármacia de Coimbra <br> Azinhaga de Santa Comba, <br> 3000-548 Coimbra <br> <span style="font-size: 12px;">Indicações específicas disponíveis na área reservada</span></p>
                <!--
                <p>NMS|FCM</p>
                <p class='small' style='margin-bottom: 50px'>NOVA Medical School <br> Campo Mártires da Pátria 130, <br> 1169-056 Lisboa</p>
                -->
                <p>EMAIL</p>
                <p class='small' style='margin-bottom: 50px'>geral@ekos.pt</p>
            </div>
            <div class="col-sm-8">
            	  <?= $this->Form->create('Contact', ['id' => 'form']) ?>
              	<div class='row'>
              		  <div class='col-md-6'>
              			    <div class="form-group">
                            <div class="label" style='float:left'>Nome</div>
                            <input type="text" class="form-control" placeholder="Inserir nome" name='nome' <?= isset($contact) ? "value='$contact[nome]'" : "" ?> required/>
                        </div>
              		  </div>
              		  <div class='col-md-6'>
              			    <div class="form-group">
                            <div class="label" style='float:left'>Contacto</div>
                            <input type="text" class="form-control" placeholder="Inserir email ou telefone" name='contacto' <?= isset($contact) ? "value='$contact[contacto]'" : "" ?> required/>
                        </div>
              		  </div>
            	  </div>
            	  <div class='row'>
            		    <div class='col-md-12'>
            			      <div class="form-group">
                            <div class="label" style='float:left'>Mensagem</div>
                            <textarea class="form-control" placeholder="Inserir Mensagem" name='message' style='min-height: 240px' required id='message'><?= isset($contact) ? $contact['message'] : "" ?></textarea>
                            <div class="g-recaptcha" data-sitekey="6LdAL20UAAAAAJOZy5YPgXQR_u26zrk1Y8hEfuM2" style='float: right; margin-top:15px; display: none'>
                            </div>
                            <button type="submit" class="btn btn-black" style='float:left'>SUBMETER</button>  
                        </div>
            		    </div>
            	  </div>
                <?= $this->Form->end() ?>
            </div>
        </div>
    </div>
</section>

<!--

<div class="modal fade" id="suc">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <br>
                <div style='padding: 100px 0'>
                    <h1>A mensagem foi enviada com sucesso.</h1>
                    <p>Receberás uma resposta assim que possível.</p>
            	  </div>
                <div align="center" style='margin-bottom:30px'>
                    <button type="button" class="btn btn-black" data-dismiss="modal">COMPREENDI</button>
                </div>
            </div>
        </div>
    </div>
</div>

-->

<script>
$('#form').on('valid.bs.validator', function(event){
	if(event.relatedTarget.id == 'message') {
	$('.g-recaptcha').slideDown();
	}		
})

$("section form").submit(function(event) {

   var recaptcha = $("section #g-recaptcha-response").val();
   if (recaptcha === "") {
      event.preventDefault();
      alert("Por favor, confirma que não és um robô.");
   }
});
</script>