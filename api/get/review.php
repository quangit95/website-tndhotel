<?php
if (isset($url_data[3]) && $url_data[3] ) {
    $iId = intval($url_data[3]);
    $file = FOLDERREVIEW . $iId . ".xml";

    $information = null;
    if (is_file($file)) {
        $information = simplexml_load_file($file);
        $information = json_encode($information);
        $information = json_decode($information, true);

        if(isset($_GET["app"])) {
            $sub = arrSearch($menuTable, "pa=={$iId}");
            $information["sub"] = $sub;
        }

        if(isset($_GET["detail"])) {
            $detailList = isset($information["detail"])?$information["detail"] : null;
            $json = array();
            if($detailList){
                foreach($detailList as $key=> $value){
                    $value["menuid"] = $iId;
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

    $file = FOLDERREVIEW . "review.xml";
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

    if (isset($_GET["st"]) && $_GET["st"]) {
        $dataList = arrSearch($dataList, "st=={$_GET["st"]}");
    }

    if (isset($_GET["st_l"]) ) {
        $_GET["st_l"] = intval($_GET["st_l"])>0 ? intval($_GET["st_l"]):0;
        $dataList = arrSearch($dataList, "st<={$_GET["st_l"]}");
    }
    if (isset($_GET["st_g"]) ) {
        $_GET["st_g"] = intval($_GET["st_g"])>0 ? intval($_GET["st_g"]):0;
        $dataList = arrSearch($dataList, "st>={$_GET["st_g"]}");
    }

    if (isset($_GET["tag"]) && $_GET["tag"]) {
        $filter_array = array_filter($dataList, function ($obj) {
            if (isset($obj["tg"]) && count($obj["tg"])) {
                return strtolower($obj["tg"]) == strtolower($_GET["tag"]);
            }
            else {
                return false;
            }
        });
        $dataList = $filter_array;
    }

    if(isset($_GET["sortId"]) && $_GET["sortId"]) {
        if($_GET["sortId"] == 'ASC') {
            usort($dataList, function($a, $b)
            {
                return intval($a["id"] ?? 0) <=> intval($b["id"] ?? 0);
            });
        }
        else {
            usort($dataList, function($a, $b)
            {
                return intval($b["id"] ?? 0) <=> intval($a["id"] ?? 0);
            });
        }
    }

    if (isset($_GET["limit"])) {
        $dataList = array_slice( $dataList, 0, intval($_GET["limit"]) );
    }
        $dataResponse = array_values($dataList);
    }
}
?>
