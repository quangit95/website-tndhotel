<?php

$isPageNotFound = false;

if(!isset($url_data[1]) || isset($url_data[3]) ){
    $isPageNotFound = true;
}

$fileId = $url_data[1];
$file = FOLDERMENU . $fileId . ".xml";
$pageInfo = null;

if (is_file($file)) {
    $pageInfo = simplexml_load_file($file);
    $pageInfo = json_encode($pageInfo);
    $pageInfo = json_decode($pageInfo, true);
    $seo = isset($pageInfo["meta"])?$pageInfo["meta"]: null;

    $web_title = isset($seo["title"]) && count($seo["title"]) ? $seo["title"]:null;
    $web_description = isset($seo["keyword"]) && count($seo["keyword"]) ? $seo["keyword"]:null;
    $web_description = isset($seo["description"]) && count($seo["description"]) ?$seo["description"]:null;
    $path_img = FOLDERSLIDEMENU . $pageInfo["db"]["id"] . "/";

    $list_file = readImageDir($path_img);
    $bannerSlide = $list_file["image"] ? $list_file["image"] : null;

    // check page not found
    if( isset($url_data[2]) ) {
        $strUrlEndcode = preg_replace('/[^a-zA-Z0-9]+/', ' ', $url_data[2]);
        $strTitleEndcode = preg_replace('/[^a-zA-Z0-9]+/', ' ', strtolower(endcode_vn($pageInfo["db"]["ti"])));
        if($strUrlEndcode !== $strTitleEndcode ) {
            $isPageNotFound = true;
        }
    }

} else {
    $isPageNotFound = true;
}

if($isPageNotFound) {
    require dirname(__FILE__) . '/notfound.php';
}
else {

    function main() {
        global $seo_name, $language, $pageInfo;

        if(isset($pageInfo["more"]["description"]) && count($pageInfo["more"]["description"])){
            ?>
            <div class="more-info">
                <div class="title">
                    <h1><?=$pageInfo["db"]["ti"]?></h1>
                </div>
                <div class="content">
                    <?=$pageInfo["more"]["description"]?>
                </div>
            </div>
            <?php
        } else {
            if (isset($pageInfo["detail"]) && $pageInfo["detail"]) {
                $strTab = null;
                foreach ($pageInfo["detail"] as $key => $value) {
                  if ($value["title"] && $value["description"]) {
                    $strTab .= '<div class="item-content">
                          <h3 class="icon tab-title">' . $value["title"] . '</h3>
                          <div class="tab-content" ><div class="tab-description" >' . $value["description"] . '</div></div>
                      </div>';
                  }
                }
                echo $strTab ? '<div data-ui-tabs data-tab-class="ui-tabs" data-mobile-title="tab-title"><div class="product-des">'.$strTab.'</div></div>':'';
            }
        }
    }
}
