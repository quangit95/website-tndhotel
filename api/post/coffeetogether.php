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

$file = FOLDERHOME . "coffeetogether.xml";
$itemList = null;

if (is_file($file)) {
    $itemList = simplexml_load_file($file);
    $itemList = json_encode($itemList);
    $itemList = json_decode($itemList, true);
}

if(isset($_SESSION["coffeetogether"]) && $_SESSION["coffeetogether"] == $post) {
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
        }
        else {
            $infoUpdate["st"] = 0;
        }
        // set id for post
        $infoUpdate["id"] = $iId;
        $infoUpdate["cr"] = $currentTime;

        $itemList["table"][$node] = $infoUpdate;

        // save item to file
        if (saveXMLFile($file, $itemList)) {
            $code = 200;
            $message = '<p>Cảm ơn bạn đã liên hệ.</p><p>Chúng tôi sẽ liện lạc với bạn trong vòng thời gian sớm nhất !</p>';
        }
        $dataResponse = $infoUpdate;
        $_SESSION["coffeetogether"] = $post;

        #SEND MAIL
        /*require "{$strDataFolderTemplate}newsletter/contact.php";
        require dirname(__FILE__) . "/sendmail.php";*/

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
