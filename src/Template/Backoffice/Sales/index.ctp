<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Sale[]|\Cake\Collection\CollectionInterface $sales
 */
?>
    <h2><?= __('Contabilidade') ?> <small><?= $this->Html->link('<i class="fa fa-plus-circle" style="margin-left:10px"></i>', ['action' => 'add'], ['escape' => false]) ?>
 </small></h2>
   
<br>
<div class="row">
<div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Vendas</h3>

              <div class="box-tools">
                  <div class="input-group input-group-sm" style="width: 300px;">
                      <input type="text" name="table_search" class="form-control pull-right" placeholder="Procurar" id='finder'>

                      <div class="input-group-btn">
                        <button type="submit" class="btn btn-default" onClick='submit_button()'><i class="fa fa-search"></i></button>
                      </div>
                      <div class="pull-right">    
                        <?= $this->Form->control('years', ['class' => 'form-control', 'label' => false]); ?>
                      </div>
                  </div>
              </div>

              <div class="box-tools" style='right:310px'>
                  <ul class="pagination pagination-sm no-margin pull-right">
                      <?= $this->Paginator->first('«') ?>
                      <?= $this->Paginator->prev('‹') ?>
                      <?= $this->Paginator->numbers() ?>
                      <?= $this->Paginator->next('›') ?>
                      <?= $this->Paginator->last('»') ?>
                  </ul>
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive no-padding">
              <table class="table table-hover">
                <tbody><tr>
                  <th>#</th>
                  <th>Utilizador <?= $this->Paginator->sort('Users.first_name', '<i class="glyphicon glyphicon-sort" style="float:right;">', ['escape' => false]); ?></th>
                  <th>Data <?= $this->Paginator->sort('datetime', '<i class="glyphicon glyphicon-sort" style="float:right;">', ['escape' => false]); ?></th>
                  <th>Montante <?= $this->Paginator->sort('value', '<i class="glyphicon glyphicon-sort" style="float:right;">', ['escape' => false]); ?></th>
                  <th>Estado <?= $this->Paginator->sort('status', '<i class="glyphicon glyphicon-sort" style="float:right;">', ['escape' => false]); ?></th>
                  <th width='120px'></th>
                </tr>
            <?php 
            if(count($sales) > 0):
            foreach ($sales as $sale): ?>
                <tr>
                  <td><?= $this->Number->format($sale->id) ?></td>
                  <td><?= $sale->user->first_name." ".$sale->user->last_name; ?></td>
                  <td><?= h($sale->datetime->nice('Europe/Lisbon', 'pt-PT')) ?></td>
                  <td><?= $this->Number->currency($sale->value, 'EUR'); ?></td>
                  <td>
                    <?php if($sale->status == 3) {echo '<span class="label label-danger">Aguarda</span> '; }
                          elseif ($sale->status == 2) {echo '<span class="label label-warning">Pendente</span> '; }
                          elseif ($sale->status == 1) {echo '<span class="label label-success">Aprovado</span> '; }
                          ?>
                  </td>
                  <td> 
                    <?php if($sale->receipt){ echo $this->Html->link('<i class="fa fa-file-text" style="margin-right:10px;"></i>', ['prefix' => false, 'controller' => 'img', 'action' => 'receipts', $sale->receipt], ['escape' => false, 'target' => '_blank']); } else { echo '<i class="fa fa-file-text" style="margin-right:10px; color:#ccc"></i>';} ?>            
                     
                      <?php if($sale->moloni_id){ echo $this->Html->link('<i class="fa fa-file-text-o" style="margin-right:10px;"></i>', ['action' => 'get-invoice', $sale->id], ['escape' => false, 'target' => '_blank']); } 
                        
                        elseif($sale->invoice){ echo $this->Html->link('<i class="fa fa-file-text-o" style="margin-right:10px;"></i>', "img/invoices/".$sale->invoice, ['escape' => false, 'target' => '_blank']); } 

                        else { echo $this->Form->postLink('<i class="fa fa-file-text-o" style="margin-right:10px; color:#ccc"></i>', ['action' => 'add-invoice', $sale->id], ['escape' => false, 'confirm' => __('Tens a certeza que pretendes emitir a fatura #{0}?', $sale['id'])]);
                         } ?>     

                     <?= $this->Html->link('<i class="fa fa-edit" style="margin-right:10px;"></i>', ['action' => 'edit', $sale->id], ['escape' => false]) ?>

                     <?= $this->Form->postLink('<i class="fa fa-trash" style="margin-right:10px"></i>', ['action' => 'delete', $sale['id']], ['escape' => false, 'confirm' => __('Tens a certeza que pretendes eliminar #{0}?', $sale['id'])]) ?>
                </tr>
            <?php endforeach; 
            else: ?>
                <tr> <td colspan='6' style='text-align:center'><em>Sem resultados a apresentar.</em></td></tr>
            <?php endif;?>
              </tbody></table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>

</div>
<div class="dataTables_info" style='text-align:right; color:#333; font-size:9pt; position:relative; top:-10px'><?= $this->Paginator->counter(['format' => __('Página {{page}} de {{pages}}, aprenta {{current}} de {{count}} registos.')]) ?></div>  

</div>

<script>

$("#years").val(<?= $year ?>);

$("#years").on('change', function(){
  window.location.href='<?=$this->Url->build(["controller" => "sales", "action" => "index"], true); ?>/index/'+ $(this).val();
})

function submit_button(){  
    document.location = document.location.href.match(/(^[^?#]*)/)[0]+"?name="+$('#finder').val()
    }

document.getElementById('finder').onkeypress = function(e){
    if (!e) e = window.event;
    var keyCode = e.keyCode || e.which;
    if (keyCode == '13'){
      submit_button();
      return false;
    }
  }
</script>

