<?php
$column = isset($informationConfig["config"]["column"])? $informationConfig["config"]["column"] : null;
$strColumnLeft = isset($column["left"]) && !empty($column["left"]) ? $column["left"] : null;
$strColumnMain = isset($column["main"]) && !empty($column["main"]) ? $column["main"] : null;
$strColumnRight = isset($column["right"]) && !empty($column["right"]) ? $column["right"] : null;

$numberItem = isset($_GET["item"])? $_GET["item"]:10;
$strLinkPage = '?fun=sidebar';
$strOptionItem = null;
foreach ($language["itemNumberOption"] as $key=>$value) {
    $strOptionItem .='<li><a href="'.$strLinkPage.'&item='.$key.'">'.$value.'</a></li>';
}
?>
<div class="layout-page">
    <div data-ui-tabs data-tab-class="ui-tabs" data-mobile-title="tab-title">
        <div class="product-des">
            <div class="item-content"
                data-remove-view-list="data-view-list-by-handlebar-in-tab"
                data-view-list="[data-view-list-by-handlebar-in-tab]">
                <h3 class="icon tab-title"><?=$language["sidebar"]?></h3>
                <div class="tab-content" >
                    <div class="item-view-more item-view-sidebar admin-list"
                        data-view-list-by-handlebar-in-tab
                        data-init-button-magic=".item [data-button-magic]"
                        data-url="<?=APIGETCONFIGSIDEBAR;?>"
                        data-method="get"
                        data-show-page="10"
                        data-show-item="<?=$numberItem?>"
                        data-show-all="false"
                        data-scroll-view="false"
                        data-form-filter=".form-filter"
                        data-object-reverse="true"
                        data-template-id="entrySidebarItem" >
                        <div class="admin-title">
                            <div class="row">
                                <div class="col-xs-5">
                                    <?php if (isset($language["itemNumberOption"][$numberItem]) ) {?>
                                    <div class="item-of-page">
                                        <label data-object=".item-of-page"
                                                data-closet-toggle-class="active"><?=$language["itemNumberOption"][$numberItem]?></label>
                                        <?php echo '<ul>'.$strOptionItem.'</ul>';?>
                                    </div>
                                    <?php } ?>
                                </div>
                                <div class="col-xs-2 text-right">
                                    <button class="btn btn-default form-add btn-add-a-item"
                                    data-button-magic
                                    data-view-template-local="true"
                                    data-view-template="[data-quick-view-item]"
                                    data-template-id="entrySidebarUpdate"><?=$language["add"];?> + </button>
                                </div>
                            </div>
                        </div>
                        <div class="head-title">
                            <div class="row">
                                <div class="col-xs-4"><label><?=$language["title"]?></label></div>
                                <div class="col-xs-2"><label><?=$language["category"]?></label></div>
                                <div class="col-xs-2">
                                    <div class="row">
                                        <div class="col-xs-6">
                                            <label>Left</label>
                                        </div>
                                        <div class="col-xs-6">
                                            <label>Right</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-2"><label>HTML ATTRIBUTE</label></div>
                                <div class="col-xs-1"><label><?=$language["order"]?></label></div>
                                <div class="col-xs-1 text-right"><label><?=$language["update"]?></label></div>
                            </div>
                        </div>
                        <div class="content-filter">
                            <form class="form-filter">
                                <div class="row">
                                    <div class="col-xs-4">
                                        <div class="row">
                                            <div class="col-xs-3">
                                                <div class="form-group">
                                                    <input type="text"
                                                        name="id"
                                                        data-compare="equal"
                                                        placeholder="<?=$language["id"]?>"
                                                        class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-xs-9">
                                                <div class="form-group">
                                                    <input type="text"
                                                        name="ti"
                                                        data-compare="text in"
                                                        placeholder="<?=$language["title"]?>"
                                                        class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xs-2">
                                        <div class="form-group">
                                            <select name="cat"
                                                data-dropdown
                                                data-object-init='{"id":"", "ti":"<?=$language["viewAll"]?>"}'
                                                data-option-local-json="menuStructure"
                                                data-params="opp=3"
                                                data-compare="in"
                                                data-option-base-on-url="cat"
                                                class="form-control">
                                                <option value=""><?=$language["viewAll"]?></option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xs-2">
                                        <div class="form-group">

                                        </div>
                                    </div>
                                    <div class="col-xs-2">
                                        <div class="form-group">
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="view-items" data-content><div class="style-loadding">...</div></div>
                        <div class="row">
                            <div class="col-xs-10">
                                <div data-footer></div>
                            </div>
                            <div class="col-xs-2 text-right">
                                <button class="btn btn-default form-add btn-add-a-item"
                                data-button-magic
                                data-view-template-local="true"
                                data-view-template="[data-quick-view-item]"
                                data-template-id="entrySidebarUpdate"><?=$language["add"];?> + </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="item-content"
                data-remove-view-list="data-view-list-by-handlebar-in-tab"
                data-view-list="[data-view-list-by-handlebar-in-tab]">
                <h3 class="icon tab-title"><?=$language["configColumn"]?></h3>
                <div class="tab-content" >
                    <form method="post"
                        class="post-form post-form-about edit-add-item edit-disabled">
                        <span data-closet-toggle-class="edit-enabled"
                        data-object=".edit-disabled"
                        class="icon-edit-cancel icon-lg1 position-right"></span>
                        <input type="hidden" name="config.type" value="column">
                        <div class="form-group">
                            <label>Custom class column left</label>
                            <div class="form-control-static"><?=$strColumnLeft?></div>
                            <input name="column.left" class="form-control" value="<?=$strColumnLeft?>" />
                        </div>
                        <div class="form-group">
                            <label>Custom class column main</label>
                            <div class="form-control-static"><?=$strColumnMain?></div>
                            <input name="column.main" class="form-control" value="<?=$strColumnMain?>" />
                        </div>
                        <div class="form-group">
                            <label>Custom class column right</label>
                            <div class="form-control-static"><?=$strColumnRight?></div>
                            <input name="column.right" class="form-control" value="<?=$strColumnRight?>" />
                        </div>

                        <div class="fieldset">
                            <div class="edit-show form-group">
                                <input type="submit"
                                    data-button-magic
                                    data-params-form=".post-form"
                                    data-format-json="true"
                                    data-ajax-url="<?=APIPOSTCONFIGPAGE?>"
                                    data-redirects="."
                                    data-show-success=".alert"
                                    data-show-errors=".popup.signin-missing-session"
                                    class="btn btn-primary"
                                    value="<?=$language["update"]?>">
                                <button
                                    onclick="location.reload();"
                                    class="btn btn-second"><?=$language["reset"]?></button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <!-- Tab 2-->
        </div>
    </div>
    <div class="alert text-left" data-fade="2000"> <div class="sms-content"><?=$language["updateSuccess"]?></div> </div>
</div>
