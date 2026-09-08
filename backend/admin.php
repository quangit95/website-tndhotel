<?php
$titlePage = isset($_GET["manage"]) ? $_GET["manage"] : (isset($_GET["p"]) ? $_GET["p"] : "daskboard");

function main() {
    global $db, $language, $url_data, $sessionUserId, $informationConfig, $titlePage, $isAdminPage;
    $featureFile = "/" . $titlePage . ".php";

    $functionTemplate = null;
    $strLocalOption = null;
    $mod = isset($_GET["mod"]) ? $_GET["mod"] : null;

    $daysBack = 365;

    $tmpFrom = date("Y-m-d",strtotime("-{$daysBack} days"));
    $tmpTo = date("Y-m-d");
    if(isset($_POST["date"])) {
        $postDate = explode(' - ', $_POST["date"]);
        $tmpFrom = $postDate[0];
        $tmpTo = $postDate[1];
    }


    $tmpFrom = explode('-', $tmpFrom);
    $tmpTo = explode('-', $tmpTo);
    $intFrom = mktime(0, 0, 0, $tmpFrom[1], $tmpFrom[2],$tmpFrom[0]);
    $intTo = mktime(23, 59, 59, $tmpTo[1], $tmpTo[2],$tmpTo[0]);
    $tmpFrom = implode("-", $tmpFrom);
    $tmpTo = implode("-", $tmpTo);

    $strElmParams = ",\"date\":\"{$tmpFrom} - {$tmpTo}\",\"to\":\"{$intTo}\",\"from\":\"{$intFrom}\" ";


    $strGetScript = null;

    if (!isset($_SESSION["adminlog"]) ) {
        $strGetUrl = APIGETMODEL."?mod=site&node=signin";
        if(isset($isAdminPage) && $isAdminPage) {
            $strGetUrl = APIGETMODEL."?mod=user&node=signinadmin&nomodal=1";
        }
        $functionTemplate = "entryFormElement";
        ?>
        <div class="container">
            <div class="form-login-admin">
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
            </div>
        </div>
        <?php
    } else {
        $strGetUrl = null;
        $strElmData = null;
        ?>
        <div class="relative main-session">
            <div class="main-module">
                <div class="sidebar user-functionality"
                    data-elm-data='{"mod":"<?=$mod?>", "<?=$titlePage?>":"1"}'
                    data-copy-template
                    data-view-template=".user-functionality"
                    data-template-id="entryUserFunctionality">&nbsp;</div>
            </div>
            <div class="main-content">
        <?php
        if($mod && is_file(dirname(__FILE__) . "/{$mod}.php")) {
            $titlePage = $mod;
            require dirname(__FILE__) .  "/{$mod}.php";
        }
        else {
            if($titlePage == "daskboard") {
                $functionTemplate = "entryAdminHomePage";
            } elseif($titlePage == "config") {
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
            } elseif($titlePage == "filter") {
                $functionTemplate = "viewFilterManage";
            } elseif($titlePage == "review") {
                $functionTemplate = "viewReviewManage";
            } elseif($titlePage == "contact") {
                $strGetUrl = APIGETCONTACT;
                $strGetScript = '<script src="'.$strGetUrl.'?var=window.contactusManage"></script>';
                $functionTemplate = "viewContactManage";
            } elseif($titlePage == "questionnaires") {
                $functionTemplate = "questionnairesManage";
            } elseif($titlePage == "checkout") {
                $functionTemplate = "viewCheckoutManage";
            } elseif($titlePage == "newPlugins") {
                $functionTemplate = isset($_GET["strTemp"]) ? $_GET["strTemp"]:null;
            }
            
            echo $strGetScript;
            $strElmData = "{\"elmop\":\"1\" {$strElmParams} }";
            ?>
            <div class="admin-management"
                data-get-url="<?=$strGetUrl?>"
                data-elm-data='<?=$strElmData?>'
                <?=$strLocalOption?>
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
