<?php
$footer = isset($informationConfig["config"]["footer"])? $informationConfig["config"]["footer"] : null;
$strFooter1 = isset($footer["content1"]) && ($footer["content1"]) ? $footer["content1"] : "";
$strFooter2 = isset($footer["content2"]) && ($footer["content2"]) ? $footer["content2"] : "";
$advertise = isset($informationConfig["config"]["advertise"])? $informationConfig["config"]["advertise"] : null;
echo $strFooter1?$strFooter1:'';
?>
<div id="footer">
    <?=$strFooter2;?>
</div>
<div style="width:40px;">
    <div data-goto-top data-fixed="#header" data-fixed-class="btn-to-top-fixed" class="btn-to-top"><span class="fa fa-arrow-circle-up"></span></div>
</div>
<?php
if(isset($advertise["left"]) && count($advertise["left"]) ) {
    echo '<div data-ads-scroll class="ads-scroll-left">'.$advertise["left"].'</div>';
}
if(isset($advertise["right"]) && count($advertise["right"]) ) {
    echo '<div data-ads-scroll class="ads-scroll-right">'.$advertise["right"].'</div>';
}
?>
