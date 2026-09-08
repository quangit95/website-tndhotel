<?php
if(!$linkReferer) {
    die();
}
$dataList = array();
if (isset($url_data[3]) && $url_data[3] ) {
    $iId = intval($url_data[3]);
    $file = FOLDERORDER . $iId . ".xml";

    $information = null;
    if (is_file($file)) {
        $information = simplexml_load_file($file);
        $information = json_encode($information);
        $information = json_decode($information, true);
        $dataResponse = $information;
    }
}
else {

    $file = FOLDERORDER . "order.xml";
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
    }


    if(isset($_GET["identity"]) && $_GET["identity"]) {

        if (filter_var($_GET["identity"], FILTER_VALIDATE_EMAIL)) {
            $dataList = array_filter($dataList, function ($obj) {
                if($obj["em"] == $_GET["identity"]){
                    return true;
                }
                return false;
            });
        } else {
            $dataList = array_filter($dataList, function ($obj) {
                if($obj["ph"] == $_GET["identity"]){
                    return true;
                }
                return false;
            });
        }

        $dataResponse = array_values($dataList);
        if(count($dataResponse)>0) {
            if(isset($_GET["lastid"])) {
                $itemResponse = $dataResponse[count($dataResponse)-1];
            } elseif(isset($_GET["firstid"])) {
                $itemResponse = $dataResponse[0];
            }

            $dataResponse = $itemResponse;

        } else {
            $code = 201; 
            $errors = "there was no your information found";
        }

        if(isset($_GET["strStorage"]) && $_GET["strStorage"]) {
            $dataResponse[$_GET["strStorage"]] =  json_encode($_GET);
        }
        
        
    } else {
        if(!$linkReferer) {
            die();
        }

        if (isset($_GET["from"]) && $_GET["from"]) {
            $filter_array = array_filter($dataList, function ($obj) {
                if (!isset($obj["dt"])) {
                    return false;
                }
                if($obj["dt"] >= $_GET["from"]){
                    return true;
                }
                return false;
            });
            $dataList = $filter_array;
        }

        if (isset($_GET["to"]) && $_GET["to"]) {
            $filter_array = array_filter($dataList, function ($obj) {
                if (!isset($obj["dt"])) {
                    return false;
                }
                if($obj["dt"] <= $_GET["to"]){
                    return true;
                }
                return false;
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
        } else {
            $dataResponse = array_values($dataList);
        }
    }
}
?>
