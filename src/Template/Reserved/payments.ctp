

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
              <?php if($sales):
          foreach ($sales as $key => $value) { ?>
            <tr style='    border-top: 2px solid #333'>
              <td style='width: 30px; padding:10px'width='30px'>#<?= $value['id'] ?></td>
              <td><?php 
              $prod = array();
              foreach ($value['products'] as $key2 => $product) {$prod[$key2] = $product['group']['course']['name'];} 
              echo implode(' <b>|</b> ', $prod)." <b>[".$value['products'][0]['group']['name']."]</b>"; ?></td>
              <td style='width: 75px; padding:10px'><?= $value['value']." €"; ?>
              <td> 
                <?php if($value['status'] == 3): ?>
                  <a href="#" data-toggle="modal" data-target="#modal_<?= $value['id']?>"><span class="label label-danger" style='padding: 5px 10px;color: white;'>Efetuar pagamento</span></a>
                <?php elseif ($value['status'] == 2): ?>
                   <a href="#" data-toggle="modal" data-target="#modal_<?= $value['id']?>"><span class="label label-warning" style='padding: 5px 10px;color: white;'>Aguarda validação</span></a>
                <?php elseif (!$value['invoice'] && !$value['moloni_id']):?>
                 <span class="label label-success" style='padding: 5px 10px;color: white;'>Inscrito</span>
                <?php elseif ($value['moloni_id']):?>
                 <a href="<?= $this->Url->build(["prefix" => false, "controller" => 'reserved', 'action' => 'invoices', $value['id']], true); ?>" target='_blank'><span class="label label-success" style='padding: 5px 10px;color: white;'><i class="fa fa-download"></i> Fatura</span></a>
                <?php else: ?>
                   <a href="<?= $this->Url->build(["prefix" => false, "controller" => 'img', 'action' => 'invoices', $value['invoice']], true); ?>" target='_blank'><span class="label label-success" style='padding: 5px 10px;color: white;'><i class="fa fa-download"></i> Fatura</span></a>
                <?php endif;?>
              </td>
            </tr>            
             <?php } else: ?>
            <p>Ainda não efetuaste nenhuma inscrição.</p>
           <?php endif; ?>
            </table>
            
          </div>
        </div>





            <button class='btn btn-black' onClick="window.location.href='<?= $this->Url->build(["prefix" => false, "controller" => "Users", "action" => "logout"]) ?>'" >LOGOUT</button>
          </div>
        </div>
       </div>
    </section>


  <?php if($sales):
      foreach ($sales as $key => $value) { ?>

      <div class="modal fade" id="modal_<?= $value['id']?>">
      <div class="vertical-alignment-helper">
        <div class="modal-dialog vertical-align-center">
            <div class="modal-content">
                <div class="modal-body">

                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                  <br>
                <h1>Pagamento</h1>
                <?php if($value['payment_type'] == 0): ?>

                <?= $this->Form->create('Form', [ 'url' => ['controller' => 'reserved', 'action' => 'upload'], 'enctype' => "multipart/form-data"]) ?>
                
                <fieldset>
                
                <p style='text-align:center'>
               <?php if($value['status'] == 3):?> <p>Para concluíres a tua inscrição, deves efetuar uma transferência bancária no valor de <b><?= $value['value']?> €</b> para o IBAN: </p><p style='text-align:center'><br><b>PT50.0033.0000.45541395629.05</b></p><br><p>Após o pagamento, deves fazer upload no comprovativo de pagamento nesta página.</p> <?php else: ?> <p>O teu comprovativo de pagamento foi enviado e aguarda validação por parte da EKOS. Caso pretendas substituir o ficheiro enviado, podes fazê-lo através desta página.</p>
             <?php endif;?>
                <div class="form-group">
                    <div class="label"><br><br></div>
                     <input type="file" id="file" name="file" required><br>
                     <input type='hidden' name='id' value='<?= $value['id']?>' />
                     <p style='text-align:center'><button class="btn btn-black btn-xs" type='submit'>ENVIAR</button></p>
                </div>
                
                </fieldset>

                <?= $this->Form->end() ?> 

                <?php elseif ($value['payment_type'] == 2) : ?>
                  
                   <p style='text-align:left'>Para concluíres a tua inscrição, deves efetuar efetuar o pagamento através da rede multibanco com os seguintes dados: </p><p><br>
                    <b>Entidade</b>: <?= $value['mb_reference']['entidade'] ?><br>
                    <b>Referência</b>: <?= $value['mb_reference']['referencia'] ?><br>
                    <b>Valor</b>: <?= $value['mb_reference']['valor'] ?> €</p>

                <?php endif; ?>  
              </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div></div>
    </div>

  <?php } endif; ?>

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
$("#modal_<?=$_GET['c']?>").modal();
</script>
<?php endif; ?>
  