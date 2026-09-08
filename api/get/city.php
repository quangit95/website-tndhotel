<?php
$dataResponse = $database->select("local_city",["id","ti","code"]);
if($dataResponse) {
    $message = "total Item: ".count($dataResponse);
    $code =200;
} else {
    $message = $language["dataNotfound"];
}
