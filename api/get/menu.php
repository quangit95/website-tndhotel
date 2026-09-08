<?php
if (isset($url_data[3]) && $url_data[3] ) {
    $iId = intval($url_data[3]);
    $file = FOLDERMENU . $iId . ".xml";

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

    $file = FOLDERMENU . "menu.xml";
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
        /*if($multiLanguage) {
            foreach ($dataList as $key => $value) {
                $dataList[$key]["ti"] = isset($dataList[$key]["ti"]["$langcode"]) ? $dataList[$key]["ti"]["$langcode"] : null;
                $dataList[$key]["ti1"] = isset($dataList[$key]["ti1"]["$langcode"]) ? $dataList[$key]["ti1"]["$langcode"] : null;
            }
        }*/

        if (isset($_GET["opp"]) && $_GET["opp"]) {
            $dataList = arrSearch($dataList, "opp=={$_GET["opp"]}");
        }

        if (isset($_GET["pa"]) && $_GET["pa"]) {
            $dataList = arrSearch($dataList, "pa=={$_GET["pa"]}");
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

        if (isset($_GET["limit"])) {
            $dataList = array_slice( $dataList, 0, intval($_GET["limit"]) );
        }

        $dataResponse = array_values($dataList);
    }
}
?>
