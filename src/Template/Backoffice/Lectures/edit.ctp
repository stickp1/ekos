<?php $url = $this->Url->build(["prefix" => false, "controller" => '/'], true); ?>

<div class="row">
    <div class='col-md-12'>
        <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Editar Aula</h3>
            </div>

            <?= $this->Form->create($lecture, ['class' => 'form-horizontal']) ?>
            <div class="form-group">
                    <br>
                  <label class="col-sm-4 control-label">Temas</label>
                  <div class="col-sm-7">
                    <?= $this->Form->control('description', ['label' => false, 'class' => 'form-control']);?>
                  </div>
                </div>

             <div class="form-group">
                    <br>
                  <label class="col-sm-4 control-label">Data</label>
                  <div class="col-sm-7">
                    <?= $this->Form->control('datepicker', ['label' => false, 'class' => 'form-control', 'id' => 'datepicker', 'name' => 'datetime']);?>
                  </div>
                </div>

            <div class="form-group">
                    <br>
                  <label class="col-sm-4 control-label">Formador</label>
                  <div class="col-sm-7">
                    <?= $this->Form->control('teacher', ['label' => false, 'class' => 'form-control', 'options' => $teachers]);?>
                  </div>
                </div>

            <div class="form-group">
                    <br>
                  <label class="col-sm-4 control-label">Local</label>
                  <div class="col-sm-7">
                    <?= $this->Form->control('place', ['label' => false, 'class' => 'form-control']);?>
                  </div>
                </div>

            <div class="form-group">
                    <br>
                  <label class="col-sm-4 control-label">Temas</label>
                  <div class="col-sm-7">
                    <?= $this->Form->control('themes', ['label' => false, 'class' => 'form-control', 'multiple', 'id' => 'themes', 'name' => 'themes[]']);?>
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

<link rel="stylesheet" href="<?= $url; ?>/bower_components/select2/dist/css/select2.min.css">
<script src="<?= $url; ?>/bower_components/select2/dist/js/select2.min.js"></script>

<link rel="stylesheet" href="<?= $url; ?>/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
<script src="<?= $url; ?>/bower_components/moment/src/moment.js"></script>
<script src="<?= $url; ?>/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.js"></script>

<script>
$('#datepicker').datetimepicker({
                    format: 'DD/MM/YYYY HH:mm',
                });

<?php if($lecture['datetime']):?>
$("#datepicker").val('<?= $lecture->datetime->i18nFormat("dd/MM/yyyy HH:mm"); ?>');
<?php endif; ?>

<?php echo "var PRESELECTED_THEMES = [". $lecture['themes'] . "];\n"; ?>


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