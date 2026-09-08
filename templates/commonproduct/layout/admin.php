<!DOCTYPE html>
<!--[if lt IE 9]><html class="no-js ie lt-ie9"><![endif]-->
<!--[if gt IE 8]><!-->
<html>
<!--<![endif]-->
  <?php
  require "frontend/morescript.php";
  require dirname(__FILE__) . '/../portal/head_admin.php';
  ?>
  <body data-tinymce-menubar="true">
    <div class="admin-page">
        <?php
        require dirname(__FILE__) . "/../portal/header.php";
        require dirname(__FILE__) . "/../portal/menu.php";
        ?>
        <div id="container">
            <div class="container">
                <main id="main">
                    <?php main(); ?>
                </main>
            </div>
        </div>
        <div class="modal quick-view-item fade" data-quick-view-item data-modal-quick-view> <!--Embed view detail here--></div>
        <div class="modal fade" data-quick-view-item1 data-modal-quick-view> <!--Embed apply job here--></div>
        <div class="modal quick-view-sms fade"  data-quick-view-sms> <!--Embed apply job here--></div>
        <div class="alert-footer alert" data-fade="3000"><div class="sms-content"></div></div>
        <div class="alert-footer alert-error" data-fade="3000"><div class="sms-content"></div></div>
        <div class="modal modal-option-file-upload"  data-quick-view-sms> </div>
        <span class="btn btn-default hidden browser-files-option"
            data-button-magic
            data-method="post"
            data-ajax-url="<?=APIPOSTFOLDERUPLOAD."?uid={$sessionUserId}"?>"
            data-view-template=".modal-option-file-upload"
            data-template-id="entryOptionFilesUpload">Button</span>
        <div id="footer">
            <div class="container">
                <?=$strSiteby?>
            </div>
        </div>
    </div>
    <noscript>JavaScript is off. Please enable to view full site.</noscript>
    <script src="/api/get/lang?var=window.languageText"></script>
    <script src="/api/get/backend?var=designTemplates"></script>
    <script src="/storage/pagedata/assets/local.js"></script>
    <script src="/frontend/js/clientlibs.js"></script>
    <script type="text/javascript" src="/frontend/plugins/tinymce/tinymce.min.js"></script>
    <script type="text/javascript" src="/frontend/plugins/tinymce/init.js"></script>
    <?=isset($informationWebsite["script"]["javascript"]) && !empty($informationWebsite["script"]["javascript"])? $informationWebsite["script"]["javascript"]:null;?>
    <!--[if lt IE 9]><div class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</div><![endif]-->
  </body>
</html>
