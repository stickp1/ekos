<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User[]|\Cake\Collection\CollectionInterface $users
 */
?>

<?php $url = $this->Url->build(["prefix" => false, "controller" => '/'], true); ?>

<h2><?= h("Curso de ".$Courses->toArray()[$group->courses_id]) ?> <small> <?= $group->name." - ".$group->city->name ?></small></h2> 


<br>

<div class="row">
<div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Lista de Inscritos</h3> <button type="button" class="btn btn-primary btn-xs pull-right" style="margin-right: 5px;" data-toggle="modal" data-target="#modal-default">
            + Adicionar
          </button>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive no-padding">
              <table class="table table-hover">
                <tbody><tr>
                  <th width='50px'></th>
                  <th>Utilizador</th>
                  <th>Email</th>
                </tr>
            <?php 
            if(count($group->users) > 0):
            foreach ($group->users as $user): ?>
                <tr>
                  <td style='text-align:right'> 
                    <?= $this->Form->postLink('<i class="glyphicon glyphicon-remove-circle" style="margin-right:10px"></i>', ['action' => 'delete_user_group', $group->courses_id, $user['_joinData']['id']], ['escape' => false, 'confirm' => __('Tens a certeza que pretendes eliminar {0}?', $user->first_name)]) ?></td>
                  <td><?= $user->first_name." ".$user->last_name; ?></td>
                  <td><?= $user->email ?></td>
                </tr>
            <?php endforeach; 
            else: ?>
                <tr> <td colspan='5' style='text-align:center'><em>Sem alunos inscritos.</em></td></tr>
            <?php endif;?>
              </tbody></table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
          

        </div>

</div>

<div class="row">
<div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Lista de Aulas</h3> <button type="button" class="btn btn-primary btn-xs pull-right" style="margin-right: 5px;" data-toggle="modal" data-target="#modal-default2">
            + Adicionar
          </button>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive no-padding">
              <table class="table table-hover">
                <tbody><tr>
                  <th>Aula</th>
                  <th>Data/Hora</th>
                  <th>Local</th>
                  <th>Formador</th>
                  <th width='75px'></th>
                </tr>
            <?php 
            if(count($group->lectures) > 0):
            foreach ($group->lectures as $lecture): ?>
                <tr>
                  
                  <td><?= $lecture->description ?> </td>
                  <td><?= $lecture->has('datetime') ? $lecture->datetime->nice('Europe/Lisbon', 'pt-PT') : ''?></td>
                  <td><?= $lecture->place ?></td>
                  <td><?= $lecture->user['first_name']." ".$lecture->user['last_name'] ?></td>
                  <td style='text-align:right'> 

                    <?= $this->Html->link('<i class="fa fa-edit" style="margin-right:10px;"></i>', ['controller' => 'lectures', 'action' => 'edit', $group->courses_id, $lecture['id']], ['escape' => false]) ?> 

                    <?= $this->Form->postLink('<i class="fa fa-trash" style="margin-right:10px"></i>', ['controller' => 'lectures', 'action' => 'delete', $group->courses_id, $lecture['id']], ['escape' => false, 'confirm' => __('Tens a certeza que pretendes eliminar {0}?', $lecture->description)]) ?></td>

                </tr>
            <?php endforeach; 
            else: ?>
                <tr> <td colspan='5' style='text-align:center'><em>Sem aulas programadas.</em></td></tr>
            <?php endif;?>
              </tbody></table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
          

        </div>

</div>

<div class="row">
<div class="col-xs-12">
    <div class="box">
     <?= $this->Form->create($group, ['class' => 'form-horizontal']) ?>
     <div class='box-body'>
        <div class="col-sm-4">
          <div class="form-group">
            <label class="control-label">Vagas</label>
            <?= $this->Form->control('vacancy', ['label' => false, 'class' => 'form-control', 'style' => 'width:50%;']);?>
          </div>
        </div>

        <div class="col-sm-4">
          <div class="form-group">
            <label class="control-label">Inscrições Abertas</label>
            <?= $this->Form->checkbox('inscriptions_open', ['label' => false, 'style' => 'display: block; width: 30px;
  height: 30px;']);?>
          </div>
        </div>

        <div class="col-sm-4">
          <div class="form-group">
            <button class="btn btn-primary btn-xs pull-right" style="margin-right: 5px;" type='submit'>
            Guardar
          </button>
          </div>
        </div>

    </div>
      <?= $this->Form->end() ?>
   </div>
</div>
</div>

<div class="modal fade" id="modal-default">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Adicionar Formando</h4>
              </div>
              <div class="modal-body">
                <?= $this->Form->create('', ['url' => ['action' => 'add_user_group/', $group->courses_id, $group['id']], 'id' => 'add-group']) ?>
                      <select id="mySelect2" style="width:100%;" name="user_id" >
                        <option></option>
                      </select>

                      <div class="form-group"><br>
                        <input type="checkbox" name="sale" value="1" id='sale' checked/>
                        <label class="control-label" for="sale"> Gerar venda</label>
                      </div>
                      <input type="hidden" name="courses_id" value="<?= $group['courses_id'] ?>" />

                      
               
                    
                    <?= $this->Form->end() ?>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" onClick='$("#add-group").submit()'>Guardar</button>
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>

<div class="modal fade" id="modal-default2">
          <div class="modal-dialog">
            <div class="modal-content">
               <?= $this->Form->create('', ['url' => ['controller' => 'lectures', 'action' => 'add', $group->courses_id, $group['id']], 'id' => 'add-lecture']) ?>
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Adicionar Aula</h4>
              </div>
              <div class="modal-body">

                <div class="form-group">
                <label>Nome da Aula</label>

                <div class="input-group">
                  <input type="text" class="form-control pull-right" name='description' required>
                </div>
                <!-- /.input group -->
              </div>

                <div class="form-group">
                <label>Data e Hora:</label>

                <div class="input-group date">
                  <input type="text" class="form-control pull-right" id="datepicker" name='datetime'>
                </div>
                <!-- /.input group -->
              </div>

              <div class="form-group">
                <label>Local</label>

                <div class="input-group">
                  <input type="text" class="form-control pull-right" name='place' required>
                </div>
                <!-- /.input group -->
              </div>

              <div class="form-group">
                <label>Formador</label>

                <div class="input-group">
                  <?= $this->Form->control('teacher', ['options' => $teachers, 'empty' => true, 'label' => false, 'class' => 'form-control', 'required']);?>
                </div>
                
              </div>   
              
              
               <div class="form-group">
                  <label>Temas</label>
                  <div class="input-group">
                    <?= $this->Form->control('themes', ['label' => false, 'class' => 'form-control', 'multiple', 'id' => 'themes', 'name' => 'themes[]', 'style' => 'width: 100%']);?>
                  </div>
                </div>
           
                    
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancelar</button>
                <button type="submit" class="btn btn-primary">Guardar</button>
              </div>
              <?= $this->Form->end() ?>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>




<link rel="stylesheet" href="<?= $url; ?>/bower_components/select2/dist/css/select2.min.css">
<link rel="stylesheet" href="<?= $url; ?>/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
<script src="<?= $url; ?>/bower_components/select2/dist/js/select2.min.js"></script>
<script src="<?= $url; ?>/bower_components/moment/src/moment.js"></script>
<script src="<?= $url; ?>/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.js"></script>

<style>

#modal-default2 input, #modal-default2 .input-group{
  width: 100%;

}

</style>

<script>
$('#mySelect2').select2({
  ajax: {
    url: '<?= $this->Url->build(["controller" => "Users", "action" => "user-list"]); ?>',
    dataType: 'json',
    data: function (params) {
      var query = {
        search: params.term
      }


      // Query parameters will be ?search=[term]&type=public
      return query;
    }
  },
  placeholder: "Pesquisa por nome ou email",
  minimumInputLength: 3
});

$('#datepicker').datetimepicker({
                    format: 'DD/MM/YYYY HH:mm',
                });
                
$('#themes').select2();
</script>

<style>
.select2-container--default .select2-selection--multiple .select2-selection__choice {
    background-color: #3c8dbc;
    border-color: #367fa9;
}

.select2-container--default .select2-selection--multiple .select2-selection__choice span {
  color: white;
}
</style>
