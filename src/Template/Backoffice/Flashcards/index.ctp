<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User[]|\Cake\Collection\CollectionInterface $users
 */
?>

<h2><?= __('Flashcards') ?></h2>
<div class="box-tools">
    <div class="input-group input-group-sm" style="width: auto">
        <?php if(!isset($this->request->getParam('pass')['0'])): 
          $courses = array_replace((array) '(Selecionar Módulo)', $courses);  
        endif; ?>
        <?= $this->Form->control('courses', ['class' => 'form-control pull-right', 'id' => 'finder', 'label' => false, 'options' => $courses ]); ?>          
    </div>
</div>
   
<br>
<div class="row">

    <div class="col-xs-12">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">Flashcards de utilizadores</h3>
                <div class="box-tools">
                    <div class="input-group input-group-sm" style="width: auto">
                        <?= $this->Form->control('categories', ['user_cats' => 'form-control pull-right', 'id' => 'change_cat', 'label' => false, 'options' => $user_cats ]); ?>          
                    </div>
                </div>
                <div class="box-tools" style="right:200px">
                    <ul class="pagination pagination-sm no-margin pull-right" style="right:200px">
                        <?= $this->Paginator->first('«') ?>
                        <?= $this->Paginator->prev('‹') ?>
                        <?= $this->Paginator->numbers() ?>
                        <?= $this->Paginator->next('›') ?>
                        <?= $this->Paginator->last('»') ?>
                    </ul>
                </div>
            </div>
            <div class="box-body table-responsive no-padding">
                <table class="table table-hover">
                    <tbody>
                        <tr>
                            <th>#</th>
                            <th>Utilizador</th>
                            <th>Curso</th>
                            <th>Tema</th>
                            <th>Frente</th>
                            <th width="100px"></th>
                        </tr>
                        <?php if(count($pendingFlashcards) > 0): ?>
                            <?php foreach ($pendingFlashcards as $value): ?>
                                <tr>
                                    <td><?= $this->Number->format($value->id) ?></td>
                                    <td><?= $value['user_ids']?></td>
                                    <td><?= $value->course['name']?></td>
                                    <td><?= $themes[$value['theme_id']]?></td>
                                    <td><?= substr($value->front, 0, 190)."..." ?></td>
                                    <td style='text-align:right'> 
                                        <?= $this->Html->link('<i class="fa fa-edit" style="margin-right:10px;"></i>', ['action' => 'edit', $value->id], ['escape' => false]) ?>
                                        <?= $this->Form->postLink('<i class="fa fa-trash" style="margin-right:10px"></i>', ['action' => 'delete', $value->id], ['escape' => false, 'confirm' => __('Tens a certeza que pretendes eliminar o flashcard?')]) ?>
                                    </td>
                                </tr> 
                            <?php endforeach ?>
                        <?php else: ?>  
                            <tr> 
                                <td colspan='5' style='text-align:center'><em>Sem Flashcards a apresentar.</em>
                                </td>
                            </tr>
                        <?php endif ?>   
                    </tbody>
                </table>    
            </div>
        </div>
    </div>

    <div class="col-xs-12">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">Todos os Flashcards</h3>
                <?php $this->Paginator->options(['model' => 'Flashcards']) ?>
                <button type="button" class="btn btn-primary btn-xs pull-left" style="margin-right: 5px;" onClick='window.location.href="<?= $this->Url->build(["action" => "add"]);?>"'>
                   + Adicionar
                </button>
                <div class="box-tools">
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
                    <tbody>
                        <tr>
                            <th>#</th>
                            <th>Curso </th>
                            <th>Tema(s)</th>
                            <th>Frente</th>
                            <th width='100px'></th>
                        </tr>
                        <?php if(count($flashcards) > 0): ?>
                            <?php foreach ($flashcards as $question): ?>
                                <tr>
                                    <td><?= $this->Number->format($question->id) ?></td>
                                    <td><?= $question->course['name']?></td>
                                    <td><?= $themes[$question['theme_id']]?></td>
                                    <td><?= substr($question->front, 0, 190)."..." ?></td>
                                    <td style='text-align:right'> 
                                        <?php if ($question['active'] == 1): ?>
                                            <?php echo $this->Form->postLink('<i class="fa fa-eye" style="margin-right:10px"></i>', ['controller' => 'Flashcards', 'action' => 'toggle', $question['id']], ['escape' => false]); ?>
                                        <?php else: ?>
                                            <?php echo $this->Form->postLink('<i class="fa fa-eye-slash" style="margin-right:10px"></i>', ['controller' => 'Flashcards', 'action' => 'toggle', $question['id']], ['escape' => false]); ?>
                                        <?php endif ?>  
                                        <?= $this->Html->link('<i class="fa fa-edit" style="margin-right:10px;"></i>', ['action' => 'edit', $question->id], ['escape' => false]) ?>
                                        <?= $this->Form->postLink('<i class="fa fa-trash" style="margin-right:10px"></i>', ['action' => 'delete', $question->id], ['escape' => false, 'confirm' => __('Tens a certeza que pretendes eliminar o flashcard?')]) ?>
                                    </td>
                                </tr>
                            <?php endforeach ?> 
                        <?php else: ?>
                            <tr> 
                                <td colspan='5' style='text-align:center'><em>Sem Flashcards a apresentar.</em>
                                </td>
                            </tr>
                        <?php endif ?>
                    </tbody>
                </table>
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
    </div>
</div>

<div class="dataTables_info" style='text-align:right; color:#333; font-size:9pt; position:relative; top:-10px'>
  <?= $this->Paginator->counter(['format' => __('Página {{page}} de {{pages}}, aprenta {{current}} de {{count}} registos.'), 'model' => 'Flashcards']) ?>
</div>  


<script>
<?php if(isset($this->request->getParam('pass')['0'])):?>
$("#finder").val(<?= $this->request->getParam('pass')['0']?>);
<?php endif; ?>

$("#change_cat").val(<?= $category ?>);

$("#finder").on('change', function(){
  var url = '<?= $this->Url->build(["controller" => "Flashcards", "action" => "index"]);?>/index/'+$('#finder').val();
  document.location = url;
})

$("#change_cat").on('change', function(){
  var url = '<?= $this->Url->build(["controller" => "Flashcards", "action" => "index"]);?>/index/0/'+$('#change_cat').val();
  document.location = url;
})

</script>
