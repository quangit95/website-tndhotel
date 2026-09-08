<?php
$mod = isset($post["mod"]) ? $post["mod"] : null;

#validate admin
$isAction = true;

if($isAction) {
    if($mod == "recharge" && isset($post["update"]) && isset($post["db"]["ui"]) && isset($post["db"]["id"])  && isset($post["db"]["am"]) ) {
        $rowUpdate = $post["update"];
        $rowUpdate["ps"] = 3;

        if( $db->db_update($rowUpdate, TABLE_USER_PAYMENT, $post["db"] ) ) {
            # update money to user
            updateMoneyIntoUserAccount($post["db"]["ui"], $post["db"]["am"]);
            $code = 200;
            $message = "Nạp tiền thành công";
        }
    } elseif($mod == "rechargeDirection") {
        $insertData = $post["db"];
        $insertData["ps"] = 3;
        $insertData["pm"] = 5; # Direction Recharge define
        $insertData["ai"] = 1;
        $insertData["cr"] = $currentTime;
        if(isset($insertData["am"]) && isset($insertData["ui"]) && isset($insertData["ai"]))
        {
            if(isset($insertData["am"]) && $insertData["am"]) {
                $insertData["am"] = str_replace(',','', $insertData["am"]);
                $insertData["am"] = floatVal($insertData["am"]);
            }

            if($db->db_insert($insertData, TABLE_USER_PAYMENT)) {
                updateMoneyIntoUserAccount($insertData["ui"], $insertData["am"]);
            }
        }
    } elseif($mod == "manager") {
        if(isset($post["db"]) ) {
            $post["db"]["password"] = md5($post["db"]["password"]);
            $arrayUpdate = $post["db"];
            if(isset($post["db"]["id"]) && $post["db"]["id"]) {
                #update database
                if ($db->db_update($arrayUpdate, TABLE_USER_MANAGER, array("id" => $post["db"]["id"]))) {
                    $isUpdate = true;
                }
            } else {
                #insert database
                if($db->db_insert($arrayUpdate, TABLE_USER_MANAGER));
            }

            $code = 200;
            $message = "Update success";
        }
    } elseif($mod == "removemanager") {
        if(isset($post["uid"]) && isset($post["id"]) && $post["uid"]) {
            $db->db_delete(TABLE_USER_MANAGER, array("id"=>$post["id"], "user_id"=>$post["uid"]));
            $code = 200;
            $message = "delete success";
        }
    } elseif($mod == "password") {

        $uid = $post["db"]["user_id"];
        $id = $post["db"]["id"];
        $oldPassword = isset($post["password"]["passwordOld"]) ? $post["password"]["passwordOld"] : null;
        $strQuery = "SELECT * FROM ".TABLE_USER_MANAGER. " WHERE id = {$id} AND user_id = {$uid} AND password ='".md5($oldPassword)."'";

        $row = $db->db_array($strQuery);
        if($row) {
            $post["db"]["password"] = md5( $post["password"]["passwordConfirm"] );
            if ($db->db_update($post["db"], TABLE_USER_MANAGER, array("id" => $id, "user_id" => $uid ))) {
                $isUpdate = true;
                $code = 200;
                $message = "New Password was updated";
            }
        } else {
            $code = 201;
            $errors = "Old Password was wrong";
        }

    }
} else {

}
?>
