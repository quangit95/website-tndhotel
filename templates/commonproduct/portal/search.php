<form data-form-validate class="form-filter form-horizontal form-search-home" action="/q" method="get">
    <div class="row">
        <div class="col-xs-4">
            <div class="form-group">
                <label class="col-xs-12 hidden-sm hidden-md hidden-lg control-label"><?=$language["state"]?>:</label>
                <div class="col-xs-12">
                    <select name="sta"
                        data-validate
                        data-required="Please option"
                        data-dropdown
                        data-dropdown-relative-body
                        data-dropdown-relative="ci"
                        data-params="state="
                        data-index-value="<?=isset($_GET["sta"])?$_GET["sta"]:null?>"
                        data-object-init='{"code":"", "state":"<?=$language["state"]?>"}'
                        data-option-local-json="state"
                        data-str-key="code"
                        data-str-value="state"
                        class="form-control">
                    </select>
                </div>
            </div>
        </div>
        <div class="col-xs-4">
            <div class="form-group">
                <label class="col-xs-12 hidden-sm hidden-md hidden-lg control-label"><?=$language["city"]?>:</label>
                <div class="col-xs-12">
                    <select name="ci"
                        data-validate
                        data-required="Please option"
                        data-dropdown
                        type="select-from-json"
                        data-option-from-json="<?=APIGETCITY?>"
                        data-params="<?=isset($_GET["sta"])?"state={$_GET["sta"]}":null?>"
                        data-index-value="<?=isset($_GET["ci"])?$_GET["ci"]:null?>"
                        data-object-init='{"id":"", "title":"<?=$language["city"]?>"}'
                        data-str-key="id"
                        data-str-value="title"
                        class="form-control">
                    </select>
                </div>
            </div>
        </div>
        <div class="col-xs-4">
            <div class="form-group">
                <label class="col-xs-12 hidden-sm hidden-md hidden-lg control-label"><?=$language["property"]?>:</label>
                <div class="col-xs-12">
                    <select name="cat"
                        data-validate
                        data-required="Please option"
                        data-dropdown
                        data-index-value="<?=isset($_GET["cat"])?$_GET["cat"]:null?>"
                        data-object-init='{"id":"", "ti":"<?=$language["property"]?>"}'
                        data-option-local-json="menuStructure"
                        data-params="opp=3"
                        class="form-control"></select>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-6">
            <div class="form-group">
                <label class="col-sm-2 control-label"><?=$language["acres"]?>:</label>
                <div class="col-sm-5">
                    <input type="text"
                    name="si_from"
                    value="<?=isset($_GET["si_from"])?$_GET["si_from"]:null?>"
                    placeholder="<?=$language["from"]?>"
                    class="form-control">
                </div>
                <div class="col-sm-5">
                    <input type="text"
                    name="si_to"
                    value="<?=isset($_GET["si_to"])?$_GET["si_to"]:null?>"
                    placeholder="<?=$language["to"]?>"
                    class="form-control">
                </div>
            </div>
        </div>
        <div class="col-xs-6">
            <div class="form-group">
                <label class="col-sm-2 control-label"><?=$language["price"]?>:</label>
                <div class="col-sm-5">
                    <input type="text"
                    name="pr_from"
                    value="<?=isset($_GET["pr_from"])?$_GET["pr_from"]:null?>"
                    placeholder="<?=$language["from"]?>"
                    class="form-control">
                </div>
                <div class="col-sm-5">
                    <input type="text"
                    name="pr_to"
                    value="<?=isset($_GET["pr_to"])?$_GET["pr_to"]:null?>"
                    placeholder="<?=$language["to"]?>"
                    class="form-control">
                </div>
            </div>
        </div>
    </div>
    <div class="text-right">
        <input class="btn btn-warning text-uppercase" type="submit" value="<?=$language["btnSearch"]?>">
    </div>
</form>
