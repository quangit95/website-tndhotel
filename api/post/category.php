<?php
$nodeUpdate = isset($post["updateNode"])? $post["updateNode"]:null;
$uid = isset($post["db"]["uid"]) ? $post["db"]["uid"] : 0;

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
    if($type) {

        # update more (SEO Content, More detail ...)
        $iId = isset($post["db"]["id"]) ? $post["db"]["id"] : null;
        if($iId) {

            $fileDetail = FOLDERCATEGORY . "{$iId}.xml";

            if (is_file($fileDetail)) {
                $itemInfo = simplexml_load_file($fileDetail);
                $itemInfo = json_encode($itemInfo);
                $itemInfo = json_decode($itemInfo, true);

                if($type=="detail") {
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

                    #user update content of category page
                    if($type=="layout" || $type=="config") {
                        foreach ($post[$type] as $key => $value) {
                            $itemInfo[$type][$key] = $value;
                        }
                    } elseif($type=="sidebar") {
                        # var_dump($post["$type"]);
                        if(isset($post["nodedelete"]) && isset($post["id"]) ) {
                            $strNode  = $post["nodedelete"];
                            $nodeId = "n_{$post["id"]}";
                            if(isset($itemInfo["{$strNode}"]["$nodeId"]) ) {
                                unset($itemInfo["{$strNode}"]["$nodeId"]);
                                $code = 200;
                                $message = $language["updateSuccess"];
                            }
                            else {
                                $code = 401;
                                $errors = "can not delete this node";
                            }
                        } else {
                            $strNode = 1;
                            $listDetail = isset($itemInfo[$type]) ? $itemInfo[$type]:null;

                            if (isset($post[$type]["id"]) && $post[$type]["id"]) {
                                $strNode = $post[$type]["id"];
                            } elseif ($listDetail) {
                                $lastobj = end($listDetail);
                                $strNode = intval($lastobj["id"]) + 1;
                            }

                            $post[$type]["id"] = $strNode;
                            $post[$type]["so"] = isset($post[$type]["so"]) && $post[$type]["so"] ? intval($post[$type]["so"]):0;
                            $itemInfo[$type]["n_{$strNode}"] = $post[$type];
                            // save file
                            $code = 200;
                            $message = $language["updateSuccess"];
                        }
                    } else {
                        $itemInfo[$type] = $post[$type];
                    }
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

        if(!isset($infoUpdate["ism"])) {
            $infoUpdate["ism"] = 0;
        }

        if(isset($infoUpdate["id"]) && $infoUpdate["id"] ) {
            # update row
            $iId = $infoUpdate["id"];
            $file = FOLDERCATEGORY . "{$iId}.xml";

            if (is_file($file)) {
                $information = simplexml_load_file($file);
                $information = json_encode($information);
                $information = json_decode($information, true);
            }

            foreach ($infoUpdate as $key => $value) {
                $information["db"][$key] = $value;
            }

            if ($db->db_update($infoUpdate, TABLE_CATEGORY, array("id" => $iId))) {
                saveXMLFile($file, $information);
                $code = 200;
                $message = $language["updateSuccess"];
            }

        }
        else {
            # insert row
            if ($db->db_insert($infoUpdate, TABLE_CATEGORY)) {
                $str_query = "SELECT * FROM ".TABLE_CATEGORY." WHERE url='{$infoUpdate["url"]}' ORDER BY id DESC LIMIT 0,1 ";
                $row = $db->db_array($str_query);
                if ($row) {
                    $file = FOLDERCATEGORY . "{$row["id"]}.xml";
                    $information = array(
                        "db" => $row,
                    );
                    saveXMLFile($file, $information);
                    $code = 200;
                    $message = $language["insertSuccess"];
                }
                else {
                    $code = 201;
                    $errors = $language["insertErrors"];
                }

            } else {
                $code = 401;
                $errors = $language["insertErrors"];
            }
        }
    } elseif($nodeUpdate && $nodeUpdate == "del") {
        # delete item
        $iId = isset($post["id"]) ? $post["id"]:null;
        $uid = isset($post["uid"]) ? $post["uid"]:null;
        if($iId) {
            if($db->db_delete(TABLE_CATEGORY, array("id"=>$iId)) ){
                # delete image, xml, slide file
                $fileXml = FOLDERCATEGORY . "{$iId}.xml";
                $fileImage = "";
                // delete xml file
                if (is_file($fileXml)) {
                    unlink($fileXml);
                }
                // delete image file
                if (is_file($fileImage)) {
                    unlink($fileImage);
                }
                $message = $language["apiResponseSuccess"];
            }
        }
    }  elseif($nodeUpdate && $nodeUpdate == "detail" && isset($post["delId"])) {
        # delete node detail of item
        $iId = $post["id"];
        $fileDetail = FOLDERCATEGORY . "{$iId}.xml";
        if (is_file($fileDetail)) {
            $itemInfo = simplexml_load_file($fileDetail);
            $itemInfo = json_encode($itemInfo);
            $itemInfo = json_decode($itemInfo, true);
            $strNode = $post["delId"];
            if(isset($itemInfo[$nodeUpdate]["n_{$strNode}"])) {
                unset($itemInfo[$nodeUpdate]["n_{$strNode}"]);
            }
            saveXMLFile($fileDetail, $itemInfo);
        }
    }
}
else {
    # missing session
    $errors = "missing session";
    $code = 401;
}

?>
