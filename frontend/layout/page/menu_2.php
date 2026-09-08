<?php
$className = "view-items-{$db["id"]}";
$customclassName = isset($db["clc"])&& !empty($db["clc"])?$db["clc"]: "layout-square";
$customResponsive = isset($db["clr"])&& !empty($db["clr"])?$db["clr"]: "[1020,5], [800, 4], [546, 3], [0,2]";
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
$viewNumberItem = 12;
$strCustomMenuTemplate = isset($pageInfo["db"]["opl"]) && !empty($pageInfo["db"]["opl"]) ? $pageInfo["db"]["opl"]: null;

$strLocalListItem = "localBlogList";

if(isset($pageInfo["more"]["numberItem"]) && $pageInfo["more"]["numberItem"]) {
    $viewNumberItem = $pageInfo["more"]["numberItem"];
}

if(isset($pageInfo["more"]["contentCustom"]) && !empty($pageInfo["more"]["contentCustom"])){
    ?>
    <div class="description">
        <?=$pageInfo["more"]["contentCustom"]?>
    </div>
    <?php
} else {

    echo $strTabContent ? '<div data-ui-tabs data-tab-class="ui-tabs" data-mobile-title="tab-title"><div class="product-des">'.$strTabContent.'</div></div>':'';

    if(!empty($listCatChild)) {
        foreach ($listCatChild as $key => $value) {
            $strInitObject = 'viewListCat'.$value["id"];
            $listCatChildId[]=$value["id"];
            $tmpLimit = 48;
            $tmpUrl = APIGETBLOG."?sortId=DESC&limit={$tmpLimit}&cat={$value["id"]}";
            $strScriptCat .= '<script src="'.$tmpUrl.'&var=window.'.$strInitObject.'"></script>';
            $tmpTitle = $value["ti"];
            
            $strCustomMenuTemplate = isset($value["opl"]) && !empty($value["opl"]) ? $value["opl"]: null;

            $strShowCat .= '<div class="news"
                    data-view-list-by-handlebar
                    data-init-object="'.$strLocalListItem.'" '.$strCustomMenuTemplate.' 
                    data-filter-init=\'[
                        {"name":"cat","value":",'.$value["id"].',","compare":"checkin"},
                        {"name":"st","value":"2","compare":"from"}
                    ]\'
                    data-init-button-magic=".item [data-button-magic]"
                    data-method="get"
                    data-show-page="6"
                    data-show-item="8"
                    data-str-sort="id=-1"
                    data-show-all="false"
                    data-scroll-view="false"
                    data-slide="true"
                    data-ignore-hash="true"
                    data-template-id="entryItemBlogViewSlide" >
                        <div class="title"><h2>'.$tmpTitle.'</h2></div>
                        <div class="row" data-content data-slick-show="2" data-arrows="true" data-adaptive-height="false">
                            <div class="style-loadding"></div>
                        </div>
                    </div>
                    <div class="news-link news-link-block"
                    data-view-list-by-handlebar
                    data-init-object="'.$strLocalListItem.'"
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
                            <div class="style-loadding text-center"><span class="fa fa-spinner fa-spin fa-3x fa-fw"></span></div>
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
    else {
        $strFilter = "[
            {\"name\":\"cat\",\"value\":\",".implode(',', $listCatChildId).",\",\"compare\":\"checkin\"},
            {\"name\":\"st\",\"value\":\"2\",\"compare\":\"from\"}
        ]";

        $tmpTitle = '<span>'.$pageInfo["db"]["ti"].'</span> ';
        if(isset($pageInfo["db"]["ti1"]) && !empty($pageInfo["db"]["ti1"])) {
            $tmpTitle .= $pageInfo["db"]["ti1"];
        }

    ?>
        <script src="<?=$getUrlCategory?>"></script>
        <div class="description more-info">
            <div class="title">
                <h1><?=$tmpTitle?></h1>
            </div>
            <?php
            // category description
            if (isset($catMore["description"]) && !empty($catMore["description"]) ) {
              echo $catMore["description"];
            } 
            ?>
            <div class="content">
                <div class="news hidden-xs"
                    data-view-list-by-handlebar
                    data-url="<?=APIGETBLOG."?geturl=1".$urlQuery;?>"
                    data-init-object="<?=$strLocalListItem?>"
                    data-filter-init='<?=$strFilter?>'
                    data-method="get"
                    data-show-page="6"
                    data-show-item="<?=$viewNumberItem?>" <?=$strCustomMenuTemplate?>
                    data-show-all="false"
                    data-scroll-view="false"
                    data-str-sort="id=-1"
                    data-template-id="<?=$strItemTemplate["blog"];?>" >
                    <div class="view-items" data-content>
                        <div class="style-loadding text-center"><span class="fa fa-spinner fa-spin fa-3x fa-fw"></span></div>
                    </div>
                    <div data-footer></div>
                </div>
                <div class="news news-m hidden-sm hidden-md hidden-lg "
                    data-view-list-by-handlebar
                    data-url="<?=APIGETBLOG."?geturl=1".$urlQuery;?>"
                    data-init-object="<?=$strLocalListItem?>"
                    data-filter-init='<?=$strFilter?>'
                    data-method="get"
                    data-show-page="6"
                    data-show-item="<?=$viewNumberItem?>" <?=$strCustomMenuTemplate?>
                    data-show-all="false"
                    data-scroll-view="true"
                    data-sroll-bottom=".flag-scroll-bottom"
                    data-template-id="<?=$strItemTemplate["blog"];?>" >
                    <div class="view-items" data-content>
                        <div class="style-loadding text-center"><span class="fa fa-spinner fa-spin fa-3x fa-fw">&nbsp;</span></div>
                    </div>
                    <div class="icon-loading"><span class="fa fa-spinner fa-spin fa-3x fa-fw">&nbsp;</span></div>
                </div>
                <div class="clearfix">&nbsp;</div>
                <div class="flag-scroll-bottom">&nbsp;</div>
            </div>
        </div>
    <?php }
}
?>
