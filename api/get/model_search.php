<?php
$listButton = array();

$dbAttr = isset($nodeDb["attr"]) ? $nodeDb["attr"] : null;

if(isset($language["dropdownLocalOption"]["filterPropertiesStructure"]) && count($language["dropdownLocalOption"]["filterPropertiesStructure"])) {

    $arrayPlus = array();

    foreach ($language["dropdownLocalOption"]["filterPropertiesStructure"] as $key => $value) {
        $searchType = isset($value["type"]) ? $value["type"] : null;
        $searchType = isset($value["typesearch"]) ? $value["typesearch"] : $searchType;

        if(isset($value["code"]) && $searchType ) {
            $strKeyNode = "attr";
            $strAttrNode = $strKeyNode.".".$value["code"];
            $strOptioned = isset($dbAttr[$value["code"]]) ? $dbAttr[$value["code"]]:null;
            $strNote = isset($value["note"]) && count($value["note"]) ? $value["note"]:null;
            $isRequired = isset($value["required"]) && count($value["required"]) ? $language["requireInput"]:null;

            if(isset($value["sub"]) && $value["sub"]) {
                $strAllPlus = array(
                        "id"=>"",
                        "ti"=> "x",
                    );

                if($searchType==1) {
                    array_unshift($value["sub"],$strAllPlus);
                    # array_push($value["sub"],$strAllPlus);
                    
                    array_push($arrayPlus, array(
                        "iLabel"=>$value["ti"],
                        "iClassCustom"=>"style-button group-search-id-".$value["id"],
                        "iNote"=>$strNote,
                        "iName"=>$strAttrNode,
                        "iTypeRadio"=>"radio",
                        "iAttr"=>'',
                        "iDesign"=>'<div class="radio-inline"><label class="radio"><input type="radio" data-key="'.$strKeyNode.'" data-key-node="'.$value["code"].'" name="'.$strAttrNode.'" value="{0}" {2} data-compare="equal"><span class="fa radio-style"></span><span>{1}</span></label> </div>',
                        "iList"=>$value["sub"],
                        "iKey"=>"id",
                        "iValue"=>"ti"
                    ));
                } elseif($searchType==2) {
                   array_push($arrayPlus,array(
                            "iLabel"=>$value["ti"],
                            "iClassCustom"=>"group-search-id-".$value["id"],
                            "iNote"=>$strNote,
                            "iName"=>$strAttrNode,
                            "iTypeDropdown"=>"dropdown",
                            "iAttr"=>array(
                                "type"=>"select-from-json",
                                "data-dropdown"=>"",
                                "data-compare"=>"equal",
                                "data-key"=>$strKeyNode,
                                "data-key-node"=>$value["code"],
                                "data-option-base-on-url"=>$strAttrNode,
                                "data-local-optiona"=>json_encode($value["sub"], true),
                                "data-object-init"=>"{\"id\":\"\", \"ti\":\"{$language["viewAll"]}\"}"
                            ),
                            "iClass"=>"form-control"
                    ));
                } elseif($searchType==3) {
                    array_push($arrayPlus, array(
                            "iLabel"=>$value["ti"],
                            "iClassCustom"=>"more-style-checkbox group-search-id-".$value["id"],
                            "iNote"=>$strNote,
                            "iName"=>$strAttrNode,
                            "iTypeCheckbox"=>"checkbox",
                            "iAttr"=>null,
                            "iDesign"=>'<div class="checkbox-inline"><label class="checkbox"><input type="checkbox" data-compare="checkin" data-key-name= "'.$strAttrNode.'-{0}"data-key="'.$strKeyNode.'" data-key-node="'.$value["code"].'" name="'.$strAttrNode.'" name="{3}.{0}" value="{0}" {2}><span class="fa checkbox-style"></span><span> {1}</span></label> </div>',
                            "iList"=>$value["sub"],
                            "iKey"=>"id",
                            "iValue"=>"ti",
                            "iKeyBox"=>$strAttrNode,
                            "iOptioned"=>$strOptioned
                    ));
                }
            } else {
                if($searchType==4) {
                    array_push($arrayPlus, array(
                            "iLabel"=>$value["ti"],
                            "iClassCustom"=>"group-search-id-".$value["id"],
                            "iNote"=>$strNote,
                            "iName"=>$strAttrNode,
                            "iValue"=>$strOptioned,
                            "iTypeInput"=>"input",
                            "iAttr"=> array(
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
        "left"=>"col-xs-12 col-sm-12 control-label",
        "right"=>"col-xs-12 col-sm-12",
    ),
    "eInputHidden" => array(
        
    ),
    "eForm" => array(
        
    ),
    "attrForm" => array(
        "class"=>"post-form form-filter"
    ),
    "button" => $listButton,
    "buttonClass"=>"row form-group"
);

array_splice($modeDesign["eForm"], 0, 0, $arrayPlus);

?>
