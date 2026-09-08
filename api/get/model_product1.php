<?php
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
    $dbTitleSecond = isset($nodeDb["ti1"]) ? $nodeDb["ti1"] : null;
    $dbTitleTag= isset($nodeDb["tag"]) ? $nodeDb["tag"] : null;
    $dbCat = isset($nodeDb["cat"]) ? $nodeDb["cat"] : null;
    $dbContent = isset($nodeDb["ct"]) ? $nodeDb["ct"] : null;
    $dbStatus = isset($nodeDb["st"]) ? $nodeDb["st"] : null;
    $dbSort = isset($nodeDb["so"]) ? $nodeDb["so"] : null;
    $dbPrice = isset($nodeDb["pr"]) ? $nodeDb["pr"] : null;
    $dbRating = isset($nodeDb["ra"]) ? $nodeDb["ra"] : null;
    $dbSoldOut = isset($nodeDb["su"]) ? $nodeDb["su"] : null;

    $dbAdd = isset($nodeDb["add"]) ? $nodeDb["add"] : null;
    $dbCit = isset($nodeDb["cit"]) ? $nodeDb["cit"] : null;
    $dbDis = isset($nodeDb["dis"]) ? $nodeDb["dis"] : null;
    $dbWard = isset($nodeDb["wid"]) ? $nodeDb["wid"] : null;


    $dbPbr = isset($nodeDb["pbr"]) ? $nodeDb["pbr"] : null;
    $dbPcl = isset($nodeDb["pcl"]) ? $nodeDb["pcl"] : null;
    $dbPcm = isset($nodeDb["pcm"]) ? $nodeDb["pcm"] : null;

    $priceSale = isset($dbPrice["sale"]) && !empty($dbPrice["sale"]) ? intval($dbPrice["sale"]) : 0;
    $priceOff = isset($dbPrice["off"]) && !empty($dbPrice["off"]) ? intval($dbPrice["off"]) : null;

    if($dbId) {
        $listButton[0]["iAttr"]["data-refress-list"] = ".item-view-more";
    } else {
        $listButton[0]["iAttr"]["data-redirect"] = ".";
    }

    $groupTitle = [];
    $groupTitle1 = [];
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
        array_push($groupTitle1, [
            "iName"=>"db.ti1.{$key}",
            "iValue"=>isset($dbTitleSecond[$key]) && !empty($dbTitleSecond[$key]) ? $dbTitleSecond[$key] : null,
            "iTypeInput"=>"input",
            "iAttr"=>[
                "placeholder"=>$key,
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
                "iLabel"=>$language["titleSecond"],
                "groupClass"=>"row",
                "groupInput"=>$groupTitle1,
                "iClassCustom"=>"init-none product-second-title",
            ),
            array(
                "iLabel"=>$language["shortContent"],
                "groupClass"=>"row",
                "groupInput"=>$groupContent,
            ),
            array(
                "iLabel"=>$language["tag"],
                "iName"=>"db.tag",
                "iValue"=>$dbTitleTag,
                "iTypeInput"=>"input",
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
                "iLabel"=>$language["priceSale"],
                "iName"=>"db.pr.sale",
                "iValue"=>$priceSale,
                "iTypeInput"=>"input",
                "iAttr"=>array(
                    "data-required"=>$language["requireInput"],
                    "onchange"=>" $(this).val(Site.numberWithCommas($(this).val(),',')); ",
                    "onkeyup"=>" if (event.which == 46 || (event.which >= 48 && event.which <= 57) ) {  $(this).val(Site.numberWithCommas($(this).val(),',')); } else if(event.which ==13) { $(this).trigger('change'); }",
                    "onkeypress"=>"return (event.charCode == 46 || (event.charCode >= 48 && event.charCode <= 57) ) || (event.charCode >= 37 && event.charCode <= 40) || event.charCode===0 "
                ),
                "iClass"=>"form-control"
            ),
            array(
                "iLabel"=>$language["priceOff"],
                "iName"=>"db.pr.off",
                "iValue"=>$priceOff,
                "iTypeInput"=>"input",
                "iAttr"=>array(
                    "data-required"=>$language["requireInput"],
                    "onchange"=>" $(this).val(Site.numberWithCommas($(this).val(),',')); ",
                    "onkeyup"=>" if (event.which == 46 || (event.which >= 48 && event.which <= 57) ) {  $(this).val(Site.numberWithCommas($(this).val(),',')); } else if(event.which ==13) { $(this).trigger('change'); }",
                    "onkeypress"=>"return (event.charCode == 46 || (event.charCode >= 48 && event.charCode <= 57) ) || (event.charCode >= 37 && event.charCode <= 40) || event.charCode===0 "
                ),
                "iClass"=>"form-control"
            ),
            array(
                "iLabel"=>$language["soldOut"],
                "iName"=>"db.su",
                "iTypeRadio"=>"radio",
                "iOptioned"=>$dbSoldOut,
                "iAttr"=>'data-validates data-pattern-message="invalid option" data-hidden-message="true" ',
                "iDesign"=>'<div class="radio-inline radio-text col-xs-3 col-sm-2"><label class="radio"><input type="radio" name="db.su" value="{0}" {2}><span class="fa radio-style"></span><span class="i-center">{1}</span></label> </div>',
                "iList"=>"yesNoQuestion",
                "iClassCustom"=>"init-none product-soldout"
            ),
            array(
                "iLabel"=>"rating",
                "iName"=>"db.ra",
                "iValue"=>$dbRating,
                "iTypeInput"=>"number",
                "iPlaceholder"=>"",
                "iClassCustom"=>"init-none rating-block",
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

    if(isset($informationWebsite["backendConfig"]["productLocation"]) && $informationWebsite["backendConfig"]["productLocation"] == 2) {

        $productLocation = array(
            array(
                #"iLabel"=>$language["city"],
                "iName"=>"db.cit",
                "iValue"=>$dbCit,
                "iTypeDropdown"=>"dropdown",
                "iAttr"=>array(
                    "data-validate"=>"",
                    "data-dropdown"=>"",
                    "data-required"=>$language["requireInput"],
                    "data-index-value"=>$dbCit ? $dbCit : (isset($informationWebsite["db"]["city"]) ? $informationWebsite["db"]["city"] : null),
                    "data-str-key"=>"id",
                    "data-str-value"=>"ti",
                    "data-key-sort"=>"ti",
                    "data-dropdown-relative"=>"db.dis",
                    "data-params"=>"cid=",
                    "data-option-from-json"=>APIGETCITY,
                    "data-local-optiona"=>"city",
                    "data-object-init"=>"{\"id\":\"\", \"ti\":\"{$language["city"]}\"}"
                ),
                "gClass"=>"col-xs-4 col-sm-4 mb-10",
                "iClass"=>"form-control"
            ),
            array(
                #"iLabel"=>$language["district"],
                "iName"=>"db.dis",
                "iValue"=>$dbDis,
                "iTypeDropdown"=>"dropdown",
                "iAttr"=>array(
                    "data-dropdown-relative"=>"db.wid",
                    "data-validate"=>"",
                    "data-dropdown"=>"",
                    "data-params-relative"=>"did={$dbDis}",
                    "data-index-value"=>$dbDis,
                    "data-str-key"=>"id",
                    "data-str-value"=>"ti",
                    "data-key-sort"=>"ti",
                    "data-option-from-json"=>APIGETDISTRICT,
                    "data-local-optiona"=>"district",
                    "data-object-init"=>"{\"id\":\"\", \"ti\":\"{$language["district"]}\"}"
                ),
                "gClass"=>"col-xs-4 col-sm-4 mb-10",
                "iClass"=>"form-control"
            ),
            array(
                // "iLabel"=>$language["ward"],
                "iName"=>"db.wid",
                "iTypeDropdown"=>"dropdown",
                "iAttr"=>array(
                    "data-validate"=>"",
                    "data-dropdown"=>"",
                    "data-required"=>$language["requireInput"],
                    "data-index-value"=>$dbWard,
                    "data-str-key"=>"id",
                    "data-str-value"=>"ti",
                    "data-params"=>"did={$dbDis}",
                    "data-option-from-json"=>"api/get/ward?did={$dbDis}",
                    "data-object-init"=>"{\"id\":\"\", \"ti\":\"{$language["ward"]}\"}"
                ),
                "gClass"=>"col-xs-4 col-sm-4 mb-10",
                "iClass"=>"form-control"
            ),
            array(
                #"iLabel"=>$language["address"],
                "iName"=>"db.add",
                "iValue"=>$dbAdd,
                "iTypeInput"=>"input",
                "iAttr"=>array(
                   "placeholder"=> $language["address"],
                ),
                "gClass"=>"col-xs-12 col-sm-12",
                "iClass"=>"form-control"
            )
        );
        array_push($arrayPlus, array(
                "iLabel"=>$language["address"],
                "groupClass"=>"row",
                "groupInput"=>$productLocation,
            ));
    }

    if(isset($informationWebsite["backendConfig"]["productBrand"]) && $informationWebsite["backendConfig"]["productBrand"] == 2) {

        $productClass = array(
            array(
                "iName"=>"db.pbr",
                "iValue"=>"",
                "iTypeDropdown"=>"dropdown",
                "iAttr"=>array(
                    "data-dropdown"=>"",
                    "data-required"=>"require",
                    "data-index-value"=>$dbPbr,
                    "data-str-key"=>"id",
                    "data-str-value"=>"ti",
                    "data-key-sort"=>"ti",
                    "data-local-optiona"=>"productBrand",
                    "data-object-init"=>"{\"id\":\"\", \"ti\":\"Brand\"}"
                ),
                "gClass"=>"col-xs-12",
                "iClass"=>"form-control"
            )
        );
        array_push($arrayPlus, array(
                "iLabel"=>"Product Brand",
                "groupClass"=>"row",
                "groupInput"=>$productClass,
            ));
    }

    if(isset($informationWebsite["backendConfig"]["productClass"]) && $informationWebsite["backendConfig"]["productClass"] == 2) {

        $productClass = array(
            array(
                "iName"=>"db.pcl",
                "iValue"=>"",
                "iTypeDropdown"=>"dropdown",
                "iAttr"=>array(
                    "data-dropdown"=>"",
                    "data-required"=>"require",
                    "data-index-value"=>$dbPcl,
                    "data-str-key"=>"id",
                    "data-str-value"=>"ti",
                    "data-key-sort"=>"ti",
                    "data-dropdown-relative"=>"productModellist",
                    "data-params"=>"pcl=",
                    "data-local-optiona"=>"productClass",
                    "data-object-init"=>"{\"id\":\"\", \"ti\":\"class\"}"
                ),
                "gClass"=>"col-xs-4",
                "iClass"=>"form-control"
            ),
            array(
                "iName"=>"productModellist",
                "iValue"=>"",
                "iTypeDropdown"=>"dropdown",
                "multiOption"=>"multiselect-model",
                "iAttr"=>array(
                    "data-dropdown"=>"",
                    "data-multiselect-box"=>"",
                    "data-multi-selected"=>$dbPcm,
                    "data-target-append"=>".multiselect-model",
                    "data-index-value"=>$dbPcm,
                    "type"=>"select-from-json",
                    "data-key-name"=>"db.pcm",
                    "data-str-key"=>"id",
                    "data-str-value"=>"ti",
                    "data-key-sort"=>"ti",
                    "data-local-optiona"=>"productClassModel",
                    "data-object-init"=>"{\"id\":\"\", \"ti\":\"Class Model\"}"
                ),
                "gClass"=>"col-xs-8",
                "iClass"=>"form-control"
            )
        );
        array_push($arrayPlus, array(
                "iLabel"=>"Product Class",
                "groupClass"=>"row",
                "groupInput"=>$productClass,
            ));
    }

    if(!empty($arrayPlus)) {
        array_splice($modeDesign["eForm"], 4, 0, $arrayPlus);
    }

} elseif($node == "more") {
    $listButton[0]["iClassCustom"] = "col-xs-4 col-sm-2";
    $groupDescription = [];
    $groupContent = [];
    $moreDisplaySlide = isset($nodeMore["isShowSlide"]) ? $nodeMore["isShowSlide"] : null;
    $moreYoutubeId = isset($nodeMore["youtubeId"]) && !empty($nodeMore["youtubeId"]) ? $nodeMore["youtubeId"] : null;

    foreach ($multiLanguage as $key => $value) {
        array_push($groupDescription, [
            "iLabel"=>"{$language["description"]} ({$key})",
            "iName"=>"more.{$key}.description",
            "iValue"=>isset($nodeMore[$key]["description"]) ? $nodeMore[$key]["description"] : null,
            "iTypeInput"=>"input",
            "iTextarea"=>"true",
            "gClass"=>"col-xs-12 mb-10",
            "iClass"=>"form-control mce-editor"
        ]);
        array_push($groupContent, [
            "iLabel"=>"{$language["shortContent"]} ({$key})",
            "iName"=>"more.{$key}.content",
            "iValue"=>isset($nodeMore[$key]["content"]) ? $nodeMore[$key]["content"] : null,
            "iTypeInput"=>"input",
            "iTextarea"=>"true",
            "gClass"=>"col-xs-12 mb-10",
            "iClass"=>"form-control mce-editor"
        ]);
    }

    $modeDesign = array(
        "eDesign" => array(
            "row"=>"row form-group",
            "left"=>"col-xs-12 col-sm-12 control-label hidden",
            "right"=>"col-xs-12 col-sm-12",
        ),
        "eInputHidden" => $inputHidden,
        "eForm" => array(
            array(
                "iLabel"=>$language["shortContent"],
                "groupClass"=>"row",
                "groupInput"=>$groupContent,
            ),
            array(
                "iLabel"=>$language["description"],
                "groupClass"=>"row",
                "groupInput"=>$groupDescription,
            ),
            array(
                "iLabel"=>"Youtube Video Id",
                "iName"=>"more.youtubeId",
                "iValue"=>$moreYoutubeId,
                "iTypeInput"=>"input",
                "iPlaceholder"=>"Youtube Video Id",
                "iClass"=>"form-control",
                "iClassCustom"=>"init-none youtube-video-id-product-block"
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
        ),
        "attrForm" => array(
            "class"=>"post-form"
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
} elseif($node == "advertise") {
    $advertiseLeft = isset($nodeAdvertise["left"]) ? $nodeAdvertise["left"] : null;
    $advertisePopup = isset($nodeAdvertise["popup"]) ? $nodeAdvertise["popup"] : null;
    $advertiseRight = isset($nodeAdvertise["right"]) ? $nodeAdvertise["right"] : null;
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
    $columnLeft = isset($nodeColumn["left"]) && count($nodeColumn["left"]) ? $nodeColumn["left"] : null;
    $columnMain = isset($nodeColumn["main"]) && count($nodeColumn["main"]) ? $nodeColumn["main"] : null;
    $columnRight = isset($nodeColumn["right"]) && count($nodeColumn["right"]) ? $nodeColumn["right"] : null;
    $modeDesign = array(
        "eDesign" => array(
            "row"=>"row form-group",
            "left"=>"col-xs-12 col-sm-2 control-label",
            "right"=>"col-xs-12 col-sm-10",
        ),
        "eInputHidden" => $inputHidden,
        "eForm" => array(
            array(
                "iLabel"=>"{$language["left"]}",
                "iName"=>"column.left",
                "iValue"=>"{$columnLeft}",
                "iTypeInput"=>"input",
                "iClass"=>"form-control"
            ),
            array(
                "iLabel"=>"{$language["main"]}",
                "iName"=>"column.main",
                "iValue"=>"{$columnMain}",
                "iTypeInput"=>"input",
                "iClass"=>"form-control"
            ),
            array(
                "iLabel"=>"{$language["right"]}",
                "iName"=>"column.right",
                "iValue"=>"{$columnRight}",
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
} elseif($node == "attr") {

    $dbAttr = isset($nodeDb["attr"]) ? $nodeDb["attr"] : null;
    $inputHidden[0]["value"]="db";
    $inputHidden[1]["name"]="db.id";

    if(isset($language["dropdownLocalOption"]["filterPropertiesStructure"]) && count($language["dropdownLocalOption"]["filterPropertiesStructure"])) {

        $arrayPlus = array();

        foreach ($language["dropdownLocalOption"]["filterPropertiesStructure"] as $key => $value) {
            if(isset($value["code"]) && isset($value["type"]) ) {

                $strAttrNode = "db.attr.".$value["code"];
                $strOptioned = isset($dbAttr[$value["code"]]) ? $dbAttr[$value["code"]]:null;
                $strNote = isset($value["note"]) && count($value["note"]) ? $value["note"]:null;

                $isRequired = isset($value["required"]) && $value["required"] == 2 ? $language["requireInput"]:null;

                if(isset($value["sub"]) && $value["sub"]) {

                    if($value["type"]==1) {
                        array_push($arrayPlus, array(
                            "iLabel"=>$value["ti"],
                            "iClassCustom"=>"style-button",
                            "iNote"=>$strNote,
                            "iName"=>$strAttrNode,
                            "iTypeRadio"=>"radio",
                            "iAttr"=>'',
                            "iDesign"=>'<div class="radio-inline"><label class="radio"><input type="radio" name="'.$strAttrNode.'" value="{0}" {2} data-validate data-required="'.$isRequired.'" data-hidden-message="true"><span class="fa radio-style"></span><span>{1}</span></label> </div>',
                            "iList"=>$value["sub"],
                            "iKey"=>"id",
                            "iValue"=>"ti",
                            "iOptioned"=>$strOptioned
                        ));
                    } elseif($value["type"]==2) {
                       array_push($arrayPlus,array(
                                "iLabel"=>$value["ti"],
                                "iNote"=>$strNote,
                                "iName"=>$strAttrNode,
                                "iTypeDropdown"=>"dropdown",
                                "iAttr"=>array(
                                    "type"=>"select-from-json",
                                    "data-validate"=>"",
                                    "data-hidden-message"=>"true",
                                    "data-required"=>$isRequired,
                                    "data-dropdown"=>"",
                                    "data-index-value"=>$strOptioned,
                                    "data-local-optiona"=>json_encode($value["sub"], true),
                                    "data-object-init"=>"{\"id\":\"\", \"ti\":\"{$value["ti"]}\"}"
                                ),
                                "iClass"=>"form-control"
                        ));
                    } elseif($value["type"]==3) {
                        array_push($arrayPlus, array(
                                "iLabel"=>$value["ti"],
                                "iNote"=>$strNote,
                                "iName"=>$strAttrNode,
                                "iTypeCheckbox"=>"checkbox",
                                "iAttr"=>'data-validate data-required="'.$isRequired.'" data-hidden-message="true" type="checkbox" ',
                                "iDesign"=>'<div class="checkbox-inline"><label class="checkbox"><input type="checkbox" name="{3}.{0}" data-key="{3}" value="{0}" {2}><span class="fa checkbox-style"></span><span> {1}</span></label> </div>',
                                "iList"=>$value["sub"],
                                "iKey"=>"id",
                                "iValue"=>"ti",
                                "iKeyBox"=>$strAttrNode,
                                "iOptioned"=>$strOptioned
                        ));
                    }
                } else {
                    if($value["type"]==4) {
                        array_push($arrayPlus, array(
                                "iLabel"=>$value["ti"],
                                "iNote"=>$strNote,
                                "iName"=>$strAttrNode,
                                "iValue"=>$strOptioned,
                                "iTypeInput"=>"input",
                                "iAttr"=> array(
                                    "data-validate"=>"",
                                    "data-hidden-message"=>"true",
                                    "data-required"=>$isRequired,
                                ),
                                "iPlaceholder"=>"",
                                "iClass"=>"form-control"
                        ));
                    }
                }


            }
        }

    }
    $modeDesign = array(
        "eDesign" => array(
            "row"=>"row form-group",
            "left"=>"col-xs-12 col-sm-2 control-label",
            "right"=>"col-xs-12 col-sm-10",
        ),
        "eInputHidden" => $inputHidden,
        "eForm" => array(

        ),
        "attrForm" => array(
            "class"=>"post-form form-horizontal"
        ),
        "button" => $listButton,
        "buttonClass"=>"row form-group"
    );

    array_splice($modeDesign["eForm"], 0, 0, $arrayPlus);

} elseif($node == "pl") {
    $listButton[0]["iClassCustom"] = "col-sm-offset-2 col-xs-6 col-sm-5";
    $listButton[0]["iAttr"]["data-view-template-from-element"] = ".product-pricelist.in";



    $strButtonPlus = array(
        array(
            "iClassCustom"=>"col-xs-6 col-sm-5",
            "iLabel"=> '<span>'.$language["btnCancel"].'</span>',
            "iAttr"=> array(
                "data-button-magic"=>"",
                "data-view-template-local"=>"true",
                "data-view-template"=>".form-update-price-list",
                "data-template-id"=>"entryEmptyBlock",
                "class"=>"btn btn-block btn-default text-uppercase"
            )
        )
    );

    array_splice($listButton, 1, 0, $strButtonPlus);
    $plId = isset($_GET["plid"])? $_GET["plid"] : null;
    if($plId) {
        $rowPrice = isset($nodeDb["pl"]["id_{$plId}"]) ? $nodeDb["pl"]["id_{$plId}"] : null;
    }

    $dbTitle = isset($nodeDb["ti"]) && count($nodeDb["ti"]) ? $nodeDb["ti"] : null;

    $priceTitle = isset($rowPrice["ti"]) && count($rowPrice["ti"]) ? $rowPrice["ti"] : null;
    $priceId = isset($rowPrice["id"]) && count($rowPrice["id"]) ? $rowPrice["id"] : null;
    $priceValue = isset($rowPrice["pr"]) && count($rowPrice["pr"]) ? $rowPrice["pr"] : null;




    if(!$dbTitle) {
        $listButton[0]["iLabel"] = $language["btnAdd"];
    }

    $modeDesign = array(
        "modals" => array(
            "title"=>"Giá đặc sản phẩm: {$dbTitle}",
            "close"=>"[data-quick-view-item1]",
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
                "data-required"=>$language["requireInput"]
            ),
            array(
                "type"=>"hidden",
                "name"=>"db.id",
                "value"=>$dbId
            ),
            array(
                "type"=>"hidden",
                "name"=>"db.pl.id",
                "value"=>$priceId
            ),
        ),
        "eForm" => array(
            array(
                "iLabel"=>$language["title"],
                "iName"=>"db.pl.ti",
                "iValue"=>$priceTitle,
                "iTypeInput"=>"input",
                "iAttr"=> array(
                    "data-validate"=>"",
                    "data-required"=>$language["requireInput"],
                ),
                "iPlaceholder"=>"",
                "iClass"=>"form-control"
            ),
            array(
                "iLabel"=>$language["price"],
                "iName"=>"db.pl.pr",
                "iValue"=>$priceValue,
                "iTypeInput"=>"input",
                "iAttr"=>array(
                    "data-required"=>$language["requireInput"],
                    "onchange"=>" $(this).val(Site.numberWithCommas($(this).val(),',')); ",
                    "onkeyup"=>" if (event.which == 46 || (event.which >= 48 && event.which <= 57) ) {  $(this).val(Site.numberWithCommas($(this).val(),',')); } else if(event.which ==13) { $(this).trigger('change'); }",
                    "onkeypress"=>"return (event.charCode == 46 || (event.charCode >= 48 && event.charCode <= 57) ) || (event.charCode >= 37 && event.charCode <= 40) || event.charCode===0 "
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
}
