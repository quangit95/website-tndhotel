<?php

$nodeUpdate = isset($post["updateNode"])? $post["updateNode"]:null;
$infoUpdate = null;

$file = FOLDERORDER . "booking.xml";
$itemList = null;
if (is_file($file)) {
    $itemList = simplexml_load_file($file);
    $itemList = json_encode($itemList);
    $itemList = json_decode($itemList, true);
}

if($nodeUpdate == "db") {
    $infoUpdate = isset($post[$nodeUpdate]) ? $post[$nodeUpdate] : $infoUpdate;
    $iId = 0;
    if (!$itemList) {
        $iId = 1;
    } else {
        $table = $itemList["table"];
        // edit Item
        if (isset($infoUpdate["id"]) && intval($infoUpdate["id"]) > 0) {
            $iId = intval($infoUpdate["id"]);
        } else {
            // add Item
            $endElmTable = end($table);
            $iId = intval($endElmTable["id"]) + 1;
        }
    }
    $node = 'id_' . $iId;

    if(isset($infoUpdate["st"]) && intval($infoUpdate["st"])){
        $infoUpdate["st"] = intval($infoUpdate["st"]);
    } else {
        $infoUpdate["st"] = 1;
    }
    // set id for post
    $infoUpdate["id"] = $iId;
    $infoUpdate["cr"] = $currentTime;


    $strInfoBooking = null;
    $strInfoCustomer = null;

    if(isset($post["db"]["ti"]) && !empty($post["db"]["ti"])) {
        $strInfoBooking .= '<p>'.$post["db"]["ti"].'</p>';
    }
    if(isset($post["db"]["adult"]) && !empty($post["db"]["adult"]) ) {
        $strInfoBooking .= '<p>Adult: '.$post["db"]["adult"].'</p>';
    }
    if(isset($post["db"]["child"]) && !empty($post["db"]["child"])) {
        $strInfoBooking .= '<p>Child: '.$post["db"]["child"].'</p>';
    }

    if(isset($post["db"]["dt"]) && !empty($post["db"]["dt"])) {
        $strInfoBooking .= '<p>Time: '.$post["db"]["dt"].'</p>';
    }
    if(isset($post["db"]["fn"]) && !empty($post["db"]["fn"])) {
        $strInfoCustomer .= '<p>'.$post["db"]["fn"].'</p>';
    }
    if(isset($post["db"]["em"]) && !empty($post["db"]["em"])) {
        $listMailCC = array(
            array(
                "email"=>$post["db"]["em"],
                "name"=>$post["db"]["fn"],
            )
        );

        $strInfoCustomer .= '<p>'.$post["db"]["em"].'</p>';
    }
    if(isset($post["db"]["ph"]) && !empty($post["db"]["ph"])) {
        $strInfoCustomer .= '<p>'.$post["db"]["ph"].'</p>';
    }

    $itemList["table"][$node] = $infoUpdate;
    if (saveXMLFile($file, $itemList)) {
        $code = 200;

        $message = '<p>Cảm ơn bạn đã liên hệ.</p><p>Chúng tôi sẽ liên lạc với bạn trong thời gian sớm nhất.</p>';
        $messageBooking = '<div><h3>Booking info</h3>'.$strInfoBooking.'</div><hr>'.'<div><h3>Customer info</h3>'.$strInfoCustomer.'</div>';
        $dataResponse = array("sms"=>$messageBooking);


        $strEmailto = isset($informationConfig["config"]["email"]["orders"]) && !empty($informationConfig["config"]["email"]["orders"]) 
            ? $informationConfig["config"]["email"]["orders"] 
            : "info@tndhotelnhatrang.com";

        $customerEmail = isset($post["db"]["em"]) && !empty($post["db"]["em"]) ? trim($post["db"]["em"]) : null;
        $customerName = isset($post["db"]["fn"]) && !empty($post["db"]["fn"]) ? trim($post["db"]["fn"]) : "Quý khách";
        $customerPhone = isset($post["db"]["ph"]) ? trim($post["db"]["ph"]) : "";
        $roomTitle = isset($post["db"]["ti"]) ? $post["db"]["ti"] : "Phòng khách sạn";
        $roomTime = isset($post["db"]["dt"]) ? $post["db"]["dt"] : "";
        $roomAdult = isset($post["db"]["adult"]) ? $post["db"]["adult"] : "1";
        $roomChild = isset($post["db"]["child"]) && !empty($post["db"]["child"]) ? $post["db"]["child"] : "0";

        $strSubject = "[TND Hotel] Xác nhận đặt phòng / Booking Confirmation - MS#{$iId}";

        $emailHtmlContent = "
<div style='font-family: Arial, Helvetica, sans-serif; max-width: 600px; margin: 0 auto; border: 1px solid #e2d5b5; border-radius: 8px; overflow: hidden;'>
    <div style='background: #d8a72c; color: #ffffff; padding: 20px; text-align: center;'>
        <h2 style='margin: 0; text-transform: uppercase; font-size: 22px; letter-spacing: 1px;'>TND HOTEL NHA TRANG</h2>
        <p style='margin: 6px 0 0; font-size: 14px; opacity: 0.95;'>Xác nhận đặt phòng &bull; Booking Confirmation</p>
    </div>
    <div style='padding: 25px; color: #333333; line-height: 1.6; background: #ffffff;'>
        <p style='font-size: 15px; margin-top: 0;'>Kính gửi Quý khách <strong>{$customerName}</strong>,</p>
        <p style='font-size: 14px;'>Cảm ơn Quý khách đã đặt phòng tại <strong>TND Hotel Nha Trang</strong>. Hệ thống xin gửi thông tin chi tiết đơn đặt phòng của Quý khách:</p>
        
        <div style='background: #faf7f0; border-left: 4px solid #d8a72c; padding: 15px 18px; margin: 20px 0; border-radius: 0 6px 6px 0;'>
            <h3 style='margin: 0 0 12px; color: #b5891a; font-size: 15px; text-transform: uppercase;'>Chi tiết đặt phòng (Mã số: MS#{$iId})</h3>
            <table style='width: 100%; border-collapse: collapse; font-size: 14px;'>
                <tr>
                    <td style='padding: 6px 0; color: #666; width: 40%;'>Hạng phòng / Room:</td>
                    <td style='padding: 6px 0; font-weight: bold; color: #222;'>{$roomTitle}</td>
                </tr>
                <tr>
                    <td style='padding: 6px 0; color: #666;'>Thời gian / Time:</td>
                    <td style='padding: 6px 0; font-weight: bold; color: #222;'>{$roomTime}</td>
                </tr>
                <tr>
                    <td style='padding: 6px 0; color: #666;'>Người lớn / Adults:</td>
                    <td style='padding: 6px 0; font-weight: bold; color: #222;'>{$roomAdult}</td>
                </tr>
                <tr>
                    <td style='padding: 6px 0; color: #666;'>Trẻ em / Children:</td>
                    <td style='padding: 6px 0; font-weight: bold; color: #222;'>{$roomChild}</td>
                </tr>
            </table>
        </div>

        <div style='background: #f8f9fa; border-left: 4px solid #6c757d; padding: 15px 18px; margin: 20px 0; border-radius: 0 6px 6px 0;'>
            <h3 style='margin: 0 0 12px; color: #495057; font-size: 15px; text-transform: uppercase;'>Thông tin khách hàng</h3>
            <table style='width: 100%; border-collapse: collapse; font-size: 14px;'>
                <tr>
                    <td style='padding: 6px 0; color: #666; width: 40%;'>Họ và tên / Full name:</td>
                    <td style='padding: 6px 0; font-weight: bold; color: #222;'>{$customerName}</td>
                </tr>
                <tr>
                    <td style='padding: 6px 0; color: #666;'>Số điện thoại / Phone:</td>
                    <td style='padding: 6px 0; font-weight: bold; color: #222;'>{$customerPhone}</td>
                </tr>
                <tr>
                    <td style='padding: 6px 0; color: #666;'>Email:</td>
                    <td style='padding: 6px 0; font-weight: bold; color: #222;'>{$customerEmail}</td>
                </tr>
            </table>
        </div>

        <p style='font-size: 14px; margin-top: 20px;'>Nhân viên khách sạn sẽ sớm liên hệ với Quý khách qua số điện thoại <strong>{$customerPhone}</strong> để xác nhận chi tiết.</p>
        <p style='font-size: 14px; margin-bottom: 5px;'>Quý khách cần hỗ trợ thêm thông tin vui lòng liên hệ:</p>
        <ul style='font-size: 14px; color: #555; padding-left: 20px; margin-top: 5px;'>
            <li><strong>Hotline:</strong> 0258 3 822 999</li>
            <li><strong>Email:</strong> info@tndhotelnhatrang.com</li>
            <li><strong>Địa chỉ:</strong> 07 Lê Lợi, Phường Nha Trang, Tỉnh Khánh Hòa, Việt Nam</li>
        </ul>
    </div>
    <div style='background: #f4f4f4; padding: 15px; text-align: center; font-size: 12px; color: #777; border-top: 1px solid #eee;'>
        <p style='margin: 0;'>TND Hotel Nha Trang &bull; 07 Lê Lợi, Nha Trang, Khánh Hòa</p>
        <p style='margin: 4px 0 0;'>Website: <a href='http://tndhotelnhatrang.com' style='color: #d8a72c; text-decoration: none;'>tndhotelnhatrang.com</a></p>
    </div>
</div>";

        if($customerEmail) {
            // Send directly to customer, CC hotel admin
            $sendMailObj = array(
                "from" => $strEmailto,
                "to" => $customerEmail,
                "sender" => "TND Hotel Nha Trang",
                "receiver" => $customerName,
                "reply" => $strEmailto,
                "replyInfo" => "TND Hotel Nha Trang",
                "subject" => $strSubject,
                "content" => $emailHtmlContent,
            );
            $listMailCC = array(
                array(
                    "email" => $strEmailto,
                    "name" => "TND Hotel Orders"
                )
            );
            require dirname(__FILE__) . "/sendmail.php";
        } elseif($strEmailto) {
            // Customer did not enter email, send to hotel only
            $sendMailObj = array(
                "from" => $strEmailto,
                "to" => $strEmailto,
                "sender" => "TND Hotel Website",
                "receiver" => "TND Hotel Admin",
                "reply" => $strEmailto,
                "replyInfo" => "TND Hotel Website",
                "subject" => $strSubject,
                "content" => $emailHtmlContent,
            );
            require dirname(__FILE__) . "/sendmail.php";
        }

    } else {
        $code = 201;
        $errors = '<p>Invalidation post.</p>';
    }

} elseif($nodeUpdate == "del" && isset($post["id"])) {
    # delete node
    $iId = $post["id"];
    $node = 'id_' . $iId;

    try {
        # remove item from file database
        if(isset($itemList["table"][$node])) {
            unset($itemList["table"][$node]);
            if (saveXMLFile($file, $itemList)) {
                $code = 200;
                $message = $language["updateSuccess"];
            }
        }
        else {
            $code = 404;
            $errors = "Not found ITEM";
        }
    } catch (Exception $ex) {
        $code = 501;
        $errors = $language["unknownErrors"];
    }

}
?>
