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
            <div class="col-xs-12 col-sm-4">
                <div class="hidden-sm hidden-md hidden-lg">
                    <div class="row">
                        <div class="col-xs-6">
                            <div class="logo">
                                <a href="/">
                                    <img src="<?="/".$strLogoWebsite?>" alt="<?=$informationWebsite["db"]["name"]?>">
                                </a>

                            </div>
                        </div>
                        <div class="col-xs-6">
                            <div class="icon-menu text-right">
                                <span data-object=".website" data-closet-toggle-class="mobile-active"> <span class="fa fa-navicon fa-2x">&nbsp;</span> </span> <span data-object=".website" data-closet-toggle-class="mobile-active"> <span class="fa fa-close fa-2x">&nbsp;</span> </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="hidden-xs">
                    <div class="logo text-right">
                        <a href="/"><img src="<?="/".$strLogoWebsite?>" alt="<?=$informationWebsite["db"]["name"]?>"> </a>
                    </div>
                </div>
            </div>
            <div class="col-xs-12 hidden-xs col-sm-7 col-sm-offset-1">
                <div class="header-content">
                    <address><span class="fa fa-map-marker"> </span> <?=$socialAddress?></address>
                    <p>
                        <a href="tel:<?=$socialHotline?>"><em class="fa fa-phone"> </em> <?=$socialHotline?> </a> - <em class="fa fa-envelope-o"></em> <?=$socialEmail?>
                    </p>
                </div>
            </div>
        </div>
    </div>
    <?php
    endif;
    ?>
</div>
<!-- End Header -->
<?php
require dirname(__FILE__) . '/menu3.php';
echo '<div class="space-header"></div>';
require dirname(__FILE__) . '/banner.php';
?>
