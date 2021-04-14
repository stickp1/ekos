<?php $url = $this->Url->build(["prefix" => false, "controller" => '/'], true); ?>

<section id="services" class="text-center ">
    <div class="container">
        <div class="row">
            <div class="col-md-20">
              <div class="panel with-nav-tabs panel-default" style='background:transparent'>
                  <div class="panel-heading">
                          <ul class="nav nav-tabs" id='submenu'>
                              <li <?=  @$this->request->params['action'] == 'index' ? 'class="active"': ''?>><a href="<?= $this->Url->build(["prefix" => false, "controller" => 'reserved', "action" => "index"]) ?>">Cursos</a></li>
                              <li <?=  @$this->request->params['action'] == 'qbank' ? 'class="active"': ''?>><a href="<?= $this->Url->build(["prefix" => false, "controller" => 'reserved', "action" => "qbank"]) ?>">Perguntas</a></li>
                              <li <?=  @$this->request->params['action'] == 'fbank' ? 'class="active"': ''?>><a href="<?= $this->Url->build(["prefix" => false, "controller" => 'reserved', "action" => "fbank"]) ?>">Flashcards</a></li>
                              <li <?=  @$this->request->params['action'] == 'forum' ? 'class="active"': ''?>><a href="<?= $this->Url->build(["prefix" => false, "controller" => 'reserved', "action" => "forum"]) ?>">Dúvidas</a></li>
                              <?php if($isStudio): ?> <li <?=  @$this->request->params['action'] == 'videobank' ? 'class="active"': ''?>><a href="<?= $this->Url->build(["prefix" => false, "controller" => 'reserved', "action" => "videobank"]) ?>">Vídeos</a></li> <?php endif; ?>
                              <?php if(in_array(16, $courses) || in_array(15, $courses) || in_array(1, $courses)): ?> <li <?=  @$this->request->params['action'] == 'ebank' ? 'class="active"': ''?>><a href="<?= $this->Url->build(["prefix" => false, "controller" => 'reserved', "action" => "ebank"]) ?>">Exames</a></li> <?php endif; ?>
                              <li <?=  @$this->request->params['action'] == 'payments' ? 'class="active"': ''?>><a href="<?= $this->Url->build(["prefix" => false, "controller" => 'reserved', "action" => "payments"]) ?>">Pagamentos</a></li>
                          </ul>
                  </div>
              </div>
            </div>
        </div>
        <div class="row" style='position:relative'>
            <div class="reserved-background"></div>
            <div class="col-md-10 col-md-offset-1" style='padding-top: 75px'>
                <h1>Olá <?= $Auth['first_name']; ?>!</h1>
                <p><label> a frequentar</label><br>
                    <?php if($user['groups'] == 0) echo "Ainda não te encontras inscrito em nenhum curso."; 
                        else 
                        {
                          $groups_ = array();
                          foreach ($user['groups'] as $key => $value) {
                            $groups_[$key] = $this->Html->link($value['course']['name'], ['action' => 'index', $value['id']]);
                            if(@$group['id'] == $value['id']) {
                              $groups_[$key] = '<b>'.$groups_[$key].'</b>';
                            }
                          }
                          echo implode(' | ', $groups_);
                          echo "<p class='small' style='margin-top: 30px'><a href='".$this->Url->build(["prefix" => false, "controller" => "reserved", "action" => "schedule", $group['id'].".pdf"])."' target='_blank'> <i class='fa fa-download'></i> Calendário de Aulas </a></p>";
                        } 
                    ?>
                </p>
                <br>
                <br>
            </div>
            <div class='col-md-10 col-md-offset-1'>
                <table class='courses-list'>
                  
                    <?php if($user['groups']): foreach ($group['lectures'] as $key => $value) {
                        $themes_ = explode(',', $value['themes']);
                        if($value['themes'] != ''):
                        foreach ($themes_ as $value2) {
                    ?>
                  
                    <tr class='primary' id="<?= $value2?>" >
                        <td><?= $themes[$value2]['name'] ?>   <span class='small'><?= isset($surveys[$value['id']]) ? '<a href="'.$this->Url->build(["controller" => "frontend", "action" => "feedback", $surveys[$value['id']]]).'"><i class="fa fa-exclamation-triangle"></i></a>':''?></span></td>
                        <td> <span class='small' style='color: #FEB000'><?= $value['description'] ?></span></td>
                        <td width='50px'><i class="fa fa-chevron-down" id='arrow_<?= $value2?>'></i></td>
                    </tr>
                    <tr>
                        <td colspan='3' style='padding:0; background-color: #f5f5f5'>
                            <div class='dependency d<?= $value2?> closed'>
                                <table style='width: 100%;'>
                                    <tr class='class-list' style='border-top: 1px solid #152335; border-bottom: 1px solid #152335'>
                                        <td colspan='2'>
                                            <span style='margin-right: 25px'><?= $value->has('datetime') ?$value['datetime']->i18nFormat('dd.MM.yyyy') : '' ?></span>
                                            <span style='margin-right: 25px'><?= $value->has('datetime') ? $value['datetime']->i18nFormat('HH')."h" : '' ?><?= $value->has('datetime') ? $value['datetime']->i18nFormat('mm'): '' ?> 
                                              </span><span style='margin-right: 25px'><?= $value['user']['first_name']." ".$value['user']['last_name']?></span><span style='margin-right: 25px'><?= $value['place']?></span>
                                        </td>
                                    </tr>
                                    <?php if(count($themes[$value2]['uploads']) > 0) {
                                        foreach ($themes[$value2]['uploads'] as $value3) { 
                                    ?>
                                    <tr>
                                        <td style='padding: 5px 5px 5px 30px'><span class='small'> <?= $this->Html->link('<i class="fa fa-download" style="margin-right:10px;"></i>'.$value3['name'], ['action' => 'file', $value3['id'], $value3['name']], ['escape' => false, 'target' => '_blank']) ?> </span></td>
                                    </tr>
                                    <?php } } else { ?>
                                    <tr>
                                        <td style='padding: 5px 5px 5px 30px'><span class='small'><em>Sem ficheiros para descarregar.</em></span></td>
                                    </tr>
                                    <?php } ?>
                                </table>
                            </div>
                        </td>
                    </tr>
                  
                    <?php } else: ?>
                  
                    <tr class='primary' id="<?= $value['id']?>" >
                        <td><span><?= $value['description']?></span></td>
                        <td> </td>
                        <td width='50px'><i class="fa fa-chevron-down" id='arrow_<?= $value['id']?>'></i></td>
                    </tr>
                    <tr>
                        <td colspan='3' style='padding:0; background-color: #f5f5f5'>
                            <div class='dependency d<?= $value['id']?> closed'>
                                <table style='width: 100%;'>
                                    <tr class='class-list' style='border-top: 1px solid #152335; border-bottom: 1px solid #152335'>
                                        <td colspan='2'>
                                            <span style='margin-right: 25px'><?= $value->has('datetime') ?$value['datetime']->i18nFormat('dd.MM.yyyy') : '' ?></span>
                                            <span style='margin-right: 25px'><?= $value->has('datetime') ? $value['datetime']->i18nFormat('HH')."h" : '' ?><?= $value->has('datetime') ? $value['datetime']->i18nFormat('mm'): '' ?></span>
                                            <span style='margin-right: 25px'><?= $value['user']['first_name']." ".$value['user']['last_name']?></span><span style='margin-right: 25px'><?= $value['place']?></span>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </td>
                    </tr>

                    <?php endif; } endif;?>
                  
                </table> 
            </div>
            <button class='btn btn-black' onClick="window.location.href='<?= $this->Url->build(["prefix" => false, "controller" => "Users", "action" => "logout"]) ?>'" >LOGOUT
            </button>
        </div>
    </div>
</section>

<link rel="stylesheet" href="<?= $url; ?>/css/toastr.css">
<style>
table.courses-list tr td:nth-child(2){
  width: 100px;
  text-align: right;
}

</style>

<script src="<?= $url; ?>/js/toastr.js"></script>
<script>
$('.primary').on('click', function(){
  id = $(this).attr('id');
  if($('.dependency.d'+id).hasClass('closed')){
    $('.dependency').addClass('closed');
    $('.fa-chevron-up').removeClass('fa-chevron-up').addClass('fa-chevron-down');
    $('.dependency.d'+id).removeClass('closed');
    $('#arrow_'+id).removeClass('fa-chevron-down').addClass('fa-chevron-up');
  } else {
    $('.dependency').addClass('closed');
    $('#arrow_'+id).removeClass('fa-chevron-up').addClass('fa-chevron-down');
  }
  
})



toastr.options = {
  "closeButton": true,
  "debug": false,
  "newestOnTop": false,
  "progressBar": false,
  "positionClass": "toast-top-right",
  "preventDuplicates": false,
  "onclick": null,
  "showDuration": "300",
  "hideDuration": "1000",
  "timeOut": "0",
  "extendedTimeOut": "0",
  "showEasing": "swing",
  "hideEasing": "linear",
  "showMethod": "fadeIn",
  "hideMethod": "fadeOut"
};


<?php foreach ($notifications as $notification) { ?>
  toastr["warning"]("<?=$notification['value'] ?>", "Atenção");
<?php } ?>

</script>


