<?php
if(isset($pageInfo["more"]["contentCustom"])
    && !empty($pageInfo["more"]["contentCustom"])){
    ?>
    <div class="description">
        <?=$pageInfo["more"]["contentCustom"]?>
    </div>
    <?php
} else {
    $tmpTitle = $pageInfo["db"]["ti"];
    if(isset($pageInfo["db"]["ti1"]) && !empty($pageInfo["db"]["ti1"])) {
        $tmpTitle = $pageInfo["db"]["ti1"];
    }
    ?>
    <div class="title">
        <h1><?=$tmpTitle?></h1>
    </div>
    <?php
    if(isset($pageInfo["more"]["description"]) && !empty($pageInfo["more"]["description"])){
        ?>
        <div class="more-info">
            <div class="content">
                <?=$pageInfo["more"]["description"]?>
            </div>
        </div>
        <?php
    }
    echo $strTabContent ? $strTabContent:'';
}
?>
