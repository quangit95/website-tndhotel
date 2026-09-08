<?php
$nodeDb = isset($information["db"]) ? $information["db"] : null;

$dbId = isset($_GET["id"])? $_GET["id"] : null;
$listButton = array(
    array(
        "iClassCustom"=>"col-sm-offset-2 col-xs-4 col-sm-2",
        "iAttr"=> array(
            "type"=>"submit",
            "data-button-magic"=>"",
            "data-params-form"=>".post-form",
            "data-format-json"=>"true",
            "data-ajax-url"=>APIPOSTPRODUCT,
            "data-show-success"=>".alert-footer.alert",
            "data-show-errors"=>".alert-footer.alert-error",
            "class"=>"btn btn-block btn-primary text-uppercase"
        )
    )
);

if($dbId) {
    $strButton = $language["btnUpdate"];
} else {
    $strButton = $language["btnAdd"];
}
$listButton[0]["iLabel"] = '<span>'.$strButton.'</span>';

$node = isset($_GET["node"]) && $_GET["node"] ? $_GET["node"] : "db";

$inputHidden = array(
        array(
            "type"=>"hidden",
            "name"=>"updateNode",
            "value"=>$node,
            "data-validate"=>"",
            "data-required"=>$language["requireInput"]
        ),
        array(
            "type"=>"hidden",
            "name"=>"id",
            "value"=>$dbId
        ),
    );

if($node == "db") {
    $inputHidden[1]["name"]="db.id";
    $dbId = isset($nodeDb["id"]) ? $nodeDb["id"] : null;
    $dbTitle = isset($nodeDb["ti"]) ? $nodeDb["ti"] : null;
    $dbCat = isset($nodeDb["cat"]) ? $nodeDb["cat"] : null;
    $dbStatus = isset($nodeDb["st"]) ? $nodeDb["st"] : null;
    $dbSort = isset($nodeDb["so"]) ? $nodeDb["so"] : null;


    if($dbId) {
        $listButton[0]["iAttr"]["data-refress-list"] = ".item-view-more";
    } else {
        $listButton[0]["iAttr"]["data-redirect"] = ".";
    }

    $modeDesign = array(
        "modals" => array(
            "title"=>$language["addEdit"],
        ),
        "eDesign" => array(
            "row"=>"row form-group",
            "left"=>"col-xs-12 col-sm-2 control-label",
            "right"=>"col-xs-12 col-sm-10",
        ),
        "eInputHidden" => $inputHidden,
        "eForm" => array(
            array(
                "iLabel"=>$language["title"],
                "iName"=>"db.ti",
                "iValue"=>$dbTitle,
                "iTypeInput"=>"input",
                "iAttr"=> array(
                    "data-validate"=>"",
                    "data-required"=>$language["requireInput"],
                ),
                "iPlaceholder"=>"",
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
                    "data-multi-selected"=>$dbCat,
                    "data-target-append"=>".multiselect-category",
                    "data-index-value"=>$dbCat,
                    "data-key-name"=>"db.cat",
                    "type"=>"select-from-json",
                    "data-dropdown"=>"",
                    "data-params"=>"opp=3",
                    "data-local-optiona"=>"menuStructure",
                    "data-object-init"=>"{\"id\":\"\", \"ti\":\"{$language["category"]}\"}"
                ),
                "iClass"=>"form-control"
            ),
            array(
                "iLabel"=>"Layout",
                "iName"=>"db.layout",
                "iTypeRadio"=>"radio",
                "iAttr"=>'data-validates="" data-pattern-message="invalide option" data-hidden-message="true" type="checkbox"',
                "iDesign"=>'<div class="radio-inline layout-{0}"><label class="radio"><input type="radio" name="db.cmf" data-key="db.cmf" value="{0}" {2}><span class="fa radio-style"></span><span>{1}</span></label> </div>',
                "iList"=>"stampitLayout",
                "iKey"=>"id",
                "iValue"=>"ti",
                "iOptioned"=>" ",
                "iKeyBox"=>"db.layout"
            ),
            array(
                "iLabel"=>$language["order"],
                "iName"=>"db.so",
                "iValue"=>$dbSort,
                "iTypeInput"=>"number",
                "iPlaceholder"=>"",
                "iClass"=>"form-control"
            ),
            array(
                "iLabel"=>$language["status"],
                "iName"=>"db.st",
                "iTypeDropdown"=>"dropdown",
                "iAttr"=>array(
                    "data-validate"=>"",
                    "data-dropdown"=>"",
                    "data-index-value"=>$dbStatus,
                    "data-required"=>$language["requireInput"],
                    "data-local-optiona"=>"productStatus",
                    "data-object-init"=>"{\"id\":\"\", \"ti\":\"{$language["viewAll"]}\"}"
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

    $arrayPlus = [];

    if(!empty($arrayPlus)) {
        array_splice($modeDesign["eForm"], 4, 0, $arrayPlus);
    }
}
?>
