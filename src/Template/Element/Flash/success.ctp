<?php
if (!isset($params['escape']) || $params['escape'] !== false) {
    $message = h($message);
}
?>
<div class="message success" onclick="$(this).slideUp();$('.navbar-fixed-top').css('top','0')"><?= $message ?></div>
