<?php
$isPageNotFound = false;
$arrayPathUrl = null;
$productDetailLayout["strListPath"] = null;
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

    $itemId = $itemInfomation["db"]["id"];
    $urlSlide = APIGETSLIDEPRODUCT."/".$itemId;

    $value = $pageInfo["db"];
    $customclassName = isset($value["clc"])&& !empty($value["clc"])?$value["clc"]: null;

    if(!$customclassName) {
        $customclassName = isset($pageInfoParent["db"]["clc"])&& !empty($pageInfoParent["db"]["clc"])?$pageInfoParent["db"]["clc"]: null;
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
        if(isset($itemInfomation)){
            if(isset($itemInfomation["db"]["ti"][$langcode]) ){
                $jsonChangeLanguage = array(
                    "id"=>$itemInfomation["db"]["id"],
                    "page"=>$url_data[0],
                    "ti"=>isset($itemInfomation["db"]["ti"]) ? $itemInfomation["db"]["ti"]:null
                );
                $itemInfomation["db"]["ti"] = !empty($itemInfomation["db"]["ti"][$langcode]) ? $itemInfomation["db"]["ti"][$langcode]:null;
            }

            if(isset($itemInfomation["db"]["ct"][$langcode]) ){
                $itemInfomation["db"]["ct"] = !empty($itemInfomation["db"]["ct"][$langcode]) ? $itemInfomation["db"]["ct"][$langcode]:null;
            }


            if(isset($itemInfomation["more"][$langcode]) ){
                $itemInfomation["more"]["content"] = !empty($itemInfomation["more"][$langcode]["content"]) ? $itemInfomation["more"][$langcode]["content"]:null;
                $itemInfomation["more"]["description"] = !empty($itemInfomation["more"][$langcode]["description"]) ? $itemInfomation["more"][$langcode]["description"]:null;

            }
            if(isset($itemInfomation["meta"][$langcode]) ){
                $itemInfomation["meta"] = !empty($itemInfomation["meta"][$langcode]) ? $itemInfomation["meta"][$langcode]:null;
            }

            if(isset($itemInfomation["detail"]) && count($itemInfomation["detail"])>0) {
                foreach ($itemInfomation["detail"] as $key => $value) {
                    $itemInfomation["detail"][$key]["title"] = isset($value["title"][$langcode]) ? $value["title"][$langcode] : null;
                    $itemInfomation["detail"][$key]["description"] = isset($value["description"][$langcode]) ? $value["description"][$langcode] : null;
                }
            }
        }
    }

    $customResponsive = isset($value["clr"])&& !empty($value["clr"])?$value["clr"]: $customResponsiveDefault;
    $slideProductLayout = isset($value["ps"])&& !empty($value["ps"])?$value["ps"]: 1;
    $productDetailLayout["strSlideImage"] = null;
    $productDetailLayout["strBlockPrice"] = null;
    $strImageDefault = null;
    $productDetailLayout["strBlockAddress"] = null;
    $productDetailLayout["strBlockYoutube"] = null;
    $productDetailLayout["strBlockMapInfo"] = null;
    $productDetailLayout["strBlockSortContent"] = isset($itemInfomation["more"]["content"]) && !empty($itemInfomation["more"]["content"]) ? '<div class="more-content">'.$itemInfomation["more"]["content"].'</div>' : null;
    $productDetailLayout["strBlockNoteProductDes"] = isset($informationConfig["config"]["order"]["productdetail"]) && !empty($informationConfig["config"]["order"]["productdetail"]) ?$informationConfig["config"]["order"]["productdetail"]:null;
    $productDetailLayout["strBlockNoteDetail"] = null;
    $productDetailLayout["strBlockSameTag"] = null;
    $productDetailLayout["strBlockSameCategory"] = null;
    $strLocalListItem = "localProductList";

    $productDetailLayout["strProductId"] =$itemInfomation["db"]["id"];
    $productDetailLayout["strProductCat"] =$itemInfomation["db"]["cat"];
    $productDetailLayout["strBlockTitle"] = '<h1>'.$itemInfomation["db"]["ti"].'</h1>';
    $productDetailLayout["templateBooking"] = null;
    $strTemplateBookingElm = " data-elm-data='{\"id\":\"{$productDetailLayout["strProductId"]}\",\"title\":\"{$itemInfomation["db"]["ti"]}\",\"viewtemplate\":\".form-booking\"}' ";
        if(isset($pageInfo["more"]["templateBooking"]) && $pageInfo["more"]["templateBooking"]) {
            $productDetailLayout["templateBooking"] = '<div class="post-form-booking post-form-booking-page" '.$strTemplateBookingElm.'
                        data-copy-template=""
                        data-view-template-local="true"
                        data-view-template=".post-form-booking-page"
                        data-template-id="'.$pageInfo["more"]["templateBooking"].'"></div>';
        } else if(isset($pageInfoParent["more"]["templateBooking"]) && $pageInfoParent["more"]["templateBooking"]) {
            $productDetailLayout["templateBooking"] = '<div class="post-form-booking post-form-booking-page" '.$strTemplateBookingElm.'
                        data-copy-template=""
                        data-view-template-local="true"
                        data-view-template=".post-form-booking-page"
                        data-template-id="'.$pageInfoParent["more"]["templateBooking"].'"></div>';
        }


    if(isset($itemInfomation["db"]["wid"]) && isset($itemInfomation["db"]["add"]) && isset($itemInfomation["db"]["dis"]) && isset($itemInfomation["db"]["cid"])) {

            $productDetailLayout["strBlockAddress"] = '<div class="view-address"
                    data-elm-data=\'{"add":"'.$itemInfomation["db"]["add"].'","wi":"'.$itemInfomation["db"]["wid"].'","di":"'.$itemInfomation["db"]["dis"].'","ci":"'.$itemInfomation["db"]["cid"].'"}\'
                    data-view-template=".view-address"
                    data-template-id="entryViewAddress"
                    data-view-template-local="true"
                    data-copy-template></div>';
    }

    $productDetailLayout["strListPath"] = '<div class="block-path-product"
                data-view-template=".block-path-product"
                data-template-id="blockPathProduct"
                data-view-template-local="true"
                data-copy-template></div>';

    $productDetailLayout["strBlockOrders"] = '<div class="block-product-btn-buy" data-copy-template data-view-template-local="true" data-view-template=".block-product-btn-buy" data-template-id="entryProductDetailButtonBuy"></div>';

    if(isset($pageInfo["more"]["noteDetail"]) && !empty($pageInfo["more"]["noteDetail"])) {
        $productDetailLayout["strBlockNoteDetail"] = $pageInfo["more"]["noteDetail"];
    } elseif(isset($pageInfoParent["more"]["noteDetail"]) && !empty($pageInfoParent["more"]["noteDetail"]) ) {
        $productDetailLayout["strBlockNoteDetail"] = $pageInfoParent["more"]["noteDetail"];
    }

    if(isset($itemInfomation["db"]["tag"]) && !empty($itemInfomation["db"]["tag"])) {
        $strFilter = "[
            {\"name\":\"tag\",\"value\":\"".$itemInfomation["db"]["tag"]."\",\"compare\":\"equal\"},
            {\"name\":\"st\",\"value\":\"2\",\"compare\":\"from\"}
        ]";

        $productDetailLayout["strBlockSameTag"] = '<div class="product-more-slide has-button-bottom">
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
        $productDetailLayout["strSlideImage"] = $strImageDefault;
    } elseif($slideProductLayout == 2) {
        $productDetailLayout["strSlideImage"] = '<div class="p-slide-image" data-view-list-by-handlebar data-ignore-hash="true" data-url="'.$urlSlide.'" data-method="get" data-show-page="10" data-show-item="10" data-show-all="true"
                data-scroll-view="false" data-template-id="entryProductSlideShow" data-slide="true">
                <div class="view-items" data-arrows="true" data-slick-infinite="true" data-auto-play="2800" data-content><div class="style-loadding"></div></div>'.$strImageDefault.'
            </div>';
    } elseif($slideProductLayout == 3) {
        $productDetailLayout["strSlideImage"] =  '<div class="p-slide-image" data-view-list-by-handlebar data-ignore-hash="true" data-url="'.$urlSlide.'"
                data-method="get" data-show-page="10" data-show-item="10" data-show-all="true" data-scroll-view="false" data-template-id="entryProductSlideShow" data-slide="true" data-ignore-visible="true">
                <div class="view-items" data-arrows="false" data-adaptive-height="true" data-content><div class="style-loadding"></div></div>'.$strImageDefault.'
            </div>';
        $productDetailLayout["strSlideImage"] .= '<div class="o-hidden"><div class="p-slide-image1" data-view-list-by-handlebar data-ignore-hash="true" data-url="'.$urlSlide.'"
            data-method="get" data-show-all="true" data-scroll-view="false" data-template-id="entryProductSlideShow" data-slide="true" data-ignore-visible="true">
            <div class="view-items" data-arrows="true" data-slick-show="4" data-slick-center-mode="true" data-slick-infinite="false" data-variable-width="false" data-focus-on-select="true" data-slick-relative=".p-slide-image .view-items" data-content><div class="style-loadding"></div></div>
        </div></div>';
    }

    if(isset($itemInfomation["db"]["pr"])) {
        $price = isset($itemInfomation["db"]["pr"]["sale"]) && !empty($itemInfomation["db"]["pr"]["sale"]) ? $itemInfomation["db"]["pr"]["sale"] : 0;
        $priceOff = isset($itemInfomation["db"]["pr"]["off"]) && !empty($itemInfomation["db"]["pr"]["off"]) ? $itemInfomation["db"]["pr"]["off"] : 0;
        if($price > 0) {
            if( $priceOff ) {
                $productDetailLayout["strBlockPrice"] = ' <span data-format-currency class="p-off">'.($price).'</span>'.
                ' <span data-format-currency class="p-sale">'.($priceOff).'</span>'.
                ' <span data-format-currency class="p-save">'.($price-$priceOff).'</span>';
            } else {
                $productDetailLayout["strBlockPrice"] = '<span data-format-currency class="p-sale">'.$price.'</span>';
            }
        } else {
            $productDetailLayout["strBlockPrice"] = $language["price"].": Liên hệ";
        }
    }

    $productDetailLayout["strBlockPrice"] = '<div class="price-detail">'.$productDetailLayout["strBlockPrice"].'</div>';

    $moreContent = isset($itemInfomation["more"]) ? $itemInfomation["more"]: null;
    $moreDetail = isset($itemInfomation["detail"]) ? $itemInfomation["detail"]: null;
    $productDetailLayout["strDescription"] = null;
    $productDetailLayout["strDescriptionMore"] = null;
    $productDetailLayout["strDisplayImages"] = null;

    if(isset($itemInfomation["db"]["ct"]) && !empty($itemInfomation["db"]["ct"]) ) {
        $productDetailLayout["strBlockTitle"] .='<div class="init-none p-content">'.$itemInfomation["db"]["ct"].'</div>';
    }
    if(isset($itemInfomation["more"]["description"]) && !empty($itemInfomation["more"]["description"])) {
        $productDetailLayout["strDescription"] = '<div class="more-description">'.$itemInfomation["more"]["description"].'</div>';
    }

    

    if(isset($moreContent["isShowSlide"])){
        $productDetailLayout["strDisplayImages"] ='<script src="'.$urlSlide.'?var=window.viewSlideProduct"></script> <div class="block-images-product-slide">
            <div class="title"><h2>'.$language["productImage"].'</h2></div>
            <div class="item-view-slide-image item-view-slide-image-product" data-view-list-by-handlebar data-ignore-hash="true" data-init-object="viewSlideProduct" data-method="get" data-show-page="30" data-show-item="30" data-show-all="true"
                data-scroll-view="false" data-slide="true" data-img-lightbox=".item-view-slide-image [data-lightbox]" data-template-id="entrySlideItemGallery">
                <div data-content class="view-items" data-arrows="true" data-slick-responsive="3" data-slick-show="3" data-slick-infinite="true" data-auto-play="3500"><div class="style-loadding"></div></div>
            </div>
            </div>';
    }

    if(isset($moreContent["youtubeId"]) && !empty($moreContent["youtubeId"])){
        $productDetailLayout["strBlockYoutube"] ='<div class="product-media-video">
            <div class="media-title"><h3>'.$language["video"].'</h3></div>
            <div class="view-frame-youtube-video"
                data-copy-template=""
                data-elm-data=\'{"source":"'.$moreContent["youtubeId"].'"}\'
                data-view-template=".view-frame-youtube-video"
                data-template-id="entryItemYoutubeVideo">
            </div>
        </div>';
    }

    if ($moreDetail) {
        foreach ($itemInfomation["detail"] as $key => $value) {
          if ($value["title"] && $value["description"]) {
            $productDetailLayout["strDescriptionMore"] .= '<div class="item-content">
                  <h3 class="icon tab-title">' . $value["title"] . '</h3>
                  <div class="tab-content" ><div class="tab-description" >' . $value["description"] . '</div></div>
              </div>';
         }
        }

        $productDetailLayout["strDescriptionMore"] = $productDetailLayout["strDescriptionMore"] ? '<div data-ui-tabs data-tab-class="ui-tabs" data-mobile-title="tab-title" data-ignore-hash="false" data-scroll-to="true" data-fixed=".more-description,.description-info" data-fixed-class="ui-nav-fixed"><div class="product-des">'.$productDetailLayout["strDescriptionMore"].'</div></div>':null;
    }

    $strFilter = "[
        {\"name\":\"cat\",\"value\":\"".$itemInfomation["db"]["cat"]."\",\"compare\":\"in\"},
        {\"name\":\"st\",\"value\":\"2\",\"compare\":\"from\"}
    ]";

    $productDetailLayout["strBlockSameCategory"] ='<div class="clearfix"></div>
    <h3 class="box-title-1 title-down">'.$language["productSameCategory"].'</h3>
    <div class="product-more product-same-category block-product-same-category-normal">
        <div class="item-view-products '.$customclassName.'"
        data-view-list-by-handlebar
        data-init-button-magic=".item [data-button-magic]"
        data-elm-data=\'{"urlRedirect":"/orders"}\'
        data-url="'.APIGETPRODUCT.'"
        data-params=\'{"cat":"'.$itemInfomation["db"]["cat"].'","sort":"ASC"}\'
        data-method="get"
        data-init-object="'.$strLocalListItem.'"
        data-filter-init=\''.$strFilter.'\'
        data-str-sort="id=-1"
        data-show-page="10"
        data-show-item="24"
        data-show-all="false"
        data-scroll-view="false"
        data-ignore-hash="true"
        data-form-filter=".form-filter"
        data-template-id="entryViewProduct" >
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
    </div>
    <div class="clearfix"></div>

    <div class="init-none has-slick-slide block-product-category-slide-show">
        <div class="item-view-products '.$customclassName.'"
        data-view-list-by-handlebar
        data-init-button-magic=".item [data-button-magic]"
        data-elm-data=\'{"urlRedirect":"/orders"}\'
        data-url="'.APIGETPRODUCT.'"
        data-params=\'{"cat":"'.$itemInfomation["db"]["cat"].'","sort":"ASC"}\'
        data-method="get"
        data-init-object="'.$strLocalListItem.'"
        data-filter-init=\''.$strFilter.'\'
        data-str-sort="id=-1"
        data-show-page="10"
        data-show-item="24"
        data-show-all="false"
        data-scroll-view="false"
        data-ignore-hash="true"
        data-slide="true"
        data-template-id="entryViewProduct" >
            <div class="slide-more">
                <div data-content
                    class="view-items"
                    data-arrows="true"
                    data-slick-dot="true"
                    data-slick-responsive="3"
                    data-slick-infinite="false">
                    <div class="style-loadding"></div>
                </div>
            </div>
        </div>
    </div>';
    unset($value);
} else {
    $isPageNotFound = true;
}

?>
