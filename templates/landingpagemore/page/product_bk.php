
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

                if(isset($pageInfo["db"]["pa"]) && intval($pageInfo["db"]["pa"]) > 0 ){
                    $parentId = $pageInfo["db"]["pa"];
                    $pageInfoParent = simplexml_load_file(FOLDERMENU . $parentId . ".xml");
                    $pageInfoParent = json_encode($pageInfoParent);
                    $pageInfoParent = json_decode($pageInfoParent, true);
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
        global $seo_name, $language, $itemInfomation, $fileId, $informationConfig, $menuList, $pageInfo, $pageInfoParent, $arrayPathUrl, $socialHotline, $customResponsiveDefault, $protocol;
        $itemId = $itemInfomation["db"]["id"];
        $urlSlide = APIGETSLIDEPRODUCT."/".$itemId;

        $value = $pageInfo["db"];
        $customclassName = isset($value["clc"])&& !empty($value["clc"])?$value["clc"]: null;

        if(!$customclassName) {
            $customclassName = isset($pageInfoParent["db"]["clc"])&& !empty($pageInfoParent["db"]["clc"])?$pageInfoParent["db"]["clc"]: null;
        }

        $customResponsive = isset($value["clr"])&& !empty($value["clr"])?$value["clr"]: $customResponsiveDefault;
        $slideProductLayout = isset($value["ps"])&& !empty($value["ps"])?$value["ps"]: 1;
        $strSlideImage = null;
        $strBlockPrice = null;
        $strImageDefault = null;
        $strBlockAddress = null;
        $strBlockYoutube = null;
        $strBlockMapInfo = null;
        $strBlockMoreDetail = null;
        $strBlockSortContent = isset($itemInfomation["more"]["content"]) && !empty($itemInfomation["more"]["content"]) ? '<div class="more-content">'.$itemInfomation["more"]["content"].'</div>' : null;
        $strBlockNoteProductDes = isset($informationConfig["config"]["order"]["productdetail"]) && !empty($informationConfig["config"]["order"]["productdetail"]) ?$informationConfig["config"]["order"]["productdetail"]:null;

        $strBlockMoreDescription = null;
        $strBlockNoteDetail = null;
        $strBlockSameTag = null;
        $strBlockSameCategory = null;


        $strLocalListItem = "localProductList";

        $strBlockTitle = '<h1>'.$itemInfomation["db"]["ti"].'</h1>';
        if(isset($itemInfomation["db"]["ct"]) ) {
            $strBlockTitle .='<div class="init-none p-content">'.$itemInfomation["db"]["ct"].'</div>';
        }

        $strListPath = '<div class="block-path-product"
                    data-view-template=".block-path-product"
                    data-template-id="blockPathProduct"
                    data-view-template-local="true"
                    data-copy-template></div>';

        $strBlockOrders = '<div class="row btn-action">
                        <div class="col-xs-7">
                            <a class="btn btn-default btn-lg btn-block text-uppercase"
                                href="tel:<?=$socialHotline?>"><i class="fa fa-phone"></i> '.$socialHotline.'</a>
                        </div>
                        <div class="col-xs-5">
                            <span class="btn btn-block btn-primary btn-buy-detail"
                                data-button-magic
                                data-ajax-url="'.APIPOSTADDTOCART.'"
                                data-method="POST"
                                data-format-json="true"
                                data-params=\'{"sid":"1","pid":"'.$itemInfomation["db"]["id"].'","add":"1"}\'
                                data-redirect="/orders"> <strong class="init-none"> '.$language["orderNow"].'</strong> <i class="fa fa-cart-plus fa-2x"></i></span>
                        </div>
                    </div>';

        if(isset($pageInfo["more"]["noteDetail"]) && !empty($pageInfo["more"]["noteDetail"])) {
            $strBlockNoteDetail = $pageInfo["more"]["noteDetail"];
        } elseif(isset($pageInfoParent["more"]["noteDetail"]) && !empty($pageInfoParent["more"]["noteDetail"]) ) {
            $strBlockNoteDetail = $pageInfoParent["more"]["noteDetail"];
        }

        if(isset($itemInfomation["db"]["tag"]) && !empty($itemInfomation["db"]["tag"])) {
            $strFilter = "[
                {\"name\":\"tag\",\"value\":\"".$itemInfomation["db"]["tag"]."\",\"compare\":\"equal\"},
                {\"name\":\"st\",\"value\":\"2\",\"compare\":\"from\"}
            ]";

            $strBlockSameTag = '<div class="product-more-slide has-button-bottom">
                <h3 class="box-title-1 title-down">'.$language["productSameTag"].'</h3>
                <div class="item-view-products '.$customclassName.'"
                data-view-list-by-handlebar
                data-elm-data=\'{"urlRedirect":"/orders"}\'
                data-init-button-magic=".item [data-button-magic]"
                data-url="'.APIGETPRODUCT.'"
                data-params=\'{"sort":"ASC","tag":"'.$itemInfomation["db"]["tag"].'"}\'
                data-method="get"
                data-init-object="'.$strLocalListItem.'"
                data-filter-init=\''.$strFilter.'\'
                data-show-page="10"
                data-show-item="24"
                data-show-all="false"
                data-scroll-view="false"
                data-form-filter=".form-filter"
                data-slide="true"
                data-template-id="entryViewProduct" >
                    <div class="row slide-more">
                        <div data-content
                            class="view-items"
                            data-arrows="true"
                            data-slick-responsive="3"
                            data-slick-infinite="false"
                            data-slick-show="4">
                            <div class="style-loadding"></div>
                        </div>
                    </div>
                </div>
            </div>';
        }


        if(isset($itemInfomation["db"]["im"]) && !empty($itemInfomation["db"]["im"])) {
            $strImageDefault = '<div class="img-info"><img src="/'.FOLDERIMAGEPRODUCT.$itemInfomation["db"]["im"].'"></div>';
        }

        if($slideProductLayout == 1) {
            $strSlideImage = $strImageDefault;
        } elseif($slideProductLayout == 2) {
            $strSlideImage = '<div class="p-slide-image" data-view-list-by-handlebar data-ignore-hash="true" data-url="'.$urlSlide.'" data-method="get" data-show-page="10" data-show-item="10" data-show-all="true"
                    data-scroll-view="false" data-template-id="entryProductSlideShow" data-slide="true">
                    <div class="view-items" data-arrows="true" data-slick-infinite="true" data-auto-play="4000" data-content><div class="style-loadding"></div></div>'.$strImageDefault.'
                </div>';
        } elseif($slideProductLayout == 3) {
            $strSlideImage =  '<div class="p-slide-image" data-view-list-by-handlebar data-ignore-hash="true" data-url="'.$urlSlide.'"
                    data-method="get" data-show-page="10" data-show-item="10" data-show-all="true" data-scroll-view="false" data-template-id="entryProductSlideShow" data-slide="true" data-ignore-visible="true">
                    <div class="view-items" data-arrows="false" data-adaptive-height="true" data-content><div class="style-loadding"></div></div>'.$strImageDefault.'
                </div>';
            $strSlideImage .= '<div class="o-hidden"><div class="p-slide-image1" data-view-list-by-handlebar data-ignore-hash="true" data-url="'.$urlSlide.'"
                data-method="get" data-show-all="true" data-scroll-view="false" data-template-id="entryProductSlideShow" data-slide="true" data-ignore-visible="true">
                <div class="view-items" data-arrows="true" data-slick-show="4" data-slick-center-mode="true" data-slick-infinite="false" data-variable-width="false" data-focus-on-select="true" data-slick-relative=".p-slide-image .view-items" data-content><div class="style-loadding"></div></div>
            </div></div>';
        }

        if(isset($itemInfomation["db"]["pr"])) {
            $price = isset($itemInfomation["db"]["pr"]["sale"]) && !empty($itemInfomation["db"]["pr"]["sale"]) ? $itemInfomation["db"]["pr"]["sale"] : 0;
            $priceOff = isset($itemInfomation["db"]["pr"]["off"]) && !empty($itemInfomation["db"]["pr"]["off"]) ? $itemInfomation["db"]["pr"]["off"] : 0;
            if($price > 0) {
                if( $priceOff ) {
                    $strBlockPrice = ' <span data-format-currency class="p-off">'.($price).'</span>'.
                    ' <span data-format-currency class="p-sale">'.($priceOff).'</span>'.
                    ' <span data-format-currency class="p-save">'.($price-$priceOff).'</span>';
                } else {
                    $strBlockPrice = '<span data-format-currency class="p-sale">'.$price.'</span>';
                }
            } else {
                $strBlockPrice = $language["price"].": Liên hệ";
            }
        }

        $strBlockPrice = '<div class="price-detail">'.$strBlockPrice.'</div>';

        $moreContent = isset($itemInfomation["more"]) ? $itemInfomation["more"]: null;
        $moreDetail = isset($itemInfomation["detail"]) ? $itemInfomation["detail"]: null;
        $strDescription = null;
        $strMedia = null;

        if($moreContent) {
            if(isset($moreContent["description"]) && !empty($moreContent["description"])) {
                $strDescription .= '<div class="more-description" id="default">'.$itemInfomation["more"]["description"].'</div>';
            }
        }
        if(isset($moreContent["isShowSlide"])){
            $strDescription .='<script src="'.$urlSlide.'?var=window.viewSlideProduct"></script> <div class="hidden-xs">
                <div class="title"><h2>'.$language["productImage"].'</h2></div>
                <div class="item-view-slide-image item-view-slide-image-product" data-view-list-by-handlebar data-ignore-hash="true" data-init-object="viewSlideProduct" data-method="get" data-show-page="10" data-show-item="10" data-show-all="true"
                    data-scroll-view="false" data-img-lightbox=".item-view-slide-image [data-lightbox]" data-template-id="entrySlideItemGallery">
                    <div data-content><div class="style-loadding"></div></div>
                </div>
                </div>';
        }

        if(isset($moreContent["youtubeId"]) && !empty($moreContent["youtubeId"])){
            $strMediaClass .="has-video ";
            $strBlockYoutube ='<div class="product-media-video">
                <div class="media-title"><h3>'.$language["video"].'</h3></div>
                <div class="view-frame-youtube-video"
                    data-copy-template=""
                    data-elm-data=\'{"source":"'.$moreContent["youtubeId"].'"}\'
                    data-view-template=".view-frame-youtube-video"
                    data-template-id="entryItemYoutubeVideo">
                </div>
            </div>';
        }


        $strMediaClass="row-media ";
        if ($moreDetail) {
            foreach ($itemInfomation["detail"] as $key => $value) {
              if ($value["title"] && $value["description"]) {
                $strDescription .= '<div class="item-content">
                      <h3 class="icon tab-title">' . $value["title"] . '</h3>
                      <div class="tab-content" ><div class="tab-description" >' . $value["description"] . '</div></div>
                  </div>';
              }
            }
            $strDescription = $strDescription ? '<div data-ui-tabs data-tab-class="ui-tabs" data-mobile-title="tab-title" data-ignore-hash="false" data-scroll-to="true" data-fixed=".description-info" data-fixed-class="ui-nav-fixed"><div class="product-des">'.$strDescription.'</div></div>':null;
        }

        if($strMedia) {
            $strMedia = "<div class=\"{$strMediaClass}\">{$strMedia}</div>";
        }

        $strFormatDetailProduct = '<div class="class="product-detail">
                <div class="row description-info">
                    <div class="col-xs-12 col-sm-6 col-right">
                        slide image
                    </div>
                    <div class="col-xs-12 col-sm-6">
                        product info
                    </div>
                </div>
            </div>';

        // formatStrArguments($pageInfo["customproductpage"]["content"], $itemInfomation["db"]["ui"], $itemInfomation["db"]["ci"],$strListPath, $strBlockTitle, $strBlockPrice, $strBlockAddress,$strBlockNoteDetail, $strBlockMoreDescription, $strImage, $strBlockMapInfo, $strBlockYoutube  );
        echo $strListPath;

        $strFilter = "[
            {\"name\":\"cat\",\"value\":\"".$itemInfomation["db"]["cat"]."\",\"compare\":\"in\"},
            {\"name\":\"st\",\"value\":\"2\",\"compare\":\"from\"}
        ]";

        $strBlockSameCategory ='<div class="product-more">
            <div class="item-view-products '.$customclassName.'"
            data-view-list-by-handlebar
            data-init-button-magic=".item [data-button-magic]"
            data-elm-data=\'{"urlRedirect":"/orders"}\'
            data-url="'.APIGETPRODUCT.'"
            data-params=\'{"cat":"'.$itemInfomation["db"]["cat"].'","sort":"ASC"}\'
            data-method="get"
            data-init-object="'.$strLocalListItem.'"
            data-filter-init=\''.$strFilter.'\'
            data-show-page="10"
            data-show-item="24"
            data-show-all="false"
            data-scroll-view="false"
            data-ignore-hash="true"
            data-form-filter=".form-filter"
            data-template-id="entryViewProduct" >
                <h3 class="box-title-1 title-down">'.$language["productSameCategory"].'</h3>
                <div data-content
                    class="view-items"
                    data-center-items
                    data-class-name="view-items-mobile"
                    data-item-class=".item"
                    data-responsive="true"
                    data-items-custom="'.$customResponsive.'">
                    <div class="style-loadding"></div>
                </div>
                <div data-footer></div>
            </div>
        </div>';
        ?>
        <script src="<?=APIGETPRODUCT."/".$itemId;?>?var=window.itemDetail"></script>
        <div class="product-detail">
            <div class="row description-info">
                <div class="col-xs-12 col-sm-6 col-right">
                    <?php echo $strSlideImage?>
                </div>
                <div class="col-xs-12 col-sm-6">
                    <div data-fixeds="#slide-banner,#main-menu"
                        data-fixed-width="760"
                        data-fixed-class="filter-fixed"
                        data-fixed-stop=".item-view-products, .container-f1"
                        data-fixed-closet=".container">
                        <div class="info">
                            <?=$strBlockTitle?>
                            <?=$strBlockPrice;?>
                            <?=$strBlockOrders?>
                            <?=$strBlockNoteDetail?>
                            <?=$strBlockSortContent?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="description">
                <?php
                echo $strDescription.$strMedia;
                echo $strBlockNoteProductDes;
                ?>
            </div>
        </div>

        <?php
        $currentUrl = "http://{$_SERVER["HTTP_HOST"]}{$_SERVER["REQUEST_URI"]}";
        $strCommentFb = isset($pageInfo["db"]["cmf"]) && $pageInfo["db"]["cmf"]==2 ? '<div class="fb-comments" data-href="'.$currentUrl.'" data-numposts="5"></div>' : null;
        echo $strCommentFb;
        echo $strBlockSameTag;
        ?>
        <div class="clearfix"></div>
        <?=$strBlockSameCategory?>
    <?php
        unset($value);
    }

}

?>
