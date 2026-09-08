<?php
$code = 200;
$dataList = [];
if(isset($_GET["test"]) ) {
  $file = FOLDERHOME."{$_GET["test"]}.xml";
  if(is_file($file)) {
      $information = simplexml_load_file($file);
      if($information) {
        $information = json_encode($information);
        $information = json_decode($information, true);
        $dataList = $information["table"];
      }
  }
}
$dataResponse = array_values($dataList);
?>
