<?php
if (!isset($_GET["did"]) ) {
  // die();
  if(!isset($_SESSION["adminlog"])) {
    die();
  }
}
if(!isset($db)) {
  require "setting/db.php";
}
$objOrder = ["local_ward.id" => "DESC"];

if (isset($_GET["cid"]) && $_GET["cid"]) {
    $objSqlMore['AND']['local_ward.cid'] = $_GET["cid"];
}

if (isset($_GET["did"]) && $_GET["did"]) {
    $objSqlMore['AND']['local_ward.did'] = $_GET["did"];
}

$objSqlMore["ORDER"] = $objOrder;

$dataResponse = $database->select("local_ward",["id","ti","cid","did"],$objSqlMore);

if($dataResponse) {
    $message = "total Item: ".count($dataResponse);
    $code =200;
} else {
    $message = $language["dataNotfound"];
}
