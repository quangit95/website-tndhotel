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
            "data-ajax-url"=>APIPOSTBLOG,
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

    if($dbId) {
        $listButton[0]["iAttr"]["data-refress-list"] = ".item-view-more";
    } else {
        $listButton[0]["iAttr"]["data-redirect"] = ".";
    }

    $inputHidden[1]["name"]="db.id";

    $dbId = isset($nodeDb["id"]) ? $nodeDb["id"] : null;
    $dbCat = isset($nodeDb["cat"]) ? $nodeDb["cat"] : null;
    $dbTitle = isset($nodeDb["ti"]) ? $nodeDb["ti"] : null;
    $dbTag = isset($nodeDb["tag"]) ? $nodeDb["tag"] : null;
    $dbContent = isset($nodeDb["ct"]) ? $nodeDb["ct"] : null;
    $dbIsMenu = isset($nodeDb["ism"]) ? $nodeDb["ism"] : null;
    $dbStatus = isset($nodeDb["st"]) ? $nodeDb["st"] : null;
    $dbSort = isset($nodeDb["so"]) ? $nodeDb["so"] : null;

    $groupTitle = [];
    $groupContent = [];

    foreach ($multiLanguage as $key => $value) {
        array_push($groupTitle, [
            "iName"=>"db.ti.{$key}",
            "iValue"=>isset($dbTitle[$key]) && !empty($dbTitle[$key]) ? $dbTitle[$key] : null,
            "iTypeInput"=>"input",
            "iAttr"=>[
                "placeholder"=>$key,
                "data-validate"=>"",
                "data-required"=>$language["requireInput"],
            ],
            "gClass"=>"col-xs-12 mb-10",
            "iClass"=>"form-control"
        ]);
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
                "groupClass"=>"row",
                "groupInput"=>$groupTitle,
            ),
            array(
                "iLabel"=>$language["category"],
                "iName"=>"db.cat",
                "iTypeDropdown"=>"dropdown",
                "iAttr"=>array(
                    "data-validate"=>"",
                    "data-required"=>$language["requireInput"],
                    "data-dropdown"=>"",
                    "data-index-value"=>$dbCat,
                    "data-params"=>"opp=2",
                    "data-local-optiona"=>"menuStructure",
                    "data-object-init"=>"{\"id\":\"\", \"ti\":\"{$language["category"]}\"}"
                ),
                "iClass"=>"form-control"
            ),
            array(
                "iLabel"=>$language["tag"],
                "iName"=>"db.tag",
                "iValue"=>$dbTag,
                "iTypeInput"=>"input",
                "iClass"=>"form-control"
            ),
            array(
                "iLabel"=>$language["shortContent"],
                "groupClass"=>"row",
                "groupInput"=>$groupContent,
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
                    "data-local-optiona"=>"blogStatus",
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
} elseif($node == "more") {
    $moreDescription = isset($nodeMore["description"]) && !empty($nodeMore["description"]) ? $nodeMore["description"] : null;
    $groupDescription = [];
    $moreDisplaySlide = isset($nodeMore["isShowSlide"]) ? $nodeMore["isShowSlide"] : null;
    $moreYoutubeId = isset($nodeMore["youtubeId"]) && !empty($nodeMore["youtubeId"]) ? $nodeMore["youtubeId"] : null;


    $listButton[0]["iClassCustom"] = "col-xs-4 col-sm-2";

    foreach ($multiLanguage as $key => $value) {
        array_push($groupDescription, [
            "iLabel"=>"{$language["description"]}({$key})",
            "iName"=>"more.{$key}.description",
            "iValue"=>isset($nodeMore[$key]["description"]) ? $nodeMore[$key]["description"] : null,
            "iTypeInput"=>"input",
            "iTextarea"=>"true",
            "gClass"=>"col-xs-12 mb-10",
            "iClass"=>"form-control mce-editor"
        ]);
    }

    $modeDesign = array(
        "eDesign" => array(
            "row"=>"row form-group",
            "left"=>"col-xs-12 control-label hidden",
            "right"=>"col-xs-12",
        ),
        "eInputHidden" => $inputHidden,
        "eForm" => array(
            array(
                "iLabel"=>$language["description"],
                "groupClass"=>"row",
                "groupInput"=>$groupDescription,
            ),
            array(
                "iLabel"=>$language["displaySlideImage"],
                "iName"=>"{$node}.isShowSlide",
                "iTypeCheckbox"=>"checkbox",
                "iAttr"=>'data-validates data-pattern-message="invalide option" data-hidden-message="true" type="checkbox" data-option-onlys="6"',
                "iDesign"=>'<div class="item-ticket"><label class="checkbox"><input type="checkbox" name="{3}.{0}" data-key="{3}" value="{0}" {2}><span class="fa checkbox-style"></span> <span>'.$language["displaySlideImage"].'</span></label> </div>',
                "iList"=>$language["dropdownLocalOption"]["checkboxIsMenu"],
                "iOptioned"=>$moreDisplaySlide,
                "iKeyBox"=>"{$node}.isShowSlide"
            ),
            array(
                "iLabel"=>"Youtube Video Id",
                "iName"=>"more.youtubeId",
                "iValue"=>$moreYoutubeId,
                "iTypeInput"=>"input",
                "iPlaceholder"=>"Youtube Video Id",
                "iClass"=>"form-control",
                "iClassCustom"=>"init-none youtube-video-id-block"
            )
        ),
        "attrForm" => array(
            "class"=>"post-form form-horizontal"
        ),
        "button" => $listButton,
        "buttonClass"=>"row form-group"
    );
} elseif($node == "meta") {
    $metaTitle = isset($nodeMeta["title"]) ? $nodeMeta["title"] : null;
    $metaDesc = isset($nodeMeta["desc"]) ? $nodeMeta["desc"] : null;
    $metaKeyword = isset($nodeMeta["keyword"]) ? $nodeMeta["keyword"] : null;

    $groupTitle = [];
    $groupDesc = [];
    $groupKeyword = [];

    foreach ($multiLanguage as $key => $value) {
        array_push($groupTitle, [
            "iName"=>"meta.{$key}.title",
            "iValue"=>isset($nodeMeta[$key]["title"]) ? $nodeMeta[$key]["title"] : null,
            "iTypeInput"=>"input",
            "iAttr"=>[
                "placeholder"=>$key,
            ],
            "gClass"=>"col-xs-12 mb-10",
            "iClass"=>"form-control"
        ]);
        array_push($groupDesc, [
            "iName"=>"meta.{$key}.desc",
            "iValue"=>isset($nodeMeta[$key]["desc"]) ? $nodeMeta[$key]["desc"] : null,
            "iTypeInput"=>"input",
            "iAttr"=>[
                "placeholder"=>$key,
            ],
            "gClass"=>"col-xs-12 mb-10",
            "iClass"=>"form-control"
        ]);
        array_push($groupKeyword, [
            "iName"=>"meta.{$key}.keyword",
            "iValue"=>isset($nodeMeta[$key]["keyword"]) ? $nodeMeta[$key]["keyword"] : null,
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
            "row"=>"row form-group",
            "left"=>"col-xs-12 col-sm-2 control-label",
            "right"=>"col-xs-12 col-sm-10",
        ),
        "eInputHidden" => $inputHidden,
        "eForm" => array(
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
} elseif($node == "column") {
    $columnLeft = isset($nodeColumn["left"]) ? $nodeColumn["left"] : null;
    $columnMain = isset($nodeColumn["main"]) ? $nodeColumn["main"] : null;
    $columnRight = isset($nodeColumn["right"]) ? $nodeColumn["right"] : null;
    $modeDesign = array(
        "eDesign" => array(
            "row"=>"row form-group",
            "left"=>"col-xs-12 col-sm-2 control-label",
            "right"=>"col-xs-12 col-sm-10",
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
} elseif($node == "detail") {

}
