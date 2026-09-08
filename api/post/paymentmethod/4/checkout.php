<?php
$isSuccessPost = true;
$code = 200;
$urlInfo = "http://{$_SERVER['HTTP_HOST']}/{$seo_name["page"]["user"]}?fun=config&node=recharge&checkout={$getRowJustInsert["id"]}&pm=4";
$message = '<img src="/img/style/ajax-loader.gif" class="img-payment"/>';
$dataResponse = array("urlRedirect" => $urlInfo);
?>
