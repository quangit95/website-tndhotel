<?php
$strEmailRow = null;

$emailConfig = isset($informationConfig["config"]["email"]) ? $informationConfig["config"]["email"] : null;
$strEmailto = isset($emailConfig["orders"])? $emailConfig["orders"] : "124phn@gmail.com";

require_once("api/get/state/vn.php");

$rowCity = arrSearch($countryState, "id=='{$row["cit"]}'");
$rowDistrict = arrSearch($district, "id=={$row["dis"]}");


if(isset($row["em"]) && $row["em"]) {
    $strEmailRow = "<p><strong>{$language["yourEmail"]}:</strong> {$row["em"]}</p>";
    $listMailCC = array(
        array(
            'email'=>$row["em"],
            'name'=>$row["fn"],
        )
    );
}

$message = $language["orderSuccess"];

if(isset($informationWebsite["db"]["im"])) {
    $strWebsite = "<a href=\"{$informationWebsite["db"]["url"]}\">
                <img src=\"{$informationWebsite["db"]["url"]}/storage/management/img/website/{$informationWebsite["db"]["im"]}\" alt=\"{$informationWebsite["db"]["name"]}\" width=\"200px\">
            </a>";
} else {
    $strWebsite = "<a href=\"{$informationWebsite["db"]["url"]}\">{$informationWebsite["db"]["name"]}</a>";
}

$strSubject = "From website {$informationWebsite["db"]["name"]} orders ".date('d-m-Y')." - MS#{$iId}";

$htmlSMS = "<table cellpadding=\"10\" cellspacing=\"0\">
    <tr>
        <td>
            {$strWebsite}
        </td>
        <td>
            <p><strong>{$language["fullname"]}:</strong> {$row["fn"]}</p>
            {$strEmailRow}
            <p><strong>{$language["yourNumber"]}:</strong> {$row["ph"]}</p>
            <p><strong>{$language["address"]}:</strong> {$row["add"]} - <strong>{$rowDistrict[0]["ti"]} - {$rowCity[0]["ti"]}</strong></p>
            <p><strong>{$language["noteOrder"]}:</strong> {$row["no"]}</p>
        </td>
    </tr>
    </table>";

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
