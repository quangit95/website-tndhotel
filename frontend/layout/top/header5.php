<!-- Header -->
<div class="headerwrap">
    <span data-object=".website" data-closet-toggle-class="menu-active" class="icon-menu hidden-md hidden-lg">
        <span class="fa fa-navicon">&nbsp;</span>
    </span>
    <div class="header-container">
        <?php
        if($strHeader1) { echo $strHeader1;}
        ?>
        <div id="header" class="relative">
            <?php
            if($strHeader2):
                echo $strHeader2;
            else:
            ?>
            <div class="logo">
            <a href="/"><img src="<?="/".$strLogoWebsite?>" alt="<?=$informationWebsite["db"]["name"]?>"> </a>
            </div>
            <?php
            endif;
            ?>
        </div>
        <!-- End Header -->
    </div>
</div>
<?php
require dirname(__FILE__) . '/menu_in_banner.php';
?>
