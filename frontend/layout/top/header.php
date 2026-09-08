<!-- Header -->
<?php
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
            <div class="col-xs-12 col-sm-6 col-md-3">
                <div class="logo">
                    <a href="/">
                        <img src="<?="/".$strLogoWebsite?>" alt="<?=$informationWebsite["db"]["name"]?>">
                    </a>
                </div>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-4 hidden-xs hidden-sm header-box-search">
                <div class="top-search" data-copy-template="" data-get-url="/api/get/model?mod=site&node=search" data-view-template="#header .top-search" data-template-id="entryFormElement">&nbsp;</div>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-5 contact-info hidden-xs">
                <div class="row top-address">
                    <div class="col-xs-1"><em class="fa fa-map-marker">&nbsp;</em></div>
                    <div class="col-xs-11">
                        <?=$socialAddress?>
                    </div>
                </div>
                <div class="row top-hotline">
                    <div class="col-xs-1 col-sm-1"><em class="fa fa-phone">&nbsp;</em></div>
                    <div class="col-xs-11 col-sm-11">
                    <p><?=$socialHotline?></p> 
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
    endif;
    ?>
</div>
<div class="space-header"></div>
<!-- End Header -->
<?php
require dirname(__FILE__) . '/menu.php';
require dirname(__FILE__) . '/banner.php';
?>
