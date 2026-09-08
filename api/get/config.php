<?php
$file = FOLDERHOME . "config.xml";

$information = null;

if (is_file($file)) {
    $fileInfo = simplexml_load_file($file);
    $information = json_encode($fileInfo);
    $information = json_decode($information, true);
    if(isset($_GET["sidebar"]) && $_GET["sidebar"] ==1 ){
        $detailList = isset($information["sidebar"])?$information["sidebar"] : null;
        if (isset($url_data[3]) && $url_data[3] ) {
            $dataResponse = null;
            if(isset($detailList["n_{$url_data[3]}"])) {
                $dataResponse = $detailList["n_{$url_data[3]}"];
            }
        }
        else {
            $json = array();
            if($detailList){
                foreach($detailList as $key=> $value){
                    $json[] = $value;
                }
            }
            $dataResponse = $json;
        }
    } elseif(isset($_GET["variantColor"]) && $_GET["variantColor"] ==1 ){
        $detailList = isset($information["variantColor"])?$information["variantColor"] : null;
        if (isset($url_data[3]) && $url_data[3] ) {
            $dataResponse = null;
            if(isset($detailList["n_{$url_data[3]}"])) {
                $dataResponse = $detailList["n_{$url_data[3]}"];
            }
        }
        else {
            $json = array();
            if($detailList){
                foreach($detailList as $key=> $value){
                    $json[] = $value;
                }
            }
            $dataResponse = $json;
        }
    } elseif(isset($_GET["variantSize"]) && $_GET["variantSize"] ==1 ){
        $detailList = isset($information["variantSize"])?$information["variantSize"] : null;
        if (isset($url_data[3]) && $url_data[3] ) {
            $dataResponse = null;
            if(isset($detailList["n_{$url_data[3]}"])) {
                $dataResponse = $detailList["n_{$url_data[3]}"];
            }
        }
        else {
            $json = array();
            if($detailList){
                foreach($detailList as $key=> $value){
                    $json[] = $value;
                }
            }
            $dataResponse = $json;
        }
    } elseif(isset($_GET["filterproperties"]) && $_GET["filterproperties"] ==1 ){
        $detailList = isset($information["filterproperties"])?$information["filterproperties"] : null;
        if (isset($url_data[3]) && $url_data[3] ) {
            $dataResponse = null;
            if(isset($detailList["n_{$url_data[3]}"])) {
                $dataResponse = $detailList["n_{$url_data[3]}"];
            }
        }
        else {
            $json = array();
            if($detailList){
                foreach($detailList as $key=> $value){
                    $json[] = $value;
                }
            }
            $dataResponse = $json;
        }
    } elseif(isset($_GET["confignode"]) && $_GET["confignode"]) {
        if(isset($information["config"][$_GET["confignode"]])) {
            $dataResponse = $information["config"][$_GET["confignode"]];
        } else {
            $dataResponse = [];
        }
    } else {
        if(isset($information["sidebar"])) {
            unset($information["sidebar"]);
        }
        if(isset($information["config"]["account"]["password"])) {
            unset($information["config"]["account"]["password"]);
        }
        $dataResponse = $information;
    }

}
?>
