<?php

if(isset($isAdminPage) && $isAdminPage) {
    # signin admin page of system
    if( isset($_SESSION["userlog"]["email"]) && isset($post["db"]["email"]) && $post["db"]["email"] == $_SESSION["userlog"]["email"] ) {
        $password = md5($post["db"]["password"]);

        $row = $database->get("user_manager", [
                "id",
                "uid",
                "permission"
            ], [
                "uid"=>$_SESSION["userlog"]["id"],
                "password"=>$password
            ]);

        if ($row) {
            $_SESSION["adminlog"] = $row;
            $post = $_SESSION["adminlog"];
            $code = 200;
        } else {
            $code = 401;
            $errors = $language["signinError"];

            if(!isset($_SESSION["adminlogfail"])) {
                $_SESSION["adminlogfail"] = 1;
            } else {
                $_SESSION["adminlogfail"] = $_SESSION["adminlogfail"] + 1;
            }

            if($_SESSION["adminlogfail"] > 3) {
                unset($_SESSION["adminlogfail"]);
                unset($_SESSION["userlog"]);
                $code = 200;
                $errors = null;
                $message ="Warning login";
                $dataResponse = array("urlRedirect" => "/");
            }
        }
    } else {
        $code = 403;
        $errors = $language["signinError"];
    }

} else {
    # username and password was setting in account of system
    $file = FOLDERWEBSITE . "{$websiteId}.xml";
    $fileHistoryLogin = FOLDERHOME . "history.xml";
    if(isset($post["username"]) && isset($post["password"]) ) {
        $account = isset($informationWebsite["login"])? $informationWebsite["login"] : null;
        if($account && $account["username"] === $post["username"] && $account["password"] === md5($post["password"]) ) {
            $timeLogin = time();
            $token = md5($timeLogin.$account["password"]);
            $_SESSION["adminlog"] = $token;
            // store history login
            $itemList = null;
            if (is_file($fileHistoryLogin)) {
                $itemList = simplexml_load_file($fileHistoryLogin);
                $itemList = json_encode($itemList);
                $itemList = json_decode($itemList, true);
            }

            if (!$itemList) {
                $iId = 1;
            } else {
                // add Item
                $table = $itemList["table"];
                $endElm = end($table);
                $iId = intval($endElm["i"]) + 1;
            }
            $node = 'i_' . $iId;
            $itemList["table"][$node] = array('i'=>$iId, 't'=>$timeLogin, 'a'=>$token);
            // save file
            saveXMLFile($fileHistoryLogin, $itemList);
            $code = 200;
            $dataResponse = $token;
        }
        else {
            $code = 401;
            $errors = "username and password do not match";
        }
    }
    else {
        $code = 501;
        $errors = $language["unknownErrors"];
    }
}
?>
