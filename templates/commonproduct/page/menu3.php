<?php

// category description
if (isset($catMore["description"]) && !empty($catMore["description"]) ) {
  $strContentCat = $catMore["description"];
}

if($catMore) {
    if(isset($catMore["showItem"])) {
        $viewItemList = $catMore["showItem"];
    }

}

$listCatChild = arrSearch($menuTable,"pa=={$fileId}");
$listCatChildId[] = $pageInfo["db"]["id"];
$strShowCat = null;
$dataElmProduct = null;

$viewNumberItem = 12;
$strLocalListItem = "localProductList";
if(isset($pageInfo["more"]["numberItem"]) && $pageInfo["more"]["numberItem"]) {
    $viewNumberItem = $pageInfo["more"]["numberItem"];
}

if(!empty($listCatChild)) {
    foreach ($listCatChild as $key => $value) {
        $listCatChildId[]=$value["id"];
        $tmpUrl = APIGETPRODUCT."?cat={$value["id"]}";
        $tmpTitle = '<span>'.$value["ti"].'</span>';
        if(isset($value["ti1"]) && !empty($value["ti1"])) {
            $tmpTitle .=$value["ti1"];
        }
        $tmpItemClass= "i_{$value["id"]}";
        $tmpCustomclassName = isset($value["clc"])&& !empty($value["clc"])?$value["clc"]: $customclassName;
        $tmpCustomResponsive = isset($value["clr"])&& !empty($value["clr"])?$value["clr"]: $customResponsive;
        $strShowCat .= '<div class="item-view-products '.$tmpCustomclassName.'"
                data-view-list-by-handlebar
                data-init-button-magic=".item [data-button-magic]"
                data-url="'.$tmpUrl.'" '.$dataElmProduct.'
                data-method="get"
                data-init-object="'.$strLocalListItem.'"
                data-filter-init=\'[
                    {"name":"cat","value":",'.$value["id"].',","compare":"checkin"},
                    {"name":"st","value":"2","compare":"from"}
                ]\'
                data-str-sort='.$strSortInList.'
                data-show-page="10"
                data-show-item="'.$viewNumberItem.'"
                data-show-all="false"
                data-scroll-view="false"
                data-ignore-hash="true"
                data-template-id="'.$strItemTemplate["product"].'" >
                <div class="title"><h2>'.$tmpTitle.'</h2></div>
                <div
                    data-content
                    class="view-items"
                    data-center-items
                    data-class-name="'.$tmpItemClass.'"
                    data-item-class=".item"
                    data-responsive="true"
                    data-items-custom="'.$tmpCustomResponsive.'"
                    ><div class="style-loadding">...</div>
                </div>
                <div class="clearfix"></div>
                <div>
                    <div data-footer></div>
                </div>
            </div>';
    }
}

if($listCatChildId && $viewItemList == 1){
    $listCatChildId = [$pageInfo["db"]["id"]];
}
$urlQuery = "&cat=".implode(',', $listCatChildId)."&st_g=2";
$getUrlProduct = APIGETPRODUCT."?var=window.productCategoryList".$urlQuery;
# echo $getUrlProduct;

if(isset($pageInfo["more"]["contentCustom"]) && !empty($pageInfo["more"]["contentCustom"])) {
    echo $pageInfo["more"]["contentCustom"];
} else {
    if($viewItemList == 2) {
        echo $strContentCat ? '<div class="description">'.$strContentCat.'</div>':'';
        echo $strShowCat;
    }
    else {
        /*if($viewItemList == 1) {
            $strFilter = "[
                {\"name\":\"cat\",\"value\":\"".$pageInfo["db"]["id"]."\",\"compare\":\"in\"},
                {\"name\":\"st\",\"value\":\"2\",\"compare\":\"from\"}
            ]";
        } else {
            $strFilter = "[
                {\"name\":\"cat\",\"value\":\"".implode(',', $listCatChildId)."\",\"compare\":\"in\"},
                {\"name\":\"st\",\"value\":\"2\",\"compare\":\"from\"}
            ]";
        }*/

        $strCheckIn = "in";
        if($listCatChildId && count($listCatChildId) > 1) {
            $strCheckIn = "checkin";
        }
        $strFilter = "[
            {\"name\":\"cat\",\"value\":\"".implode(',', $listCatChildId)."\",\"compare\":\"{$strCheckIn}\"},
            {\"name\":\"st\",\"value\":\"2\",\"compare\":\"from\"}
        ]";

    $tmpTitle = '<span>'.$pageInfo["db"]["ti"].'</span> ';
    if(isset($pageInfo["db"]["ti1"]) && !empty($pageInfo["db"]["ti1"])) {
        $tmpTitle .= $pageInfo["db"]["ti1"];
    }
    ?>
    <div class="title">
        <h2><?=$tmpTitle?></h2>
    </div>
    <?php
    echo $strContentCat ? '<div class="description">'.$strContentCat.'</div>':'';
    echo $strTabContent ? '<div data-ui-tabs data-tab-class="ui-tabs" data-mobile-title="tab-title"><div class="product-des">'.$strTabContent.'</div></div>':'';
    ?>
    <div class="item-view-products  <?=$customclassName?>"
        data-view-list-by-handlebar
        data-init-button-magic=".item [data-button-magic]"
        data-url="<?=APIGETPRODUCT."?geturl=1".$urlQuery;?>"
        data-init-object="<?=$strLocalListItem?>"
        data-filter-init='<?=$strFilter?>'
        data-form-filter=".form-filter"
        data-str-sort="<?=$strSortInList?>"
        data-method="get"
        data-show-page="10"
        data-show-item="<?=$viewNumberItem?>"
        data-show-all="false"
        data-scroll-view="true"
        data-scroll-bottom=".flag-scroll-bottom"
        data-scroll-space-plus="300"
        data-template-id="<?=$strItemTemplate["product"]?>" >
        <div
            data-content
            class="view-items"
            data-center-items
            data-space-item="[20,20]"
            data-class-name="view-items-mobile"
            data-item-class=".item"
            data-responsive="true"
            data-items-custom="<?=$customResponsive?>">
            <div class="style-loadding text-center"><span class="fa fa-spinner fa-spin fa-3x fa-fw"></span></div>
        </div>
        <div class="icon-loading"><span class="fa fa-spinner fa-spin fa-3x fa-fw"></span></div>
    </div>
    <div class="clearfix"></div>
    <div class="flag-scroll-bottom"></div>
    <?php
    }
}
?>
