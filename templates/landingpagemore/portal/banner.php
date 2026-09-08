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
                    $strSlide .='<div class="hidden banner-info" data-image="/'.$image.'" data-url="'.$link.'">
                        <div class="slide-content">
                            <p><a href="'.$link.'"><span class="iconm-point-right"></span>'.$item["ti"].'</a></p>
                        </div>
                    </div>';
                endif;
            }
            elseif( isset($pageInfo["db"]["id"]) && $pageInfo["db"]["id"]) {
                $image  = FOLDERSLIDEMENU.$pageInfo["db"]["id"]."/".$item;
                if(is_file($image)):
                    $strSlide .='<div class="hidden banner-info" data-image="/'.$image.'" data-url="#"></div>';
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
