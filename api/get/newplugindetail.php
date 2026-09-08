<?php
ini_set('memory_limit', '1024M'); // 1 GB minus 1 MB

if(!isset($_SERVER['HTTP_REFERER'])) {
  die();
} elseif (strpos($_SERVER['HTTP_REFERER'], $_SERVER["HTTP_HOST"]) !== false) {
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
      $file = $strPathFile . $id . ".xml";
      $information = null;
      if (is_file($file)) {
          $information = simplexml_load_file($file);
          $information = json_encode($information);
          $information = json_decode($information, true);
          if(isset($_GET["detail"])) {
              $detailList = isset($information["detail"])?$information["detail"] : null;
              $json = array();
              if($detailList){
                  foreach($detailList as $key=> $value){
                      $value["menuid"] = $id;
                      $value["title"] = is_array($value["title"]) && !empty($value["title"]) && isset($value["title"][$langcode]) ? $value["title"][$langcode] : $value["title"];
                      $json[] = $value;
                  }
              }
              $dataResponse = $json;
          } elseif(isset($_GET["detailId"])) {
              $detailId  = $_GET["detailId"];
              $node = "n_{$detailId}";
              if(isset($information["detail"][$node])) {
                  $information["detail"][$node]["menuid"] = $id;
                  $dataResponse["detail"] = $information["detail"][$node];
              } else {
                  die();
              }
          }
          else {
              $dataResponse = $information;
              if(isset($_GET["wp"])) {
                if($_GET["wp"]==$information["db"]["pw"]) {
                  /*$detailList = isset($information["detail"])?$information["detail"] : null;
                  $json = array();
                  if($detailList){
                      foreach($detailList as $key=> $value){
                          $value["menuid"] = $id;
                          $value["title"] = is_array($value["title"]) && !empty($value["title"]) && isset($value["title"][$langcode]) ? $value["title"][$langcode] : $value["title"];
                          $json[] = $value;
                      }
                      $dataResponse["detail"] = $json;
                  }*/
                } else {
                  $dataResponse = [];
                }
              }
          }
      }
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
}
?>
