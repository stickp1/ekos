<?php $url = $this->Url->build(["prefix" => false, "controller" => '/'], true); ?>
<!-- Header -->
<header style='background-image: url("<?= $url?>/img/banner3.jpg")'>
    <div class="container text-center">
        <span class='prelabel'>EKOS - Formar para a especialidade</span>
        <h1>Um novo exame, uma nova abordagem.</h1>
    </div>
</header>

    
<section id="intro" class="text-center bg-light">
    <div class="container">
        <div class="row" >
            <div class="col-md-8 col-md-offset-2">
                <h1>Um novo modelo.</h1>
                <p>Enfrentar uma prova com diferenças tão marcadas face ao anterior modelo e que exige domínio de conhecimento clínico, aumenta significativamente o nível de dificuldade e o desafio que é ser bem sucedido.
                </p>
                <p>Com vista a atingir melhores resultados, acreditamos que é preciso reformular o modelo de aulas de preparação, <b>passando do anfiteatro para a sala de aula.</b> 
                </p>
                <p><b>Aulas construídas de raiz</b>, apoiadas em casos clínicos e perguntas-tipo, com <b>integração de conhecimentos entre capítulos e livros</b> de temas clinicamente associados. 
              </p>
            </div>
        </div>
    </div>
</section>

<section id="annual" class="text-center">
    <div class="container">
        <div class="row" style='margin-bottom:40px'>
            <div class="col-md-8 col-md-offset-2">
                <h1>O nosso curso anual.</h1>
                <!--<p>Organizámos os módulos por <b>aparelhos funcionais</b>, que integram conhecimentos médicos e cirúrgicos complementares, de forma a potenciar a integração clínica que é o foco do exame. 
                </p>-->
                <p>Organizado em <b>11 módulos</b> estruturados por <b>aparelhos funcionais</b>, que integram conhecimentos médicos e cirúrgicos complementares, de forma a potenciar a integração clínica que é o foco do exame. 
                </p>
                <p class='small download'>
                    <a href='/temas_modulos.pdf' target="_blank">    <i class="fa fa-download"></i> Organização Temática dos Módulos 
                    </a>
                </p>
                <p><?= $this->Form->intpu('city', ['type' => 'select', 'options' => $cities2, 'style' => 'font-size: 12pt; margin-top:20px; display:none;', 'value' => $scity, 'id' => 'city_selector'])?>
                </p>
                <?php foreach($courses as $key => $value): ?>
                    <?php foreach ($value['groups'] as $key2 => $group): ?>
                        <?php if($group['inscriptions_open'] == 1 && $value['id'] == $annual_trigger_course_id): ?>
                            <?php if (@in_array($group['id'], $inscriptions)) break 2; ?>
                        <?php endif; ?>
                    <?php endforeach; ?>
                    <?php foreach ($value['groups'] as $key2 => $group): ?>
                        <?php if($group['inscriptions_open'] == 1 && $value['id'] == $annual_trigger_course_id): ?>
                            <?php if(!@in_array($group['id'], $inscriptions) && !isset($annualDisplayed)): ?>
                                <br>
                                <span class='small'> Inscrições Abertas </span>
                                <?php $annualDisplayed = true; ?>
                            <?php endif; ?>
                            
                            <?php if (@$count[$group['id']] >= $group['vacancy']): ?>
                                <?php if(isset($Auth['id'])): ?>
                                        <?php if(!in_array($group['id'], $waiting)) ?>
                                            <button class="btn btn-black" onClick='window.location.href = "<?= $this->Url->build(["controller" => 'reserved', 'action' => 'waiting', $group['id']]) ?>"'>Lista de Espera
                                            </button> 
                                <?php else: ?>
                                        <button class="btn btn-black" data-toggle="modal" data-target="#login" >Lista de Espera
                                        </button>
                                <?php endif; ?>

                            <?php else: ?>
                                <?php if(isset($Auth['id'])): ?>
                                    <button class="btn btn-black" onClick='window.location.href = "<?= $this->Url->build(["controller" => 'reserved', 'action' => 'inscription', $value['id'], 'true']) ?>"'>INSCREVER
                                    </button>
                                <?php else: ?>
                                    <button class="btn btn-black" data-toggle="modal" data-target="#login" >INSCREVER
                                    </button>
                                <?php endif; break; ?>                                
                            <?php endif; ?>
                        <?php endif; ?>
                    <?php endforeach; ?>         
                <?php endforeach; ?>
            </div>
        </div>
        <div class='row'>
            <div class='col-md-10 col-md-offset-1'>
                <table class='courses-list'>
                    <?php $aux = $coursesLen; ?>
                    <?php foreach ($courses as $key => $value) : ?>
                        <?php //if(--$aux < 5) break; ?>
                        <tr class='primary' id="<?= $value['id']?>">
                            <td><?= $value['name'] ?></td>
                            <td>
                                <?php foreach ($value['groups'] as $key2 => $group): ?>
                                    <?php if(@in_array($group['id'], $inscriptions)): ?>
                                      <span class='small'> INSCRITO </span>
                                    <?php break; elseif($group['inscriptions_open'] == 1): ?>
                                      <span class='small'> Inscrições Abertas </span>
                                    <?php break; endif ?>
                                <?php endforeach; ?>
                            </td>
                            <td width='50px'><i class="fa fa-chevron-down" id='arrow_<?= $value['id']?>'></i>
                            </td>
                        </tr>
                        <tr>
                            <td colspan='3' style='padding:0; background-color: #f5f5f5'>
                                <div class='dependency d<?= $value['id']?> closed'>
                                <!---VERIFICA SE EXISTEM TURMAS -->
                                <?php if(count($value['groups']) > 0): ?>
                                <div class="panel with-nav-tabs panel-default" style='background:transparent'>
                                    <div>
                                        <ul class="nav nav-tabs">
                                            <?php foreach ($value['groups'] as $key2 => $group): ?>
                                            <li <?= $key2 == 0 ? "class='active'" : "" ?>><a href="#turma<?=$group['id']?>" data-toggle="tab"><?= $group['name']?></a></li>
                                            <?php endforeach; ?>
                                        </ul>
                                    </div>
                                    <div class="panel-body">
                                        <div class="tab-content">
                                            <?php foreach ($value['groups'] as $key2 => $group):
                                              $min_date = new DateTime('2040-12-31');
                                              $max_date = new DateTime('1994-12-31');
                                              foreach ($group['lectures'] as $lecture): 
        						                              if($lecture['datetime']):
                                                    if($lecture['datetime']->format("Y-m-d") < $min_date->format("Y-m-d")) 
                                                      $min_date = $lecture['datetime'];
                                                    if($lecture['datetime']->format("Y-m-d") > $max_date->format("Y-m-d"))
                                                      $max_date = $lecture['datetime'];
                                                  endif;
                                              endforeach; ?>
                                              <div class="tab-pane fade in <?= $key2 == 0 ? "active" : "" ?>" id="turma<?=$group['id']?>">
                                                  <table style='width: 100%;'>
                                                      <tr style='border-bottom: 1px solid #666; background-color: white'>
                                                          <td valign='middle'>
                                                              <span style='position: relative; top: 7px'>
                                                                  <?= $min_date != new DateTime('2040-12-31') && $max_date != new DateTime('1994-12-31') ?$min_date->i18nFormat('dd.MM.yyyy')." - ".$max_date->i18nFormat('dd.MM.yyyy') : ""?>    
                                                              </span> 
                                                              <span style='position: relative; top: 7px; left: 20px; font-weight: 600'> 
                                                                  <?= $value['price'] ? $value['price']. " €" : ''?> 
                                                              </span> 
                                                              <?php if(@$count[$group['id']] >= $group['vacancy'] && $group['inscriptions_open'] == 1) echo "<span style='position: relative; top: 7px; left: 40px; font-weight: 400; color:red'> Esgotado</span>"; ?>
                                                          </td>
                                                          <td width='100px'> 
                                                              <?php if (@in_array($group['id'], $inscriptions)): ?>
                                                                  <span style='position: relative; top: 7px; right: 10px;'>Inscrito</span>
                                                              <?php elseif (@$count[$group['id']] >= $group['vacancy'] && $group['inscriptions_open'] == 1 && isset($Auth['id'])): ?>
                                                                  <?php if(!in_array($group['id'], $waiting)) ?> 
                                                                      <button class="btn btn-black" onClick='window.location.href = "<?= $this->Url->build(["controller" => 'reserved', 'action' => 'waiting', $value['id']]) ?>"'>Lista de Espera
                                                                      </button>
                                                              <?php elseif (@$count[$group['id']] >= $group['vacancy'] && $group['inscriptions_open'] == 1 && !isset($Auth['id'])): ?>
                                                                  <button class="btn btn-black" data-toggle="modal" data-target="#login" >Lista de Espera
                                                                  </button>
                                                              <?php elseif ($group['inscriptions_open'] == 1 && isset($Auth['id'])): ?>
                                                                  <button class="btn btn-black" onClick='window.location.href="<?= $this->Url->build(["controller" => 'reserved', 'action' => 'inscription', $value['id']]) ?>"'>INSCREVER
                                                                  </button>
                                                              <?php elseif ($group['inscriptions_open'] == 1 && !isset($Auth['id'])): ?>
                                                                  <button class="btn btn-black" data-toggle="modal" data-target="#login" >INSCREVER</button>
                                                              <?php endif; ?>
                                                          </td>
                                                      </tr>
                                                      <?php foreach ($group['lectures'] as $lecture) { ?>
                                                          <tr class='class-list'>
                                                              <td colspan='2'>
                                                                  <span class='class-name'> 
                                                                      <?php 
                                                                        $themes_ =  explode(',', $lecture['themes']);
                                                                        if($lecture['themes'] != ''){
                                        	                                foreach($themes_ as $key3 => $value2):
                                        	                                $themes_[$key3] = $themes[$value2];
                                        	                                endforeach;
                                        	                                $lecture['description'] = implode(' | ', $themes_);
                                                                        }         
                                                                        echo $lecture['description']; ?>
                                                                  </span>
                                                                  <span style='margin-right: 25px'><?= $lecture->has('datetime') ?$lecture['datetime']->i18nFormat('dd.MM.yyyy') : '' ?>
                                                                  </span>
                                                                  <span style='margin-right: 25px'><?= $lecture->has('datetime') ? $lecture['datetime']->i18nFormat('HH')."h" : '' ?><?= $lecture->has('datetime') ? $lecture['datetime']->i18nFormat('mm'): '' ?> 
                                                                  </span>
                                                                  <!--<span style='margin-right: 25px'><?= $lecture['user']['first_name']." ".$lecture['user']['last_name']?></span>-->
                                                                  <?php if(@in_array($value['id'], $inscriptions_courses)): ?>
                                                                    <span style='margin-right: 25px'><?= $lecture['place'] ?></span>
                                                                  <?php endif; ?>
                                                              </td>
                                                          </tr>
                                                      <?php } ?>
                                                  </table>
                                              </div>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>    <!---SE NÃO EXISTEM TURMAS -->
                    
                                <?php else: ?>
                  
            		        <table style='width: 100%;'>
                            <tr style='border-bottom: 1px solid #666; border-top: 1px solid #666; background-color: white'>
                                <td colspan='3' valign='middle' style='text-align: center'> 
                                    <span style='font-weight: 600'> <?= $value['price'] ? $value['price']. " € | " : '' ?> </span> 
                                    <span style='font-style: italic'><small>Datas a definir</small></span>
                                </td>
                            </tr>
                            <?php foreach ($value['themes'] as $theme_): ?>
                                <tr class='class-list'>
                                    <td colspan='2'>
                                        <span class='class-name'> <?= $theme_['name'] ?></span>
                                    </td>
                                </tr>
                            <?php endforeach ?>
                        </table>
                                <?php endif; ?>
                  
                        </div>
                    <?php endforeach; ?>
                </table>
            </div>
        </div>
    </div>
</section>

<section id="summer" class="text-center bg-light">
    <div class="container">
        <div class="row" style='margin-bottom:40px'>
            <div class="col-md-8 col-md-offset-2">
                <h1>O nosso curso de verão.</h1>
                <p>Um curso de <b>revisão intensiva</b> dos principais conceitos das 5 áreas da matriz, através de um <b>modelo assente em casos clínicos</b>, a partir dos quais se fará a desconstrução e apresentação de conteúdos. 
                </p>
                <p class='small download' style='display:none;'>
                    <a href='/programa_integrado.pdf' target="_blank">    <i class="fa fa-download"></i> Temas do Curso de Verão 
                    </a>
                </p>
                <p><?= $this->Form->intpu('city', ['type' => 'select', 'options' => $cities2, 'style' => 'font-size: 12pt; margin-top:20px; display:none;', 'value' => $scity, 'id' => 'city_selector'])?>
                </p>
                <?php foreach ($summer['groups'] as $key2 => $group): ?>
                    <?php if(!@in_array($group['id'], $inscriptions) && $group['inscriptions_open'] == 1 && !isset($summerDisplayed)): ?>
                      <br>
                      <span class='small'> Inscrições Abertas </span>
                      <?php $summerDisplayed = true; ?>
                    <?php endif; ?>
                    <?php if ($group['inscriptions_open'] == 1): ?>
                        <?php if (@$count[$group['id']] >= $group['vacancy']): ?>
                            <?php if(isset($Auth['id']) && !in_array($group['id'], $inscriptions)): ?>
                                <?php if(!in_array($group['id'], $waiting)) ?>
                                    <button class="btn btn-black" onClick='window.location.href = "<?= $this->Url->build(["controller" => 'reserved', 'action' => 'waiting', $group['id']]) ?>"'>Lista de Espera
                                    </button> 
                            <?php elseif(!isset($Auth['id'])): ?>
                                <button class="btn btn-black" data-toggle="modal" data-target="#login" >Lista de Espera
                                </button>
                            <?php endif ?>
                        <?php else: ?>
                            <?php if(isset($Auth['id']) && !in_array($group['id'], $inscriptions)): ?>
                                <button class="btn btn-black" onClick='window.location.href = "<?= $this->Url->build(["controller" => 'reserved', 'action' => 'inscription', $summer['id']]) ?>"'>INSCREVER
                                </button>
                            <?php elseif(!isset($Auth['id'])): ?>
                                <button class="btn btn-black" data-toggle="modal" data-target="#login" >INSCREVER
                                </button>
                            <?php endif; break; ?>
                        <?php endif; ?>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
        </div>
        <div class='row'>
            <div class='col-md-10 col-md-offset-1'>
                <table class='courses-list'>
                    <?php $aux = $coursesLen; ?>
                    <?php foreach ($courses2 as $key => $value) : ?>
                        <tr class='primary' id="s<?= $key?>">
                            <td><?= $value ?></td>
                            <td>
                                <?php foreach ($summer['groups'] as $key2 => $group): ?>
                                    <?php if(@in_array($group['id'], $inscriptions)): ?>
                                      <span class='small'> INSCRITO </span>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </td>
                            <td width='50px'><i class="fa fa-chevron-down" id='arrow_s<?= $key?>'></i>
                            </td>
                        </tr>
                        <tr>
                            <td colspan='3' style='padding:0; background-color: #f5f5f5'>
                                <div class='dependency ds<?= $key?> closed'>
                                    <!---VERIFICA SE EXISTEM TURMAS -->
                                    <?php if(count($summer['groups']) > 0): ?>
                                    <div class="panel with-nav-tabs panel-default" style='background:transparent'>
                                        <div>
                                            <ul class="nav nav-tabs">
                                                <?php foreach ($summer['groups'] as $key2 => $group): ?>
                                                <li <?= $key2 == 0 ? "class='active'" : "" ?>><a href="#turma<?=$key.$group['id']?>" data-toggle="tab"><?= $group['name']?></a></li>
                                                <?php endforeach; ?>
                                            </ul>
                                        </div>
                                        <div class="panel-body">
                                            <div class="tab-content">
                                                <?php foreach ($summer['groups'] as $key2 => $group): 
                                                  $min_date = new DateTime('2040-12-31');
                                                  $max_date = new DateTime('1994-12-31');
                                                  foreach ($group['lectures'] as $lecture):
                                                      if($lecture['datetime'] && $lecture['description'] == $value):
                                                        if($lecture['datetime']->format("Y-m-d") < $min_date->format("Y-m-d")) 
                                                          $min_date = $lecture['datetime'];
                                                        if($lecture['datetime']->format("Y-m-d") > $max_date->format("Y-m-d"))
                                                          $max_date = $lecture['datetime'];
                                                      endif;
                                                  endforeach; ?>
                                                  <div class="tab-pane fade in <?= $key2 == 0 ? "active" : "" ?>" id="turma<?=$key.$group['id']?>">
                                                      <table style='width: 100%;'>
                                                          <tr style='border-bottom: 1px solid #666'>
                                                              <td valign='middle'>
                                                                  <span style='position: relative; top: 7px'>
                                                                      <?= $min_date != new DateTime('2040-12-31') && $max_date != new DateTime('1994-12-31') ?$min_date->i18nFormat('dd.MM.yyyy')." - ".$max_date->i18nFormat('dd.MM.yyyy') : ""?>
                                                                  </span> 
                                                                  <?php if(@$count[$group['id']] >= $group['vacancy'] && $group['inscriptions_open'] == 1) ?>    <span style='position: relative; top: 7px; left: 40px; font-weight: 400; color:red'>
                                                                          Esgotado
                                                                      </span>
                                                              </td>
                                                              <td> 
                                                                  <button class="btn btn-black" onClick='window.location.href="<?= $this->Url->build(["controller" => 'frontend', 'action' => 'informacoes', '#' => 'verão'])?>"'>Mais informações
                                                                  </button>
                                                              </td>
                                                          </tr>
                                                          <?php foreach ($group['lectures'] as $lecture): ?>
                                                              <?php if ($lecture['description'] == $value): ?>
                                                                  <tr class='class-list'>
                                                                      <td colspan='2'>
                                                                          <span class='class-name'> 
                                                                              <?php 
                                                                                $themes_ =  explode(',', $lecture['themes']);
                                                                                if($lecture['themes'] != ''){
                                                                                  foreach($themes_ as $key3 => $value2):
                                                                                  $themes_[$key3] = $themes[$value2];
                                                                                  endforeach;
                                                                                  $lecture['description'] = implode(' | ', $themes_);
                                                                                }
                                                                                echo $lecture['description']; ?>
                                                                          </span>
                                                                          <span style='margin-right: 25px'><?= $lecture->has('datetime') ?$lecture['datetime']->i18nFormat('dd.MM.yyyy') : '' ?>
                                                                          </span>
                                                                          <span style='margin-right: 25px'><?= $lecture->has('datetime') ? $lecture['datetime']->i18nFormat('HH')."h" : '' ?><?= $lecture->has('datetime') ? $lecture['datetime']->i18nFormat('mm'): '' ?> 
                                                                          </span>
                                                                          <!--<span style='margin-right: 25px'><?= $lecture['user']['first_name']." ".$lecture['user']['last_name']?></span>-->
                                                                          <?php if(@in_array($summer['id'], $inscriptions_courses)): ?>
                                                                            <span style='margin-right: 25px'><?= $lecture['place'] ?></span>
                                                                          <?php endif; ?>
                                                                      </td>
                                                                  </tr>
                                                              <?php endif; ?>
                                                          <?php endforeach;?>
                                                      </table>
                                                  </div>
                                                <?php endforeach; ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>    
                                    <!---SE NÃO EXISTEM TURMAS -->
                                    <?php else: ?>
                                        <table style='width: 100%;'>
                                            <tr style='border-bottom: 1px solid #666; border-top: 1px solid #666; background-color: white'>
                                                <td colspan='3' valign='middle' style='text-align: center'> 
                                                    <span style='font-style: italic'><small>Datas a definir</small></span>
                                                </td>
                                            </tr>
                                            <?php foreach ($summer['themes'] as $theme_): ?>
                                                <tr class='class-list'>
                                                    <td colspan='2'>
                                                        <span class='class-name'> <?= $theme_['name'] ?></span>
                                                    </td>
                                                </tr>
                                            <?php endforeach ?>
                                        </table>
                                     
                                    <?php endif; ?>
                  
                        </div>
                    <?php endforeach; ?>
                </table>
            </div>
        </div>
    </div>
</section>

<section id="recruting" class='text-center'>
      <div class="container">
        <div class="row">
          <div class="col-md-8 col-md-offset-2">
            <h1>Perguntas Modelo.</h1>
            <p>Não sabes que tipo de perguntas vão sair na nova prova? A EKOS preparou para ti 25 perguntas-tipo, baseadas no modelo de vinheta clínica, para que possas saber o que te espera.</p>

            <button class="btn btn-black" onClick="window.open('http://ekos.pt/reserved/exam')" >COMEÇAR</button>
          </div>
        </div>
      </div>
</section> 

<section class='text-sm-left text-center no-gutters about'>
    <div class="row is-flex">
        <div class="col-sm-6" style='background-image: url("<?= $url?>/img/sub_banner1.jpg?>"); justify-content: center; align-items: center; color:white; font-weight: bold; font-size:120%;'>
           
        </div>
        <div class="col-sm-6 bibliography_box">
            <h2>Análise Prova-Piloto.</h2>
            <p>A EKOS preparou para ti a análise da prova-piloto, para te ajudar a orientar o estudo!</p>
            <button class='btn btn-black' style='margin-top:20px; width: 150px; color: #152335' onClick='window.location.href="<?= $this->Url->build(["prefix" => false, "controller" => 'analise-pp.pdf']); ?>"'>VER ANÁLISE</button>
        </div>
    </div>
</section>

<section id="management" class="text-center">
    <div class="container">
        <div class="row" style='margin-bottom:40px'>
            <div class="col-md-8 col-md-offset-2">
                <h1>Desenvolvimento Pessoal.</h1>
                <p>Um curso dirigido ao desenvolvimento de <b>competências e técnicas</b> úteis para a organização de tarefas e de tempo, que tem como objetivo <b>potenciar a gestão do teu estudo</b> e valorizar o teu percurso profissional. 
                </p>
                <p class='small download' style='display:none;'>
                    <a href='/programa_integrado.pdf' target="_blank">    <i class="fa fa-download"></i> Temas do Curso de Verão 
                    </a>
                </p>
                <p><?= $this->Form->intpu('city', ['type' => 'select', 'options' => $cities2, 'style' => 'font-size: 12pt; margin-top:20px; display:none;', 'value' => $scity, 'id' => 'city_selector'])?>
                </p>
            </div>
        </div>
        <div class='row'>
            <div class='col-md-10 col-md-offset-1'>
                <table class='courses-list'>
                    <?php $aux = $coursesLen; ?>
                    <?php foreach ($courses3 as $key => $value) : ?>
                        <tr class='primary' id="t<?= $key?>">
                            <td><?= $value ?></td>
                            <td>
                                <span class='small' style='color: #FEB000'>
                                <?php 
                                  $e = '';
                                  foreach ($manage['groups'] as $key2 => $group):
                                    if(@in_array($group['id'], $inscriptions)) $e = "INSCRITO"; 
                                    elseif($group['inscriptions_open'] == 1) $e = 'Inscrições Abertas';
                                  endforeach;
                                  echo $e;
                                ?> 
                                </span>
                            </td>
                            <td width='50px'><i class="fa fa-chevron-down" id='arrow_t<?= $key?>'></i>
                            </td>
                        </tr>
                        <tr>
                            <td colspan='3' style='padding:0; background-color: #f5f5f5'>
                                <div class='dependency dt<?= $key?> closed'>
                                    <!---VERIFICA SE EXISTEM TURMAS -->
                                    <?php if(count($manage['groups']) > 0): ?>
                                    <div class="panel with-nav-tabs panel-default" style='background:transparent'>
                                        <div>
                                            <ul class="nav nav-tabs">
                                                <?php foreach ($manage['groups'] as $key2 => $group): ?>
                                                <li <?= $key2 == 0 ? "class='active'" : "" ?>><a href="#turma<?=$key.$group['id']?>" data-toggle="tab"><?= $group['name']?></a></li>
                                                <?php endforeach; ?>
                                            </ul>
                                        </div>
                                        <div class="panel-body">
                                            <div class="tab-content">
                                                <?php foreach ($manage['groups'] as $key2 => $group): 
                                                  $min_date = new DateTime('2040-12-31');
                                                  $max_date = new DateTime('1994-12-31');
                                                  foreach ($group['lectures'] as $lecture):
                                                      if($lecture['datetime'] && $lecture['description'] == $value):
                                                        if($lecture['datetime']->format("Y-m-d") < $min_date->format("Y-m-d")) 
                                                          $min_date = $lecture['datetime'];
                                                        if($lecture['datetime']->format("Y-m-d") > $max_date->format("Y-m-d"))
                                                          $max_date = $lecture['datetime'];
                                                      endif;
                                                  endforeach; ?>
                                                  <div class="tab-pane fade in <?= $key2 == 0 ? "active" : "" ?>" id="turma<?=$key.$group['id']?>">
                                                      <table style='width: 100%;'>
                                                          <tr style='border-bottom: 1px solid #666'>
                                                              <td valign='middle'>
                                                                  <span style='position: relative; top: 7px'>
                                                                      <?= $min_date != new DateTime('2040-12-31') && $max_date != new DateTime('1994-12-31') ?$min_date->i18nFormat('dd.MM.yyyy')." - ".$max_date->i18nFormat('dd.MM.yyyy') : ""?>    
                                                                  </span> 
                                                                  <span style='position: relative; top: 7px; left: 20px; font-weight: 600'> 
                                                                      <?= $manage['price'] ? $manage['price']. " €" : ''?> 
                                                                  </span> 
                                                                  <?php if(@$count[$group['id']] >= $group['vacancy'] && $group['inscriptions_open'] == 1) echo "<span style='position: relative; top: 7px; left: 40px; font-weight: 400; color:red'> Esgotado</span>"; ?>
                                                              </td>
                                                              <td width='100px'> 
                                                                  <?php if (@in_array($group['id'], $inscriptions)) 
                                                                      echo "<span style='position: relative; top: 7px; right: 10px;'>Inscrito</span>";
                                                                    elseif (@$count[$group['id']] >= $group['vacancy'] && $group['inscriptions_open'] == 1 && isset($Auth['id'])) {
                                                                      if(!in_array($group['id'], $waiting)){ echo  '<button class="btn btn-black" style="margin: 0; padding: 10px 30px; float: right" onClick="window.location.href = \''.$this->Url->build(["controller" => 'reserved', 'action' => 'waiting', $group['id']]).'\'">Lista de Espera</button>';}}
                                                                    elseif (@$count[$group['id']] >= $group['vacancy'] && $group['inscriptions_open'] == 1 && !isset($Auth['id'])) echo '<button class="btn btn-black" style="margin: 0; padding: 10px 30px; float: right" data-toggle="modal" data-target="#login" >Lista de Espera</button>';
                                                                    elseif ($group['inscriptions_open'] == 1 && isset($Auth['id'])) echo '<button class="btn btn-black" style="margin: 0; padding: 10px 30px; float: right" onClick="window.location.href = \''.$this->Url->build(["controller" => 'reserved', 'action' => 'inscription', $group['id']]).'\'">INSCREVER</button>';
                                                                    elseif ($group['inscriptions_open'] == 1 && !isset($Auth['id'])) echo '<button class="btn btn-black" style="margin: 0; padding: 10px 30px; float: right" data-toggle="modal" data-target="#login" >INSCREVER</button>';
                                                                  ?>  
                                                              </td>
                                                          </tr>
                                                          <?php foreach ($group['lectures'] as $lecture): ?>
                                                              <?php if ($lecture['description'] == $value): ?>
                                                                  <tr class='class-list'>
                                                                      <td colspan='2'>
                                                                          <span class='class-name'> 
                                                                              <?php 
                                                                                $themes_ =  explode(',', $lecture['themes']);
                                                                                if($lecture['themes'] != ''){
                                                                                  foreach($themes_ as $key3 => $value2):
                                                                                  $themes_[$key3] = $themes[$value2];
                                                                                  endforeach;
                                                                                  $lecture['description'] = implode(' | ', $themes_);
                                                                                }
                                                                                echo $lecture['description']; ?>
                                                                          </span>
                                                                          <span style='margin-right: 25px'><?= $lecture->has('datetime') ?$lecture['datetime']->i18nFormat('dd.MM.yyyy') : '' ?>
                                                                          </span>
                                                                          <span style='margin-right: 25px'><?= $lecture->has('datetime') ? $lecture['datetime']->i18nFormat('HH')."h" : '' ?><?= $lecture->has('datetime') ? $lecture['datetime']->i18nFormat('mm'): '' ?> 
                                                                          </span>
                                                                          <!--<span style='margin-right: 25px'><?= $lecture['user']['first_name']." ".$lecture['user']['last_name']?></span>-->
                                                                          <?php if(in_array($summer['id'], $inscriptions_courses)): ?>
                                                                            <span style='margin-right: 25px'><?= $lecture['place'] ?></span>
                                                                          <?php endif; ?>
                                                                      </td>
                                                                  </tr>
                                                              <?php endif; ?>
                                                          <?php endforeach;?>
                                                      </table>
                                                  </div>
                                                <?php endforeach; ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>    
                                    <!---SE NÃO EXISTEM TURMAS -->
                                    <?php else: ?>
                                        <table style='width: 100%;'>
                                            <tr style='border-bottom: 1px solid #666; border-top: 1px solid #666;'>
                                                <td colspan='3' valign='middle' style='text-align: center'> 
                                                    <span style='font-weight: 600'> <?= $manage['price'] ? $manage['price']. " € | " : '' ?> </span> 
                                                    <span style='font-style: italic'><small>Datas a definir</small></span>
                                                </td>
                                            </tr>
                                            <?php foreach ($manage['themes'] as $theme_): ?>
                                                <tr class='class-list'>
                                                    <td colspan='2'>
                                                        <span class='class-name'> <?= $theme_['name'] ?></span>
                                                    </td>
                                                </tr>
                                            <?php endforeach ?>
                                        </table>
                                     
                                    <?php endif; ?>
                  
                        </div>
                    <?php endforeach; ?>
                </table>
            </div>
        </div>
    </div>
</section>



<style>
#intro h1{
  text-align:center;
}
#services h1{
  text-align:center;
}
.download{
  margin-top: 30px;
}
#summer .dependency{
  background-color: white;
}
#summer .panel tbody tr:first-child{
  background-color: #F5F5F5;
}
#summer .panel .nav-tabs{
  background-color: #F5F5F5;
}
#management .courses-list tr td .dependency{
  background-color: #F5F5F5;
}
section .col-md-8 .btn-black{
  margin: 0; 
  padding: 10px 30px; 
  float: center;
}
section .col-md-8 > span.small{
  color: #FEB000;
  font-size: 1.2em;
  margin-right: 15px;
}
section tr td span.small{
  color: #FEB000;
}
section .tab-pane table td .btn-black{
  margin: 0; 
  padding: 10px 30px; 
  float: right;
} 

</style>

<script>
$('.primary').on('click', function(){
  id = $(this).attr('id');
  if($('.dependency.d'+id).hasClass('closed')){
    $('.dependency').addClass('closed');
    $('.fa-chevron-up').removeClass('fa-chevron-up').addClass('fa-chevron-down');
    $('.dependency.d'+id).removeClass('closed');
    $('#arrow_'+id).removeClass('fa-chevron-down').addClass('fa-chevron-up');
    console.log("if there were........");
  } else {
    $('.dependency').addClass('closed');
    $('#arrow_'+id).removeClass('fa-chevron-up').addClass('fa-chevron-down');
  }
  
})

<?php if(isset($_GET['c'])): ?>
  $('.dependency.d<?= $_GET['c'] ?>').removeClass('closed');
  $('#arrow_<?= $_GET['c'] ?>').removeClass('fa-chevron-down').addClass('fa-chevron-up');
  $("#arrow_<?= $_GET['c']?>").get(0).scrollIntoView();

  setTimeout(function(){$('html, body').animate({
                      scrollTop: $("#arrow_<?= $_GET['c']?>").offset().top-100
                  }, 500)}, 500);
<?php endif;?>
</script>