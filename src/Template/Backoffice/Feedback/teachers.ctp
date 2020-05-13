<?php if(@$this->request->getParam("pass")[1] > 2000){
  $year = @$this->request->getParam('pass')[1]; 
} else {
  $year = array_keys($years)[0];
} ?>

<?php $url = $this->Url->build(["prefix" => false, "controller" => '/'], true); ?>

<div class="page-header" style='border-bottom: 1px solid #ccc'>
        <h2>Análise por Formador
    

<div class="pull-right">    
    <?= $this->Form->control('years', ['class' => 'form-control', 'label' => false]); ?>
</div>

</h2>
</div>
   
<br>

<?php if($questions == 0): ?>
<div class="row animated fadeInRight">    
<div class="col-lg-8 col-md-10 col-lg-offset-2 col-md-offset-1 col-sm-12">
    <div class="ibox float-e-margins">
        <div class="ibox-title text-center"><b>Não existem respostas neste ano letivo.</b></div>
    </div>
</div>
</div>
<?php else: ?>


<?php foreach ($teachers as $key => $value) { ?>
<div class="row">
<div class="col-lg-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title"> <?= $questions[$key]?></h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table class="table teachers">
                <tbody>
                <?php foreach ($value as $key => $value2) { ?>
                <tr onclick='window.location.href="<?= $url."/backoffice/feedback/teacher/".$key?>"' >
                  <td><?= $value2['name'] ?></td>
                  <td width='250px'>
                    <div class="progress progress-sm">
                      <div class="progress-bar <?= $value2['avg'] < 3 ? 'progress-bar-danger' : 'progress-bar-green' ?>" style="width: <?= $value2['avg'] / 6 * 100 ?>%"></div>
                    </div>
                  </td>
                  <td width='40px'><span class="badge" style='background-color: #f2f2f2; color: #333'><?= $this->Number->precision($value2['avg'], 2) ?></span></td>
                </tr>
                <?php } ?>
              </tbody></table>


            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>

</div>
<?php } ?>

<?php endif; ?>

<style>
.progress {
  margin-bottom: 0;
}

table.teachers tr:hover td{
  background-color: #f9f9f9
}

table.teachers tr:hover {
  cursor: pointer
}
</style>

<script>
$("#years").on('change', function(){
  id = $(this).val();
  window.location.href='<?=$this->Url->build(["controller" => "feedback", "action" => "teachers"], true); ?>/'+id;
})

<?php if(@$this->request->getParam("pass")[0] > 2000){
  echo "$('#years').val(".@$this->request->getParam('pass')[0].");"; 
} ?>

$("li#<?= $this->request->params['controller']; ?> ul li#F3").addClass('active');
</script>