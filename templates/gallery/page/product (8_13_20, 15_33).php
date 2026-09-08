<?php
$isPageNotFound = false;
$arrayPathUrl = null;
$strListPath = null;

if(!isset($url_data[1]) || isset($url_data[2]) ){
    $isPageNotFound = true;
}

$strParamUrl = explode(".",$url_data[1]);
$fileId = intval($strParamUrl[count($strParamUrl)-1]);
$file = FOLDERPRODUCT . $fileId . ".xml";
$itemInfomation = null;

if (is_file($file)) {
    $itemInfomation = simplexml_load_file($file);
    $itemInfomation = json_encode($itemInfomation);
    $itemInfomation = json_decode($itemInfomation, true);
    $menuCategory = null;
    $pageInfo = null;

    $arrayPathUrl = array(
        array("title"=>$itemInfomation["db"]["ti"])
    );

    if(isset($itemInfomation["db"]["cat"]) && !empty($itemInfomation["db"]["cat"]) ){
        $menuCategory = explode(',', $itemInfomation["db"]["cat"]);
        if(!empty($menuCategory) ) {

            $fileCat = FOLDERMENU . $menuCategory[0] . ".xml";
            if (is_file($fileCat)) {
                $pageInfo = simplexml_load_file($fileCat);
                $pageInfo = json_encode($pageInfo);
                $pageInfo = json_decode($pageInfo, true);

                if(isset($pageInfo["db"]["ti"])) {
                    $arrayPathUrlPlus = array(
                        array(
                            "title"=>$pageInfo["db"]["ti"],
                            "url"=>isset($pageInfo["db"]["link"]) && !empty($pageInfo["db"]["link"])?$pageInfo["db"]["link"]:"/".$pageInfo["db"]["url"]
                        )
                    );
                    array_splice($arrayPathUrl, 0, 0, $arrayPathUrlPlus);
                }
            }
        }
    };

    if($arrayPathUrl) {
        $arrayPathUrlPlus = array(
            array("title"=>$language["homepage"], "url"=>"/")
        );
        array_splice($arrayPathUrl, 0, 0, $arrayPathUrlPlus);
    }

    // check page not found
    array_pop($strParamUrl);
    $strUrlEndcode = preg_replace('/[^a-zA-Z0-9]+/', ' ', implode('.', $strParamUrl));
    $strTitleEndcode = isset($itemInfomation["db"]["ti"][$langcode]) ? $itemInfomation["db"]["ti"][$langcode] : $itemInfomation["db"]["ti"];
    $strTitleEndcode = preg_replace('/[^a-zA-Z0-9]+/', ' ', strtolower(endcode_vn($strTitleEndcode)));
    if($strUrlEndcode !== $strTitleEndcode ) {
        $isPageNotFound = true;
    }

} else {
    $isPageNotFound = true;
}

if($isPageNotFound) {
    require dirname(__FILE__) . '/notfound.php';
}
else {

    function main() {
        global $seo_name, $language, $itemInfomation, $fileId, $informationConfig, $menuList, $formatCurrency, $pageInfo, $pageInfoParent, $arrayPathUrl, $strListPath, $socialHotline, $customResponsiveDefault;

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

        $itemId = $itemInfomation["db"]["id"];
        $urlSlide = APIGETSLIDEPRODUCT."/".$itemId;
        $urlProductDetail = APIGETPRODUCT."/".$itemId;
        $value = $pageInfo["db"];
        $customclassName = isset($value["clc"])&& !empty($value["clc"])?$value["clc"]: "";
        $customResponsive = isset($value["clr"])&& !empty($value["clr"])?$value["clr"]: $customResponsiveDefault;
        $slideProductLayout = isset($value["ps"])&& !empty($value["ps"])?$value["ps"]: 1;

        $productDetailColLeft = "col-xs-12 col-sm-6";
        $productDetailColRight = "col-xs-12 col-sm-6 col-right";
        $strSlideImage = null;
        $strImageDefault = null;
        if(isset($itemInfomation["db"]["im"]) && !empty($itemInfomation["db"]["im"])) {
            $strImageDefault = '<div class="img-info"><a href="/'.FOLDERIMAGEPRODUCT.$itemInfomation["db"]["im"].'" target="_blank"><img src="/'.FOLDERIMAGEPRODUCT.$itemInfomation["db"]["im"].'"></a></div>';
        }
        $itemTitle  = isset($itemInfomation["db"]["ti"])?$itemInfomation["db"]["ti"]:null;
        if($slideProductLayout == 1) {
            $strSlideImage = $strImageDefault;
        } elseif($slideProductLayout == 2) {
            $strSlideImage = '<div class="p-slide-image has-button-top" data-view-list-by-handlebar data-ignore-hash="true" data-url="'.$urlSlide.'" data-method="get" data-show-page="10" data-show-item="10" data-show-all="true"
                    data-scroll-view="false" data-template-id="entryProductSlideShow" data-slide="true">
                    <div class="view-items" data-arrows="true" data-slick-dot="true" data-slick-infinite="true" data-auto-play="2500" data-content><div class="style-loadding"></div></div>'.$strImageDefault.'
                </div>';
        } elseif($slideProductLayout == 3) {
            $strSlideImage =  '<div class="p-slide-image" data-view-list-by-handlebar data-ignore-hash="true" data-url="'.$urlSlide.'"
                    data-method="get" data-show-page="10" data-show-item="10" data-show-all="true" data-scroll-view="false" data-template-id="entryProductSlideShow" data-slide="true" data-ignore-visible="true">
                    <div class="view-items" data-arrows="false" data-adaptive-height="true" data-content><div class="style-loadding"></div></div>'.$strImageDefault.'
                </div>';
            $strSlideImage .= '<div class="o-hidden"><div class="p-slide-image1" data-view-list-by-handlebar data-ignore-hash="true" data-url="'.$urlSlide.'"
                data-method="get" data-show-all="true" data-scroll-view="false" data-template-id="entryProductSlideShow" data-slide="true" data-ignore-visible="true">
                <div class="view-items" data-arrows="true" data-slick-show="4" data-slick-infinite="true" data-variable-width="true" data-focus-on-select="true" data-slick-relative=".p-slide-image .view-items" data-content><div class="style-loadding"></div></div>
            </div></div>';
        }
        echo $strListPath;
        ?>

        <script src="<?=$urlProductDetail?>?var=window.itemDetail"></script>
        <div class="product-detail">
            <?php
            if(isset($itemInfomation["more"]["content"]) && $itemInfomation["more"]["content"]) {
            ?>
            <div class="row description-info">
                <div class="<?=$productDetailColRight?>">
                    <?php echo $strSlideImage?>
                </div>
                <div class="<?=$productDetailColLeft?>">
                    <div data-fixeds="#slide-banner,#main-menu"
                        data-fixed-width="760"
                        data-fixed-class="filter-fixed"
                        data-fixed-stop=".item-view-products, .container-f1"
                        data-fixed-closet=".container">
                        <div class="info">
                            <h1><?=$itemTitle?></h1>
                            <div class="price-detail">
                            <?php
                            if(isset($itemInfomation["db"]["pr"])) {
                                $price = isset($itemInfomation["db"]["pr"]["sale"]) && !empty($itemInfomation["db"]["pr"]["sale"]) ? $itemInfomation["db"]["pr"]["sale"] : 0;
                                $priceOff = isset($itemInfomation["db"]["pr"]["off"]) && !empty($itemInfomation["db"]["pr"]["off"]) ? $itemInfomation["db"]["pr"]["off"] : 0;
                                if($price > 0) {
                                    if( $priceOff ) {
                                        echo ' <span data-format-currency class="p-off">'.($price).'</span>'.
                                        ' <span data-format-currency class="p-sale">'.($priceOff).'</span>'.
                                        ' <span data-format-currency class="p-save">'.($price-$priceOff).'</span>';
                                    } else {
                                        echo '<span data-format-currency class="p-sale">'.$price.'</span>';
                                    }
                                } else {
                                    echo $language["price"].": Liên hệ";
                                }
                            }
                            ?>
                            </div>
                            <?php

                                echo '<div class="more-content">'.$itemInfomation["more"]["content"].'</div>';
                            ?>
                            <div class="row">
                                <div class="col-xs-7">
                                    <a class="btn btn-default btn-lg btn-block text-uppercase"
                                        href="tel:<?=$socialHotline?>"><i class="fa fa-phone"></i> <?=$socialHotline?></a>
                                </div>
                                <div class="col-xs-5">
                                    <span class="btn btn-block btn-primary btn-buy-detail"
                                        data-button-magic
                                        data-ajax-url="<?=APIPOSTADDTOCART?>"
                                        data-method="POST"
                                        data-format-json="true"
                                        data-params='{"sid":"1","pid":"<?=$itemInfomation["db"]["id"]?>","add":"1"}'
                                        data-redirect="/orders"> <strong class="init-none"><?=$language["orderNow"]?></strong> <i class="fa fa-cart-plus fa-2x"></i></span>
                                </div>
                            </div>
                            <?php
                            if(isset($pageInfo["more"]["noteDetail"]) && !empty($pageInfo["more"]["noteDetail"])) {
                                echo $pageInfo["more"]["noteDetail"];
                            } elseif(isset($pageInfoParent["more"]["noteDetail"]) && !empty($pageInfoParent["more"]["noteDetail"]) ) {
                                echo $pageInfoParent["more"]["noteDetail"];
                            } else {
                                echo isset($informationConfig["config"]["about"]["delivery"]) && !empty($informationConfig["config"]["about"]["delivery"]) ?$informationConfig["config"]["about"]["delivery"]:'';
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
            <?php
            }
            else {
            ?>
            <div class="description-info">
                <div class="title">
                    <h1><?=$itemTitle?></h1>
                </div>
                <?php echo $strSlideImage.'<p>&nbsp;</p>';?>
            </div>
            <?php
            }
            ?>
            <div class="description">
                <?php
                $moreContent = isset($itemInfomation["more"]) ? $itemInfomation["more"]: null;
                $moreDetail = isset($itemInfomation["detail"]) ? $itemInfomation["detail"]: null;
                $strDescription = null;
                $strMedia = null;
                $strMediaClass="row-media ";

                if ($moreDetail) {
                    usort($moreDetail, function($a, $b){
                        return intval($a["so"]) > intval($b["so"]);
                    });

                    foreach ($moreDetail as $key => $value) {
                      if ($value["title"] && $value["description"]) {
                        $strDescription .= '<div class="item-content">
                              <h3 class="icon tab-title">' . $value["title"] . '</h3>
                              <div class="tab-content" ><div class="tab-description" >' . $value["description"] . '</div></div>
                          </div>';
                      }
                    }
                    $strDescription = $strDescription ? '<div data-ui-tabs data-tab-class="ui-tabs" data-mobile-title="tab-title" data-ignore-hash="false" data-scroll-to="true" data-fixed=".more-description,.description-info" data-fixed-class="ui-nav-fixed"><div class="product-des">'.$strDescription.'</div></div>':null;

                    if(isset($moreContent["description"]) && !empty($moreContent["description"])) {
                        $strDescription = '<div class="more-description">'.$itemInfomation["more"]["description"].'</div>'.$strDescription;
                    }

                } elseif($moreContent) {
                    if(isset($moreContent["description"]) && !empty($moreContent["description"])) {
                        $strDescription .= '<div class="more-description">'.$itemInfomation["more"]["description"].'</div>';
                    }
                    if(isset($moreContent["isShowSlide"])){

                        $strDescription .='<script src="'.$urlSlide.'?var=window.viewSlideProduct"></script> <div class="hidden-xs">
                            <div class="title"><h2>'.$language["productImage"].'</h2></div>
                            <div class="item-view-slide-image" data-view-list-by-handlebar data-ignore-hash="true" data-init-object="viewSlideProduct" data-method="get" data-show-page="10" data-show-item="10" data-show-all="true"
                                data-scroll-view="false" data-img-lightbox=".item-view-slide-image [data-lightbox]" data-template-id="entrySlideItemGallery">
                                <div data-content><div class="style-loadding"></div></div>
                            </div>
                            </div>';
                    }
                }
                if(isset($moreContent["youtubeId"]) && !empty($moreContent["youtubeId"])){
                    $strMediaClass .="has-video ";
                    $strMedia .='<div class="product-media-video">
                        <div class="media-title"><h3>'.$language["video"].'</h3></div>
                        <div class="view-frame-youtube-video"
                            data-copy-template=""
                            data-elm-data=\'{"source":"'.$moreContent["youtubeId"].'"}\'
                            data-view-template=".view-frame-youtube-video"
                            data-template-id="entryItemYoutubeVideo">
                        </div>
                    </div>';
                }
                if($strMedia) {
                    $strMedia = "<div class=\"{$strMediaClass}\">{$strMedia}</div>";
                }
                echo $strDescription.$strMedia;
                echo isset($informationConfig["config"]["order"]["productdetail"]) && !empty($informationConfig["config"]["order"]["productdetail"]) ?$informationConfig["config"]["order"]["productdetail"]:'';
                ?>
            </div>
        </div>
        <?php

        $currentUrl = "http://{$_SERVER["HTTP_HOST"]}{$_SERVER["REQUEST_URI"]}";
        $strCommentFb = isset($pageInfo["db"]["cmf"]) && $pageInfo["db"]["cmf"]==2 ? '<div class="fb-comments" data-href="'.$currentUrl.'" data-numposts="5"></div>' : null;
        echo $strCommentFb;

        if(isset($itemInfomation["db"]["tag"]) && !empty($itemInfomation["db"]["tag"])) {
            $strFilter = "[
                {\"name\":\"tag\",\"value\":\"".$itemInfomation["db"]["tag"]."\",\"compare\":\"equal\"},
                {\"name\":\"st\",\"value\":\"2\",\"compare\":\"from\"}
            ]";
        ?>
        <div class="product-more-slide has-button-bottom">
            <h3 class="box-title-1 title-down"><?=$language["productSameTag"]?></h3>
            <div class="item-view-products <?=$customclassName?>"
            data-view-list-by-handlebar
            data-elm-data='{"urlRedirect":"/orders"}'
            data-init-button-magic=".item [data-button-magic]"
            data-url="<?=APIGETPRODUCT;?>"
            data-params='{"sort":"ASC","tag":"<?=$itemInfomation["db"]["tag"]?>"}'
            data-method="get"
            data-init-object="<?=$strLocalListItem?>"
            data-filter-init='<?=$strFilter?>'
            data-show-page="10"
            data-show-item="24"
            data-show-all="false"
            data-scroll-view="false"
            data-form-filter=".form-filter"
            data-slide="true"
            data-template-id="entryViewProductHasGallery" >
                <div class="row slide-more">
                    <div data-content
                        class="view-items"
                        data-arrows="true"
                        data-slick-responsive="2"
                        data-slick-infinite="false"
                        data-slick-show="3">
                        <div class="style-loadding"></div>
                    </div>
                </div>
            </div>
        </div>
        <?php
        }
        $strFilter = "[
            {\"name\":\"cat\",\"value\":\"".$itemInfomation["db"]["cat"]."\",\"compare\":\"in\"},
            {\"name\":\"st\",\"value\":\"2\",\"compare\":\"from\"}
        ]";
        ?>
        <div class="clearfix"></div>
        <div class="item-view-products slide-same-category has-button-bottom item-img-icon rectangle2">
            <div class="item-view-products <?=$customclassName?>"
            data-view-list-by-handlebar
            data-init-button-magic=".item [data-button-magic]"
            data-elm-data='{"urlRedirect":"/orders"}'
            data-url="<?=APIGETPRODUCT;?>"
            data-params='{"cat":"<?=$itemInfomation["db"]["cat"]?>","sort":"ASC"}'
            data-method="get"
            data-init-object="<?=$strLocalListItem?>"
            data-filter-init='<?=$strFilter?>'
            data-show-page="6"
            data-show-item="12"
            data-show-all="true"
            data-scroll-view="false"
            data-slide="true"
            data-scroll-bottom=".flag-scroll-bottom"
            data-scroll-space-plus="200"
            data-ignore-hash="true"
            data-form-filter=".form-filter"
            data-template-id="entryViewProductHasGallery" >
                <h3 class="box-title-1 title-down"><?=$language["productSameCategory"]?></h3>
                <div data-content data-arrows="true" data-slick-responsive="2" data-slick-infinite="false" data-slick-show="3"
                    class="view-items">
                    <div class="style-loadding"></div>
                </div>
            </div>
        </div>
        <div class="flag-scroll-bottom">&nbsp;</div>
        <p class="clearfix"></p>

    <?php
        unset($value);
    }

}

?>
