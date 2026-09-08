<?php

$mod = isset($post["model"]) ? strval($post["model"]) : null;
$nodeUpdate = isset($post["updateNode"])? $post["updateNode"]:null;

$strSms = isset($_GET["strsms"])? $_GET["strsms"]:null;

if($mod) {
  $strPathFile =FOLDERHOME."{$mod}/";
  $file = $strPathFile."list.xml";
  if(!is_dir($strPathFile)) {
    mkdir($strPathFile);
  }

  if(is_file($file)) {
      $itemList = simplexml_load_file($file);
      $itemList = json_encode($itemList);
      $itemList = json_decode($itemList, true);
  }

  if($nodeUpdate == "db") {
    $infoUpdate = isset($post[$nodeUpdate]) ? $post[$nodeUpdate] : $infoUpdate;

    if(isset($infoUpdate["o"]) && isset($infoUpdate["mq"])) {
      if(is_array($infoUpdate["mq"])) {
        $index = 1;
        foreach ($infoUpdate["mq"] as $key => $value) {
          $infoUpdate["mq"][$key]["id"] = $key;
          if($index<4) {
            $infoUpdate["mq"][$key]["ix"] = $index;
          }
          $index++;
        }

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

    // set id for post
    $infoUpdate["id"] = $iId;
    $itemList["table"][$node] = $infoUpdate;

    if(saveXMLFile($file, $itemList)) {
      $code = 200;
      $message = $strSms ? $strSms : $language["updateSuccess"];
    } else {
      $code = 201;
      $errors = "invalid post";
    }

    $dataResponse = $infoUpdate;

  } elseif($nodeUpdate == "del" && isset($post["id"])) {
      # delete node
      $iId = $post["id"];
      $node = 'id_' . $iId;

      try {
          # remove item from file database
          if(isset($itemList["table"][$node])) {
              unset($itemList["table"][$node]);
              if (saveXMLFile($file, $itemList)) {
                  $code = 200;
                  $message = $language["updateSuccess"];
              }
          }
          else {
              $code = 404;
              $errors = "Not found ITEM";
          }
      } catch (Exception $ex) {
          $code = 501;
          $errors = $language["unknownErrors"];
      } 
  } elseif($nodeUpdate == "clone" && isset($post["id"])) {
      # clone node
      $iId = $post["id"];
      $node = 'id_' . $iId;
      $endElmTable = end($itemList["table"]);
      $endId = intval($endElmTable["id"]) + 1;
      $nodeNew = 'id_' . $endId;
      if(isset($itemList["table"][$node])) {
          $cloneNode = $itemList["table"][$node];
          $cloneNode["id"] = $endId;
          $itemList["table"][$nodeNew] = $cloneNode;
          if(saveXMLFile($file, $itemList)) {
            $code = 200;
            $message = $strSms ? $strSms : $language["updateSuccess"];
          } else {
            $code = 201;
            $errors = "invalid post";
          }

      } else {
          $code = 501;
          $errors = $language["unknownErrors"];
      }   
  }

}

// create file javascript new plugin
if(isset($_GET["keyvalue"]) && $_GET["keyvalue"]) {
  $keyvalue = explode(',', $_GET["keyvalue"]);

  $varobj = isset($_GET["varobj"]) ? explode(',', $_GET["varobj"]) : [];
  $strJs = null;

  for ($i=0; $i < count($keyvalue); $i++) {
    $strPathFile = FOLDERHOME."{$keyvalue[$i]}/";
    $file = $strPathFile."list.xml";
    $information = null;

    if (is_file($file)) {
        $information = simplexml_load_file($file);
        $information = json_encode($information);
        $information = json_decode($information, true);

        if(!isset($_GET["jsonTableDefault"])) {
          $information["table"] = array_values($information["table"]);
        }

        if(count($varobj)>1) {
          $strJs .= $varobj[$i]. "=" . json_encode($information["table"]).";";
        } else {
          $strJs .= $varobj[0].".".$keyvalue[$i] . "=" . json_encode($information["table"]).";";
        }
    }
  }
  if($strJs) {
    # generator javascript blogs file and save to asset folder
      $dirAssets = FOLDERDATAOFWEBSITE."assets/";
      if(!is_dir($dirAssets)) {
          mkdir($dirAssets);
      }
      $fileAccessJs = $dirAssets."newplugin_{$dataOfWebsiteId}.js";
      $pf = fopen ($fileAccessJs, "w");
      fwrite ($pf, $strJs);
      fclose ($pf);
  }

}

?>
