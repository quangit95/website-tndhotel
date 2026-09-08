<?php
# check page id
$fileConfig = FOLDERHOME . "config.xml";
$informationConfig = null;
if (is_file($fileConfig)) {
    $informationConfig = simplexml_load_file($fileConfig);
    $informationConfig = json_encode($informationConfig);
    $informationConfig = json_decode($informationConfig, true);
}

$pageMenu = null;
$menuTable = array();
$fileMenu = FOLDERMENU . "menu.xml";
$menuList = array();
$menuRoot = array();
$menuStructure = array();
$sitebyPhone = "0378642642";
$sitebyName = "Phpvnn";
$strItemTemplate = ["product"=>"entryViewProduct","blog"=>"entryItemBlogView"];

if(isset($informationWebsite["template"]["tmpItemProduct"]) && !empty($informationWebsite["template"]["tmpItemProduct"])) {
    $strItemTemplate["product"] = $informationWebsite["template"]["tmpItemProduct"];
}

if(isset($informationWebsite["template"]["tmpItemBlog"]) && !empty($informationWebsite["template"]["tmpItemBlog"])) {
    $strItemTemplate["blog"] = $informationWebsite["template"]["tmpItemBlog"];
}

$strLogoWebsite = "img/logo.png";
$strSiteby = '<p class="copyright">TND Hotel Nha Trang</p>';



if (is_file($fileMenu)) {
    $menuTable = simplexml_load_file($fileMenu);
    $menuTable = json_encode($menuTable);
    $menuTable = json_decode($menuTable, true);
    $menuTable = $menuTable["table"];
    $menuTable = arrSearch($menuTable, "st>=2");

    usort($menuTable, function($a, $b)
    {
        return intval($a["so"] ?? 0) <=> intval($b["so"] ?? 0);
    });


    if($multiLanguage) {
        # $langcode
        if($menuTable) {
            foreach ($menuTable as $key => $value) {
                $menuTable[$key]["ti"] = isset($menuTable[$key]["ti"]["$langcode"]) ? $menuTable[$key]["ti"]["$langcode"] : null;
                $menuTable[$key]["ti1"] = isset($menuTable[$key]["ti1"]["$langcode"]) ? $menuTable[$key]["ti1"]["$langcode"] : null;
                $menuTable[$key]["ct"] = isset($menuTable[$key]["ct"]["$langcode"]) ? $menuTable[$key]["ct"]["$langcode"] : null;
                $menuTable[$key]["url"] = $langcode."/".$menuTable[$key]["url"];
            }
        }

        if(isset($informationConfig["filterproperties"]) && $informationConfig["filterproperties"]) {
            foreach ($informationConfig["filterproperties"] as $key => $value) {
                $informationConfig["filterproperties"][$key]["ti"] = isset($informationConfig["filterproperties"][$key]["ti"]["$langcode"]) ? $informationConfig["filterproperties"][$key]["ti"]["$langcode"] : null;
                $informationConfig["filterproperties"][$key]["note"] = isset($informationConfig["filterproperties"][$key]["note"]["$langcode"]) ? $informationConfig["filterproperties"][$key]["note"]["$langcode"] : null;
            }
        }

        if(isset($informationConfig["config"]["order"][$langcode])) {
            foreach ($informationConfig["config"]["order"][$langcode] as $key => $value) {
                $informationConfig["config"]["order"][$key] = isset($informationConfig["config"]["order"][$langcode][$key]) ? $informationConfig["config"]["order"][$langcode][$key] : null;
            }
        }
        $language["multiLanguage"] = $multiLanguage;
        $language["languageCode"] = $langcode;
    }

    if($menuTable) {
        foreach ($menuTable as $key => $value) {
            if(is_array($value["ti"])) {
                $value["ti"] = array_values($value["ti"])[0];
                $menuTable[$key]["ti"] = $value["ti"];
            }
            $menuList[intval($value["id"])] = isset($value["ti"]) ? $value["ti"]:null;
            if(isset($url_data[0]) && isset($value["url"]) ) {
                if($multiLanguage && $value["url"] == $langcode.'/'.$url_data[0]) {
                    $pageMenu = $value;
                } elseif($value["url"] == $url_data[0]) {
                    $pageMenu = $value;
                }
            }
            if(isset($value["pa"]) && intval($value["pa"] == 0 )) {
                array_push($menuRoot, $value );
                $sub = arrSearch($menuTable, "pa=={$value["id"]}");
                $subMenu1 = array();
                if($sub) {
                    foreach ($sub as $k => $v) {
                        $sub1 = arrSearch($menuTable, "pa=={$v["id"]}");
                        if($sub1) {
                            $subMenu2 = array();
                            foreach ($sub1 as $m=>$n ) {
                                $sub2 = arrSearch($menuTable, "pa=={$n["id"]}");
                                if($sub2) {
                                    $subMenu3 = array();
                                    foreach ($sub2 as $e=>$f ) {
                                        $sub3 = arrSearch($menuTable, "pa=={$f["id"]}");
                                        if($sub3) {
                                            $subMenu4 = array();
                                            foreach ($sub3 as $k=>$l ) {
                                                $sub4 = arrSearch($menuTable, "pa=={$l["id"]}");
                                                if($sub4) {
                                                    $subMenu5 = array();
                                                    foreach ($sub4 as $x=>$y ) {
                                                        array_push($subMenu5, $y );
                                                    }
                                                    $l["sub"] = $subMenu5;
                                                }
                                                array_push($subMenu4, $l );
                                            }
                                            $f["sub"] = $subMenu4;
                                        }
                                        array_push($subMenu3, $f );
                                    }
                                    $n["sub"] = $subMenu3;
                                }
                                array_push($subMenu2, $n );
                            }
                            $v["sub"] = $subMenu2;
                        }
                        array_push($subMenu1, $v );
                    }
                    $value["sub"]= $subMenu1;
                }
                array_push($menuStructure, $value );
            }
        }
    }
}

unset($subMenu1, $subMenu2, $subMenu3, $subMenu4, $subMenu5);


$language["dropdownLocalOption"]["menuList"] = $menuList;
$language["dropdownLocalOption"]["menuRoot"] = $menuRoot;
$language["dropdownLocalOption"]["menuStructure"] = $menuStructure;
$language["dropdownLocalOption"]["menuTable"] = $menuTable;

if(isset($informationConfig["filterproperties"]) && $informationConfig["filterproperties"]) {
    $filterProperties = $informationConfig["filterproperties"];
    usort($filterProperties, function($a, $b)
    {
        return intval($a["so"] ?? 0) <=> intval($b["so"] ?? 0);
    });

    $filterPropertiesStructure = [];

    $filterPropertiesRoot = array_filter($filterProperties, function ($obj) {
        return !isset($obj["pa"]) ? true : intval($obj["pa"])==0 ;
    });

    if($filterPropertiesRoot) {
        foreach ($filterPropertiesRoot as $k => $v) {
            $v["sub"] = arrSearch($filterProperties, "pa=={$v["id"]}");
            array_push($filterPropertiesStructure, $v );
        }
        $language["dropdownLocalOption"]["filterPropertiesStructure"] = $filterPropertiesStructure;
        unset($filterPropertiesStructure);
    }
}

if(isset($informationConfig["config"]["order"]["productinfo"]) && !empty($informationConfig["config"]["order"]["productinfo"])) {
    $language["orderProductinfo"] = $informationConfig["config"]["order"]["productinfo"];
}

if(isset($informationConfig["config"]["order"]["thankyou"]) && !empty($informationConfig["config"]["order"]["thankyou"])) {
    $language["orderThankyouContent"] = $informationConfig["config"]["order"]["thankyou"];
}

if(isset($informationConfig["config"]["order"]["empty"]) && !empty($informationConfig["config"]["order"]["empty"])) {
    $language["orderEmptyContent"] = $informationConfig["config"]["order"]["empty"];
}

if(isset($informationWebsite["template"]["boxchat"]) && $informationWebsite["template"]["boxchat"]) {
    $language["boxchatconfig"] = $informationWebsite["template"]["boxchat"];
}

if(isset($informationConfig) && !empty($informationConfig)) {
    $language["websiteConfigToJson"] = $informationConfig;
}

if(isset($informationConfig["config"]) && !empty($informationConfig["config"])) {
    $language["configWebsiteJson"] = $informationConfig["config"];
}


$language["urlProduct"] = $seo_name["page"]["product"];
$language["urlBlog"] = $seo_name["page"]["blog"];
$language["idOfWebsite"] = $websiteId;

if(isset($informationWebsite["template"]["minImage"]) && $informationWebsite["template"]["minImage"] == 2) {
    $language["hasMinImageAuto"] = 1;
}

$formatCurrency = ' data-format-currency data-currency="'.$language["currencyFormat"].'" data-format="'.$language["currencyPosition"].'"';

$customResponsiveDefault =  isset($informationWebsite["template"]["clr"]) && ! empty($informationWebsite["template"]["clr"])? $informationWebsite["template"]["clr"] : '[960, 4], [640, 3], [480,2], [320,1]';
$language["customResponsiveDefault"] = $customResponsiveDefault;

require "{$strDataFolderTemplate}website.php";
