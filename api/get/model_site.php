<?php
$listButton = array(
    array(
        "iClassCustom"=>"col-xs-12 col-sm-offset-3 col-sm-9",
        "iAttr"=> array(
            "type"=>"submit",
            "data-button-magic"=>"",
            "data-format-json"=>"true",
            "data-params-form"=>".post-form",
            "data-ajax-url"=>APIPOSTORDER,
            "data-show-success"=>".alert-footer.alert",
            "data-show-errors"=>".alert-footer.alert-error",
            "class"=>"btn btn-block btn-warning btn-sendinquery btn-lg text-uppercase"
        )
    )
);

$node = isset($_GET["node"]) && $_GET["node"] ? $_GET["node"] : "orders";

if($node == "orders") {
    $listButton[0]["iLabel"] = '<span>'.$language["btnBuy"].'</span>';

    if(isset($_GET["showThankyou"])) {
        $listButton[0]["iAttr"]["data-view-template"] = $_GET["showThankyou"];
        $listButton[0]["iAttr"]["data-template-id"] = isset($_GET["templateThankyou"]) ? $_GET["templateThankyou"] :"entryOrderStep3";
    }

    if(isset($_GET["page"]) && $_GET["page"]=="foodpickup") {
        $modeDesign = array(
            "eDesign" => array(
                "row"=>"row form-group",
                "left"=>"col-xs-12 col-sm-3",
                "right"=>"col-xs-12 col-sm-9",
            ),
            "modal"=> array(
                "title"=>"Orders online",
            ),
            "eInputHidden" => array(
            ),
            "eForm" => array(
                array(
                    "iLabel"=>$language["yourName"],
                    "iName"=>"db.fn",
                    "iValue"=>"",
                    "iTypeInput"=>"input",
                    "iAttr"=> array(
                        "data-validate"=>"",
                        "data-required"=>$language["requireInput"],
                    ),
                    "iPlaceholder"=>"",
                    "iClass"=>"form-control"
                ),
                array(
                    "iLabel"=>$language["yourEmail"],
                    "iName"=>"db.em",
                    "iValue"=>"",
                    "iTypeInput"=>"input",
                    "iAttr"=> array(
                        "data-validate"=>"",
                        "data-hidden-message"=>false,
                        "data-required"=>$language["requireInput"],
                        "data-pattern"=>$language["requireEmailPattern"],
                        "data-pattern-message"=>$language["requireEmailRule"]
                    ),
                    "iPlaceholder"=>"",
                    "iClass"=>"form-control"
                ),
                array(
                    "iLabel"=>$language["yourNumber"],
                    "iName"=>"db.ph",
                    "iValue"=>"",
                    "iTypeInput"=>"input",
                    "iAttr"=>array(
                        "data-validate"=>"",
                        "data-required"=>$language["requireInput"],
                        "data-pattern"=>$language["requirePhonePattern"],
                        "data-min-length"=>"9",
                        "data-max-length"=>"20",
                        "data-pattern-message"=>$language["requirePhoneRule"]
                    ),
                    "iPlaceholder"=>"",
                    "iClass"=>"form-control"
                ),
                array(
                    "iLabel"=>$language["address"],
                    "iName"=>"db.add",
                    "iValue"=>"",
                    "iTypeInput"=>"input",
                    "iPlaceholder"=>"",
                    "iClass"=>"form-control"
                ),
                array(
                    "iLabel"=>"{$language["noteOrder"]}",
                    "iName"=>"db.no",
                    "iValue"=>"",
                    "iTypeInput"=>"input",
                    "iTextarea"=>"true",
                    "iPlaceholder"=>"",
                    "iClass"=>"form-control"
                )
            ),
            "attrForm" => array(
                "class"=>"post-form form-horizontal"
            ),
            "button" => $listButton,
            "buttonClass"=>"row form-group"
        );
    } else {
        $modeDesign = array(
            "eDesign" => array(
                "row"=>"row form-group",
                "left"=>"col-xs-12 col-sm-3",
                "right"=>"col-xs-12 col-sm-9",
            ),
            "eInputHidden" => array(
            ),
            "eForm" => array(
                array(
                    "iLabel"=>$language["yourName"],
                    "iName"=>"db.fn",
                    "iValue"=>"",
                    "iTypeInput"=>"input",
                    "iAttr"=> array(
                        "data-validate"=>"",
                        "data-required"=>$language["requireInput"],
                    ),
                    "iPlaceholder"=>"",
                    "iClass"=>"form-control"
                ),
                array(
                    "iLabel"=>$language["yourEmail"],
                    "iName"=>"db.em",
                    "iValue"=>"",
                    "iTypeInput"=>"input",
                    "iAttr"=> array(
                        "data-validate"=>"",
                        "data-hidden-message"=>false,
                        "data-required"=>$language["requireInput"],
                        "data-pattern"=>$language["requireEmailPattern"],
                        "data-pattern-message"=>$language["requireEmailRule"]
                    ),
                    "iPlaceholder"=>"",
                    "iClass"=>"form-control"
                ),
                array(
                    "iLabel"=>$language["yourNumber"],
                    "iName"=>"db.ph",
                    "iValue"=>"",
                    "iTypeInput"=>"input",
                    "iAttr"=>array(
                        "data-validate"=>"",
                        "data-required"=>$language["requireInput"],
                        "data-pattern"=>$language["requirePhonePattern"],
                        "data-min-length"=>"9",
                        "data-max-length"=>"20",
                        "data-pattern-message"=>$language["requirePhoneRule"]
                    ),
                    "iPlaceholder"=>"",
                    "iClass"=>"form-control"
                ),
                array(
                    "iLabel"=>$language["address"],
                    "iName"=>"db.add",
                    "iValue"=>"",
                    "iTypeInput"=>"input",
                    "iPlaceholder"=>"",
                    "iClass"=>"form-control"
                ),
                array(
                    "iLabel"=>$language["city"],
                    "iName"=>"db.cit",
                    "iValue"=>"",
                    "iTypeDropdown"=>"dropdown",
                    "iAttr"=>array(
                        "data-validate"=>"",
                        "data-dropdown"=>"",
                        "data-required"=>$language["requireInput"],
                        "data-index-value"=>isset($informationWebsite["db"]["city"]) ? $informationWebsite["db"]["city"] : null,
                        "data-str-key"=>"id",
                        "data-str-value"=>"ti",
                        "data-key-sort"=>"ti",
                        "data-dropdown-relative"=>"db.dis",
                        "data-params"=>"cid=",
                        "data-option-from-json"=>APIGETCITY,
                        "data-local-optiona"=>"city",
                        "data-object-init"=>"{\"id\":\"\", \"ti\":\"{$language["city"]}\"}"
                    ),
                    "iClass"=>"form-control"
                ),
                array(
                    "iLabel"=>$language["district"],
                    "iName"=>"db.dis",
                    "iValue"=>"",
                    "iTypeDropdown"=>"dropdown",
                    "iAttr"=>array(
                        "data-validate"=>"",
                        "data-dropdown"=>"",
                        "data-required"=>$language["requireInput"],
                        "data-index-value"=>"",
                        "data-params"=>"cid=".(isset($informationWebsite["db"]["city"]) ? $informationWebsite["db"]["city"] : null),
                        "data-str-key"=>"id",
                        "data-str-value"=>"ti",
                        "data-key-sort"=>"ti",
                        "data-option-from-json"=>APIGETDISTRICT,
                        "data-local-optiona"=>"district",
                        "data-object-init"=>"{\"id\":\"\", \"ti\":\"{$language["district"]}\"}"
                    ),
                    "iClass"=>"form-control"
                ),
                array(
                    "iLabel"=>$language["noteOrder"],
                    "iName"=>"db.no",
                    "iValue"=>"",
                    "iTypeInput"=>"input",
                    "iTextarea"=>"true",
                    "iPlaceholder"=>"",
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
} elseif($node == "signin") {

    $listButton[0]["iLabel"] = '<span>'.$language["signin"].'</span>';
    $listButton[0]["iClassCustom"] = "col-xs-6 col-sm-6 text-right";
    $listButton[0]["iAttr"]["class"] = 'btn btn-block btn-primary text-uppercase';
    $listButton[0]["iAttr"]["data-ajax-url"] = APIPOSTADMINSIGNIN;
    $listButton[0]["iAttr"]["data-redirect"] = ".";

    /*$strButtonPlus = array(
        array(
            "iClassCustom"=>"col-xs-6 col-sm-6",
            "iLabel"=> '<span>'.$language["forgotPassword"].'</span>',
            "iAttr"=> array(
                "type"=>"submit",
                "class"=>"btn btn-block btn-default text-uppercase"
            )
        )
    );

    array_splice($listButton, 1, 0, $strButtonPlus);*/

    $modeDesign = array(
        "eDesign" => array(
            "row"=>"row form-group",
            "left"=>"col-xs-12 col-sm-12 control-label",
            "right"=>"col-xs-12 col-sm-12",
        ),
        "eForm" => array(
            array(
                "iLabel"=>"",
                "iName"=>"username",
                "iValue"=>"",
                "iTypeInput"=>"text",
                "iAttr"=> array(
                    "data-validate"=>"",
                    "data-required"=>$language["requireInput"],
                    "data-pattern"=>$language["requireUsernamePattern"],
                    "data-pattern-message"=>$language["requireUsernameRule"],
                    "data-min-length"=>6,
                    "data-max-length"=>20,
                    "placeholder"=>$language["username"]
                ),
                "iPlaceholder"=>"",
                "iClass"=>"form-control"
            ),
            array(
                "iLabel"=>"",
                "iName"=>"password",
                "iValue"=>"",
                "iTypeInput"=>"password",
                "iAttr"=> array(
                    "data-validate"=>"",
                    "data-required"=>"required",
                    "placeholder"=>$language["password"]
                ),
                "iClass"=>"form-control"
            )
        ),
        "attrForm" => array(
            "class"=>"post-form form-horizontal block"
        ),
        "button" => $listButton,
        "buttonClass"=>"row form-group"
    );
} elseif($node == "contact") {
    $listButton[0]["iLabel"] = '<span>'.$language["btnSend"].'</span>';
    $listButton[0]["iClassCustom"] = "col-xs-6 col-sm-4  text-right transparent-input-b";
    $listButton[0]["iAttr"]["class"] = 'btn btn-block btn-primary text-uppercase';
    $listButton[0]["iAttr"]["data-ajax-url"] = APIPOSTCONTACTUS;


    $strColLeft = "col-xs-12 col-sm-12  init-none";
    $strColRight = "col-xs-12 col-sm-12";
    if(isset($_GET["col"])) {
        if($_GET["col"]==1) {
            $strColLeft = "col-xs-12 col-sm-3 init-none";
            $strColRight = "col-xs-12 col-sm-9";
        } elseif($_GET["col"]==2) {
            $strColLeft = "hidden";
            $strColRight = "col-xs-12 col-sm-12";
        }
    }

    $strButtonPlus = array(
        array(
            "iClassCustom"=>"col-xs-6 col-sm-4",
            "iLabel"=> '<span>'.$language["btnCancel"].'</span>',
            "iAttr"=> array(
                "type"=>"submit",
                "class"=>"btn btn-block btn-default text-uppercase"
            )
        )
    );

    array_splice($listButton, 1, 0, $strButtonPlus);

    $modeDesign = array(
        "eDesign" => array(
            "row"=>"row form-group",
            "left"=>$strColLeft,
            "right"=>$strColRight,
        ),
        "eInputHidden" => array(
            array(
                "type"=>"hidden",
                "name"=>"updateNode",
                "value"=>"db",
                "iAttr"=> array(
                    "data-validate"=>"",
                    "data-required"=>$language["requireInput"],
                )
            ),
            array(
                "type"=>"hidden",
                "name"=>"db.st",
                "value"=>"1"
            )
        ),
        "eForm" => array(
            array(
                "iLabel"=>$language["title"],
                "iName"=>"db.su",
                "iValue"=>isset($_GET["su"]) ? $_GET["su"] : null,
                "iTypeInput"=>"input",
                "iAttr"=> array(
                    "data-validate"=>"",
                    "data-required"=>$language["requireInput"],
                    "placeholder"=>$language["title"]
                ),
                "iPlaceholder"=>"",
                "iClass"=>"form-control"
            ),
            array(
                "iLabel"=>$language["yourName"],
                "iName"=>"db.fn",
                "iValue"=>"",
                "iTypeInput"=>"input",
                "iAttr"=> array(
                    "data-validate"=>"",
                    "data-required"=>$language["requireInput"],
                    "placeholder"=>$language["yourName"]
                ),
                "iPlaceholder"=>"",
                "iClass"=>"form-control"
            ),
            array(
                "iLabel"=>$language["phone"],
                "iName"=>"db.ph",
                "iValue"=>"",
                "iTypeInput"=>"input",
                "iAttr"=>array(
                    "data-validate"=>"",
                    "data-required"=>$language["requireInput"],
                    "data-pattern"=>$language["requirePhonePattern"],
                    "data-min-length"=>"9",
                    "data-max-length"=>"20",
                    "placeholder"=>$language["phone"],
                    "data-pattern-message"=>$language["requirePhoneRule"]
                ),
                "iPlaceholder"=>"",
                "iClass"=>"form-control"
            ),
            array(
                "iLabel"=>$language["content"],
                "iName"=>"db.me",
                "iValue"=>isset($_GET["me"]) ? $_GET["me"] : null,
                "iTypeInput"=>"input",
                "iTextarea"=>"true",
                "iAttr"=>array(
                    "placeholder"=>$language["content"],
                ),
                "iClass"=>"form-control"
            )
        ),
        "attrForm" => array(
            "class"=>"post-form form-horizontal"
        ),
        "buttonClass"=>"row form-group"
    );

    if(isset($_GET["sendfile"]) && $_GET["sendfile"] ) {
        $modeDesign["infoLeft"] = '<img src="'.$_GET["sendfile"].'" class="modal-file-info">';
    }
    if(isset($_GET["mid"]) ) {
        $modeDesign["eForm"][0] = array(
            "iLabel"=>$language["product"],
            "iName"=>"db.su",
            "iTypeDropdown"=>"dropdown",
            "iAttr"=>array(
                "data-validate"=>"",
                "data-dropdown"=>"",
                "data-required"=>$language["requireInput"],
                "data-index-value"=>$_GET["mid"],
                "data-str-key"=>"ti",
                "data-str-value"=>"ti",
                "data-params"=>"opp=5",
                "data-local-optiona"=>"menuStructure",
                "data-object-init"=>"{\"id\":\"\", \"ti\":\"{$language["product"]}\"}"
            ),
            "iClass"=>"form-control"
        );
    }

    if(isset($_GET["pid"]) ) {
        $modeDesign["eForm"][0] = array(
                "groupClass"=> "row",
                "groupInput"=> array(
                    array(
                        "iLabel"=>$language["product"],
                        "iName"=>"db.su",
                        "iValue"=>"",
                        "iTypeDropdown"=>"dropdown",
                        "iAttr"=>array(
                            "data-validate"=>"",
                            "data-dropdown"=>"",
                            "data-required"=>$language["requireInput"],
                            "data-index-value"=>"",
                            "data-str-key"=>"id",
                            "data-str-value"=>"ti",
                            "data-option-from-json"=>"/api/get/product",
                            "data-local-optiona"=>"localProductList",
                            "data-object-init"=>"{\"id\":\"\", \"ti\":\"{$language["product"]}\"}"
                        ),
                        "gClass"=> "col-xs-6 mb-10",
                        "iClass"=>"form-control"
                    ),
                    array(
                        "iLabel"=>$language["date"],
                        "iName"=>"db.tbook.date",
                        "iValue"=>"",
                        "iTypeInput"=>"input",
                        "iAttr"=>array(
                            "data-validate"=>"",
                            "data-required"=>$language["requireInput"],
                            "data-date-picker"=>"",
                            "data-format"=>"DD-MM-YYYY",
                            "data-single-date-picker"=>"true",
                            "data-show-week-numbers"=>"false",
                            "data-invalid-dates"=>"1,2",
                            "data-opens"=>"right",
                            "placeholder"=>$language["date"]
                        ),
                        "gClass"=> "col-xs-3 mb-10",
                        "iClass"=>"form-control"
                    ),
                    array(
                        "iLabel"=>$language["hour"],
                        "iName"=>"db.tbook.hour",
                        "iValue"=>"",
                        "iTypeDropdown"=>"dropdown",
                        "iAttr"=>array(
                            "data-dropdown"=>"",
                            "data-required"=>"require",
                            "data-index-value"=>"",
                            "data-local-optiona"=>"timeH",
                            "data-object-init"=>"{\"id\":\"\", \"ti\":\"{$language["hour"]}\"}"
                        ),
                        "gClass"=> "col-xs-3 mb-10",
                        "iClass"=>"form-control"
                    ),
                )
            );
    }

    if(isset($_GET["file"]) && $_GET["file"] ) {
        $arrayPlus = array(
            array(
                "iLabel"=>"Tải hình ảnh của bạn tại đây để nhận được những tư vấn chuẩn xác hơn.",
                "iName"=>"file",
                "iValue"=>"",
                "iTypeInput"=>"file",
                "iAttr"=> array(
                    "id"=>"file-image-contact"
                ),
                "iPlaceholder"=>"",
                "iClassCustom"=>"file-image-contact",
                "iClass"=>"form-control"
            )
        );
        array_splice($modeDesign["eForm"], 0, 0, $arrayPlus);
        $modeDesign["attrForm"]["enctype"] = "multipart/form-data";
        $modeDesign["attrForm"]["method"] = "post";
        $listButton[0]["iAttr"]["data-form-data"] = ".post-form";
        unset($listButton[0]["iAttr"]["data-format-json"]);
    }
    if(isset($_GET["modalTitle"]) && $_GET["modalTitle"] ) {
        $modeDesign["modal"] = array(
            "title"=>"{$_GET["modalTitle"]}",
        );
        $listButton[1]["iAttr"]["data-closet-toggle-class"] = "in";
        $listButton[1]["iAttr"]["data-object"] = ".modal";
        $listButton[1]["iAttr"]["data-empty-object"] = "[data-quick-view-item]";
        $listButton[0]["iAttr"]["data-empty-object"] = "[data-quick-view-item]";
    }

    $modeDesign["button"] = $listButton;

} elseif($node == "support") {
    $listButton[0]["iLabel"] = '<span>'.$language["btnSend"].'</span>';
    $listButton[0]["iClassCustom"] = "col-xs-4 col-xs-offset-8 transparent-input-b";
    $listButton[0]["iAttr"]["class"] = 'btn btn-block btn-primary text-uppercase';
    $listButton[0]["iAttr"]["data-ajax-url"] = APIPOSTCONTACTUS;
    $modeDesign = array(
        "eDesign" => array(
            "row"=>"row form-group",
            "left"=>"col-xs-12 col-sm-12",
            "right"=>"col-xs-12 col-sm-12",
        ),
        "eInputHidden" => array(
            array(
                "type"=>"hidden",
                "name"=>"updateNode",
                "value"=>"support",
                "iAttr"=>array(
                    "data-dropdown"=>"",
                    "data-required"=>$language["requireInput"],
                )
            )
        ),
        "eInfo" => "<i>Chào bạn! Để được giải đáp thắc mắc <br/>hãy điền thông tin vào form bên dưới</i>",
        "eForm" => array(
            array(
                "iLabel"=>"",
                "iName"=>"db.em",
                "iValue"=>"",
                "iTypeInput"=>"input",
                "iAttr"=> array(
                    "data-validate"=>"",
                    "data-hidden-message"=>"true",
                    "data-required"=>$language["requireInput"],
                    "placeholder"=>$language["email"],
                    "data-pattern"=>$language["requireEmailPattern"],
                    "data-pattern-message"=>$language["requireEmailRule"]
                ),
                "iPlaceholder"=>"",
                "iClass"=>"form-control"
            ),
            array(
                "iLabel"=>"",
                "iName"=>"support.me",
                "iValue"=>"",
                "iTypeInput"=>"input",
                "iTextarea"=>"true",
                "iAttr"=>array(
                    "data-validate"=>"",
                    "data-required"=>$language["requireInput"],
                    "placeholder"=>"Xin vui lòng điền thông tin tại đây"
                ),
                "iPlaceholder"=>"Xin vui lòng điền thông tin tại đây",
                "iClass"=>"form-control"
            )
        ),
        "attrForm" => array(
            "class"=>"post-form form-horizontal"
        ),
        "buttonClass"=>"row form-group"
    );

    $modeDesign["button"] = $listButton;
} elseif($node == "newsletter") {
    $listButton[0]["iLabel"] = '<span>'.$language["signup"].'</span>';
    $listButton[0]["iClassCustom"] = "col-xs-4 col-xs-offset-8 transparent-input-b";
    $listButton[0]["iAttr"]["class"] = 'btn btn-block btn-primary text-uppercase btn-newsletter';
    $listButton[0]["iAttr"]["data-ajax-url"] = "/api/post/newplugin";

    if(isset($_GET["strsms"]) && $_GET["strsms"] ) {
        $listButton[0]["iAttr"]["data-ajax-url"] = $listButton[0]["iAttr"]["data-ajax-url"]."?strsms={$_GET["strsms"]}";
    }
    $modeDesign = array(
        "eDesign" => array(
            "row"=>"row form-group",
            "left"=>"col-xs-12 col-sm-12",
            "right"=>"col-xs-12 col-sm-12",
        ),
        "eInputHidden" => array(
            array(
                "type"=>"hidden",
                "name"=>"updateNode",
                "value"=>"db",
                "data-validate"=>"",
                "data-required"=>$language["requireInput"],
            ),
            array(
                "type"=>"hidden",
                "name"=>"model",
                "value"=>"newsletter"
            ),
        ),
        "eForm" => array(
            array(
                "iLabel"=>"",
                "iName"=>"db.em",
                "iValue"=>"",
                "iTypeInput"=>"input",
                "iAttr"=> array(
                    "data-validate"=>"",
                    "data-hidden-message"=>"true",
                    "data-required"=>$language["requireInput"],
                    "placeholder"=>$language["newsletterReceive"],
                    "data-pattern"=>$language["requireEmailPattern"],
                    "data-pattern-message"=>$language["requireEmailRule"]
                ),
                "iPlaceholder"=>"",
                "iClass"=>"form-control"
            )
        ),
        "attrForm" => array(
            "class"=>"post-form form-horizontal"
        ),
        "buttonClass"=>"row form-group"
    );

    if(isset($_GET["inputTime"]) && $_GET["inputTime"]) {
        array_splice($modeDesign["eInputHidden"], 0, 0, array(array("type"=>"hidden","name"=>"db.cr", "value"=>time())) );
    }

    $modeDesign["button"] = $listButton;
} elseif($node == "search") {
    $strPlaceholder = $language["product"];
    $strAction = "/q";
    if(isset($_GET["placeholder"]) && $_GET["placeholder"]) {
        $strPlaceholder = $_GET["placeholder"];
    }
    if(isset($_GET["model"]) && $_GET["model"]) {
        $tmpInputHidden = array(
            array(
                "type"=>"hidden",
                "name"=>"getmodel",
                "value"=>$_GET["model"],
            )
        );
    }
    $listButton = array(
        array(
            "iClassCustom"=>"col-xs-12 col-sm-6 btn-search",
            "iLabel" => '<span>'.$language["btnSend"].'</span>',
            "iAttr"=> array(
                "type"=>"submit",
                "class"=>"btn btn-block btn-sendinquery text-uppercase"
            )
        )
    );

    $modeDesign = array(
        "eDesign" => array(
            "row"=>"row form-group",
            "left"=>"col-xs-12 col-sm-12",
            "right"=>"col-xs-12 col-sm-12",
        ),
        "eInputHidden" => isset($tmpInputHidden) ? $tmpInputHidden : array(),
        "eForm" => array(
            array(
                "iLabel"=>"",
                "iName"=>"title",
                "iValue"=>"",
                "iTypeInput"=>"input",
                "iAttr"=>array(
                    "data-validate"=>"",
                    "data-required"=>$language["requireInput"],
                    "placeholder"=>$strPlaceholder
                ),
                "iClass"=>"form-control"
            )
        ),
        "attrForm" => array(
            "class"=>"post-form form-horizontal",
            "method"=>"get",
            "action"=>$strAction,
        ),
        "buttonClass"=>"row form-group",
    );
    $modeDesign["button"] = $listButton;

} elseif($node == "checkbox") {

    $listCategory = $language["dropdownLocalOption"]["menuList"];

    if(isset($_GET["pid"]) && $_GET["pid"]) {
        $listCategory = arrSearch($menuTable, "pa=={$_GET["pid"]}");
    }

    $listButton[0]["iLabel"] = '<span>'.$language["btnSend"].'</span>';
    $listButton[0]["iClassCustom"] = "col-xs-4 col-xs-offset-8 transparent-input-b";
    $listButton[0]["iAttr"]["class"] = 'btn btn-block btn-primary text-uppercase';
    $listButton[0]["iAttr"]["data-ajax-url"] = APIPOSTCONTACTUS;
    $modeDesign = array(
        "eDesign" => array(
            "row"=>"row form-group",
            "left"=>"col-xs-12 col-sm-12",
            "right"=>"col-xs-12 col-sm-12",
        ),
        "eForm" => array(
            array(
                "iClassCustom"=>"checkbox-inlines",
                "iLabel"=>"",
                "iName"=>"cat.id",
                "iTypeCheckbox"=>"checkbox",
                "iDesign"=>'<div class="item-ticket checkbox-inline"><label class="checkbox"><input type="checkbox" name="category[]" data-key="cat" data-key-name="cat-{0}" data-compare="checkin" value="{0}" {2}><span class="fa checkbox-style"></span> <span>{1}</span></label> </div>',
                "iKey"=>"id",
                "iValue"=>"ti",
                "iList"=>$listCategory,
                "iOptioned"=>"",
                "iKeyBox"=>"catid"
            )
        ),
        "attrForm" => array(
            "class"=>"post-form form-horizontal"
        ),
        "buttonClass"=>"row form-group"
    );

    // $modeDesign["button"] = $listButton;
} elseif($node == "radio") {

    $listCategory = $language["dropdownLocalOption"]["menuList"];
    if(isset($_GET["pid"]) && $_GET["pid"]) {
        $listCategory = arrSearch($menuTable, "pa=={$_GET["pid"]}");
    }

    if(isset($_GET["hasall"])) {
        $strAllPlus = array(
            array(
                "id"=>"",
                "ti"=> $language["viewAll"],
            )
        );
        array_splice($listCategory, 0, 0, $strAllPlus);
    }


    $listButton[0]["iLabel"] = '<span>'.$language["btnSend"].'</span>';
    $listButton[0]["iClassCustom"] = "col-xs-4 col-xs-offset-8 transparent-input-b";
    $listButton[0]["iAttr"]["class"] = 'btn btn-block btn-primary text-uppercase';
    $listButton[0]["iAttr"]["data-ajax-url"] = APIPOSTCONTACTUS;
    $modeDesign = array(
        "eDesign" => array(
            "row"=>"row form-group",
            "left"=>"col-xs-12 col-sm-12",
            "right"=>"col-xs-12 col-sm-12",
        ),
        "eForm" => array(
            array(
                "iClassCustom"=>"",
                "iLabel"=>"",
                "iName"=>"cat.id",
                "iTypeRadiobox"=>"radio",
                "iDesign"=>'<div class="radio-inline"><label class="radio"><input type="radio" name="category" data-key="cat" data-key-name="cat" data-compare="in" value="{0}" {2}><span class="fa radio-style"></span><span>{1}</span></label> </div>',
                "iKey"=>"id",
                "iValue"=>"ti",
                "iList"=>$listCategory,
                "iOptioned"=>"",
                "iKeyBox"=>"catid"
            )
        ),
        "attrForm" => array(
            "class"=>"post-form form-horizontal"
        ),
        "buttonClass"=>"row form-group"
    );
    // $modeDesign["button"] = $listButton;
} elseif($node == "radioPage") {

    $listCategory = $language["dropdownLocalOption"]["menuList"];

    if(isset($_GET["opp"]) && $_GET["opp"]) {
        $listCategory = arrSearch($menuTable, "opp=={$_GET["opp"]}");
    }

    if(isset($_GET["hasall"])) {
        $strAllPlus = array(
            array(
                "id"=>"",
                "ti"=> $language["viewAll"],
            )
        );
        array_splice($listCategory, 0, 0, $strAllPlus);
    }

    $listButton[0]["iLabel"] = '<span>'.$language["btnSend"].'</span>';
    $listButton[0]["iClassCustom"] = "col-xs-4 col-xs-offset-8 transparent-input-b";
    $listButton[0]["iAttr"]["class"] = 'btn btn-block btn-primary text-uppercase';
    $listButton[0]["iAttr"]["data-ajax-url"] = APIPOSTCONTACTUS;
    $modeDesign = array(
        "eDesign" => array(
            "row"=>"row form-group",
            "left"=>"col-xs-12 col-sm-12",
            "right"=>"col-xs-12 col-sm-12",
        ),
        "eForm" => array(
            array(
                "iClassCustom"=>"",
                "iLabel"=>"",
                "iName"=>"cat.id",
                "iTypeRadiobox"=>"radio",
                "iDesign"=>'<div class="radio-inline"><label class="radio"><input type="radio" name="category" data-key="cat" data-key-name="cat" data-compare="in" value="{0}" {2}><span class="fa radio-style"></span><span>{1}</span></label> </div>',
                "iKey"=>"id",
                "iValue"=>"ti",
                "iList"=>$listCategory,
                "iOptioned"=>"",
                "iKeyBox"=>"catid"
            )
        ),
        "attrForm" => array(
            "class"=>"post-form form-horizontal"
        ),
        "buttonClass"=>"row form-group"
    );

    // $modeDesign["button"] = $listButton;
}
?>
