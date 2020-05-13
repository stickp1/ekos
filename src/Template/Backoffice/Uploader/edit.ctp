<div class="row">
    <div class='col-md-12'>
        <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Editar Ficheio <small><a href="<?php echo $this->Url->build(["prefix" => false, "controller" => 'img', 'action' => 'uploads', $file['url']]); ?>" target="_blank"><?= $file['url']?></a></small></h3>
            </div>

            <?= $this->Form->create($file, ['class' => 'form-horizontal']) ?>
        
            <div class="form-group">
                    <br>
                  <label class="col-sm-4 control-label">Nome</label>
                  <div class="col-sm-7">
                    <?= $this->Form->control('name', ['label' => false, 'class' => 'form-control']);?>
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

        
