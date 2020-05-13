
<?php $url = $this->Url->build(["prefix" => false, "controller" => '/'], true); ?>

<div class="row">
    <div class='col-md-12'>
        <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Adicionar Flashcards</h3>
            </div>

            <?= $this->Form->create($flashcard, ['class' => 'form-horizontal']) ?>

            <div class="form-group">
                    <br>
                  <label class="col-sm-4 control-label">Módulo</label>
                  <div class="col-sm-7">
                   <?= $this->Form->control('course_id', ['label' => false, 'class' => 'form-control', 'value' => $courses]);?>
                  </div>
                </div>

             <div class="form-group">
                    <br>
                  <label class="col-sm-4 control-label">Tema</label>
                  <div class="col-sm-7">
                   <?= $this->Form->control('theme_id', ['label' => false, 'class' => 'form-control']);?>
                  </div>
                </div>

             <div class="form-group">
                    <br>
                  <label class="col-sm-4 control-label">Frente</label>
                  <div class="col-sm-7">
                    <textarea id="editor1" name="front" rows="10" cols="80">
                                 
                    </textarea>
                  </div>
                </div>

             <div class="form-group">
                    <br>
                  <label class="col-sm-4 control-label">Verso</label>
                  <div class="col-sm-7">
                    <textarea id="editor2" name="verse" rows="10" cols="80">
                            
                    </textarea>
                  </div>
                </div>


              <div class="form-group">
                <div class="col-sm-7">
                <?= $this->Form->button(__('Guardar'), ['class' => 'btn btn-primary', 'style' => 'margin:5px; float:right']) ?>
                </div>
            </div>
    <?= $this->Form->end() ?>
        </div>
    </div>
</div>


<script src="<?= $url; ?>/bower_components/ckeditor/ckeditor.js"></script>
<script>
  $(function () {

    // Replace the <textarea id="editor1"> with a CKEditor
    // instance, using default configuration.
    CKEDITOR.replace('editor1', {
      height: '100px',
      allowedContent: true,
      toolbarGroups: [{ name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },
        { name: 'paragraph', groups: [ 'list', 'indent', 'blocks', 'align', 'bidi', 'paragraph' ] },
        { name: 'links', groups: [ 'links' ] },
        { name: 'insert', groups: [ 'insert' ] },
      ],
    });

    CKEDITOR.replace('editor2', {
      height: '100px',
      allowedContent: true,
      toolbarGroups: [{ name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },
        { name: 'paragraph', groups: [ 'list', 'indent', 'blocks', 'align', 'bidi', 'paragraph' ] },
        { name: 'links', groups: [ 'links' ] },
        { name: 'insert', groups: [ 'insert' ] },
      ],
    });

  });

</script>


