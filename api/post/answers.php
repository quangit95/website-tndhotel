<?php
$callStartTime = microtime(true);
$code = 200;
$message = "Success";
$table = [];

$infoUpdate = isset($post["db"]) ? $post["db"] : [];

if(isset($_GET["match"]) && isset($_GET["test"]) ) {
  $file = FOLDERHOME."{$_GET["match"]}_{$_GET["test"]}.xml";
  if(is_file($file)) {
      $itemList = simplexml_load_file($file);
      if($itemList) {
        $itemList = json_encode($itemList);
        $itemList = json_decode($itemList, true);
      } else {
        unset($itemList);
      }
  }

  $iId = 0;
  if (!isset($itemList)) {
      $iId = 1;
  } else {
      $table = $itemList["table"];
      // edit Item
      if (isset($infoUpdate["id"]) && intval($infoUpdate["id"]) > 0) {
          $iId = intval($infoUpdate["id"]);
      } else {
          // add Item
          $endElmTable = end($table);
          $iId = intval($endElmTable["id"]) + 1;
      }
  }

  $node = 'id_' . $iId;

  if(isset($post["db"]["a"])) {

    if(isset($itemList["table"][$node]["fn"]) && $itemList["table"][$node]["fn"] != $infoUpdate["fn"] ) {
      $code = 201;
      $errors = "Invalid post";
    } else {
      // set id for post
      $infoUpdate["id"] = $iId;
      $infoUpdate["la"] = $currentTime;

      if(isset($_REQUEST["overwritepost"]) && $_REQUEST["overwritepost"] == 1 ) {
        
          $itemList["table"][$node] = $infoUpdate;

      } else {

          foreach ($infoUpdate as $key => $value) {
              if(is_array($value) ) {
                  foreach ($value as $key1 => $value1) {
                      $itemList["table"][$node][$key][$key1] = $value1;
                  }
              } else {
                  $itemList["table"][$node][$key]=$value;
              }
          }
      }

      saveXMLFile($file, $itemList);
      $message = "Your answers saved";
    }
  } elseif(isset($post["validationAnswer"])) {
    if(isset($infoUpdate["fn"]) && isset($infoUpdate["id"]) && isset($itemList["table"][$node]["fn"]) && isset($itemList["table"][$node]["id"]) && $itemList["table"][$node]["fn"] ==$infoUpdate["fn"] && $itemList["table"][$node]["id"]==$infoUpdate["id"]  ) {
      $message = "View your answers";
    } else {
      $code = 201;
      $errors = "Invalid post, please contact to admin";
    }

  }
  $strListanswers = isset($_GET["answerskey"]) && $_GET["answerskey"] ? $_GET["answerskey"] : "listanswers";
  $dataResponse[$strListanswers] = json_encode($itemList["table"][$node]);

  /*$filematch = FOLDERHOME."{$_GET["match"]}/list.xml";
  if(is_file($filematch)) {
      $matchList = simplexml_load_file($filematch);
      $matchList = json_encode($matchList);
      $matchList = json_decode($matchList, true);
      $table = $matchList["table"];

      if($table && count($table)>0) {
        foreach ($post["db"] as $key => $value) {
          if(is_object($value) && $key1 =="a") {
            foreach ($value as $key1 => $value1) {
              $table["db"][$key][$key1] = $value1;
            }
          } else {
            $table["db"][$key]=$value;
          }

        }
      }
  }*/
}

?>
