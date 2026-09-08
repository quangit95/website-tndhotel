<div id="header" class="relative">
    <?php
    // $strLogoWebsite = isset($informationWebsite["db"]["im"]) ? FOLDERIMAGEWEBSITE.$informationWebsite["db"]["im"]: "";
    if($strHeader2):
        echo $strHeader2;
    else:
    ?>
    <div class="container">
        <div class="hidden-sm hidden-md hidden-lg icon-menu text-right">
            <span
                data-object=".website"
                data-closet-toggle-class="mobile-active">
                <span class="fa fa-navicon fa-2x">&nbsp;</span>
            </span>
            <span
                data-object=".website"
                data-closet-toggle-class="mobile-active">
                <span class="fa fa-close fa-2x">&nbsp;</span>
            </span>
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
                    echo '<div class="top-bar hidden-xs"><a href="tel:'.$socialHotline.'"><span class="fa fa-phone"></span> '.$socialHotline.'</a></div>';
                }
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
                            $strSubMenu .= '<li><a href="'.$sublink.'"><i class="fa fa-angle-double-right"></i> '.$subItem["ti"].'</a></li>';
                            $stroption .= '<option value="'.$sublink.'">'.$subItem["ti"].'</option>';

                            if(isset($subItem["sub"]) && $subItem["sub"]) {
                                foreach ($subItem["sub"] as $key => $subItem2) {
                                    $sublink = isset($subItem2["link"]) && !empty($subItem2["link"]) ? $subItem2["link"]: "/".$subItem2["url"] ;

                                }
                            }
                        }

                        $strSubMenu = '<ul class="sub-menu">'.$strSubMenu.'</ul>';
                        $strMenu .='<li '.$strCustomMenuTemplate.' class="menu-item menu-item-'.$value["id"].'"><a href="'.$link.'">'.$value["ti"].'<i class="fa fa-angle-down"></i></a>'.$strSubMenu.'</li>';
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
                    <div class="containers">
                        <?='<div class="hidden-xs hidden-sm desktop-menu text-right"><ul>'.$strMenu.'</ul></div>';?>
                        <div class="mobile-menu hidden-md hidden-lg">
                            <div data-copy-obj=".desktop-menu > ul">
                            </div>
                            <?=$strHeader1;?>
                        </div>
                        <div class="hidden hidden-sm hidden-md hidden-lg form-group" style="padding-bottom:10px;">
                            <select data-option-goto-link class="form-control" ><?=$stroption?></select>
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
    endif;
    ?>
</div>

