<?php
if(isset($pageInfo["more"]["contentCustom"])
    && !empty($pageInfo["more"]["contentCustom"])){
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
    <div class="more-info">
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
}
?>
