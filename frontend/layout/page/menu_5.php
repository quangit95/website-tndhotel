<?php
if(isset($pageInfo["more"]["contentCustom"]) && !empty($pageInfo["more"]["contentCustom"])){
    ?>
    <div class="description">
        <?=$pageInfo["more"]["contentCustom"]?>
    </div>
    <?php
} else {
    if(isset($pageInfo["more"]["description"]) && !empty($pageInfo["more"]["description"])){
    $tmpTitle = '<span> '.$pageInfo["db"]["ti"].'</span> ';
    if(isset($pageInfo["db"]["ti1"]) && !empty($pageInfo["db"]["ti1"])) {
        $tmpTitle .=$pageInfo["db"]["ti1"];
    }
    ?>
    <div class="description more-info">
        <div class="title">
            <h1><?=$tmpTitle?></h1>
        </div>
        <div class="description">
            <?=$pageInfo["more"]["description"]?>
        </div>
    </div>
    <?php
    }
    echo $strTabContent ? '<div data-ui-tabs data-tab-class="ui-tabs" data-mobile-title="tab-title"><div class="product-des">'.$strTabContent.'</div></div>':'';
    if(isset($pageInfo["more"]["isform"]) && $pageInfo["more"]["isform"] == 2) {
    ?>
        <div class="form-landing-page" data-copy-template="" data-get-url="/api/get/model" data-params="mod=site&node=contact&col=2&mid=<?=$pageInfo["db"]["ti"]?>" data-view-template=".form-contact-landing-page" data-template-id="entryFormElement">
            <h3 class="text-color-2"><?=$language["contactSendInquery"]?></h3>
            <div class="form-contact-landing-page">&nbsp;</div>
        </div>
    <?php
    }
    if(isset($pageInfo["db"]["pa"]) && intval($pageInfo["db"]["pa"])>0) {
    ?>
    <div class="relative-landipage">
        <div class="title">
            <h2><?=$language["sameCategory"]?></h2>
        </div>
        <div class="item-view-landing-page item-view-landing-page-slide has-button-bottom rectangle" 
            data-view-list-by-handlebar="" 
            data-url="/api/get/menu?opp=5"
            data-init-object="languageText.dropdownLocalOption.menuTable"
            data-filter-init='[{"name":"pa","value":"<?=$pageInfo["db"]["pa"]?>","compare":"equal"}]'
            data-method="get" 
            data-show-page="10" 
            data-show-item="24" 
            data-show-all="true" 
            data-slide="true" data-template-id="entryLandingPage">
            <div class="view-items item-img-icon item-side-icon" data-content="" data-arrows="true" data-slick-responsive="2" data-slick-infinite="true" data-auto-play="2000" data-slick-show="3">
                <div class="style-loadding"></div>
            </div>
        </div>
    </div>
    <?php
    } else {
        
    }
}
?>
