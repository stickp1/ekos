<h2>Gestor de Ficheiros</h2>

<div class='row'>
	<div class="col-xs-12">
		<div class='box' style='padding:10px'>
		<div class="row">
		
		<div class="col-sm-6">
			<div class="form-group">
	                  <label>Curso</label>
	                  <select class="form-control" id='courses-select'>
	                  		<option style="display:none"> -- selecionar uma opção -- </option>
	                    <?php foreach ($courses_list as $key => $value) { ?>
	                    	<option value='<?= $key ?>'><?= $value ?> </option>
	                    <?php }?>
	                  </select>
	                </div>
		</div>
		<div class="col-sm-6">
			<div class="form-group" id="form-group-2">
	                  <label>Tema</label>
	                  <select class="form-control" id='theme-select' disabled >
	                  		<option style="display:none"> -- selecionar um curso -- </option>
	                  </select>
	                </div>
		</div>
		</div>

		<div class='row' id='uploader' style="display:none">
            <form method="post" action="<?= $this->Url->build(["action" => 'upload']);?>" enctype="multipart/form-data" id="uploadForm">

			<div class="col-sm-6">
                    <label for="file" class="floated">Enviar ficheiro: </label>
                    <input type="file" id="file" name="file" ><br>
                    <input type='hidden' name='theme_id' id='theme_id' />

                    <button type="submit" name="upload" class='btn btn-primary btn-xs' style='position:relative; bottom:10px'> Enviar </button>
            </div>
            <div class="col-sm-6">
            <?php if ($Auth['role'] == 3): ?>
			<div class="form-group">
	                  <label>Cidade</label>
	                  <select class="form-control" name='city_id'>
	                    <?php foreach ($cities2 as $key => $value) { ?>
	                    	<option value='<?= $key ?>'><?= $value ?> </option>
	                    <?php }?>
	                  </select>
	                </div>
	         <?php else: echo "<input type='hidden' name='city_id' value='$Auth[city_id]' />"; endif; ?>
		</div>
            </form>

 		</div>


	</div>

	<div class "row" id="results" style="display:none">

	</div>
	</div>
</div>

<script>
 $("#courses-select").on('change', function(){
    $.get("<?= $this->Url->build(['action' => 'list-themes']);?>/"+ $("#courses-select").val(),
   function(data){
     $("#form-group-2").html(data);
   });
 })

</script>

<?php if(isset($_GET['c']) && isset($_GET['t']) && (in_array($_GET['c'], $Auth['moderator']) || $Auth['role'] == 3)){ ?>

<script>

$("#courses-select").val(<?= $_GET['c'] ?>);
$("#theme_id").val(<?= $_GET['t'] ?>);
$("#uploader").slideDown();

$.get("<?= $this->Url->build(['action' => 'list-files', $_GET['t']]);?>",
   function(data){
     $("#results").html(data).fadeIn();
 });

$.get("<?= $this->Url->build(['action' => 'list-themes', $_GET['c']]);?>",
   function(data){
     $("#form-group-2").html(data);
     $("#themes-select").val(<?= $_GET['t'] ?>);
   });

</script>

<?php }?>

