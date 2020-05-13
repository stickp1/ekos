<div class="row">
    <div class='col-md-12'>
        <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Editar Tema</h3>
            </div>

            <?= $this->Form->create($theme, ['class' => 'form-horizontal']) ?>
    
            <div class="form-group">
                    <br>
                  <label class="col-sm-4 control-label">Nome</label>
                  <div class="col-sm-7">
                    <?= $this->Form->control('name', ['label' => false, 'class' => 'form-control']);?>
                  </div>
                </div>

            <div class="form-group">
                    <br>
                  <label class="col-sm-4 control-label">Domínio</label>
                  <div class="col-sm-7">
                    <?= $this->Form->control('domain', ['label' => false, 'class' => 'form-control', 'options' =>
                      ['Medicina' => 'Medicina', 'Cirurgia' => 'Cirurgia', 'Pediatria' => 'Pediatria', 'Ginecologia/Obstetrícia' => 'Ginecologia/Obstetrícia', 'Psiquiatria' => 'Psiquiatria']
                    ]);?>
                  </div>
                </div>

            <div class="form-group">
                    <br>
                  <label class="col-sm-4 control-label">Relevância</label>
                  <div class="col-sm-2">
                    <?= $this->Form->control('relevance', ['label' => false, 'class' => 'form-control', 'options' =>
                      ['A*' => 'A*', 'A' => 'A', 'B' => 'B', 'C' => 'C']
                    ]);?>
                  </div>
                  <label class="col-sm-2 control-label">Área</label>
                  <div class="col-sm-3">
                    <?= $this->Form->control('area', ['label' => false, 'class' => 'form-control']);?>
                  </div>
                </div>



            <div class="form-group">
                    <br>
                  <label class="col-sm-4 control-label">Livro 1</label>
                  <div class="col-sm-7">
                    <?= $this->Form->control('bibliography_1', ['label' => false, 'class' => 'form-control', 'type' => 'textarea']);?>
                  </div>
                </div>

            <div class="form-group">
                    <br>
                  <label class="col-sm-4 control-label">Livro 2</label>
                  <div class="col-sm-7">
                    <?= $this->Form->control('bibliography_2', ['label' => false, 'class' => 'form-control', 'type' => 'textarea']);?>
                  </div>
                </div>

            <div class="form-group">
                    <br>
                  <label class="col-sm-4 control-label">Destaque</label>
                  <div class="col-sm-7">
                    <?= $this->Form->control('prefered', ['label' => false, 'class' => 'form-control', 'options' => [0 => 'Nenhum', 1 => 'Livro 1', 2 => 'Livro 2', 3 => 'Ambos']]);?>
                  </div>
                </div>

                            <div class="form-group">
                    <br>
                  <label class="col-sm-4 control-label">Conteúdos</label>
                  <div class="col-sm-7">
                    <?php
                        echo $this->Form->control('MD');
                        echo $this->Form->control('D');
                        echo $this->Form->control('P');
                        echo $this->Form->control('T');
                        echo $this->Form->control('GD');
                    ?>
                  </div>
                </div>

            <?php if($Auth['role'] == 3): ?>
            <div class="form-group">
                    <br>
                  <label class="col-sm-4 control-label">Curso</label>
                  <div class="col-sm-7">
                    <?= $this->Form->control('courses_id', ['label' => false, 'class' => 'form-control', 'options' => $Courses]);?>
                  </div>
                </div>
			<?php endif;?>
                <div class="form-group">
                <div class="col-sm-7">
                <?= $this->Form->button(__('Guardar'), ['class' => 'btn btn-primary', 'style' => 'margin:5px; float:right']) ?>
                </div>
            </div>
          
    <?= $this->Form->end() ?>
        </div>
    </div>
</div>

        
