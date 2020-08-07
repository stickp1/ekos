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
                              <?php if(in_array(16, $courses) || in_array(15, $courses)): ?> <li <?=  @$this->request->params['action'] == 'ebank' ? 'class="active"': ''?>><a href="<?= $this->Url->build(["prefix" => false, "controller" => 'reserved', "action" => "ebank"]) ?>">Exames</a></li> <?php endif; ?>
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
                    <?php if($user['groups'] == 0): ?>
                     <p>Ainda não te encontras inscrito em nenhum curso.</p>  
                    <?php else: ?> 
                        <?php $groups_ = array(); ?>
                        <?php foreach ($user['groups'] as $key => $value): ?>
                            <?php $groups_[$key] = $this->Html->link($value['course']['name'], ['action' => 'forum', $value['id']]); ?>
                            <?php if(@$group['id'] == $value['id']) $groups_[$key] = '<b>'.$groups_[$key].'</b>'; ?>      
                        <?php endforeach ?>
                            <?php echo implode(' | ', $groups_); ?>
                    <?php endif ?>

                </p>
                <br>
                <br>
            </div>
            <div class='col-md-10 col-md-offset-1'>
               
                <table class='courses-list'>
                  
                    <?php if($user['groups']): ?>
                        
                        <?php foreach ($group['lectures'] as $key => $lecture): ?>
                            
                            <?php $themes_ = explode(',', $lecture['themes']); ?>
                            
                            <?php if($lecture['themes'] != ''): ?>
                                
                                <?php foreach ($themes_ as $theme_id): ?>
                                    
                                    <tr class='primary' id="<?= $theme_id?>" >
                                        <td>
                                            <?= $themes[$theme_id]['name'] ?>
                                        </td>
                                        <td> 
                                            <span class='small' style='color: #FEB000'>
                                                <?= $lecture['description'] ?>
                                            </span>
                                        </td>
                                        <td width='50px'>
                                            <i class="fa fa-chevron-down" id='arrow_<?= $theme_id?>'>
                                            </i>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan='3' style='padding:0; background-color: #f5f5f5'>
                                            <div class='dependency d<?= $theme_id?> closed'>
                                                <table class="messageList">
                                                    <?php foreach($messages as $key => $message): ?>
                                                        <tr>
                                                            <td>
                                                                <a href="#">
                                                                  <?= $message['content'] ?>
                                                                </a>
                                                            </td>
                                                            <td>
                                                                <?= count($message['children']) ?>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <span>Última publicação por zé . há 7 horas</span> 
                                                            </td> 
                                                            <td>
                                                                <span>respostas</span>
                                                            </td>
                                                        </tr>
                                                    <?php endforeach ?>
                                                </table>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach ?>

                            <?php else: ?>
                  
                                <tr class='primary' id="<?= $lecture['id']?>" >
                                    <td><span><?= $lecture['description']?></span></td>
                                    <td> </td>
                                    <td width='50px'><i class="fa fa-chevron-down" id='arrow_<?= $lecture['id']?>'></i></td>
                                </tr>
                                <tr>
                                    <td colspan='3' style='padding:0; background-color: #f5f5f5'>
                                        <div class='dependency d<?= $lecture['id']?> closed'>
                                            <table style='width: 100%;'>
                                                <tr class='class-list' style='border-top: 1px solid #152335; border-bottom: 1px solid #152335'>
                                                    <td colspan='2'>
                                                        <span style='margin-right: 25px'><?= $lecture->has('datetime') ? $lecture['datetime']->i18nFormat('dd.MM.yyyy') : '' ?></span>
                                                        <span style='margin-right: 25px'><?= $lecture->has('datetime') ? $lecture['datetime']->i18nFormat('HH')."h" : '' ?><?= $lecture->has('datetime') ? $lecture['datetime']->i18nFormat('mm'): '' ?></span>
                                                        <span style='margin-right: 25px'><?= $lecture['user']['first_name']." ".$lecture['user']['last_name']?></span><span style='margin-right: 25px'><?= $lecture['place']?></span>
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                    </td>
                                </tr>

                            <?php endif ?>
                       
                        <?php endforeach ?>
                    
                    <?php endif;?>
                             
                </table> 

            </div>
            <button class='btn btn-black' onClick="window.location.href='<?= $this->Url->build(["prefix" => false, "controller" => "Users", "action" => "logout"]) ?>'" >LOGOUT
            </button>
        </div>
    </div>
</section>

<style>
table.courses-list tr td:nth-child(2){
  width: 100px;
  text-align: right;
}
#services {
    padding-bottom: 180px;
}
table.messageList{
    width: 90%; 
    margin: auto; 
    border: 1px solid black;

    border-collapse: unset;
    margin-bottom: 10px;
}
table.messageList tr:nth-child(even){
    border-bottom: 1px solid black;
}
table.messageList td{
    padding: 10px;
}
table.messageList td span{
    font-size:12px;
}
table.messageList tr:nth-child(odd) td{
    padding-bottom: 0;
}
table.messageList tr:nth-child(even) td{
    padding-top: 0;
    padding-bottom: 0;
}
table.messageList tr td:last-child{
    text-align: center;
}
table.messageList tr:last-child{
    border-bottom: none;
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
  } else {
    $('.dependency').addClass('closed');
    $('#arrow_'+id).removeClass('fa-chevron-up').addClass('fa-chevron-down');
  }
  
})



</script>


