<?php
if (!isset($url_data[3]) || !$url_data[3] || isset($url_data[4])) {
    die();
}
$fileId = intval($url_data[3]);
$file = FOLDERORDER . $fileId . ".xml";

$information = null;
if (is_file($file)) {
    $information = simplexml_load_file($file);
    $information = json_encode($information);
    $information = json_decode($information, true);
    $dataResponse = $information;
} else {
    die();
}
?>
