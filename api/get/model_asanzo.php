<?php
$node = isset($_GET["node"]) && $_GET["node"] ? $_GET["node"] : null;
if($isAdminPage) {
    if($node == "ewarrantySignup") {
        $formEwarranty = array(
            array(
                "iLabel"=>$language["serialNumber"],
                "iName"=>"serial",
                "iValue"=>"",
                "iTypeInput"=>"input",
                "iAttr"=> array(
                    "placeholder"=>$language["serialNumber"],
                    "data-validate"=>"",
                    "data-required"=>$language["requireInput"],
                ),
                "iPlaceholder"=>"",
                "iClass"=>"form-control"
            ),
            array(
                "iLabel"=>$language["yourName"],
                "iName"=>"name",
                "iValue"=>"",
                "iTypeInput"=>"input",
                "iAttr"=> array(
                    "placeholder"=>$language["yourName"],
                    "data-validate"=>"",
                    "data-required"=>$language["requireInput"],
                ),
                "iPlaceholder"=>"",
                "iClass"=>"form-control"
            ),
            /*array(
                "iLabel"=>$language["yourEmail"],
                "iName"=>"db.em",
                "iValue"=>"",
                "iTypeInput"=>"input",
                "iAttr"=> array(
                    "placeholder"=>$language["yourEmail"],
                    "data-validate"=>"",
                    "data-hidden-message"=>false,
                    "data-required"=>$language["requireInput"],
                    "data-pattern"=>$language["requireEmailPattern"],
                    "data-pattern-message"=>$language["requireEmailRule"]
                ),
                "iPlaceholder"=>"",
                "iClass"=>"form-control"
            ),*/
            array(
                "iLabel"=>$language["yourNumber"],
                "iName"=>"phone",
                "iValue"=>"",
                "iTypeInput"=>"input",
                "iAttr"=>array(
                    "placeholder"=>$language["yourNumber"],
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
                "iName"=>"address",
                "iValue"=>"",
                "iTypeInput"=>"input",
                "iAttr"=>array(
                    "placeholder"=>$language["address"]
                ),
                "iClass"=>"form-control"
            )
        );
        $modeDesign = array(
            "eDesign" => array(
                "row"=>"row form-group",
                "left"=>"col-xs-12 col-sm-12 hidden",
                "right"=>"col-xs-12 col-sm-12"
            ),
            "eForm" => $formEwarranty,
            "attrForm" => array(
                "class"=>"post-form form-horizontal"
            ),
            "button" => array(
                array(
                    "iLabel"=>'<span>'.$language["signup"].'</span>',
                    "iClassCustom"=>"col-xs-6 col-sm-3",
                    "iAttr"=>array(
                        "data-button-magic"=>"",
                        "data-method"=>"POST",
                        "data-params-form"=>".post-form",
                        "data-format-json"=>"false",
                        "data-headers"=>"sessionName",
                        "data-params-localstorage"=>"sessionName",
                        "data-ajax-url"=>"//asanzo.ptsystem.vn/webservice.php?operation=CreateContactSerial",
                        "data-view-template"=>".form-signin",
                        "data-template-id"=>"entryFormElement",
                        "data-show-success"=>".alert-footer.alert",
                        "data-show-errors"=>".alert-footer.alert-error",
                        "class"=>"btn btn-block btn-warning text-uppercase"
                    )
                ),
            ),
            "buttonClass"=>"form-group"
        );
    } elseif($node == "ewarranty") {
        $formEwarranty = array(
            array(
                "iLabel"=>$language["serialNumber"],
                "iName"=>"db.serial",
                "iValue"=>"",
                "iTypeInput"=>"input",
                "iAttr"=> array(
                    "placeholder"=>$language["serialNumber"],
                    "data-validate"=>"",
                    "data-required"=>$language["requireInput"],
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
                    "placeholder"=>$language["yourNumber"],
                    "data-validate"=>"",
                    "data-required"=>$language["requireInput"],
                    "data-pattern"=>$language["requirePhonePattern"],
                    "data-min-length"=>"9",
                    "data-max-length"=>"20",
                    "data-pattern-message"=>$language["requirePhoneRule"]
                ),
                "iPlaceholder"=>"",
                "iClass"=>"form-control"
            )
        );
        $modeDesign = array(
            "eDesign" => array(
                "row"=>"row form-group",
                "left"=>"col-xs-12 col-sm-12 hidden",
                "right"=>"col-xs-12 col-sm-12"
            ),
            "eForm" => $formEwarranty,
            "attrForm" => array(
                "class"=>"post-form form-horizontal"
            ),
            "button" => array(
                array(
                    "iLabel"=>'<span>'.$language["btnSearch"].'</span>',
                    "iClassCustom"=>"col-xs-6 col-sm-3",
                    "iAttr"=>array(
                        "data-button-magic"=>"",
                        "data-method"=>"POST",
                        "data-params-form"=>".post-form",
                        "data-format-json"=>"true",
                        "data-ajax-url"=>APIPOSTVERIFYACCOUNT,
                        "data-view-template"=>".form-signin",
                        "data-template-id"=>"entryFormElement",
                        "data-show-success"=>".alert-footer.alert",
                        "data-show-errors"=>".alert-footer.alert-error",
                        "class"=>"btn btn-block btn-warning text-uppercase"
                    )
                ),
            ),
            "buttonClass"=>"form-group"
        );
    } elseif($node == "ewarrantyLookup") {
        $formEwarranty = array(
            array(
                "iLabel"=>$language["serialNumber"],
                "iName"=>"db.serial",
                "iValue"=>"",
                "iTypeInput"=>"input",
                "iAttr"=> array(
                    "placeholder"=>$language["serialNumber"],
                    "data-validate"=>"",
                    "data-required"=>$language["requireInput"],
                ),
                "iPlaceholder"=>"",
                "iClass"=>"form-control"
            )
        );
        $modeDesign = array(
            "eDesign" => array(
                "row"=>"row form-group",
                "left"=>"col-xs-12 col-sm-12 hidden",
                "right"=>"col-xs-12 col-sm-12"
            ),
            "eForm" => $formEwarranty,
            "attrForm" => array(
                "class"=>"post-form form-horizontal"
            ),
            "button" => array(
                array(
                    "iLabel"=>'<span>'.$language["btnSearch"].'</span>',
                    "iClassCustom"=>"col-xs-6 col-sm-3",
                    "iAttr"=>array(
                        "data-button-magic"=>"",
                        "data-method"=>"POST",
                        "data-params-form"=>".post-form",
                        "data-format-json"=>"true",
                        "data-ajax-url"=>APIPOSTVERIFYACCOUNT,
                        "data-view-template"=>".form-signin",
                        "data-template-id"=>"entryFormElement",
                        "data-show-success"=>".alert-footer.alert",
                        "data-show-errors"=>".alert-footer.alert-error",
                        "class"=>"btn btn-block btn-warning text-uppercase"
                    )
                ),
            ),
            "buttonClass"=>"form-group"
        );
    } elseif($node == "signin") {
        $formSignin =  array(
            array(
                "iLabel"=>$language["username"],
                "iName"=>"username",
                "iValue"=>"",
                "iTypeInput"=>"text",
                "iAttr"=> array(
                    "placeholder"=>$language["username"],
                    "data-validate"=>"",
                    "data-required"=>$language["requireInput"]
                ),
                "iClass"=>"form-control"
            ),
            array(
                "iLabel"=>$language["password"],
                "iName"=>"password",
                "iValue"=>"",
                "iTypeInput"=>"password",
                "iAttr"=> array(
                    "placeholder"=>$language["password"],
                    "data-validate"=>"",
                    "data-required"=>$language["requireInput"],
                    "data-min-length"=>6,
                    "data-pattern-message"=>formatStrArguments($language["requireRuleMinLength"],6),
                ),
                "iClass"=>"form-control"
            )
        );
        if($iswebsite) {
            $modeDesign = array(
                "modal" => array(
                    "title"=>$language["signInHeader"],
                    "class"=>"modal-dialog modal-signup"
                ),
                "eDesign" => array(
                    "row"=>"row form-group",
                    "left"=>"col-xs-12 hidden",
                    "right"=>"col-xs-12",
                ),
                "eForm" => $formSignin,
                "attrForm" => array(
                    "class"=>"post-form form-horizontal"
                ),
                "button" => array(
                    array(
                        "iLabel"=>'<span>'.$language["signin"].'</span>',
                        "iClassCustom"=>"col-xs-12",
                        "iAttr"=>array(
                            "data-button-magic"=>"",
                            "data-method"=>"GET",
                            "data-params-form"=>".post-form",
                            "data-format-json"=>"false",
                            "data-ajax-url"=>"//asanzo.ptsystem.vn/webservice.php?operation=login",
                            "data-redirect"=>".",
                            "data-show-success"=>".alert-footer.alert",
                            "data-show-errors"=>".alert-footer.alert-error",
                            "class"=>"btn btn-block btn-warning text-uppercase"
                        )
                    ),
                ),
                "buttonClass"=>"row form-group"
            );
            if(isset($_GET["mobile"]) && $_GET["mobile"]==1) {
                $modeDesign["button"][0]["iAttr"]["data-view-template-from-element"]=".container-main-view";
                $modeDesign["button"][0]["iAttr"]["data-template-id"]="appViewOptionForm";
                $modeDesign["button"][0]["iAttr"]["data-storage"] = "sessionName";
                $modeDesign["button"][0]["iAttr"]["data-ajax-url"] = "//asanzo.ptsystem.vn/webservice.php?operation=login";
                unset($modeDesign["button"][0]["iAttr"]["data-redirect"]);
            }
        } else {

        }
        if(isset($_GET["nomodal"])&& $_GET["nomodal"]) {
            unset($modeDesign["modal"]);
        }
    }
} else {
    $code = 401;
    $errors = $language["doNotAccessPage"];
}
?>
