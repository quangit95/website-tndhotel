<?php
$mod = isset($post["model"]) ? strval($post["model"]) : null;
if($mod) {
  $strPathFile =FOLDERHOME."{$mod}/";
  $file = $strPathFile."list.xml";
  if(!is_dir($strPathFile)) {
    mkdir($strPathFile);
  }
  if(is_file($file)) {
    echo $file;
  }
}

?>
