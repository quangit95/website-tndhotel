<?php
if(isset($menuTable) && !empty($menuTable)) {
    $bannerSlide = arrSearch($menuTable, "st==3");
}
# $column["main"] = null;
function main() {
    global $seo_name, $language, $menuTable, $pageInfo, $informationConfig, $customResponsiveDefault, $strItemTemplate;
    $about = isset($informationConfig["config"]["about"])? $informationConfig["config"]["about"]:null;

    if(isset($about["customDescription"]) && !empty($about["customDescription"])) {
        echo $about["customDescription"];
    } else {

        echo isset($about["description"]) && !empty($about["description"]) ? $about["description"]:null;
        if(!empty($menuTable)) {
            $homeCat = arrSearch($menuTable, "st==4");
            # $homeCat = arrSearch($homeCat, "opp==3");
            usort($homeCat, function($a, $b)
            {
                return intval($a["so"]) > intval($b["so"]);
            });
        }

        if(isset($homeCat) && $homeCat) {
            $strProductHome = null;
            $strBlogHome = null;


            foreach ($homeCat as $key => $value) {
                $className = "view-items-{$value["id"]}";
                $customclassName = isset($value["clc"])&& !empty($value["clc"])?$value["clc"]: "layout-square";
                $customResponsive = isset($value["clr"])&& !empty($value["clr"])?$value["clr"]: $customResponsiveDefault;
                $linkFriendly = '/'.preg_replace('/[^a-zA-Z0-9]+/', '-', trim(strtolower(endcode_vn($value["ti"]))) );
                $tmpTitle = '<span>'.$value["ti"].'</span> ';
                $strFilter = '[{"name":"cat","value":"'.$value["id"].'","compare":"in"},{"name":"st","value":"4","compare":"equal"}]';
                if(isset($value["ti1"]) && !empty($value["ti1"])) {
                    $tmpTitle .=$value["ti1"];
                }
                $listCatChildId = [];
                if($value["opp"]==3) {
                    $listCatChildId[]=$value["id"];
                    $strParamCat = '{"cat":"'.implode(',', $listCatChildId).'", "st":"4"}';
                    if($value["pa"] == 0) {
                        $listCatChild = arrSearch($menuTable, "pa=={$value["id"]}");
                        foreach ($listCatChild as $key => $value) {
                            $listCatChildId[]=$value["id"];
                        }
                        $strFilter = '[{"name":"cat","value":",'.implode(',', $listCatChildId).',","compare":"checkin"},{"name":"st","value":"4","compare":"equal"}]';
                    }

                    $strProductHome .=' <div class="item-view-products '.$customclassName.' product-category-id-'.$value["id"].'"
                        data-view-list-by-handlebar
                        data-init-button-magic=".item [data-button-magic]"
                        data-init-object="localProductList"
                        data-url="'.APIGETPRODUCT.'"
                        data-params=\''.$strParamCat.'\'
                        data-filter-init=\''.$strFilter.'\'
                        data-method="get"
                        data-show-page="10"
                        data-show-item="24"
                        data-show-all="false"
                        data-scroll-view="false"
                        data-object-reverse="false"
                        data-str-sort="so=1"
                        data-template-id="'.$strItemTemplate["product"].'" >
                        <div class="title">
                            <h2>'.$tmpTitle.'</h2>
                        </div>
                        <div class="view-items"
                            data-center-items
                            data-space-item="[20,20]"
                            data-space-max="[30,30]"
                            data-class-name="'.$className.'"
                            data-item-class=".item"
                            data-content
                            data-responsive="true"
                            data-items-custom="'.$customResponsive.'"><div class="style-loadding"></div></div>
                    </div><div class="clearfix"></div>';

                } elseif($value["opp"]==2){
                    $strBlogHome .='<div class="col-xs-12 col-sm-6"> <div class="item-view-blogs"
                        data-view-list-by-handlebar
                        data-init-button-magic=".item [data-button-magic]"
                        data-init-object="localBlogList"
                        data-url="'.APIGETBLOG.'"
                        data-params=\'{"cat":'.$value["id"].', "st":"4"}\'
                        data-method="get"
                        data-show-page="10"
                        data-show-item="24"
                        data-show-all="false"
                        data-scroll-view="false"
                        data-object-reverse="false"
                        data-str-sort="so=1"
                        data-filter-init=\''.$strFilter.'\'
                        data-template-id="entryItemBlogViewTitle" >
                        <div class="title">
                            <h2>'.$tmpTitle.'</h2>
                            <div class="menu-img"><img class="full-width" src="/'.(isset($value["im"]) ? (FOLDERIMAGEMENU.$value["im"]) :"images/transparent.png").'"></div>
                        </div>
                        <div class="view-items" data-content><div class="style-loadding"></div></div>
                    </div></div>';
                }
            }
            echo '<div class="row home-blog-selected">'.$strBlogHome.'<div class="clearfix"></div></div>';
            echo $strProductHome;
        }
    }
}
