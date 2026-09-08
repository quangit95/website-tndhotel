<?php
$listButton = array(
    array(
        "iClassCustom"=>"col-xs-12 col-sm-offset-2 col-sm-10",
        "iAttr"=> array(
            "type"=>"submit",
            "data-button-magic"=>"",
            "data-format-json"=>"true",
            "data-params-form"=>".post-form",
            "data-ajax-url"=>"/api/post/storeinfo",
            "data-show-success"=>".alert-footer.alert",
            "data-show-errors"=>".alert-footer.alert-error",
            "class"=>"btn btn-block btn-warning btn-sendinquery btn-lg text-uppercase"
        )
    )
);

$filename = isset($_GET["file"]) && $_GET["file"] ? $_GET["file"] : null;
$node = isset($_GET["node"]) && $_GET["node"] ? $_GET["node"] : "orders";

$validationcode = isset($_GET["validationcode"]) ? $_GET["validationcode"] : null;

$listButton[0]["iLabel"] = '<span>'.$language["btnSend"].'</span>';

$modeDesign = array(
    "eDesign" => array(
        "row"=>"row form-group",
        "left"=>"col-xs-12 col-sm-2",
        "right"=>"col-xs-12 col-sm-10",
    ),
    "eInputHidden" => array(
        array(
            "type"=>"hidden",
            "name"=>"filename",
            "value"=>$filename,
            "data-validate"=>"",
            "data-required"=>"{$language["requireInput"]}"
        ),
        array(
            "type"=>"hidden",
            "name"=>"validationcode",
            "value"=>$validationcode,
        ),
        array(
            "type"=>"hidden",
            "name"=>"unique",
            "value"=>"code",
            "data-validate"=>"",
            "data-required"=>"{$language["requireInput"]}"
        ),
        array(
            "type"=>"hidden",
            "name"=>"updateNode",
            "value"=>"db",
            "data-validate"=>"",
            "data-required"=>"{$language["requireInput"]}"
        )
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
            "iLabel"=>$language["address"],
            "groupClass"=>"row",
            "groupInput"=>[
                [
                    "iName"=>"db.add",
                    "iValue"=>"",
                    "iTypeInput"=>"input",
                    "iAttr"=>[
                        "placeholder"=>$language["address"],
                        "data-validate"=>"",
                        "data-required"=>$language["requireInput"],
                    ],
                    "gClass"=>"col-xs-12 col-sm-6 mb-10",
                    "iClass"=>"form-control"
                ],
                [
                    "iName"=>"db.cit",
                    "iValue"=>"0944112199",
                    "iTypeDropdown"=>"dropdown",
                    "iAttr"=>array(
                        "data-validate"=>"",
                        "data-dropdown"=>"",
                        "data-required"=>$language["requireInput"],
                        "data-index-value"=>"",
                        "data-str-key"=>"id",
                        "data-str-value"=>"ti",
                        "data-dropdown-relative"=>"db.dis",
                        "data-params"=>"cityid=",
                        "data-option-from-json"=>APIGETCITY,
                        "data-local-optiona"=>"city",
                        "data-object-init"=>"{\"id\":\"\", \"ti\":\"{$language["city"]}\"}"
                    ),
                    "gClass"=>"col-xs-6 col-sm-3",
                    "iClass"=>"form-control"
                ],
                [
                    "iName"=>"db.dis",
                    "iValue"=>"0944112199",
                    "iTypeDropdown"=>"dropdown",
                    "iAttr"=>array(
                        "data-validate"=>"",
                        "data-dropdown"=>"",
                        "data-required"=>$language["requireInput"],
                        "data-index-value"=>"",
                        "data-str-key"=>"id",
                        "data-str-value"=>"ti",
                        "data-option-from-json"=>APIGETDISTRICT,
                        "data-local-optiona"=>"district",
                        "data-object-init"=>"{\"id\":\"\", \"ti\":\"{$language["district"]}\"}"
                    ),
                    "gClass"=>"col-xs-6 col-sm-3",
                    "iClass"=>"form-control"
                ]
            ]
        ),
        /*array(
            "iLabel"=>$language["yourEmail"],
            "iName"=>"db.em",
            "iValue"=>"",
            "iTypeInput"=>"input",
            "iAttr"=> array(
                "data-validate"=>"",
                "data-required"=>$language["requireInput"],
                "data-hidden-message"=>false,
                "data-pattern-message"=>$language["requireEmailRule"]
            ),
            "iPlaceholder"=>"",
            "iClass"=>"form-control"
        ),*/
        array(
            "iLabel"=>$language["yourNumber"],
            "iName"=>"db.ph",
            "iValue"=>"",
            "iTypeInput"=>"number",
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
            "iLabel"=>$language["cmnd"],
            "iName"=>"db.cmnd",
            "iValue"=>"",
            "iTypeInput"=>"number",
            "iAttr"=>array(
                "data-validate"=>"",
                "data-required"=>$language["requireInput"],
                "data-pattern"=>$language["requirePhonePattern"],
                "data-min-length"=>"9",
                "data-max-length"=>"20",
                "data-pattern-message"=>$language["invalidCMND"]
            ),
            "iPlaceholder"=>"",
            "iClass"=>"form-control"
        ),
        array(
            "iLabel"=>$language["codeGame"],
            "iName"=>"db.code",
            "iValue"=>"",
            "iTypeInput"=>"number",
            "iAttr"=>array(
                "data-validate"=>"",
                "data-required"=>$language["requireInput"],
                "data-min-length"=>"10",
                "data-max-length"=>"10",
            ),
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
?>
