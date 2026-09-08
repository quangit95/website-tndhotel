<?php
echo $strFooter1;
?>
<div id="footer">
    <?php
		if($strFooter2){
			echo $strFooter2;
		}
		?>
</div>
<div class="btn-to-top" data-goto-top><span class="fa fa-arrow-circle-up"></span></div>
<?php
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
