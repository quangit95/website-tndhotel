<?php
$file = FOLDERORDER . "order.xml";
$information = null;
if (is_file($file)) {
    $information = simplexml_load_file($file);
    $information = json_encode($information);
    $information = json_decode($information, true);
}

$code = 200;

if (!$information) {

} else {
    $dataList = $information["table"];


    if (isset($_GET["st"]) && $_GET["st"]) {
        $dataList = arrSearch($dataList, "st=={$_GET["st"]}");
    }

    if (isset($_GET["ci"]) && $_GET["ci"]) {
        $dataList = arrSearch($dataList, "ci=={$_GET["ci"]}");
    }

    if (isset($get["from"])) {
        $dtime = DateTime::createFromFormat("d-m-yy G:i", $get["from"]." 00:01");
        if($dtime) {
            $dataList = arrSearch($dataList, "dt>={$dtime->getTimestamp()}");
        }
    }

    if (isset($get["to"])) {
        $dtime = DateTime::createFromFormat("d-m-yy G:i", $get["to"]." 23:59");
        if($dtime) {
            $dataList = arrSearch($dataList, "dt<={$dtime->getTimestamp()}");
        }
    }

    if (isset($_GET["limit"])) {
        // doto updating list
    }

    $dataResponse = array_values($dataList);
}
?>
