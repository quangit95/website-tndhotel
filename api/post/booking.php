<?php

$nodeUpdate = isset($post["updateNode"])? $post["updateNode"]:null;
$infoUpdate = null;

$file = FOLDERORDER . "booking.xml";
$itemList = null;
if (is_file($file)) {
    $itemList = simplexml_load_file($file);
    $itemList = json_encode($itemList);
    $itemList = json_decode($itemList, true);
}

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
        $infoUpdate["st"] = 1;
    }
    // set id for post
    $infoUpdate["id"] = $iId;
    $infoUpdate["cr"] = $currentTime;


    $strInfoBooking = null;
    $strInfoCustomer = null;

    if(isset($post["db"]["ti"]) && !empty($post["db"]["ti"])) {
        $strInfoBooking .= '<p>'.$post["db"]["ti"].'</p>';
    }
    if(isset($post["db"]["adult"]) && !empty($post["db"]["adult"]) ) {
        $strInfoBooking .= '<p>Adult: '.$post["db"]["adult"].'</p>';
    }
    if(isset($post["db"]["child"]) && !empty($post["db"]["child"])) {
        $strInfoBooking .= '<p>Child: '.$post["db"]["child"].'</p>';
    }

    if(isset($post["db"]["dt"]) && !empty($post["db"]["dt"])) {
        $strInfoBooking .= '<p>Time: '.$post["db"]["dt"].'</p>';
    }
    if(isset($post["db"]["fn"]) && !empty($post["db"]["fn"])) {
        $strInfoCustomer .= '<p>'.$post["db"]["fn"].'</p>';
    }
    if(isset($post["db"]["em"]) && !empty($post["db"]["em"])) {
        $listMailCC = array(
            array(
                "email"=>$post["db"]["em"],
                "name"=>$post["db"]["fn"],
            )
        );

        $strInfoCustomer .= '<p>'.$post["db"]["em"].'</p>';
    }
    if(isset($post["db"]["ph"]) && !empty($post["db"]["ph"])) {
        $strInfoCustomer .= '<p>'.$post["db"]["ph"].'</p>';
    }

    $itemList["table"][$node] = $infoUpdate;
    if (saveXMLFile($file, $itemList)) {
        $code = 200;

        $message = '<p>Cảm ơn bạn đã liên hệ.</p><p>Chúng tôi sẽ liện lạc với bạn trong vòng thời gian sớm nhất.</p>';
        $messageBooking = '<div><h3>Booking info</h3>'.$strInfoBooking.'</div><hr>'.'<div><h3>Customer info</h3>'.$strInfoCustomer.'</div>';
        $dataResponse = array("sms"=>$messageBooking);


        $strEmailto = isset($informationConfig["config"]["email"]["orders"]) && !empty($informationConfig["config"]["email"]["orders"]) ? $informationConfig["config"]["email"]["orders"] : null;
        if($strEmailto) {

            $strSubject = "From website {$informationWebsite["db"]["name"]} orders ".date('d-m-Y')." - MS#{$iId}";

            $messageBooking = "<h3>{$strSubject}</h3><hr>".$messageBooking;
            $sendMailObj = isset($sendMailObj) ? $sendMailObj : array(
                "from" => "info@phpvnn.com",
                "to" => $strEmailto,
                "sender" => "Phpvnn team website",
                "receiver" => "User",
                "reply" => "info@phpvnn.com",
                "replyInfo" => "Phpvnn.com",
                "subject" => $strSubject,
                "content" => $messageBooking,
            );
            require dirname(__FILE__) . "/sendmail.php";
        } else {
            $message = '<p>Yêu cầu đã được lưu, chúng tôi sẽ gọi lại trong thời gian sớm nhất.</p>';
            $code = 200;
        }

    } else {
        $code = 201;
        $errors = '<p>Invalidation post.</p>';
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
?>
