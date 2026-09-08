<?php
$modeDesign = array(
    "modal" => array(
        "title"=>"Title",
    ),
    "eInfo" => "Vui lòng chọn sản phẩm trước.",
    "eDesign" => array(
        "row"=>"row form-group",
        "left"=>"col-xs-12 col-sm-2 control-label",
        "right"=>"col-xs-12 col-sm-10",
    ),
    "eForm" => array(
        array(
            "iLabel"=>"Fullname",
            "iName"=>"db.title",
            "iValue"=>"",
            "iTypeInput"=>"input",
            "iAttr"=> array(
                "data-validate"=>"",
                "data-required"=>"required",
                "data-hidden-message"=>false,
                "data-pattern-message"=>"requireEmailRule"
            ),
            "iPlaceholder"=>"",
            "iClass"=>"form-control mce-editors"
        ),
        array(
            "iLabel"=>"Email",
            "iName"=>"db.email",
            "iValue"=>"",
            "iTypeInput"=>"email",
            "iAttr"=> array(
                "data-validate"=>"",
                "data-required"=>"required",
                "data-key"=>"value",
                "data-params"=>"{\"updateNode\":\"checkemail\"}",
                "data-server"=>"/api/post/user",
                "data-format-json"=>"true",
                "data-pattern"=>"^[\w._%+-]{2,}@[\w.-]{1,}\.[\w]{2,}$",
                "data-pattern-message"=>"requireEmailRule"
            ),
            "iPlaceholder"=>"",
            "iClass"=>"form-control"
        ),
        array(
            "iLabel"=>"Textarea",
            "iName"=>"db.textarea",
            "iValue"=>"",
            "iTypeInput"=>"input",
            "iTextarea"=>"true",
            "iPlaceholder"=>"",
            "iClass"=>"form-control mce-editors"
        ),
        array(
            "iLabel"=>"Text Editor",
            "iName"=>"db.title",
            "iValue"=>"",
            "iTypeInput"=>"input",
            "iTextarea"=>"true",
            "iClass"=>"form-control mce-editor"
        ),
        array(
            "iLabel"=>"Datetime Plus Disable",
            "iName"=>"db.datetime",
            "iValue"=>"Title",
            "iTypeInput"=>"input",
            "iCalendar"=>"true",
            "iClassCustom"=>"relative",
            "iAttr"=>array(
                "onkeydown"=>"return false",
                "data-date-picker"=>"",
                "data-single-date-picker"=>"true",
                "data-end-date-plus"=>"14,days",
                "data-invalid-date"=>"1,2",
                "data-format"=>"YYYY-MM-DD",
                "data-auto-apply"=>"true",
                "data-show-dropdowns"=>"true",
                "data-drops"=>"down",
                "data-opens"=>"right"
            ),
            "iPlaceholder"=>"",
            "iClass"=>"form-control mce-editors"
        ),
        array(
            "iLabel"=>"Datetime Min Max",
            "iName"=>"db.dateminmax",
            "iTypeInput"=>"input",
            "iCalendar"=>"true",
            "iClassCustom"=>"relative",
            "iAttr"=> array(
                "onkeydown"=>"return false",
                "data-date-picker"=>"",
                "data-input-empty"=>"true",
                "data-single-date-picker"=>"true",
                "data-min-date"=>"1950-01-01",
                "data-max-date"=>"2010-01-01",
                "data-format"=>"YYYY-MM-DD",
                "data-auto-apply"=>"true",
                "data-show-dropdowns"=>"true",
                "data-drops"=>"down",
                "data-opens"=>"right",
            ),
            "iPlaceholder"=>"DOB",
            "iClass"=>"form-control mce-editors"
        ),
        array(
            "iLabel"=>"Password",
            "iName"=>"db.password",
            "iTypeInput"=>"password",
            "iAttr"=> array(
                "data-validate"=>"",
                "data-required"=>"required",
                "data-min-length"=>"6",
                "data-pattern-message"=>"requirePasswordRule"
            ),
            "iValue"=>"",
            "iPlaceholder"=>"*********",
            "iClass"=>"form-control"
        ),
        array(
            "iLabel"=>"phone",
            "iName"=>"db.title",
            "iValue"=>"0944112199",
            "iTypeInput"=>"input",
            "iAttr"=>array(
                "data-validate"=>"",
                "data-required"=>"required",
                "data-pattern"=>"^[0-9-+\s()]*$",
                "data-min-length"=>"9",
                "data-max-length"=>"20",
                "data-pattern-message"=>"phoneRule"
            ),
            "iPlaceholder"=>"0944112199",
            "iClass"=>"form-control"
        ),
        array(
            "iLabel"=>"City",
            "iName"=>"db.city",
            "iValue"=>"0944112199",
            "iTypeDropdown"=>"dropdown",
            "iAttr"=>array(
                "data-dropdown"=>"",
                "data-required"=>"require",
                "data-index-value"=>"SG",
                "data-str-key"=>"id",
                "data-str-value"=>"ti",
                "data-dropdown-relative"=>"db.district",
                "data-params"=>"cityid=",
                "data-option-from-json"=>"<?=APIGETCITY;?>",
                "data-local-optiona"=>"city",
                "data-object-init"=>"{\"id\":\"\", \"ti\":\"City Option\"}"
            ),
            "iPlaceholder"=>"0944112199",
            "iClass"=>"form-control"
        ),
        array(
            "iLabel"=>"District",
            "iName"=>"db.district",
            "iValue"=>"0944112199",
            "iTypeDropdown"=>"dropdown",
            "iAttr"=>array(
                "data-dropdown"=>"",
                "data-required"=>"require",
                "data-index-value"=>"54",
                "data-str-key"=>"id",
                "data-str-value"=>"district",
                "data-option-from-json"=>"<?=APIGETDISTRICT;?>",
                "data-local-optiona"=>"district",
                "data-object-init"=>"{\"id\":\"\", \"district\":\"District Option\"}"
            ),
            "iPlaceholder"=>"0944112199",
            "iClass"=>"form-control"
        ),
        array(
            "iLabel"=>"{$language["paymentMethod"]}",
            "iName"=>"db.pm",
            "changeOptionInput"=> $language["dropdownLocalOption"]["paymentMethod"],
            "iAttr"=> array(
                "data-validate"=>"",
                "data-required"=>"{$language["requireInput"]}",
                "data-button-magic"=>"",
                "data-prevent-default"=>"true",
                "data-view-template-local"=>"true",
                "data-view-template"=>".view-option-change-input",
                "data-hidden-message"=>"true",
            ),
            "notification"=>'<div class="view-option-change-input"></div>',
            "iClassCustom"=>"payment-method",
        )
    ),
    "attrForm" => array(
        "class"=>"post-form form-horizontal"
    ),
    "button" => array(
        array(
            "iLabel"=>'<span>signup</span>',
            "iClassCustom"=>"col-xs-offset-2 col-xs-4",
            "iAttr"=>array(
                "type"=>"submit",
                "data-button-magic"=>"",
                "data-params-form"=>".post-form",
                "data-format-json"=>"true",
                "data-ajax-url"=>APIPOSTMENU,
                "data-show-success"=>".alert-footer.alert",
                "data-show-errors"=>".alert-footer.alert-error",
                "class"=>"btn btn-block btn-warning text-uppercase"
            )
        ),
        array(
            "iLabel"=>'<span>Reset</span>',
            "iClassCustom"=>"col-xs-4",
            "iAttr"=>array(
                "type"=>"submit",
                "data-button-magic"=>"",
                "data-params-form"=>".post-form",
                "data-format-json"=>"true",
                "data-ajax-url"=>APIPOSTMENU,
                "data-show-success"=>".alert-footer.alert",
                "data-show-errors"=>".alert-footer.alert-error",
                "class"=>"btn btn-block btn-warning text-uppercase"
            )
        )
    ),
    "buttonClass"=>"row form-group"
);

$modeDesign = array();


$strModel = isset($_GET["mod"]) ? $_GET["mod"] : null;

if($strModel == "config") {
    $file = FOLDERHOME . "config.xml";
} elseif(isset($_GET["id"]) && $_GET["id"]) {
    $iId = intval($_GET["id"]);
    if($strModel == "menu") {
        $file = FOLDERMENU . $iId . ".xml";
    } elseif($strModel == "blog") {
        $file = FOLDERBLOG . $iId . ".xml";
    } elseif($strModel == "product") {
        $file = FOLDERPRODUCT . $iId . ".xml";
    } elseif($strModel == "agency") {
        $file = FOLDERAGENCY . $iId . ".xml";
    } elseif($strModel == "review") {
        $file = FOLDERREVIEW . $iId . ".xml";
    } elseif($strModel == "website") {
        $file = FOLDERWEBSITE . $iId . ".xml";
    } elseif($strModel == "template") {
        $file = FOLDERTEMPLATE . $iId . ".xml";
    }
}

if (isset($file) && is_file($file)) {
    $information = simplexml_load_file($file);
    $information = json_encode($information);
    $information = json_decode($information, true);
}

# model menu
$getModelFile = dirname(__FILE__)."/model_".$strModel. ".php";
if (is_file($getModelFile)) {
    require $getModelFile;
}

$dataResponse = $modeDesign;
?>
