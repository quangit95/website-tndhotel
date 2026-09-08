<?php
if($multiLanguage) {
    require_once dirname(__FILE__)."/model_blog1.php";
} else {
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

        $dbId = isset($nodeDb["id"]) ? $nodeDb["id"] : null;
        $dbCat = isset($nodeDb["cat"]) ? $nodeDb["cat"] : null;
        $dbTitle = isset($nodeDb["ti"]) ? $nodeDb["ti"] : null;
        $dbTag = isset($nodeDb["tag"]) ? $nodeDb["tag"] : null;
        $dbContent = isset($nodeDb["ct"]) ? $nodeDb["ct"] : null;
        $dbIsMenu = isset($nodeDb["ism"]) ? $nodeDb["ism"] : null;
        $dbStatus = isset($nodeDb["st"]) ? $nodeDb["st"] : null;
        $dbSort = isset($nodeDb["so"]) ? $nodeDb["so"] : null;

        $inputHidden[1]["name"]="db.id";

        $modeDesign = array(
            "modals" => array(
                "title"=>"Thêm mới menu/danh mục",
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
                    "iName"=>"db.ct",
                    "iValue"=>$dbContent,
                    "iTypeInput"=>"input",
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
        $moreYoutubeId = isset($nodeMore["youtubeId"]) && !empty($nodeMore["youtubeId"]) ? $nodeMore["youtubeId"] : null;
        $moreDisplaySlide = isset($nodeMore["isShowSlide"]) ? $nodeMore["isShowSlide"] : null;

        $modeDesign = array(
            "eDesign" => array(
                "row"=>"row form-group",
                "left"=>"col-xs-12 col-sm-2 control-label",
                "right"=>"col-xs-12 col-sm-10",
            ),
            "eInputHidden" => $inputHidden,
            "eForm" => array(
                array(
                    "iLabel"=>$language["description"],
                    "iName"=>"more.description",
                    "iValue"=>$moreDescription,
                    "iTypeInput"=>"input",
                    "iTextarea"=>"true",
                    "iClass"=>"form-control mce-editor"
                ),
                array(
                    "iLabel"=>$language["displaySlideImage"],
                    "iName"=>"more.isShowSlide",
                    "iTypeCheckbox"=>"checkbox",
                    "iAttr"=>'data-validates data-pattern-message="invalide option" data-hidden-message="true" type="checkbox" data-option-onlys="6"',
                    "iDesign"=>'<div class="item-ticket"><label class="checkbox"><input type="checkbox" name="{3}.{0}" data-key="{3}" value="{0}" {2}><span class="fa checkbox-style"></span></label> </div>',
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
                    "iName"=>"meta.title",
                    "iValue"=>$metaTitle,
                    "iTypeInput"=>"input",
                    "iClass"=>"form-control"
                ),
                array(
                    "iLabel"=>$language["metaDesc"],
                    "iName"=>"meta.desc",
                    "iValue"=>$metaDesc,
                    "iTypeInput"=>"input",
                    "iClass"=>"form-control"
                ),
                array(
                    "iLabel"=>$language["metaKeyword"],
                    "iName"=>"meta.keyword",
                    "iValue"=>$metaKeyword,
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
}
