
<?php $url = $this->Url->build(["prefix" => false, "controller" => '/'], true); ?>

<div class="row">
    <div class='col-md-12'>
        <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Adicionar Aviso</h3>
            </div>

            <?= $this->Form->create($notification, ['class' => 'form-horizontal']) ?>

            <div class="form-group">
                    <br>
                  <label class="col-sm-4 control-label">Módulo</label>
                  <div class="col-sm-7">
                   <?= $this->Form->control('course_id', ['label' => false, 'class' => 'form-control', 'value' => $courses]);?>
                  </div>
                </div>
                
           <?php if ($Auth['role'] == 3): ?>
			<div class="form-group">
                    <br>
                  <label class="col-sm-4 control-label">Cidade</label>
                  <div class="col-sm-7">
                    <?= $this->Form->control('city_id', ['label' => false, 'class' => 'form-control', 'options' => $cities2]);?>
                  </div>
                </div>
	         <?php else: echo "<input type='hidden' name='city_id' value='$Auth[city_id]' />"; endif; ?>


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



