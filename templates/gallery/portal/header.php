<?php
$header = isset($informationConfig["config"]["header"])? $informationConfig["config"]["header"] : null;
$strHeader1 = isset($header["content1"]) && ($header["content1"]) ? $header["content1"] : null;
$strHeader2 = isset($header["content2"]) && ($header["content2"]) ? $header["content2"] : null;

$menubaner = isset($informationConfig["config"]["menubaner"])? $informationConfig["config"]["menubaner"] : null;
$strMenuConfig = isset($menubaner["menu"]) && ($menubaner["menu"]) ? $menubaner["menu"] : null;
$strBannerConfig = isset($menubaner["banner"]) && ($menubaner["banner"]) ? $menubaner["banner"] : null;

$social = isset($informationConfig["config"]["social"])? $informationConfig["config"]["social"] : null;
$socialSkype = isset($social["skype"]) && !empty($social["skype"]) ? "skype:{$social["skype"]}?chat" : "skype:webbac1?chat";
$socialFacebook = isset($social["facebook"]) && !empty($social["facebook"]) ? $social["facebook"] : "https://facebook.com";
$socialHotline = isset($social["hotline"]) && count($social["hotline"]) ? $social["hotline"] : "";

if($strHeader1) {
    echo $strHeader1;
}
?>
<div id="header" class="relative">
    <?php
    if($strHeader2):
        echo $strHeader2;
    else:
    ?>
    <div class="container">
        <div class="row">
            <div class="col-xs-4 col-sm-4">
                <div class="logo-text">
                    <h2>PHPVNN<span>.com</span></h2>
                </div>
            </div>
            <div class="col-xs-12 hidden-xs col-sm-6">
                <div class="logo-slogan">Làm website cho đơn giản hơn</div>
            </div>
            <div class="col-xs-8 col-sm-2">
                <div class="user-header text-right in" data-copy-template="" data-view-template=".user-header" data-template-id="entryUserHeader"></div>
            </div>
        </div>
    </div>
    <?php
    endif;
    ?>
</div>
