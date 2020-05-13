
    <section id="services" class="text-center ">
      <div class="container">
        <div class="row">
          <div class="col-md-20">
            <div class="panel with-nav-tabs panel-default" style='background:transparent'>
                <div class="panel-heading">
                        <ul class="nav nav-tabs" id='submenu'>
                            <li <?=  @$this->request->params['action'] == 'index' ? 'class="active"': ''?>><a href="<?= $this->Url->build(["prefix" => false, "controller" => 'reserved', "action" => "index"]) ?>">Cursos</a></li>
                            <li <?=  @$this->request->params['action'] == 'qbank' ? 'class="active"': ''?>><a href="<?= $this->Url->build(["prefix" => false, "controller" => 'reserved', "action" => "qbank"]) ?>">Perguntas</a></li>
                            <li <?=  @$this->request->params['action'] == 'fbank' ? 'class="active"': ''?>><a href="<?= $this->Url->build(["prefix" => false, "controller" => 'reserved', "action" => "fbank"]) ?>">Flashcards</a></li>
                            <?php if(in_array(16, $courses) || in_array(15, $courses)): ?> <li <?=  @$this->request->params['action'] == 'ebank' ? 'class="active"': ''?>><a href="<?= $this->Url->build(["prefix" => false, "controller" => 'reserved', "action" => "ebank"]) ?>">Exames</a></li> <?php endif; ?>
                            <li <?=  @$this->request->params['action'] == 'payments' ? 'class="active"': ''?>><a href="<?= $this->Url->build(["prefix" => false, "controller" => 'reserved', "action" => "payments"]) ?>">Pagamentos</a></li>
                        </ul>
                </div>
              </div>
          </div>
        </div>

        <div class="row" style='position:relative;'>
          <div style='background-color: #f5f5f5; left: -300px; top:-30px; right:-300px; bottom:-100px; position: absolute; z-index: -2'></div>
          <div class="col-md-10 col-md-offset-1" style='padding-top: 75px'>
            <h1>Olá <?= $Auth['first_name']; ?>!</h1>
          </div>



        <div class='row' >
          <div class='col-md-10 col-md-offset-1'>
            <table class='courses-list' style='margin-top: 20px; margin-bottom:20px'>
              <?php if($exams):
          foreach ($exams as $key => $value) { ?>
            <tr style='border-top: 2px solid #333' class='primary' onClick='window.location.href="<?= $this->Url->build(["controller" => 'reserved', 'action' => 'exam', $value['id']]) ?>"'>

              <td><?= $value['name'] ?></span></td>
              <td width='100px'> <span class='small' style='color: #FEB000;' ><?php 
                if (@$value['user_exams'][0]['finished'] == 1) echo "CONCLUÍDO"
                
              ?></span></td>
              <td width='50px'><i class="fa fa-arrow-right"></i></td>
            </tr>            
             <?php } else: ?>
            <p>Não existe nenhum exame disponível.</p>
           <?php endif; ?>
            </table>
            
          </div>
        </div>





            <button class='btn btn-black' onClick="window.location.href='<?= $this->Url->build(["prefix" => false, "controller" => "Users", "action" => "logout"]) ?>'" >LOGOUT</button>
          </div>
        </div>
       </div>
    </section>


<div class="modal fade" id="finished">
      <div class="vertical-alignment-helper">
        <div class="modal-dialog vertical-align-center">
            <div class="modal-content">
                <div class="modal-body">

                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                  <br>
                
        <h3>Exame concluído!</h3>
              <p> As tuas respostas foram registadas com sucesso. Podes agora rever o teu exame ou realizar uma nova prova.</p>  
              <br> 
              </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div></div>
    </div>
    
  
  <style>
.courses-list a span{
  opacity: 0.85
}

.courses-list a:hover span{
  opacity: 1
}
  </style>



<?php if(isset($_GET['c'])): ?>
  <script>
$("#finished").modal();
</script>
<?php endif; ?>
  