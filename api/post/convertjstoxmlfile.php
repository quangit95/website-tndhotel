<?php
$mod = isset($_GET["plugin"]) ? strval($_GET["plugin"]) : null;
if($mod) {
  $strPathFile =FOLDERHOME."{$mod}/";
  $file = $strPathFile."list.xml";
  if(!is_dir($strPathFile)) {
    mkdir($strPathFile);
  }
  if($post) {
    $message = $file;
    $itemList["table"]=[];
    foreach ($post as $key => $value) {
      $itemList["table"]["id_{$value["id"]}"] = $value ;
    }
    $dataResponse= $post;
    saveXMLFile($file, $itemList);
  }
}

?>
