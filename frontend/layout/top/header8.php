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
            <div class="col-xs-12 col-sm-4 col-md-3">
                <div class="logo">
                    <a href="/">
                        <img src="<?="/".$strLogoWebsite?>">
                    </a>
                </div>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-7 hidden-xs">
                <div class="top-search" data-copy-template="" data-get-url="/api/get/model?mod=site&node=search" data-view-template="#header .top-search" data-template-id="entryFormElement">&nbsp;</div>
            </div>
            <div class="col-xs-12 col-sm-2 col-md-2 contact-info hidden-xs">
                <div class="box-shop">
                    <a href="#"><i class="fa fa-shopping-cart"></i> Giỏ hàng</a>
                </div>
            </div>
        </div>
    </div>
    <?php
    endif;
    ?>
</div>
<div class="space-header"></div>
