<?php

$nodeUpdate = isset($post["updateNode"])? $post["updateNode"]:null;
$infoUpdate = null;
$file = FOLDERORDER . "carbooking.xml";
$itemList = null;
if (is_file($file)) {
    $itemList = simplexml_load_file($file);
    $itemList = json_encode($itemList);
    $itemList = json_decode($itemList, true);
}

if($nodeUpdate == "db" && isset($post["db"])) {
    $row = $post["db"];

    #SEND MAIL
    $strEmailRow = null;
    $emailConfig = isset($informationConfig["config"]["email"]) ? $informationConfig["config"]["email"] : null;
    $strEmailto = isset($emailConfig["orders"])? $emailConfig["orders"] : "124phn@gmail.com";

    $message = $language["sendMessageSuccess"];

    if(isset($row["em"]) && $row["em"]) {
        $strEmailRow = "<p><strong>{$language["yourEmail"]}:</strong> {$row["em"]}</p>";
        $listMailCC = array(
            array(
                'email'=>$row["em"],
                'name'=>$row["fn"],
            )
        );

        if(isset($informationWebsite["db"]["im"])) {
            $strWebsite = "<a href=\"{$informationWebsite["db"]["url"]}\">
                        <img src=\"{$informationWebsite["db"]["url"]}/storage/management/img/website/{$informationWebsite["db"]["im"]}\" alt=\"{$informationWebsite["db"]["name"]}\" width=\"200px\">
                    </a>";
        } else {
            $strWebsite = "<a href=\"{$informationWebsite["db"]["url"]}\">{$informationWebsite["db"]["name"]}</a>";
        }
        $strBooking = null;
        foreach ($row as $key => $value) {
            $strBooking .="<tr><td><strong>{$key}</strong><strong></td><td>{$value}</td></tr>";
        }
        $strSubject = "From website {$informationWebsite["db"]["name"]} Carbooking ".date('d-m-Y');
        $htmlSMS = "<table cellpadding=\"10\" cellspacing=\"0\" border=\"1px\" style=\"border-collapse: collapse; border-spacing: 0;\"><tr><td colspan=\"2\">{$strWebsite}</td></tr>$strBooking</table>";

        $htmlSMS = "<h3>{$strSubject}</h3><br>".$htmlSMS;
        $sendMailObj = isset($sendMailObj) ? $sendMailObj : array(
            "from" => "info@phpvnn.com",
            "to" => $strEmailto,
            "sender" => "Phpvnn team website",
            "receiver" => "User",
            "reply" => "info@phpvnn.com",
            "replyInfo" => "Phpvnn.com",
            "subject" => $strSubject,
            "content" => $htmlSMS,
        );

        require dirname(__FILE__) . "/sendmail.php";
        $dataResponse = $row;
    }

} elseif($nodeUpdate == "del" && isset($post["id"])) {
    # delete node

}
?>
