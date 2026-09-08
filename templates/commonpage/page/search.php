<?php
$getUrl = APIGETPRODUCT."?status=active";
$pageSearchCustom["class"]="item-view-products";
$pageSearchCustom["templateId"]="entryViewProduct";
$pageSearchCustom["center"]="data-center-items";
$pageSearchCustom["centerItem"]=$customResponsiveDefault;

$strContentOfPageSearch = '<div class="{1}"
        data-view-list-by-handlebar
        data-init-button-magic=".item [data-button-magic]"
        data-url="{2}"
        data-method="get"
        data-show-page="10"
        data-show-item="24"
        data-form-filter=".form-filter-1"
        data-show-all="false"
        data-scroll-view="true"
        data-scroll-bottom=".flag-scroll-bottom"
        data-scroll-space-plus="300"
        data-template-id="{3}">
            <div class="title"><h2>{4}</div>
            <div data-content class="view-items" {5} data-class-name="view-items-mobile"
                data-item-class=".item" data-responsive="true" data-items-custom="{6}">
                <div class="style-loadding"></div>
            </div>
            <div class="clearfix"></div>
        </div>';

if(isset($_GET["getmodel"]) && $_GET["getmodel"] == "blog") {
    $getUrl = APIGETBLOG."?status=active";
    $pageSearchCustom["templateId"]="entryItemBlogView";
    $pageSearchCustom["class"] ="news";
    $pageSearchCustom["center"] = null;
}

$hasFilter = 1;
$web_title = null;

if(isset($_GET["title"]) && $_GET["title"]) {
    $hasFilter++;
    $getUrl .= "&title={$_GET["title"]}";
    $web_title[1] = $_GET["title"];
}
if(isset($_GET["sta"]) && $_GET["sta"]) {
    $hasFilter++;
    $getUrl .= "&sta={$_GET["sta"]}";
}
if(isset($_GET["ci"]) && $_GET["ci"]) {
    $hasFilter++;
    $getUrl .= "&ci={$_GET["ci"]}";
}
if(isset($_GET["cat"]) && $_GET["cat"]) {
    $hasFilter++;
    $getUrl .= "&cat={$_GET["cat"]}";
}
if(isset($_GET["si_to"]) && $_GET["si_to"]) {
    $hasFilter++;
    $getUrl .= "&si_to={$_GET["si_to"]}";
}
if(isset($_GET["si_from"]) && $_GET["si_from"]) {
    $hasFilter++;
    $getUrl .= "&si_from={$_GET["si_from"]}";
}
if(isset($_GET["pr_to"]) && $_GET["pr_to"]) {
    $hasFilter++;
    $getUrl .= "&pr_to={$_GET["pr_to"]}";
}
if(isset($_GET["pr_from"]) && $_GET["pr_from"]) {
    $hasFilter++;
    $getUrl .= "&pr_from={$_GET["pr_from"]}";
}

if($web_title){
    $web_title = implode(' ', $web_title);
}

$pageSearchCustom["url"]=$getUrl;
$pageSearchCustom["title"]=formatStrArguments($language["searchContentResult"], $web_title);

$strContentOfPageSearch = formatStrArguments($strContentOfPageSearch,$pageSearchCustom["class"],$pageSearchCustom["url"], $pageSearchCustom["templateId"], $pageSearchCustom["title"], $pageSearchCustom["center"], $pageSearchCustom["centerItem"]);


function main() {
    global $seo_name, $language, $url_data, $getUrl, $hasFilter, $web_title, $customResponsiveDefault, $strContentOfPageSearch;
    if($hasFilter>1){
        $strColLeft = "col-xs-12 col-sm-3";
        $strColRight = "col-xs-12 col-sm-9";
        if(!isset($language["dropdownLocalOption"]["filterPropertiesStructure"])) {
            $strColLeft = "hidden";
            $strColRight = "col-xs-12 col-sm-12";
        }

    ?>
    <div class=" item-product-search">
        <div class="row">
            <div class="<?=$strColLeft?>">
                <div class="block-search">
                    <div class="block-title">
                        <h3><?=$language["searchBy"];?></h3>
                    </div>
                    <div class="form-search-attr form-filter-1" data-waiting="500" data-copy-template data-method="get" data-get-url="/api/get/model?mod=search" data-view-template=".form-search-attr" data-template-id="entryFormElement">
                        </div>
                </div>
            </div>
            <div class="<?=$strColRight?>">
                <?php echo $strContentOfPageSearch;?>
            </div>
        </div>
    </div>
    <?php
    }
    else {

    }
}
?>
