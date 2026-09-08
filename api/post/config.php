<?php
$file = FOLDERHOME . "config.xml";
$information = null;
if (is_file($file)) {
    $fileInfo = simplexml_load_file($file);
    $information = json_encode($fileInfo);
    $information = json_decode($information, true);
}

if(isset($post["removednode"]) && $post["removednode"]) {
    if(isset($information["config"]["giainhat"])) {
        unset($information["config"]["giainhat"]);
    }
    if(isset($information["config"]["giainhi"])) {
        unset($information["config"]["giainhi"]);
    }
    if(isset($information["config"]["giaiba"])) {
        unset($information["config"]["giaiba"]);
    }

    if(isset($information["config"]["strgiainhatresult"])) {
        unset($information["config"]["strgiainhatresult"]);
    }

    if(isset($information["config"]["strgiainhiresult"])) {
        unset($information["config"]["strgiainhiresult"]);
    }

    if(isset($information["config"]["strgiaibaresult"])) {
        unset($information["config"]["strgiaibaresult"]);
    }
    saveXMLFile($file, $information);
}

$type = isset($post["config"]["type"])?$post["config"]["type"]:null;

if (!$type) {
    if(isset($post["nodedelete"]) && isset($post["id"]) ) {
        $strNode  = $post["nodedelete"];
        $nodeId = "n_{$post["id"]}";

        if(isset($information["{$strNode}"]["$nodeId"]) ) {
            unset($information["{$strNode}"]["$nodeId"]);
            // save file
            saveXMLFile($file, $information);
            $code = 200;
            $message = $language["updateSuccess"];
        }
        else {
            $code = 401;
            $errors = "can not delete this node";
        }
    }
    else {
        $code = 401;
        $errors = $language["sessionExpiration"];
    }
} else {
    if (isset($post[$type])) {
        if($type == 'account') {
            # update  website
            $accountInfo = $informationWebsite["login"];
            if($accountInfo["password"] == md5($post[$type]["passwordOld"]) ) {
                if($post[$type]["passwordNew"] == $post[$type]["passwordConfirm"] ){
                    $accountInfo["username"] = $post[$type]["username"];
                    $accountInfo["password"] = md5($post[$type]["passwordNew"]);
                    $informationWebsite["login"] = $accountInfo;
                    // save file
                    saveXMLFile($websiteSettingFile, $informationWebsite);
                    $code = 200;
                    $message = $language["updateSuccess"];
                }
                else {
                    $code = 401;
                    $message = "Password don't match";
                }
            }
            else {
                $code = 401;
                $message = "Password invalid";
            }
        } elseif($type=="sidebar" || $type=="filterproperties" || $type=="variantColor"  || $type=="variantSize") {
            $strNode = 1;
            $listDetail = isset($information[$type]) ? $information[$type]:null;

            if (isset($post[$type]["id"]) && $post[$type]["id"]) {
                $strNode = $post[$type]["id"];
            } elseif ($listDetail) {
                $lastobj = end($listDetail);
                $strNode = intval($lastobj["id"]) + 1;
            }

            $post[$type]["id"] = $strNode;
            $post[$type]["so"] = isset($post[$type]["so"]) && $post[$type]["so"] ? intval($post[$type]["so"]):0;

            if(isset($post[$type]["cat"]) && is_array($post[$type]["cat"])) {
                $post[$type]["cat"] =  implode($post[$type]["cat"], ',');
            }

            if(isset($post[$type]["dis"])) {
                $post[$type]["dis"] = implode($post[$type]["dis"], ',');
            }

            $information[$type]["n_{$strNode}"] = $post[$type];

            // save file
            saveXMLFile($file, $information);

            $code = 200;
            $message = $language["updateSuccess"];
        } elseif($type=="payment") {
            $method = isset($post["method"]) ? $post["method"] : null;
            if(isset($post[$type][$method])) {
                $information["config"]["payment"][$method] = $post[$type][$method];
                // save file
                saveXMLFile($file, $information);
                $code = 200;
                $message = $language["updateSuccess"];
            }
            else {
                $code = 201;
                $errors = "notfound method";
            }
        } else {
            if(isset($post["subnode"]) && $post["subnode"]) {
                # check node if is new then add
                $information["config"][$type][$post["subnode"]] = $post[$type][$post["subnode"]];
            } else {
                $information["config"][$type] = $post[$type];
            }

            // save file
            saveXMLFile($file, $information);
            $dataResponse = $information["config"][$type];
            $code = 200;
            $message = $language["updateSuccess"];

        }

    } else {
        $code = 401;
        $errors = "invalidate form";
    }
}

?>
