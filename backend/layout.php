<?php
global $layoutNode;
$cssNode = isset($informationConfig["config"]["css"])? $informationConfig["config"]["css"] : null;
$strCSS = isset($cssNode["style"]) && !empty($cssNode["style"])? $cssNode["style"] : null;
$strTemplate = isset($layoutNode["temp"]) && !empty($layoutNode["temp"])? $layoutNode["temp"] : 'responsive';

$footer = isset($informationConfig["config"]["footer"])? $informationConfig["config"]["footer"] : null;
$header = isset($informationConfig["config"]["header"])? $informationConfig["config"]["header"] : null;
$menubaner = isset($informationConfig["config"]["menubaner"])? $informationConfig["config"]["menubaner"] : null;


$strFooter1 = isset($footer["content1"]) && ($footer["content1"]) ? $footer["content1"] : "";
$strFooter2 = isset($footer["content2"]) && ($footer["content2"]) ? $footer["content2"] : "";
$strHeader1 = isset($header["content1"]) && ($header["content1"]) ? $header["content1"] : "";
$strHeader2 = isset($header["content2"]) && ($header["content2"]) ? $header["content2"] : "";

$strMenu = isset($menubaner["menu"]) && ($menubaner["menu"]) ? $menubaner["menu"] : "";
$strBanner = isset($menubaner["banner"]) && ($menubaner["banner"]) ? $menubaner["banner"] : "";


$strOptionTemplate = null;
if ($handle = opendir('./template')) {
    while (false !== ($entry = readdir($handle))) {
        $strSelected = '';
        if ($entry != "." && $entry != "..") {
            if($entry == $strTemplate) {
                $strSelected = 'selected';
            }
            $strOptionTemplate .= "<option value='{$entry}' {$strSelected}>{$entry}</option>";
        }
    }
    closedir($handle);
}
$numberItem = isset($_GET["item"])? $_GET["item"]:10;
$strLinkPage = '?fun=blog';
$strOptionItem = null;
foreach ($language["itemNumberOption"] as $key=>$value) {
    $strOptionItem .='<li><a href="'.$strLinkPage.'&item='.$key.'">'.$value.'</a></li>';
}
?>
<div class="admin-title">
    <h2><?=$language["layoutCustom"]?></h2>
</div>
<div class="layout-page">
    <div data-ui-tabs data-tab-class="ui-tabs" data-mobile-title="tab-title">
        <div class="product-des">
            <div class="item-content">
                <h3 class="icon tab-title"><?=$language["layoutOption"]?></h3>
                <div class="tab-content">
                    <form method="post"
                        class="post-form post-form-about edit-disabled">
                        <span data-closet-toggle-class="edit-enabled"
                        data-object=".edit-disabled"
                        class="icon-edit-cancel icon-lg1 position-right"></span>
                        <input type="hidden" name="config.type" value="layout">
                        <div class="form-group">
                            <label><?=$language["layoutOption"]?></label>
                            <code class="form-control-static"><?=$strTemplate?></code>
                            <div class="edit-show">
                                <?php if($strOptionTemplate) {
                                    echo "<select name='layout.temp'>{$strOptionTemplate}</select>";
                                } ?>
                            </div>
                        </div>
                        <div class="edit-show form-group">
                            <input type="submit"
                                data-button-magic
                                data-params-form=".post-form"
                                data-format-json="true"
                                data-ajax-url="<?=APIPOSTCONFIGPAGE?>"
                                data-redirect="."
                                data-show-success=".alert"
                                data-show-errors=".popup.signin-missing-session"
                                class="btn btn-primary"
                                value="<?=$language["update"]?>">
                            <button
                                onclick="location.reload();"
                                class="btn btn-second"><?=$language["reset"]?></button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="item-content">
                <h3 class="icon tab-title"><?=$language["cssCustom"]?></h3>
                <div class="tab-content">
                    <form method="post"
                        class="post-form post-form-about edit-disabled">
                        <span data-closet-toggle-class="edit-enabled"
                        data-object=".edit-disabled"
                        class="icon-edit-cancel icon-lg1 position-right"></span>
                        <input type="hidden" name="config.type" value="css">
                        <div class="form-group">
                            <label><?=$language["cssCustom"]?></label>
                            <code class="form-control-static"><?=$strCSS?></code>
                            <div class="edit-show">
                                <textarea name="css.style"
                                    class="form-control" style="min-height:400px;"><?=$strCSS?></textarea>
                            </div>
                        </div>
                        <div class="edit-show form-group">
                            <input type="submit"
                                data-button-magic
                                data-params-form=".post-form"
                                data-format-json="true"
                                data-ajax-url="<?=APIPOSTCONFIGPAGE?>"
                                data-redirect="."
                                data-show-success=".alert"
                                data-show-errors=".popup.signin-missing-session"
                                class="btn btn-primary"
                                value="<?=$language["update"]?>">
                            <button
                                onclick="location.reload();"
                                class="btn btn-second"><?=$language["reset"]?></button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="item-content">
                <h3 class="icon tab-title"><?=$language["header"]?></h3>
                <div class="tab-content">
                    <form method="post"
                        class="edit-add-item post-form post-form-about edit-disabled">
                        <span data-closet-toggle-class="edit-enabled"
                        data-object=".edit-disabled"
                        class="icon-edit-cancel icon-lg1 position-right"></span>
                        <input type="hidden" name="config.type" value="header">
                        <div class="fieldset">
                            <div class="form-group">
                                <label><?=$language["header"]?> 1</label>
                                <div class="form-control-static"><?=$strHeader1?></div>
                                <div class="edit-show">
                                    <textarea name="header.content1"
                                        class="form-control mce-editor"><?=$strHeader1?></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="fieldset">
                            <div class="form-group">
                                <label><?=$language["header"]?> 2</label>
                                <div class="form-control-static"><?=$strHeader2?></div>
                                <div class="edit-show">
                                    <textarea name="header.content2"
                                        class="form-control mce-editor"><?=$strHeader2?></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="fieldset">
                            <div class="edit-show form-group">
                                <input type="submit"
                                    data-button-magic
                                    data-params-form=".post-form"
                                    data-format-json="true"
                                    data-ajax-url="<?=APIPOSTCONFIGPAGE?>"
                                    data-redirect="."
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

            <div class="item-content">
                <h3 class="icon tab-title"><?=$language["customMenuBanner"]?></h3>
                <div class="tab-content">
                    <form method="post"
                        class="edit-add-item post-form post-form-about edit-disabled">
                        <span data-closet-toggle-class="edit-enabled"
                        data-object=".edit-disabled"
                        class="icon-edit-cancel icon-lg1 position-right"></span>
                        <input type="hidden" name="config.type" value="menubaner">
                        <div class="fieldset">
                            <div class="form-group">
                                <label><?=$language["customNavMenu"]?></label>
                                <div class="form-control-static"><?=$strMenu?></div>
                                <div class="edit-show">
                                    <textarea name="menubaner.menu"
                                        class="form-control mce-editor"><?=$strMenu?></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="fieldset">
                            <div class="form-group">
                                <label><?=$language["customBannerHome"]?></label>
                                <div class="form-control-static"><?=$strBanner?></div>
                                <div class="edit-show">
                                    <textarea name="menubaner.banner"
                                        class="form-control mce-editor"><?=$strBanner?></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="fieldset">
                            <div class="edit-show form-group">
                                <input type="submit"
                                    data-button-magic
                                    data-params-form=".post-form"
                                    data-format-json="true"
                                    data-ajax-url="<?=APIPOSTCONFIGPAGE?>"
                                    data-redirect="."
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
            <div class="item-content">
                <h3 class="icon tab-title"><?=$language["footer"]?></h3>
                <div class="tab-content">
                    <form method="post"
                        class="edit-add-item post-form post-form-about edit-disabled">
                        <span data-closet-toggle-class="edit-enabled"
                        data-object=".edit-disabled"
                        class="icon-edit-cancel icon-lg1 position-right"></span>
                        <input type="hidden" name="config.type" value="footer">
                        <div class="fieldset">
                            <div class="form-group">
                                <label><?=$language["footer"]?> 1</label>
                                <div class="form-control-static"><?=$strFooter1?></div>
                                <div class="edit-show">
                                    <textarea name="footer.content1"
                                        class="form-control mce-editor"><?=$strFooter1?></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="fieldset">
                            <div class="form-group">
                                <label><?=$language["footer"]?> 2</label>
                                <div class="form-control-static"><?=$strFooter2?></div>
                                <div class="edit-show">
                                    <textarea name="footer.content2"
                                        class="form-control mce-editor"><?=$strFooter2?></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="fieldset">
                            <div class="edit-show form-group">
                                <input type="submit"
                                    data-button-magic
                                    data-params-form=".post-form"
                                    data-format-json="true"
                                    data-ajax-url="<?=APIPOSTCONFIGPAGE?>"
                                    data-redirect="."
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
