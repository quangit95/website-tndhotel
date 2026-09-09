<?php
if(!$linkReferer) {
    die();
}
$dataList = array();
if (isset($url_data[3]) && $url_data[3] ) {
    $iId = intval($url_data[3]);
    $file = FOLDERORDER . $iId . ".xml";

    $information = null;
    if (is_file($file)) {
        $information = simplexml_load_file($file);
        $information = json_encode($information);
        $information = json_decode($information, true);
        $dataResponse = $information;
        $code = 200;
    } else {
        // Fallback to booking.xml for single booking view
        $fileBooking = FOLDERORDER . "booking.xml";
        if (is_file($fileBooking)) {
            $bookingXml = simplexml_load_file($fileBooking);
            $bookingArr = json_decode(json_encode($bookingXml), true);
            $node = "id_" . $iId;
            if (isset($bookingArr["table"][$node])) {
                $b = $bookingArr["table"][$node];
                $adult = !empty($b["adult"]) ? intval($b["adult"]) : 1;
                $child = !empty($b["child"]) ? intval($b["child"]) : 0;
                $guestStr = $adult . " Người lớn" . ($child > 0 ? ", " . $child . " Trẻ em" : "");
                $stayDates = !empty($b["dt"]) ? $b["dt"] : "";
                
                $dataResponse = array(
                    "db" => array(
                        "id" => intval($b["id"] ?? $iId),
                        "fn" => $b["fn"] ?? "",
                        "em" => $b["em"] ?? "",
                        "ad" => "Phòng: " . ($b["ti"] ?? "") . ($stayDates ? " (Lưu trú: " . $stayDates . ")" : ""),
                        "ph" => $b["ph"] ?? "",
                        "no" => "Thời gian: " . $stayDates . " | Khách: " . $guestStr . (!empty($b["no"]) ? " | Ghi chú: " . $b["no"] : ""),
                        "st" => intval($b["st"] ?? 1),
                        "tt" => isset($b["tt"]) ? $b["tt"] : 0
                    ),
                    "order" => array(
                        array(
                            "id" => intval($b["pid"] ?? ($b["id"] ?? $iId)),
                            "title" => ($b["ti"] ?? "Phòng khách sạn") . ($stayDates ? " [" . $stayDates . "]" : "") . " - " . $guestStr,
                            "quantity" => 1,
                            "price" => isset($b["tt"]) ? $b["tt"] : 0
                        )
                    )
                );
                $code = 200;
            } else {
                $code = 404;
                $errors = "not found item";
            }
        } else {
            $code = 404;
            $errors = "not found item";
        }
    }
}
else {

    $file = FOLDERORDER . "order.xml";
    $information = null;
    if (is_file($file)) {
        $information = simplexml_load_file($file);
        $information = json_encode($information);
        $information = json_decode($information, true);
    }

    $code = 200;
    if (!$information || empty($information["table"])) {
        // Fallback to hotel room bookings from booking.xml
        $fileBooking = FOLDERORDER . "booking.xml";
        if (is_file($fileBooking)) {
            $bookingXml = simplexml_load_file($fileBooking);
            $bookingArr = json_decode(json_encode($bookingXml), true);
            if (!empty($bookingArr["table"])) {
                foreach ($bookingArr["table"] as $k => $b) {
                    $adult = !empty($b["adult"]) ? intval($b["adult"]) : 1;
                    $child = !empty($b["child"]) ? intval($b["child"]) : 0;
                    $guestStr = $adult . " Người lớn" . ($child > 0 ? ", " . $child . " Trẻ em" : "");
                    $stayDates = !empty($b["dt"]) ? $b["dt"] : "";
                    $createdTime = !empty($b["cr"]) ? intval($b["cr"]) : time();

                    $dataList[$k] = array(
                        "id" => intval($b["id"] ?? str_replace('id_', '', $k)),
                        "fn" => $b["fn"] ?? "",
                        "ph" => $b["ph"] ?? "",
                        "em" => $b["em"] ?? "",
                        "no" => "Phòng: " . ($b["ti"] ?? "") . " (" . $guestStr . ")" . (!empty($b["no"]) ? " - Ghi chú: " . $b["no"] : ""),
                        "add" => ($b["ti"] ?? "Phòng khách sạn"),
                        "tt" => isset($b["tt"]) ? $b["tt"] : 0,
                        "dt" => $createdTime,
                        "pm" => "Đặt phòng online",
                        "pickup" => array(
                            "date" => $stayDates,
                            "hour" => "",
                            "minutes" => ""
                        ),
                        "st" => intval($b["st"] ?? 1),
                        "room_name" => $b["ti"] ?? "",
                        "stay_dates" => $stayDates
                    );
                }
            }
        }
    } else {
        $dataList = $information["table"];
    }


    if(isset($_GET["identity"]) && $_GET["identity"]) {

        if (filter_var($_GET["identity"], FILTER_VALIDATE_EMAIL)) {
            $dataList = array_filter($dataList, function ($obj) {
                if(isset($obj["em"]) && $obj["em"] == $_GET["identity"]){
                    return true;
                }
                return false;
            });
        } else {
            $dataList = array_filter($dataList, function ($obj) {
                if(isset($obj["ph"]) && $obj["ph"] == $_GET["identity"]){
                    return true;
                }
                return false;
            });
        }

        $dataResponse = array_values($dataList);
        if(count($dataResponse)>0) {
            if(isset($_GET["lastid"])) {
                $itemResponse = $dataResponse[count($dataResponse)-1];
            } elseif(isset($_GET["firstid"])) {
                $itemResponse = $dataResponse[0];
            }

            $dataResponse = $itemResponse;

        } else {
            $code = 201; 
            $errors = "there was no your information found";
        }

        if(isset($_GET["strStorage"]) && $_GET["strStorage"]) {
            $dataResponse[$_GET["strStorage"]] =  json_encode($_GET);
        }
        
        
    } else {
        if(!$linkReferer) {
            die();
        }

        if (isset($_GET["from"]) && $_GET["from"]) {
            $filter_array = array_filter($dataList, function ($obj) {
                if (!isset($obj["dt"])) {
                    return false;
                }
                if($obj["dt"] >= $_GET["from"]){
                    return true;
                }
                return false;
            });
            $dataList = $filter_array;
        }

        if (isset($_GET["to"]) && $_GET["to"]) {
            $filter_array = array_filter($dataList, function ($obj) {
                if (!isset($obj["dt"])) {
                    return false;
                }
                if($obj["dt"] <= $_GET["to"]){
                    return true;
                }
                return false;
            });
            $dataList = $filter_array;
        }


        if(isset($_GET["sortId"]) && $_GET["sortId"]) {
            if($_GET["sortId"] == 'ASC') {
                usort($dataList, function($a, $b)
                {
                    return intval($a["id"] ?? 0) <=> intval($b["id"] ?? 0);
                });
            }
            else {
                usort($dataList, function($a, $b)
                {
                    return intval($b["id"] ?? 0) <=> intval($a["id"] ?? 0);
                });
            }
        }

        if (isset($_GET["limit"])) {
            $dataList = array_slice( $dataList, 0, intval($_GET["limit"]) );
        }
        $dataResponse = array_values($dataList);
    }
}
?>
