<?php
function main() {
    global $seo_name, $language, $informationConfig, $url_data;
    $method = isset($url_data[1]) ? $url_data[1] : null;

    $fileCheckout = FOLDERPAYMENT . "checkout.xml";
    $itemList = null;

    if (is_file($fileCheckout)) {
        $itemList = simplexml_load_file($fileCheckout);
        $itemList = json_encode($itemList);
        $itemList = json_decode($itemList, true);
    }

    $iId = 0;
    if (!$itemList) {
        $iId = 1000000;
    } else {
        $table = $itemList["table"];
        $endElmTable = end($table);
        $iId = intval($endElmTable["id"]) + 1;
    }
    $node = 'id_' . $iId;
    // set id for post
    $infoUpdate["id"] = $iId;
    $infoUpdate["created"] = time();
    // update row before save

    if($method == "paypal") {
        $infoUpdate["method"] = "paypal";
        require 'api/post/paymentmethod/paypal/PayPal.class.php';
        $paypalAPICredentials = $informationConfig["config"]["payment"]["paypal"];
        $username = $paypalAPICredentials["username"];
        $password = $paypalAPICredentials["password"];
        $signature = $paypalAPICredentials["signature"];
        $environment = "LIVE";
        if(isset($paypalAPICredentials["sandbox"]) && count($paypalAPICredentials["sandbox"]) &&$paypalAPICredentials["sandbox"]==1) {
            $environment = "SANDBOX";
        }
        $paypal = new PayPal($environment, $username, $password, $signature);
        // Complete an Express Checkout transaction
        $payment = $paypal->doExpressCheckoutPayment();
        if($payment) {
            $infoUpdate["status"] = 1;
            $infoUpdate["detail"] = array("token" => $payment["TOKEN"],
                        "ack" => $payment["ACK"],
                        "timestamp" => $payment["TIMESTAMP"],
                        "transactionid" => $payment["PAYMENTINFO_0_TRANSACTIONID"],
                        "status" => $payment["PAYMENTINFO_0_PAYMENTSTATUS"],
                        "amt" => $payment["PAYMENTINFO_0_AMT"]);
            $itemList["table"][$node]=$infoUpdate;
            // save item to file
            if (saveXMLFile($fileCheckout, $itemList) ) {
                $fileInfo = FOLDERPAYMENT . $iId . ".xml";
                if (is_file($fileInfo)) {
                    $information = simplexml_load_file($fileInfo);
                    $information = json_encode($information);
                    $information = json_decode($information, true);
                }
                $information["db"] = $itemList["table"][$node];
                if($payment) {
                    $information["checkoutPayment"] = $payment;
                }
                saveXMLFile($fileInfo, $information);
            }
            # payment success info
        }
        else {
            #void refund
        }
    }
    else {
        #updating ...
    }
}
?>
