<?php
if($multiLanguage) {
    require_once dirname(__FILE__)."/model_config1.php";
} else {
    $nodeAbout = isset($information["config"]["about"]) ? $information["config"]["about"] : null;
    $nodeSocial = isset($information["config"]["social"]) ? $information["config"]["social"] : null;
    $nodeSeo = isset($information["config"]["seo"]) ? $information["config"]["seo"] : null;
    $nodeEmail = isset($information["config"]["email"]) ? $information["config"]["email"] : null;
    $nodeOrder = isset($information["config"]["order"]) ? $information["config"]["order"] : null;
    $nodeScript = isset($information["config"]["script"]) ? $information["config"]["script"] : null;
    $nodeEmailContent = isset($information["config"]["emailcontent"]) ? $information["config"]["emailcontent"] : null;
    $nodeMetatag = isset($information["config"]["metatag"]) ? $information["config"]["metatag"] : null;

    $listButton = array(
        array(
            "iClassCustom"=>"col-sm-offset-2 col-xs-4 col-sm-2",
            "iAttr"=> array(
                "type"=>"submit",
                "data-button-magic"=>"",
                "data-refress-list"=>".item-view-more",
                "data-params-form"=>".post-form",
                "data-format-json"=>"true",
                "data-ajax-url"=>APIPOSTCONFIGPAGE,
                "data-show-success"=>".alert-footer.alert",
                "data-show-errors"=>".alert-footer.alert-error",
                "class"=>"btn btn-block btn-primary text-uppercase"
            )
        )
    );

    $strButton = $language["btnUpdate"];
    $listButton[0]["iLabel"] = '<span>'.$strButton.'</span>';
    $node = isset($_GET["node"]) && $_GET["node"] ? $_GET["node"] : null;

    $inputHidden = array(
            array(
                "type"=>"hidden",
                "name"=>"config.type",
                "value"=>$node,
                "data-validate"=>"",
                "data-required"=>$language["requireInput"]
            )
        );


    if($node == "about") {
        $listButton[0]["iClassCustom"] = "col-sm-offset-0 col-xs-4 col-sm-2";
        $aboutDescription = isset($nodeAbout["description"]) && !empty($nodeAbout["description"]) ? $nodeAbout["description"] : null;
        $customDescription = isset($nodeAbout["description"]) && !empty($nodeAbout["customDescription"]) ? $nodeAbout["customDescription"] : null;
        $aboutPageNotfound = isset($nodeAbout["pageNotfound"]) && !empty($nodeAbout["pageNotfound"]) ? $nodeAbout["pageNotfound"] : null;
        $modeDesign = array(
            "eDesign" => array(
                "row"=>"form-group",
                "left"=>"col-xs-12 col-sm-12",
                "right"=>"col-xs-12 col-sm-12",
            ),
            "eInputHidden" => $inputHidden,
            "eForm" => array(
                array(
                    "iLabel"=>$language["description"],
                    "iName"=>"about.description",
                    "iValue"=>$aboutDescription,
                    "iTypeInput"=>"input",
                    "iTextarea"=>"true",
                    "iClass"=>"form-control mce-editor"
                ),
                array(
                    "iLabel"=>"Custom Description",
                    "iName"=>"about.customDescription",
                    "iValue"=>$customDescription,
                    "iTypeInput"=>"input",
                    "iTextarea"=>"true",
                    "iClass"=>"form-control mce-editor"
                ),
                array(
                    "iLabel"=>$language["pageNotfound"],
                    "iName"=>"about.pageNotfound",
                    "iValue"=>$aboutPageNotfound,
                    "iTypeInput"=>"input",
                    "iTextarea"=>"true",
                    "iClass"=>"form-control mce-editor"
                )
            ),
            "attrForm" => array(
                "class"=>"post-form form-horizontal"
            ),
            "button" => $listButton,
            "buttonClass"=>"row form-group"
        );
    } elseif($node == "social") {
        $socialSkype = isset($nodeSocial["skype"]) && !empty($nodeSocial["skype"]) ? $nodeSocial["skype"] : null;
        $socialFacebook = isset($nodeSocial["facebook"]) && !empty($nodeSocial["facebook"]) ? $nodeSocial["facebook"] : null;
        $socialHotline = isset($nodeSocial["hotline"]) && !empty($nodeSocial["hotline"]) ? $nodeSocial["hotline"] : null;
        $socialEmail = isset($nodeSocial["email"]) && !empty($nodeSocial["email"]) ? $nodeSocial["email"] : null;
        $socialAddress = isset($nodeSocial["address"]) && !empty($nodeSocial["address"]) ? $nodeSocial["address"] : null;

        $modeDesign = array(
            "eDesign" => array(
                "row"=>"form-group",
                "left"=>"col-xs-12 col-sm-2 control-label",
                "right"=>"col-xs-12 col-sm-8",
            ),
            "eInputHidden" => $inputHidden,
            "eForm" => array(
                array(
                    "iLabel"=>$language["skype"],
                    "iName"=>"social.skype",
                    "iValue"=>$socialSkype,
                    "iTypeInput"=>"input",
                    "iClass"=>"form-control"
                ),
                array(
                    "iLabel"=>$language["address"],
                    "iName"=>"social.address",
                    "iValue"=>$socialAddress,
                    "iTypeInput"=>"input",
                    "iClass"=>"form-control"
                ),
                array(
                    "iLabel"=>$language["facebook"],
                    "iName"=>"social.facebook",
                    "iValue"=>$socialFacebook,
                    "iTypeInput"=>"text",
                    "iAttr"=> array(
                        "placeholder"=>"http://facebook.com",
                        "data-validates"=>"",
                        "data-pattern"=>$language["requireUrlPattern"],
                        "data-pattern-message"=>$language["requireUrlRule"]
                    ),
                    "iClass"=>"form-control"
                ),
                array(
                    "iLabel"=>$language["hotline"],
                    "iName"=>"social.hotline",
                    "iValue"=>$socialHotline,
                    "iTypeInput"=>"text",
                    "iAttr"=> array(
                        "data-validates"=>"",
                        "data-required"=>$language["requireInput"],
                        "data-pattern"=>$language["requirePhonePattern"],
                        "data-min-length"=>"9",
                        "data-max-length"=>"13",
                        "data-pattern-message"=>$language["requirePhoneRule"]
                    ),
                    "iClass"=>"form-control"
                ),
                array(
                    "iLabel"=>$language["email"],
                    "iName"=>"social.email",
                    "iValue"=>$socialEmail,
                    "iTypeInput"=>"input",
                    "iAttr"=> array(
                        "data-validates"=>"",
                        //"data-required"=>$language["requireInput"],
                        "data-pattern"=>$language["requireEmailPattern"],
                        "data-pattern-message"=>$language["requireEmailRule"]
                    ),
                    "iClass"=>"form-control"
                ),
            ),
            "attrForm" => array(
                "class"=>"post-form form-horizontal"
            ),
            "button" => $listButton,
            "buttonClass"=>"row form-group"
        );
    } elseif($node == "seo") {
        $seoTitle = isset($nodeSeo["title"]) && !empty($nodeSeo["title"]) ? $nodeSeo["title"] : null;
        $seoGA = isset($nodeSeo["googleAnalyticsCode"]) && !empty($nodeSeo["googleAnalyticsCode"]) ? $nodeSeo["googleAnalyticsCode"] : null;
        $seoDescription = isset($nodeSeo["desc"]) && !empty($nodeSeo["desc"]) ? $nodeSeo["desc"] : null;
        $seoKeyword = isset($nodeSeo["keyword"]) && !empty($nodeSeo["keyword"]) ? $nodeSeo["keyword"] : null;

        $modeDesign = array(
            "eDesign" => array(
                "row"=>"form-group",
                "left"=>"col-xs-12 col-sm-2 control-label",
                "right"=>"col-xs-12 col-sm-8",
            ),
            "eInputHidden" => $inputHidden,
            "eForm" => array(
                array(
                    "iLabel"=>"Google Analytics Code",
                    "iName"=>"seo.googleAnalyticsCode",
                    "iValue"=>$seoGA,
                    "iTypeInput"=>"input",
                    "iClass"=>"form-control"
                ),
                array(
                    "iLabel"=>$language["metaTitle"],
                    "iName"=>"seo.title",
                    "iValue"=>$seoTitle,
                    "iTypeInput"=>"input",
                    "iClass"=>"form-control"
                ),
                array(
                    "iLabel"=>$language["metaDesc"],
                    "iName"=>"seo.desc",
                    "iValue"=>$seoDescription,
                    "iTypeInput"=>"input",
                    "iClass"=>"form-control"
                ),
                array(
                    "iLabel"=>$language["metaKeyword"],
                    "iName"=>"seo.keyword",
                    "iValue"=>$seoKeyword,
                    "iTypeInput"=>"input",
                    "iClass"=>"form-control"
                )

            ),
            "attrForm" => array(
                "class"=>"post-form form-horizontal"
            ),
            "button" => $listButton,
            "buttonClass"=>"row form-group"
        );
    } elseif($node == "email") {
        $emailOrders = isset($nodeEmail["orders"]) && !empty($nodeEmail["orders"]) ? $nodeEmail["orders"] : null;
        $emailContact = isset($nodeEmail["contact"]) && !empty($nodeEmail["contact"]) ? $nodeEmail["contact"] : null;

        $modeDesign = array(
            "eDesign" => array(
                "row"=>"form-group",
                "left"=>"col-xs-12 col-sm-2 control-label",
                "right"=>"col-xs-12 col-sm-8",
            ),
            "eInputHidden" => $inputHidden,
            "eForm" => array(
                array(
                    "iLabel"=>$language["orders"],
                    "iName"=>"email.orders",
                    "iValue"=>$emailOrders,
                    "iTypeInput"=>"input",
                    "iClass"=>"form-control"
                ),
                array(
                    "iLabel"=>$language["emailContact"],
                    "iName"=>"email.contact",
                    "iValue"=>$emailContact,
                    "iTypeInput"=>"input",
                    "iClass"=>"form-control"
                )

            ),
            "attrForm" => array(
                "class"=>"post-form form-horizontal"
            ),
            "button" => $listButton,
            "buttonClass"=>"row form-group"
        );
    } elseif($node == "emailcontent") {
        $listButton[0]["iClassCustom"] = "col-sm-offset-0 col-xs-4 col-sm-2";
        $emailcontentContact = isset($nodeEmailContent["contact"]) && !empty($nodeEmailContent["contact"]) ? $nodeEmailContent["contact"] : null;
        $emailcontentSupport = isset($nodeEmailContent["support"]) && !empty($nodeEmailContent["support"]) ? $nodeEmailContent["support"] : null;

        $emailcontentSignupverify = isset($nodeEmailContent["signupverify"]) && !empty($nodeEmailContent["signupverify"]) ? $nodeEmailContent["signupverify"] : null;
        $emailcontentSignupsuccess = isset($nodeEmailContent["signupsuccess"]) && !empty($nodeEmailContent["signupsuccess"]) ? $nodeEmailContent["signupsuccess"] : null;
        $emailcontentForgotpassword = isset($nodeEmailContent["forgotpassword"]) && !empty($nodeEmailContent["forgotpassword"]) ? $nodeEmailContent["forgotpassword"] : null;

        if (isset($isAdminPage) && $isAdminPage) {

            $eFormPlus = array(
                array(
                    "iLabel"=>$language["verifyCode"],
                    "iName"=>"emailcontent.signupverify",
                    "iValue"=>$emailcontentSignupverify,
                    "iTypeInput"=>"input",
                    "iTextarea"=>"true",
                    "iClass"=>"form-control mce-editor"
                ),
                array(
                    "iLabel"=>$language["signup"],
                    "iName"=>"emailcontent.signupsuccess",
                    "iValue"=>$emailcontentSignupsuccess,
                    "iTypeInput"=>"input",
                    "iTextarea"=>"true",
                    "iClass"=>"form-control mce-editor"
                )
            );
        } else {
            $eFormPlus = null;
        }

        $modeDesign = array(
            "eDesign" => array(
                "row"=>"form-group",
                "left"=>"col-xs-12 col-sm-12",
                "right"=>"col-xs-12 col-sm-12",
            ),
            "eInputHidden" => $inputHidden,
            "eForm" => array(
                array(
                    "iLabel"=>$language["contact"],
                    "iName"=>"emailcontent.contact",
                    "iValue"=>$emailcontentContact,
                    "iTypeInput"=>"input",
                    "iTextarea"=>"true",
                    "iClass"=>"form-control mce-editor"
                ),
                array(
                    "iLabel"=>$language["support"],
                    "iName"=>"emailcontent.support",
                    "iValue"=>$emailcontentSupport,
                    "iTypeInput"=>"input",
                    "iTextarea"=>"true",
                    "iClass"=>"form-control mce-editor"
                )
            ),
            "attrForm" => array(
                "class"=>"post-form form-horizontal"
            ),
            "button" => $listButton,
            "buttonClass"=>"row form-group"
        );

        array_splice($modeDesign["eForm"], 0, 0, $eFormPlus);

    } elseif($node == "order") {
        $listButton[0]["iClassCustom"] = "col-sm-offset-0 col-xs-4 col-sm-2";
        $orderEmpty = isset($nodeOrder["empty"]) && !empty($nodeOrder["empty"]) ? $nodeOrder["empty"] : null;
        $orderThankyou = isset($nodeOrder["thankyou"]) && !empty($nodeOrder["thankyou"]) ? $nodeOrder["thankyou"] : null;
        $orderProductInfo = isset($nodeOrder["productinfo"]) && !empty($nodeOrder["productinfo"]) ? $nodeOrder["productinfo"] : null;
        $orderProductDetail = isset($nodeOrder["productdetail"]) && !empty($nodeOrder["productdetail"]) ? $nodeOrder["productdetail"] : null;

        $modeDesign = array(
            "eDesign" => array(
                "row"=>"form-group",
                "left"=>"col-xs-12 col-sm-12",
                "right"=>"col-xs-12 col-sm-12",
            ),
            "eInputHidden" => $inputHidden,
            "eForm" => array(
                array(
                    "iLabel"=>$language["productInfo"],
                    "iName"=>"order.productinfo",
                    "iValue"=>$orderProductInfo,
                    "iTypeInput"=>"input",
                    "iTextarea"=>"true",
                    "iClass"=>"form-control mce-editor"
                ),
                array(
                    "iLabel"=>$language["productDetail"],
                    "iName"=>"order.productdetail",
                    "iValue"=>$orderProductDetail,
                    "iTypeInput"=>"input",
                    "iTextarea"=>"true",
                    "iClass"=>"form-control mce-editor"
                ),
                array(
                    "iLabel"=>$language["orderSuccess"],
                    "iName"=>"order.thankyou",
                    "iValue"=>$orderThankyou,
                    "iTypeInput"=>"input",
                    "iTextarea"=>"true",
                    "iClass"=>"form-control mce-editor"
                ),
                array(
                    "iLabel"=>$language["orderEmpty"],
                    "iName"=>"order.empty",
                    "iValue"=>$orderEmpty,
                    "iTypeInput"=>"input",
                    "iTextarea"=>"true",
                    "iClass"=>"form-control mce-editor"
                )

            ),
            "attrForm" => array(
                "class"=>"post-form form-horizontal"
            ),
            "button" => $listButton,
            "buttonClass"=>"row form-group"
        );
    } elseif($node == "script") {
        $listButton[0]["iClassCustom"] = "col-sm-offset-0 col-xs-4 col-sm-2";
        $scriptCss = isset($nodeScript["css"]) && !empty($nodeScript["css"]) ? $nodeScript["css"] : null;
        $scriptJavascript = isset($nodeScript["javascript"]) && !empty($nodeScript["javascript"]) ? $nodeScript["javascript"] : null;

        $modeDesign = array(
            "eDesign" => array(
                "row"=>"form-group",
                "left"=>"col-xs-12 col-sm-12",
                "right"=>"col-xs-12 col-sm-12",
            ),
            "eInputHidden" => $inputHidden,
            "eForm" => array(
                array(
                    "iLabel"=>"CSS",
                    "iName"=>"script.css",
                    "iValue"=>$scriptCss,
                    "iTypeInput"=>"input",
                    "iTextarea"=>"true",
                    "iAttr"=> array(
                        "style"=>"min-height:400px;"
                    ),
                    "iClass"=>"form-control"
                ),
                array(
                    "iLabel"=>"Javascript",
                    "iName"=>"script.javascript",
                    "iValue"=>$scriptJavascript,
                    "iTypeInput"=>"input",
                    "iTextarea"=>"true",
                    "iAttr"=> array(
                        "style"=>"min-height:300px;"
                    ),
                    "iClass"=>"form-control"
                )
            ),
            "attrForm" => array(
                "class"=>"post-form form-horizontal"
            ),
            "button" => $listButton,
            "buttonClass"=>"row form-group"
        );
    } elseif($node == "header") {
        $listButton[0]["iClassCustom"] = "col-sm-offset-0 col-xs-4 col-sm-2";
        $nodeHeader = isset($information["config"]["header"]) ? $information["config"]["header"] : null;
        $headerContent1 = isset($nodeHeader["content1"]) && !empty($nodeHeader["content1"]) ? $nodeHeader["content1"] : null;
        $headerContent2 = isset($nodeHeader["content2"]) && !empty($nodeHeader["content2"]) ? $nodeHeader["content2"] : null;

        $modeDesign = array(
            "eDesign" => array(
                "row"=>"form-group",
                "left"=>"col-xs-12 col-sm-12",
                "right"=>"col-xs-12 col-sm-12",
            ),
            "eInputHidden" => $inputHidden,
            "eForm" => array(
                array(
                    "iLabel"=>"{$language["header"]} 1",
                    "iName"=>"header.content1",
                    "iValue"=>$headerContent1,
                    "iTypeInput"=>"input",
                    "iTextarea"=>"true",
                    "iClass"=>"form-control mce-editor"
                ),
                array(
                    "iLabel"=>"{$language["header"]} 2",
                    "iName"=>"header.content2",
                    "iValue"=>$headerContent2,
                    "iTypeInput"=>"input",
                    "iTextarea"=>"true",
                    "iClass"=>"form-control mce-editor"
                )
            ),
            "attrForm" => array(
                "class"=>"post-form form-horizontal"
            ),
            "button" => $listButton,
            "buttonClass"=>"row form-group"
        );
    } elseif($node == "footer") {
        $listButton[0]["iClassCustom"] = "col-sm-offset-0 col-xs-4 col-sm-2";
        $nodeFooter = isset($information["config"]["footer"]) ? $information["config"]["footer"] : null;
        $footerContent1 = isset($nodeFooter["content1"]) && !empty($nodeFooter["content1"]) ? $nodeFooter["content1"] : null;
        $footerContent2 = isset($nodeFooter["content2"]) && !empty($nodeFooter["content2"]) ? $nodeFooter["content2"] : null;

        $modeDesign = array(
            "eDesign" => array(
                "row"=>"form-group",
                "left"=>"col-xs-12 col-sm-12",
                "right"=>"col-xs-12 col-sm-12",
            ),
            "eInputHidden" => $inputHidden,
            "eForm" => array(
                array(
                    "iLabel"=>"{$language["footer"]} 1",
                    "iName"=>"footer.content1",
                    "iValue"=>$footerContent1,
                    "iTypeInput"=>"input",
                    "iTextarea"=>"true",
                    "iClass"=>"form-control mce-editor"
                ),
                array(
                    "iLabel"=>"{$language["footer"]} 2",
                    "iName"=>"footer.content2",
                    "iValue"=>$footerContent2,
                    "iTypeInput"=>"input",
                    "iTextarea"=>"true",
                    "iClass"=>"form-control mce-editor"
                )
            ),
            "attrForm" => array(
                "class"=>"post-form form-horizontal"
            ),
            "button" => $listButton,
            "buttonClass"=>"row form-group"
        );
    } elseif($node == "menubaner") {
        $listButton[0]["iClassCustom"] = "col-sm-offset-0 col-xs-4 col-sm-2";
        $nodeMenubaner = isset($information["config"]["menubaner"]) ? $information["config"]["menubaner"] : null;
        $menubanerMenu = isset($nodeMenubaner["menu"]) && !empty($nodeMenubaner["menu"]) ? $nodeMenubaner["menu"] : null;
        $menubanerBaner = isset($nodeMenubaner["baner"]) && !empty($nodeMenubaner["baner"]) ? $nodeMenubaner["baner"] : null;

        $modeDesign = array(
            "eDesign" => array(
                "row"=>"form-group",
                "left"=>"col-xs-12 col-sm-12",
                "right"=>"col-xs-12 col-sm-12",
            ),
            "eInputHidden" => $inputHidden,
            "eForm" => array(
                array(
                    "iLabel"=>$language["customNavMenu"],
                    "iName"=>"menubaner.menu",
                    "iValue"=>$menubanerMenu,
                    "iTypeInput"=>"input",
                    "iTextarea"=>"true",
                    "iClass"=>"form-control mce-editor"
                ),
                array(
                    "iLabel"=>$language["customBannerHome"],
                    "iName"=>"menubaner.baner",
                    "iValue"=>$menubanerBaner,
                    "iTypeInput"=>"input",
                    "iTextarea"=>"true",
                    "iClass"=>"form-control mce-editor"
                )
            ),
            "attrForm" => array(
                "class"=>"post-form form-horizontal"
            ),
            "button" => $listButton,
            "buttonClass"=>"row form-group"
        );
    } elseif($node == "column") {

        $nodeColumn = isset($information["config"]["column"]) ? $information["config"]["column"] : null;
        $columnLeft = isset($nodeColumn["left"]) && !empty($nodeColumn["left"]) ? $nodeColumn["left"] : null;
        $columnMain = isset($nodeColumn["main"]) && !empty($nodeColumn["main"]) ? $nodeColumn["main"] : null;
        $columnRight = isset($nodeColumn["right"]) && !empty($nodeColumn["right"]) ? $nodeColumn["right"] : null;

        $modeDesign = array(
            "eDesign" => array(
                "row"=>"form-group",
                "left"=>"col-xs-12 col-sm-2 control-label",
                "right"=>"col-xs-12 col-sm-9",
            ),
            "eInputHidden" => $inputHidden,
            "eForm" => array(
                array(
                    "iLabel"=>$language["left"],
                    "iName"=>"column.left",
                    "iValue"=>$columnLeft,
                    "iTypeInput"=>"input",
                    "iClass"=>"form-control"
                ),
                array(
                    "iLabel"=>$language["main"],
                    "iName"=>"column.main",
                    "iValue"=>$columnMain,
                    "iTypeInput"=>"input",
                    "iClass"=>"form-control"
                ),
                array(
                    "iLabel"=>$language["right"],
                    "iName"=>"column.right",
                    "iValue"=>$columnRight,
                    "iTypeInput"=>"input",
                    "iClass"=>"form-control"
                )
            ),
            "attrForm" => array(
                "class"=>"post-form form-horizontal"
            ),
            "button" => $listButton,
            "buttonClass"=>"row form-group"
        );
    } elseif($node == "advertise") {
        $listButton[0]["iClassCustom"] = "col-sm-offset-0 col-xs-4 col-sm-2";
        $nodeAdvertise = isset($information["config"]["advertise"]) ? $information["config"]["advertise"] : null;
        $advertiseLeft = isset($nodeAdvertise["left"]) && !empty($nodeAdvertise["left"]) ? $nodeAdvertise["left"] : null;
        $advertiseMain = isset($nodeAdvertise["main"]) && !empty($nodeAdvertise["main"]) ? $nodeAdvertise["main"] : null;
        $advertiseRight = isset($nodeAdvertise["right"]) && !empty($nodeAdvertise["right"]) ? $nodeAdvertise["right"] : null;

        $modeDesign = array(
            "eDesign" => array(
                "row"=>"form-group",
                "left"=>"col-xs-12 col-sm-12",
                "right"=>"col-xs-12 col-sm-12",
            ),
            "eInputHidden" => $inputHidden,
            "eForm" => array(
                array(
                    "iLabel"=>$language["advertiseLeft"],
                    "iName"=>"advertise.left",
                    "iValue"=>$advertiseLeft,
                    "iTypeInput"=>"input",
                    "iTextarea"=>"true",
                    "iClass"=>"form-control mce-editor"
                ),
                array(
                    "iLabel"=>$language["advertisePopup"],
                    "iName"=>"advertise.main",
                    "iValue"=>$advertiseMain,
                    "iTypeInput"=>"input",
                    "iTextarea"=>"true",
                    "iClass"=>"form-control mce-editor"
                ),
                array(
                    "iLabel"=>$language["advertiseRight"],
                    "iName"=>"advertise.right",
                    "iValue"=>$advertiseRight,
                    "iTypeInput"=>"input",
                    "iTextarea"=>"true",
                    "iClass"=>"form-control mce-editor"
                )
            ),
            "attrForm" => array(
                "class"=>"post-form form-horizontal"
            ),
            "button" => $listButton,
            "buttonClass"=>"row form-group"
        );
    } elseif($node == "sidebar") {
        $detailList = isset($information["sidebar"])?$information["sidebar"] : null;

        $id = isset($_GET["id"]) ? $_GET["id"] : null;

        if(isset($detailList["n_{$id}"])) {
            $sidebarNode = $detailList["n_{$id}"];
            $strButton = $language["btnUpdate"];
        } else {
            $strButton = $language["btnAdd"];
            $listButton[0]["iAttr"]["data-trigger-click"] = '.modal .fa-times-circle';
        }

        $listButton[0]["iLabel"] = '<span>'.$strButton.'</span>';

        $title = isset($sidebarNode["ti"]) && !empty($sidebarNode["ti"]) ? $sidebarNode["ti"] : null;
        $category = isset($sidebarNode["cat"]) && !empty($sidebarNode["cat"]) ? $sidebarNode["cat"] : null;
        $description = isset($sidebarNode["de"]) && !empty($sidebarNode["de"]) ? $sidebarNode["de"] : null;

        $cls = isset($sidebarNode["cls"]) && !empty($sidebarNode["cls"]) ? $sidebarNode["cls"] : null;
        $attr = isset($sidebarNode["attr"]) && !empty($sidebarNode["attr"]) ? $sidebarNode["attr"] : null;
        $sort = isset($sidebarNode["so"]) && !empty($sidebarNode["so"]) ? $sidebarNode["so"] : null;
        $display = isset($sidebarNode["dis"]) && !empty($sidebarNode["dis"]) ? $sidebarNode["dis"] : null;

        $modeDesign = array(
            "eDesign" => array(
                "row"=>"row form-group",
                "left"=>"col-xs-12 col-sm-2 control-label",
                "right"=>"col-xs-12 col-sm-10",
            ),
            "eInputHidden" => array(
                array(
                    "type"=>"hidden",
                    "name"=>"config.type",
                    "value"=>"sidebar",
                    "data-validate"=>"",
                    "data-required"=>$language["requireInput"]
                ),
                array(
                    "type"=>"hidden",
                    "name"=>"sidebar.id",
                    "value"=>$id
                )
            ),
            "eForm" => array(
                array(
                    "iLabel"=>$language["title"],
                    "iName"=>"sidebar.ti",
                    "iValue"=>$title,
                    "iTypeInput"=>"input",
                    "iClass"=>"form-control"
                ),
                /*array(
                    "iLabel"=>$language["category"],
                    "iName"=>"db.ism",
                    "iTypeCheckbox"=>"checkbox",
                    "iAttr"=>'data-validates data-pattern-message="invalide option" data-hidden-message="true" type="checkbox" data-option-onlys="6"',
                    "iDesign"=>'<div class="item-ticket"><label class="checkbox"><input type="checkbox" name="{3}.{0}" data-key="{3}" value="{0}" {2}><span class="fa checkbox-style"></span><span> {1}</span></label></div>',
                    "iList"=>"menuStructure",
                    "iOptioned"=>"{$category}",
                    "iGroup"=>4,
                    "iGroupClass"=>"col-xs-4 col-sm-2",
                    "iKey"=>"id",
                    "iValue"=>"ti",
                    "iKeyBox"=>"sidebar.cat"
                ),*/
                array(
                    "iLabel"=>$language["category"],
                    "iName"=>"categorylist",
                    "iTypeDropdown"=>"dropdown",
                    "multiOption"=>"multiselect-category",
                    "iAttr"=>array(
                        "data-validate"=>"",
                        "data-required"=>$language["requireInput"],
                        "data-multiselect-box"=>"",
                        "data-multi-selected"=>$category,
                        "data-target-append"=>".multiselect-category",
                        "data-index-value"=>$category,
                        "data-key-name"=>"sidebar.cat",
                        "type"=>"select-from-json",
                        "data-dropdown"=>"",
                        "data-local-optiona"=>"menuStructure",
                        "data-object-init"=>"{\"id\":\"\", \"ti\":\"{$language["category"]}\"}"
                    ),
                    "iClass"=>"form-control"
                ),
                array(
                    "iLabel"=>$language["description"],
                    "iName"=>"sidebar.de",
                    "iValue"=>$description,
                    "iTypeInput"=>"input",
                    "iTextarea"=>"true",
                    "iClass"=>"form-control mce-editor"
                ),
                array(
                    "iLabel"=>$language["customClass"],
                    "iName"=>"sidebar.cls",
                    "iValue"=>$cls,
                    "iTypeInput"=>"input",
                    "iClass"=>"form-control"
                ),
                array(
                    "iLabel"=>$language["htmlAttr"],
                    "iName"=>"sidebar.attr",
                    "iValue"=>$attr,
                    "iTypeInput"=>"input",
                    "iClass"=>"form-control"
                ),
                array(
                    "iLabel"=>$language["order"],
                    "iName"=>"sidebar.so",
                    "iValue"=>$sort,
                    "iTypeInput"=>"number",
                    "iClass"=>"form-control"
                ),
                array(
                    "iLabel"=>$language["display"],
                    "iName"=>"sidebar.dis",
                    "iTypeCheckbox"=>"checkbox",
                    "iAttr"=>'data-validates data-pattern-message="invalide option" data-hidden-message="true" type="checkbox" data-option-onlys="6"',
                    "iDesign"=>'<div class="checkbox-inline"><label class="checkbox"><input type="checkbox" name="{3}.{0}" data-key="{3}" value="{0}" {2}><span class="fa checkbox-style"></span><span> {1}</span></label> </div>',
                    "iList"=>$language["dropdownLocalOption"]["checkboxDisplay"],
                    "iOptioned"=>$display,
                    "iKeyBox"=>"sidebar.dis"
                )
            ),
            "attrForm" => array(
                "class"=>"post-form form-horizontal"
            ),
            "button" => $listButton,
            "buttonClass"=>"row form-group"
        );
    } elseif($node == "sidebarConfig") {

        $sidebarConfigMenu = isset($information["config"]["sidebarConfig"]["followMenu"]) ? $information["config"]["sidebarConfig"]["followMenu"] : 1;

        $modeDesign = array(
            "eDesign" => array(
                "row"=>"form-group",
                "left"=>"col-xs-12 col-sm-2 control-label",
                "right"=>"col-xs-12 col-sm-9",
            ),
            "eInputHidden" => $inputHidden,
            "eForm" => array(
                array(
                    "iLabel"=>$language["followMenu"],
                    "iTypeRadio"=>"radio",
                    "iAttr"=>'data-validates data-pattern-message="invalide option" data-hidden-message="true" type="checkbox"',
                    "iDesign"=>'<div class="radio-inline"><label class="radio"><input type="radio" name="sidebarConfig.followMenu" data-key="sidebarConfig.followMenu" value="{0}" {2}><span class="fa radio-style"></span><span>{1}</span></label> </div>',
                    "iList"=>$language["dropdownLocalOption"]["yesNoQuestion"],
                    "iOptioned"=>$sidebarConfigMenu,
                    "iKeyBox"=>"sidebarConfig.followMenu"
                )
            ),
            "attrForm" => array(
                "class"=>"post-form form-horizontal"
            ),
            "button" => $listButton,
            "buttonClass"=>"row form-group"
        );

    } elseif($node == "filterproperties") {
        $detailList = isset($information["filterproperties"])?$information["filterproperties"] : null;

        if ($detailList) {
            $dataList = array_filter($detailList, function ($obj) {
                return !isset($obj["pa"]) ? true : intval($obj["pa"])==0 ;
            });
            $dataList = array_values($dataList);
        } else {
            $dataList = array(
                array(
                    "id" => 0,
                    "ti"=>$language["rootMenu"]
                )
            );
        }

        $id = isset($_GET["id"]) ? $_GET["id"] : null;

        if(isset($detailList["n_{$id}"])) {
            $sidebarNode = $detailList["n_{$id}"];
            $strButton = $language["btnUpdate"];
        } else {
            $strButton = $language["btnAdd"];
            $listButton[0]["iAttr"]["data-trigger-click"] = '.modal .fa-times-circle';
        }

        $listButton[0]["iLabel"] = '<span>'.$strButton.'</span>';

        $title = isset($sidebarNode["ti"]) && !empty($sidebarNode["ti"]) ? $sidebarNode["ti"] : null;
        $code = isset($sidebarNode["code"]) && !empty($sidebarNode["code"]) ? $sidebarNode["code"] : null;
        $note = isset($sidebarNode["note"]) && !empty($sidebarNode["note"]) ? $sidebarNode["note"] : null;
        $parentId = isset($sidebarNode["pa"]) && !empty($sidebarNode["pa"]) ? $sidebarNode["pa"] : null;
        $type = isset($sidebarNode["type"]) && !empty($sidebarNode["type"]) ? $sidebarNode["type"] : null;
        $typeSearch = isset($sidebarNode["typesearch"]) && !empty($sidebarNode["typesearch"]) ? $sidebarNode["typesearch"] : null;
        $attr = isset($sidebarNode["attr"]) && !empty($sidebarNode["attr"]) ? $sidebarNode["attr"] : null;
        $sort = isset($sidebarNode["so"]) && !empty($sidebarNode["so"]) ? $sidebarNode["so"] : null;
        $strRequired = isset($sidebarNode["required"]) && !empty($sidebarNode["required"]) ? $sidebarNode["required"] : 1;
        $category = isset($sidebarNode["cat"]) ? $sidebarNode["cat"] : null;

        $modeDesign = array(
            "eDesign" => array(
                "row"=>"row form-group",
                "left"=>"col-xs-12 col-sm-2 control-label",
                "right"=>"col-xs-12 col-sm-10",
            ),
            "eInputHidden" => array(
                array(
                    "type"=>"hidden",
                    "name"=>"config.type",
                    "value"=>"filterproperties",
                    "data-validate"=>"",
                    "data-required"=>$language["requireInput"]
                ),
                array(
                    "type"=>"hidden",
                    "name"=>"filterproperties.id",
                    "value"=>$id
                )
            ),
            "eForm" => array(
                array(
                    "iLabel"=>$language["title"],
                    "iName"=>"filterproperties.ti",
                    "iValue"=>$title,
                    "iTypeInput"=>"input",
                    "iAttr"=> array(
                        "data-validate"=>"",
                        "data-required"=>$language["requireInput"]
                    ),
                    "iClass"=>"form-control"
                ),
                array(
                    "iLabel"=>$language["code"],
                    "iName"=>"filterproperties.code",
                    "iValue"=>$code,
                    "iTypeInput"=>"input",
                    "iAttr"=> array(
                    ),
                    "iClass"=>"form-control"
                ),
                array(
                    "iLabel"=>$language["note"],
                    "iName"=>"filterproperties.note",
                    "iValue"=>$note,
                    "iTypeInput"=>"input",
                    "iClass"=>"form-control"
                ),
                array(
                    "iLabel"=>$language["category"],
                    "iName"=>"categorylist",
                    "iTypeDropdown"=>"dropdown",
                    "multiOption"=>"multiselect-category",
                    "iAttr"=>array(
                        "data-validate"=>"",
                        "data-required"=>$language["requireInput"],
                        "data-multiselect-box"=>"",
                        "data-multi-selected"=>$category,
                        "data-target-append"=>".multiselect-category",
                        "data-index-value"=>$category,
                        "data-key-name"=>"filterproperties.cat",
                        "type"=>"select-from-json",
                        "data-dropdown"=>"",
                        "data-params"=>"opp=3",
                        "data-local-optiona"=>"menuStructure",
                        "data-object-init"=>"{\"id\":\"\", \"ti\":\"{$language["category"]}\"}"
                    ),
                    "iClass"=>"form-control"
                ),
                array(
                    "iLabel"=>$language["inputType"],
                    "iClassCustom"=>"style-button",
                    "iName"=>"filterproperties.type",
                    "iTypeRadio"=>"radio",
                    "iAttr"=>'data-validates data-pattern-message="invalide option" data-hidden-message="true" type="checkbox" data-option-onlys="6"',
                    "iDesign"=>'<div class="radio-inline"><label class="radio"><input type="radio" name="filterproperties.type" data-key="filterproperties.type" value="{0}" {2}><span class="fa radio-style"></span><span>{1}</span></label> </div>',
                    "iList"=>$language["dropdownLocalOption"]["attrInputOption"],
                    "iOptioned"=>$type,
                    "iKeyBox"=>"filterproperties.type"
                ),
                array(
                    "iLabel"=>$language["searchType"],
                    "iClassCustom"=>"style-button",
                    "iName"=>"filterproperties.typesearch",
                    "iTypeRadio"=>"radio",
                    "iAttr"=>'data-validates data-pattern-message="invalide option" data-hidden-message="true" type="checkbox" data-option-onlys="6"',
                    "iDesign"=>'<div class="radio-inline"><label class="radio"><input type="radio" name="filterproperties.typesearch" data-key="filterproperties.typesearch" value="{0}" {2}><span class="fa radio-style"></span><span>{1}</span></label> </div>',
                    "iList"=>$language["dropdownLocalOption"]["attrInputOption"],
                    "iOptioned"=>$typeSearch,
                    "iKeyBox"=>"filterproperties.type"
                ),
                array(
                    "iLabel"=>$language["rootMenu"],
                    "iName"=>"filterproperties.pa",
                    "iTypeDropdown"=>"dropdown",
                    "iAttr"=>array(
                        "type"=>"select-from-json",
                        "data-dropdown"=>"",
                        "data-index-value"=>$parentId,
                        "data-local-optiona"=>json_encode($dataList, true),
                        "data-object-init"=>"{\"id\":\"0\", \"ti\":\"{$language["rootMenu"]}\"}"
                    ),
                    "iClass"=>"form-control"
                ),
                array(
                    "iLabel"=>$language["requireInput"],
                    "iClassCustom"=>"style-button",
                    "iName"=>"filterproperties.required",
                    "iTypeRadio"=>"radio",
                    "iAttr"=>'data-validates data-pattern-message="invalide option" data-hidden-message="true" type="checkbox" data-option-onlys="6"',
                    "iDesign"=>'<div class="radio-inline"><label class="radio"><input type="radio" name="filterproperties.required" data-key="filterproperties.required" value="{0}" {2}><span class="fa radio-style"></span><span>{1}</span></label> </div>',
                    "iList"=>$language["dropdownLocalOption"]["yesNoQuestion"],
                    "iOptioned"=>$strRequired
                ),
                array(
                    "iLabel"=>$language["htmlAttr"],
                    "iName"=>"filterproperties.attr",
                    "iValue"=>$attr,
                    "iTypeInput"=>"input",
                    "iClass"=>"form-control"
                ),
                array(
                    "iLabel"=>$language["order"],
                    "iName"=>"filterproperties.so",
                    "iValue"=>$sort,
                    "iTypeInput"=>"number",
                    "iClass"=>"form-control"
                )
            ),
            "attrForm" => array(
                "class"=>"post-form form-horizontal"
            ),
            "button" => $listButton,
            "buttonClass"=>"row form-group"
        );
    } elseif($node == "variantColor") {

        $detailList = isset($information["variantColor"])?$information["variantColor"] : null;

        $id = isset($_GET["id"]) ? $_GET["id"] : null;

        if(isset($detailList["n_{$id}"])) {
            $sidebarNode = $detailList["n_{$id}"];
            $strButton = $language["btnUpdate"];
        } else {
            $strButton = $language["btnAdd"];
            $listButton[0]["iAttr"]["data-trigger-click"] = '[data-quick-view-item1].modal .fa-times-circle';
        }

        $listButton[0]["iLabel"] = '<span>'.$strButton.'</span>';

        $title = isset($sidebarNode["ti"]) && !empty($sidebarNode["ti"]) ? $sidebarNode["ti"] : null;
        $html = isset($sidebarNode["html"]) && !empty($sidebarNode["html"]) ? $sidebarNode["html"] : null;
        $sort = isset($sidebarNode["so"]) && !empty($sidebarNode["so"]) ? $sidebarNode["so"] : null;

        $modeDesign = array(
            "eDesign" => array(
                "row"=>"row form-group",
                "left"=>"col-xs-12 col-sm-2 control-label",
                "right"=>"col-xs-12 col-sm-10",
            ),
            "eInputHidden" => array(
                array(
                    "type"=>"hidden",
                    "name"=>"config.type",
                    "value"=>"variantColor",
                    "data-validate"=>"",
                    "data-required"=>$language["requireInput"]
                ),
                array(
                    "type"=>"hidden",
                    "name"=>"variantColor.id",
                    "value"=>$id
                )
            ),
            "eForm" => array(
                array(
                    "iLabel"=>$language["title"],
                    "iName"=>"variantColor.ti",
                    "iValue"=>$title,
                    "iTypeInput"=>"input",
                    "iClass"=>"form-control"
                ),
                array(
                    "iLabel"=>"HTML Block",
                    "iName"=>"variantColor.html",
                    "iValue"=>$html,
                    "iTypeInput"=>"input",
                    "iClass"=>"form-control"
                ),
                array(
                    "iLabel"=>$language["order"],
                    "iName"=>"variantColor.so",
                    "iValue"=>$sort,
                    "iTypeInput"=>"number",
                    "iClass"=>"form-control"
                )
            ),
            "attrForm" => array(
                "class"=>"post-form form-horizontal"
            ),
            "button" => $listButton,
            "buttonClass"=>"row form-group"
        );

    } elseif($node == "variantSize") {

        $detailList = isset($information["variantSize"])?$information["variantSize"] : null;

        $id = isset($_GET["id"]) ? $_GET["id"] : null;

        if(isset($detailList["n_{$id}"])) {
            $sidebarNode = $detailList["n_{$id}"];
            $strButton = $language["btnUpdate"];
        } else {
            $strButton = $language["btnAdd"];
            $listButton[0]["iAttr"]["data-trigger-click"] = '[data-quick-view-item1].modal .fa-times-circle';
        }

        $listButton[0]["iLabel"] = '<span>'.$strButton.'</span>';

        $title = isset($sidebarNode["ti"]) && !empty($sidebarNode["ti"]) ? $sidebarNode["ti"] : null;
        $html = isset($sidebarNode["html"]) && !empty($sidebarNode["html"]) ? $sidebarNode["html"] : null;
        $sort = isset($sidebarNode["so"]) && !empty($sidebarNode["so"]) ? $sidebarNode["so"] : null;

        $modeDesign = array(
            "eDesign" => array(
                "row"=>"row form-group",
                "left"=>"col-xs-12 col-sm-2 control-label",
                "right"=>"col-xs-12 col-sm-10",
            ),
            "eInputHidden" => array(
                array(
                    "type"=>"hidden",
                    "name"=>"config.type",
                    "value"=>"variantSize",
                    "data-validate"=>"",
                    "data-required"=>$language["requireInput"]
                ),
                array(
                    "type"=>"hidden",
                    "name"=>"variantSize.id",
                    "value"=>$id
                )
            ),
            "eForm" => array(
                array(
                    "iLabel"=>$language["title"],
                    "iName"=>"variantSize.ti",
                    "iValue"=>$title,
                    "iTypeInput"=>"input",
                    "iClass"=>"form-control"
                ),
                array(
                    "iLabel"=>$language["content"],
                    "iName"=>"variantSize.html",
                    "iValue"=>$html,
                    "iTypeInput"=>"input",
                    "iClass"=>"form-control"
                ),
                array(
                    "iLabel"=>$language["order"],
                    "iName"=>"variantSize.so",
                    "iValue"=>$sort,
                    "iTypeInput"=>"number",
                    "iClass"=>"form-control"
                )
            ),
            "attrForm" => array(
                "class"=>"post-form form-horizontal"
            ),
            "button" => $listButton,
            "buttonClass"=>"row form-group"
        );

    } elseif($node == "metatag") {
        $listButton[0]["iClassCustom"] = "col-sm-offset-0 col-xs-4 col-sm-2";
        $metatagContent1 = isset($nodeMetatag["content1"]) && !empty($nodeMetatag["content1"]) ? $nodeMetatag["content1"] : null;
        $metatagContentBodytop = isset($nodeMetatag["contentBodytop"]) && !empty($nodeMetatag["contentBodytop"]) ? $nodeMetatag["contentBodytop"] : null;
        $metatagContentBodybottom = isset($nodeMetatag["contentBodybottom"]) && !empty($nodeMetatag["contentBodybottom"]) ? $nodeMetatag["contentBodybottom"] : null;

        $modeDesign = array(
            "eDesign" => array(
                "row"=>"form-group",
                "left"=>"col-xs-12 col-sm-12",
                "right"=>"col-xs-12 col-sm-12",
            ),
            "eInputHidden" => $inputHidden,
            "eForm" => array(
                array(
                    "iLabel"=>"Meta tag content",
                    "iName"=>"metatag.content1",
                    "iValue"=>$metatagContent1,
                    "iTypeInput"=>"input",
                    "iTextarea"=>"true",
                    "iAttr"=> array(
                        "style"=>"min-height:200px;"
                    ),
                    "iClass"=>"form-control"
                ),
                array(
                    "iLabel"=>"Element in Body Top",
                    "iName"=>"metatag.contentBodytop",
                    "iValue"=>$metatagContentBodytop,
                    "iTypeInput"=>"input",
                    "iTextarea"=>"true",
                    "iAttr"=> array(
                        "style"=>"min-height:200px;"
                    ),
                    "iClass"=>"form-control"
                ),
                array(
                    "iLabel"=>"Element in Body Bottom",
                    "iName"=>"metatag.contentBodybottom",
                    "iValue"=>$metatagContentBodybottom,
                    "iTypeInput"=>"input",
                    "iTextarea"=>"true",
                    "iAttr"=> array(
                        "style"=>"min-height:200px;"
                    ),
                    "iClass"=>"form-control"
                )
            ),
            "attrForm" => array(
                "class"=>"post-form form-horizontal"
            ),
            "button" => $listButton,
            "buttonClass"=>"row form-group"
        );
    }
}

