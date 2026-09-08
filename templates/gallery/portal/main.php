<?php
$strClsColumnLeft = isset($strClsColumnLeft) ? $strClsColumnLeft:null;
$strClsColumnMain = isset($strClsColumnMain) ? $strClsColumnMain:null;
# $strClsColumnRight = isset($strClsColumnRight) ? $strClsColumnRight:null;
$strSidebarLeft = isset($strSidebarLeft) ? $strSidebarLeft:null;
$strSidebarRight = isset($strSidebarRight) ? $strSidebarRight:null;
?>
<div id="container">
    <div class="container">
        <?php
        if($strClsColumnMain):
        ?>
        <div class="row">
            <?php
            if(isset($strClsColumnLeft) && $strClsColumnLeft) {
                echo '<div class="'.$strClsColumnLeft.'">'.$strSidebarLeft.'</div>';
            }
            ?>
            <div class="<?=$strClsColumnMain?>">
                <main id="main">
                    <?php main(); ?>
                </main>
            </div>
            <?php
            if(isset($strClsColumnRight) && $strClsColumnRight) {
                echo '<div class="'.$strClsColumnRight.'">'.$strSidebarRight.'</div>';
            }
            ?>
        </div>
        <?php
        else :
        ?>
        <main id="main">
            <?php main(); ?>
        </main>
        <?php
        endif;
        ?>
    </div>
</div>
<div class="modal quick-view-item fade" data-quick-view-item data-modal-quick-view> <!--Embed view detail here--></div>
<div class="modal fade" data-quick-view-item1 data-modal-quick-view> <!--Embed apply job here--></div>
<div class="modal quick-view-sms fade"  data-quick-view-sms> <!--Embed apply job here--></div>
<div data-lightbox-show
    data-has-button-magic="true"
    data-lightbox-img="[data-lightbox-show] .lb-img"
    data-lightbox-button="[data-button]"
    data-lightbox-loader="[data-lightbox-show] .lb-loader"
    data-lightbox-content="[data-lightbox-show] .lb-content"
    data-lightbox-title="[data-lightbox-show] .lb-title">
    <div class="lb-content">
        <div class="modal-signin">
            <span data-button data-lightbox-btn-close class="lb-close  position-right"><i class="fa fa-times-circle fa-2x "></i></span>
        </div>
        <img class="lb-img" src="/img/style/ajax-loader.gif" />
        <div class="lb-nav">
            <a data-button value="-1"><i class="fa fa-chevron-circle-left"></i></a>
            <a data-button value="1"><i class="fa fa-chevron-circle-right"></i></a>
        </div>
        <div class="lb-loader"></div>
        <div class="lb-title">&nbsp;</div>
        <span class="btn btn-sendinquery"
            data-button-magic
            data-elm-data='{"layout1":{"left":"col-xs-12 col-sm-4","right":"col-xs-12 col-sm-8"} }'
            data-ajax-url="/api/get/model?mod=site&node=contact&modalTitle=<?=$language["contactSendInquery"]?>"
            data-method="get"
            data-view-template="[data-quick-view-item1]"
            data-template-id="entryFormElement">Tư vấn ngay</span>
    </div>
</div>
<div class="alert-footer alert" data-fade="3000">
    <div class="sms-content"></div>
</div>
<div class="alert-footer alert-error" data-fade="3000">
    <div class="sms-content"></div>
</div>
