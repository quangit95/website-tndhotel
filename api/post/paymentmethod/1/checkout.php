<?php
// smartlink gateway

$smartlinkAPICredentials = isset($paymentSetting["smartlink"]) ? $paymentSetting["smartlink"] : null ;

$accessCode = isset($smartlinkAPICredentials["accessCode"]) ? $smartlinkAPICredentials["accessCode"] : 'ECAFAB';
$merchantID = isset($smartlinkAPICredentials["merchantID"]) ? $smartlinkAPICredentials["merchantID"] :'SMLTEST' ;

$setSecureSecret = isset($smartlinkAPICredentials["secure"]) ? $smartlinkAPICredentials["secure"] : "198BE3F2E8C75A53F38C1C4A5B6DBA27";



$fields= array(
    "vpc_Version" => "1",
    "vpc_Command" => "pay",
    "vpc_AccessCode" =>  $accessCode,
    "vpc_MerchTxnRef" => "create_01",
    "vpc_Merchant" => $merchantID,
    "vpc_OrderInfo" =>  "order info",
    "vpc_Amount" =>1000*100,
    "vpc_Locale" => "EN" ,
    "vpc_Currency" => "VND",
    "vpc_ReturnURL" => "",
    "vpc_BackURL" => "",
 );

$md5HashData = $setSecureSecret;
ksort ($fields);

// set a parameter to show the first pair in the URL
$appendAmp = 0;
$vpcURL = '';

foreach($fields as $key => $value) {

    // create the md5 input and URL leaving out any fields that have no value
    if (strlen($value) > 0) {

        // this ensures the first paramter of the URL is preceded by the '?' char
        if ($appendAmp == 0) {
            $vpcURL .= urlencode($key) . '=' . urlencode($value);
            $appendAmp = 1;
        } else {
            $vpcURL .= '&' . urlencode($key) . "=" . urlencode($value);
        }
        $md5HashData .= $value;
    }
}

$fields['vpc_SecureHash'] = strtoupper(md5($md5HashData));

// Create the secure hash and append it to the Virtual Payment Client Data if
// the merchant secret has been provided.
if (strlen($setSecureSecret) > 0) {
    $vpcURL .= "&vpc_SecureHash=" . strtoupper(md5($md5HashData));
}
if( isset($smartlinkAPICredentials["test"]) && intval($smartlinkAPICredentials["test"]) == 1 )
    $url = 'https://payment.smartlink.com.vn:8181/vpcpay.do?'.$vpcURL;
else
    $url = 'https://payment.smartlink.com.vn/vpcpay.do?'.$vpcURL;

echo $url;
die();
?>
