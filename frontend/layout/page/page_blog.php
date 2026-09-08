<?php
$isPageNotFound = false;
$arrayPathUrl = null;
$blogDetailLayout["strListPath"] = null;
if(!isset($url_data[1]) || isset($url_data[2]) ){
    $isPageNotFound = true;
}
$strParamUrl = explode(".",$url_data[1]);
$fileId = intval($strParamUrl[count($strParamUrl)-1]);
$file = FOLDERBLOG . $fileId . ".xml";
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
    $urlSlide = APIGETSLIDEBLOG."/".$itemId;

    $value = $pageInfo["db"];

    $customResponsive = isset($value["clr"])&& !empty($value["clr"])?$value["clr"]: $customResponsiveDefault;

    $blogDetailLayout["strId"] =$itemInfomation["db"]["id"];
    $blogDetailLayout["strCat"] =$itemInfomation["db"]["cat"];
    $blogDetailLayout["strBlockYoutube"] = null;
    $blogDetailLayout["strBlockSameTag"] = null;
    $blogDetailLayout["strBlockSameCategory"] = null;
    $blogDetailLayout["strListPath"] = '<div class="block-path-product"
                data-view-template=".block-path-product"
                data-template-id="blockPathProduct"
                data-view-template-local="true"
                data-copy-template></div>';

    $moreContent = isset($itemInfomation["more"]) ? $itemInfomation["more"]: null;
    $moreDetail = isset($itemInfomation["detail"]) ? $itemInfomation["detail"]: null;
    $blogDetailLayout["strDescription"] = null;
    $blogDetailLayout["strDescriptionMore"] = null;
    $blogDetailLayout["strDisplayImages"] = null;
    $strLocalListItem = "localBlogList";
    $strFilter = "[
        {\"name\":\"cat\",\"value\":\",".$itemInfomation["db"]["cat"].",\",\"compare\":\"checkin\"},
        {\"name\":\"st\",\"value\":\"2\",\"compare\":\"from\"}
    ]";

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

    $blogDetailLayout["strTitle"] = '<h1 class="blog-title title_">'.$itemInfomation["db"]["ti"].'</h1>';
    if(isset($itemInfomation["db"]["ct"]) && !empty($itemInfomation["db"]["ct"]) ) {
        $blogDetailLayout["strTitle"] .='<div class="init-none p-content">'.$itemInfomation["db"]["ct"].'</div>';
    }

    if(isset($itemInfomation["more"]["description"]) && !empty($itemInfomation["more"]["description"])) {
        $blogDetailLayout["strDescription"] = '<div class="description more-description">'.$itemInfomation["more"]["description"].'</div>';
    }



    if(isset($moreContent["isShowSlide"])){

        $blogDetailLayout["strDisplayImages"] ='<script src="'.$urlSlide.'?var=window.viewSlideBlog"></script> <div class="list-image-detail">
            <div class="title"><h2>'.$language["image"].'</h2></div>
            <div class="item-view-slide-image item-view-slide-image-blog" data-view-list-by-handlebar data-ignore-hash="true" data-init-object="viewSlideBlog" data-str-sort="name=2" data-method="get" data-show-page="10" data-show-item="10" data-show-all="true"
                data-scroll-view="false" data-img-lightbox=".item-view-slide-image [data-lightbox]" data-template-id="entrySlideItemGallery">
                <div data-content><div class="style-loadding"></div></div>
            </div>
        </div>';
    }

    if(isset($moreContent["youtubeId"]) && !empty($moreContent["youtubeId"])){
        $blogDetailLayout["strBlockYoutube"] ='<div class="product-media-video">
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
            $blogDetailLayout["strDescriptionMore"] .= '<div class="item-content">
                  <h3 class="icon tab-title">' . $value["title"] . '</h3>
                  <div class="tab-content" ><div class="tab-description" >' . $value["description"] . '</div></div>
              </div>';
         }
        }

        $blogDetailLayout["strDescriptionMore"] = $blogDetailLayout["strDescriptionMore"] ? '<div data-ui-tabs data-tab-class="ui-tabs" data-mobile-title="tab-title" data-ignore-hash="false" data-scroll-to="true" data-fixed=".more-description,.description-info" data-fixed-class="ui-nav-fixed"><div class="product-des">'.$blogDetailLayout["strDescriptionMore"].'</div></div>':null;
    }
    if(isset($itemInfomation["db"]["tag"]) && !empty($itemInfomation["db"]["tag"])) {
        $strFilterTag = "[
            {\"name\":\"tag\",\"value\":\"".$itemInfomation["db"]["tag"]."\",\"compare\":\"equal\"},
            {\"name\":\"st\",\"value\":\"2\",\"compare\":\"from\"}
        ]";

        $blogDetailLayout["strBlockSameTag"] = '<div class="blog-more-slide has-button-bottom">
            <h3 class="box-title-1 title-down">'.$language["blogSameTag"].'</h3>
            <div class="item-view-products"
            data-view-list-by-handlebar
            data-elm-data=\'{"urlRedirect":"/orders"}\'
            data-init-button-magic=".item [data-button-magic]"
            data-url="'.APIGETBLOG.'"
            data-params=\'{"sort":"ASC","tag":"'.$itemInfomation["db"]["tag"].'"}\'
            data-method="get"
            data-init-object="'.$strLocalListItem.'"
            data-filter-init=\''.$strFilterTag.'\'
            data-show-page="10"
            data-show-item="24"
            data-show-all="false"
            data-scroll-view="false"
            data-form-filter=".form-filter"
            data-slide="true"
            data-template-id="entryViewIconBlog" >
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

    $blogDetailLayout["strBlockSameCategory"] ='<div class="clearfix"></div>
    <h3 class="title_ title-same-blog">'.$language["sameCategory"].'</h3>
    <div class="news news-link-block"
        data-view-list-by-handlebar
        data-init-button-magic=".item [data-button-magic]"
        data-elm-data=\'{"urlRedirect":"/orders"}\'
        data-url="'.APIGETBLOG.'"
        data-params=\'{"cat":"'.$itemInfomation["db"]["cat"].'","sort":"ASC"}\'
        data-method="get"
        data-init-object="'.$strLocalListItem.'"
        data-filter-init=\''.$strFilter.'\'
        data-show-page="10"
        data-show-item="12"
        data-str-sort="id=-1"
        data-show-all="false"
        data-ignore-hash="true"
        data-form-filter=".form-filter"
        data-template-id="entryItemBlogViewTitle" >
        <div class="view-items" data-content>
            <div class="style-loadding"> </div>
        </div>
        <div data-footer></div>
    </div>';
    unset($value);
} else {
    $isPageNotFound = true;
}

?>
