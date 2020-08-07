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
            <div id="themeTable" class='col-md-10 col-md-offset-1'>
                <table class='courses-list'>              
                    <?php if($user['groups']): ?>
                        <?php foreach ($group['lectures'] as $key => $lecture): ?>
                            <?php $themes_ = explode(',', $lecture['themes']); ?>
                            <?php if($lecture['themes'] != ''): ?>
                                <?php foreach ($themes_ as $theme_id): ?>
                                    <tr class='primary' id="<?= $theme_id ?>" >
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
                                    <tr class="messageList" id="t<?= $theme_id ?>">
                                        <td colspan='3' style='padding:0; background-color: #f5f5f5'>
                                            <div class='dependency d<?= $theme_id?> closed'>
                                                <?php if(array_key_exists($theme_id, $messages)): ?>
                                                    <table class="messageList">
                                                        <?php foreach($messages[$theme_id] as $key => $message): ?>
                                                            <tr>
                                                                <td>
                                                                    <input type="hidden" name="message" value="<?= $message['message'] ?>">
                                                                    <input type="hidden" name="user" value="<?= $message['user'] ?>">
                                                                    <input type="hidden" name="date" value="<?= $message['date_last']->timeAgoInWords() ?>">
                                                                    <input type="hidden" name="upvotes" value="<?= $message['upvotes'] ?>">
                                                                    <a href="#" class="messageToggle" id="message<?= $message['id'] ?>">
                                                                      <?= $message['title'] ?>
                                                                    </a>
                                                                </td>
                                                                <td>
                                                                    <?= $message['children'] ?>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>
                                                                    <span>Última publicação por <?= $message['user'] ?> · <?= $message['date_last']->timeAgoInWords() ?></span> 
                                                                </td> 
                                                                <td>
                                                                    <span>respostas</span>
                                                                </td>
                                                            </tr>
                                                        <?php endforeach ?>
                                                    </table>
                                                <?php endif ?>
                                                <button class="btn btn-black newMessage">Nova dúvida</button>
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
                    <?php endif ?>
                </table> 
            </div>
            <div class="col-xs-2 closeReplies" id="backArrow">
                <button><i class="fa fa-arrow-left"></i></button>
            </div>
            <?php if($replyPermission): ?>
                <div id="replyList" tabindex='-1' class='col-md-8 col-xs-10' style="display: none">
                    <div id="tempReplies"></div>
                    <textarea id="replyMessage" name="replyMessage"></textarea>
                    <button class="btn btn-black submitReplyMessage">Submeter resposta</button>
                </div>
            <?php endif ?>
            <button class='btn btn-black' id="logout" onClick="window.location.href='<?= $this->Url->build(["prefix" => false, "controller" => "Users", "action" => "logout"]) ?>'" >LOGOUT
            </button>
        </div>
    </div>
</section>

<div class="modal fade" id="newMessage">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h1 class="modal-title text-center">Nova mensagem</h1>
            </div>
            <div class="modal-body">
                <?= $this->Form->create('Form', ['url' => ['controller' => 'reserved', 'action' => 'messageCreate'], 'id' => 'message-form']) ?>
                    <div id="textDiv">
                        <input type="hidden" name="newTheme">
                        <textarea rows=2 name="newTitle" placeholder="Introduz aqui a tua dúvida resumidamente"></textarea>
                        <textarea id="newMessage" rows=5 name="newMessage" placeholder="Explicita aqui o contexto ou detalhes da tua dúvida" required></textarea>
                    </div>
                    <div class="modal-footer row">
                        <div id="report-captcha" class="g-recaptcha col-sm-6 col-xs-12" data-sitekey="6LdAL20UAAAAAJOZy5YPgXQR_u26zrk1Y8hEfuM2" style='display: none'>
                        </div>
                        <div class="col-sm-6 col-sm-offset-6 col-xs-12 text-sm-right text-center">
                            <button type="submit" class="btn btn-black submitNewMessage">Submeter</button>
                        </div> 
                    </div>
                <?= $this->Form->end() ?>
            </div>
            
        </div>
    </div>
</div>

<style>
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
.btn.btn-black.newMessage{
    position: absolute;
    bottom: -80px;
    right: 0;
    left: 0;
    margin: auto;
}
.messageList input, .messageList textarea{
    display: block;
    width: 90%;
    margin-left: auto;
    margin-right: auto;
    margin-top: 10px;
}
.messageList input#newTitle{
    margin-top: 30px;
}
.dependency{
    padding-bottom: 100px;
}
.dependency.closed{
    padding-bottom: 0;
}
.messageList .btn.btn-black{
    bottom: 25px;
    background: #FEB000;
    color: #f5f5f5;
    /*display: none;*/
}
#replyList{
    outline: none !important;
}
#replyList #tempReplies div.well{
    width: 500px;
    border: 1px solid #152335;
    padding: 10px;
    margin-right: auto;
    margin-left: auto;
    margin-bottom: 20px;
    font-size: 12pt;
}
#replyList #tempReplies div.well div:first-child{
    font-size: 16pt;
    margin-bottom: 20px;
}
#replyList #tempReplies div.well span{
    float: left;
}
#replyList #tempReplies div.well div:last-child{
    text-align: justify;
    margin-top: 20px;
}
#replyList #tempReplies div.well hr{
    margin: 0 0 10px 0;
    border: 0.5px solid #00000021;
}
#replyList textarea{
    width: 500px;
    border-radius: 10px;
    margin-top: 20px;
}
#replyList .submitReplyMessage{
    width: 150px;
    padding: 10px 0 10px 0;
    bottom: -60px;
    position: absolute;
    right: 0;
    left: 0;
    margin: auto;
}
div#themeTable{
    -moz-transition: all 1s ease-out;
    -webkit-transition: all 1s ease-out;
    -o-transition: all 1s ease-out;
    transition: all 1s ease-out;
    position: relative;
}
#newMessage textarea{
    width: 100%;
    margin: 10px 0 20px 0;
    resize: none;
    font-size: 13pt;
    padding: 5px;
}
#newMessage .modal-footer .btn-black{
    margin-top: 0;
}
#newMessage #textDiv{
    margin-left: 15px;
    margin-right: 15px;
}
#newMessage .modal-header{
    padding-left: 45px;
    padding-right: 45px;
}
#newMessage .g-recaptcha iframe{
    padding-left: 0;
    padding-right: 0;
}
@media (min-width: 768px){
    #newMessage .modal-footer .captcha-push{
        float: none;
        display: table-cell;
        vertical-align: bottom;
    }
}
@media (max-width: 767px){
    #newMessage .modal-footer{
        padding: 0;
    }
    #newMessage .modal-footer .col-sm-offset-6{
        margin-top: 10px;
    }
    #newMessage .modal-footer .g-recaptcha{
        margin-top:15px;
        padding: 0;
    }
    #newMessage .modal-footer .g-recaptcha div{
        margin: auto;
        margin-bottom: 15px;
    }
}
#backArrow i:hover{
    color: #FEB000;
}
#backArrow{
    display: none;
}
#backArrow button{
    height: 50px;
    width: 50px;
}
.fa-thumbs-up{
    float: right;
    margin-right: 10px;
    color: #00000021;
}
.fa-thumbs-up:hover{
    color: #FEB000;
}
.fa-thumbs-up.upvoted{
    color: #FEB000;
}
#replyList #tempReplies div.well span.upvotes{
    float: right;
    font-weight: bold;
    color: #00000021;
    margin-top: -10px;
    margin-right: 10px;
    width: 15px;
    text-align: center;
}

</style>

<script src="<?= $url; ?>/bower_components/ckeditor/ckeditor.js"></script>
<script>

messageId = 0;
themeId = 0;
childFocus = false;
breakpoint = 974;
smallScreen = window.innerWidth <= breakpoint;

setTimeout(function(){
  $('.message.success').hide();  
  $('#mainNav').addClass('flash_timeout');
}, 5000);

function repliesTemplate(messageId){
    var replies = "<div id='" + messageId + "' class='well well-sm'>" +
        "<div></div>" +
        "<span></span>" +
        "<span></span>" +
        "<i class='fa fa-thumbs-up'></i><br><hr>" +
        "<span class='upvotes'></span>" +
        "<div></div>" +
        "</div>";
    return replies;
}

function closeReplies(){
    $('#backArrow').hide();
    $('#replyList').hide();
    $('#themeTable').addClass('col-md-10').addClass('col-md-offset-1').removeClass('col-md-4');
}

function displayStyle(){
    if($('#replyList').is(':visible')) {
        if($(this).width() > breakpoint) {
            $('#themeTable').show();
            $('#backArrow').hide();
            smallScreen = false   
        } else {
            smallScreen = true;
            $('#themeTable').hide(); 
            $('#backArrow').show();
        }
    }
}

$('#tempReplies').on('click', '.fa-thumbs-up', function () {
    console.log($(this));
    console.log($(this).siblings('.upvotes').text());
    console.log($(this).siblings('.upvotes').text() + 1);
    $(this).siblings('.upvotes').text(
        (isNaN(parseInt($(this).siblings('.upvotes').text())) ?
        0 : parseInt($(this).siblings('.upvotes').text())) + 1);
    $(this).addClass('upvoted');
    $.post( "<?= $url?>/reserved/message-upvote", { 
        id: $(this).parents('div.well').attr('id'),
    });
});

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
});

$('.messageToggle').on('click', function(){
    event.preventDefault();
    messageId = $(this).attr('id').match(/\d+/g);
    themeId = $(this).parents('tr.messageList').attr('id').match(/\d+/g);
    title = $(this).text();
    message = $(this).siblings('input[name="message"]').val();
    user = $(this).siblings('input[name="user"]').val();
    date = $(this).siblings('input[name="date"]').val();
    upvotes = $(this).siblings('input[name="upvotes"]').val();
    $("#logout").hide();
    if(window.innerWidth > breakpoint) {
        $('#themeTable').removeClass('col-md-10')
            .removeClass('col-md-offset-1')
            .addClass('col-md-4');
    } else {
        $("#themeTable").toggle(1000)
            .removeClass('col-md-10')
            .removeClass('col-md-offset-1')
            .addClass('col-md-4');
        $('#backArrow').show();
    }
    $.post( "<?= $url?>/reserved/message-get", { 
        parent: messageId[0] 
    }).done(function(data) {
        $('#replyList #tempReplies').empty();
        $('#replyList #tempReplies').append(repliesTemplate(messageId));
        $('#replyList #tempReplies div.well div:first-child').text(title);
        $('#replyList #tempReplies div.well div:last-child').text(message);
        $('#replyList #tempReplies div.well span:nth-child(2)').text(user);
        $('#replyList #tempReplies div.well span:nth-child(3)').html('&nbsp·&nbsp' + date);
        $('#replyList #tempReplies div.well span.upvotes').text(upvotes);

        $.each(JSON.parse(data), function(index, value){
            $('#replyList #tempReplies').append(repliesTemplate(value['id']));
            $('#replyList #tempReplies div.well:last-child div:first-child').text(value['title']);
            $('#replyList #tempReplies div.well:last-child div:last-child').text(value['message']);
            $('#replyList #tempReplies div.well:last-child span:nth-child(2)').text(value['user']);
            $('#replyList #tempReplies div.well:last-child span:nth-child(3)').html('&nbsp·&nbsp' + value['date_created']);
            $('#replyList #tempReplies div.well:last-child span.upvotes').text(value['upvotes']);
        });
        $('#replyList').show();
        $('#replyList').focus();
    });
});

$('#replyList').on('focusout', function(){
    if(!childFocus && !smallScreen)
        closeReplies();
    else {
        childFocus = false;
    }
})

$('#replyList textarea, #replyList button').on('mousedown', function(e){
    console.log('mousedowning child');
    childFocus = true;
})

$('.closeReplies').on('click', function(){
    console.log('yo');
    $('#backArrow').hide();
    $('#replyList').hide();
    $('#themeTable').addClass('col-md-10').addClass('col-md-offset-1').removeClass('col-md-4');
    $('#themeTable').show();
    $('#logout').show();
})

$('.newMessage').on('click', function(){
    $('#newMessage input[name="newTheme"]').val($(this).parents('.messageList').attr('id').match(/\d+/g));
    setTimeout(function(){ 
        $("#newMessage").modal('show'); 
    }, 500);
})

$('.submitNewMessage').on('click', function(){
    event.preventDefault();
    theme_id = $('input[name="newTheme"]').val();
    title = $('textarea[name="newTitle"]').val();
    message = $('textarea[name="newMessage"]').val();
    console.log(theme_id);
    console.log(title);
    console.log(message);
    $.post( "<?= $url?>/reserved/message-create", { 
        theme_id: theme_id,
        title: title,
        message: message
    }).done(function(data) {
        location.reload();
    });
})

$('.submitReplyMessage').on('click', function(){
    message = $(this).siblings('#replyList textarea').val();
    console.log(themeId[0]);
    console.log(messageId[0]);
    console.log(message);
    $.post( "<?= $url?>/reserved/message-create", { 
        theme_id: themeId[0],
        parent: messageId[0],
        message: message
    }).done(function(data) {
        location.reload();
    });
})

$(window).resize(displayStyle);

</script>


