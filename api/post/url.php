<?php
$id = isset($_POST["id"]) ? $_POST["id"]:null;
$url = isset($_POST["url"]) ? $_POST["url"]:null;
# $mod = isset($_POST["menu"]) ? $_POST["menu"]:null;

if($url && !in_array($url, $listUrlDoNotUpdate, true)) {

    $file = FOLDERMENU . "menu.xml";
    $itemList = null;
    if (is_file($file)) {
        $itemList = simplexml_load_file($file);
        $itemList = json_encode($itemList);
        $itemList = json_decode($itemList, true);
    }

    $dataList = $itemList["table"];

    if($dataList) {
        if($id) {
            $filter_array = array_filter($dataList, function ($obj) {
                global $id, $url;
                $isCheck = false;
                if (!isset($obj["url"])) {
                    return false;
                }

                if($obj["url"] == $url && $obj["id"]!=$id) {
                    $isCheck = true;
                }
                return $isCheck;
            });
        } else {
            $filter_array = array_filter($dataList, function ($obj) {
                global $id, $url;
                $isCheck = false;
                if (!isset($obj["url"])) {
                    return false;
                }
                if($obj["url"]==$url) {
                    $isCheck = true;
                }
                return $isCheck;
            });
        }
        $dataList = $filter_array;
    }

    if(count($dataList)) {
        $code = 201;
        $errors = $language["urlNotAvailable"];
    }
    else {
        $code = 200;
        $message = $language["urlAvailable"];
    }
}
else {
    $code = 202;
    $errors = "Url invalid";
}

?>
