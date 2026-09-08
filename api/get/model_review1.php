<?php

$nodeDb = isset($information["db"]) ? $information["db"] : null;
$nodeMore = isset($information["more"]) ? $information["more"] : null;
$nodeMeta = isset($information["meta"]) ? $information["meta"] : null;
$nodeColumn = isset($information["column"]) ? $information["column"] : null;


$dbId = isset($_GET["id"])? $_GET["id"] : null;

$listButton = array(
    array(
        "iClassCustom"=>"col-sm-offset-2 col-xs-4 col-sm-2",
        "iAttr"=> array(
            "type"=>"submit",
            "data-button-magic"=>"",
            "data-params-form"=>".post-form",
            "data-format-json"=>"true",
            "data-ajax-url"=>APIPOSTREVIEW,
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

if($node == "db") {

    if($dbId) {
        $listButton[0]["iAttr"]["data-refress-list"] = ".item-view-more";
    } else {
        $listButton[0]["iAttr"]["data-redirect"] = ".";
    }

    $dbId = isset($nodeDb["id"]) && !empty($nodeDb["id"]) ? $nodeDb["id"] : null;
    $dbTitle = isset($nodeDb["ti"]) && !empty($nodeDb["ti"]) ? $nodeDb["ti"] : null;
    $dbContent = isset($nodeDb["ct"]) && !empty($nodeDb["ct"]) ? $nodeDb["ct"] : null;
    $dbCat = isset($nodeDb["cat"]) && !empty($nodeDb["cat"]) ? $nodeDb["cat"] : null;
    $dbStatus = isset($nodeDb["st"]) && !empty($nodeDb["st"]) ? $nodeDb["st"] : null;
    $dbSort = isset($nodeDb["so"]) && !empty($nodeDb["so"]) ? $nodeDb["so"] : null;

    $groupContent = [];
    foreach ($multiLanguage as $key => $value) {
        array_push($groupContent, [
            "iName"=>"db.ct.{$key}",
            "iValue"=>isset($dbContent[$key]) && !empty($dbContent[$key]) ? $dbContent[$key] : null,
            "iTypeInput"=>"input",
            "iAttr"=>[
                "placeholder"=>$key,
            ],
            "gClass"=>"col-xs-12 mb-10",
            "iClass"=>"form-control"
        ]);
    }

    $modeDesign = array(
        "modal" => array(
            "title"=>"Thêm mới đại lý",
        ),
        "eDesign" => array(
            "row"=>"row form-group",
            "left"=>"col-xs-12 col-sm-2 control-label",
            "right"=>"col-xs-12 col-sm-10",
        ),
        "eInputHidden" => array(
            array(
                "type"=>"hidden",
                "name"=>"updateNode",
                "value"=>"db",
                "data-validate"=>"",
                "data-required"=>"{$language["requireInput"]}"
            ),
            array(
                "type"=>"hidden",
                "name"=>"db.id",
                "value"=>"{$dbId}"
            ),
        ),
        "eForm" => array(
            array(
                "iLabel"=>"{$language["name"]}",
                "iName"=>"db.ti",
                "iValue"=>"{$dbTitle}",
                "iTypeInput"=>"input",
                "iAttr"=> array(
                    "data-validate"=>"",
                    "data-required"=>"{$language["requireInput"]}",
                ),
                "iPlaceholder"=>"",
                "iClass"=>"form-control"
            ),
            array(
                "iLabel"=>$language["shortContent"],
                "groupClass"=>"row",
                "groupInput"=>$groupContent,
            ),
            array(
                "iLabel"=>"{$language["category"]}",
                "iName"=>"categorylist",
                "iTypeDropdown"=>"dropdown",
                "multiOption"=>"multiselect-category",
                "iAttr"=>array(
                    "data-validate"=>"",
                    "data-required"=>"{$language["requireInput"]}",
                    "data-multiselect-box"=>"",
                    "data-multi-selected"=>"{$dbCat}",
                    "data-target-append"=>".multiselect-category",
                    "data-index-value"=>"{$dbCat}",
                    "data-key-name"=>"db.cat",
                    "type"=>"select-from-json",
                    "data-dropdown"=>"",
                    "data-params"=>"opp=5",
                    "data-local-optiona"=>"menuStructure",
                    "data-object-init"=>"{\"id\":\"\", \"ti\":\"{$language["category"]}\"}"
                ),
                "iClass"=>"form-control"
            ),

            array(
                "iLabel"=>"{$language["order"]}",
                "iName"=>"db.so",
                "iValue"=>"{$dbSort}",
                "iTypeInput"=>"number",
                "iPlaceholder"=>"",
                "iClass"=>"form-control"
            ),
            array(
                "iLabel"=>"{$language["status"]}",
                "iName"=>"db.st",
                "iTypeDropdown"=>"dropdown",
                "iAttr"=>array(
                    "data-validate"=>"",
                    "data-dropdown"=>"",
                    "data-index-value"=>"{$dbStatus}",
                    "data-required"=>"{$language["requireInput"]}",
                    "data-local-optiona"=>"reviewStatus",
                    "data-object-init"=>"{\"id\":\"\", \"ti\":\"{$language["status"]}\"}"
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

    if($dbId) {
        unset($modeDesign["modal"]);
    }

} elseif($node == "more") {

} elseif($node == "meta") {

} elseif($node == "column") {

} elseif($node == "detail") {

}
?>
