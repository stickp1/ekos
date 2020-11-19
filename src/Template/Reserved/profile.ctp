<?php $url = $this->Url->build(["prefix" => false, "controller" => '/'], true); ?>

<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */
?>
<?= $this->Html->css('croppie.css') ?>
<?= $this->Html->script('croppie.js'); ?>

<script src="//foliotek.github.io/Croppie/bower_components/exif-js/exif.js"></script>

<div id='flashMessage'>
  <?= $this->Flash->render(); ?>
</div>

<section id="services" class="text-center ">
    <div class="container top-bar">
        <div class="row">
            <div class="col-md-20">
                <div class="panel with-nav-tabs panel-default" style='background:transparent'>
                    <div class="panel-heading">
                        <ul class="nav nav-tabs" id='submenu'>
                            <li <?=  @$this->request->params['action'] == 'index' ? 'class="active"': ''?>><a href="<?= $this->Url->build(["prefix" => false, "controller" => 'reserved', "action" => "index"]) ?>">Cursos</a></li>
                            <li <?=  @$this->request->params['action'] == 'qbank' ? 'class="active"': ''?>><a href="<?= $this->Url->build(["prefix" => false, "controller" => 'reserved', "action" => "qbank"]) ?>">Perguntas</a></li>
                            <li <?=  @$this->request->params['action'] == 'fbank' ? 'class="active"': ''?>><a href="<?= $this->Url->build(["prefix" => false, "controller" => 'reserved', "action" => "fbank"]) ?>">Flashcards</a></li>
                            <li <?=  @$this->request->params['action'] == 'forum' ? 'class="active"': ''?>><a href="<?= $this->Url->build(["prefix" => false, "controller" => 'reserved', "action" => "forum"]) ?>">Dúvidas</a></li>
                            <?php if($isStudio): ?> <li <?=  @$this->request->params['action'] == 'videobank' ? 'class="active"': ''?>><a href="<?= $this->Url->build(["prefix" => false, "controller" => 'reserved', "action" => "videobank"]) ?>">Vídeos</a></li> <?php endif; ?>
                            <?php if(in_array(16, $courses) || in_array(15, $courses)): ?>
                            <li <?=  @$this->request->params['action'] == 'ebank' ? 'class="active"': ''?>><a href="<?= $this->Url->build(["prefix" => false, "controller" => 'reserved', "action" => "ebank"]) ?>">Exames</a></li>
                            <?php endif; ?>
                            <li <?=  @$this->request->params['action'] == 'payments' ? 'class="active"': ''?>><a href="<?= $this->Url->build(["prefix" => false, "controller" => 'reserved', "action" => "payments"]) ?>">Pagamentos</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="row" style='position:relative;'>
            <div class="reserved-background"></div>
            <!--<div class="row">-->
            <div class='col-md-12'>
                <div class="box">
                    <div class="row">
                        <div class='col-md-3'>
                            <div class="box-body box-profile">
                                <img class="profile-user-img img-responsive img-circle" src="<?=$url."/".$user['pic'] ?>" style='width:100%' >
                                <h3 class="profile-username text-center"><?= $user['first_name']." ".$user['last_name'] ?></h3>
                                <p style='text-align: center; position:relative; top:-5px'><small><a href='#' data-toggle="modal" data-target="#modal-default" > Alterar foto </a></small></p>
                            </div>
                            <button type="button" class="btn btn-black" id="password_button">Alterar password</button>
                        </div>
                        <div class='col-md-9'>
                            <?= $this->Form->create($user, ['class' => 'form-horizontal']) ?>
                            <div class="form-group">
                                <br>
                                <label class="col-sm-3 control-label">Nome próprio</label>
                                <div class="col-sm-8">
                                    <?= $this->Form->control('first_name', ['label' => false, 'class' => 'form-control', 'data-minlength' => '3', 'data-error' => 'O nome inserido não é válido.', ['options' => 'disabled']]);?>
                                    <div class="help-block with-errors"></div>
                                </div>
                                <!--<div class="col-sm-1">
                                <button type="button" class="btn btn-link btn-outline-dark" id="edit_fname"><i class="fa fa-pencil"></i></button>
                                </div>-->
                            </div>
                            <div class="form-group">
                              <label class="col-sm-3 control-label">Apelidos</label>
                              <div class="col-sm-8">
                                <?= $this->Form->control('last_name', ['label' => false, 'class' => 'form-control', 'data-minlength' => '3', 'data-error' => 'O nome inserido não é válido.', ['options' => 'disabled']]);?>
                                <div class="help-block with-errors"></div>
                              </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">E-mail</label>
                                <div class="col-sm-8">
                                    <?= $this->Form->control('email', ['label' => false, 'class' => 'form-control', 'data-error' => 'O email inserido não é válido ou já está em uso.', 'data-remote' => $url.'/users/validaEmail/', ['options' => 'disabled']]);?>
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>
                            <div class="form-group">
                              <label class="col-sm-3 control-label">Telefone</label>
                              <div class="col-sm-8">
                                <?= $this->Form->control('phone_number', ['label' => false, 'class' => 'form-control', 'data-error' => 'O número inserido não é válido', 'data-minlength' => '8', ['options' => 'disabled']]);?>
                                <div class="help-block with-errors"></div>
                              </div>
                            </div>
                            <div class="form-group">
                              <label class="col-sm-3 control-label">NIF</label>
                              <div class="col-sm-8">
                                <?= $this->Form->control('vat_number', ['label' => false, 'class' => 'form-control', 'id' => 'vati', 'data-error' => 'O NIF inserido não é válido. Insere 999999990, caso não desejes facultar NIF', 'data-remote' => $url.'/users/validaNIF/', ['options' => 'disabled']]);?>
                                <div class="help-block with-errors"></div>
                              </div>
                            </div>
                            <div class="form-group">
                              <label class="col-sm-3 control-label">Biografia</label>
                              <div class="col-sm-8">
                                  <?= $this->Form->input('description', ['label' => false, 'class' => 'form-control', 'type' => 'textarea', ['options' => 'disabled']]);?>
                                  <div class="help-block with-errors"></div>
                              </div>
                            </div>
                            <div class="col-sm-8 col-sm-offset-3">
                                <button type="button" class="btn btn-black" style="float:left; margin:5px" id="edit">Editar</button>
                                <?= $this->Form->button(__('Guardar'), ['class' => 'btn btn-black', 'style' => 'float:right; margin:5px', 'disabled', 'id' => 'save_but']) ?>
                            </div>
                            <?= $this->Form->end() ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="modal fade" id="modal-default" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                  </button>
                <h4 class="modal-title">Atualizar foto</h4>
            </div>
            <div class="modal-body" style='padding:0'>
                <div class="demo-wrap upload-demo">
                    <div class="row">
                        <div class="col-sm-12">
                            <p align='center'> 
                                <a class="btn file-btn">
                                    <input type="file" id="upload" value="Selecionar ficheiro" accept="image/*" />
                                </a>
                            </p>
                            <div class="upload-msg" >
                                <div style='display: table-cell; vertical-align: middle; height:250px'>Faz upload de uma imagem para começar</div>
                            </div>
                            <div class="upload-demo-wrap">
                                <div id="upload-demo"></div>
                            </div>
                        </div>
                    </div>
                    <p>&nbsp</p>
                </div>
            </div>
            <div class="modal-footer" style="text-align:center">
                <button type="button" class="btn btn-black" style="margin:auto;display:block;"id ="upload-result">Guardar</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="password">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <br>
                <h1>Alterar password</h1>
                <?= $this->Form->create('Form', [ 'url' => ['controller' => 'users', 'action' => 'changePassword'], 'id' => 'password_form' ]) ?>
                <fieldset>
                    <div class="form-group">
                        <div class="label">Password</div>
                        <input type="password" class="form-control" placeholder="Inserir password" name='password' id='password1' data-minlength="6" data-error="Mínimo de 6 caracteres." required />
                        <div class="help-block with-errors"></div>
                    </div>
                    <div class="form-group">
                        <div class="label">Confirmar Password</div>
                        <input type="password" class="form-control" placeholder="Confirmar password" id='password2' data-match="#password1" data-match-error="As passwords inseridas não são iguais." required />
                        <div class="help-block with-errors"></div>
                    </div>
                    <div align="center">
                        <button class="btn btn-black" type='submit'>Guardar</button>
                    </div>
                </fieldset>
                <?= $this->Form->end() ?>
            </div>
        <!-- /.modal-content -->
        </div>
    <!-- /.modal-dialog -->
    </div>
</div>

<style>

input[type="text"]:disabled {
  background: #f5f5f5;
}

input[type="email"]:disabled{
  background: #f5f5f5;
}

input[type="textarea"]:disabled{
  background: #f5f5f5;
}

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
               $.post( "<?= $this->Url->build(['action' => 'changeImage']);?>/", { img: resp, id: <?= $user['id'] ?> }, function(data) {
                        if(data == 'success') {window.location.href = window.location.href+'?img=1';}
                        else {window.location.href = window.location.href+'?img=2';}
                    }
                );
            });
        });

$('#modal-default').on('shown.bs.modal', function(){
    $uploadCrop.croppie('bind');
})

$('#edit').on('click', function(){
  $('.form-control').attr('disabled', false);
  $('#save_but').attr('disabled', false);
})

$('#password_button').on('click', function(){
  setTimeout(function(){ $("#password").modal('show'); }, 500);
})

$(function() {
   $('#flashMessage').delay(500).fadeIn('normal', function() {
      $(this).delay(2500).fadeOut();
   });
});

</script>
