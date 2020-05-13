
<?php $url = $this->Url->build(["prefix" => false, "controller" => '/'], true); ?>

<div class="row">
    <div class='col-md-12'>
        <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Nova Venda</h3>
            </div>

            <?= $this->Form->create($sale, ['class' => 'form-horizontal']) ?>
    
            <div class="form-group">
                    <br>
                  <label class="col-sm-4 control-label">Aluno</label>
                  <div class="col-sm-7">
                    <?= $this->Form->control('users_id', ['label' => false, 'class' => 'form-control', 'id' => 'mySelect2']);?>
                  </div>
                </div>

                  <div class="form-group">
                    <br>
                  <label class="col-sm-4 control-label">Módulos - Turmas</label>
                  <div class="col-sm-7">
                    <table width='100%'>
                      <?php foreach ($groups as $key => $value) { ?>
                      <tr>
                       <td> <?= $this->Form->control($value['course']['name'].": ".$value['name'], [ 'type' => 'checkbox', 'name' => "products[".$value['id']."]"])?> </td>
                       <td width='77px'><?= $this->Form->control('price', ['name' => "price[".$value['id']."]", 'value' => $value['course']['price'], 'type' => 'number', 'class' => 'form-control', 'label' => false, 'step' => '0.01' ] ) ?></td>
                      </tr>
                      <?php } ?> 
                    </table>
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
<script src="<?= $url; ?>/bower_components/moment/src/moment.js"></script>

        
<script>
$('#mySelect2').select2({
  ajax: {
    url: '<?= $this->Url->build(["controller" => "Users", "action" => "user-list"]); ?>',
    dataType: 'json',
    data: function (params) {
      var query = {
        search: params.term
      }


      // Query parameters will be ?search=[term]&type=public
      return query;
    }
  },
  placeholder: "Pesquisa por nome ou email",
  minimumInputLength: 3
});

$('#datepicker').datetimepicker({
                    format: 'DD/MM/YYYY HH:mm',
                });
</script>
