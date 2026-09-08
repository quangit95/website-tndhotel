<?php

$dbId = isset($_GET["id"])? $_GET["id"] : null;

$listButton = array(
    array(
        "iClassCustom"=>"col-sm-offset-2 col-xs-4 col-sm-2",
        "iAttr"=> array(
            "type"=>"submit",
            "data-button-magic"=>"",
            "data-params-form"=>".post-form",
            "data-format-json"=>"true",
            "data-ajax-url"=>"/api/post/local",
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

$dbTitle = isset($_GET["ti"]) ? $_GET["ti"] : null;
$dbCode = isset($_GET["code"]) ? $_GET["code"] : null;
$dbCid = isset($_GET["cid"]) ? $_GET["cid"] : null;
$dbDid = isset($_GET["did"]) ? $_GET["did"] : null;
$strFun = isset($_GET["fun"]) ? $_GET["fun"] : null;

$modeDesign = array(
    "eDesign" => array(
        "row"=>"row form-group",
        "left"=>"col-xs-12 col-sm-2 control-label",
        "right"=>"col-xs-12 col-sm-10",
    ),
    "eInputHidden" => [
      ["type"=>"hidden", "name"=>"db.id", "value"=>$dbId],
      ["type"=>"hidden", "name"=>"table", "value"=>$strFun]
    ],
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
        )
    ),
    "attrForm" => array(
        "class"=>"post-form form-horizontal"
    ),
    "button" => $listButton,
    "buttonClass"=>"row form-group"
);

$arrayPlus = array();
if($strFun=="local_city") {
    $arrayPlus = array(
        array(
            "iLabel"=>$language["code"],
            "iName"=>"db.code",
            "iValue"=>$dbCode,
            "iTypeInput"=>"input",
            "iAttr"=> array(
                "data-validate"=>"",
                "data-required"=>$language["requireInput"],
            ),
            "iPlaceholder"=>"",
            "iClass"=>"form-control"
        )
    );
} elseif($strFun=="local_district") {
    $arrayPlus = array(
        array(
            "iLabel"=>$language["city"],
            "iName"=>"db.cid",
            "iTypeDropdown"=>"dropdown",
            "iAttr"=>array(
                "data-validate"=>"",
                "data-dropdown"=>"",
                "data-required"=>$language["requireInput"],
                "data-index-value"=>$dbCid,
                "data-str-key"=>"id",
                "data-str-value"=>"ti",
                "data-params"=>"cid=",
                "data-option-from-json"=>APIGETCITY,
                "data-local-optiona"=>"city",
                "data-object-init"=>"{\"id\":\"\", \"ti\":\"{$language["city"]}\"}"
            ),
            "iClass"=>"form-control"
        )
    );
} elseif($strFun=="local_ward") {
    $arrayPlus = array(
        array(
            "iLabel"=>$language["city"],
            "iName"=>"db.cid",
            "iTypeDropdown"=>"dropdown",
            "iAttr"=>array(
                "data-validate"=>"",
                "data-dropdown"=>"",
                "data-required"=>$language["requireInput"],
                "data-index-value"=>$dbCid,
                "data-str-key"=>"id",
                "data-str-value"=>"ti",
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
            "iName"=>"db.did",
            "iTypeDropdown"=>"dropdown",
            "iAttr"=>array(
                "data-validate"=>"",
                "data-dropdown"=>"",
                "data-params-relative"=>"did=",
                "data-required"=>$language["requireInput"],
                "data-index-value"=>$dbDid,
                "data-str-key"=>"id",
                "data-str-value"=>"ti",
                "data-option-from-json"=>APIGETDISTRICT,
                "data-local-optiona"=>"district",
                "data-object-init"=>"{\"id\":\"\", \"ti\":\"{$language["district"]}\"}"
            ),
            "iClass"=>"form-control"
        ),
    );
}

array_splice($modeDesign["eForm"], 1, 0, $arrayPlus);

?>
