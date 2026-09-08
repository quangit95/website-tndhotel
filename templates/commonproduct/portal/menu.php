<?php
// doto make function menu after
$menuStructure = arrSearch($menuStructure, "ism==1");

usort($menuStructure, function($a, $b)
{
    return intval($a["so"]) > intval($b["so"]);
});

$strMenu="";
$stroption = "";
foreach ($menuStructure as $key => $value) {
    $strSubMenu = "";
    $strActive = null;
    $strSelected = null;
    if(isset($index_page) && $index_page == $value["id"]){
        $strActive = "active";
        $strSelected = "selected";
    }

    $link = isset($value["link"]) && !empty($value["link"]) ? $value["link"] : "/".$value["url"] ;
    if(isset($value["sub"]) && $value["sub"]) {
        $stroption .= '<optgroup label="'.$value["ti"].'">';
        $stroption .= '<option value="'.$link.'">'.$value["ti"].'</option>';
        foreach ($value["sub"] as $key => $subItem) {
            $sublink = isset($subItem["link"]) && !empty($subItem["link"]) ? $subItem["link"]: "/".$subItem["url"] ;
            $strSubMenu .= '<li><a href="'.$sublink.'"><i class="fa fa-angle-double-right"></i> '.$subItem["ti"].'</a></li>';
            $stroption .= '<option value="'.$sublink.'">'.$subItem["ti"].'</option>';

            if(isset($subItem["sub"]) && $subItem["sub"]) {
                foreach ($subItem["sub"] as $key => $subItem2) {
                    $sublink = isset($subItem2["link"]) && !empty($subItem2["link"]) ? $subItem2["link"]: "/".$subItem2["url"] ;

                }
            }
        }

        $strSubMenu = '<ul class="sub-menu">'.$strSubMenu.'</ul>';
        $strMenu .='<li class="menu-item-'.$value["id"].'"><a href="'.$link.'">'.$value["ti"].'<i class="fa fa-angle-down"></i></a>'.$strSubMenu.'</li>';
        $stroption .= '</optgroup>';
    }
    else {
        $stroption .= '<option value="'.$link.'">'.$value["ti"].'</option>';
        $strMenu .='<li  class="menu-item-'.$value["id"].'"><a href="'.$link.'">'.$value["ti"].'</a></li>';
    }
}
if(isset($strMenuConfig) && $strMenuConfig ) {
    echo $strMenuConfig;
} else {
?>
<div id="main-menu">
    <div class="container">
        <div class="hidden-md hidden-lg">
            <div class="row">
                <div class="col-xs-2">
                    <div>
                        <span
                            data-object="#main-menu"
                            data-closet-toggle-class="mobile-active">
                            <span class="fa fa-navicon fa-2x">&nbsp;</span>
                        </span>
                    </div>
                </div>
                <div class="col-xs-10">
                    <div class="hotline text-right">
                        <a class="fa fa-shopping-basket" href="/orders"></a> <a href="tel:<?=$socialHotline?>"><i class="fa fa-phone"></i> <em><?=$socialHotline?></em></a>
                    </div>
                </div>
            </div>
        </div>
        <?='<div class="hidden-xs hidden-sm desktop-menu"><ul>'.$strMenu.'</ul></div>';?>
        <div class="mobile-menu hidden-md hidden-lg" data-copy-obj=".desktop-menu > ul"></div>
        <div class="hidden hidden-sm hidden-md hidden-lg form-group" style="padding-bottom:10px;">
            <select data-option-goto-link class="form-control" ><?=$stroption?></select>
        </div>
    </div>
</div>
<?php
}
?>
