<?php
$isFrontendDev = null;

$actual_link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

if(isset($informationWebsite["template"]["develop"]) && $informationWebsite["template"]["develop"]==2) {
    $isFrontendDev = true;
}
if(isset($pageInfo["column"]["main"]) && !empty($pageInfo["column"]["main"])) {
    $column = $pageInfo["column"];
}

if(isset($informationWebsite["db"]["im"])) {
    $strOgImage = "storage/management/img/website/{$informationWebsite["db"]["im"]}";
}

$strPageId = null;

$strClassPage = isset($pageInfo["db"]["pa"])? " pageid-{$pageInfo["db"]["pa"]} ":null;

$strClassPage .= isset($pageInfo["db"]["id"])? " pageid-{$pageInfo["db"]["id"]}":null;

$strClassPage .= isset($pageInfo["db"]["opp"])? " pageopp-{$pageInfo["db"]["opp"]}":null;



$strClassPage = $strClassPage ? $strClassPage : "home-page";

$sidebarList = array();

$fileAssets["product"] = FOLDERDATAOFWEBSITE."assets/products_{$websiteId}.js";
$fileAssets["blog"] = FOLDERDATAOFWEBSITE."assets/blogs_{$websiteId}.js";



$listJavascript = array(
    "adminlog"=> isset($_SESSION["adminlog"])? "/api/get/adminlog?var=window.userAccess" : null,
    "userinfo"=> isset($_SESSION["userlog"]["id"]) ? "/api/get/user/".$_SESSION["userlog"]["id"]."?var=window.userAccess" : null,
    "language"=> "/api/get/lang?var=window.languageText",
    "template"=> "/frontend/js/frontend.js?v=1.133",
    "newpluginlocal"=> $strDataFolderTemplate == "templates/testonline/" ? "/".FOLDERDATAOFWEBSITE."assets/newplugin_{$websiteId}.js?time=".intval(time()/1) : null,
    "product"=> is_file(FOLDERDATAOFWEBSITE."assets/products_{$websiteId}.js") ? "/".FOLDERDATAOFWEBSITE."assets/products_{$websiteId}.js?time=".(!isset($_SESSION["adminlog"]) ? intval(time()/3600) : time()) : null,
    "blog"=> is_file(FOLDERDATAOFWEBSITE."assets/blogs_{$websiteId}.js") ? "/".FOLDERDATAOFWEBSITE."assets/blogs_{$websiteId}.js?time=".(!isset($_SESSION["adminlog"]) ? intval(time()/3600) : time()) : null,
    "local"=> is_file(FOLDERDATAOFWEBSITE."assets/local.js") ? "/".FOLDERDATAOFWEBSITE."assets/local.js" : null,
    "clientlibs"=>"/frontend/js/clientlibs.js?v=2.0"
);

if(isset($isAdminPage) && $isAdminPage) {
    $listJavascript["template"] = "/api/get/frontend?var=designTemplates";
}

$informationWebsite["db"]["phone"] = isset($informationWebsite["db"]["phone"]) && !empty($informationWebsite["db"]["phone"]) ? $informationWebsite["db"]["phone"] : null;
$informationWebsite["db"]["address"] = isset($informationWebsite["db"]["address"]) && !empty($informationWebsite["db"]["address"]) ? $informationWebsite["db"]["address"] : null;

$attributeOfWebsiteBlock = isset($informationWebsite["template"]["websiteAttr"]) && !empty($informationWebsite["template"]["websiteAttr"])? $informationWebsite["template"]["websiteAttr"] : null;

#head Content
$seo = isset($informationConfig["config"]["seo"])? $informationConfig["config"]["seo"]: null;

if($multiLanguage) {
    if(isset($seo[$langcode]) && !empty($seo[$langcode])) {
        $seo = $seo[$langcode];
        $seo["googleAnalyticsCode"] = isset($informationConfig["config"]["seo"]["googleAnalyticsCode"]) ? $informationConfig["config"]["seo"]["googleAnalyticsCode"] : null;
    }
    #rewrite Content's pageinfo
    if(isset($informationConfig["config"]["header"][$langcode])) {
        $informationConfig["config"]["header"] = $informationConfig["config"]["header"][$langcode];
    }
    if(isset($informationConfig["config"]["footer"][$langcode])) {
        $informationConfig["config"]["footer"] = $informationConfig["config"]["footer"][$langcode];
    }

    if(isset($informationConfig["config"]["about"][$langcode])) {
        $informationConfig["config"]["about"] = $informationConfig["config"]["about"][$langcode];
    }

    /*if(isset($arrayPathUrl) && $arrayPathUrl) {
        foreach ($arrayPathUrl as $key => $value) {
            $arrayPathUrl[$key]["title"] = isset($value["title"][$langcode]) ? $value["title"][$langcode]: $value["title"];
            if(isset($value["url"])) {
                $arrayPathUrl[$key]["url"] = "/{$langcode}".$value["url"];
            }
        }
    }*/
}

$seoTitle = isset($seo["title"]) && !empty($seo["title"]) ? $seo["title"] : "";
$seoKeyword = isset($seo["keyword"]) ? $seo["keyword"] : "";
$seoDescription = isset($seo["desc"]) ? $seo["desc"] : "";
$googleAnalyticsCode = isset($seo["googleAnalyticsCode"]) ? $seo["googleAnalyticsCode"] : "";


$scriptStyle = isset($informationConfig["config"]["script"]) && !empty($informationConfig["config"]["script"]) ? $informationConfig["config"]["script"]:null;



if(isset($pageInfo) && $pageInfo) {
    if(isset($pageInfo["db"]["im"]) && !empty($pageInfo["db"]["im"])) {
        $strOgImage = FOLDERIMAGEMENU."{$pageInfo["db"]["im"]}";
    }
    $seoTitle = $pageInfo["db"]["ti"];
    $seoTitle = isset($pageInfo["meta"]["title"]) && !empty($pageInfo["meta"]["title"]) ? $pageInfo["meta"]["title"]: $seoTitle;
    $seoKeyword = isset($pageInfo["meta"]["keyword"]) && !empty($pageInfo["meta"]["keyword"]) ? $pageInfo["meta"]["keyword"]: $seoTitle;
    $seoDescription = isset($pageInfo["meta"]["desc"]) && !empty($pageInfo["meta"]["desc"]) ? $pageInfo["meta"]["desc"]: $seoTitle;
    $CollectionPage = arrSearch($menuTable,"pa=={$pageInfo["db"]["id"]}");

    if($multiLanguage) {
        $pageInfo["db"]["url"] = $langcode."/".$pageInfo["db"]["url"];
    }

    $urlOfMenuPage = $protocol.$_SERVER['SERVER_NAME']."/";
    if($CollectionPage) {
        $schemaCollectionPage = [
            "@type"=>"CollectionPage",
            "@id"=>$urlOfMenuPage.$pageInfo["db"]["url"]."/#webpage",
            "url"=>$urlOfMenuPage.$pageInfo["db"]["url"],
            "name"=>$seoTitle,
            "isPartOf"=>[
                "@id"=>$urlOfMenuPage.$pageInfo["db"]["url"]."/#website"
            ],
            "breadcrumb"=>[
                "@id"=>$urlOfMenuPage.$pageInfo["db"]["url"]."/#breadcrumb"
            ]
        ];

        $schemaItemList = [
            "@type"=>"ItemList",
            "itemListElement"=>[],
            "mainEntityOfPage"=> [
                "@id"=> $urlOfMenuPage.$pageInfo["db"]["url"]."/#webpage"
            ]
        ];
        $indexPathUrl = 0;
        foreach ($CollectionPage as $key => $value) {
            $indexPathUrl ++;
            if(isset($value["url"])) {
                array_push($schemaItemList["itemListElement"],[
                    "@type"=>"ListItem",
                    "position"=> $indexPathUrl,
                    "url"=>$urlOfMenuPage.$value["url"]
                ]);
            }
        }
        unset($indexPathUrl);

    } else {
        $schemaArticle = [
            "@type"=>"Article",
            "headline"=>$seoTitle,
            "author"=>[
                "@type"=>"Person",
                "name"=>$informationWebsite["db"]["name"],
                "url"=>$urlOfMenuPage.$pageInfo["db"]["url"]
            ],
            "description"=>$seoDescription,
            "image"=>$urlOfMenuPage.$strOgImage,
            "@id"=>$urlOfMenuPage.$pageInfo["db"]["url"]
        ];
    }

    unset($urlOfMenuPage);
    /*if(isset($pageInfo["db"]["opp"]) && $pageInfo["db"]["opp"] == 3) {
        unset($schemaArticle);
    }*/

    if(isset($pageInfo["db"]["opp"]) ) {
        if($pageInfo["db"]["opp"]== 1 || $pageInfo["db"]["opp"]== 4 || $pageInfo["db"]["opp"]== 5) {
            
        } else {

        }
    }
} else {
    /*$listRiview = FOLDERREVIEW . "review.xml";
    $informationReview = null;
    if (is_file($listRiview)) {
        $informationReview = simplexml_load_file($listRiview);
        $informationReview = json_encode($informationReview);
        $informationReview = json_decode($informationReview, true);
        $listRiview = $informationReview["table"];
        $schemaAggregateRating = [
            "@context"=>"https://schema.org/",
            "@type"=>"CreativeWorkSeries",
            "url"=>$protocol.$_SERVER['SERVER_NAME'],
            "name"=>$informationWebsite["db"]["name"],
            "aggregateRating" => [ 
                "@type"=> "AggregateRating",
                "ratingValue"=> "4.4",
                "reviewCount"=> "89"
              ]
        ];
    }*/

}

if(isset($itemInfomation) && $itemInfomation) {

    $strClassPage = $strClassPage." item-detail-infomation";
    $seoTitle = $itemInfomation["db"]["ti"];
    $seoTitle = isset($itemInfomation["meta"]["title"]) && !empty($itemInfomation["meta"]["title"]) ? $itemInfomation["meta"]["title"]: $seoTitle;
    $seoKeyword = isset($itemInfomation["meta"]["keyword"]) && !empty($itemInfomation["meta"]["keyword"]) ? $itemInfomation["meta"]["keyword"]: $seoTitle;
    $seoDescription = isset($itemInfomation["meta"]["desc"]) && !empty($itemInfomation["meta"]["desc"]) ? $itemInfomation["meta"]["desc"]: $seoTitle;

    if(isset($itemInfomation["db"]["im"]) && !empty($itemInfomation["db"]["im"])) {
        if ($url_data[0] == $seo_name["page"]["product"]) {
            $strOgImage = FOLDERIMAGEPRODUCT.$itemInfomation["db"]["im"];

            $schemaProduct = [
                "@type"=>"product",
                "name"=>$itemInfomation["db"]["ti"],
                "description"=>!empty($itemInfomation["db"]["ct"]) ? $itemInfomation["db"]["ct"] : null,
                "@id"=>$actual_link,
                "image"=>[
                    $protocol.$_SERVER['SERVER_NAME']."/{$strOgImage}"
                ],
                "offers" => [
                    "@type"=>"Offer",
                    "url"=>$actual_link,
                    "priceCurrency"=>$language["currencyFormat"],
                    "priceValidUntil"=>date('Y-m-d', strtotime("+6 month")),
                    //"itemCondition"=>"https://schema.org/UsedCondition",
                    "availability"=>"https://schema.org/InStock",
                    "seller" => [
                        "@type"=>"Organization",
                        "url"=>$protocol.$_SERVER['SERVER_NAME'],
                        "name"=>$informationWebsite["db"]["name"]
                    ]
                ]
            ];

            if(isset($itemInfomation["db"]["pr"]["off"]) && !empty($itemInfomation["db"]["pr"]["off"])) {
                $schemaProduct["offers"]["price"] = $itemInfomation["db"]["pr"]["off"];
            } elseif(isset($itemInfomation["db"]["pr"]["sale"]) && !empty($itemInfomation["db"]["pr"]["sale"])) {
                $schemaProduct["offers"]["price"] = $itemInfomation["db"]["pr"]["sale"];
            } else {
                $schemaProduct["offers"]["price"] = 0;
            }

        } else {
            $strOgImage = FOLDERIMAGEBLOG.$itemInfomation["db"]["im"];

            $schemaBlogPosting = [
                "@type"=>"BlogPosting",
                "headline"=>$seoTitle,
                // "datePublished"=>"2021-01-06GMT+000002:44:47+00:00",
                // "dateModified"=>"2021-08-20GMT+000001:52:22+00:00",
                "author"=>[
                    "@type"=>"Person",
                    "url"=>$protocol.$_SERVER['SERVER_NAME'],
                    "name"=>$informationWebsite["db"]["name"]
                ],
                "@id"=>$actual_link,
                "isPartOf"=>[
                    "@id"=>"{$actual_link}/#webpage"
                ],
                "image"=>[
                    "@id"=>"{$actual_link}/#primaryImage"
                ],
                "publisher"=>[
                    "@id"=>$protocol.$_SERVER['SERVER_NAME']."/#organization"
                ],
                "mainEntityOfPage"=>[
                    "@id"=>"{$actual_link}/#webpage"
                ]
            ];
        }

    }
    

}

if(isset($strOgImage) && $strOgImage) {
    $schemaImageObject = ["@type"=>"ImageObject",
            "@id"=>"{$actual_link}/#primaryImage",
            "url"=>$protocol.$_SERVER['SERVER_NAME']."/{$strOgImage}"];

    $strOgImage =  formatStrArguments('<meta property="og:image" content="'.$protocol.$_SERVER['SERVER_NAME'].'/{1}">
    <meta property="twitter:image" content="'.$protocol.$_SERVER['SERVER_NAME'].'/{1}">', $strOgImage);
    
}



if(isset($informationWebsite["script"]["javascript"]) && !empty($informationWebsite["script"]["javascript"]) ) {
    if(isset($scriptStyle["javascript"]) && !empty($scriptStyle["javascript"])) {
        $scriptStyle["javascript"] = $informationWebsite["script"]["javascript"].$scriptStyle["javascript"];
    } else {
        $scriptStyle["javascript"] = $informationWebsite["script"]["javascript"];
    }
}
if(isset($informationWebsite["script"]["css"]) && !empty($informationWebsite["script"]["css"]) ) {
    if(isset($scriptStyle["css"]) && !empty($scriptStyle["css"])) {
        $scriptStyle["css"] = $informationWebsite["script"]["css"].$scriptStyle["css"];
    } else {
        $scriptStyle["css"] = $informationWebsite["script"]["css"];
    }
}

$jsActualLink = '<script> languageText.jsActualLink="'.$actual_link.'"</script>';
$scriptStyle["javascript"] = isset($scriptStyle["javascript"]) && !empty($scriptStyle["javascript"]) ? $scriptStyle["javascript"].$jsActualLink : $jsActualLink;





if(isset($jsonChangeLanguage)) {
    $jsonChangeLanguage = '<script> languageText.jsonChangeLanguage='.json_encode($jsonChangeLanguage).'</script>';
    $scriptStyle["javascript"] = isset($scriptStyle["javascript"]) && !empty($scriptStyle["javascript"]) ? $scriptStyle["javascript"].$jsonChangeLanguage : $jsonChangeLanguage;
}

if(isset($url_data[0]) && $url_data[0] == $seo_name["page"]["product"] && isset($itemInfomation["db"]) ) {
    $jsonProductIndex = '<script> languageText.jsonProductIndex='.json_encode($itemInfomation["db"]).'</script>';
    $scriptStyle["javascript"] = isset($scriptStyle["javascript"]) && !empty($scriptStyle["javascript"]) ? $jsonProductIndex.$scriptStyle["javascript"] : $jsonProductIndex;
    $strClassPage = $strClassPage." page-product-detail";
}

if(isset($pageInfo["db"]) && $pageInfo["db"] ) {
    $jsonPageIndex = '<script> languageText.jsonPageIndex='.json_encode($pageInfo["db"]).'</script>';
    $scriptStyle["javascript"] = isset($scriptStyle["javascript"]) && !empty($scriptStyle["javascript"]) ? $jsonPageIndex.$scriptStyle["javascript"] : $jsonPageIndex;
}

// boxchat here
if(isset($informationWebsite["template"]["boxchat"]) && $informationWebsite["template"]["boxchat"]==2) {
    $strBoxchatCode = '<div class="client boxchat" data-boxchatsimple data-socket-url="'.$protocol.$domainName.':3000/socket.io/socket.io.js"
            data-socket-connect="'.$protocol.$domainName.':3000" data-website-id="'.$websiteId.'" data-visitor-name="A"
            data-elm-input="#message" data-elm-feedback="#feedback" data-elm-view-chat=".boxchat-view"
            data-elm-button-send="#send_message" data-elm-notification=".notification-number" data-template-id="entryBoxChatClient"></div>
            <script>
            Site.getDaysRangeCSSBoxChat(moment(\'2019-01-01\'), moment(), \'YYYY-MM-DD\');
            if(localStorage && localStorage.getItem(\'indexOpenBoxchat\')) {
                $(\'.client.boxchat\').addClass(localStorage.getItem(\'indexOpenBoxchat\'));
            }
            </script>';
    $scriptStyle["javascript"] = isset($scriptStyle["javascript"]) && !empty($scriptStyle["javascript"]) ? $strBoxchatCode.$scriptStyle["javascript"] : $strBoxchatCode;
}


#header Content
$header = isset($informationConfig["config"]["header"])? $informationConfig["config"]["header"] : null;
$strHeader1 = isset($header["content1"]) && !empty($header["content1"]) ? $header["content1"] : null;
$strHeader2 = isset($header["content2"]) && !empty($header["content2"]) ? $header["content2"] : null;
$menubaner = isset($informationConfig["config"]["menubaner"])? $informationConfig["config"]["menubaner"] : null;
$strMenuConfig = isset($menubaner["menu"]) && !empty($menubaner["menu"]) ? $menubaner["menu"] : null;
$strBannerConfig = isset($menubaner["baner"]) && !empty($menubaner["baner"]) ? $menubaner["baner"] : null;

$social = isset($informationConfig["config"]["social"])? $informationConfig["config"]["social"] : null;
$socialSkype = isset($social["skype"]) && !empty($social["skype"]) ? "skype:{$social["skype"]}?chat" : null;
$socialFacebook = isset($social["facebook"]) && !empty($social["facebook"]) ? $social["facebook"] : null;
$socialHotline = isset($social["hotline"]) && !empty($social["hotline"]) ? $social["hotline"] : $informationWebsite["db"]["phone"];
$socialAddress = isset($social["address"]) && !empty($social["address"]) ? $social["address"] : $informationWebsite["db"]["address"];
$socialEmail = isset($social["email"]) && !empty($social["email"]) ? $social["email"] : "info@phpvnn.com";

#footer
$footer = isset($informationConfig["config"]["footer"])? $informationConfig["config"]["footer"] : null;
$strFooter1 = isset($footer["content1"]) && !empty($footer["content1"]) ? $footer["content1"] : null;
$strFooter2 = isset($footer["content2"]) && !empty($footer["content2"]) ? $footer["content2"] : null;
$advertise = isset($informationConfig["config"]["advertise"])? $informationConfig["config"]["advertise"] : null;

$menuOfBasicPage = arrSearch($menuTable, "opp==1");
$menuOfProductPage = arrSearch($menuTable, "opp==3");

$strBasicPage = null;
$strProductPage = null;

if($menuOfBasicPage) {
    foreach ($menuOfBasicPage as $key => $value) {
        $link = isset($value["link"]) && !empty($value["link"]) ? $value["link"] : "/".$value["url"] ;
        $strBasicPage .= "<li class=\"menu-item-{$value["id"]}\"><a href=\"{$link}\">{$value["ti"]}</a></li>";
    }
}

if($menuOfProductPage) {
    foreach ($menuOfProductPage as $key => $value) {
        $link = isset($value["link"]) && !empty($value["link"]) ? $value["link"] : "/".$value["url"] ;
        $strProductPage .= "<li class=\"menu-item-{$value["id"]}\"><a href=\"{$link}\">{$value["ti"]}</a></li>";
    }
}


if(isset($informationConfig["sidebar"]) && $informationConfig["sidebar"]) {
    $sidebarList = $informationConfig["sidebar"];
}

$sidebarPage = $sidebarList;

if(isset($pageInfo["db"]["id"])) {

    $strPageId = $pageInfo["db"]["id"];
    $arrayPathUrl = array(
        array(
            "id" =>$pageInfo["db"]["id"],
            "title"=>$pageInfo["db"]["ti"],
            "url"=> "/".$pageInfo["db"]["url"]
        )
    );

    # Filter sidebar of menu
    /*if(isset($pageInfo["db"]["pa"]) && !empty($pageInfo["db"]["pa"])) {
        $fileParent = FOLDERMENU . $pageInfo["db"]["pa"]. ".xml";
        if(is_file($fileParent)) {

            $pageInfoParent = simplexml_load_file($fileParent);
            $pageInfoParent = json_encode($pageInfoParent);
            $pageInfoParent = json_decode($pageInfoParent, true);

            $strPageId = $pageInfoParent["db"]["id"];
            if(!isset($column) || !$column) {
                $column = isset($pageInfoParent["column"]["main"]) && !empty($pageInfoParent["column"]["main"]) ? $pageInfoParent["column"] : null;
            }

            if(!$sidebarPage) {
                // Filter sidebar of menu
                $sidebarPage = array_filter($sidebarList, function ($obj) {
                    global $pageInfoParent;
                    if (!isset($obj["ca"])) {
                        return false;
                    }
                    return in_array($pageInfoParent["db"]["id"], explode(',', $obj["ca"]));
                });
            }
        }
    }*/

    if(isset($pageInfo["db"]["pa"]) && intval($pageInfo["db"]["pa"]) > 0 ){

        
        $fileParent = FOLDERMENU . $pageInfo["db"]["pa"]. ".xml";
        if(is_file($fileParent)) {
            $pageInfoParent = simplexml_load_file($fileParent);
            $pageInfoParent = json_encode($pageInfoParent);
            $pageInfoParent = json_decode($pageInfoParent, true);

            if(!isset($column) || !$column) {
                $column = isset($pageInfoParent["column"]["main"]) && !empty($pageInfoParent["column"]["main"]) ? $pageInfoParent["column"] : null;
            }

            $arrayPathUrlPlus = array(
                array(
                    "id"=>$pageInfoParent["db"]["id"],
                    "title"=> $multiLanguage && isset($pageInfoParent["db"]["ti"]["$langcode"]) ? $pageInfoParent["db"]["ti"]["$langcode"] : $pageInfoParent["db"]["ti"],
                    "url"=>isset($pageInfoParent["db"]["link"]) && !empty($pageInfoParent["db"]["link"])?$pageInfoParent["db"]["link"]: ( $multiLanguage ? "/".$langcode."/".$pageInfoParent["db"]["url"]: "/".$pageInfoParent["db"]["url"])
                )
            );

            $fileParent = FOLDERMENU . $pageInfoParent["db"]["pa"]. ".xml";
            if(is_file($fileParent)) {
                $pageInfoParent = simplexml_load_file($fileParent);
                $pageInfoParent = json_encode($pageInfoParent);
                $pageInfoParent = json_decode($pageInfoParent, true);

                if(!isset($column) || !$column) {
                    $column = isset($pageInfoParent["column"]["main"]) && !empty($pageInfoParent["column"]["main"]) ? $pageInfoParent["column"] : null;
                }

                array_splice($arrayPathUrlPlus, 0, 0, array(
                    array(
                        "id"=>$pageInfoParent["db"]["id"],
                        "title"=> $multiLanguage && isset($pageInfoParent["db"]["ti"]["$langcode"]) ? $pageInfoParent["db"]["ti"]["$langcode"] : $pageInfoParent["db"]["ti"],
                        "url"=>isset($pageInfoParent["db"]["link"]) && !empty($pageInfoParent["db"]["link"])?$pageInfoParent["db"]["link"]: ( $multiLanguage ? "/".$langcode."/".$pageInfoParent["db"]["url"]: "/".$pageInfoParent["db"]["url"])
                    )
                ));
                $fileParent = FOLDERMENU . $pageInfoParent["db"]["pa"]. ".xml";
                if(is_file($fileParent)) {
                    $pageInfoParent = simplexml_load_file($fileParent);
                    $pageInfoParent = json_encode($pageInfoParent);
                    $pageInfoParent = json_decode($pageInfoParent, true);
                    if(!isset($column) || !$column) {
                        $column = isset($pageInfoParent["column"]["main"]) && !empty($pageInfoParent["column"]["main"]) ? $pageInfoParent["column"] : null;
                    }

                    array_splice($arrayPathUrlPlus, 0, 0, array(
                        array(
                            "id"=>$pageInfoParent["db"]["id"],
                            "title"=> $multiLanguage && isset($pageInfoParent["db"]["ti"]["$langcode"]) ? $pageInfoParent["db"]["ti"]["$langcode"] : $pageInfoParent["db"]["ti"],
                            "url"=>isset($pageInfoParent["db"]["link"]) && !empty($pageInfoParent["db"]["link"])?$pageInfoParent["db"]["link"]: ( $multiLanguage ? "/".$langcode."/".$pageInfoParent["db"]["url"]: "/".$pageInfoParent["db"]["url"])
                        )
                    ));
                    $fileParent = FOLDERMENU . $pageInfoParent["db"]["pa"]. ".xml";
                    if(is_file($fileParent)) {
                        $pageInfoParent = simplexml_load_file($fileParent);
                        $pageInfoParent = json_encode($pageInfoParent);
                        $pageInfoParent = json_decode($pageInfoParent, true);
                        if(!isset($column) || !$column) {
                            $column = isset($pageInfoParent["column"]["main"]) && !empty($pageInfoParent["column"]["main"]) ? $pageInfoParent["column"] : null;
                        }

                        array_splice($arrayPathUrlPlus, 0, 0, array(
                            array(
                                "id"=>$pageInfoParent["db"]["id"],
                                "title"=> $multiLanguage && isset($pageInfoParent["db"]["ti"]["$langcode"]) ? $pageInfoParent["db"]["ti"]["$langcode"] : $pageInfoParent["db"]["ti"],
                                "url"=>isset($pageInfoParent["db"]["link"]) && !empty($pageInfoParent["db"]["link"])?$pageInfoParent["db"]["link"]: ( $multiLanguage ? "/".$langcode."/".$pageInfoParent["db"]["url"]: "/".$pageInfoParent["db"]["url"])
                            )
                        ));
                    }
                }
            }

            array_splice($arrayPathUrl, 0, 0, $arrayPathUrlPlus);
        }
    }
  
}

$schemaBreadcrumbList = [
    "@type"=>"BreadcrumbList",
    "@id"=>$actual_link."/#breadcrumb",
    "itemListElement"=>[]
];

$strListPath = null;
if(isset($itemInfomation) && $itemInfomation && $arrayPathUrl) {
    $indexPathUrl = 0;
    foreach ($arrayPathUrl as $key => $value) {
        $strIdIndex = isset($value["id"]) ? 'data-add-class-active-to-obj=".menu-item-'.$value["id"].',active"' : null;
  
        if(isset($value["url"])) {
            $strListPath .= "<li {$strIdIndex}><a href=\"{$value["url"]}\" title=\"{$value["title"]}\">{$value["title"]}&nbsp; <i class=\"fa fa-angle-double-right\"></i></a></li>";
        } else {
            $strListPath .= "<li {$strIdIndex}><strong class=\"text-color-2\">{$value["title"]}</strong></li>";
        }
    }

    $blogDetailLayout["strListPath"]=$productDetailLayout["strListPath"] = "<nav class=\"path-url-detail\"><ul class=\"path-url\">{$strListPath}</ul></nav>";

}
if(isset($arrayPathUrl) && $arrayPathUrl) {
    $indexPathUrl = 0;
    foreach ($arrayPathUrl as $key => $value) {
        $indexPathUrl ++;
        if(isset($value["url"])) {
            array_push($schemaBreadcrumbList["itemListElement"],[
                "@type"=>"ListItem",
                "position"=>$indexPathUrl,
                "item"=>[
                    "@id"=>$protocol.$domainName.$value["url"],
                    "name"=>$value["title"]
                ]
            ]);
        }
    }
    unset($indexPathUrl);
}

if(isset($sidebarPage) && !empty($sidebarPage)) {
    # Set Sidebar left
    $listSidebarLeft = array_filter($sidebarPage, function ($obj) {
        if (isset($obj["dis"]) && !empty($obj["dis"])) {
            if (in_array(1, explode(',', $obj["dis"]))) {
                return true;
            }
            return false;
        }
        return false;
    });
    # Set Sidebar right
    $listSidebarRight = array_filter($sidebarPage, function ($obj) {
        if (isset($obj["dis"]) && !empty($obj["dis"])) {
            if (in_array(2, explode(',', $obj["dis"]))) {
                return true;
            }
            return false;
        }
        return false;
    });
}

if(isset($informationWebsite["backendConfig"]["filterCategory"]) && $informationWebsite["backendConfig"]["filterCategory"]==2) {
    if(isset($listSidebarRight) && $listSidebarRight) {
        $listSidebarRight = array_filter($listSidebarRight, function($obj){
            global $pageInfo;
            if(isset($obj["cat"]) && !empty($obj["cat"]) ) {
                $catIds = explode(',', $obj["cat"]);
                if(isset($pageInfo["db"]["id"])) {
                    return in_array(strval($pageInfo["db"]["id"]), $catIds, TRUE) || in_array(strval($pageInfo["db"]["pa"]), $catIds, TRUE) ;
                }
            }
        });
    }
    if(isset($listSidebarLeft) && $listSidebarLeft) {
        $listSidebarLeft = array_filter($listSidebarLeft, function($obj){
            global $pageInfo;
            if(isset($obj["cat"]) && !empty($obj["cat"]) ) {
                $catIds = explode(',', $obj["cat"]);
                if(isset($pageInfo["db"]["id"])) {
                    return in_array(strval($pageInfo["db"]["id"]), $catIds, TRUE) || in_array(strval($pageInfo["db"]["pa"]), $catIds, TRUE) ;
                }
            }
        });
    }
}

if(!isset($column) || !$column) {
    $column = isset($informationConfig["config"]["column"])? $informationConfig["config"]["column"] : null;
}

// Sidebar left
if(isset($listSidebarLeft) && $listSidebarLeft) {
    usort($listSidebarLeft, function($a, $b)
    {
        return intval($a["so"] ?? 0) <=> intval($b["so"] ?? 0);
    });
    $strSidebarLeft = '';
    foreach ($listSidebarLeft as $k => $v) {
        $strCustomClass = isset($v["cls"]) && !empty($v["cls"])  ? $v["cls"] :'';
        $strCustomAttr = isset($v["attr"]) && !empty($v["attr"]) ? $v["attr"] :'';
        if($multiLanguage && isset($v["ti"][$langcode]) && isset($v["de"][$langcode])) {
            $v["ti"] = $v["ti"][$langcode];
            $v["de"] = $v["de"][$langcode];
        }

        $strSidebarLeft .= '<div class="side-box '.$strCustomClass.'"'.$strCustomAttr.' >
        <h3 class="text-color-2">'.(!empty( $v["ti"]) ? $v["ti"]:null ).'</h3>
        <div class="side-content">'.(!empty($v["de"])?$v["de"]:null).'</div>
        </div>';
    }
    $strSidebarLeft = formatStrArguments($strSidebarLeft,$strPageId);
}

// Sidebar Right
if(isset($listSidebarRight) && $listSidebarRight) {
    usort($listSidebarRight, function($a, $b)
    {
        return intval($a["so"] ?? 0) <=> intval($b["so"] ?? 0);
    });
    $strSidebarRight = '';
    foreach ($listSidebarRight as $k => $v) {
        $strCustomClass = isset($v["cls"]) && is_string($v["cls"]) ? $v["cls"] :'';
        $strCustomAttr = isset($v["attr"]) && is_string($v["attr"]) ? $v["attr"] :'';
        if($multiLanguage && isset($v["ti"][$langcode]) && isset($v["de"][$langcode])) {
            $v["ti"] = $v["ti"][$langcode];
            $v["de"] = $v["de"][$langcode];
        }
        $strSidebarRight .= '<div class="side-box '.$strCustomClass.'"'.$strCustomAttr.' >
            <h3 class="text-color-2">'.(!empty($v["ti"])?$v["ti"]:'').'</h3>
            <div class="side-content">'.(!empty($v["de"])?$v["de"]:'').'</div>
            </div>';
    }
    $strSidebarRight = formatStrArguments($strSidebarRight,$strPageId);

}

$strClsColumnLeft = isset($column["left"]) && !empty($column["left"]) ? $column["left"] : null;
$strClsColumnMain = isset($column["main"]) && !empty($column["main"]) ? $column["main"] : null;
$strClsColumnRight = isset($column["right"]) && !empty($column["right"]) ? $column["right"] : null;

if(isset($informationWebsite["schema"])) {
    $strSchemaLogo = $informationWebsite["schema"]["logo"];
    unset($informationWebsite["schema"]["logo"]);

    if( isset($informationWebsite["schema"]["type"]) && !empty($informationWebsite["schema"]["type"]) ){
        $informationWebsite["schema"]["@type"] = explode(",",$informationWebsite["schema"]["type"]);
        unset($informationWebsite["schema"]["type"]);
    } else {
        $informationWebsite["schema"]["@type"] = [
                "ProfessionalService",
                "Organization"
            ];
    }
    

    $informationWebsite["schema"]["@id"] = $informationWebsite["schema"]["url"]."/#organization";
    $informationWebsite["schema"]["address"]["@type"] = "PostalAddress";
    $informationWebsite["schema"]["logo"]["@type"] = "ImageObject";
    $informationWebsite["schema"]["logo"]["url"] = $strSchemaLogo;
    $informationWebsite["schema"]["image"]["@type"] = "ImageObject";
    $informationWebsite["schema"]["image"]["url"] = $strSchemaLogo;

    if(isset($informationWebsite["schema"]["geo"]["latitude"]) && isset($informationWebsite["schema"]["geo"]["longitude"] ) ) {
        $informationWebsite["schema"]["geo"]["@type"] = "GeoCoordinates";
        $informationWebsite["schema"]["hasMap"] = "https://www.google.com/maps/search/?api=1&query=".$informationWebsite["schema"]["geo"]["latitude"].",".$informationWebsite["schema"]["geo"]["longitude"];
    }

    $schemaWebsite = [
            "@type"=>"WebSite",
            "@id"=>$informationWebsite["schema"]["url"]."/#website",
            "url"=>$informationWebsite["schema"]["url"],
            "name"=>$informationWebsite["schema"]["name"],
            "publisher"=>[
                "@id"=>$informationWebsite["schema"]["url"]."/#organization"
            ],
            "inLanguage"=>"vi-VN",
            "potentialAction"=>[
                "@type"=>"SearchAction",
                "target"=>$informationWebsite["schema"]["url"]."/q?title={search_term_string}",
                "query-input"=>"required name=search_term_string"
            ]
        ];


    $ldJson = [
        "@context"=>"https://schema.org",
        "@graph" => [
            $informationWebsite["schema"], $schemaWebsite
        ]
    ];  
    if(isset($schemaBreadcrumbList) && count($schemaBreadcrumbList["itemListElement"]) > 0 ) {
        array_push($ldJson["@graph"],$schemaBreadcrumbList);
        unset($schemaBreadcrumbList);
    }
    if(isset($schemaCollectionPage)) {
        array_push($ldJson["@graph"],$schemaCollectionPage);
        unset($schemaCollectionPage);
    }

    if(isset($schemaItemList)) {
        array_push($ldJson["@graph"],$schemaItemList);
        unset($schemaItemList);
    }

    if(isset($schemaImageObject)) {
        array_push($ldJson["@graph"],$schemaImageObject);
        unset($schemaImageObject);
    }
    if(isset($schemaArticle)) {
        array_push($ldJson["@graph"],$schemaArticle);
        unset($schemaArticle);
    }

    if(isset($schemaBlogPosting)) {
        array_push($ldJson["@graph"],$schemaBlogPosting);
        unset($schemaBlogPosting);
    }  

    if(isset($schemaProduct)) {
        array_push($ldJson["@graph"],$schemaProduct);
        unset($schemaProduct);
    }  

    /*if(isset($schemaAggregateRating)) {
        array_push($ldJson["@graph"],$schemaAggregateRating);
        unset($schemaAggregateRating);
    }*/
    
    unset($schemaWebsite);
}

