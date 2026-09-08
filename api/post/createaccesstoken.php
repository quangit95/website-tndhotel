<?php
if(!isset($post["db"]["password"]) || !isset($post["db"]["email"])) {
    die();
}

$filelog = FOLDERUSER . "log.xml";
$loginfomation["log"] = getallheaders();
saveXMLFile($filelog, $loginfomation);

$mod = isset($post["mod"]) ? $post["mod"] : null;
$password = md5($post["db"]["password"]);
$email = $post["db"]["email"];


$headers = getallheaders();
$access_token = isset($headers["Authorization"]) ? $headers["Authorization"]: null ;
# check token
$row = $database->get(TABLE_USER, "*", array("email" => $email, "password"=>$password) );

if ($row) {
    $userId = $row["id"];
    $file = FOLDERUSER . "$userId.xml";
    $code = 200;
    if (is_file($file)) {
        $readXML = simplexml_load_file($file);
        $information = json_encode($readXML);
        $information = json_decode($information, true);
    }
    $strToken = bin2hex(openssl_random_pseudo_bytes(32)).".{$userId}";

    # check old token
    $oldToken = $database->get(TABLE_USER_TOKEN, ["uid"], array("uid" => $userId) );
    $createToken = array("uid"=>$userId,
                "token"=>"{$strToken}",
                "created"=>$currentTime);
    if($oldToken) {
        # update token
        $database->update(TABLE_USER_TOKEN, $createToken,array("uid" => $userId));
    } else {
        # create new token
        $database->insert(TABLE_USER_TOKEN, $createToken);
    }

    $dataResponse["Authorization"] = $strToken;
    $code = 200;
} else {
    $code = 401;
    $errors = $language["signinError"];
}
?>
