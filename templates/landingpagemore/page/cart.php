<?php

function main() {
    global $seo_name, $language, $pageInfo, $informationConfig, $storeId, $formatCurrency;
    $storeId = 1;
    $order = isset($informationConfig["config"]["order"])? $informationConfig["config"]["order"] : null;
    $orderNote = isset($order["note"]) && strval($order["note"]) ? $order["note"] : null;
    $orderSuccess = isset($order["success"]) && strval($order["success"]) ? $order["success"] : null;

    if(isset($_SESSION["cart"][$storeId])) {
    ?>
        <div class="row">
            <div class="col-xs-12 col-sm-4 col-md-4">
                <div class="online-ordering-list" data-copy-template="" data-get-url="/api/get/cart" data-view-template=".online-ordering-list" data-template-id="entryCartInfo">My Order</div>
            </div>
            <div class="col-xs-12 col-sm-8 col-md-8">
                <div class="online-customer-info" data-copy-template="" data-get-url="/api/get/cart" data-view-template=".online-customer-info" data-template-id="entryOrderForm">Customer info</div>
            </div>
        </div>

    <?php
    }
    else {
        echo '<div data-goto-link data-url="/" > </div>';
    }

}
?>
