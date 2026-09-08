<?php
$titlePage = isset($_GET["manage"]) ? $_GET["manage"] : "daskboard";

function main() {
    global $db, $language, $url_data, $sessionUserId, $informationConfig, $titlePage, $isAdminPage;
    $featureFile = "/" . $titlePage . ".php";

    $functionTemplate = null;
    $mod = isset($_GET["mod"]) ? $_GET["mod"] : null;

    $strGetScript = null;

    if (!isset($_SESSION["adminlog"]) ) {
        $strGetUrl = APIGETMODEL."?mod=site&node=signin";
        if(isset($isAdminPage) && $isAdminPage) {
            $strGetUrl = APIGETMODEL."?mod=user&node=signinadmin&nomodal=1";
        }
        $functionTemplate = "entryFormElement";
        ?>
        <div class="row">
            <div class="col-xs-12 col-sm-6">
                <div class="admin-management"
                    data-get-url="<?=$strGetUrl?>"
                    data-copy-template
                    data-view-template=".admin-management"
                    data-template-id="<?=$functionTemplate?>">
                </div>
            </div>
        </div>
        <?php
    } else {
        $strGetUrl = null;
        $strElmData = null;
        ?>
        <div class="row">
            <div class="col-xs-12 col-sm-3 col-md-2">
                <div class="sidebar user-functionality"
                    data-elm-data='{"mod":"<?=$mod?>", "<?=$titlePage?>":"1"}'
                    data-copy-template
                    data-view-template=".user-functionality"
                    data-template-id="entryUserFunctionality">&nbsp;</div>
            </div>
            <div class="col-xs-12 col-sm-9 col-md-10">
        <?php
        if($mod && is_file(dirname(__FILE__) . "/{$mod}.php")) {
            $titlePage = $mod;
            require dirname(__FILE__) .  "/{$mod}.php";
        }
        else {
            if($titlePage == "config") {
                $strGetUrl = APIGETCONFIG;
                $functionTemplate = "viewSettingPage";
            } elseif($titlePage == "layout") {
                $strGetUrl = APIGETCONFIG;
                $functionTemplate = "viewUpdateLayout";
            } elseif($titlePage == "sidebar") {
                $strGetUrl = APIGETCONFIG;
                $functionTemplate = "viewUpdateSidebar";
            } elseif($titlePage == "payment") {
                $strGetUrl = APIGETCONFIG;
                $functionTemplate = "viewUpdatePayment";
            } elseif($titlePage == "password") {
                $strGetUrl = APIGETCONFIG;
                $functionTemplate = "viewUpdatePassword";
            } elseif($titlePage == "product") {
                $functionTemplate = "viewProductManage";
            } elseif($titlePage == "blog") {
                $functionTemplate = "viewBlogManage";
            } elseif($titlePage == "menu") {
                $functionTemplate = "viewMenuManage";
            } elseif($titlePage == "agency") {
                $functionTemplate = "viewAgencyManage";
            } elseif($titlePage == "review") {
                $functionTemplate = "viewReviewManage";
            } elseif($titlePage == "contact") {
                $strAjaxUrl = APIGETCONTACT;
                $strGetScript = '<script src="'.$strAjaxUrl.'?var=window.contactusManage"></script>';
                $functionTemplate = "viewContactManage";
            } elseif($titlePage == "checkout") {
                $functionTemplate = "viewCheckoutManage";
            }
            echo $strGetScript;
            ?>
            <div class="admin-management"
                data-get-url="<?=$strGetUrl?>"
                data-elm-data='<?=$strElmData?>'
                data-copy-template
                data-view-template=".admin-management"
                data-template-id="<?=$functionTemplate?>">
            </div>
            <?php
        }
        ?>
        </div>
    </div>
    <?php
    }
}
?>
