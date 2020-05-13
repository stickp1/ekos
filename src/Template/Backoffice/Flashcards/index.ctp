<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User[]|\Cake\Collection\CollectionInterface $users
 */
?>

<h2><?= __('Flashcards') ?></h2>
   
<br>
<div class="row">
<div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title"></h3>
              <button type="button" class="btn btn-primary btn-xs pull-left" style="margin-right: 5px;" onClick='window.location.href="<?= $this->Url->build(["action" => "add"]);?>"'>
               + Adicionar
              </button>
              <div class="box-tools">

                <div class="input-group input-group-sm" style="width: 150px;">
                  <?php if(!isset($this->request->getParam('pass')['0'])): $courses = array_replace((array) '(Selecionar Módulo)', $courses);  endif; ?>

                  <?= $this->Form->control('courses', ['class' => 'form-control pull-right', 'id' => 'finder', 'label' => false, 'options' => $courses ]);?>
                  
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
                  <th>Curso </th>
                  <th>Tema(s)</th>
                  <th>Frente</th>
                  <th width='100px'></th>
                </tr>
            <?php 
            if(count($flashcards) > 0):
            foreach ($flashcards as $question): ?>
                <tr>
                  <td><?= $this->Number->format($question->id) ?></td>
                  <td><?= $question->course['name']?></td>
                  <td><?= $themes[$question['theme_id']]?></td>
                  <td><?= substr($question->front, 0, 190)."..." ?></td>
                  <td style='text-align:right'> 

                    <?php if ($question['active'] == 1) {echo $this->Form->postLink('<i class="fa fa-eye" style="margin-right:10px"></i>', ['controller' => 'Flashcards', 'action' => 'toggle', $question['id']], ['escape' => false]); } else {
                        echo $this->Form->postLink('<i class="fa fa-eye-slash" style="margin-right:10px"></i>', ['controller' => 'Flashcards', 'action' => 'toggle', $question['id']], ['escape' => false]); 
                    } ?>  

                    <?= $this->Html->link('<i class="fa fa-edit" style="margin-right:10px;"></i>', ['action' => 'edit', $question->id], ['escape' => false]) ?>

                    <?= $this->Form->postLink('<i class="fa fa-trash" style="margin-right:10px"></i>', ['action' => 'delete', $question->id], ['escape' => false, 'confirm' => __('Tens a certeza que pretendes eliminar o flashcard?')]) ?>
                  </td>
                </tr>
            <?php endforeach; 
            else: ?>
                <tr> <td colspan='5' style='text-align:center'><em>Sem Flashcards a apresentar.</em></td></tr>
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
<?php if(isset($this->request->getParam('pass')['0'])):?>
$("#finder").val(<?= $this->request->getParam('pass')['0']?>);
<?php endif; ?>


$("#finder").on('change', function(){
  var url = '<?= $this->Url->build(["controller" => "Flashcards", "action" => "index"]);?>/index/'+$('#finder').val();
  document.location = url;
})

</script>
