<h2>Documentos</h2>
<div class='row'>
    <div class="col-xs-12">
		    <div class='box' style='padding:10px'>
		        <div class='row' id='uploader'>
                <form method="post" action="<?= $this->Url->build(['action' => 'upload']);?>" enctype="multipart/form-data" id="uploadForm">
		                <div class="col-md-6">
                        <label for="file" class="floated">Enviar ficheiro: </label>
                        <input type="file" id="file" name="file" ><br>
                        <input type='hidden' name='city_id' value='<?=$city_id?>' />
                        <label for="name">Nome do ficheiro:</label>
                        <input type="text" name="name" id="name" class="form-control">
                    </div>
                    <div class="col-md-6">
                        <label for="theme_id">Seleciona uma categoria:</label>
                        <select class="form-control" name="theme_id" id="theme_id">
                          <?php $letters = range('A', 'Z'); ?>
                          <?php $catletter = array(); ?>
                          <?php foreach ($categories as $key => $category): ?>
                              <?php $catLetter[$category['theme_id']] = $letters[$key]?>
                              <option value=<?=$category['theme_id']?> >
                                  <?=$letters[$key]?>
                              </option>
                          <?php endforeach; ?>
                        </select>
                        <button type="button" id="add" class="btn btn-xs btn-primary">Adicionar categoria</button>
                    </div>
                    <div class="col-md-12">
                    <button type="submit" name="upload" class='btn btn-primary btn-xs'> Enviar </button>    
                    </div>
                </form>
 		        </div>
	      </div>
        <div class="box">
            <div class="box-body no-padding">
                <table class="table table-condensed">
                    <tbody>
                        <tr>
                            <th style="width: 10px">#</th>
                            <th>Nome</th>
                            <th>Categoria</th>
                            <th>Tipo</th>
                            <th>Autor</th>
                            <th>Timestamp</th>
                            <th style="width: 120px"></th>
                        </tr>
                        <?php if(count($uploads) > 0): ?>
                            <?php foreach ($uploads as $key => $value): ?>
                                <tr>
                                    <td><?= $value['id'] ?></td>
                                    <td><?= $value['name']?></td>
                                    <td><?= $catLetter[$value['theme_id']]?></td>
                                    <td><?= $value['type']?></td>
                                    <td><?= $value['user']['first_name']." ".$value['user']['last_name']?></td>
                                    <td><?= h($value->timestamp->nice('Europe/Lisbon', 'pt-PT')) ?></td>
                                    <td>
                                        <?= $this->Html->link('<i class="fa fa-external-link" style="margin-right:10px;"></i>', ['prefix' => false, 'controller' => 'img', 'action' => 'uploads',  $value['url']], ['escape' => false, 'target' => '_blank']) ?>
                                        <?php if($Auth['role'] > 1 || $Auth['id'] == $value['owner']):
                                            echo $this->Form->postLink('<i class="fa fa-eye" style="margin-right:10px"></i>', ['action' => 'toggle_file', $value['id']], ['escape' => false]); 
                                        ?>
                                        <?= $this->Html->link('<i class="fa fa-edit" style="margin-right:10px;"></i>', ['action' => 'edit', $value['id']], ['escape' => false]) ?>
                                        <?= $this->Form->postLink('<i class="fa fa-trash" style="margin-right:10px"></i>', ['action' => 'delete_file', $value['id']], ['escape' => false, 'confirm' => __('Tens a certeza que pretendes eliminar {0}?', $value['name'])]) ?>
                                        <?php endif;?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr> 
                                <td colspan='6' style='text-align:center'><em>Nenhum ficheiro encontrado.</em></td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
 		</div>
</div>

<style>
.col-md-6{
  margin-bottom: 20px;
}
select.form-control{
  width: 120px;
}
input.form-control{
  width: 240px;
}
.col-md-6 button.btn-xs{
  margin-top: 20px;
}
</style>

<script>
$('#add').on('click', function(){
  console.log("bla");
  cats = <?php echo json_encode($categories) ?>;
  last = cats[cats.length-1];
  letters = <?php echo json_encode($letters) ?>;
  console.log(last['theme_id']);
  console.log(letters[cats.length]);
  $('select').append("<option id='newOption'></option>");
  $('#newOption').attr('value', last['theme_id'] - 1).text(letters[cats.length]).attr('selected', 'selected');
  $('#add').attr('disabled', true);
})

$('#file').change(function(){
  filename = $('#file').val().split(/\\|\//).pop();
  console.log(filename);
  $('#name').attr('value', filename);
});

</script>