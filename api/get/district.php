<?php
$dataResponse = $database->select("local_district",["id","ti","cid"]);
if($dataResponse) {
    $message = "total Item: ".count($dataResponse);
    $code =200;
} else {
    $message = $language["dataNotfound"];
}
