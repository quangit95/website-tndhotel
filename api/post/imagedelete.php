<?php

$uid = isset($post["ui"]) ? $post["ui"] : null;
$isUpdate = false;

if(isset($_SESSION["adminlog"]) && $_SESSION["adminlog"]) {
    $isUpdate = true;
} elseif($sessionUserId == $uid ) {
    $isUpdate = true;
}

if ($isUpdate) {
    if(!isset($post["id"]) || !isset($post["m"]) || !isset($post["name"]) ) {
        die();
    }

    $id = $post["id"];

    $filedata = $filedetail = $fileImage = null;

    if($post["m"] == "category") {
        $table = TABLE_CATEGORY;
        $filedetail = FOLDERCATEGORY."{$id}.xml";
        $fileImage = FOLDERIMAGECATEGORY.$post["name"];
    }elseif($post["m"] == "website") {
        $table = TABLE_WEBSITE;
        $filedetail = FOLDERWEBSITE."{$id}.xml";
        $fileImage = FOLDERIMAGEWEBSITE.$post["name"];
    } elseif($post["m"] == "news") {
        $table = TABLE_NEWS;
        $filedetail = FOLDERNEWS."{$id}.xml";
        $fileImage = FOLDERIMAGENEWS.$post["name"];
    } elseif($post["m"] == "template") {
        $filedata = FOLDERTEMPLATE."template.xml";
        $filedetail = FOLDERTEMPLATE.$post["id"].".xml";
        $fileImage = FOLDERIMAGETEMPLATE.$post["name"];
    } elseif($post["m"] == "product") {
        $filedata = FOLDERPRODUCT."product.xml";
        $filedetail = FOLDERPRODUCT.$post["id"].".xml";
        $fileImage = FOLDERIMAGEPRODUCT.$post["name"];
    } elseif($post["m"] == "menu") {
        $filedata = FOLDERMENU."menu.xml";
        $filedetail = FOLDERMENU.$post["id"].".xml";
        $fileImage = FOLDERIMAGEMENU.$post["name"];
    } elseif($post["m"] == "brand") {
        $filedata = FOLDERBRAND."brand.xml";
        $filedetail = FOLDERBRAND.$post["id"].".xml";
        $fileImage = FOLDERIMAGEBRAND.$post["name"];
    } elseif($post["m"] == "blog") {
        $filedata = FOLDERBLOG."blog.xml";
        $filedetail = FOLDERBLOG.$post["id"].".xml";
        $fileImage = FOLDERIMAGEBLOG.$post["name"];
    } elseif($post["m"] == "review") {
        $filedata = FOLDERREVIEW."review.xml";
        $filedetail = FOLDERREVIEW.$post["id"].".xml";
        $fileImage = FOLDERIMAGEREVIEW.$post["name"];
    }

    if(is_file($fileImage) && is_file($filedetail) && is_file($filedata)) {
        $itemList = simplexml_load_file($filedata);
        $itemList = json_encode($itemList);
        $itemList = json_decode($itemList, true);

        $node = "id_".$post["id"];
        if( isset($itemList["table"][$node]["im"]) && $itemList["table"][$node]["im"] == $post["name"] ) {
            unset($itemList["table"][$node]["im"]);

            $information = simplexml_load_file($filedetail);
            $information = json_encode($information);
            $information = json_decode($information, true);
            $information["db"] = $itemList["table"][$node];

            // save file detail
            saveXMLFile($filedetail, $information);

            // save file detail
            saveXMLFile($filedata, $itemList);

            // delefile image
            unlink($fileImage);

            $code = 200;
            $message = "image was delete";
        }

    } elseif(is_file($fileImage) && is_file($filedetail) && isset($table)) {

        if($uid) {
            $rowUpdate = $database->get($table, [
                "id",
                "im"
            ], [
                "id" => $id,
                "uid" => $uid
            ]);
        } else {
            $rowUpdate = $database->get($table, [
                "id",
                "im"
            ], [
                "id" => $id,
            ]);
        }


        // update table
        if($rowUpdate){
            // delefile image
            unlink($fileImage);
            $comfirmRowUpdate = array("id" => $id);
            $infoUpdate = array("im" => "");
            $data = $database->update($table, $infoUpdate, $comfirmRowUpdate );
            if( $data->rowCount() > 0) {
                $information = simplexml_load_file($filedetail);
                $information = json_encode($information);
                $information = json_decode($information, true);

                if(isset($information["db"]["im"])){
                    unset($information["db"]["im"]);
                }
                // save file detail
                saveXMLFile($filedetail, $information);

                $code = 200;
                $message = $language["imageWasDeleted"];
            }
        }
        else {
            $code = 201;
            $message = $language["imageNotDeleted"];
        }

    }
    else {
        $code = 401;
        $errors = "file not found";
    }
} else {
    $code = 401;
    $errors = $language["sessionExpiration"];
}
?>
