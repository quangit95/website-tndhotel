<?php

$headers = getallheaders();
$access_token = isset($headers["Authorization"]) ? $headers["Authorization"]: null ;

# check token
$str_query = "SELECT uid FROM ".TABLE_USER_TOKEN." WHERE token='{$access_token}' LIMIT 0,1";
$rowUser = $db->db_array($str_query);
if($rowUser) {

    $userId = $rowUser["uid"];
    $file = FOLDERUSER . "$userId.xml";
    $code = 200;
    if (is_file($file)) {
        $readXML = simplexml_load_file($file);
        $information = json_encode($readXML);
        $information = json_decode($information, true);
    }

    $postNode = isset($post["node"]) ? $post["node"] : null;

    $strWebapp = dirname(__FILE__)."/app/{$postNode}.php";
    if(is_file($strWebapp) ) {
        require $strWebapp;
    } else {
        $code = 401;
        $errors = "Invalid post";
    }

}



/*if(isset($information) && $information) {
    $code = 200;
    $dataResponse = $information;
}*/
?>
