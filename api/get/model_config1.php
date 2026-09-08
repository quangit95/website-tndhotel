<?php
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

$nodeMore = isset($information["config"]["$node"]) ? $information["config"]["$node"] : null;

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

    $groupDescription = [];
    $groupPageNotfound = [];
    $groupCustomDescription = [];
    foreach ($multiLanguage as $key => $value) {
        array_push($groupDescription, [
            "iLabel"=>"{$language["description"]} ({$key})",
            "iName"=>"{$node}.{$key}.description",
            "iValue"=>isset($nodeMore[$key]["description"]) ? $nodeMore[$key]["description"] : null,
            "iTypeInput"=>"input",
            "iTextarea"=>"true",
            "gClass"=>"col-xs-12 mb-10",
            "iClass"=>"form-control mce-editor"
        ]);

        array_push($groupCustomDescription, [
            "iLabel"=>"Custom ({$key})",
            "iName"=>"{$node}.{$key}.customDescription",
            "iValue"=>isset($nodeMore[$key]["customDescription"]) ? $nodeMore[$key]["customDescription"] : null,
            "iTypeInput"=>"input",
            "iTextarea"=>"true",
            "gClass"=>"col-xs-12 mb-10",
            "iClass"=>"form-control mce-editor"
        ]);

        array_push($groupPageNotfound, [
            "iLabel"=>"{$language["pageNotfound"]} ({$key})",
            "iName"=>"{$node}.{$key}.pageNotfound",
            "iValue"=>isset($nodeMore[$key]["pageNotfound"]) ? $nodeMore[$key]["pageNotfound"] : null,
            "iTypeInput"=>"input",
            "iTextarea"=>"true",
            "gClass"=>"col-xs-12 mb-10",
            "iClass"=>"form-control mce-editor"
        ]);
    }

    $modeDesign = array(
        "eDesign" => array(
            "row"=>"form-group",
            "left"=>"col-xs-12 col-sm-12 hidden",
            "right"=>"col-xs-12 col-sm-12",
        ),
        "eInputHidden" => $inputHidden,
        "eForm" => array(
            array(
                "iLabel"=>$language["description"],
                "groupClass"=>"row",
                "groupInput"=>$groupDescription,
            ),
            array(
                "iLabel"=>"Custom description",
                "groupClass"=>"row",
                "groupInput"=>$groupCustomDescription,
            ),
            array(
                "iLabel"=>$language["pageNotfound"],
                "groupClass"=>"row",
                "groupInput"=>$groupPageNotfound,
            )
        ),
        "attrForm" => array(
            "class"=>"post-form form-horizontal"
        ),
        "button" => $listButton,
        "buttonClass"=>"row form-group"
    );
} elseif($node == "social") {
    $socialSkype = isset($nodeMore["skype"]) && !empty($nodeMore["skype"]) ? $nodeMore["skype"] : null;
    $socialFacebook = isset($nodeMore["facebook"]) && !empty($nodeMore["facebook"]) ? $nodeMore["facebook"] : null;
    $socialHotline = isset($nodeMore["hotline"]) && !empty($nodeMore["hotline"]) ? $nodeMore["hotline"] : null;
    $socialEmail = isset($nodeMore["email"]) && !empty($nodeMore["email"]) ? $nodeMore["email"] : null;
    $socialAddress = isset($nodeMore["address"]) && !empty($nodeMore["address"]) ? $nodeMore["address"] : null;

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

    $seoGA = isset($nodeMore["googleAnalyticsCode"]) && !empty($nodeMore["googleAnalyticsCode"]) ? $nodeMore["googleAnalyticsCode"] : null;
    $groupTitle = [];
    $groupDesc = [];
    $groupKeyword = [];

    foreach ($multiLanguage as $key => $value) {
        array_push($groupTitle, [
            "iName"=>"{$node}.{$key}.title",
            "iValue"=>isset($nodeMore[$key]["title"]) ? $nodeMore[$key]["title"] : null,
            "iTypeInput"=>"input",
            "iAttr"=>[
                "placeholder"=>$key,
            ],
            "gClass"=>"col-xs-12 mb-10",
            "iClass"=>"form-control"
        ]);
        array_push($groupDesc, [
            "iName"=>"{$node}.{$key}.desc",
            "iValue"=>isset($nodeMore[$key]["desc"]) ? $nodeMore[$key]["desc"] : null,
            "iTypeInput"=>"input",
            "iAttr"=>[
                "placeholder"=>$key,
            ],
            "gClass"=>"col-xs-12 mb-10",
            "iClass"=>"form-control"
        ]);
        array_push($groupKeyword, [
            "iName"=>"{$node}.{$key}.keyword",
            "iValue"=>isset($nodeMore[$key]["keyword"]) ? $nodeMore[$key]["keyword"] : null,
            "iTypeInput"=>"input",
            "iAttr"=>[
                "placeholder"=>$key,
            ],
            "gClass"=>"col-xs-12 mb-10",
            "iClass"=>"form-control"
        ]);
    }

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
                "groupClass"=>"row",
                "groupInput"=>$groupTitle,
            ),
            array(
                "iLabel"=>$language["metaDesc"],
                "groupClass"=>"row",
                "groupInput"=>$groupDesc,
            ),
            array(
                "iLabel"=>$language["metaKeyword"],
                "groupClass"=>"row",
                "groupInput"=>$groupKeyword,
            )

        ),
        "attrForm" => array(
            "class"=>"post-form form-horizontal"
        ),
        "button" => $listButton,
        "buttonClass"=>"row form-group"
    );
} elseif($node == "email") {
    $emailOrders = isset($nodeMore["orders"]) && !empty($nodeMore["orders"]) ? $nodeMore["orders"] : null;
    $emailContact = isset($nodeMore["contact"]) && !empty($nodeMore["contact"]) ? $nodeMore["contact"] : null;

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

    $groupContact = [];
    $groupSupport = [];
    $groupSignupverify = [];
    $groupSignupsuccess = [];
    $groupForgotpassword = [];

    foreach ($multiLanguage as $key => $value) {
        array_push($groupContact, [
            "iLabel"=>"{$language["contact"]} ({$key})",
            "iName"=>"{$node}.{$key}.contact",
            "iValue"=>isset($nodeMore[$key]["contact"]) ? $nodeMore[$key]["contact"] : null,
            "iTypeInput"=>"input",
            "iTextarea"=>"true",
            "gClass"=>"col-xs-12 mb-10",
            "iClass"=>"form-control mce-editor"
        ]);
        array_push($groupSupport, [
            "iLabel"=>"{$language["support"]} ({$key})",
            "iName"=>"{$node}.{$key}.support",
            "iValue"=>isset($nodeMore[$key]["support"]) ? $nodeMore[$key]["support"] : null,
            "iTypeInput"=>"input",
            "iTextarea"=>"true",
            "gClass"=>"col-xs-12 mb-10",
            "iClass"=>"form-control mce-editor"
        ]);

        array_push($groupSignupverify, [
            "iLabel"=>"{$language["verifyCode"]} ({$key})",
            "iName"=>"{$node}.{$key}.signupverify",
            "iValue"=>isset($nodeMore[$key]["signupverify"]) ? $nodeMore[$key]["signupverify"] : null,
            "iTypeInput"=>"input",
            "iTextarea"=>"true",
            "gClass"=>"col-xs-12 mb-10",
            "iClass"=>"form-control mce-editor"
        ]);

        array_push($groupSignupsuccess, [
            "iLabel"=>"{$language["signup"]} ({$key})",
            "iName"=>"{$node}.{$key}.signupsuccess",
            "iValue"=>isset($nodeMore[$key]["signupsuccess"]) ? $nodeMore[$key]["signupsuccess"] : null,
            "iTypeInput"=>"input",
            "iTextarea"=>"true",
            "gClass"=>"col-xs-12 mb-10",
            "iClass"=>"form-control mce-editor"
        ]);

        array_push($groupForgotpassword, [
            "iLabel"=>"{$language["forgotPassword"]} ({$key})",
            "iName"=>"{$node}.{$key}.forgotpassword",
            "iValue"=>isset($nodeMore[$key]["forgotpassword"]) ? $nodeMore[$key]["forgotpassword"] : null,
            "iTypeInput"=>"input",
            "iTextarea"=>"true",
            "gClass"=>"col-xs-12 mb-10",
            "iClass"=>"form-control mce-editor"
        ]);

    }

    if (isset($isAdminPage) && $isAdminPage) {
        $eFormPlus = array(
            array(
                "iLabel"=>$language["verifyCode"],
                "groupClass"=>"row",
                "groupInput"=>$groupSignupverify,
            ),
            array(
                "iLabel"=>$language["signup"],
                "groupClass"=>"row",
                "groupInput"=>$groupSignupsuccess,
            ),
            array(
                "iLabel"=>$language["forgotPassword"],
                "groupClass"=>"row",
                "groupInput"=>$groupForgotpassword,
            )
        );
    } else {
        $eFormPlus = null;
    }

    $modeDesign = array(
        "eDesign" => array(
            "row"=>"form-group",
            "left"=>"col-xs-12 col-sm-12 hidden",
            "right"=>"col-xs-12 col-sm-12",
        ),
        "eInputHidden" => $inputHidden,
        "eForm" => array(
            array(
                "iLabel"=>$language["contact"],
                "groupClass"=>"row",
                "groupInput"=>$groupContact,
            ),
            array(
                "iLabel"=>$language["support"],
                "groupClass"=>"row",
                "groupInput"=>$groupSupport,
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
    $groupEmpty = [];
    $groupThankyou = [];
    $groupProductInfo = [];
    $groupProductDetail = [];
    foreach ($multiLanguage as $key => $value) {
        array_push($groupEmpty, [
            "iLabel"=>"{$language["orderEmpty"]} ({$key})",
            "iName"=>"{$node}.{$key}.empty",
            "iValue"=>isset($nodeMore[$key]["empty"]) ? $nodeMore[$key]["empty"] : null,
            "iTypeInput"=>"input",
            "iTextarea"=>"true",
            "gClass"=>"col-xs-12 mb-10",
            "iClass"=>"form-control mce-editor"
        ]);
        array_push($groupThankyou, [
            "iLabel"=>"{$language["orderSuccess"]} ({$key})",
            "iName"=>"{$node}.{$key}.thankyou",
            "iValue"=>isset($nodeMore[$key]["thankyou"]) ? $nodeMore[$key]["thankyou"] : null,
            "iTypeInput"=>"input",
            "iTextarea"=>"true",
            "gClass"=>"col-xs-12 mb-10",
            "iClass"=>"form-control mce-editor"
        ]);
        array_push($groupProductInfo, [
            "iLabel"=>"{$language["productInfo"]} ({$key})",
            "iName"=>"{$node}.{$key}.productinfo",
            "iValue"=>isset($nodeMore[$key]["productinfo"]) ? $nodeMore[$key]["productinfo"] : null,
            "iTypeInput"=>"input",
            "iTextarea"=>"true",
            "gClass"=>"col-xs-12 mb-10",
            "iClass"=>"form-control mce-editor"
        ]);
        array_push($groupProductDetail, [
            "iLabel"=>"{$language["productDetail"]} ({$key})",
            "iName"=>"{$node}.{$key}.productdetail",
            "iValue"=>isset($nodeMore[$key]["productdetail"]) ? $nodeMore[$key]["productdetail"] : null,
            "iTypeInput"=>"input",
            "iTextarea"=>"true",
            "gClass"=>"col-xs-12 mb-10",
            "iClass"=>"form-control mce-editor"
        ]);
    }


    $modeDesign = array(
        "eDesign" => array(
            "row"=>"form-group",
            "left"=>"col-xs-12 col-sm-12 hidden",
            "right"=>"col-xs-12 col-sm-12",
        ),
        "eInputHidden" => $inputHidden,
        "eForm" => array(
            array(

                "iLabel"=>$language["productInfo"],
                "groupClass"=>"row",
                "groupInput"=>$groupProductInfo,
            ),
            array(
                "iLabel"=>$language["productDetail"],
                "groupClass"=>"row",
                "groupInput"=>$groupProductDetail,
            ),
            array(
                "iLabel"=>$language["orderSuccess"],
                "groupClass"=>"row",
                "groupInput"=>$groupThankyou,
            ),
            array(
                "iLabel"=>$language["orderEmpty"],
                "groupClass"=>"row",
                "groupInput"=>$groupEmpty,
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
    $scriptCss = isset($nodeMore["css"]) && !empty($nodeMore["css"]) ? $nodeMore["css"] : null;
    $scriptJavascript = isset($nodeMore["javascript"]) && !empty($nodeMore["javascript"]) ? $nodeMore["javascript"] : null;

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

    $groupHeader1 = [];
    $groupHeader2 = [];

    foreach ($multiLanguage as $key => $value) {
        array_push($groupHeader1, [
            "iLabel"=>"{$language["header"]} 1 ({$key})",
            "iName"=>"{$node}.{$key}.content1",
            "iValue"=>isset($nodeMore[$key]["content1"]) ? $nodeMore[$key]["content1"] : null,
            "iTypeInput"=>"input",
            "iTextarea"=>"true",
            "gClass"=>"col-xs-12 mb-10",
            "iClass"=>"form-control mce-editor"
        ]);
        array_push($groupHeader2, [
            "iLabel"=>"{$language["header"]} 2 ({$key})",
            "iName"=>"{$node}.{$key}.content2",
            "iValue"=>isset($nodeMore[$key]["content2"]) ? $nodeMore[$key]["content2"] : null,
            "iTypeInput"=>"input",
            "iTextarea"=>"true",
            "gClass"=>"col-xs-12 mb-10",
            "iClass"=>"form-control mce-editor"
        ]);
    }

    $modeDesign = array(
        "eDesign" => array(
            "row"=>"form-group",
            "left"=>"col-xs-12 col-sm-12 hidden",
            "right"=>"col-xs-12 col-sm-12",
        ),
        "eInputHidden" => $inputHidden,
        "eForm" => array(
            array(
                "iLabel"=>"{$language["header"]} 1",
                "groupClass"=>"row",
                "groupInput"=>$groupHeader1,
            ),
            array(
                "iLabel"=>"{$language["header"]} 2",
                "groupClass"=>"row",
                "groupInput"=>$groupHeader2,
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

    $groupFooter1 = [];
    $groupFooter2 = [];

    foreach ($multiLanguage as $key => $value) {
        array_push($groupFooter1, [
            "iLabel"=>"{$language["footer"]} 1 ({$key})",
            "iName"=>"{$node}.{$key}.content1",
            "iValue"=>isset($nodeMore[$key]["content1"]) ? $nodeMore[$key]["content1"] : null,
            "iTypeInput"=>"input",
            "iTextarea"=>"true",
            "gClass"=>"col-xs-12 mb-10",
            "iClass"=>"form-control mce-editor"
        ]);
        array_push($groupFooter2, [
            "iLabel"=>"{$language["footer"]} 2 ({$key})",
            "iName"=>"{$node}.{$key}.content2",
            "iValue"=>isset($nodeMore[$key]["content2"]) ? $nodeMore[$key]["content2"] : null,
            "iTypeInput"=>"input",
            "iTextarea"=>"true",
            "gClass"=>"col-xs-12 mb-10",
            "iClass"=>"form-control mce-editor"
        ]);
    }

    $modeDesign = array(
        "eDesign" => array(
            "row"=>"form-group",
            "left"=>"col-xs-12 col-sm-12 hidden",
            "right"=>"col-xs-12 col-sm-12",
        ),
        "eInputHidden" => $inputHidden,
        "eForm" => array(
            array(
                "iLabel"=>"{$language["footer"]} 1",
                "groupClass"=>"row",
                "groupInput"=>$groupFooter1,
            ),
            array(
                "iLabel"=>"{$language["footer"]} 2",
                "groupClass"=>"row",
                "groupInput"=>$groupFooter2,
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


    $groupMenu = [];
    $groupBanner = [];



    foreach ($multiLanguage as $key => $value) {
        array_push($groupMenu, [
            "iLabel"=>"{$language["customNavMenu"]} ({$key})",
            "iName"=>"{$node}.{$key}.menu",
            "iValue"=>isset($nodeMore[$key]["menu"]) ? $nodeMore[$key]["menu"] : null,
            "iTypeInput"=>"input",
            "iTextarea"=>"true",
            "gClass"=>"col-xs-12 mb-10",
            "iClass"=>"form-control mce-editor"
        ]);
        array_push($groupBanner, [
            "iLabel"=>"{$language["customBannerHome"]} ({$key})",
            "iName"=>"{$node}.{$key}.baner",
            "iValue"=>isset($nodeMore[$key]["baner"]) ? $nodeMore[$key]["baner"] : null,
            "iTypeInput"=>"input",
            "iTextarea"=>"true",
            "gClass"=>"col-xs-12 mb-10",
            "iClass"=>"form-control mce-editor"
        ]);
    }

    $modeDesign = array(
        "eDesign" => array(
            "row"=>"form-group",
            "left"=>"col-xs-12 col-sm-12 hidden",
            "right"=>"col-xs-12 col-sm-12",
        ),
        "eInputHidden" => $inputHidden,
        "eForm" => array(
            array(
                "iLabel"=>$language["customNavMenu"],
                "groupClass"=>"row",
                "groupInput"=>$groupMenu,
            ),
            array(
                "iLabel"=>$language["customBannerHome"],
                "groupClass"=>"row",
                "groupInput"=>$groupBanner,
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

    $groupTitle = [];
    $groupDescription = [];

    foreach ($multiLanguage as $key => $value) {
        array_push($groupTitle, [
            "iName"=>"sidebar.ti.{$key}",
            "iValue"=>isset($title[$key]) && !empty($title[$key]) ? $title[$key] : null,
            "iTypeInput"=>"input",
            "iAttr"=>[
                "placeholder"=>$key,
                "data-validate"=>"",
                "data-required"=>$language["requireInput"],
            ],
            "gClass"=>"col-xs-12 mb-10",
            "iClass"=>"form-control"
        ]);
        array_push($groupDescription, [
            "iLabel"=>$key,
            "iName"=>"sidebar.de.{$key}",
            "iValue"=>isset($description[$key]) && !empty($description[$key]) ? $description[$key] : null,
            "iTypeInput"=>"input",
            "iTextarea"=>true,
            "iAttr"=>[
                "placeholder"=>$key,
            ],
            "gClass"=>"col-xs-12 mb-10",
            "iClass"=>"form-control mce-editor"
        ]);
    }


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
                "groupClass"=>"row",
                "groupInput"=>$groupTitle,
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
                "groupClass"=>"row",
                "groupInput"=>$groupDescription,
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
                "iTypeInput"=>"input",
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

    $groupTitle = [];
    $groupNote = [];

    foreach ($multiLanguage as $key => $value) {
        array_push($groupTitle, [
            "iName"=>"filterproperties.ti.{$key}",
            "iValue"=>isset($title[$key]) && !empty($title[$key]) ? $title[$key] : null,
            "iTypeInput"=>"input",
            "iAttr"=>[
                "placeholder"=>$key,
                "data-validate"=>"",
                "data-required"=>$language["requireInput"],
            ],
            "gClass"=>"col-xs-12 mb-10",
            "iClass"=>"form-control"
        ]);
        array_push($groupNote, [
            "iName"=>"filterproperties.note.{$key}",
            "iValue"=>isset($note[$key]) && !empty($note[$key]) ? $note[$key] : null,
            "iTypeInput"=>"input",
            "iAttr"=>[
                "placeholder"=>$key
            ],
            "gClass"=>"col-xs-12 mb-10",
            "iClass"=>"form-control"
        ]);
    }

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
                "groupClass"=>"row",
                "groupInput"=>$groupTitle,
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
                "groupClass"=>"row",
                "groupInput"=>$groupNote,
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
                    # "data-local-optiona"=>json_encode($dataList, true),
                    "data-local-optiona"=>"filterPropertiesStructure",
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
} elseif($node == "metatag") {
    $listButton[0]["iClassCustom"] = "col-sm-offset-0 col-xs-4 col-sm-2";
    $metatagContent1 = isset($nodeMore["content1"]) && !empty($nodeMore["content1"]) ? $nodeMore["content1"] : null;
    $metatagContentBodytop = isset($nodeMore["contentBodytop"]) && !empty($nodeMore["contentBodytop"]) ? $nodeMore["contentBodytop"] : null;
    $metatagContentBodybottom = isset($nodeMore["contentBodybottom"]) && !empty($nodeMore["contentBodybottom"]) ? $nodeMore["contentBodybottom"] : null;


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
