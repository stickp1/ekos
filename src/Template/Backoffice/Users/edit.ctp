<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */
?>
<?= $this->Html->css('croppie.css') ?>
<?= $this->Html->script('croppie.js'); ?>

<script src="http://foliotek.github.io/Croppie/bower_components/exif-js/exif.js"></script>

<div class="row">
    <div class='col-md-12'>
        <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Editar Perfil</h3>
            </div>
            <div class="row">
            <div class='col-md-3'>
                <div class="box-body box-profile">
              <img class="profile-user-img img-responsive img-circle" src="<?= $user['pic'] ?>" style='width:70%'>

              <h3 class="profile-username text-center"><?= $user['first_name']." ".$user['last_name'] ?></h3>
              <p style='text-align: center; position:relative; top:-5px'><small><a href='#' data-toggle="modal" data-target="#modal-default" > Alterar foto </a></small></p>

            </div>

            </div>
            <div class='col-md-9'>
                <?= $this->Form->create($user, ['class' => 'form-horizontal']) ?>
                <div class="form-group">
                    <br>
                  <label class="col-sm-3 control-label">Nome próprio</label>
                  <div class="col-sm-8">
                    <?= $this->Form->control('first_name', ['label' => false, 'class' => 'form-control']);?>
                  </div>
                </div>

                <div class="form-group">
                  <label class="col-sm-3 control-label">Apelidos</label>
                  <div class="col-sm-8">
                    <?= $this->Form->control('last_name', ['label' => false, 'class' => 'form-control']);?>
                  </div>
                </div>

                 <div class="form-group">
                  <label class="col-sm-3 control-label">E-mail</label>
                  <div class="col-sm-8">
                    <?= $this->Form->control('email', ['label' => false, 'class' => 'form-control']);?>
                  </div>
                </div>

                <div class="form-group">
                  <label class="col-sm-3 control-label">Telefone</label>
                  <div class="col-sm-8">
                    <?= $this->Form->control('phone_number', ['label' => false, 'class' => 'form-control']);?>
                  </div>
                </div>

                <div class="form-group">
                  <label class="col-sm-3 control-label">NIF</label>
                  <div class="col-sm-8">
                    <?= $this->Form->control('vat_number', ['label' => false, 'class' => 'form-control']);?>
                  </div>
                </div>

                <div class="form-group">
                  <label class="col-sm-3 control-label">Cargo</label>
                  <div class="col-sm-8">
                    <?= $this->Form->select('role', $role, ['id' => 'role-selector', 'label' => false, 'class' => 'form-control', "value" => $user['role'] ]);?>
                  </div>
                </div>

                 <div class="form-group" id='cidades' <?= $user['role'] == 0 || $user['role'] == 3 ? 'style="display:none"' : '' ?> >
                  <label class="col-sm-3 control-label">Cidade</label>
                    <div class="col-sm-8">
                      <?= $this->Form->select('city_id', $cities, ['label' => false, 'class' => 'form-control', "value" => $user['city_id'] ]);?>
                    </div>
                  </div>

                <div class="form-group" id='modulos' <?= $user['role'] == 0 || $user['role'] == 3 || $user['role'] == 4  ? 'style="display:none"' : '' ?> >
                  <label class="col-sm-3 control-label">Cursos</label>
                  <?php foreach ($Courses as $key => $value) { ?>
                  <div class="checkbox col-sm-3">
                    <label>
                      <input type="checkbox" name='privileges[]' value='<?= $key ?>' <?= @in_array($key, $moderator) ? 'checked': ''?>>
                      <?= $value ?>
                    </label>
                  </div>
                  <?php } ?>

                </div>

                <div class="form-group">
                  <label class="col-sm-3 control-label">Biografia</label>
                  <div class="col-sm-8">
                    <?= $this->Form->input('description', ['label' => false, 'class' => 'form-control', 'type' => 'textarea']);?>
                  </div>
                </div>
                <div class="col-sm-11">
                <?= $this->Form->button(__('Guardar'), ['class' => 'btn btn-primary', 'style' => 'float:right; margin:5px']) ?>
                </div>
                <?= $this->Form->end() ?>
                </div>
                
               
                
            </div>
        </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-default" style="display: none;">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">×</span></button>
                <h4 class="modal-title">Atualizar foto</h4>
              </div>
              <div class="modal-body" style='padding:0'>
                 <div class="demo-wrap upload-demo">
                    <div class="row">
                        <div class="col-sm-12">   
                        <p align='center'> <a class="btn file-btn">
                                    <input type="file" id="upload" value="Selecionar ficheiro" accept="image/*" />
                                </a></p>             
                            <div class="upload-msg" >
                                <div style='display: table-cell; vertical-align: middle; height:250px'>Faz upload de uma imagem para começar</div>
                            </div>
                            <div class="upload-demo-wrap">
                                <div id="upload-demo"></div>
                            </div>

                           <p>.</p>
                        </div>
                    </div>
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" id ="upload-result">Guardar</button>
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>




<style>
.demo-wrap {
    border-bottom: 1px solid #ddd;
    padding-top: 20px;
}

.demo-wrap .container {
    padding-bottom: 10px;
}

.demo-wrap strong {
    font-size: 16px;
    display: block;
    font-weight: 400;
    color: #aaa;
    margin: 0 0 5px 0;
}

.upload-demo .upload-demo-wrap,
.upload-demo .upload-result,
.upload-demo.ready .upload-msg {
    display: none;
}
.upload-demo.ready .upload-demo-wrap {
    display: block;
}
.upload-demo.ready .upload-result {
    display: inline-block;    
}
.upload-demo-wrap {
    width: 420px;
    height: 420px;
    margin: 0 auto;
}

.upload-msg {
    text-align: center;
    padding: 50px;
    font-size: 22px;
    color: #aaa;
    width: 300px;
    height:300px;
    margin: auto;
    border: 1px solid #aaa;
}
</style>
<script>

 var $uploadCrop;

        $uploadCrop = $('#upload-demo').croppie({
            viewport: {
                width: 400,
                height: 400,
                type: 'square'
            },
            enableExif: true
        });

$('#upload').on('change', function () { readFile(this); });

function readFile(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                
                reader.onload = function (e) {
                    $('.upload-demo').addClass('ready');
                    $uploadCrop.croppie('bind', {
                        url: e.target.result
                    }).then(function(){
                        console.log('jQuery bind complete');
                    });
                    
                }
                
                reader.readAsDataURL(input.files[0]);
            }
            else {
                swal("Sorry - you're browser doesn't support the FileReader API");
            }
        }

$('#upload-result').on('click', function (ev) {
            $uploadCrop.croppie('result', {
                type: 'canvas',
                size: 'viewport'
            }).then(function (resp) {
               $.post( "<?= $this->Url->build(['action' => 'image']);?>/", { img: resp, id: <?= $user['id'] ?> }, function( data ) {
                        if(data == 'success') {window.location.href = window.location.href+'?img=1';} 
                        else {window.location.href = window.location.href+'?img=2';}
                    }
                );
            });
        });

$('#modal-default').on('shown.bs.modal', function(){ 
    $uploadCrop.croppie('bind');
})

$('#role-selector').on('change', function(){ 
    if($(this).val() > 0 && $(this).val() < 3){$("#modulos").slideDown();} else {$("#modulos").slideUp();}
});

$('#role-selector').on('change', function(){ 
    if($(this).val() == 1 || $(this).val() == 2 || $(this).val() == 4){$("#cidades").slideDown();} else {$("#cidades").slideUp();}
});

</script>
