<?php $url = $this->Url->build(["prefix" => false, "controller" => '/'], true); ?>

<div class="row">
        <div class="col-md-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title" style='font-size:20pt'><?php if($id == 1) echo "Inscrições"; elseif ($id == 2) echo "Exame"; elseif ($id == 3) echo "FAQs"; ?>
              </h3>
              <!-- tools box -->
              <!-- /. tools -->
            </div>
            <!-- /.box-header -->
            <div class="box-body pad">
              <form method='post'>
                    <textarea id="editor1" name="content" rows="10" cols="80">
                           <?= $content['content']; ?>          
                    </textarea>
                    <button class="btn btn-primary" style="float:right; margin-top:10px" type="submit">Guardar</button>
              </form>
            </div>

          </div>
          <!-- /.box -->
      </div>
  </div>

<script src="<?= $url; ?>/bower_components/ckeditor/ckeditor.js"></script>
<script>
  $(function () {
    // Replace the <textarea id="editor1"> with a CKEditor
    // instance, using default configuration.
    CKEDITOR.replace('editor1', {
height: '375px',
allowedContent: true
} );

  });

$("li#<?= $this->request->params['controller']; ?>").addClass('active');
$("li#Frontend ul li#i<?= $id ?>").addClass('active');

</script>