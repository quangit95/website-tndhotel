<div id="header" class="relative">
    <?php
    if(isset($strHeader2) && $strHeader2){
        echo $strHeader2;
    }
    else {
    ?>
    <div class="container">
        <div class="hidden-sm hidden-md hidden-lg icon-menu text-right">
            <div
                data-object=".website"
                data-closet-toggle-class="mobile-active">
                <strong>MENU</strong> <span class="fa fa-navicon fa-2x">&nbsp;</span>
            </div>
            <div
                data-object=".website"
                data-closet-toggle-class="mobile-active">
                <span class="fa fa-close fa-2x">&nbsp;</span>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12 col-sm-2 col-md-3">
                <div class="logo">
                    <a href="/">
                        <img src="<?="/".$strLogoWebsite?>" alt="<?=$informationWebsite["db"]["name"]?>">
                    </a>
                </div>
            </div>
            <div class="col-xs-12 col-sm-10 col-md-9">
                <?php
                if(isset($strHeader1) && $strHeader1 ) {
                    echo $strHeader1;
                } else {
                    echo '<div class="top-bar hidden-xs"><a href="tel:'.$informationWebsite["db"]["phone"].'"><span class="fa fa-phone"></span> '.$informationWebsite["db"]["phone"].'</a></div>';
                }
                // doto make function menu after
                $menuStructure = arrSearch($menuStructure, "ism==1");
                usort($menuStructure, function($a, $b)
                {
                    return intval($a["so"] ?? 0) <=> intval($b["so"] ?? 0);
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

                    $link = !empty($link)? $link: "#";

                    if(isset($value["sub"]) && $value["sub"]) {
                        $stroption .= '<optgroup label="'.$value["ti"].'">';
                        $stroption .= '<option value="'.$link.'">'.$value["ti"].'</option>';
                        foreach ($value["sub"] as $key => $subItem) {
                            $sublink = (!empty($subItem["link"])) ? $subItem["link"] : (isset($subItem["url"]) ? "/".$subItem["url"] : "#");
                            $strSubMenu .= '<li class="sub-page-id-'.$subItem["id"].'"><a href="'.$sublink.'" data-goto-top data-obj="#page-id-'.$subItem["id"].'">'.$subItem["ti"].'</a></li>';
                            $stroption .= '<option value="'.$sublink.'">'.$subItem["ti"].'</option>';
                        }

                        $strSubMenu = '<ul class="sub-menu">'.$strSubMenu.'</ul>';
                        $strMenu .='<li class="menu-item-'.$value["id"].'"><a href="'.$link.'" data-goto-top data-obj="#page-id-'.$value["id"].'">'.$value["ti"].' <i class="fa fa-angle-down"></i></a>'.$strSubMenu.'</li>';
                        $stroption .= '</optgroup>';
                    }
                    else {
                        $stroption .= '<option value="'.$link.'">'.$value["ti"].'</option>';
                        $strMenu .='<li  class="menu-item-'.$value["id"].'"><a href="'.$link.'" data-goto-top data-obj="#page-id-'.$value["id"].'">'.$value["ti"].'</a></li>';
                    }
                }
                if(isset($strMenuConfig) && $strMenuConfig ) {
                    echo $strMenuConfig;
                } else {
                ?>
                <div id="main-menu">
                    <div class="containers">
                        <?='<div class="hidden-xs desktop-menu text-right"><ul>'.$strMenu.'</ul></div>';?>
                        <div class="mobile-menu hidden-sm hidden-md hidden-lg" data-copy-obj=".desktop-menu > ul">
                            <?=$strHeader1;?>
                        </div>
                    </div>
                </div>
            <?php
            }
            ?>
            </div>
        </div>
    </div>
    <?php
    }
    ?>
</div>
<div class="space-header"></div>

