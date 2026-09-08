<?php

$isAction = false;

if(isset($_SESSION["adminlog"]["uid"]) ) {
    $isAction = true;
}

if($isAction) {
    if(isset($post["db"]["id"])) {
      $data = $database->update($post["table"], $post["db"], array("id"=>$post["db"]["id"]) );
    } else {
      #inser
    }
    if($data && $data->rowCount() > 0) {
      $code = 200;
      $message = $language["updateSuccess"];
      # update file javascript local in Vietnam

      $strJsCity = "window.languageText.dropdownLocalOption.city=".json_encode($database->select("local_city",["id","ti","code"]), true);
      $strJsDistrict  = "window.languageText.dropdownLocalOption.district=".json_encode($database->select("local_district",["id","ti","cid"]), true);
      $strJsWard = "window.languageText.dropdownLocalOption.ward=".json_encode($database->select("local_ward",["id","ti","cid","did"]), true);


      $dirAssets = FOLDERDATAOFWEBSITE."assets/";
      if(!is_dir($dirAssets)) {
          mkdir($dirAssets);
      }
      $fileAccessJs = $dirAssets."local.js";
      $pf = fopen ($fileAccessJs, "w");
      fwrite ($pf, $strJsCity."; ".$strJsDistrict."; ".$strJsWard."; " );
      fclose ($pf);
    } else {
    }
}
?>
