
<?php $url = $this->Url->build(["prefix" => false, "controller" => '/'], true); ?>

<style>
section {
-webkit-transition: all .5s; /* Safari */
    transition: all .5s;
}
</style>

<?php if(isset($_GET['e'])): ?>
<div class='row'>
  <div class="col-xs-12">
    <div class="callout callout-warning">
                    <h4>Código de validação já inserido</h4>

                    <p> O código de validação inserido corresponde ao mesmo da <a href='<?= $this->Url->build(["action" => "edit", $_GET['e']]); ?>' target='_blank' /> venda #<?= $_GET['e'] ?></a>.</p>
                    <p> Se pretenderes prosseguir com a validação, acrescenta 1" ao código registado.</p>
    </div>
  </div>
</div>
<?php endif; ?>

<div class='row'>

<section class="invoice" id='invoice'>
      <!-- title row -->
      <div class="row">
        <div class="col-xs-12">
          <h2 class="page-header">
            Venda #<?= h($sale->id); ?> 
            <small class="pull-right">Data: <?= h($sale->datetime->i18nFormat('dd/MM/yyyy')) ?></small>
          </h2>
        </div>
        <!-- /.col -->
      </div>
      <!-- info row -->
      <div class="row invoice-info">
        <div class="col-sm-4 invoice-col">
          Estado
          <address style='font-size:12pt'>
            <?php if($sale->status == 3) {echo '<span class="label label-danger">Aguarda pagamento</span> '; }
                          elseif ($sale->status == 2) {echo '<a href="#" id="pending"><span class="label label-warning">Validação pendente</span></a> '; }
                          elseif ($sale->status == 1) {echo '<span class="label label-success">Aprovado</span> '; }
                          ?>

          </address>
        </div>
        <!-- /.col -->
        <div class="col-sm-4 invoice-col">
          Formando
          <address>
            <strong><?= $sale->user->first_name." ".$sale->user->last_name ?></strong><br><?= $sale->user->email ?><br>NIF: <?= $sale->user->vat_number ?><br>
          </address>
        </div>
        <!-- /.col -->
        <?php if($sale->status == 1):?>
        <div class="col-sm-4 invoice-col">
          Fatura
          <br> 
          <?php if($sale->invoice != ''):?>
          <a href='<?= $this->Url->build(["prefix" => false, "controller" => "img", "action" => "invoices", $sale->invoice]);?>' target='_blank'>Abrir </a> / <?= $this->Form->postLink('Eliminar', ['action' => 'delete_invoice', $sale->id], ['escape' => false, 'confirm' => __('Tens a certeza que pretendes eliminar a fatura?')]) ?>
          <?php else: ?>
          <form method="post" action="<?= $this->Url->build(["action" => 'upload', $sale->id]);?>" enctype="multipart/form-data" id="uploadForm">
                    <input type="file" id="file" name="file" ><br>
                    <input type='hidden' name='theme_id' id='theme_id' />

                    <button type="submit" name="upload" class='btn btn-default btn-xs' style='position:relative; bottom:10px'> Enviar </button>
            </form>
          <?php endif; ?>
        </div>
        <?php endif;?>
        <!-- /.col -->
      </div>
      <!-- /.row -->

      <!-- Table row -->
      <div class="row">
        <div class="col-xs-12 table-responsive">
        <?= $this->Form->create('', ['id' => 'form1']) ?>
          <table class="table table-striped">
            <thead>
            <tr>
              <th width='15px'></th>
              <th>Produto <button type="button" class="btn btn-primary btn-xs pull-right" style="margin-right: 5px;" data-toggle="modal" data-target="#modal-default">
            + Adicionar
          </button></th>
              <th width='80px'>Valor (€)</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($sale->products as $key => $product) {
                ?>
            <tr>
              <td><?= $this->Form->postLink('<i class="glyphicon glyphicon-remove-circle" style="margin-right:10px"></i>', ['action' => 'delete_product', $product['id']], ['escape' => false, 'confirm' => __('Tens a certeza que pretendes eliminar {0}?', $product->course->name)]) ?></td>
              <td><?= $product->group->name." - ".$product->course->name ?></td>
              <td> <input type="number" class="form-control sum" name="value[<?= $product->id ?>]" value="<?= $product->value ?>" style='text-align:right'/></td>
            </tr>
                <?php
            } ?>
            <tr>
                <td></td>
                <td style='text-align:right'><b>TOTAL</b></td>
                <td id="total" style='border-top:1px solid grey; text-align:center'><?= $sale->value ?></td>
            </tbody>
          </table>
        <?= $this->Form->end() ?>
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->

      <!-- this row will not appear when printing -->
      <div class="row no-print">
        <div class="col-xs-12">
          
          <button type="button" class="btn btn-primary pull-right" style="margin-right: 5px; display:none" onClick="$('#form1').submit()" >
            Guardar alterações
          </button>
        </div>
      </div>
</section>

<?php if ($sale->status == 2) { ?>
<section class="invoice" style='width: 49%; margin-right: 0; margin-left: 0; display: none; height:0' id='receipt'>
      <!-- title row -->
      <div class="row">
        <div class="col-xs-12">
          <?= $this->Form->create('', ['id' => 'form2', 'url' => ['action' => 'validate', $sale->id] ]) ?>
          <div class="input-group">
                <input type="text" class="form-control"  data-inputmask="'alias': 'dd/mm/yyyy hh:mm:ss'" data-mask="" id="datemask" name='date'>
                    <span class="input-group-btn">
                      <button type="button" class="btn btn-info btn-flat" onClick="$('#form2').submit()">Validar</button>
                    </span>
              </div>
        <?= $this->Form->end() ?>
        </div>
        <!-- /.col -->
      </div>
      <!-- info row -->
      <div class="row">
        <iframe src='' style='width:100%; position:absolute; top: 80px; bottom: 0; border: 0' id='iframe'></iframe>
      </div>
      <!-- /.row -->
</section>

<?php }?>

</div>


<div class="modal fade" id="modal-default">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Adicionar Produto</h4>
              </div>
              <div class="modal-body">
                <?= $this->Form->create('', ['url' => ['action' => 'add_product', $sale->id], 'id' => 'add-product']) ?>
                      <select id="groups" style="width:100%;" name="group_id" >
                         <?php foreach ($groups as $key => $value) { ?>
                          <option value='<?= $value['id']?>'><?= $value['course']['name'].": ".$value['name'] ?></option>
                          <?php } ?>
                      </select>
                      
                      <input type='hidden' name='users_id' value='<?= $sale->users_id ?>' />
                    
                    <?= $this->Form->end() ?>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" onClick='$("#add-product").submit()'>Guardar</button>
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>
        

<?php if ($sale->status == 2) { ?>
<script src="<?= $this->Url->build(["prefix" => false, "controller" => '/'], true); ?>bower_components/inputmask/dist/jquery.inputmask.bundle.js"></script>


<script>


$("#pending").on('click', function(){
    $("#invoice").css('display', 'inline-block');
    $("#invoice").css('margin-right', '0');
    $("#invoice").css('margin-left', '0');
    $("#invoice").css('width', '100%');
    $("#invoice").css('width', '50%');
    $("#receipt").css('visibility', 'hidden');
    $("#receipt").css('display', 'inline-block');
    setTimeout(
  function() 
  { $("#receipt").css('height', $("#invoice").outerHeight()).css('visibility', 'visible'); $("#iframe").css('height', $("#invoice").outerHeight()-85) }, 500);
    
    setTimeout(
  function() 
  { document.getElementById("iframe").src = "/img/receipts/<?= $sale->receipt ?>", 1200});
})

$('#datemask').inputmask('99/99/9999 99:99:99', { 'placeholder': 'dd/mm/yyyy hh:mm:ss' })

</script>
<?php } ?>

<link rel="stylesheet" href="<?= $url; ?>/bower_components/select2/dist/css/select2.min.css">
<script src="<?= $url; ?>/bower_components/select2/dist/js/select2.min.js"></script>
<script>
$('#groups').select2();
$('.sum').on('change', function(){
    $(".btn-primary").slideDown();
    var sum = 0;
    $('.sum').each(function(){
        sum += parseFloat($(this).val());  // Or this.innerHTML, this.innerText
    });
    $('#total').text(sum);
})
</script>
