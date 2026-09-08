<?php
$nodeUpdate = isset($post["updateNode"])? $post["updateNode"]:null;
$uid = isset($post["db"]["uid"]) ? $post["db"]["uid"] : null;
$isUpdate = false;
if (isset($_SESSION["adminlog"]) && $_SESSION["adminlog"]) {
    $isUpdate = true;
}

if(isset($_SESSION["userlog"]["id"]) && $_SESSION["userlog"]["id"] == $uid) {
    $isUpdate = true;
}

if(isset($_SESSION["userlog"]["cid"]) && isset($post["db"]["pid"]) && $_SESSION["userlog"]["cid"] == $post["db"]["pid"]) {
    $isUpdate = true;
}

# check is admin and user is admin
if ($isUpdate) {
    $type = isset($post["db"]["type"]) ? $post["db"]["type"] : null;
    $type = isset($post["db"]["type"]) ? $post["db"]["type"] : null;
    if($type) {
        # update more (SEO Content, More detail ...)
        $iId = isset($post["db"]["id"])?$post["db"]["id"]:null;
        if($iId) {
            $fileDetail = FOLDERNEWS . "{$iId}.xml";

            if (is_file($fileDetail)) {
                $itemInfo = simplexml_load_file($fileDetail);
                $itemInfo = json_encode($itemInfo);
                $itemInfo = json_decode($itemInfo, true);

                if($type == "detail") {
                    $strNode = 1;
                    $listDetail = isset($itemInfo[$type]) ? $itemInfo[$type]:null;
                    if (isset($post[$type]["id"]) && $post[$type]["id"]) {
                        $strNode = $post[$type]["id"];
                    } elseif ($listDetail) {
                        $lastobj = end($listDetail);
                        $strNode = intval($lastobj["id"]) + 1;
                    }
                    $post[$type]["id"] = $strNode;
                    $itemInfo[$type]["n_{$strNode}"] = $post[$type];
                }
                else {
                    $itemInfo[$type] = $post[$type];
                }
                // save file
                saveXMLFile($fileDetail, $itemInfo);
                $code = 200;
                $message = $language["updateSuccess"];
            }
        }
        else {
            die();
        }

    } elseif($nodeUpdate && $nodeUpdate == "db") {

        if(!isset($post[$nodeUpdate])) {
            die();
        }

        $infoUpdate = isset($post[$nodeUpdate]) ? $post[$nodeUpdate] : null;
        # todo reupdate menu_id, category_id to string
        $menu_id = isset($infoUpdate["me"]) ? $infoUpdate["me"] : null;

        if($menu_id) {
            $infoUpdate["me"] = implode($menu_id, ',');
        }
        $category_id = isset($infoUpdate["ca"]) ? $infoUpdate["ca"] : null;
        if($category_id) {
            $infoUpdate["ca"] = implode($category_id, ',');
        }


        if(isset($infoUpdate["id"]) && $infoUpdate["id"] ) {
            # update blog
            $iId = $infoUpdate["id"];
            $file = FOLDERNEWS . "{$iId}.xml";

            if (is_file($file)) {
                $information = simplexml_load_file($file);
                $information = json_encode($information);
                $information = json_decode($information, true);
            }

            foreach ($infoUpdate as $key => $value) {
                $information["db"][$key] = $value;
            }

            if ($db->db_update($infoUpdate, TABLE_NEWS, array("id" => $iId, "uid" => $uid))) {
                saveXMLFile($file, $information);
                $code = 200;
                $message = $language["updateSuccess"];
            }
        }
        else {
            # insert blog
            $infoUpdate["cr"] = $currentTime;
            if ($db->db_insert($infoUpdate, TABLE_NEWS)) {
                $str_query = "SELECT * FROM ".TABLE_NEWS." WHERE cr={$currentTime} ORDER BY id DESC LIMIT 0,1";
                $row = $db->db_array($str_query);

                if ($row) {
                    $file = FOLDERNEWS . "{$row["id"]}.xml";
                    $information = array(
                        "db" => $row,
                    );
                    saveXMLFile($file, $information);
                    $code = 200;
                    $message = $language["insertSuccess"];

                    if(isset($infoUpdate["me"]) && isset($infoUpdate["pid"]) ){
                        #goto edit news
                        $dataResponse = array("urlRedirect" => $_SERVER['HTTP_REFERER']."&node=editnews&id={$row["id"]}");
                    }
                }
                else {
                    $code = 401;
                    $errors = $language["insertErrors"];
                }

            } else {
                $code = 402;
                $errors = $language["insertErrors"];
            }
        }
    } elseif($nodeUpdate == "del") {
        # delete item

        $iId = isset($post["db"]["id"]) ? $post["db"]["id"]:null;
        if($iId) {
            if($db->db_delete(TABLE_NEWS, array("id"=>$iId)) ){
                # delete image, xml, slide file
                $fileXml = FOLDERNEWS . "{$iId}.xml";
                $dirSlide = FOLDERSLIDENEWS . "{$iId}";
                $fileImage = "";
                if (is_file($fileXml)) {
                    // delete image file
                    if (is_file($fileImage)) {
                        unlink($fileImage);
                    }
                    // delete xml file
                    unlink($fileXml);
                }

                if(is_dir($dirSlide))
                {
                    deleteDirectory($dirSlide);
                }

                $code = 200;
                $message = $language["deleteSuccess"];
            }
        }
    }
}
else {
    # missing session
    $errors = "missing session";
    $code = 401;
}

?>
