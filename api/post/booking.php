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


        $hotelEmail = isset($informationConfig["config"]["email"]["orders"]) && !empty($informationConfig["config"]["email"]["orders"]) 
            ? $informationConfig["config"]["email"]["orders"] 
            : "info@tndhotelnhatrang.com";

        $salesEmail = isset($informationConfig["config"]["email"]["sales"]) && !empty($informationConfig["config"]["email"]["sales"])
            ? $informationConfig["config"]["email"]["sales"]
            : "sales1@tndhotelnhatrang.com";

        $customerEmail = isset($post["db"]["em"]) && !empty($post["db"]["em"]) ? trim($post["db"]["em"]) : null;
        $customerName = isset($post["db"]["fn"]) && !empty($post["db"]["fn"]) ? trim($post["db"]["fn"]) : "Quý khách";
        $customerPhone = isset($post["db"]["ph"]) ? trim($post["db"]["ph"]) : "";
        $roomTitle = isset($post["db"]["ti"]) ? $post["db"]["ti"] : "Phòng khách sạn";
        $roomTime = isset($post["db"]["dt"]) ? $post["db"]["dt"] : "";
        $roomAdult = isset($post["db"]["adult"]) ? $post["db"]["adult"] : "1";
        $roomChild = isset($post["db"]["child"]) && !empty($post["db"]["child"]) ? $post["db"]["child"] : "0";
        $bookingCreatedTime = date('d/m/Y H:i:s');

        // Customer Confirmation Email Template
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

        // Admin & Sales Notification Email Template
        $adminSubject = "[ĐƠN ĐẶT PHÒNG MỚI] MS#{$iId} - {$roomTitle} - Khách: {$customerName} ({$customerPhone})";
        $customerEmailDisplay = $customerEmail ? $customerEmail : "Chưa cung cấp";

        $adminEmailHtmlContent = "
<div style='font-family: Arial, Helvetica, sans-serif; max-width: 650px; margin: 0 auto; border: 1px solid #dcdcdc; border-radius: 8px; overflow: hidden;'>
    <div style='background: #c29219; color: #ffffff; padding: 18px 24px;'>
        <h2 style='margin: 0; font-size: 20px;'>THÔNG BÁO ĐẶT PHÒNG MỚI - TND HOTEL</h2>
        <p style='margin: 5px 0 0; font-size: 13px; opacity: 0.95;'>Mã đơn đặt phòng: <strong>MS#{$iId}</strong> &bull; Thời gian đặt: {$bookingCreatedTime}</p>
    </div>
    <div style='padding: 24px; color: #333333; line-height: 1.6; background: #ffffff;'>
        <p style='font-size: 15px; margin-top: 0;'>Kính gửi <strong>Ban quản trị & Phòng Kinh doanh TND Hotel</strong>,</p>
        <p style='font-size: 14px;'>Hệ thống website vừa nhận được một yêu cầu đặt phòng mới từ khách hàng. Thông tin chi tiết:</p>

        <div style='background: #fdfbf6; border: 1px solid #faebcc; border-left: 5px solid #c29219; padding: 16px; margin: 18px 0; border-radius: 4px;'>
            <h3 style='margin: 0 0 12px; color: #a1770e; font-size: 15px; text-transform: uppercase;'>1. Thông tin phòng đặt</h3>
            <table style='width: 100%; border-collapse: collapse; font-size: 14px;'>
                <tr>
                    <td style='padding: 6px 0; color: #666; width: 35%;'>Mã số đơn:</td>
                    <td style='padding: 6px 0; font-weight: bold; color: #222;'>MS#{$iId}</td>
                </tr>
                <tr>
                    <td style='padding: 6px 0; color: #666;'>Hạng phòng:</td>
                    <td style='padding: 6px 0; font-weight: bold; color: #c29219; font-size: 15px;'>{$roomTitle}</td>
                </tr>
                <tr>
                    <td style='padding: 6px 0; color: #666;'>Thời gian lưu trú:</td>
                    <td style='padding: 6px 0; font-weight: bold; color: #222;'>{$roomTime}</td>
                </tr>
                <tr>
                    <td style='padding: 6px 0; color: #666;'>Số lượng khách:</td>
                    <td style='padding: 6px 0; font-weight: bold; color: #222;'>{$roomAdult} Người lớn &bull; {$roomChild} Trẻ em</td>
                </tr>
            </table>
        </div>

        <div style='background: #f8f9fa; border: 1px solid #e9ecef; border-left: 5px solid #495057; padding: 16px; margin: 18px 0; border-radius: 4px;'>
            <h3 style='margin: 0 0 12px; color: #343a40; font-size: 15px; text-transform: uppercase;'>2. Thông tin khách hàng</h3>
            <table style='width: 100%; border-collapse: collapse; font-size: 14px;'>
                <tr>
                    <td style='padding: 6px 0; color: #666; width: 35%;'>Họ và tên khách:</td>
                    <td style='padding: 6px 0; font-weight: bold; color: #222; font-size: 15px;'>{$customerName}</td>
                </tr>
                <tr>
                    <td style='padding: 6px 0; color: #666;'>Số điện thoại:</td>
                    <td style='padding: 6px 0; font-weight: bold; color: #d9534f; font-size: 16px;'><a href='tel:{$customerPhone}' style='color: #d9534f; text-decoration: none;'>{$customerPhone}</a></td>
                </tr>
                <tr>
                    <td style='padding: 6px 0; color: #666;'>Email khách hàng:</td>
                    <td style='padding: 6px 0; font-weight: bold; color: #0275d8;'><a href='mailto:{$customerEmail}' style='color: #0275d8; text-decoration: none;'>{$customerEmailDisplay}</a></td>
                </tr>
            </table>
        </div>

        <div style='margin-top: 20px; padding: 14px; background: #eef7fc; border: 1px solid #bce8f1; border-radius: 4px; font-size: 14px; color: #31708f;'>
            <strong>Nhắc nhở:</strong> Vui lòng liên hệ lại khách hàng qua số điện thoại <strong>{$customerPhone}</strong> để xác nhận đặt phòng và thông báo các thủ tục nhận phòng.
        </div>
    </div>
    <div style='background: #f4f4f4; padding: 12px; text-align: center; font-size: 12px; color: #777; border-top: 1px solid #eaeaea;'>
        Hệ thống gửi tự động từ Website TND Hotel Nha Trang &bull; Quản trị web &amp; Phòng kinh doanh
    </div>
</div>";

        // 1. Gửi email thông báo đơn đặt phòng mới về Quản trị web (To: info@tndhotelnhatrang.com, CC: sales1@tndhotelnhatrang.com)
        $sendMailObj = array(
            "from" => $hotelEmail,
            "to" => $hotelEmail,
            "sender" => "TND Hotel Website",
            "receiver" => "TND Hotel Admin",
            "reply" => $customerEmail ? $customerEmail : $hotelEmail,
            "replyInfo" => $customerEmail ? $customerName : "TND Hotel Nha Trang",
            "subject" => $adminSubject,
            "content" => $adminEmailHtmlContent,
        );
        $listMailCC = array(
            array(
                "email" => $salesEmail,
                "name" => "Phòng Kinh Doanh - TND Hotel"
            )
        );
        require dirname(__FILE__) . "/sendmail.php";

        // 2. Gửi email xác nhận đặt phòng trực tiếp cho Khách hàng (nếu khách có điền email)
        if($customerEmail) {
            $sendMailObj = array(
                "from" => $hotelEmail,
                "to" => $customerEmail,
                "sender" => "TND Hotel Nha Trang",
                "receiver" => $customerName,
                "reply" => $hotelEmail,
                "replyInfo" => "TND Hotel Nha Trang",
                "subject" => $strSubject,
                "content" => $emailHtmlContent,
            );
            $listMailCC = null;
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
