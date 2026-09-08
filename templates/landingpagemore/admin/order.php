<?php
$numberItem = isset($_GET["item"])? $_GET["item"]:10;
$strLinkPage = '?fun=order';
$strOptionItem = null;
foreach ($language["itemNumberOption"] as $key=>$value) {
    $strOptionItem .='<li><a href="'.$strLinkPage.'&item='.$key.'">'.$value.'</a></li>';
}

$filterForm = isset($_POST)?$_POST:null;
if(!isset($filterForm["from"])) {
    $filterForm["from"] = date('01-m-Y');
}
$strWhere = array();
if($filterForm) {
    foreach ($filterForm as $key => $value) {
        if($key&& $value) {
            $strWhere[] = $key."=".$value;
        }
    }
}
$getUrl = APIGETORDER.'?'.implode('&', $strWhere);
?>
<div class="item-view-more admin-list"
    data-view-list-by-handlebar
    data-init-button-magic=".item [data-button-magic]"
    data-url="<?=$getUrl?>"
    data-method="get"
    data-show-page="10"
    data-show-item="20"
    data-show-all="false"
    data-scroll-view="false"
    data-form-filter=".form-filter"
    data-object-reverse="true"
    data-template-id="entryOrderItem" >
    <div class="admin-title">
        <div class="row">
            <div class="col-xs-5">
                <h2><?=$language["orderManage"]?></h2>
            </div>
            <div class="col-xs-5">
                <?php if (isset($language["itemNumberOption"][$numberItem]) ) {?>
                <div class="item-of-page">
                    <label data-object=".item-of-page"
                            data-closet-toggle-class="active"><?=$language["itemNumberOption"][$numberItem]?></label>
                    <?php echo '<ul>'.$strOptionItem.'</ul>';?>
                </div>
                <?php } ?>
            </div>
        </div>
    </div>

    <div class="submit-filter">
        <form data-form-change-to-submit class="form-inline" method="post" action="?fun=order">
            <div class="form-group">
                <label>From:</label>
                <input type="text"
                    name="from"
                    value="<?=isset($filterForm["from"])?$filterForm["from"]:null?>"
                    data-date-picker
                    data-date-picker-relative="to"
                    data-date-picker-type="startDate"
                    class="datetime form-control">
                <span class="error"></span>
            </div>
            <div class="form-group">
                <label for="exampleInputPassword3">To:</label>
                <input  type="text"
                    name="to"
                    value="<?=isset($filterForm["to"])?$filterForm["to"]:null?>"
                    data-date-picker
                    data-date-picker-relative="from"
                    data-date-picker-type="endDate"
                    class="datetime form-control">
                <span class="error"></span>
            </div>
            <div class="form-group">
                <label ><?=$language["city"]?>:</label>
                <select name="ci"
                    data-dropdown
                    data-object-init='{"id":"", "ti":"<?=$language["viewAll"]?>"}'
                    data-option-local-json="cityOption"
                    data-index-value="<?=isset($filterForm["ci"])?$filterForm["ci"]:null?>"
                    class="form-control">
                </select>
            </div>
            <div class="form-group">
                <label ><?=$language["status"]?>:</label>
                <select name="st"
                    data-dropdown
                    data-object-init='{"id":"", "ti":"<?=$language["viewAll"]?>"}'
                    data-option-local-json="orderStatusOption"
                    data-index-value="<?=isset($filterForm["st"])?$filterForm["st"]:null?>"
                    class="form-control">
                    <option value=""><?=$language["viewAll"]?></option>
                </select>
            </div>
        </form>
    </div>
    <div class="head-title">
        <div class="row">
            <div class="col-xs-5">
                <div class="row">
                    <div class="col-xs-2">
                        <label>#</label>
                    </div>
                    <div class="col-xs-10">
                        <label><?=$language["customerInfo"]?></label>
                    </div>
                </div>
            </div>
            <div class="col-xs-2"><label><?=$language["orderTotal"]?></label></div>
            <div class="col-xs-2"><label><?=$language["orderDate"]?></label></div>
            <div class="col-xs-2"><label><?=$language["status"]?></label></div>
            <div class="col-xs-1 text-right"></div>
        </div>
    </div>
    <div class="content-filter">
        <form class="form-filter">
            <div class="row">
                <div class="col-xs-5">
                    <div class="row">
                        <div class="col-xs-2">
                            <div class="form-group">
                                <input type="text"
                                    name="id"
                                    data-compare="equal"
                                    placeholder="<?=$language["id"]?>"
                                    class="form-control">
                            </div>
                        </div>
                        <div class="col-xs-5">
                            <div class="form-group">
                                <input type="text"
                                    name="em"
                                    data-compare="text in"
                                    placeholder="<?=$language["email"]?>"
                                    class="form-control">
                            </div>
                        </div>
                        <div class="col-xs-5">
                            <div class="form-group">
                                <input type="text"
                                    name="ph"
                                    data-compare="text in"
                                    placeholder="<?=$language["phone"]?>"
                                    class="form-control">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xs-2">
                </div>
                <div class="col-xs-2">
                </div>
                <div class="col-xs-2">
                </div>
            </div>
        </form>
    </div>
    <div class="view-items" data-content><div class="style-loadding">...</div></div>
</div>
