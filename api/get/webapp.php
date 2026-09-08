<?php
/*error_reporting(E_ALL);
ini_set('display_errors', 1);*/

$headers = getallheaders();
$access_token = isset($headers["Authorization"]) ? $headers["Authorization"]: null ;
# check token

$whereSignup = array("token" => $access_token);
$rowUser = $database->get(TABLE_USER_TOKEN, [
    "uid",
    "expires_in",
    "created"
], $whereSignup );


$getNode = isset($_GET["node"]) ? $_GET["node"] : null;

if($rowUser) {
    $userId = $rowUser["uid"];
    $file = FOLDERUSER . "$userId.xml";
    $code = 200;
    if (is_file($file)) {
        $readXML = simplexml_load_file($file);
        $information = json_encode($readXML);
        $information = json_decode($information, true);
    }

    if($getNode) {
        $keyId =  isset($_GET["key"]) ? intval($_GET["key"]) : null;
        if(isset($information["cartinfo"]["items"]["n_{$keyId}"]) && $information["cartinfo"]["items"]["n_{$keyId}"]) {
            $dataResponse = $information["cartinfo"]["items"]["n_{$keyId}"];
        }
    } else {
        $code = 200;
        $dataResponse = $information;
    }

} else {
    $dataResponse = $headers;
}
?>
