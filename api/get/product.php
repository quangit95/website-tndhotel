<?php
$callStartTime = microtime(true);
if (isset($url_data[3]) && $url_data[3] ) {
    $iId = intval($url_data[3]);
    $file = FOLDERPRODUCT . $iId . ".xml";

    $information = null;
    if (is_file($file)) {
        $information = simplexml_load_file($file);
        $information = json_encode($information);
        $information = json_decode($information, true);

        if(isset($_GET["app"])) {
            $sub = arrSearch($menuTable, "pa=={$iId}");
            $information["sub"] = $sub;
        }

        if(isset($_GET["pricelist"])) {
            $priceList = isset($information["db"]["pl"])?$information["db"]["pl"] : null;
            $json = array();
            if($priceList){
                foreach($priceList as $key=> $value){
                    $json[] = $value;
                }
            }
            $dataResponse = $json;
        } elseif(isset($_GET["detail"])) {
            $detailList = isset($information["detail"])?$information["detail"] : null;
            $json = array();
            if($detailList){
                foreach($detailList as $key=> $value){
                    $value["title"] = is_array($value["title"]) && !empty($value["title"]) && isset($value["title"][$langcode]) ? $value["title"][$langcode] : $value["title"];
                    $value["description"] = is_array($value["description"]) && !empty($value["description"]) && isset($value["description"][$langcode]) ? $value["description"][$langcode] : $value["description"];
                    $json[] = $value;
                }
            }
            $dataResponse = $json;
        } elseif(isset($_GET["detailId"])) {
            $detailId  = $_GET["detailId"];
            $node = "n_{$detailId}";
            if(isset($information["detail"][$node])) {
                $information["detail"][$node]["menuid"] = $iId;
                $dataResponse["detail"] = $information["detail"][$node];
            } else {
                die();
            }
        }
        else {
            $dataResponse = $information;
        }
    }
}
else {

    $file = FOLDERPRODUCT . "product.xml";
    $information = null;
    if (is_file($file)) {
        $information = simplexml_load_file($file);
        $information = json_encode($information);
        $information = json_decode($information, true);
    }

    $code = 200;

    if (!$information) {
        $dataResponse = array();
    } else {
        $dataList = $information["table"];

        if($multiLanguage && $dataList && isset($_GET["titleNoObj"])) {
            foreach ($dataList as $key => $value) {
                $dataList[$key]["ti"] = isset($dataList[$key]["ti"]["$langcode"]) ? $dataList[$key]["ti"]["$langcode"] : null;
            }
        }

        if (isset($_GET["st"]) && $_GET["st"]) {
            $dataList = arrSearch($dataList, "st=={$_GET["st"]}");
        }



        if (isset($_GET["title"]) && $_GET["title"]) {
            if($multiLanguage && $dataList) {
                $title = strtolower(endcode_vn(trim($get["title"])));
                $title = explode(' ', $title);

                $filter_array = array_filter($dataList, function ($obj) {
                    global $title,$langcode;
                    if(!isset($obj['ti'][$langcode]))
                        return false;
                    $strTitle = strtolower(endcode_vn($obj['ti'][$langcode]));

                    foreach ($title as $key => $value) {
                        if(strpos($strTitle , $value ) === false) {
                            return false;
                        }
                    }
                    return true;
                });
                $dataList = $filter_array;
            } else {
                $title = strtolower(endcode_vn(trim($get["title"])));
                $title = explode(' ', $title);
                $filter_array = array_filter($dataList, function ($obj) {
                    global $title;

                    if(!isset($obj['ti']) || empty($obj['ti']))
                        return false;
                    $strTitle = strtolower(endcode_vn($obj['ti']));

                    foreach ($title as $key => $value) {
                        if(strpos($strTitle , $value ) === false) {
                            // var_dump(strpos( strtolower(endcode_vn($obj['ti'])), $value ));
                            return false;
                        }
                    }
                    return true;
                });
                $dataList = $filter_array;
            }
        }

        if (isset($_GET["st_l"]) ) {
            $_GET["st_l"] = intval($_GET["st_l"])>0 ? intval($_GET["st_l"]):0;
            $dataList = arrSearch($dataList, "st<={$_GET["st_l"]}");
        }
        if (isset($_GET["st_g"]) ) {
            $_GET["st_g"] = intval($_GET["st_g"])>0 ? intval($_GET["st_g"]):0;
            $dataList = arrSearch($dataList, "st>={$_GET["st_g"]}");
        }

        if (isset($_GET["cat"]) && $_GET["cat"]) {
            $filter_array = array_filter($dataList, function ($obj) {
                if (!isset($obj["cat"])) {
                    return false;
                }
                $catIds = explode(',', $_GET["cat"]);
                $isInCat = false;
                foreach ($catIds as $value) {
                    if( in_array($value, explode(',', $obj["cat"])) )
                    {
                        $isInCat = true;
                        break;
                    }
                }
                return $isInCat;
            });
            $dataList = $filter_array;
        }
        if (isset($_GET["sta"]) && $_GET["sta"]) {
            $filter_array = array_filter($dataList, function ($obj) {
                if (!isset($obj["sta"])) {
                    return false;
                }
                if($obj["sta"] == $_GET["sta"]){
                    return true;
                }
                return false;
            });
            $dataList = $filter_array;
        }

        if (isset($_GET["ci"]) && $_GET["ci"]) {
            $filter_array = array_filter($dataList, function ($obj) {
                if (!isset($obj["ci"])) {
                    return false;
                }
                if($obj["ci"] == $_GET["ci"]){
                    return true;
                }
                return false;
            });
            $dataList = $filter_array;
        }

        if(isset($_GET["si_to"]) && $_GET["si_to"]) {
            $filter_array = array_filter($dataList, function ($obj) {
                if (!isset($obj["si"])) {
                    return false;
                }
                if(intval($obj["si"]) <= intval($_GET["si_to"])){
                    return true;
                }
                return false;
            });
            $dataList = $filter_array;
        }

        if(isset($_GET["si_from"]) && $_GET["si_from"]) {
            $filter_array = array_filter($dataList, function ($obj) {
                if (!isset($obj["si"])) {
                    return false;
                }
                if(intval($obj["si"]) >= intval($_GET["si_from"])){
                    return true;
                }
                return false;
            });
            $dataList = $filter_array;
        }

        if(isset($_GET["pr_to"]) && $_GET["pr_to"]) {
            $filter_array = array_filter($dataList, function ($obj) {
                if (!isset($obj["pr"]["sale"]) && $obj["pr"]["sale"]) {
                    return false;
                }
                if( floatval($obj["si"]) <= floatval($obj["pr"]["sale"]) ){
                    return true;
                }
                return false;
            });
            $dataList = $filter_array;
        }

        if(isset($_GET["pr_from"]) && $_GET["pr_from"]) {
            $filter_array = array_filter($dataList, function ($obj) {
                if (!isset($obj["pr"]["sale"]) && $obj["pr"]["sale"]) {
                    return false;
                }
                if( floatval($obj["si"]) >= floatval($obj["pr"]["sale"]) ){
                    return true;
                }
                return false;
            });
            $dataList = $filter_array;
        }

        if (isset($_GET["sta"]) && $_GET["sta"]) {
            $filter_array = array_filter($dataList, function ($obj) {
                if (!isset($obj["sta"])) {
                    return false;
                }
                if($obj["sta"] == $_GET["sta"]){
                    return true;
                }
                return false;
            });
            $dataList = $filter_array;
        }

        if (isset($_GET["tag"]) && $_GET["tag"]) {
            $filter_array = array_filter($dataList, function ($obj) {
                if (isset($obj["tag"]) && !empty($obj["tag"])) {
                    return strtolower($obj["tag"]) == strtolower($_GET["tag"]);
                }
                else {
                    return false;
                }
            });
            $dataList = $filter_array;
        }

        if (isset($_GET["limit"])) {
            $dataList = array_slice( $dataList, 0, intval($_GET["limit"]) );
        }

        if(isset($discountPercent) && $discountPercent > 0) {
            $dataList =  array_map(function($val) {
                global $discountPercent;
                if(isset($val["pr"]["sale"])) {
                    $val["pr"]["discount"] = $discountPercent;
                    $val["pr"]["off"] = $val["pr"]["sale"]*($discountPercent/100);
                }
                return $val;
            }, $dataList);
        }

        if(isset($_GET["sort"]) ) {
            if($_GET["sort"] == 'ASC') {
                usort($dataList, function($a, $b)
                {
                    return intval($a["so"] ?? 0) <=> intval($b["so"] ?? 0);
                });
            } else {
                usort($dataList, function($a, $b)
                {
                    return intval($b["so"] ?? 0) <=> intval($a["so"] ?? 0);
                });
            }
        } elseif(isset($_GET["sortId"]) && $_GET["sortId"]) {
            if($_GET["sortId"] == 'ASC') {
                usort($dataList, function($a, $b)
                {
                    return intval($a["id"] ?? 0) <=> intval($b["id"] ?? 0);
                });
            } else {
                usort($dataList, function($a, $b)
                {
                    return intval($b["id"] ?? 0) <=> intval($a["id"] ?? 0);
                });
            }
        }

        $dataResponse = array_values($dataList);
    }
}
$callEndTime = microtime(true);
$callTime = $callEndTime - $callStartTime;
$message = "calltime: {$callTime} - Current memory usage:".(memory_get_usage(true) / 1024 / 1024)."MB total: ".count($dataResponse);
?>
