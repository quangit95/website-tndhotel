<?php
require dirname(__FILE__) . "/account.php";
#exchange currency to USD
$orderAmt = $orderAmt/20000;

// Set the return/cancel URL
$url = "http://{$_SERVER['HTTP_HOST']}/{$seo_name["page"]["user"]}?fun=config&node=recharge&checkout={$getRowJustInsert["id"]}&pm=3";
// Add some items to the transaction
$paypal->addItem($orderTitle, $orderMore, $orderAmt, 1);
$paypal->setCurrencyCode('USD');

// Initiate an Express Checkout transaction
$vpcURL = $paypal->setExpressCheckout($url, $url);

$paypalResponse = isset($paypal->response)? $paypal->response : null;
if(isset($paypalResponse["TOKEN"]) && $paypalResponse["TOKEN"] ) {
    #update TOKEN to user_payment
    $db->db_update(array("token"=>$paypalResponse["TOKEN"]), TABLE_USER_PAYMENT, array("id" => $getRowJustInsert["id"]));

    # var_dump($vpcURL);
    if($vpcURL) {
        $isSuccessPost = true;
        $code = 200;
        $message = '<img src="/img/style/ajax-loader.gif" class="img-payment"/>';
        $dataResponse = array("urlRedirect" => $vpcURL);

    } else {
        $code = 201;
        $message = 'invalidate authorization paypal';
    }
    # https://www.sandbox.paypal.com/webscr?cmd=_express-checkout&token=EC-6HK91804HU732653E
}

