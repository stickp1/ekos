
<?php $url = $this->Url->build(["prefix" => false, "controller" => '/'], true); ?>

<div class="row">
    <div class='col-md-12'>
        <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Editar Pergunta</h3>
            </div>

            <?= $this->Form->create($question, ['class' => 'form-horizontal', 'enctype' => 'multipart/form-data']) ?>

             <div class="form-group">
                    <br>
                  <label class="col-sm-4 control-label">Temas</label>
                  <div class="col-sm-7">
                   <?= $this->Form->control('themes', ['label' => false, 'class' => 'form-control', 'multiple', 'id' => 'themes', 'name' => 'themes[]']);?>
                  </div>
                </div>

            <div class="form-group">
                    <br>
                  <label class="col-sm-4 control-label">Pergunta</label>
                  <div class="col-sm-7">
                    <textarea id="editor1" name="question" rows="10" cols="80">
                           <?= $question['question']; ?>          
                    </textarea>
                  </div>
                </div>

            <div class="form-group">
                    <br>
                  <label class="col-sm-4 control-label">Opção 1</label>
                  <div class="col-sm-7">
                    <?= $this->Form->control('op1', ['label' => false, 'class' => 'form-control', 'type' => 'text']);?>
                  </div>
                </div>

            <div class="form-group">
                    <br>
                  <label class="col-sm-4 control-label">Opção 2</label>
                  <div class="col-sm-7">
                    <?= $this->Form->control('op2', ['label' => false, 'class' => 'form-control', 'type' => 'text']);?>
                  </div>
                </div>

            <div class="form-group">
                    <br>
                  <label class="col-sm-4 control-label">Opção 3</label>
                  <div class="col-sm-7">
                    <?= $this->Form->control('op3', ['label' => false, 'class' => 'form-control', 'type' => 'text']);?>
                  </div>
                </div>

            <div class="form-group">
                    <br>
                  <label class="col-sm-4 control-label">Opção 4</label>
                  <div class="col-sm-7">
                    <?= $this->Form->control('op4', ['label' => false, 'class' => 'form-control', 'type' => 'text']);?>
                  </div>
                </div>

            <div class="form-group">
                    <br>
                  <label class="col-sm-4 control-label">Opção 5</label>
                  <div class="col-sm-7">
                    <?= $this->Form->control('op5', ['label' => false, 'class' => 'form-control', 'type' => 'text']);?>
                  </div>
                </div>


            <div class="form-group">
                    <br>
                  <label class="col-sm-4 control-label">Correta</label>
                  <div class="col-sm-7">
                    <?= $this->Form->control('correct', ['label' => false, 'class' => 'form-control', 'options' => [1=>1,2=>2,3=>3,4=>4,5=>5]]);?>
                  </div>
                </div>


             <div class="form-group">
                    <br>
                  <label class="col-sm-4 control-label">Justificação</label>
                  <div class="col-sm-7">
                    <textarea id="editor2" name="justification" rows="10" cols="80">
                           <?= $question['justification']; ?>          
                    </textarea>
                  </div>
                </div>

            <?php if($question->pic != ''):?>
            <div class="form-group">
                    <br>
                  <label class="col-sm-4 control-label">Imagem</label>
                  <div class="col-sm-7" style='margin-top: 7px'>
                     <a href='<?= $this->Url->build(["prefix" => false, "controller" => "img", "action" => "questions", $question->pic]);?>' target='_blank'>Abrir </a> / <a href='#' onClick='$("#del_link").click()'> Eliminar </a> <br><br>
                  </div>
                </div>
            <?php else: ?>
            <div class="form-group">
                    <br>
                  <label class="col-sm-4 control-label"></label>
                  <div class="col-sm-7">
                     <input type="file" id="file" name="file" >
                  </div>
                </div>
            <?php endif; ?>


              <div class="form-group">
                <div class="col-sm-7">
                <?= $this->Form->button(__('Guardar'), ['class' => 'btn btn-primary', 'style' => 'margin:5px; float:right']) ?>
                </div>
            </div>
    <?= $this->Form->end() ?>
        </div>
    </div>
</div>

<?= $this->Form->postLink('Eliminar', ['action' => 'delete_pic', $question->id], ['escape' => false, 'confirm' => __('Tens a certeza que pretendes eliminar a imagem?'), 'id' => 'del_link', 'style' => 'display: none']) ?>

<link rel="stylesheet" href="<?= $url; ?>/bower_components/select2/dist/css/select2.min.css">
<script src="<?= $url; ?>/bower_components/select2/dist/js/select2.min.js"></script>

<link rel="stylesheet" href="<?= $url; ?>/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
<script src="<?= $url; ?>/bower_components/moment/src/moment.js"></script>
<script src="<?= $url; ?>/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.js"></script>

<script>

<?php echo "var PRESELECTED_THEMES = [". $question['theme_id'] . "];\n"; ?>


$('#themes').val(PRESELECTED_THEMES);
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

<script src="<?= $url; ?>/bower_components/ckeditor/ckeditor.js"></script>
<script>
  $(function () {

    // Replace the <textarea id="editor1"> with a CKEditor
    // instance, using default configuration.
    CKEDITOR.replace('editor1', {
      allowedContent: true,
      toolbarGroups: [{ name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },
        { name: 'paragraph', groups: [ 'list', 'indent', 'blocks', 'align', 'bidi', 'paragraph' ] },
        { name: 'links', groups: [ 'links' ] },
        { name: 'insert', groups: [ 'insert' ] },
      ],
    });

    CKEDITOR.replace('editor2', {
      height: '375px',
      allowedContent: true,
      toolbarGroups: [{ name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },
        { name: 'paragraph', groups: [ 'list', 'indent', 'blocks', 'align', 'bidi', 'paragraph' ] },
        { name: 'links', groups: [ 'links' ] },
        { name: 'insert', groups: [ 'insert' ] },
      ],
    });

  });

</script>


