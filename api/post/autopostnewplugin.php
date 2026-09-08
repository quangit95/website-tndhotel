<?php

if(!isset($_SESSION["adminlog"])) {
  die();
}

$mod = isset($_GET["model"]) ? strval($_GET["model"]) : null;
$numberLoop = isset($_GET["numberloop"]) ? intval($_GET["numberloop"]) : 2;
$strPathFile =FOLDERHOME."{$mod}/";
$file = $strPathFile."list.xml";


if(is_file($file)) {
    $itemList = simplexml_load_file($file);
    $itemList = json_encode($itemList);
    $itemList = json_decode($itemList, true);
}

if(isset($itemList["table"])) {
  $tmpList = array_values($itemList["table"]);
  $total = count($tmpList);

  if($total > 0 ){
    $numberLoop = $numberLoop * $total;
    $lastobj = end($tmpList);
    for($i=$lastobj["id"]; $i< $lastobj["id"]+$numberLoop; $i++) {
      $strNode = $i+1;
      $tmpCopy = $tmpList[$i%$total];
      $tmpCopy["id"] = $strNode;
      $itemList["table"]["id_{$strNode}"] = $tmpCopy;
    }
  }
  if (saveXMLFile($file, $itemList)) {
      $code = 200;
      $message = count($itemList["table"]);
  }
}
?>
