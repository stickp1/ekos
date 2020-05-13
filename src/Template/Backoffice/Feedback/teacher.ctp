<?php if(@$this->request->getParam("pass")[1] > 2000){
  $year = @$this->request->getParam('pass')[1]; 
} else {
  $year = array_keys($years)[0];
} ?>

<?php $url = $this->Url->build(["prefix" => false, "controller" => '/'], true); ?>

<div class="page-header" style='border-bottom: 1px solid #ccc'>
        <h2><?= $user['first_name']." ".$user['last_name'] ?>
    

<div class="pull-right">    
    <?= $this->Form->control('years', ['class' => 'form-control', 'label' => false]); ?>
</div>

</h2>
</div>
   
<br>

<?php if($q == 0): ?>
<div class="row animated fadeInRight">    
<div class="col-lg-8 col-md-10 col-lg-offset-2 col-md-offset-1 col-sm-12">
    <div class="ibox float-e-margins">
        <div class="ibox-title text-center"><b>Não existem respostas para este formador neste ano letivo.</b></div>
    </div>
</div>
</div>
<?php else: ?>

<div class="row">
<div class="col-lg-8 col-lg-offset-2">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Análise Global</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <canvas id="graph-general" style='height: 100px'></canvas>

              <table class='table table-striped' style='margin-top: 20px; margin-bottom: 20px'>
            <thead>
              <tr>
                <th colspan='2'>Legenda</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($general['label'] as $key => $value) {?>
              <tr>
                <td width='50px'><b><?= $value ?></b></td>
                <td><?= $questions[$value] ?> </td>
              </tr>
              <?php } ?>
            </tbody>
          </table>

          <div id='data-div-1' class='data-div'>
          
          <table class='table data courses'>
            <thead>
              <tr>
                <th class='border'></th>
                <th>n</th>
                <th>0</th>
                <th >avg</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($general['label'] as $key => $question) {?>
              <tr>
                <th class='border'> <?= $question ?> </td>
                <td><?= isset($q[$question]['n']) ? $q[$question]['n'] : 0?></td>
                <td><?= isset($q[$question]['zero']) ? $q[$question]['zero'] : 0?></td>
                <td ><?= isset($q[$question]['avg']) ? $this->Number->precision($q[$question]['avg'], 2) : 0?></td>
              </tr>
              <?php } ?>
            </tbody>
          </table>

          </div>
          <a href="#" style='font-size: 16pt; float: right; padding: 0 3px' id='plus-1' class='plus'> <i class="fa fa-plus-square"></i></a>


            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>

</div>

<?php foreach ($q3 as $key => $value) { ?>

<div class="row">
<div class="col-lg-8 col-lg-offset-2">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Qualidade Global: <?= $courses[$key] ?></h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <canvas id="graph-uc-<?= $key?>" style='height: 100px'></canvas>

              <table class='table table-striped' style='margin-top: 20px; margin-bottom: 20px'>
            <thead>
              <tr>
                <th colspan='2'>Legenda</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($value['label'] as $key => $value2) {?>
              <tr>
                <td width='50px'><b><?= $value2 ?></b></td>
                <td><?= $Lectures[$value2] ?> <small> ---- <?php $themes_ = explode(',', $lectures[$value2]['themes']); foreach ($themes_ as $key => $theme) {
                @$themes_[$key] = $themes[$theme];}; @$themes_ = implode(" | ", $themes_); echo @$themes_; ?></small></td>
              </tr>
              <?php } ?>
            </tbody>
          </table>


            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>

</div>
<?php } ?>

<?php foreach ($q2 as $course => $value) {
        foreach ($value as $lecture => $value2) { ?>

<div class="row">
<div class="col-lg-8 col-lg-offset-2">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title"><?= $courses[$course]." - ".$Lectures[$lecture] ?></h3>
              <p><?php $themes_ = explode(',', $lectures[$lecture]['themes']); foreach ($themes_ as $key => $theme) {
                $themes_[$key] = $themes[$theme];}; $themes_ = implode(" | ", $themes_); echo $themes_; ?></p>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <canvas id="graph-lec-<?= $course.$lecture?>" style='height: 100px'></canvas>

              <table class='table table-striped' style='margin-top: 20px; margin-bottom: 20px'>
            <thead>
              <tr>
                <th colspan='2'>Legenda</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($value2['label'] as $key => $value3) {?>
              <tr>
                <td width='50px'><b><?= $value3 ?></b></td>
                <td><?= $questions[$value3] ?> </td>
              </tr>
              <?php } ?>
            </tbody>
          </table>


          <?php if(isset($comments[$lecture])): ?>

          <table class='table table-striped' style='margin-top: 20px; margin-bottom: 20px'>
            <thead>
              <tr>
                <th colspan='2'>Comentários</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($comments[$lecture] as $key => $value3) {?>
              <tr>
                <td><?= $value3 ?> </td>
              </tr>
              <?php } ?>
            </tbody>
          </table>

          <?php endif; ?>

          <div id='data-div-<?= $course.$lecture ?>' class='data-div'>
          
           <table class='table data courses'>
              <thead>
                <tr>
                  <th class='border'></th>
                  <th>n</th>
                  <th>0</th>
                  <th >avg</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($value2['label'] as $key => $question) {?>
                <tr>
                  <th class='border'> <?= $question ?> </td>
                  <td><?= isset($q[$question]['courses'][$course]['lectures'][$lecture]['n']) ? $q[$question]['courses'][$course]['lectures'][$lecture]['n'] : 0?></td>
                  <td><?= isset($q[$question]['courses'][$course]['lectures'][$lecture]['zero']) ? $q[$question]['courses'][$course]['lectures'][$lecture]['zero'] : 0?></td>
                  <td ><?= isset($q[$question]['courses'][$course]['lectures'][$lecture]['avg']) ? $this->Number->precision($q[$question]['courses'][$course]['lectures'][$lecture]['avg'], 2) : 0?></td>
                </tr>
                <?php } ?>
              </tbody>
            </table>

          </div>
          <a href="#" style='font-size: 16pt; float: right; padding: 0 3px' id='plus-<?= $course.$lecture ?>' class='plus'> <i class="fa fa-plus-square"></i></a>


            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>

</div>
<?php } } ?>



<script src="<?= $url; ?>/bower_components/chart.js/Chart.js"></script>
<script>
<?php 
$js_array = json_encode($general);
echo "var general = ". $js_array . ";\n";
$js_array = json_encode($q3);
echo "var q3 = ". $js_array . ";\n";
$js_array = json_encode($q2);
echo "var q2 = ". $js_array . ";\n";
 ?>

$(".plus").on('click', function(){
  event.preventDefault();
  $(this).fadeOut();
  var n = parseInt($(this).attr('id').replace(/[^\d]/g, ''), 10);
  $("#data-div-"+n).slideDown();
})

$(".details").on('change', function(){
  var n = parseInt($(this).attr('id').replace(/[^\d]/g, ''), 10);
  id = $(this).val();
  eval("myChart"+n).destroy();
  eval("question_graph"+n)(id);
  console.log();

  $("#data-div-"+n+" table.data.courses").toggleClass('hidden');
  $("#data-div-"+n+" table.data.groups").toggleClass('hidden');
})




var myChart;
var ctx = document.getElementById("graph-general");
  myChart = new Chart(ctx, {
      type: 'bar',
      data: {
          labels: general['label'],
          datasets: [{
              label: '',
              data: general['data'],
              backgroundColor: general['color'],
              borderColor: general['color'],
              borderWidth: 1
          }
          ]
      },
      options: {
      legend: {
              display: false
           },
          scales: {
              yAxes: [{
                  ticks: {
                      beginAtZero:true,
                      max: 6
                  }
              }],
              xAxes: [{
                categoryPercentage: 1.0,
                barPercentage: .8,
                  
              }]
          },
          tooltips: {
              callbacks: {
              label: function(tooltipItem, data) {
                      var label = data.datasets[tooltipItem.datasetIndex].label || '';

                      if (label) {
                          label += ': ';
                      }
                      label += Math.round(tooltipItem.yLabel * 100) / 100;
                      return label;
                  }
              }
          },
         
      }
  });


<?php foreach ($q3 as $key => $value) { ?>
var myChart_uc<?= $key?>;

var ctx = document.getElementById("graph-uc-<?= $key?>");
  myChart_uc = new Chart(ctx, {
      type: 'bar',
      data: {
          labels: q3[<?= $key?>]['label'],
          datasets: [{
              label: '',
              data: q3[<?= $key?>]['data'],
              borderWidth: 1,
              backgroundColor: 'rgba(204, 204, 204, 0.7)',
              borderColor: 'rgba(204, 204, 204, 0.7)',
              borderWidth: 1
          }
          ]
      },
      options: {
      legend: {
              display: false
           },
          scales: {
              yAxes: [{
                  ticks: {
                      beginAtZero:true,
                      max: 6
                  }
              }],
              xAxes: [{
                categoryPercentage: 1.0,
                barPercentage: .8,
                ticks: {
                      display: false //this will remove only the label
                  }
              }]
          },
          tooltips: {
              callbacks: {
              label: function(tooltipItem, data) {
                      var label = data.datasets[tooltipItem.datasetIndex].label || '';

                      if (label) {
                          label += ': ';
                      }
                      label += Math.round(tooltipItem.yLabel * 100) / 100;
                      return label;
                  }
              }
          },
         
      }
  });

<?php } ?>

<?php foreach ($q2 as $course => $value) {
        foreach ($value as $lecture => $value2) { ?>
var myChart_lec<?= $lecture?>;

var ctx = document.getElementById("graph-lec-<?= $course.$lecture?>");
  myChart_uc = new Chart(ctx, {
      type: 'bar',
      data: {
          labels: q2[<?= $course?>][<?= $lecture?>]['label'],
          datasets: [{
              label: '',
              data: q2[<?= $course?>][<?= $lecture?>]['data'],
              borderWidth: 1,
              backgroundColor: q2[<?= $course?>][<?= $lecture?>]['color'],
              borderColor: q2[<?= $course?>][<?= $lecture?>]['color'],
              borderWidth: 1
          }
          ]
      },
      options: {
      legend: {
              display: false
           },
          scales: {
              yAxes: [{
                  ticks: {
                      beginAtZero:true,
                      max: 6
                  }
              }],
              xAxes: [{
                categoryPercentage: 1.0,
                barPercentage: .8,
                ticks: {
                      display: false //this will remove only the label
                  }
              }]
          },
          tooltips: {
              callbacks: {
              label: function(tooltipItem, data) {
                      var label = data.datasets[tooltipItem.datasetIndex].label || '';

                      if (label) {
                          label += ': ';
                      }
                      label += Math.round(tooltipItem.yLabel * 100) / 100;
                      return label;
                  }
              }
          },
         
      }
  });

<?php } } ?>



</script>

<?php endif; ?>

<script>
$("#years").on('change', function(){
  id = $(this).val();
  window.location.href='<?=$this->Url->build(["controller" => "feedback", "action" => "teacher", $this->request->getParam("pass")[0]], true); ?>/'+id;
})

<?php if(@$this->request->getParam("pass")[1] > 2000){
  echo "$('#years').val(".@$this->request->getParam('pass')[1].");"; 
} ?>

<?php if($Auth['id'] == $user['id']): ?>
$("li#<?= $this->request->params['controller']; ?> ul li#F4").addClass('active');
<?php else: ?>
$("li#<?= $this->request->params['controller']; ?> ul li#F3").addClass('active');
<?php endif; ?>

</script>

<style>
div#main_container {
    padding: 10px 25px;
}

.table.universe th, 
.table.universe td {
  text-align: center;
  vertical-align: middle;
}

.table.universe tbody td,
.table.universe thead th  {
  border-right: 1px solid #e7eaec;
}

.table.universe > thead > tr > th {
  background-color: white;
  border-bottom: 1px solid #333;
}

.table.universe td.border, .table.universe th.border {
  border-right: 1px solid #333;
}

.table.universe > thead > tr > th:first-child{
  border-right: 1px solid #333;
}

.table.universe > tbody > tr > th {
  font-weight: 300;
}

.table.universe > tbody > tr > th,
.table.universe > tfoot > tr > th {
  border-right: 1px solid #333;
}

.table.universe > tfoot > tr > th,
.table.universe > tfoot > tr > td {
  background-color: rgba(248, 248, 248, 1);
}


.table.data {
  margin-top: 25px
  margin-bottom: 0;
}
.table.data th, .table.data td {
  text-align: center
}

.table.data > thead > tr > th{
  background-color: transparent;
  border-bottom:  0;

}

.table.data > thead > tr:nth-child(2) > th{
  border-bottom:  1px solid #333;
  border-top: 0;
  padding-top: 0;
}

.table.data.groups > thead > tr:nth-child(2) > th{
  width: <?= 100 / (count($groups)*3 + 4) ?>%;
}

.table.data.courses > thead > tr:nth-child(2) > th{
  width: <?= 100 / (count($courses)*3 + 4) ?>%;
}

.table.data tbody td {
  border-right: 1px solid #e7eaec;
}

.table.data tbody tr:last-child td, 
.table.data tbody tr:last-child th {
  border-bottom: 1px solid #e7eaec;
}

.table.data td.border, .table.data th.border {
  border-right: 1px solid #333;
}

.data-div{
  display: none
}

.plus {
  color: #e9e9ea;
}

.plus:hover {
  color: #999;
}

</style>