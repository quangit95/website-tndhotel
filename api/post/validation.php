<?php
# username and password was setting in account of system

$strMod = isset($post["mod"])? $post["mod"]:null;

$code = 201;
$errors = "Invalid owner website";


if($strMod == "chathost" && isset($post["db"])) {
    if(isset($post["db"]["id"]) && isset($post["db"]["code"]) ) {
      $id = $post["db"]["id"];
      $file = FOLDERWEBSITE . "{$id}.xml";
      if (is_file($file)) {
          $information = simplexml_load_file($file);
          $information = json_encode($information);
          $information = json_decode($information, true);
      }
      if(isset($information["template"]["boxchatcode"]) && $information["template"]["boxchatcode"] === md5($post["db"]["code"])) {
        $code = 200;
        $dataResponse = $post["db"];
        $errors = null;
      }
    }

} elseif($strMod == "chatRemove" && isset($post["websiteId"])) {
  $post["remove"] = $post["websiteId"];
  unset($post["websiteId"]);
  $code = 200;
  $errors = null;
  $dataResponse = $post;
} elseif(isset($post["websiteId"]) && isset($post["websiteOwner"])) {
  $id = $post["websiteId"];
  $file = FOLDERWEBSITE . "{$id}.xml";
  if (is_file($file)) {
      $information = simplexml_load_file($file);
      $information = json_encode($information);
      $information = json_decode($information, true);
  }
  if(isset($information["template"]["boxchatcode"]) && $information["template"]["boxchatcode"] === md5($post["websiteOwner"])) {
    $code = 200;
    $errors = null;
  }

}

