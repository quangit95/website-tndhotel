<?php
$isPageNotFound = false;
$fileId = $pageMenu["id"];
$file = FOLDERMENU . $fileId . ".xml";
$pageInfo = null;
$arrayPathUrl = null;


if (is_file($file)) {
    $pageInfo = simplexml_load_file($file);
    $pageInfo = json_encode($pageInfo);
    $pageInfo = json_decode($pageInfo, true);
    $path_img = FOLDERSLIDEMENU . $pageInfo["db"]["id"] . "/";

    if (isset($pageInfo["detail"]) && count($pageInfo["detail"]) > 0) {
        usort($pageInfo["detail"], function($a, $b){
              return intval($a["so"] ?? 0) <=> intval($b["so"] ?? 0);
        });
    }
    
    if($multiLanguage) {
        if(isset($pageInfo["db"]["ti"][$langcode]) ){
            $jsonChangeLanguage = array(
                "id"=>$pageInfo["db"]["id"],
                "url"=>isset($pageInfo["db"]["url"]) ? $pageInfo["db"]["url"]:null
            );
            $pageInfo["db"]["ti"] = !empty($pageInfo["db"]["ti"][$langcode]) ? $pageInfo["db"]["ti"][$langcode]:null;
        }
        if(isset($pageInfo["db"]["ti1"][$langcode]) ){
            $pageInfo["db"]["ti1"] = !empty($pageInfo["db"]["ti1"][$langcode]) ? $pageInfo["db"]["ti1"][$langcode]:null;
        }
        if(isset($pageInfo["more"][$langcode]) ){
            $pageInfo["more"]["contentCustom"] = !empty($pageInfo["more"][$langcode]["contentCustom"]) ? $pageInfo["more"][$langcode]["contentCustom"]:null;
            $pageInfo["more"]["description"] = !empty($pageInfo["more"][$langcode]["description"]) ? $pageInfo["more"][$langcode]["description"]:null;
        }
        if(isset($pageInfo["detail"]) && count($pageInfo["detail"])>0) {
            foreach ($pageInfo["detail"] as $key => $value) {
                $pageInfo["detail"][$key]["title"] = isset($value["title"][$langcode]) ? $value["title"][$langcode] : null;
                $pageInfo["detail"][$key]["description"] = isset($value["description"][$langcode]) ? $value["description"][$langcode] : null;
            }
        }

        if(isset($pageInfo["meta"][$langcode]) ){
            $pageInfo["meta"] = !empty($pageInfo["meta"][$langcode]) ? $pageInfo["meta"][$langcode]:null;
        }
    }
    $arrayPathUrl = array(
        array("title"=>$pageInfo["db"]["ti"])
    );

    if(isset($pageInfo["db"]["pa"]) && intval($pageInfo["db"]["pa"]) > 0 ){
        $parentId = $pageInfo["db"]["pa"];
        $pageInfoParent = simplexml_load_file(FOLDERMENU . $parentId . ".xml");
        $pageInfoParent = json_encode($pageInfoParent);
        $pageInfoParent = json_decode($pageInfoParent, true);
        if(isset($pageInfoParent["db"]["ti"])) {
            $arrayPathUrlPlus = array(
                array(
                    "title"=>$pageInfoParent["db"]["ti"],
                    "url"=>isset($pageInfoParent["db"]["link"]) && !empty($pageInfoParent["db"]["link"])?$pageInfoParent["db"]["link"]:"/".$pageInfoParent["db"]["url"]
                )
            );
            array_splice($arrayPathUrl, 0, 0, $arrayPathUrlPlus);
        }
    }
    $list_file = readImageDir($path_img);
    $bannerSlide = isset($list_file["image"]) ? $list_file["image"] : null;
    // check page not found
    if( isset($url_data[2]) ) {
        $strUrlEndcode = preg_replace('/[^a-zA-Z0-9]+/', ' ', $url_data[2]);
        $strTitleEndcode = preg_replace('/[^a-zA-Z0-9]+/', ' ', strtolower(endcode_vn($pageInfo["db"]["ti"])));
        if($strUrlEndcode !== $strTitleEndcode ) {
            $isPageNotFound = true;
        }
    }
    $column = isset($pageInfo["column"]["main"]) && !empty($pageInfo["column"]["main"]) ? $pageInfo["column"] : null;
} else {
    $isPageNotFound = true;
}

if($arrayPathUrl) {
    $arrayPathUrlPlus = array(
        array("title"=>$language["homepage"], "url"=>"/")
    );
    array_splice($arrayPathUrl, 0, 0, $arrayPathUrlPlus);
}

if($isPageNotFound) {
    require dirname(__FILE__) . '/notfound.php';
}
else {
    function main() {
        global $seo_name, $language, $pageInfo, $pageInfoParent, $menuTable, $fileId, $arrayPathUrl, $customResponsiveDefault, $strItemTemplate, $strDataFolderTemplate;
        $urlQuery = "&cat={$pageInfo["db"]["id"]}";
        $db = $pageInfo["db"];
        $className = "view-items-{$db["id"]}";
        $customclassName = isset($db["clc"]) && !empty($db["clc"]) ? $db["clc"]: null;

        $customResponsive = isset($db["clr"])&& !empty($db["clr"])?$db["clr"]: $customResponsiveDefault;
        $catMore = isset($pageInfo["more"])?$pageInfo["more"]:null;

        $viewItemList = 3;

        if($catMore) {
            if(isset($catMore["showItem"])) {
                $viewItemList = $catMore["showItem"];
            }
        }

        $viewNumberItem = 12;
        $strContentCat = null;
        $strTabContent = null;
        $listCategoryGroup = null;
        $strListPath = null;
        $strTotalClass = null;
        $strListCategoryGroup = null;
        $file_menu = $strDataFolderTemplate."page/menu{$db["opp"]}.php";
        
        $strSortInList = "id=-1";
        $strTitle = $pageInfo["db"]["ti"];
        $parentId = $pageInfo["db"]["id"];
        if($pageInfoParent) {
            $strTitle = $pageInfoParent["db"]["ti"];
            $parentId = $pageInfoParent["db"]["id"];
            $strSortInList = (isset($pageInfoParent["more"]["sortItem"])&& !empty($pageInfoParent["more"]["sortItem"])) ? $pageInfoParent["more"]["sortItem"] : $strSortInList;
            if(!$customclassName) {
                $customclassName = isset($pageInfoParent["db"]["clc"]) && !empty($pageInfoParent["db"]["clc"])?$pageInfoParent["db"]["clc"]: null;
            }
        } else {
            $arrayPathUrl = null;
        }

        $strSortInList = (isset($pageInfo["more"]["sortItem"])&& !empty($pageInfo["more"]["sortItem"])) ? $pageInfo["more"]["sortItem"] : $strSortInList;

        $listCategoryGroup = arrSearch($menuTable, "pa=={$parentId}");


        if($arrayPathUrl) {

            foreach ($arrayPathUrl as $key => $value) {
                if(isset($value["url"])) {
                    $strListPath .= "<li><a href=\"{$value["url"]}\">{$value["title"]}&nbsp; <i class=\"fa fa-angle-double-right\"></i></a></li>";
                } else {
                    $strListPath .= "<li><strong class=\"text-color-2\">{$value["title"]}</strong></li>";
                }
            }
            $strListPath = "<ul class=\"path-url\">{$strListPath}</ul>";

        }

        $totalCategory = 0;

        if($listCategoryGroup) {
            $slideAttr = 'data-slick-slide data-arrows="false" data-slick-responsive="3" data-slick-infinite="true" data-auto-play="5000" data-slick-show="4"';
            $totalCategory = count($listCategoryGroup);
            if($totalCategory == 2) {
                $strTotalClass = "col-sm-8 col-sm-offset-2";
                $slideAttr = 'data-slick-slide data-arrows="false" data-slick-responsives="3" data-slick-infinite="true" data-auto-play="5000" data-slick-show="2"';
            }
            if($totalCategory == 3) {
                $strTotalClass = "col-sm-10 col-sm-offset-1";
                $slideAttr = 'data-slick-slide data-arrows="false" data-slick-responsive="2" data-slick-infinite="true" data-auto-play="5000" data-slick-show="3"';
            }
            foreach ($listCategoryGroup as $key => $value) {
                $formatListCategoryGroup = '<div class="item item-page-icon sub-page-id-{4}">
                    <div class="img">
                        <figure>
                            <span class="i-center">
                                <img alt="{1}"
                                    src="{2}" class="image-load-finished">
                            </span>
                        </figure>
                    </div>
                    <h4 class="text-center text-title-2 title-arrow-down">
                        <a href="{3}" class="text-uppercase">{1}</a>
                    </h4>
                </div>';
                if(isset($value["im"]) && $value["im"]) {
                    $strImageCat = "/".FOLDERIMAGEMENU.$value["im"];
                    $strLinkCat = isset($value["link"]) && !empty($value["link"]) ? $value["link"] : "/".$value["url"];
                    $strListCategoryGroup .= formatStrArguments($formatListCategoryGroup, isset($value["ti1"]) && !empty($value["ti1"]) ? $value["ti1"] : $value["ti"], $strImageCat,$strLinkCat, $value["id"]);
                }
            }
            $strListCategoryGroup = $strListCategoryGroup ? '<div class="row" data-add-class-active-to-obj=".sub-page-id-'.$pageInfo["db"]["id"].',active"><div class="col-xs-12 '.$strTotalClass.'"><div class="review-slide category-list-icon radius" '.$slideAttr.'>'.$strListCategoryGroup.'</div></div></div>': null;
        }
        // category tab content
        if (isset($pageInfo["detail"]) && $pageInfo["detail"]) {
            $i = 0;
            foreach ($pageInfo["detail"] as $key => $value) {
                $strTag = isset($value["tag"]) && !empty($value["tag"])? $value["tag"] : null;
                $strAttr = isset($value["tag"]) && !empty($value["attr"])? $value["attr"] : null;
                if ($value["title"] && $value["description"]) {
                    if($db["opp"]==4) {
                        $strTabContent .= '<div class="tag-faq tag-faq-'.$strTag.'"><div data-toggle-next class="bg-transparent tab-title icon-question '.($i == 0 ? "active":null ).'"><strong data-parent-toggle="active">' . $value["title"] . '</strong></div>
                            <div class="tab-content" '.$strAttr.'><div class="tab-description" >' . $value["description"] . '</div></div></div>';
                    } else {
                        $strTabContent .= '<div class="item-content"'.$strAttr.'>
                              <h3 class="icon tab-title">' . $value["title"] . '</h3>
                              <div class="tab-content"><div class="description tab-description" >' . $value["description"] . '</div></div>
                          </div>';
                    }
                }
                $i++;
            }
        }

        echo $strListPath;

        /*if(is_file($file_menu)) {
            require($file_menu);
        } else{
            $file_menu = dirname(__FILE__)."/menu_{$db["opp"]}.php";
            if(is_file($file_menu)) {
                require($file_menu);
            }
        }*/

        $file_menu = dirname(__FILE__)."/menu_{$db["opp"]}.php";

        if(is_file($file_menu)) {
            require($file_menu);
        }
    }
}
