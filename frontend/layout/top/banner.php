<?php
if(isset($strBannerConfig) && $strBannerConfig && !$url_data[0] ) {
    echo $strBannerConfig;
}
else {
    if(isset($bannerSlide) && $bannerSlide) {
        $strSlide=null;
        foreach($bannerSlide as $item):
            $image = $link = null;
            if( is_array($item) && isset($item["im"]) ){
                $image  = FOLDERIMAGEMENU.$item["im"];
                $link = isset($item["link"]) && !empty($item["link"]) ? $item["link"]:"/".$item["url"];
                if(is_file($image)):
                    $item["ct"] = !empty($item["ct"]) ? $item["ct"] : null;
                    $strSlide .='<div class="init-none banner-info" data-image="/'.$image.'" data-url="'.$link.'">
                        <div class="slide-content text-center">
                            <h3 class="b-title">'.$item["ti"].'</h3>
                            <p>'.$item["ct"].'</p>
                            <a class="btn btn-primary text-uppercase" href="'.$link.'"><span class="iconm-point-right"></span>'.$language["viewDetail"].'</a>
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
            <div class="container">
                <ul id="supersized"></ul>
                <div id="progress-back" class="load-item">
                    <div id="progress-bar hidden"></div>
                </div>
                <?php
                if(count($bannerSlide)>1) {
                ?>
                <div class="controls-bar">
                    <a id="prevslide" class="nav-slide load-item nav-slide-prev"> <span class="fa fa-chevron-left fa-2x"></span></a>
                    <a id="nextslide" class="nav-slide load-item nav-slide-next"><span class="fa fa-chevron-right fa-2x"></span></a>
                </div>
                <?php }?>
                <div class="slide-container">
                    <div class="hidden-xss" id="slidecaption"></div>
                </div>
            </div>
            <div class="supersized-setup"><?=$strSlide?></div>
        </div>
        <?php
        unset($bannerSlide);
        }
    }
}
?>
