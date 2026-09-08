<?php
$id = isset($_POST["id"]) ? $_POST["id"]:null;
$url = isset($_POST["url"]) ? $_POST["url"]:null;
if($url) {
    $strQuery = "SELECT id, url FROM ".TABLE_CATEGORY."
    WHERE url='{$url}' AND id != '{$id}' LIMIT 0,1";
    $item = $db->db_array($strQuery);
    if($item) {
        $code = 201;
        $errors = $language["urlNotAvailable"];
    }
    else {
        $code = 200;
        $message = $strQuery;
    }
}
else {
    $code = 202;
    $errors = "Post invalid";
}

?>
