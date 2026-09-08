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
    if (isset($pageInfo["detail"]) && $pageInfo["detail"]) {
        $strTab = null;
        foreach ($pageInfo["detail"] as $key => $value) {
          if ($value["title"] && $value["description"]) {
            $strTab .= '<div class="item-content">
                  <h3 class="icon tab-title">' . $value["title"] . '</h3>
                  <div class="tab-content" ><div class="tab-description description" >' . $value["description"] . '</div></div>
              </div>';
          }
        }
        echo $strTab ? '<div data-ui-tabs data-tab-class="ui-tabs" data-mobile-title="tab-title"><div class="product-des">'.$strTab.'</div></div>':'';
    }
}
?>
