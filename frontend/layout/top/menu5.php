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
    $strCustomMenuTemplate = isset($value["opl"]) && !empty($value["opl"]) ? $value["opl"]: null;

    if($strCustomMenuTemplate) {
        $strCustomMenuTemplate .= ' data-elm-data=\'{"id":"'.$value["id"].'","ti":"'.$value["ti"].'","link":"'.$link.'"}\'';
    }
    
    if(isset($value["sub"]) && $value["sub"]) {
        $stroption .= '<optgroup label="'.$value["ti"].'">';
        $stroption .= '<option value="'.$link.'">'.$value["ti"].'</option>';
        foreach ($value["sub"] as $key => $subItem) {
            $sublink = isset($subItem["link"]) && !empty($subItem["link"]) ? $subItem["link"]: "/".$subItem["url"] ;
            $strSubMenu .= '<li><a href="'.$sublink.'">'.$subItem["ti"].'</a></li>';
            $stroption .= '<option value="'.$sublink.'">'.$subItem["ti"].'</option>';

            if(isset($subItem["sub"]) && $subItem["sub"]) {
                foreach ($subItem["sub"] as $key => $subItem2) {
                    $sublink = isset($subItem2["link"]) && !empty($subItem2["link"]) ? $subItem2["link"]: "/".$subItem2["url"] ;

                }
            }
        }

        $strSubMenu = '<ul class="sub-menu">'.$strSubMenu.'</ul>';
        $strMenu .='<li '.$strCustomMenuTemplate.' class="menu-item menu-item-'.$value["id"].'"><a href="'.$link.'">'.$value["ti"].'</a><i class="fa fa-angle-down" data-closet-toggle-class="active" data-object="li"></i>'.$strSubMenu.'</li>';
        $stroption .= '</optgroup>';
    }
    else {
        $stroption .= '<option value="'.$link.'">'.$value["ti"].'</option>';
        $strMenu .='<li '.$strCustomMenuTemplate.' class="menu-item menu-item-'.$value["id"].'"><a href="'.$link.'">'.$value["ti"].'</a></li>';
    }
}
if(isset($strMenuConfig) && $strMenuConfig ) {
    echo $strMenuConfig;
} else {
?>
<div id="main-menu">
    <?='<div class="menu-link"><ul>'.$strMenu.'</ul></div>';?>
</div>
<?php
}
?>
