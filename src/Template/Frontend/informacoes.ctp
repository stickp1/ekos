<?php $url = $this->Url->build(["prefix" => false, "controller" => '/'], true); ?>
<!-- Header -->
<header style='background-image: url("<?= $url?>/img/banner4.jpg")'>
    <div class="container text-center">
        <span class='prelabel'>EKOS - Formar para a especialidade</span>
        <h1>Estamos aqui para ajudar.</h1>
    </div>
</header>
    
<section id="services" class="text-center">
  <div class="container">
    <div class="row">
      <div class="col-md-10 col-md-offset-1">
        <div class="panel with-nav-tabs panel-default" style='background:transparent'>
          <div class="panel-heading">
            <ul class="nav nav-tabs" id='submenu'>
              <li <?=  @$this->request->params['param'] == 'inscricoes' ||  @$this->request->params['param'] == null ? 'class="active"': ''?>>
                <a id="anual" href="#inscricoes" data-toggle="tab">Inscrições</a>
              </li>
              <li <?=  @$this->request->params['param'] == 'exame' ? 'class="active"': ''?> >
                <a href="#exame" data-toggle="tab">Exame</a>
              </li>
              <li <?=  @$this->request->params['param'] == 'matriz' ? 'class="active"': ''?> >
                <a href="#matriz" data-toggle="tab">Bibliografia</a>
              </li>
              <li <?=  @$this->request->params['param'] == 'docs' ? 'class="active"': ''?> >
                <a href="#docs" data-toggle="tab">Documentos</a>
              </li>
              <li <?=  @$this->request->params['param'] == 'faq' ? 'class="active"': ''?> >
                <a href="#faq" data-toggle="tab">FAQs</a>
              </li>
            </ul>
          </div>
          <div class="panel-body" style='padding-top:50px'>
            <div class="tab-content">
              <div class="tab-pane fade in <?=  @$this->request->params['param'] == 'inscricoes' ||  @$this->request->params['param'] == null ? 'in active': ''?>" id="inscricoes">
                  <?= $content['1']; ?> 
              </div>
              <div class="tab-pane fade <?=  @$this->request->params['param'] == 'exame' ? 'in active': ''?>" id="exame">
                  <?= $content['2']; ?>
              </div>
              <div class="tab-pane fade <?=  @$this->request->params['param'] == 'matriz' ? 'in active': ''?>" id="matriz">

                <p>Abaixo podes encontrar a correspondência entre temas e capítulos a estudar da bibliografia recomendada que elaborámos para ti. Podes consultar os nomes completos de cada livro na página de <a href='/informacoes/exame'>informações do exame</a>. </p> <p> Para cada tema indicámos os capitulos dos vários livros pelos quais podes optar por estudar. A negrito encontra-se a nossa recomendação bibliográfica de base. Em cada aula serão dadas informações mais detalhadas sobre por onde poderás orientar o teu estudo.
                </p>
                <br>
                <br>
                <div id="accordion">
                  <div class="card">
                    <div class="card-header" id="headingOne" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne" >
                      <button class="btn btn-link">Medicina
                      </button>
                      <i class="fa fa-chevron-down" id='arrow_collapseOne' style='float:right; margin-right: 20px; margin-top:5px'>
                      </i>
                    </div>
                    <div id="collapseOne" class="collapse " aria-labelledby="headingOne" data-parent="#accordion">
                      <div class="box-body table-responsive no-padding">
                        <table class="table" style='margin-bottom: 10px; border-bottom: 1px solid #666; border-top: 1px solid #666;'>
                          <tbody>
                            <?php foreach ($matrix['Medicina'] as $area => $content_) { ?>
                            <tr><td colspan='9' class='table-area'> <?= $area ?></td> </tr>
                            <tr>
                              <th>Rel.</th>
                              <th >Tema </th>
                              <th width='40px' style='text-align: center'>MD </th>
                              <th width='40px' style='text-align: center'>D </th>
                              <th width='40px' style='text-align: center'>P </th>
                              <th width='40px' style='text-align: center'>T </th>
                              <th width='40px' style='text-align: center'>GD </th>
                              <th width='100px'>Cecil</th>
                              <th width='100px'>Harrison</th>
                            </tr>
                            <?php foreach ($content_ as  $value) { ?>
                            <tr>
                              <td><?= $value['relevance'] ?></td>
                              <td><?= $value['name'] ?></td>
                              <td style='color: #F1F1F1; text-align: center; font-size: 10pt; <?= $value['MD'] == 1  ? "background-color:#D6D6D6;" : "" ?> border-right: 1px solid white;'>MD</td>
                              <td style='color: #F1F1F1; text-align: center; font-size: 10pt; <?= $value['D'] == 1 ? "background-color:#D6D6D6;" : "" ?> border-right: 1px solid white;'>D</td>
                              <td style='color: #F1F1F1; text-align: center; font-size: 10pt; <?= $value['P'] == 1 ? "background-color:#D6D6D6;" : "" ?> border-right: 1px solid white;'>P</td>
                              <td style='color: #F1F1F1; text-align: center; font-size: 10pt; <?= $value['T'] == 1 ? "background-color:#D6D6D6;" : "" ?> border-right: 1px solid white;'>T</td>
                              <td style='color: #F1F1F1; text-align: center; font-size: 10pt; <?= $value['GD'] == 1  ? "background-color:#D6D6D6;" : "" ?> border-right: 1px solid white;'>GD</td>
                              <td <?= $value['prefered'] == 1 || $value['prefered'] == 3 ? "style='font-weight:600'" : "" ?>><?= $value['bibliography_1'] ?></td>
                              <td <?= $value['prefered'] == 2 || $value['prefered'] == 3 ? "style='font-weight:600'" : "" ?>><?= $value['bibliography_2'] ?></td>
                            </tr>
                            <?php } ?>
                            <?php } ?>
                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div>
                  <div class="card">
                    <div class="card-header" id="headingOne" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo" >
                        <button class="btn btn-link">Cirurgia</button>
                        <i class="fa fa-chevron-down" id='arrow_collapseTwo' style='float:right; margin-right: 20px; margin-top:5px'></i>
                    </div>

                    <div id="collapseTwo" class="collapse " aria-labelledby="headingOne" data-parent="#accordion">
                      <div class="box-body table-responsive no-padding">
                        <table class="table" style='margin-bottom: 0'>
                          <tbody>
                            <?php foreach ($matrix['Cirurgia'] as $area => $content_) { ?>
                            <tr><td colspan='9' class='table-area'> <?= $area ?></td> </tr>
                            <tr>
                              <th>Rel.</th>
                              <th >Tema </th>
                              <th width='40px' style='text-align: center'>MD </th>
                              <th width='40px' style='text-align: center'>D </th>
                              <th width='40px' style='text-align: center'>P </th>
                              <th width='40px' style='text-align: center'>T </th>
                              <th width='40px' style='text-align: center'>GD </th>
                              <th width='100px'>Schwartz</th>
                              <th width='100px'>Outros</th>
                            </tr>
                            <?php foreach ($content_ as  $value) { ?>
                            <tr>
                              <td><?= $value['relevance'] ?></td>
                              <td><?= $value['name'] ?></td>
                              <td style='color: #F1F1F1; text-align: center; font-size: 10pt; <?= $value['MD'] == 1  ? "background-color:#D6D6D6;" : "" ?> border-right: 1px solid white;'>MD</td>
                              <td style='color: #F1F1F1; text-align: center; font-size: 10pt; <?= $value['D'] == 1 ? "background-color:#D6D6D6;" : "" ?> border-right: 1px solid white;'>D</td>
                              <td style='color: #F1F1F1; text-align: center; font-size: 10pt; <?= $value['P'] == 1 ? "background-color:#D6D6D6;" : "" ?> border-right: 1px solid white;'>P</td>
                              <td style='color: #F1F1F1; text-align: center; font-size: 10pt; <?= $value['T'] == 1 ? "background-color:#D6D6D6;" : "" ?> border-right: 1px solid white;'>T</td>
                              <td style='color: #F1F1F1; text-align: center; font-size: 10pt; <?= $value['GD'] == 1  ? "background-color:#D6D6D6;" : "" ?> border-right: 1px solid white;'>GD</td>
                              <td <?= $value['prefered'] == 1 || $value['prefered'] == 3 ? "style='font-weight:600'" : "" ?>><?= $value['bibliography_1'] ?></td>
                              <td <?= $value['prefered'] == 2 || $value['prefered'] == 3 ? "style='font-weight:600'" : "" ?>><?= $value['bibliography_2'] ?></td>
                            </tr>
                            <?php } ?>
                            <?php } ?>
                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div>
                  <div class="card">
                    <div class="card-header" id="headingOne" data-toggle="collapse" data-target="#collapseThree" aria-expanded="true" aria-controls="collapseThree" >
                      <button class="btn btn-link">
                        Pediatria
                      </button>
                      <i class="fa fa-chevron-down" id='arrow_collapseThree' style='float:right; margin-right: 20px; margin-top:5px'></i>
                    </div>

                    <div id="collapseThree" class="collapse " aria-labelledby="headingOne" data-parent="#accordion">
                      <div class="box-body table-responsive no-padding">
                        <table class="table" style='margin-bottom: 0'>
                          <tbody>
                            <?php foreach ($matrix['Pediatria'] as $area => $content_) { ?>
                            <tr><td colspan='9' class='table-area'> <?= $area ?></td> </tr>
                            <tr>
                              <th>Rel.</th>
                              <th >Tema </th>
                              <th width='40px' style='text-align: center'>MD </th>
                              <th width='40px' style='text-align: center'>D </th>
                              <th width='40px' style='text-align: center'>P </th>
                              <th width='40px' style='text-align: center'>T </th>
                              <th width='40px' style='text-align: center'>GD </th>
                              <th width='100px'>Manual Diagnóstico y Terapéutica</th>
                              <th width='100px'>Outros</th>
                            </tr>
                            <?php foreach ($content_ as  $value) { ?>
                            <tr>
                              <td><?= $value['relevance'] ?></td>
                              <td><?= $value['name'] ?></td>
                              <td style='color: #F1F1F1; text-align: center; font-size: 10pt; <?= $value['MD'] == 1  ? "background-color:#D6D6D6;" : "" ?> border-right: 1px solid white;'>MD</td>
                              <td style='color: #F1F1F1; text-align: center; font-size: 10pt; <?= $value['D'] == 1 ? "background-color:#D6D6D6;" : "" ?> border-right: 1px solid white;'>D</td>
                              <td style='color: #F1F1F1; text-align: center; font-size: 10pt; <?= $value['P'] == 1 ? "background-color:#D6D6D6;" : "" ?> border-right: 1px solid white;'>P</td>
                              <td style='color: #F1F1F1; text-align: center; font-size: 10pt; <?= $value['T'] == 1 ? "background-color:#D6D6D6;" : "" ?> border-right: 1px solid white;'>T</td>
                              <td style='color: #F1F1F1; text-align: center; font-size: 10pt; <?= $value['GD'] == 1  ? "background-color:#D6D6D6;" : "" ?> border-right: 1px solid white;'>GD</td>                  <td <?= $value['prefered'] == 1 || $value['prefered'] == 3 ? "style='font-weight:600'" : "" ?>><?= $value['bibliography_1'] ?></td>
                              <td <?= $value['prefered'] == 2 || $value['prefered'] == 3 ? "style='font-weight:600'" : "" ?>><?= $value['bibliography_2'] ?></td>
                            </tr>
                            <?php } ?>
                            <?php } ?>
                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div>
                  <div class="card">
                    <div class="card-header" id="headingOne" data-toggle="collapse" data-target="#collapseFour" aria-expanded="true" aria-controls="collapseFour" >
                      <button class="btn btn-link">
                        Ginecologia / Obstetrícia
                      </button>
                      <i class="fa fa-chevron-down" id='arrow_collapseFour' style='float:right; margin-right: 20px; margin-top:5px'></i>
                    </div>

                    <div id="collapseFour" class="collapse " aria-labelledby="headingOne" data-parent="#accordion">
                      <div class="box-body table-responsive no-padding">
                        <table class="table" style='margin-bottom: 0'>
                          <tbody>
                            <?php foreach ($matrix['Ginecologia/Obstetrícia'] as $area => $content_) { ?>
                            <tr><td colspan='8' class='table-area'> <?= $area ?></td> </tr>
                            <tr>
                              <th>Rel.</th>
                              <th >Tema </th>
                              <th width='40px' style='text-align: center'>MD </th>
                              <th width='40px' style='text-align: center'>D </th>
                              <th width='40px' style='text-align: center'>P </th>
                              <th width='40px' style='text-align: center'>T </th>
                              <th width='40px' style='text-align: center'>GD </th>
                              <th style='width: 100px'>Obstetrics & Gynecology </th>
                            </tr>
                            <?php foreach ($content_ as  $value) { ?>
                            <tr>
                              <td><?= $value['relevance'] ?></td>
                              <td><?= $value['name'] ?></td>
                              <td style='color: #F1F1F1; text-align: center; font-size: 10pt; <?= $value['MD'] == 1  ? "background-color:#D6D6D6;" : "" ?> border-right: 1px solid white;'>MD</td>
                              <td style='color: #F1F1F1; text-align: center; font-size: 10pt; <?= $value['D'] == 1 ? "background-color:#D6D6D6;" : "" ?> border-right: 1px solid white;'>D</td>
                              <td style='color: #F1F1F1; text-align: center; font-size: 10pt; <?= $value['P'] == 1 ? "background-color:#D6D6D6;" : "" ?> border-right: 1px solid white;'>P</td>
                              <td style='color: #F1F1F1; text-align: center; font-size: 10pt; <?= $value['T'] == 1 ? "background-color:#D6D6D6;" : "" ?> border-right: 1px solid white;'>T</td>
                              <td style='color: #F1F1F1; text-align: center; font-size: 10pt; <?= $value['GD'] == 1  ? "background-color:#D6D6D6;" : "" ?> border-right: 1px solid white;'>GD</td>
                              <td <?= $value['prefered'] == 1 || $value['prefered'] == 3 ? "style='font-weight:600'" : "" ?>><?= $value['bibliography_1'] ?></td>
                            </tr>
                            <?php } ?>
                            <?php } ?>
                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div>
                  <div class="card">
                    <div class="card-header" id="headingOne" data-toggle="collapse" data-target="#collapseFive" aria-expanded="true" aria-controls="collapseFive" >
                      <button class="btn btn-link">
                        Psiquiatria
                      </button>
                      <i class="fa fa-chevron-down" id='arrow_collapseFive' style='float:right; margin-right: 20px; margin-top:5px'></i>
                    </div>

                    <div id="collapseFive" class="collapse " aria-labelledby="headingOne" data-parent="#accordion">
                      <div class="box-body table-responsive no-padding">
                        <table class="table" style='margin-bottom: 0'>
                          <tbody>
                            <?php foreach ($matrix['Psiquiatria'] as $area => $content_) { ?>
                            <tr><td colspan='9' class='table-area'> <?= $area ?></td> </tr>
                            <tr>
                              <th>Rel.</th>
                              <th >Tema </th>
                              <th width='40px' style='text-align: center'>MD </th>
                              <th width='40px' style='text-align: center'>D </th>
                              <th width='40px' style='text-align: center'>P </th>
                              <th width='40px' style='text-align: center'>T </th>
                              <th width='40px' style='text-align: center'>GD </th>
                              <th width='100px'>Oxford</th>
                              <th width='100px'>Outros</th>
                            </tr>
                            <?php foreach ($content_ as  $value) { ?>
                            <tr>
                              <td><?= $value['relevance'] ?></td>
                              <td><?= $value['name'] ?></td>
                              <td style='color: #F1F1F1; text-align: center; font-size: 10pt; <?= $value['MD'] == 1  ? "background-color:#D6D6D6;" : "" ?> border-right: 1px solid white;'>MD</td>
                              <td style='color: #F1F1F1; text-align: center; font-size: 10pt; <?= $value['D'] == 1 ? "background-color:#D6D6D6;" : "" ?> border-right: 1px solid white;'>D</td>
                              <td style='color: #F1F1F1; text-align: center; font-size: 10pt; <?= $value['P'] == 1 ? "background-color:#D6D6D6;" : "" ?> border-right: 1px solid white;'>P</td>
                              <td style='color: #F1F1F1; text-align: center; font-size: 10pt; <?= $value['T'] == 1 ? "background-color:#D6D6D6;" : "" ?> border-right: 1px solid white;'>T</td>
                              <td style='color: #F1F1F1; text-align: center; font-size: 10pt; <?= $value['GD'] == 1  ? "background-color:#D6D6D6;" : "" ?> border-right: 1px solid white;'>GD</td>
                              <td <?= $value['prefered'] == 1 || $value['prefered'] == 3 ? "style='font-weight:600'" : "" ?>><?= $value['bibliography_1'] ?></td>
                              <td <?= $value['prefered'] == 2 || $value['prefered'] == 3 ? "style='font-weight:600'" : "" ?>><?= $value['bibliography_2'] ?></td>
                            </tr>
                            <?php } ?>
                            <?php } ?>
                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- Fecha acordião -->
                <p style='font-size:12px; text-align: right'> * MD - Mecanismo de Doença; D - Diagnóstico; P - Prevenção; T - Terapêutica; GD - Gestão do Doente
                </p>
                <p style='text-align:center'>
                  <button class="btn btn-black" onclick="window.open('http://ekos.pt/matriz-ekos.pdf')" style='margin-top:50px'>GUARDAR PDF
                  </button>
                </p>
              </div>
              
              <div class="tab-pane fade <?=  @$this->request->params['param'] == 'docs' ? 'in active': ''?>" id="docs">
                <p>Nesta secção podes encontrar documentos relevantes.</p><br>
                <?php $catNames = ['Geral', 'documentos tipo B']; ?>
                <?php foreach($categories as $key => $category): ?>
                    <p><?=$catNames[$key] ?>:</p>
                    <div class="panel panel-info well well-sm">
                        <div class="panel-body">
                            <?php foreach ($documents as $doc) : ?>
                                <?php if($doc['theme_id'] == $category['theme_id']): ?>
                                    <p class='small download'>
                                        <?= 
                                        $this->Html->link('<i class="fa fa-download"></i>'.$doc['name'], ['action' => 'file', $doc['id']], ['escape' => false, 'target' => '_blank']) ?>
                                    </p>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
              </div>
              <div class="tab-pane fade <?=  @$this->request->params['param'] == 'faq' ? 'in active': ''?>" id="faq">
                <div id="FAQ_accordion">
                  <?= $content['3']; ?>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div> 
    </div>
  </div>
</section>

<style>
a.expand{
  font-weight: 600;
}
#FAQ_accordion>div>p:last-child{
  padding-bottom: 30px
}
.fa-download{
  margin-right: 10px;
}
</style>

<script>
var $animation_elements = $('.animation-element');
var $window = $(window);

function check_if_in_view() {
  var window_height = $window.height();
  var window_top_position = $window.scrollTop();
  var window_bottom_position = (window_top_position + window_height);

  var time = 100;

  $.each($animation_elements, function() {
    var $element = $(this);
    var element_height = $element.outerHeight();
    var element_top_position = $element.offset().top;
    var element_bottom_position = (element_top_position + element_height);

    //check to see if this current container is within viewport
    if ((element_bottom_position >= window_top_position) &&
      (element_top_position <= window_bottom_position)) {
      setTimeout( function(){ $element.addClass('in-view'); }, time)
      time += 150;
    }
  });
}

$window.on('scroll resize', check_if_in_view);
$window.trigger('scroll');



$('#accordion').on('show.bs.collapse', function (e) {
  arrow = $("#arrow_"+$(e.target).attr('id'));
  arrow.removeClass('fa-chevron-down').addClass('fa-chevron-up');
})

$('#accordion').on('hide.bs.collapse', function (e) {
  arrow = $("#arrow_"+$(e.target).attr('id'));
  arrow.removeClass('fa-chevron-up').addClass('fa-chevron-down');
})


$('a.expand').click(function(e){
        e.preventDefault(); 
      });

</script>