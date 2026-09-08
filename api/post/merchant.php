<?php
$nodeUpdate = isset($post["updateNode"])? $post["updateNode"]:null;
$uid = isset($post["db"]["ui"]) ? $post["db"]["ui"] : null;
$id = isset($post["db"]["id"]) ? $post["db"]["id"] : null;

$isUpdate = false;

if (isset($_SESSION["adminlog"]) && $_SESSION["adminlog"]) {
    $isUpdate = true;
} elseif (isset($_SESSION["merchantlog"]["id"]) && $_SESSION["merchantlog"]["id"] == $id ) {
    $isUpdate = true;
}

if($nodeUpdate == "checkemail") {
    $email = isset($_POST["value"]) ? $_POST["value"]:null;
    $strQuery = "SELECT id, email FROM ".TABLE_MERCHANT."
    WHERE email='{$email}' AND id != '{$id}' LIMIT 0,1";
    $item = $db->db_array($strQuery);
    if($item) {
        $code = 201;
        $errors = $language["emailAlreadyRegistered"];
    }
    else {
        $code = 200;
        $message = $strQuery;
    }
} elseif($nodeUpdate == "db") {
    $infoUpdate = $post["{$nodeUpdate}"];

    if($isUpdate) {
        if($id) {
            #update user
            if(isset($infoUpdate["deactive"]) && $infoUpdate["deactive"]) {
                # var_dump($infoUpdate["deactive"]);
                if ($db->db_update($infoUpdate, TABLE_MERCHANT, array("id" => $id))) {
                    $code = 200;
                    $message = $language["updateSuccess"];
                } else {
                    $code = 201;
                    $message = $language["unknownErrors"];
                }
            } else {
                if ($db->db_update($infoUpdate, TABLE_MERCHANT, array("id" => $id))) {
                    $code = 200;
                    $message = $language["updateSuccess"];
                } else {
                    $code = 201;
                    if(isset($infoUpdate["email"]) && $infoUpdate["email"]) {
                        $errors = $language["emailAlreadyRegistered"];
                    } else {
                        $errors = $language["updateSuccess"];
                    }

                }
            }


        } else {
            # create new user
            $infoUpdate["password"] = md5($infoUpdate["password"]);
            $infoUpdate["created"] = $currentTime;
            $infoUpdate["status"] = 1;

            if ($db->db_insert($infoUpdate, TABLE_MERCHANT)) {
                $strQuery = "SELECT * FROM user
                        WHERE email='" . $infoUpdate["email"] . "' AND created=$currentTime LIMIT 0,1";
                $row = $db->db_array($strQuery);

                if($row) {

                    $code = 200;
                    $message = $strQuery;
                }
            } else {
                $code = 202;
                $errors = $language["insertErrors"];
            }
        }
    } else {
        $code = 201;
        $errors = $language["unknownErrors"];
    }
} elseif($nodeUpdate == "password") {

    $uid = isset($post["db"]["id"]) ? $post["db"]["id"] : null;
    $infoUpdate = $post["{$nodeUpdate}"];

    if( !isset($_SESSION["merchantlog"]["id"]) || $_SESSION["merchantlog"]["id"] != $uid || !$uid || !isset($infoUpdate["passwordNew"]) || !isset($infoUpdate["passwordOld"]) ) {
        $code = 201;
        $errors = $language["unknownErrors"];
    } else {
        $isOldPassword = false;
        $strQuery  = "SELECT id, email, password FROM ".TABLE_MERCHANT." WHERE id={$uid}";
        $row = $db->db_array($strQuery);
        if($row["password"] == md5($infoUpdate["passwordOld"]) ) {
            $row["password"] = md5($infoUpdate["passwordNew"]);
            if( $db->db_update($row, TABLE_MERCHANT, array("id" => $uid) ) ) {
                $isOldPassword = true;
                #update time change password
                $information["userinfo"][$nodeUpdate]["lastupdate"] = $currentTime;
                // saveXMLFile($file, $information);
            }
        }

        if($isOldPassword == true) {
            $code = 200;
            $message = $language["passwordChangeSuccess"];
        }
        else {
            $code = 201;
            $errors = $language["passwordDonotChange"];
        }
    }
} elseif($nodeUpdate == "changepw" && $isUpdate ) {

    $infoUpdate = $post["{$nodeUpdate}"];
    $row["password"] = md5($infoUpdate["password"]);
    if($db->db_update($row, TABLE_MERCHANT, array("id" => $infoUpdate["id"]) )){
        $code = 200;
        $message = $language["passwordChangeSuccess"];
    } else {
        $code = 201;
        $errors = $language["passwordDonotChange"];
    }
}
?>
