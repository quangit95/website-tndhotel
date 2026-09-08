<!DOCTYPE html>
<!--[if lt IE 9]><html class="no-js ie lt-ie9"><![endif]-->
<!--[if gt IE 8]><!-->
<html>
<!--<![endif]-->
  <?php
  require dirname(__FILE__) . "/morescript.php";
  require dirname(__FILE__) . "/meta/head_admin.php";
  // $dataOfDrive = sizeOfDirectory("storage/pagedata/{$websiteId}");
  // echo $dataOfDrive;
  ?>
  <body data-tinymce-menubar="true" class="website-id-<?=$websiteId?>">
    <div class="admin-page ">
        <div id="header" class="relative">
            <div class="container">
                <div class="row">
                    <div class="col-xs-6 col-sm-4 col-md-4">
                        <a class="logo" href="/">
                            <?php
                            echo $strLogoWebsite ? '<img src="'.$strLogoWebsite.'" alt="'.$informationWebsite["db"]["name"].'">' : '<h3>'.$informationWebsite["db"]["name"].'</h3>';
                            ?>

                        </a>
                    </div>
                    <div class="col-xs-6 col-sm-8 col-md-8">
                        <div class="btn-header">
                            <a class="btn btn-default btn-sm" target="_blank" href="/"><i class="fa fa-home"></i></a>
                            <span class="btn btn-warning btn-sm" data-button-magic="" data-ajax-url="/api/post/signout" data-method="POST" data-format-json="true" data-params="{&quot;uid&quot;:&quot;1&quot;}" data-redirect="."><i class="fa fa-sign-out"></i> Logout</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="container">
            <?php main(); ?>
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
    <?php if(isset($sessionUserId) && $sessionUserId) { ?>
    <script src="<?=APIGETUSER.'/'.$sessionUserId."?var=window.userAccess";?>"></script>
    <?php } ?>
    <script src="/api/get/lang?var=window.languageText"></script>
    <?php
    if(isset($isFrontendDev) && $isFrontendDev) {
        echo '<script src="/api/get/backend?var=designTemplates"></script>';
    } else {
        echo '<script src="/frontend/js/backend.js?time='.intval(time()/(3600*24)).'"></script>';
    }
    ?>

    <script src="/storage/pagedata/assets/local.js"></script>
    <script src="/frontend/js/Chart.js"></script>
    <script src="/frontend/js/clientlibs.js?v=<?=time()?>"></script>
    <script type="text/javascript" src="/frontend/plugins/tinymce/tinymce.min.js"></script>
    <script type="text/javascript" src="/frontend/plugins/tinymce/init.js"></script>
    <?=isset($informationWebsite["script"]["javascript"]) && !empty($informationWebsite["script"]["javascript"])? $informationWebsite["script"]["javascript"]:null;?>
    <!--[if lt IE 9]><div class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</div><![endif]-->
  </body>
</html>
