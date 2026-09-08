<?php
if($multiLanguage) {
    require_once dirname(__FILE__)."/model_menu1.php";
} else {
    $nodeDb = isset($information["db"]) ? $information["db"] : null;
    $nodeMore = isset($information["more"]) ? $information["more"] : null;
    $nodeMeta = isset($information["meta"]) ? $information["meta"] : null;
    $nodeAdvertise = isset($information["advertise"]) ? $information["advertise"] : null;
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
                "data-ajax-url"=>APIPOSTMENU,
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

    $dbOpp = isset($nodeDb["opp"]) && !empty($nodeDb["opp"]) ? $nodeDb["opp"] : null;

    if($node == "db") {

        $inputHidden[1]["name"]="db.id";

        $dbId = isset($nodeDb["id"]) && !empty($nodeDb["id"]) ? $nodeDb["id"] : null;
        $dbTitle = isset($nodeDb["ti"]) && !empty($nodeDb["ti"]) ? $nodeDb["ti"] : null;
        $dbTitleSecond = isset($nodeDb["ti1"]) && !empty($nodeDb["ti1"]) ? $nodeDb["ti1"] : null;
        $dbUrl = isset($nodeDb["url"]) && !empty($nodeDb["url"]) ? $nodeDb["url"] : null;
        $dbLink = isset($nodeDb["link"]) && !empty($nodeDb["link"]) ? $nodeDb["link"] : null;

        $dbPa = isset($nodeDb["pa"]) && !empty($nodeDb["pa"]) ? $nodeDb["pa"] : null;
        $dbContent = isset($nodeDb["ct"]) && !empty($nodeDb["ct"]) ? $nodeDb["ct"] : null;
        $dbIsMenu = isset($nodeDb["ism"]) && !empty($nodeDb["ism"]) ? $nodeDb["ism"] : null;
        $dbStatus = isset($nodeDb["st"]) && !empty($nodeDb["st"]) ? $nodeDb["st"] : null;
        $dbSort = isset($nodeDb["so"]) && !empty($nodeDb["so"]) ? $nodeDb["so"] : null;
        $dbOpl = isset($nodeDb["opl"]) && !empty($nodeDb["opl"]) ? $nodeDb["opl"] : null;

        if($dbId) {
            $listButton[0]["iAttr"]["data-refress-list"] = ".item-view-more";
        } else {
            $listButton[0]["iAttr"]["data-redirect"] = ".";
        }

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
                    "iLabel"=>$language["titleSecond"],
                    "iName"=>"db.ti1",
                    "iValue"=>$dbTitleSecond,
                    "iTypeInput"=>"input",
                    "iPlaceholder"=>"",
                    "iClass"=>"form-control"
                ),
                array(
                    "iLabel"=>$language["titleUrl"],
                    "iName"=>"db.url",
                    "iValue"=>$dbUrl,
                    "iTypeInput"=>"input",
                    "iAttr"=> array(
                        "data-validate"=>"",
                        "data-required"=>$language["requireInput"],
                        "data-server"=>APIPOSTCHECKURL,
                        "data-key"=>"url",
                        "data-params"=> $dbId ? "{\"mod\":\"menu\",\"id\":\"{$dbId}\"}" : "{\"mod\":\"menu\"}",
                        "data-pattern"=>"^[A-Za-z0-9_-]{3,40}$",
                        "data-pattern-message"=>$language["requireUsernameRule"]
                    ),
                    "iPlaceholder"=>"",
                    "iClass"=>"form-control mce-editors"
                ),
                array(
                    "iLabel"=>"Attribute HTML",
                    "iName"=>"db.opl",
                    "iValue"=>$dbOpl,
                    "iTypeInput"=>"input",
                    "iPlaceholder"=>"",
                    "iClassCustom"=>"init-none attribute-html-block",
                    "iClass"=>"form-control mce-editors"
                ),
                array(
                    "iLabel"=>$language["externalLink"],
                    "iName"=>"db.link",
                    "iValue"=>$dbLink,
                    "iTypeInput"=>"input",
                    "iPlaceholder"=>"",
                    "iClass"=>"form-control"
                ),
                array(
                    "iLabel"=>$language["page"],
                    "iName"=>"db.opp",
                    "iTypeDropdown"=>"dropdown",
                    "iAttr"=>array(
                        "data-validate"=>"",
                        "data-required"=>$language["requireInput"],
                        "data-dropdown"=>"",
                        "data-index-value"=>$dbOpp,
                        "data-dropdown-relative"=>"db.pa",
                        "data-params"=>"opp=",
                        "data-local-optiona"=>"page",
                        "data-object-init"=>"{\"id\":\"\", \"ti\":\"{$language["viewAll"]}\"}"
                    ),
                    "iClass"=>"form-control"
                ),
                array(
                    "iLabel"=>$language["rootMenu"],
                    "iName"=>"db.pa",
                    "iTypeDropdown"=>"dropdown",
                    "iAttr"=>array(
                        "type"=>"select-from-json",
                        "data-dropdown"=>"",
                        "data-index-value"=>$dbPa,
                        "data-option-from-json"=>APIGETMENU,
                        "data-local-optiona"=>"menuStructure",
                        "data-object-init"=>"{\"id\":\"0\", \"ti\":\"{$language["rootMenu"]}\"}"
                    ),
                    "iPlaceholder"=>"0944112199",
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
                    "iLabel"=>$language["order"],
                    "iName"=>"db.so",
                    "iValue"=>$dbSort,
                    "iTypeInput"=>"number",
                    "iPlaceholder"=>"",
                    "iClass"=>"form-control"
                ),
                array(
                    "iLabel"=>$language["navMenu"],
                    "iName"=>"db.ism",
                    "iTypeCheckbox"=>"checkbox",
                    "iAttr"=>'data-validates data-pattern-message="invalide option" data-hidden-message="true" type="checkbox" data-option-onlys="6"',
                    "iDesign"=>'<div class="item-ticket"><label class="checkbox"><input type="checkbox" name="{3}.{0}" data-key="{3}" value="{0}" {2}><span class="fa checkbox-style"></span></label> </div>',
                    "iList"=>$language["dropdownLocalOption"]["checkboxIsMenu"],
                    "iOptioned"=>"{$dbIsMenu}",
                    "iKeyBox"=>"db.ism"
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
                        "data-local-optiona"=>"menuStatus",
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

        if($dbOpp ) {
            if($dbOpp == 3) {

                $dbClc = isset($nodeDb["clc"]) && !empty($nodeDb["clc"]) ? $nodeDb["clc"] : null;
                $dbClr = isset($nodeDb["clr"]) && !empty($nodeDb["clr"]) ? $nodeDb["clr"] : null;
                $dbcmf = isset($nodeDb["cmf"]) && !empty($nodeDb["cmf"]) ? $nodeDb["cmf"] : 1;
                $dbPs = isset($nodeDb["ps"]) && !empty($nodeDb["ps"]) ? $nodeDb["ps"] : 1;


                $arrayPlus = array(
                    array(
                        "iLabel"=>$language["commentFB"],
                        "iName"=>"db.cmf",
                        "iTypeRadio"=>"radio",
                        "iAttr"=>'data-validates data-pattern-message="invalide option" data-hidden-message="true" type="checkbox" data-option-onlys="6"',
                        "iDesign"=>'<div class="radio-inline"><label class="radio"><input type="radio" name="db.cmf" data-key="db.cmf" value="{0}" {2}><span class="fa radio-style"></span><span>{1}</span></label> </div>',
                        "iList"=>$language["dropdownLocalOption"]["yesNoQuestion"],
                        "iOptioned"=>"{$dbcmf}",
                        "iKeyBox"=>"db.cmf"
                    ),
                    array(
                        "iLabel"=>$language["customLayoutClass"],
                        "iName"=>"db.clc",
                        "iTypeDropdown"=>"dropdown",
                        "iAttr"=>array(
                            "data-validate"=>"",
                            "data-dropdown"=>"",
                            "data-index-value"=>$dbClc,
                            "data-required"=>$language["requireInput"],
                            "data-local-optiona"=>"customClass",
                            "data-object-init"=>"{\"id\":\"\", \"ti\":\"{$language["viewAll"]}\"}"
                        ),
                        "iClass"=>"form-control"
                    ),
                    array(
                        "iLabel"=>$language["customLayoutViewList"],
                        "iName"=>"db.clr",
                        "iValue"=>$dbClr,
                        "iTypeInput"=>"input",
                        "iPlaceholder"=>"",
                        "iClass"=>"form-control"
                    ),
                    array(
                        "iLabel"=>$language["customLayoutClass"],
                        "iName"=>"db.ps",
                        "iTypeDropdown"=>"dropdown",
                        "iAttr"=>array(
                            "data-validate"=>"",
                            "data-dropdown"=>"",
                            "data-index-value"=>$dbPs,
                            "data-local-optiona"=>"slideProduct",
                            "data-object-init"=>"{\"id\":\"\", \"ti\":\"{$language["viewAll"]}\"}"
                        ),
                        "iClass"=>"form-control"
                    )
                );

                array_splice($modeDesign["eForm"], 4, 0, $arrayPlus);
            } elseif($dbOpp == 2) {
                $dbcmf = isset($nodeDb["cmf"]) && !empty($nodeDb["cmf"]) ? $nodeDb["cmf"] : 1;
                $arrayPlus = array(
                    array(
                        "iLabel"=>$language["commentFB"],
                        "iName"=>"db.cmf",
                        "iTypeRadio"=>"radio",
                        "iAttr"=>'data-validates data-pattern-message="invalide option" data-hidden-message="true" type="checkbox" data-option-onlys="6"',
                        "iDesign"=>'<div class="radio-inline"><label class="radio"><input type="radio" name="db.cmf" data-key="db.cmf" value="{0}" {2}><span class="fa radio-style"></span><span>{1}</span></label> </div>',
                        "iList"=>$language["dropdownLocalOption"]["yesNoQuestion"],
                        "iOptioned"=>$dbcmf,
                        "iKeyBox"=>"db.cmf"
                    )
                );
                array_splice($modeDesign["eForm"], 4, 0, $arrayPlus);
            }
        }



    } elseif($node == "more") {
        $moreDescription = isset($nodeMore["description"]) && !empty($nodeMore["description"]) ? $nodeMore["description"] : null;
        $moreNoteDetail = isset($nodeMore["noteDetail"]) && !empty($nodeMore["noteDetail"]) ? $nodeMore["noteDetail"] : null;
        $moreContentCustom = isset($nodeMore["contentCustom"]) && !empty($nodeMore["contentCustom"]) ? $nodeMore["contentCustom"] : null;
        $moreShowItem = isset($nodeMore["showItem"]) && !empty($nodeMore["showItem"]) ? $nodeMore["showItem"] : null;
        $moreNumberItem = isset($nodeMore["numberItem"]) && !empty($nodeMore["numberItem"]) ? $nodeMore["numberItem"] : 24;
        $moreSortItem = isset($nodeMore["sortItem"]) && !empty($nodeMore["sortItem"]) ? $nodeMore["sortItem"] : "id=-1";
        $moreItemPageDetail= isset($nodeMore["itemPageDetail"]) && !empty($nodeMore["itemPageDetail"]) ? $nodeMore["itemPageDetail"] : null;
        $isFormContact = isset($nodeMore["isform"]) && !empty($nodeMore["isform"]) ? $nodeMore["isform"] : 1;
        $moreTemplateBooking = isset($nodeMore["templateBooking"]) && !empty($nodeMore["templateBooking"]) ? $nodeMore["templateBooking"] : null;


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
                    "iLabel"=>$language["contentCustom"],
                    "iName"=>"more.contentCustom",
                    "iValue"=>$moreContentCustom,
                    "iTypeInput"=>"input",
                    "iTextarea"=>"true",
                    "iClass"=>"form-control mce-editor"
                ),
            ),
            "attrForm" => array(
                "class"=>"post-form form-horizontal"
            ),
            "button" => $listButton,
            "buttonClass"=>"row form-group"
        );

        if($dbOpp ) {
            if($dbOpp == 3 || $dbOpp == 2) {
                $arrayPlus = array(
                    array(
                        "iLabel"=>"Show category list",
                        "iName"=>"more.showItem",
                        "iTypeDropdown"=>"dropdown",
                        "iAttr"=>array(
                            "data-validate"=>"",
                            "data-dropdown"=>"",
                            "data-index-value"=>$moreShowItem,
                            "data-required"=>$language["requireInput"],
                            "data-local-optiona"=>"categoryShowItem",
                            "data-object-init"=>"{\"id\":\"\", \"ti\":\"{$language["viewAll"]}\"}"
                        ),
                        "iClass"=>"form-control"
                    ),
                    array(
                        "iLabel"=>$language["itemNumber"],
                        "iName"=>"more.numberItem",
                        "iValue"=>$moreNumberItem,
                        "iTypeInput"=>"input",
                        "iAttr"=> array(
                            "data-validate"=>"",
                            "data-required"=>$language["requireInput"],
                        ),
                        "iPlaceholder"=>"",
                        "iClass"=>"form-control"
                    ),
                    array(
                        "iLabel"=>"Template Booking",
                        "iName"=>"more.templateBooking",
                        "iValue"=>$moreTemplateBooking,
                        "iTypeInput"=>"input",
                        "iPlaceholder"=>"Template Booking",
                        "iClass"=>"form-control",
                        "iClassCustom"=>"init-none template-booking-block"
                    ),
                    array(
                        "iLabel"=>"Custom sort",
                        "iName"=>"more.sortItem",
                        "iValue"=>$moreSortItem,
                        "iTypeInput"=>"input",
                        "iPlaceholder"=>"",
                        "iClass"=>"form-control",
                        "iClassCustom"=>"init-none block-custom-sort"
                    ),
                    array(
                        "iLabel"=>"Item Page Detail",
                        "iName"=>"more.itemPageDetail",
                        "iValue"=>$moreItemPageDetail,
                        "iTypeInput"=>"input",
                        "iTextarea"=>"true",
                        "iPlaceholder"=>"",
                        "iClass"=>"form-control",
                        "iClassCustom"=>"init-none block-custom-detail-page"
                    ),
                );

                array_splice($modeDesign["eForm"], 2, 0, $arrayPlus);

                if($dbOpp == 3) {
                    array_splice($modeDesign["eForm"], 2, 0, array(
                        array(
                            "iLabel"=>"Note For Product",
                            "iName"=>"more.noteDetail",
                            "iValue"=>$moreNoteDetail,
                            "iTypeInput"=>"input",
                            "iTextarea"=>"true",
                            "iClass"=>"form-control mce-editor"
                        )
                    ));
                }
            } elseif( $dbOpp == 5) {
                $arrayPlus = array(
                    array(
                        "iLabel"=>$language["contact"],
                        "iName"=>"more.isform",
                        "iTypeRadio"=>"radio",
                        "iAttr"=>'data-validates data-pattern-message="invalide option" data-hidden-message="true" type="checkbox" ',
                        "iDesign"=>'<div class="radio-inline"><label class="radio"><input type="radio" name="more.isform" data-key="more.isform" value="{0}" {2}><span class="fa radio-style"></span><span>{1}</span></label> </div>',
                        "iList"=>$language["dropdownLocalOption"]["yesNoQuestion"],
                        "iOptioned"=>$isFormContact,
                        "iKeyBox"=>"more.isform"
                    )
                );
                array_splice($modeDesign["eForm"], 2, 0, $arrayPlus);
            }  elseif($dbOpp == 6) {
                $arrayPlus = array(
                    array(
                        "iLabel"=>"Show category list",
                        "iName"=>"more.showItem",
                        "iTypeDropdown"=>"dropdown",
                        "iAttr"=>array(
                            "data-validate"=>"",
                            "data-dropdown"=>"",
                            "data-index-value"=>$moreShowItem,
                            "data-required"=>$language["requireInput"],
                            "data-local-optiona"=>"categoryShowItem",
                            "data-object-init"=>"{\"id\":\"\", \"ti\":\"{$language["viewAll"]}\"}"
                        ),
                        "iClass"=>"form-control"
                    ),
                    array(
                        "iLabel"=>$language["itemNumber"],
                        "iName"=>"more.numberItem",
                        "iValue"=>$moreNumberItem,
                        "iTypeInput"=>"input",
                        "iAttr"=> array(
                            "data-validate"=>"",
                            "data-required"=>$language["requireInput"],
                        ),
                        "iPlaceholder"=>"",
                        "iClass"=>"form-control"
                    ),
                    array(
                        "iLabel"=>"Custom sort",
                        "iName"=>"more.sortItem",
                        "iValue"=>$moreSortItem,
                        "iTypeInput"=>"input",
                        "iPlaceholder"=>"",
                        "iClass"=>"form-control",
                        "iClassCustom"=>"block-custom-sort"
                    )
                );
                array_splice($modeDesign["eForm"], 2, 0, $arrayPlus);
            } elseif($dbOpp == 7) {
                $arrayPlus = array(
                    array(
                        "iLabel"=>"Session Group",
                        "iName"=>"more.session",
                        "iTypeDropdown"=>"dropdown",
                        "iAttr"=>array(
                            "data-validate"=>"",
                            "data-dropdown"=>"",
                            "data-index-value"=>$moreShowItem,
                            "data-required"=>$language["requireInput"],
                            "data-local-optiona"=>"categoryShowItem",
                            "data-object-init"=>"{\"id\":\"\", \"ti\":\"{$language["viewAll"]}\"}"
                        ),
                        "iClass"=>"form-control"
                    )
                );
                array_splice($modeDesign["eForm"], 2, 0, $arrayPlus);
            }
        }

    } elseif($node == "meta") {
        $metaTitle = isset($nodeMeta["title"]) && !empty($nodeMeta["title"]) ? $nodeMeta["title"] : null;
        $metaDesc = isset($nodeMeta["desc"]) && !empty($nodeMeta["desc"]) ? $nodeMeta["desc"] : null;
        $metaKeyword = isset($nodeMeta["keyword"]) && !empty($nodeMeta["keyword"]) ? $nodeMeta["keyword"] : null;
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
    } elseif($node == "advertise") {
        $advertiseLeft = isset($nodeAdvertise["left"]) && !empty($nodeAdvertise["left"]) ? $nodeAdvertise["left"] : null;
        $advertisePopup = isset($nodeAdvertise["popup"]) && !empty($nodeAdvertise["popup"]) ? $nodeAdvertise["popup"] : null;
        $advertiseRight = isset($nodeAdvertise["right"]) && !empty($nodeAdvertise["right"]) ? $nodeAdvertise["right"] : null;
        $modeDesign = array(
            "eDesign" => array(
                "row"=>"row form-group",
                "left"=>"col-xs-12 col-sm-2 control-label",
                "right"=>"col-xs-12 col-sm-10",
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
                    "iLabel"=>$language["advertiseRight"],
                    "iName"=>"advertise.right",
                    "iValue"=>$advertiseRight,
                    "iTypeInput"=>"input",
                    "iTextarea"=>"true",
                    "iClass"=>"form-control mce-editor"
                ),
                array(
                    "iLabel"=>$language["advertisePopup"],
                    "iName"=>"advertise.popup",
                    "iValue"=>$advertisePopup,
                    "iTypeInput"=>"input",
                    "iTextarea"=>"true",
                    "iClass"=>"form-control mce-editor"
                ),
            ),
            "attrForm" => array(
                "class"=>"post-form form-horizontal"
            ),
            "button" => $listButton,
            "buttonClass"=>"row form-group"
        );
    } elseif($node == "column") {
        $columnLeft = isset($nodeColumn["left"]) && !empty($nodeColumn["left"]) ? $nodeColumn["left"] : null;
        $columnMain = isset($nodeColumn["main"]) && !empty($nodeColumn["main"]) ? $nodeColumn["main"] : null;
        $columnRight = isset($nodeColumn["right"]) && !empty($nodeColumn["right"]) ? $nodeColumn["right"] : null;
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
