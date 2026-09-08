<?php
$strTab = null;
if (isset($pageInfo["detail"]) && $pageInfo["detail"]) {
    foreach ($pageInfo["detail"] as $key => $value) {
        if ($value["title"] && $value["description"]) {
            $strTag = isset($value["tag"]) && !empty($value["tag"])? $value["tag"] : null;
            $strTab .= '<div class="tag-faq tag-faq-'.$strTag.'"><div data-toggle-next class="bg-transparent tab-title icon-question"><strong data-parent-toggle="active">' . $value["title"] . '</strong></div>
                <div class="tab-content" ><div class="tab-description" >' . $value["description"] . '</div></div></div>';
        }
    }
    
}

if(isset($pageInfo["more"]["contentCustom"])
    && !empty($pageInfo["more"]["contentCustom"])){
    ?>
    <div class="description">
        <?=$pageInfo["more"]["contentCustom"]?>
    </div>
    <?php
    echo $strTab ? $strTab:'';
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
    echo $strTab ? $strTab:'';
}
?>
