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
                    <?php if($user['groups']): ?>
                        <?php $groups_ = array(); ?>
                        <?php foreach ($user['groups'] as $key => $value): ?>
                            <?php $groups_[$key] = $this->Html->link($value['course']['name'], ['action' => 'forum', $value['courses_id']]); ?>
                            <?php if(@$group['id'] == $value['id']) $groups_[$key] = '<b>'.$groups_[$key].'</b>'; ?>      
                        <?php endforeach ?>
                            <?php echo implode(' | ', $groups_); ?>
                    <?php else: ?> 
                        <p>Ainda não te encontras inscrito em nenhum curso.</p>  
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
                                    <tr id="t<?= $theme_id ?>">
                                        <td colspan='3' style='padding:0; background-color: #f5f5f5'>
                                            <div class='dependency closed' id='d<?= $theme_id?>'>
                                                <?php if(isset($messages[$theme_id])): ?>
                                                    <?php $pageNr = ceil(count($messages[$theme_id]) / $maxPerPage); ?>
                                                    <input type="hidden" class="pageInfo" id="<?= $pageNr ?>" value=1>
                                                    <table class="messageList">
                                                        <?php foreach($messages[$theme_id] as $key => $message): ?>
                                                            <?php if($key == $maxPerPage) break ?>
                                                            <tr>
                                                                <td>
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
                                                                    <span>Last post by <?= $message['user'] ?> · <?= $message['date_last']->timeAgoInWords() ?></span> 
                                                                </td> 
                                                                <td>
                                                                    <span>respostas</span>
                                                                </td>
                                                            </tr>
                                                        <?php endforeach ?>
                                                    </table>
                                                    <button class="nextPage changePage <?= $pageNr>1 ? '' : 'invisible'?>">
                                                        <i class="fa fa-arrow-right"></i>
                                                    </button>
                                                    <button class="prevPage changePage <?= $pageNr>1 ? '' : 'invisible'?>">
                                                        <i class="fa fa-arrow-left"></i>
                                                    </button>
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
            <div id="replyList" tabindex='-1' class='col-md-7 col-xs-10' style="display: none">
                <div id="tempReplies"></div>
                <textarea id="replyMessage" name="replyMessage"></textarea>
                <button class="btn btn-black submitReplyMessage">Submeter resposta</button>
                <button class="closeReplies"><i class="fa fa-close"></i></button>
            </div>
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
                        <div class="newMessageLabel">Título:</div>
                        <textarea rows=2 name="newTitle" placeholder="Introduz aqui a tua dúvida resumidamente"></textarea>
                        <div class="newMessageLabel" id="contentLabel">Conteúdo:</div><br>
                        <textarea rows=5 id="newMessageEditor" name="newMessage" placeholder="Explicita aqui o contexto ou detalhes da tua dúvida"></textarea>
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
.invisible{
    display: none;
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
.btn.btn-black.newMessage{
    position: absolute;
    bottom: -80px;
    right: 0;
    left: 0;
    margin: auto;
}
.dependency{
    padding-bottom: 100px;
}
.dependency.closed{
    padding-bottom: 0;
}
.btn.btn-black.newMessage{
    bottom: 25px;
    background: #FEB000;
    color: #f5f5f5;
    /*display: none;*/
}
.changePage{
    float: right;
    height: 30px;
    width: fit-content;
    margin-right: 10px;
    border: 0.5px solid #152335;
    background-color: #F5F5F5;
    border-radius: 2px;
}
.nextPage{
    margin-right: 5%;
}
.changePage .fa{
    -webkit-text-stroke: 1px #F5F5F5;
    font-size: 16px;
    display: flex;
    align-items: center;
}
#replyList{
    outline: none !important;
    padding-left: 0;
}
#replyList #tempReplies div.well{
    width: 500px;
    border: 1px solid #6B6B6B;
    padding: 10px;
    margin-right: auto;
    margin-left: auto;
    margin-bottom: 20px;
    font-size: 12pt;
}
.poster{
    background: #FEB0006E!important;
}
.moderator{
    background: #3c5f8d61;
}
#replyList #tempReplies div.well div:first-child{
    font-size: 16pt;
    margin-bottom: 20px;
}
#replyList #tempReplies div.well span{
    float: left;
}
#replyList #tempReplies div.well span.moderatorTag{
    font-size: 12px;
    margin-top: 4px;
    color: #ffd77d;
}
#replyList #tempReplies div.well span.date{
    font-size: 12px;
    margin-top: 4px;
}
#replyList #tempReplies div.well div:last-child{
    text-align: justify;
    margin-top: 20px;
}
#replyList #tempReplies div.well hr{
    margin: 0 0 10px 0;
    border: 0.5px solid #6B6B6B59;
}
#replyList #tempReplies div.well span.upvotes{
    float: right;
    font-weight: bold;
    color: #6B6B6B;
    margin-top: -10px;
    margin-right: 10px;
    width: 15px;
    text-align: center;
}
.fa-thumbs-up{
    float: right;
    margin-right: 10px;
    color: #6B6B6B;
}
.fa-thumbs-up:hover{
    color: #FEB000;
}
.fa-thumbs-up.upvoted{
    color: #FEB000;
}
#replyList textarea{
    width: 500px;
    border-radius: 10px;
    margin-top: 20px;
    padding: 5px;
    resize: vertical;
}
#replyList #cke_replyMessage{
    width: 500px;
    margin: auto;
    border-radius: 3px;
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
#replyList button.closeReplies{
    position: absolute;
    top: 0;
    right: 0;
    height: 25px;
    width: 30px;
}
#replyList button.closeReplies:hover{
    background: #FEB000;
    border-radius: 1px;
    border: 0.5px solid black;
    padding-top: 2px;
}
#replyList button.closeReplies .fa-close{
    -webkit-text-stroke: inherit;
    color: #152335;
}
div#themeTable{
    -moz-transition: all 0.5s ease-out;
    -webkit-transition: all 0.5s ease-out;
    -o-transition: all 0.5s ease-out;
    transition: all 0.5s ease-out;
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
.newMessageLabel{
    font-size: 18px;
    text-transform: uppercase;
    width:100%;
    text-align: left;
    font-weight: bold;
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
}
#newMessage #contentLabel{
    margin-bottom: -10px;
}
#backArrow i{
    position: absolute;
    right: 0;
    left: 0;
    top: 35%;
}
#backArrow i:hover{
    color: #FEB000;
}
#backArrow{
    display: none;
}
#backArrow button{
    position: relative;
    height: 50px;
    width: 50px;
    border: 1px solid #00000070;
    border-radius: 2px;
    background: #F5F5F5;
}
@media(max-width:615px){
    #backArrow button{
        width: 75%;
    }
    #replyList textarea, #replyList #cke_replyMessage{
        width: 100%;
    }
    #replyList #tempReplies div.well{
        width: 100%;
    }
    #replyList #tempReplies div.well span.date{
        display: none;
    }
}
</style>

<script src="<?= $url; ?>/bower_components/ckeditor/ckeditor.js"></script>
<script>

MESSAGEID = 0;
THEMEID = 0;
BREAKPOINT = 974;
SMALLSCREEN = window.innerWidth <= BREAKPOINT;

setTimeout(function(){
  $('.message.success').hide();  
  $('#mainNav').addClass('flash_timeout');
}, 5000);

$(function () {

    cke_new_editor = CKEDITOR.replace('newMessageEditor', {
      allowedContent: true,
      toolbarGroups: [
        { name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },
        { name: 'paragraph', groups: [ 'list', 'blocks'] },
        { name: 'links', groups: [ 'links' ] },
        { name: 'insert', groups: [ 'insert' ] },
      ]
    });

    cke_reply_editor = CKEDITOR.replace('replyMessage', {
      allowedContent: true,
      toolbarGroups: [
        { name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },
        { name: 'paragraph', groups: [ 'list', 'blocks'] },
        { name: 'links', groups: [ 'links' ] },
        { name: 'insert', groups: [ 'insert' ] },
      ]
    });

});


$(document).ready(function(){
    <?php if(@$theme_anchor): ?>
        $('#<?= $theme_anchor ?>').trigger('click');
        $('html, body').animate({
            scrollTop: $('#<?= $theme_anchor ?>').offset().top
        }, 1000);
    <?php endif ?>
});


function repliesTemplate(messageId){
    var replies = "<div id='" + messageId + "' class='well well-sm'>" +
        "<div></div>" +
        "<span></span>" +
        "<span class='moderatorTag' display='none'>&nbsp&nbspFormador</span>" +
        "<span class='date'></span>" +
        "<i class='fa fa-thumbs-up'></i><br><hr>" +
        "<span class='upvotes'></span>" +
        "<div></div>" +
        "</div>";
    return replies;
}

function displayStyle(){
    if($('#replyList').is(':visible')) {
        if($(this).width() > BREAKPOINT) {
            $('#themeTable').show();
            $('#backArrow').hide();
            $('#replyList .closeReplies').show();
            SMALLSCREEN = false   
        } else {
            SMALLSCREEN = true;
            $('#themeTable').hide(); 
            $('#backArrow').show();
            $('#replyList .closeReplies').hide();
        }
    }
}

function getMessageTable(theme, page){
    $('div#d'+theme+' .messageList tbody').hide(300, function(){$(this).show(300)});
    $.post("<?= $url?>/reserved/message-table-get", {
        page: page,
        theme: theme
    }).done(function(data) {
        console.log(JSON.parse(data));
        $('div#d'+theme+' .messageList tbody').empty();
        $.each(JSON.parse(data), function(index, value){
            $('div#d'+theme+' .messageList tbody').append(
                "<tr>" + 
                    "<td> <a href='#' class='messageToggle'></a> </td>" + 
                    "<td></td>" + 
                "</tr>" + 
                "<tr>" +
                    "<td> <span></span> <span></span> </td>" +
                    "<td> <span></span> </td>" +
                "</tr>"
            );
            $('div#d'+theme+' .messageList tbody tr:nth-last-child(2) td:first-child a').text(value['title']);
            $('div#d'+theme+' .messageList tbody tr:nth-last-child(2) td:first-child a').attr('id', 'message' + value['id']);
            $('div#d'+theme+' .messageList tbody tr:nth-last-child(2) td:last-child').text(value['children']);
            $('div#d'+theme+' .messageList tbody tr:last-child td:first-child span:first-child').text('Last post by ' + value['user'] + ' ·');
            $('div#d'+theme+' .messageList tbody tr:last-child td:first-child span:last-child').text(value['date_last']);
            $('div#d'+theme+' .messageList tbody tr:last-child td:last-child span').text('respostas');
        });
        $('div#d'+theme+' .messageList tbody').show(200);
    })
}

$('#tempReplies').on('click', '.fa-thumbs-up', function () {
    if(!$(this).hasClass('upvoted')){
        $(this).siblings('.upvotes').text(
            (isNaN(parseInt($(this).siblings('.upvotes').text())) ?
            0 : parseInt($(this).siblings('.upvotes').text())) + 1);
        $(this).addClass('upvoted');
        $.post( "<?= $url?>/reserved/message-upvote", { 
            id: $(this).parents('div.well').attr('id'),
        });
    }
});

$('.primary').on('click', function(){
  id = $(this).attr('id');
  if($('.dependency#d'+id).hasClass('closed')){
    $('.dependency').addClass('closed');
    $('.fa-chevron-up').removeClass('fa-chevron-up').addClass('fa-chevron-down');
    $('.dependency#d'+id).removeClass('closed');
    $('#arrow_'+id).removeClass('fa-chevron-down').addClass('fa-chevron-up');
  } else {
    $('.dependency').addClass('closed');
    $('#arrow_'+id).removeClass('fa-chevron-up').addClass('fa-chevron-down');
  }
});

$('.messageList').on('click', '.messageToggle', function(){
    event.preventDefault();
    MESSAGEID = $(this).attr('id').match(/\d+/g);
    THEMEID = $(this).parents('.dependency').attr('id').match(/\d+/g);
    if(window.innerWidth > BREAKPOINT) {
        $('#themeTable').removeClass('col-md-10')
            .removeClass('col-md-offset-1')
            .addClass('col-md-5');
        $('#replyList .closeReplies').show();
    } else {
        $('#themeTable').hide(500)
            .removeClass('col-md-10')
            .removeClass('col-md-offset-1')
            .addClass('col-md-5');
        $('#backArrow').show();
        $('#replyList .closeReplies').hide();
    }
    if($('#replyList').is(':visible'))
        $('#replyList').hide(500);
    else $('#replyList').hide();
    $.post( "<?= $url?>/reserved/message-get", { 
        parent: MESSAGEID[0] 
    }).done(function(data) {
        $('#replyList #tempReplies').empty();
        parent_user_id = 0;
        $.each(JSON.parse(data), function(index, value){
            $('#replyList #tempReplies').append(repliesTemplate(value['id']));
            $('#replyList #tempReplies div.well:last-child div:first-child').text(value['title']);
            $('#replyList #tempReplies div.well:last-child div:last-child').html(value['message']);
            $('#replyList #tempReplies div.well:last-child span:nth-child(2)').text(value['user']);
            $('#replyList #tempReplies div.well:last-child span.date').html('&nbsp&nbsp·&nbsp' + value['date_created']);
            $('#replyList #tempReplies div.well:last-child span.upvotes').text(value['upvotes']);
            if(value['voted'])
                $('#replyList #tempReplies div.well:last-child i.fa-thumbs-up').addClass('upvoted');
            if(value['parent_id'] == null || value['user_id'] == parent_user_id){
                $('#replyList #tempReplies div.well:last-child').addClass('poster');
                $('#replyList #tempReplies div.well:last-child span.moderatorTag').hide();
                parent_user_id = value['user_id'];
            }
            else if(value['role'] >= 1){
                $('#replyList #tempReplies div.well:last-child').addClass('moderator');
                $('#replyList #tempReplies div.well:last-child span.moderatorTag').show();
            }
        });
        $('#replyList').show(500);
        $('html, body').animate({
            scrollTop: $('div.col-md-10.col-md-offset-1').offset().top
        }, 500);
    });
});

$('.closeReplies').on('click', function(){
    $('#backArrow').hide();
    $('#replyList').hide();
    $('#themeTable').addClass('col-md-10').addClass('col-md-offset-1').removeClass('col-md-5');
    $('#themeTable').show();
})

$('.newMessage').on('click', function(){
    $('#newMessage input[name="newTheme"]').val($(this).parents('.dependency').attr('id').match(/\d+/g));
    setTimeout(function(){ 
        $("#newMessage").modal('show'); 
    }, 500);
})

$('.submitNewMessage').on('click', function(){
    event.preventDefault();
    theme_id = $('input[name="newTheme"]').val();
    title = $('textarea[name="newTitle"]').val();
    message = cke_new_editor.getData();
    $.post( "<?= $url?>/reserved/message-create", { 
        theme_id: theme_id,
        title: title,
        message: message,
        course: <?= @$group['courses_id'] ? @$group['courses_id'] : 0 ?>
    }).done(function(data) {
        if(data)
            $.post( "<?= $url?>/reserved/message-notification", { 
                theme_id: theme_id,
                title: title,
                message: message,
                course: <?= @$group['courses_id'] ? @$group['courses_id'] : 0 ?>
            });
        location.reload();
    });
})

$('.submitReplyMessage').on('click', function(){
    message = cke_reply_editor.getData();
    title = $(this).siblings('#tempReplies').children('div:first-child').children('div:first-child').text();
    $.post( "<?= $url?>/reserved/message-create", { 
        theme_id: THEMEID[0],
        parent: MESSAGEID[0],
        message: message,
        title: title,
        course: <?= @$group['courses_id'] ? @$group['courses_id'] : 0 ?>
    }).done(function(data) {
        if(data)
            $.post( "<?= $url?>/reserved/message-notification", { 
                theme_id: THEMEID[0],
                parent: MESSAGEID[0],
                message: message,
                title: title,
                course: <?= @$group['courses_id'] ? @$group['courses_id'] : 0 ?>
            });
        location.reload();
    });
})

$('.nextPage').on('click', function(){
    pageInfo = $(this).siblings('.pageInfo');
    page = parseInt(pageInfo.val()) + 1;
    theme = $(this).parent('.dependency').attr('id').match(/\d+/g);
    console.log(pageInfo);
    console.log(page);
    console.log(theme);
    if(page <= pageInfo.attr('id')){
        pageInfo.val(page);
        getMessageTable(theme[0], page)
    }
})

$('.prevPage').on('click', function(){
    pageInfo = $(this).siblings('.pageInfo');
    page = parseInt(pageInfo.val()) - 1;
    theme = $(this).parent('.dependency').attr('id').match(/\d+/g);
    if(page >= 1){
        pageInfo.val(page);
        getMessageTable(theme[0], page)
    }
})

$(window).resize(displayStyle);

</script>


