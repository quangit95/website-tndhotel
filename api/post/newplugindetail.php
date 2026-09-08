<?php
ini_set('memory_limit', '1024M'); // 1 GB minus 1 MB
$mod = isset($post["model"]) ? strval($post["model"]) : null;
$nodeUpdate = isset($post["updateNode"])? $post["updateNode"]:null;

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

  if($nodeUpdate == "verify") {
    $isVerify = true;
    if(isset($post["strkey"]) && isset($post["strpw"]) && isset($post["id"])) {
      $strKey = explode(',', $post["strkey"]);
      $node = 'id_' . $post["id"];
      if(isset($itemList["table"][$node])) {
        $rowChildren = $itemList["table"][$node];
        if(isset($post[$post["strpw"]]) && md5($post[$post["strpw"]]) != $rowChildren["pw"] ) {
          $isVerify = false;
        }
      }
      foreach ($strKey as $key => $value) {
        if(!isset($post[$value]) || !isset($rowChildren[$value])) {
          $isVerify = false;
          break;
        } elseif($post[$value] != $rowChildren[$value]) {
          $isVerify = false;
          break;
        }
      }

      if($isVerify) {
        $code = 200;
        $fileinfo = $strPathFile . $post["id"] . ".xml";
        $information = null;
        if (is_file($fileinfo)) {
            $information = simplexml_load_file($fileinfo);
            $information = json_encode($information);
            $information = json_decode($information, true);
            if(isset($post["strLocalStorage"])) {
              $dataResponse[$post["strLocalStorage"]] = json_encode($information["db"]);
            }
        }
      } else {
        $code = 201;
        $errors = "invalid User";
      }

    } else {
      $code = 404;
      $errors = "invalid post";
    }

  } elseif($nodeUpdate == "db") {
    $infoUpdate = isset($post[$nodeUpdate]) ? $post[$nodeUpdate] : [];
    if (isset($infoUpdate["pw"]) && $infoUpdate["pw"]) {
      $infoUpdate["pw"] = md5($infoUpdate["pw"]);
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

      $fileInfo = $strPathFile . $iId . ".xml";
      if (is_file($fileInfo)) {
          $information = simplexml_load_file($fileInfo);
          $information = json_encode($information);
          $information = json_decode($information, true);
      }
      $information["db"] = $itemList["table"][$node];
      // save file detail
      if (saveXMLFile($fileInfo, $information)) {
          $dataResponse["table"][$node] = $post;
          $code = 200;
          $message = $language["updateSuccess"];
      } else {
          $code = 501;
          $errors = $language["unknownErrors"];
      }

    } else {
      $code = 201;
      $errors = "invalid post";
    }

    $dataResponse = $infoUpdate;

  }
  elseif($nodeUpdate == "del" && isset($post["id"])) {
      # delete node
      $iId = $post["id"];
      $node = 'id_' . $iId;

      $fileInfo = FOLDERPRODUCT . $iId . ".xml";
      $fileImage = FOLDERIMAGEPRODUCT . $strImg;
      # delete detail file
      if (is_file($fileInfo)) {
          unlink($fileInfo);
      }


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

  } elseif (isset($post["id"]) && $post["id"]) {
    $iId = $post["id"];
    $fileInfo = $strPathFile . $iId . ".xml";
    $type = $nodeUpdate;

    if (is_file($fileInfo)) {
        $information = simplexml_load_file($fileInfo);
        $information = json_encode($information);
        $information = json_decode($information, true);
    }
    if(isset($post["delId"]) && $post["delId"] && $type=="detail") {
        // delete detailmore node
        $strNode = $post["delId"];
        if(isset($information[$type]["n_{$strNode}"])) {
            unset($information[$type]["n_{$strNode}"]);
        }
        // save file
        saveXMLFile($fileInfo, $information);

    } elseif (isset($post[$type]) && $post[$type] ) {

        if($type=="detail") {
            $strNode = 1;
            $listDetail = isset($information[$type]) ? $information[$type]:null;
            if (isset($post[$type]["id"]) && $post[$type]["id"]) {
                $strNode = $post[$type]["id"];
            } elseif ($listDetail) {
                $lastobj = end($listDetail);
                $strNode = intval($lastobj["id"]) + 1;
            }

            $post[$type]["id"] = $strNode;
            $information[$type]["n_{$strNode}"] = $post[$type];
        }
        else {
            foreach ($post[$type] as $key => $value) {
                $information[$type][$key] = $value;
            }
        }
        // save file
        saveXMLFile($fileInfo, $information);
        $code = 200;
        $message = $language["updateSuccess"];
    } else {
        $code = 401;
        $errors = "invalidate form";
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

        $dataResponse[$keyvalue[$i]] = array_values($information["table"]);

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
