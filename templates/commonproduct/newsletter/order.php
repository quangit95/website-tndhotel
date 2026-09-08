<?php
$htmlSMS = "<h3>{$strSubject}</h3><br>".$htmlSMS.$strOrderProductInfo;
$sendMailObj = isset($sendMailObj) ? $sendMailObj : array(
    "from" => "info@phpvnn.com",
    "to" => $strEmailto,
    "sender" => "Website ordering online",
    "receiver" => "User",
    "reply" => "info@phpvnn.com",
    "replyInfo" => "Phpvnn.com",
    "subject" => $strSubject,
    "content" => $htmlSMS,
);
