<?php
$file = FOLDERAGENCY . "agency.xml";
$itemList = null;
if (is_file($file)) {
    $itemList = simplexml_load_file($file);
    $itemList = json_encode($itemList);
    $itemList = json_decode($itemList, true);
}
$nodeUpdate = isset($post["updateNode"])? $post["updateNode"]:null;

if($nodeUpdate == "db") {
    $infoUpdate = isset($post[$nodeUpdate]) ? $post[$nodeUpdate] : null;
    $iId = 0;
    if (!$itemList) {
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

    if(isset($infoUpdate["st"]) && intval($infoUpdate["st"])){
        $infoUpdate["st"] = intval($infoUpdate["st"]);
    }
    else {
        $infoUpdate["st"] = 0;
    }

    // set id for post
    $infoUpdate["id"] = $iId;
    // update row before save
    foreach ($infoUpdate as $key => $value) {
        $itemList["table"][$node][$key] = $value;
    }

    // save item to file
    if (saveXMLFile($file, $itemList)) {
        $fileInfo = FOLDERAGENCY . $iId . ".xml";
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
        $code = 501;
        $errors = $language["unknownErrors"];
    }
} elseif($nodeUpdate == "del" && isset($post["id"])) {
    # delete node
    $iId = $post["id"];
    $node = 'id_' . $iId;

    try {
        # remove item from file database
        if(isset($itemList["table"][$node])) {
            $strImg = isset($itemList["table"][$node]["im"]) && count($itemList["table"][$node]["im"])>0? strval($itemList["table"][$node]["im"]):null;

            unset($itemList["table"][$node]);

            if (saveXMLFile($file, $itemList)) {
                $fileInfo = FOLDERAGENCY . $iId . ".xml";
                # delete detail file
                if (is_file($fileInfo)) {
                    unlink($fileInfo);
                }
                # delete folder slide
                $folderDel =FOLDERSLIDEMENU.$iId;
                if(is_dir($folderDel)) {
                    deleteDirectory($folderDel);
                }
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
    $fileInfo = FOLDERAGENCY . $iId . ".xml";
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

?>
