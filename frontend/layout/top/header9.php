<div id="header" class="relative">
    <?php
    if(isset($strHeader1) && $strHeader1 ) {
        echo '<div class="top-bar">'.$strHeader1.'</div>';
    }
    
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
            <div class="col-xs-12 col-sm-2 col-md-2">
                <div class="logo">
                    <a href="/">
                        <img src="<?="/".$strLogoWebsite?>" alt="<?=$informationWebsite["db"]["name"]?>">
                    </a>
                </div>
            </div>
            <div class="col-xs-12 col-sm-10 col-md-10">
                <?php
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
                    $strCustomMenuTemplate = isset($value["opl"]) && !empty($value["opl"]) ? $value["opl"]: null;
                    if($strCustomMenuTemplate) {
                        $strCustomMenuTemplate .= ' data-elm-data=\'{"id":"'.$value["id"].'","ti":"'.$value["ti"].'","link":"'.$link.'"}\'';
                    }


                    if(isset($value["sub"]) && $value["sub"]) {
                        $stroption .= '<optgroup label="'.$value["ti"].'">';
                        $stroption .= '<option value="'.$link.'">'.$value["ti"].'</option>';
                        foreach ($value["sub"] as $key => $subItem) {
                            $sublink = (!empty($subItem["link"])) ? $subItem["link"] : (isset($subItem["url"]) ? "/".$subItem["url"] : "#");
                            $strSubMenu .= '<li class="sub-page-id-'.$subItem["id"].'"><a href="'.$sublink.'" data-goto-tops data-obj="#page-id-'.$subItem["id"].'">'.$subItem["ti"].'</a></li>';
                            $stroption .= '<option value="'.$sublink.'">'.$subItem["ti"].'</option>';
                        }

                        $strSubMenu = '<ul class="sub-menu">'.$strSubMenu.'</ul>';
                        $strMenu .='<li '.$strCustomMenuTemplate.' class="menu-item menu-item-'.$value["id"].'"><a href="'.$link.'" data-goto-tops data-obj="#page-id-'.$value["id"].'" >'.$value["ti"].' <i class="fa fa-angle-down"></i></a>'.$strSubMenu.'</li>';
                        $stroption .= '</optgroup>';
                    }
                    else {
                        $stroption .= '<option value="'.$link.'">'.$value["ti"].'</option>';
                        $strMenu .='<li '.$strCustomMenuTemplate.' class="menu-item menu-item-'.$value["id"].'"><a href="'.$link.'" data-goto-tops data-obj="#page-id-'.$value["id"].'" >'.$value["ti"].'</a></li>';
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
<?php
if(isset($strBannerConfig) && $strBannerConfig && !$url_data[0] ) {
    echo $strBannerConfig;
} else {
    if(isset($bannerSlide) && $bannerSlide) {
        $strSlide=null;
        foreach($bannerSlide as $item):
            $image = $link = null;
            if( is_array($item) && isset($item["im"]) ){
                $image  = FOLDERIMAGEMENU.$item["im"];
                $link = isset($item["link"]) && !empty($item["link"]) ? $item["link"]:"/".$item["url"];
                if(is_file($image)):
                    $strSlide .='<div class="init-none banner-info" data-image="/'.$image.'" data-url="'.$link.'">
                        <div class="slide-content">
                            <p class="slide-title"><a href="'.$link.'">'.$item["ti"].'</a></p>
                            <p class="init-none slide-ct">'.(isset($item["ct"]) && !empty($item["ct"]) ? $item["ct"]:null).'</p>
                        </div>
                    </div>';
                endif;
            }
            elseif( isset($pageInfo["db"]["id"]) && $pageInfo["db"]["id"]) {
                $image  = FOLDERSLIDEMENU.$pageInfo["db"]["id"]."/".$item;
                if(is_file($image)):
                    $strSlide .='<div class="init-none banner-info" data-image="/'.$image.'" data-url="#"></div>';
                endif;
            }
        endforeach;
        if($strSlide) {
        ?>
        <div id="slide-banner" data-supersized-animate>
            <ul id="supersized"></ul>
            <div id="progress-back" class="load-item">
                <div id="progress-bar"></div>
            </div>
            <div class="container">

                <?php
                if(count($bannerSlide)>1) {
                ?>
                <div class="controls-bar">
                    <a id="prevslide" class="nav-slide load-item nav-slide-prev"> <span class="fa fa-chevron-circle-left "></span></a>
                    <a id="nextslide" class="nav-slide load-item nav-slide-next"><span class="fa fa-chevron-circle-right"></span></a>
                </div>
                <?php }?>
                <div class="slide-container">
                    <div class="hidden-xs" id="slidecaption"></div>
                </div>
                <div class="supersized-setup"><?=$strSlide?></div>
            </div>
        </div>
        <?php
        unset($bannerSlide);
        }
    }
}
?>


