<?php

if(!isset($_SESSION["adminlog"])) {
    die();
}
$dataList = array();
$file = FOLDERORDER . "booking.xml";
$information = null;
if (is_file($file)) {
    $information = simplexml_load_file($file);
    $information = json_encode($information);
    $information = json_decode($information, true);
}
if (isset($url_data[3]) && $url_data[3] ) {
    $iId = intval($url_data[3]);
    $node = "id_{$iId}";

    if(isset($information["table"]["{$node}"])) {
        $dataResponse  = $information["table"]["{$node}"];
        $code = 200;

    } else {
        $code = 201;
        $errors = "not found item";
    }
}
else {
    $code = 200;
    if (!$information) {
        $dataResponse = array();
    } else {
        $dataList = $information["table"];
    }

    if(isset($_GET["sortId"]) && $_GET["sortId"] == 'ASC') {
        usort($dataList, function($a, $b)
        {
            return intval($a["id"] ?? 0) <=> intval($b["id"] ?? 0);
        });
    }
    else {
        usort($dataList, function($a, $b)
        {
            return intval($b["id"] ?? 0) <=> intval($a["id"] ?? 0);
        });
    }

    if (isset($_GET["limit"])) {
        $dataList = array_slice( $dataList, 0, intval($_GET["limit"]) );
    } else {
        $dataResponse = array_values($dataList);
    }
}
?>
