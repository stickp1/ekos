<div class="box">
            <!-- /.box-header -->
            <div class="box-body no-padding">
              <table class="table table-condensed">
                <tbody><tr>
                  <th style="width: 10px">#</th>
                  <th>Nome</th>
                  <th>Tipo</th>
                  <th>Cidade</th>
                  <th>Autor</th>
                  <th>Timestamp</th>
                  <th style="width: 120px"></th>
                </tr>
                <?php 
                if(count($uploads) > 0):
                foreach ($uploads as $key => $value) { ?>
                <tr>
                  <td><?= $value['id'] ?></td>
                  <td><?= $value['name']?></td>
                  <td><?= $value['type']?></td>
                  <td><?= $value['city']['name']?></td>
                  <td><?= $value['user']['first_name']." ".$value['user']['last_name']?></td>
                  <td><?= h($value->timestamp->nice('Europe/Lisbon', 'pt-PT')) ?></td>
                  <td>
                  	 <?= $this->Html->link('<i class="fa fa-external-link" style="margin-right:10px;"></i>', ['prefix' => false, 'controller' => 'img', 'action' => 'uploads',  $value['url']], ['escape' => false, 'target' => '_blank']) ?>
                  	 <?php if($Auth['role'] > 1 || $Auth['id'] == $value['owner']): ?>
                  	 
                     <?php if ($value['active'] == 1) {echo $this->Form->postLink('<i class="fa fa-eye" style="margin-right:10px"></i>', ['action' => 'toggle_file', $value['id']], ['escape' => false]); } else {
                        echo $this->Form->postLink('<i class="fa fa-eye-slash" style="margin-right:10px"></i>', ['action' => 'toggle_file', $value['id']], ['escape' => false]); 
                    } ?>  

                    <?= $this->Html->link('<i class="fa fa-edit" style="margin-right:10px;"></i>', ['action' => 'edit', $value['id']], ['escape' => false]) ?>

                    <?= $this->Form->postLink('<i class="fa fa-trash" style="margin-right:10px"></i>', ['action' => 'delete_file', $value['id']], ['escape' => false, 'confirm' => __('Tens a certeza que pretendes eliminar {0}?', $value['name'])]) ?>

                  <?php endif;?>
                  </td>
                </tr>
                <?php } else: ?>
                <tr> <td colspan='6' style='text-align:center'><em>Nenhum ficheiro encontrado.</em></td></tr>
            <?php endif;?>
              </tbody></table>
            </div>
            <!-- /.box-body -->
          </div>

 		</div>