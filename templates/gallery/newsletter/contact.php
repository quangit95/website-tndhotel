<?php
$strEmailRow = null;

$message = $language["sendMessageSuccess"];

if(isset($informationWebsite["db"]["im"])) {
    $strWebsite = "<a href=\"{$informationWebsite["db"]["url"]}\">
                <img src=\"{$informationWebsite["db"]["url"]}/storage/management/img/website/{$informationWebsite["db"]["im"]}\" alt=\"{$informationWebsite["db"]["name"]}\" width=\"200px\">
            </a>";
} else {
    $strWebsite = "<a href=\"{$informationWebsite["db"]["url"]}\">{$informationWebsite["db"]["name"]}</a>";
}

$strSubject = "From website {$informationWebsite["db"]["name"]} contact ".date('d-m-Y');


$emailConfig = isset($informationConfig["config"]["email"]) ? $informationConfig["config"]["email"] : null;
$strEmailto = isset($emailConfig["contact"])? $emailConfig["contact"] : "124phn@gmail.com";

$strSubjectRow = isset($infoUpdate["su"]) && count($infoUpdate["su"]) ? "<p><strong>{$language["subject"]}:</strong> {$infoUpdate["su"]}</p>" : null;

$strEmailFrom = isset($infoUpdate["em"]) && count($infoUpdate["em"]) ? "<p><strong>{$language["email"]}:</strong> {$infoUpdate["em"]}</p>":null;

$strAddress = isset($infoUpdate["add"]) && count($infoUpdate["add"]) ? "<p><strong>{$language["address"]}:</strong> {$infoUpdate["add"]}</p>":null;

$strFullname = isset($infoUpdate["fn"]) && count($infoUpdate["fn"]) ? "<p><strong>{$language["fullname"]}:</strong> {$infoUpdate["fn"]}</p>":null;

$strYourNumber = isset($infoUpdate["ph"]) && count($infoUpdate["ph"]) ? "<p><strong>{$language["yourNumber"]}:</strong> {$infoUpdate["ph"]}</p>":null;

$strYourMessage = isset($infoUpdate["me"]) && count($infoUpdate["me"]) ? "<p><strong>{$language["content"]}:</strong> {$infoUpdate["me"]}</p>":null;


$htmlSMS = "<table cellpadding=\"10\" cellspacing=\"0\">
    <tr>
        <td>
            {$strWebsite}
        </td>
        <td>
            {$strSubjectRow}
            {$strFullname}
            {$strAddress}
            {$strYourNumber}
            {$strEmailFrom}
            {$strYourMessage}
        </td>
    </tr>
    </table>";

$htmlSMS = "<h3>{$strSubject}</h3><br>".$htmlSMS;
$sendMailObj = isset($sendMailObj) ? $sendMailObj : array(
    "from" => "info@phpvnn.com",
    "to" => $strEmailto,
    "sender" => "PHPVNN TEAM",
    "receiver" => "User",
    "reply" => "info@phpvnn.com",
    "replyInfo" => "Phpvnn.com",
    "subject" => $strSubject,
    "content" => $htmlSMS,
);
