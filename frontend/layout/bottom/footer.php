<?php
echo $strFooter1;
?>
<div id="footer">
    <?php
	if($strFooter2){
		echo $strFooter2;
	} else {
	?>
	<div class="container">
		<div class="row">
			<div class="col-xs-12 hidden-xs col-sm-3 form-group">
				<h3><?=$informationWebsite["db"]["name"]?></h3>
				<?= $strBasicPage ? '<ul class="check-list">'.$strBasicPage.'</ul>':null;?>
			</div>
			<div class="col-xs-12 col-sm-4">
				<?php
				if($strDataFolderTemplate == "templates/testonline/"){
				?>
				<h3><?=$language["subject"]?></h3>
				<div class="footer-category" data-copy-template="" data-view-template-local="true" data-option-local="menuStructure" data-object="menuStructure" data-filter-in="opp=6" data-view-template=".footer-category" data-template-id="entryLinkCategory"></div>
				<?php
				} else {
				?>
				<h3><?=$language["product"]?></h3>
				<?= $strBasicPage ? '<ul class="check-list list-cat-product">'.$strProductPage.'</ul>':null;?>
				<?php
				}
				?>
			</div>
			<div class="col-xs-12 col-sm-5 form-group">
				<h3><?=$language["contact"]?></h3>
				<div class="row form-group">
					<div class="col-xs-1"><em class="fa fa-map-marker">&nbsp;</em></div>
					<div class="col-xs-11">
						<address><?=$socialAddress?></address>
					</div>
				</div>
				<div class="row form-group">
					<div class="col-xs-1"><em class="fa fa-envelope-o">&nbsp;</em></div>
					<div class="col-xs-11">
					<p><?=$socialEmail?></p>
					</div>
				</div>
				<div class="row form-group">
					<div class="col-xs-1 col-sm-1"><em class="fa fa-phone">&nbsp;</em></div>
					<div class="col-xs-11 col-sm-11">
					<p><?=$socialHotline?></p>
					</div>
				</div>
				<?php
				if($socialFacebook) {?>
				<div class="row form-group">
					<div class="col-xs-1"><em class="fa fa-facebook">&nbsp;</em></div>
					<div class="col-xs-11">
						<a href="<?=$socialFacebook?>" class="text-ellipsis"><?=$socialFacebook?></a>
					</div>
				</div>
				<?php } ?>
			</div>
		</div>
		<div class="row hidden-xs border-footer-column">
			<div class="col-sm-3">&nbsp;</div>
			<div class="col-sm-4">&nbsp;</div>
		</div>
	</div>
	<?php
	}
    ?>
</div>
<div class="btn-to-top" data-goto-top><span class="fa fa-arrow-circle-up"></span></div>
<?php
if(isset($advertise["left"]) && !empty($advertise["left"]) ) {
    echo '<div data-ads-scroll class="ads-scroll-left">'.$advertise["left"].'</div>';
}
if(isset($advertise["right"]) && !empty($advertise["right"]) ) {
    echo '<div data-ads-scroll class="ads-scroll-right">'.$advertise["right"].'</div>';
}

if(isset($advertise["main"]) && !empty($advertise["main"]) ) {
    if(!isset($_SESSION['flashMessage'])) {
        $_SESSION['flashMessage'] = true;
        echo '<div class="modal quick-view-item in">
        <div class="modal-content modal-ads-popup">
            <span class="fa fa-times-circle fa-2x position-right" data-closet-toggle-class="in" data-object=".modal" data-empty-object="[data-quick-view-item1]"></span>
            <div class="modal-body">'.$advertise["main"].'</div></div></div>';
    }
}
?>
