
<?php $url = $this->Url->build(["prefix" => false, "controller" => '/'], true); ?>

<div class="row">
    <div class='col-md-12'>
        <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Editar Aviso</h3>
            </div>

            <?= $this->Form->create($notification, ['class' => 'form-horizontal']) ?>


            <div class="form-group">
                    <br>
                  <label class="col-sm-4 control-label">Conteúdo</label>
                  <div class="col-sm-7">
                    <?= $this->Form->control('value', ['label' => false, 'class' => 'form-control', 'type' => 'textarea']);?>
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




