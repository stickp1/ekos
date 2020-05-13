<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User[]|\Cake\Collection\CollectionInterface $users
 */
?>

<h2><?= __('Perguntas') ?></h2>
   
<br>
<div class="row">
<div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Perguntas sobre as Aulas</h3>
              <button type="button" class="btn btn-primary btn-xs pull-right" style="margin-right: 5px;" onClick='window.location.href="<?= $this->Url->build(["action" => "add", 1]);?>"'>
               + Adicionar
              </button>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive no-padding">
              <table class="table table-hover">
                <tbody><tr>
                  <th width='50px'>#</th>
                  <th>Pergunta </th>
                  <th width='100px'></th>
                </tr>
            <?php 
            if(count($questions1) > 0):
            foreach ($questions1 as $question): ?>
                <tr>
                  <td><?= $this->Number->format($question->id) ?></td>
                  <td><?= $question->name ?></td>
                  <td style='text-align:right'> 

                    <?php if ($question['status'] == 1) {echo $this->Form->postLink('<i class="fa fa-eye" style="margin-right:10px"></i>', ['action' => 'toggle', $question['id']], ['escape' => false]); } else {
                        echo $this->Form->postLink('<i class="fa fa-eye-slash" style="margin-right:10px"></i>', ['action' => 'toggle', $question['id']], ['escape' => false]); 
                    } ?>  

                    <?= $this->Html->link('<i class="fa fa-edit" style="margin-right:10px;"></i>', ['action' => 'edit', $question->id], ['escape' => false]) ?>

                    <?= $this->Form->postLink('<i class="fa fa-trash" style="margin-right:10px"></i>', ['action' => 'delete', $question->id], ['escape' => false, 'confirm' => __('Tens a certeza que pretendes eliminar a questão?')]) ?>
                  </td>
                </tr>
            <?php endforeach; 
            else: ?>
                <tr> <td colspan='5' style='text-align:center'><em>Sem perguntas a apresentar.</em></td></tr>
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
              <h3 class="box-title">Perguntas sobre os Professores</h3>
              <button type="button" class="btn btn-primary btn-xs pull-right" style="margin-right: 5px;" onClick='window.location.href="<?= $this->Url->build(["action" => "add", 2]);?>"'>
               + Adicionar
              </button>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive no-padding">
              <table class="table table-hover">
                <tbody><tr>
                  <th width='50px'>#</th>
                  <th>Pergunta </th>
                  <th width='100px'></th>
                </tr>
            <?php 
            if(count($questions2) > 0):
            foreach ($questions2 as $question): ?>
                <tr>
                  <td ><?= $this->Number->format($question->id) ?></td>
                  <td><?= $question->name ?></td>
                  <td style='text-align:right'> 

                    <?php if ($question['status'] == 1) {echo $this->Form->postLink('<i class="fa fa-eye" style="margin-right:10px"></i>', ['action' => 'toggle', $question['id']], ['escape' => false]); } else {
                        echo $this->Form->postLink('<i class="fa fa-eye-slash" style="margin-right:10px"></i>', ['action' => 'toggle', $question['id']], ['escape' => false]); 
                    } ?>  

                    <?= $this->Html->link('<i class="fa fa-edit" style="margin-right:10px;"></i>', ['action' => 'edit', $question->id], ['escape' => false]) ?>

                    <?= $this->Form->postLink('<i class="fa fa-trash" style="margin-right:10px"></i>', ['action' => 'delete', $question->id], ['escape' => false, 'confirm' => __('Tens a certeza que pretendes eliminar a questão?')]) ?>
                  </td>
                </tr>
            <?php endforeach; 
            else: ?>
                <tr> <td colspan='5' style='text-align:center'><em>Sem perguntas a apresentar.</em></td></tr>
            <?php endif;?>
              </tbody></table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>

</div>

<script>
$("li#<?= $this->request->params['controller']; ?> ul li#F1").addClass('active');
</script>

