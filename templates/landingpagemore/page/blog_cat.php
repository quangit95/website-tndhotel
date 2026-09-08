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
    $column = isset($pageInfo["column"]["main"]) && count($pageInfo["column"]["main"]) ? $pageInfo["column"] : null;
} else {
    $isPageNotFound = true;
}

if($isPageNotFound) {
    require dirname(__FILE__) . '/notfound.php';
}
else {

    function main() {
        global $seo_name, $language, $pageInfo, $menuTable, $fileId;
        $urlQuery = "&cat={$pageInfo["db"]["id"]}";
        $db = $pageInfo["db"];
        $className = "view-items-{$db["id"]}";
        $customclassName = isset($db["clc"])&& count($db["clc"])?$db["clc"]: "layout-square";
        $customResponsive = isset($db["clr"])&& count($db["clr"])?$db["clr"]: "[1020,5], [800, 4], [546, 3], [0,2]";
        $catMore = isset($pageInfo["more"])?$pageInfo["more"]:null;
        $viewItemList = 1;
        if($catMore) {
            if(isset($catMore["showItem"])) {
                $viewItemList = $catMore["showItem"];
            }
        }
        $listCatChild = arrSearch($menuTable,"pa=={$fileId}");
        $listCatChildId[] = $pageInfo["db"]["id"];
        $strShowCat = null;
        $strScriptCat = null;

        if(count($listCatChild)) {
            foreach ($listCatChild as $key => $value) {
                $strInitObject = 'viewListCat'.$value["id"];
                $listCatChildId[]=$value["id"];
                $tmpLimit = 48;
                $tmpUrl = APIGETBLOG."?sortId=DESC&limit={$tmpLimit}&cat={$value["id"]}";
                $strScriptCat .= '<script src="'.$tmpUrl.'&var=window.'.$strInitObject.'"></script>';
                $tmpTitle = $value["ti"];
                $strShowCat .= '<div class="news"
                        data-view-list-by-handlebar
                        data-init-object="'.$strInitObject.'"
                        data-init-button-magic=".item [data-button-magic]"
                        data-method="get"
                        data-show-page="6"
                        data-show-item="8"
                        data-show-all="false"
                        data-scroll-view="false"
                        data-slide="true"
                        data-template-id="entryItemBlogViewSlide" >
                            <div class="title"><h2>'.$tmpTitle.'</h2></div>
                            <div class="row" data-content data-slick-show="2" data-arrows="true" data-adaptive-height="false">
                                <div class="style-loadding"></div>
                            </div>
                        </div>
                        <div class="news-link news-link-block"
                        data-view-list-by-handlebar
                        data-init-object="'.$strInitObject.'"
                        data-ignore-hash="true"
                        data-init-button-magic=".item [data-button-magic]"
                        data-method="get"
                        data-show-page="6"
                        data-show-item="8"
                        data-show-all="false"
                        data-scroll-view="false"
                        data-slide="false"
                        data-template-id="entryItemBlogViewTitle" >
                            <div data-content>
                                <div class="style-loadding"></div>
                            </div>
                            <div data-footer></div>
                        </div>
                        ';
            }
        }

        if($listCatChildId && $viewItemList == 3){
            $urlQuery = "&cat=".implode(',', $listCatChildId);
        }
        $urlQuery .="&st_g=2";
        $getUrlCategory = APIGETBLOG."?sortId=DESC&var=window.viewListCategory".$urlQuery;
        // echo $getUrlCategory;
        if($viewItemList == 2) {
            echo $strScriptCat;
            echo $strShowCat;
        }
        else { ?>
            <script src="<?=$getUrlCategory?>"></script>
            <div class="more-info">
                <div class="title">
                    <h1><?=$pageInfo["db"]["ti"]?></h1>
                </div>
                <div class="content">
                    <div class="news hidden-xs"
                        data-view-list-by-handlebar
                        data-init-object="viewListCategory"
                        data-method="get"
                        data-show-page="6"
                        data-show-item="12"
                        data-show-all="false"
                        data-scroll-view="false"
                        data-template-id="entryItemBlogView" >
                        <div class="view-items" data-content>
                            <div class="style-loadding">...</div>
                        </div>
                        <div data-footer></div>
                    </div>
                    <div class="news news-m hidden-sm hidden-md hidden-lg "
                        data-view-list-by-handlebar
                        data-init-object="viewListCategory"
                        data-method="get"
                        data-show-page="6"
                        data-show-item="12"
                        data-show-all="false"
                        data-scroll-view="true"
                        data-sroll-bottom="#main .sidebar"
                        data-template-id="entryItemBlogView" >
                        <div class="view-items" data-content>
                            <div class="style-loadding">...</div>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>

    <?php
    }
}
