        <h2><?= __('Lista de Temas') ?></h2>
    <div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-body no-padding">
              <table class="table table-condensed table-hover">
                <thead>
                  <th> # </th>
                  <th>Domínio</th>
                  <th>Área</th>
                  <th>Tema</th>
                  <th style="width: 100px"></th>
                </thead>
                <tbody>
                <?php foreach ($themes as $key => $value) { ?>
                <tr>
                  <td><?= $value['id']?>.</td>
                  <td><?= $value['domain']?></td>
                  <td><?= $value['area']?></td>
                  <td><?= $value['name']?></td>
                  <td style='font-size:12pt; text-align:right'>
                    <?= $this->Html->link('<i class="fa fa-edit" style="margin-right:10px;"></i>', ['controller' => 'themes', 'action' => 'edit', $value['courses_id'], $value['id']], ['escape' => false]) ?>

                </td>
                </tr>
                <?php }?>
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

<script>
$("#matrix").addClass('active');
</script>