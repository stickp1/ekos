<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User[]|\Cake\Collection\CollectionInterface $users
 */
?>

<h2><?= __('Utilizadores') ?></h2>
   
<br>
<div class="row">
<div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title"></h3>

              <div class="box-tools">

                <div class="input-group input-group-sm" style="width: 150px;">
                  <input type="text" name="table_search" class="form-control pull-right" placeholder="Procurar" id='finder'>

                  <div class="input-group-btn">
                    <button type="submit" class="btn btn-default" onClick='submit_button()'><i class="fa fa-search"></i></button>
                  </div>
                </div>
              </div>
              <div class="box-tools" style='right:170px'>
                <ul class="pagination pagination-sm no-margin pull-right">
                    <?= $this->Paginator->prev('«') ?>
                    <?= $this->Paginator->numbers() ?>
                    <?= $this->Paginator->next('»') ?>
                </ul>
            </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive no-padding">
              <table class="table table-hover">
                <tbody><tr>
                  <th>#</th>
                  <th>Utilizador <?= $this->Paginator->sort('first_name', '<i class="glyphicon glyphicon-sort" style="float:right;">', ['escape' => false]); ?></th>
                  <th>Email</th>
                  <th>Tipo <?= $this->Paginator->sort('role', '<i class="glyphicon glyphicon-sort" style="float:right;">', ['escape' => false]); ?></th>
                  <th width='100px'></th>
                </tr>
            <?php 
            if(count($users) > 0):
            foreach ($users as $user): ?>
                <tr>
                  <td><?= $this->Number->format($user->id) ?></td>
                  <td><?= $user->first_name." ".$user->last_name; ?></td>
                  <td><?= $user->email ?></td>
                  <td>
                   <?php 
                   if($user->role == 0) {
                        echo 'Formando';
                    } elseif($user->role == 1) {
                        echo 'Formador';
                    } elseif($user->role == 2) {
                        echo 'Coordenador';
                    } elseif($user->role == 3) {
                        echo 'Administrador';
                    }
                  ?>
                  </td>
                  <td style='text-align:right'> 

                     <?= $this->Html->link('<i class="fa fa-edit" style="margin-right:10px;"></i>', ['action' => 'edit', $user->id], ['escape' => false]) ?>
                </tr>
            <?php endforeach; 
            else: ?>
                <tr> <td colspan='5' style='text-align:center'><em>Sem resultados a apresentar.</em></td></tr>
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

function submit_button(){
    document.location = document.location.href.match(/(^[^?#]*)/)[0]+"?s="+$('#finder').val()
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
