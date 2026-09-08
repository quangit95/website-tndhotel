<?php
$isSuccessPost = false;
$isNextPaymentProcess = false;
if(isset($post["db"]["ui"]) && $post["db"]["ui"] == $sessionUserId) {

    $insertData = $post["db"];
    $insertData["cr"] = $currentTime;
    $insertData["ps"] = 1;

    if(isset($insertData["am"]) && $insertData["am"]) {
        $insertData["am"] = str_replace(',','', $insertData["am"]);
        $insertData["am"] = floatVal($insertData["am"]);
    } else {
        $insertData["am"] = 0;
    }

    if(isset($insertData["pm"]) ) {
        $payMethod =  $insertData["pm"];

        # Check Cash On Delivery And save content to note
        if(  $insertData["pm"]==5 && isset($post["cod"]) ) {
            $insertData["no"] = implode(' - ', $post["cod"]);
        }

        if($insertData["pm"]==2) {
            $insertData["no"] = implode(' - ', $post["sms"]);
            $isNextPaymentProcess = true;
        } elseif(floatval($insertData["am"]) > 0) {
            $isNextPaymentProcess = true;
            if($db->db_insert($insertData, TABLE_USER_PAYMENT)) {
                # update somthing
                $strRowJustInsert = "SELECT * from ".TABLE_USER_PAYMENT." WHERE ui = {$sessionUserId}
                                    AND am = {$insertData["am"]}
                                    AND pm = {$insertData["pm"]}
                                    AND cr = {$insertData["cr"]}
                                    ORDER BY id DESC LIMIT 0,1 ";
                $getRowJustInsert = $db->db_array($strRowJustInsert);

                if($getRowJustInsert) {
                    $orderAmt = isset($insertData["am"])?$insertData["am"]:0;
                    $orderTitle = "service id # 1";
                    $orderMore = "service id # 123";
                }
                #$isSuccessPost = true;
            }
        }

        $strPayFile = dirname(__FILE__)."/paymentmethod/{$payMethod}/checkout.php";
        if(is_file($strPayFile) && $isNextPaymentProcess) {
            require $strPayFile;
        } else {
            $code = 404;
            $errors = "Đơn hàng chưa hợp lệ";
        }
    }
}

if(! $isSuccessPost) {
    $code = $code ? $code : 404;
    $errors = isset($errors) ? $errors : null;
    $message = isset($message) ? $errors : null;
}

?>
