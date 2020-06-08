<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Course $course
 */
?>
<style>
    .example-modal .modal {
      position: relative;
      top: auto;
      bottom: auto;
      right: auto;
      left: auto;
      display: block;
      z-index: 1;
    }

    .example-modal .modal {
      background: transparent !important;
    }
  </style>

    <h2><?= h("Curso de ".$course->name) ?><small><?= $this->Html->link('<i class="fa fa-edit" style="margin-left:10px"></i>', ['action' => 'edit', $course->id], ['escape' => false]) ?>
 </small></h2>
 
 <?php foreach($cities as $k => $city):
 if($Auth['role'] == 3 || $k == $Auth['city_id']): ?>
    <div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-header">
              <h3 class="box-title">Lista de Turmas - <?= $city ?></h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body no-padding">
              <table class="table table-condensed table-hover">
                <thead>
                  <th style="width: 10px">#</th>
                  <th>Nome</th>
                  <th style="width: 100px"></th>
                </thead>
                <tbody>
                <?php foreach ($course['groups'] as $key => $value) { if($value['city_id'] == $k): ?>
                <tr>
                  <td><?= $value['id']?>.</td>
                  <td><?= $value['name']?></td>
                  <td style='font-size:12pt; text-align:right'>
                    <?php if ($value['active'] == 1) {echo $this->Form->postLink('<i class="fa fa-eye" style="margin-right:10px"></i>', ['controller' => 'Courses', 'action' => 'toggle_group', $course->id, $value['id']], ['escape' => false]); } else {
                        echo $this->Form->postLink('<i class="fa fa-eye-slash" style="margin-right:10px"></i>', ['controller' => 'Courses', 'action' => 'toggle_group', $course->id, $value['id']], ['escape' => false]); 
                    } ?>  

                    <?= $this->Html->link('<i class="fa fa-edit" style="margin-right:10px;"></i>', ['action' => 'edit-group', $course->id, $value['id']], ['escape' => false]) ?>

                    <?= $this->Form->postLink('<i class="fa fa-trash" style="margin-right:10px"></i>', ['action' => 'delete_group', $course->id,  $value['id']], ['escape' => false, 'confirm' => __('Tens a certeza que pretendes eliminar {0}?', $value['name'])]) ?>

                </td>
                </tr>
                <?php endif; }?>
                <tr>
                    <td colspan='3' style='text-align:center'><a href='#' onClick='$("#city_id").val(<?= $k?>)' data-toggle="modal" data-target="#modal-default">+ Nova Turma </a></td>
                </tr>
                </tbody>
              </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
    </div>
<?php endif; endforeach; ?>

    <div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-header">
              <h3 class="box-title">Lista de Espera</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body no-padding">
              <table class="table table-condensed table-hover">
                <thead>
                  <th style="width: 10px">#</th>
                  <th>Nome</th>
                  <!--<th>Turma pretendida</th>-->
                  <th>Data</th>
                  <th style="width: 100px"></th>
                </thead>
                <tbody>
                <?php 
                if(count($course['waiting_list']) > 0): 
                foreach ($course['waiting_list'] as $key => $value) { ?>
                <tr>
                  <td><?= $value['id']?>.</td>
                  <td><?= $value['user']['first_name'].' '.$value['user']['last_name']?></td>
                  <!--<td><?= $value['group']['name']?></td>-->
                  <td><?= $value->has('timestamp') ? $value->timestamp->nice('Europe/Lisbon', 'pt-PT') : ''?>
                  <td style='font-size:12pt; text-align:right'>

                    <?= $this->Form->postLink('<i class="fa fa-trash" style="margin-right:10px"></i>', ['action' => 'delete_waiting', $course->id,  $value['id']], ['escape' => false, 'confirm' => __('Tens a certeza que pretendes eliminar {0} da lista de espera?', $value['user']['first_name'])]) ?>

                </td>
                </tr>
                <?php } else:?>
                <tr><td colspan='5' style='text-align:center;'><em>Sem alunos em lista de espera neste módulo.</em></td></tr>
                <?php endif; ?>
                </tbody>
              </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
    </div>

    <div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-header">
              <h3 class="box-title">Lista de Temas</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body no-padding">
              <table class="table table-condensed table-hover">
                <thead>
                  <th style="width: 10px">#</th>
                  <th>Nome</th>
                  <th style="width: 100px"></th>
                </thead>
                <tbody>
                <?php foreach ($course['themes'] as $key => $value) { ?>
                <tr>
                  <td><?= $value['id']?>.</td>
                  <td><?= $value['name']?></td>
                  <td style='font-size:12pt; text-align:right'>
                    <?php if ($value['active'] == 1) {echo $this->Form->postLink('<i class="fa fa-eye" style="margin-right:10px"></i>', ['controller' => 'Courses', 'action' => 'toggle_theme', $course->id, $value['id']], ['escape' => false]); } else {
                        echo $this->Form->postLink('<i class="fa fa-eye-slash" style="margin-right:10px"></i>', ['controller' => 'Courses', 'action' => 'toggle_theme', $course->id, $value['id']], ['escape' => false]); 
                    } ?>  
                    
                    <?= $this->Html->link('<i class="fa fa-edit" style="margin-right:10px;"></i>', ['controller' => 'themes', 'action' => 'edit', $course->id, $value['id']], ['escape' => false]) ?>

                    <?= $this->Form->postLink('<i class="fa fa-trash" style="margin-right:10px"></i>', ['action' => 'delete_theme', $course->id, $value['id']], ['escape' => false, 'confirm' => __('Tens a certeza que pretendes eliminar {0}?', $value['name'])]) ?>

                </td>
                </tr>
                <?php }?>
                <tr>
                    <td colspan='3' style='text-align:center'><a href='#' data-toggle="modal" data-target="#modal-default2">+ Novo Tema </a></td>
                </tr>
                </tbody>
              </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
    </div>
    </div>




    <div class="modal fade" id="modal-default">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Adicionar Nova Turma</h4>
              </div>
              <div class="modal-body">
                <?= $this->Form->create('', ['url' => ['action' => 'add_group/'.$course['id']],'id' => 'add-group']) ?>
                    <fieldset>
                        <p>Nome da turma: </p>
                        <?php
                            echo $this->Form->control('name', ['label' => false, 'style' => 'width:100%; border: 0; border-bottom: 1px solid #ccc; padding:3pt']);
                            echo $this->Form->input('courses_id', ['type' => 'hidden', 'value' => $course['id']]);
                            echo $this->Form->input('city_id', ['type' => 'hidden', 'id' => 'city_id']);
                        ?>
                    </fieldset>
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
        <!-- /.modal -->

    <div class="modal fade" id="modal-default2">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Adicionar Novo Tema</h4>
              </div>
              <div class="modal-body">
                <?= $this->Form->create('', ['url' => ['action' => 'add_theme/'.$course['id']],'id' => 'add-theme']) ?>
                    <fieldset>
                        <p>Nome do Tema: </p>
                        <?php
                            echo $this->Form->control('name', ['label' => false, 'style' => 'width:100%; border: 0; border-bottom: 1px solid #ccc; padding:3pt']);
                            echo $this->Form->input('courses_id', ['type' => 'hidden', 'value' => $course['id']]);
                        ?>
                    </fieldset>
                    <?= $this->Form->end() ?>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" onClick='$("#add-theme").submit()'>Guardar</button>
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->
