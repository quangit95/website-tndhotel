<?php
$nodeUpdate = isset($post["updateNode"])? $post["updateNode"]:null;
$infoUpdate = null;

if(isset($_FILES["file"]["type"])){
    $nodeUpdate = "db";
    $infoUpdate["st"] = $_POST["db_st"];
    $infoUpdate["fn"] = $_POST["db_fn"];
    $infoUpdate["ph"] = $_POST["db_ph"];
    $infoUpdate["me"] = $_POST["db_me"];

}

$file = FOLDERCONTACT . "contact.xml";
$itemList = null;

if (is_file($file)) {
    $itemList = simplexml_load_file($file);
    $itemList = json_encode($itemList);
    $itemList = json_decode($itemList, true);
}

if(isset($_SESSION["contactus"]) && $_SESSION["contactus"] == $post) {
    $code = 201;
    $errors = '<p>Cảm ơn bạn đã liên hệ.</p><p>Chúng đã tiếp nhận thông tin!</p>';
} else {
    if($nodeUpdate == "db") {
        $infoUpdate = isset($post[$nodeUpdate]) ? $post[$nodeUpdate] : $infoUpdate;
        $iId = 0;
        if (!$itemList) {
            $iId = 1;
        } else {
            $table = $itemList["table"];
            // edit Item
            if (isset($infoUpdate["id"]) && intval($infoUpdate["id"]) > 0) {
                $iId = intval($infoUpdate["id"]);
            } else {
                // add Item
                $endElmTable = end($table);
                $iId = intval($endElmTable["id"]) + 1;
            }
        }
        $node = 'id_' . $iId;

        if(isset($infoUpdate["st"]) && intval($infoUpdate["st"])){
            $infoUpdate["st"] = intval($infoUpdate["st"]);
        } else {
            $infoUpdate["st"] = 0;
        }
        // set id for post
        $infoUpdate["id"] = $iId;
        $infoUpdate["cr"] = $currentTime;

        if(isset($infoUpdate["xttt"]) && $infoUpdate["xttt"]) {
            $infoUpdate["me"] = "";
            foreach ($infoUpdate["xttt"] as $key => $value) {

                $strMon = null;

                if($key == "mon") {
                    if(isset($value) && count($value)>0) {
                        foreach ($value as $keymon => $valuemon) {
                            $strMon .="<strong>{$keymon}:</strong>{$valuemon} ";
                        }
                    }
                }

                $value = $strMon ? $strMon : $value;

                $infoUpdate["me"] .="<tr>
                    <td><strong style=\"color:red;\">{$key}</strong></td>
                    <td>{$value}</td>
                </tr>";
            }

            $infoUpdate["me"] = '<table width="100%">'.$infoUpdate["me"].'</table>';
        }

        if(isset($_FILES["file"]["type"])) {
            $id = $iId;
            $maxSize = 5000;
            $img = uploadImage($_FILES["file"], null, FOLDERIMAGECONTACT, $id, $maxSize);
            if(isset($img["file"])) {
                $infoUpdate["im"] = $img["file"];
            } else {
                $code = 201;
            }
        }

        if($code == 201) {
            $errors = "image invalid! vui lòng chọn ảnh có size < {$maxSize} KB";
        } else {
            // update row before save
            /*foreach ($infoUpdate as $key => $value) {

                if(!isset($infoUpdate["xttt"])) {
                    $value = preg_replace('!\s+!', ' ', strval($value));
                }

                if($value !==' ') {
                    $itemList["table"][$node][$key] = $value;
                }
            }*/
            // save item to file

            $code = 200;


            if(isset($infoUpdate['tbook']['date'])) {
                $filter_array = array_filter($table, function ($obj) {
                    global $infoUpdate;
                    if (!isset($obj["tbook"]['date'])) {
                        return false;
                    }   elseif($infoUpdate['tbook']['date'] == $obj["tbook"]['date'] ){
                        return true;
                    } else {
                        return false;
                    }
                });


                if($filter_array) {
                    if(isset($infoUpdate["maxsignup"]) && count($filter_array) > intval($infoUpdate["maxsignup"]) ) {
                        $code = 201;
                    }
                } else {
                    #insert
                }
            }

            $itemList["table"][$node] = $infoUpdate;
            if ($code == 200) {
                saveXMLFile($file, $itemList);
                $message = '<p>Cảm ơn bạn đã liên hệ.</p><p>Chúng tôi sẽ liện lạc với bạn trong vòng thời gian sớm nhất !</p>';
            } else if( $code == 201) {
                $errors = "Cảm ơn bạn đã đăng ký chương trình, hiện chúng tôi đã đầy! Hẹn gặp lại lần tiếp theo";
            }

            $dataResponse = $infoUpdate;
            $_SESSION["contactus"] = $post;

            #SEND MAIL
            #SEND MAIL
            $strEmailRow = null;

            $message = $language["sendMessageSuccess"];

            if(isset($informationWebsite["db"]["im"])) {
                $strWebsite = "<a href=\"{$informationWebsite["db"]["url"]}\">
                            <img src=\"{$protocol}{$domainName}/{$strLogoWebsite}\" alt=\"{$informationWebsite["db"]["name"]}\" width=\"200px\">
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

            require dirname(__FILE__) . "/sendmail.php";
        }




    } elseif($nodeUpdate == "del" && isset($post["id"])) {
        # delete node
        $iId = $post["id"];
        $node = 'id_' . $iId;

        try {
            # remove item from file database
            if(isset($itemList["table"][$node])) {
                unset($itemList["table"][$node]);
                if (saveXMLFile($file, $itemList)) {
                    $code = 200;
                    $message = $language["updateSuccess"];
                }
            }
            else {
                $code = 404;
                $errors = "Not found ITEM";
            }
        } catch (Exception $ex) {
            $code = 501;
            $errors = $language["unknownErrors"];
        }

    }
}

?>
