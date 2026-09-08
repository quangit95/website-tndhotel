<?php
$nodeUpdate = isset($post["updateNode"])? $post["updateNode"]:null;
$id = isset($post["db"]["id"]) ? $post["db"]["id"] : null;
$isUpdate = false;
if ($userId == $id ) {
    $isUpdate = true;
}

if($isUpdate) {
    $infoUpdate = $post["{$nodeUpdate}"];
    if($nodeUpdate == "db") {
        #update user
        if(isset($infoUpdate["deactive"]) && $infoUpdate["deactive"]) {
            # var_dump($infoUpdate["deactive"]);
            if ($db->db_update($infoUpdate, TABLE_USER, array("id" => $id))) {
                $code = 200;
                $message = $language["updateSuccess"];
            } else {
                $code = 201;
                $message = $language["unknownErrors"];
            }
        } elseif(isset($infoUpdate["email"]) && $infoUpdate["email"]) {
            $code = 301;
            $errors = "Don't update email with app";
        } else {
            $file = FOLDERUSER . $id . ".xml";
            if (is_file($file)) {
                $information = simplexml_load_file($file);
                $information = json_encode($information);
                $information = json_decode($information, true);
            }

            if(isset($infoUpdate["dob"])) {
                $infoUpdate["dob"] = date("Y-m-d", strtotime($infoUpdate["dob"]));
            }

            foreach ($infoUpdate as $key => $value) {
                $information["userinfo"]["db"][$key] = $value;
            }

            if ($db->db_update($infoUpdate, TABLE_USER, array("id" => $id))) {
                saveXMLFile($file, $information);
                $code = 200;
                $message = $language["updateSuccess"];
            } else {
                $code = 201;
                if(isset($infoUpdate["email"]) && $infoUpdate["email"]) {
                    $errors = $language["emailAlreadyRegistered"];
                } else {
                    $errors = $language["updateSuccess"];
                }
            }
        }
    }
}

?>
