<?php
$mod = isset($_GET["plugin"]) ? strval($_GET["plugin"]) : null;
$id = isset($_GET["id"]) ? strval($_GET["id"]) : null;

if($mod) {
  $strPathFile =FOLDERHOME."{$mod}/";
  $file = $strPathFile."list.xml";
  $information = null;
  if (is_file($file)) {
      $information = simplexml_load_file($file);
      $information = json_encode($information);
      $information = json_decode($information, true);
  }

  $code = 200;

  $dataList = [];

  if (!$information) {
      $dataResponse = array();
  } else {
      $dataList = $information["table"];
  }

  if (isset($_GET["limit"])) {
      $dataList = array_slice( $dataList, 0, intval($_GET["limit"]) );
  }

  if($id) {
    $dataResponse["db"] = $dataList["id_{$id}"];
  } else {
    $dataResponse = array_values($dataList);
  }

} elseif(isset($_GET["keyvalue"]) && $_GET["keyvalue"]) {
  $keyvalue = explode(',', $_GET["keyvalue"]);
  for ($i=0; $i < count($keyvalue); $i++) {
    # code...
    $strPathFile = FOLDERHOME."{$keyvalue[$i]}/";
    $file = $strPathFile."list.xml";
    $information = null;
    if (is_file($file)) {
        $information = simplexml_load_file($file);
        $information = json_encode($information);
        $information = json_decode($information, true);
        $dataResponse[$keyvalue[$i]] = array_values($information["table"]);
    }
  }
}
?>
