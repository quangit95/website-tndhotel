<?php
require dirname(__FILE__) . "/PayPal.class.php";
$paypalAPICredentials = isset($paymentSetting["paypal"]) ? $paymentSetting["paypal"] : null ;
$username = isset($paypalAPICredentials["username"]) ? $paypalAPICredentials["username"] : '124phn-facilitator_api1.gmail.com';
$password = isset($paypalAPICredentials["password"]) ? $paypalAPICredentials["password"] :'87U9LFTHUSG3PDU9' ;
$signature = isset($paypalAPICredentials["signature"]) ? $paypalAPICredentials["signature"] :'AiPC9BjkCyDFQXbSkoZcgqH3hpacAdI2Fak8rEJFnWkIEsdpYtUFYpI7';

$environment = "LIVE";
if(isset($paypalAPICredentials["sandbox"]) && $paypalAPICredentials["sandbox"] ) {
    $environment = "SANDBOX";
}
$paypal = new PayPal($environment, $username, $password, $signature);
?>
