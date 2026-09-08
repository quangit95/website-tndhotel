<?php

$isUpdate = false;
$idAgain = null;

if(!isset($_SESSION["cartinfo"])) {
    $_SESSION["cartinfo"] = null;
}

if (isset($sessionUserId) && isset($post["db"]["ui"]) && $sessionUserId == $post["db"]["ui"]) {
    $isUpdate = true;
}

if($isUpdate && $post["db"]) {
    $infoUpdate = $post["db"];
    $infoUpdate["created"] = $currentTime;
    $file  = FOLDERUSER.$sessionUserId.".xml";

    $uid = $post["db"]["ui"];


    if(isset($post["mod"]) && $post["mod"]=="bookagain") {
        #book again

        $idAgain = $post["db"]["id"];

        $strQuery = "SELECT * FROM ".TABLE_ORDERS."
                        WHERE id={$idAgain} AND ui={$uid} LIMIT 0,1";
        $infoUpdate = $db->db_array($strQuery);
        if($infoUpdate) {
            $infoUpdate["status"]=1;
            $infoUpdate["drawdate"]=$post["db"]["drawdate"];
            $infoUpdate["created"]=$currentTime;
            $infoUpdate["picklottery"] = explode(' , ', $infoUpdate["picklottery"]);
            unset($infoUpdate["id"]);
        }
    }

    #update user moneyleft job left
    $fileinfo = simplexml_load_file($file);
    $information = json_encode($fileinfo);
    $information = json_decode($information, true);
    $moneyleft = isset($information["userinfo"]["db"]["moneyleft"]) ? $information["userinfo"]["db"]["moneyleft"] : 0;


    if(isset($infoUpdate["picklottery"]) && $infoUpdate["picklottery"]) {
        # validate picklottery
        $strInsertOrderDetail = 'INSERT INTO `'.TABLE_ORDERSDETAIL.'` (`orders_id`, `picked`) VALUES ';
        $picklotteries = array();
        $picklotteriesStyle = array();
        foreach ($infoUpdate["picklottery"] as $key => $value) {
            $value = explode(',',$value);
            $picklotteriesStyle[] = '<span class="btn-number-optioned">'.implode($value,'</span><span class="btn-number-optioned">').'</span><i class="clearfix"></i>';
            $value = implode($value, '-');
            $picklotteries[] = $value;
            $strInsertOrderDetail .= "({1},'{$value}'),";
        };
    }

    $infoUpdate["items"] = count($picklotteries);

    if(( $picklotteries == $_SESSION["cartinfo"] || $idAgain ) && $infoUpdate["total"] && MEGAMONEYPERITEM*$infoUpdate["items"] == $infoUpdate["total"]) {
        // insert orders into database and make money left
        $infoUpdate["picklottery"] = implode($picklotteries, ' , ');
        $infoUpdate["status"] = 1;

        if(!isset($infoUpdate["mi"]) ) {
            $infoUpdate["mi"] = 1;
        }

        if ($db->db_insert($infoUpdate, TABLE_ORDERS)) {

            if($moneyleft >= $infoUpdate["total"]) {
                $strQuery = "SELECT * FROM ".TABLE_ORDERS."
                    WHERE picklottery='" . $infoUpdate["picklottery"] . "' AND created=$currentTime LIMIT 0,1";
                $row = $db->db_array($strQuery);

                if($row) {
                    // insert ordersdetail into database
                    $strInsertOrderDetail  = substr($strInsertOrderDetail , 0, -1);
                    $strInsertOrderDetail =  formatStrArguments($strInsertOrderDetail, $row["id"]);
                    $db->db_query($strInsertOrderDetail);
                    $user_update["moneyleft"] = $moneyleft - $infoUpdate["total"];

                    if ($db->db_update($user_update, TABLE_USER, array("id" => $sessionUserId))) {
                        $information["userinfo"]["db"]["moneyleft"] = $user_update["moneyleft"];
                        saveXMLFile($file, $information);
                    }

                    $ordersSuccessContent = null;
                    $picklotteriesStyle = '<ul> <li>'.implode($picklotteriesStyle, '</li><li>').' </li> </ul>';
                    if(isset($informationConfig["config"]["ordersSuccess"]["$langcode"]) && count($informationConfig["config"]["ordersSuccess"]["$langcode"])) {
                        $ordersSuccessContent = $informationConfig["config"]["ordersSuccess"]["$langcode"];
                        $ordersSuccessContent = formatStrArguments($ordersSuccessContent, $row["id"], date("h:m:s d-m-Y"), $picklotteriesStyle);
                    }
                    $dataResponse = array("content"=>$ordersSuccessContent,
                            "moneyleft" =>$user_update["moneyleft"],
                            "id"=>$row["id"],
                            "orders"=>1,
                            "continuous"=>"/datnhanh",
                            "picklottery"=>$picklotteries);
                    $message = "Số của bạn đã được mua thành công.";
                    $code = 200;
                    if(!$idAgain) {
                        unset($_SESSION["cartinfo"]);
                    }

                    // $dataResponse["urlRedirect"] = "/user?fun=config&node=orders";
                } else {

                }
            }
        }
    } else {
        $message = "Orders không hợp lệ";
        $code = 201;
    }
}

