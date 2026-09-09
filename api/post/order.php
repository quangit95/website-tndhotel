<?php

$ordersValidate = false;
$strPickupDatetime = null;
if(isset($post["db"]["pickup"]["date"]) && $post["db"]["pickup"]["date"]) {
    $pickupDate = $post["db"]["pickup"]["date"];
    $strPickupDatetime = "<p><strong>Pickup:</strong> {$post["db"]["pickup"]["date"]} - {$post["db"]["pickup"]["hour"]}:{$post["db"]["pickup"]["minutes"]}</p>";
    $ordersValidate = true;
} else {
    $ordersValidate = true;
}

if($ordersValidate) {
    $file = FOLDERORDER . "order.xml";
    $itemList = null;
    if (is_file($file)) {
        $itemList = simplexml_load_file($file);
        $itemList = json_encode($itemList);
        $itemList = json_decode($itemList, true);
    }

    # Delete order or booking
    if (isset($post["updateNode"]) && $post["updateNode"] == "del" && isset($post["db"]["id"])) {
        $iId = intval($post["db"]["id"]);
        $node = 'id_' . $iId;
        $deleted = false;

        if (isset($itemList["table"][$node])) {
            unset($itemList["table"][$node]);
            saveXMLFile($file, $itemList);
            $deleted = true;
        }

        $fileBooking = FOLDERORDER . "booking.xml";
        if (is_file($fileBooking)) {
            $bookingList = simplexml_load_file($fileBooking);
            $bookingList = json_decode(json_encode($bookingList), true);
            if (isset($bookingList["table"][$node])) {
                unset($bookingList["table"][$node]);
                saveXMLFile($fileBooking, $bookingList);
                $deleted = true;
            }
        }

        if ($deleted) {
            $code = 200;
            $message = isset($language["updateSuccess"]) ? $language["updateSuccess"] : "Xoá thành công";
        } else {
            $code = 404;
            $errors = "not found order";
        }
    }
    # Update status for each order or booking
    elseif (isset($post["db"]["id"]) && intval($post["db"]["id"]) && isset($post["db"]["st"]) && intval($post["db"]["st"]) > 0 ) {

        $iId = intval($post["db"]["id"]);
        $node = 'id_' . $iId;
        $updated = false;

        if(isset($itemList["table"][$node]) && isset($post["db"]["st"]) ) {
            $itemList["table"][$node]["st"] = intval($post["db"]["st"]);
            if (saveXMLFile($file, $itemList)) {
                $fileInfo = FOLDERORDER . $iId . ".xml";
                if (is_file($fileInfo)) {
                    $information = simplexml_load_file($fileInfo);
                    $information = json_decode(json_encode($information), true);
                    $information["db"] = $itemList["table"][$node];
                    saveXMLFile($fileInfo, $information);
                }
                $updated = true;
            }
        }

        $fileBooking = FOLDERORDER . "booking.xml";
        if (is_file($fileBooking)) {
            $bookingList = simplexml_load_file($fileBooking);
            $bookingList = json_decode(json_encode($bookingList), true);
            if (isset($bookingList["table"][$node])) {
                $bookingList["table"][$node]["st"] = intval($post["db"]["st"]);
                if (saveXMLFile($fileBooking, $bookingList)) {
                    $updated = true;
                }
            }
        }

        if ($updated) {
            $code = 200;
            $message = isset($language["updateSuccess"]) ? $language["updateSuccess"] : "Cập nhật thành công";
        } else {
            $code = 404;
            $errors = "not found order";
        }

    } else {
        $storeId = 1;
        if(isset($_SESSION["cart"][$storeId]) && count($_SESSION["cart"][$storeId])) {
            $iId = 0;

            if (!$itemList) {
                $iId = 1;

            } else {
                $table = $itemList["table"];
                // edit Item
                if (isset($post["db"]["id"]) && intval($post["db"]["id"]) > 0) {
                    $iId = intval($post["db"]["id"]);
                } else {
                    // add Item
                    $endElmTable = end($table);
                    $iId = intval($endElmTable["id"]) + 1;
                }
            }

            $node = 'id_' . $iId;

            require dirname(__FILE__)."/../get/calculator_orders.php";

            $strOrderProductInfo = "<hr>
            <p>&nbsp;</p>
            <h3>{$language["ordersInformation"]}</h3>
            <p>&nbsp;</p>
            <table border=\"1\" cellpadding=\"10\"  cellspacing=\"0\" style=\"width:100%; border-collapse: collapse;\">
                <tr>
                    <th>STT</th>
                    <th>{$language["id"]}</th>
                    <th>{$language["product"]}</th>
                    <th>{$language["quantity"]}</th>
                    <th align=\"right\">{$language["price"]}</th>
                </tr>
                {$strOrderProductInfo}
                <tr>
                    <td colspan=\"5\" align=\"right\"><strong>{$language["total"]}: {$totalMoney}</strong></td>
                </tr>
            </table>";

            // set id for post
            $post["db"]["id"] = $iId;
            $post["db"]["tt"] = $totalMoney;
            $post["db"]["dt"] = $currentTime;
            $row = $post["db"];

            #validate form before insert into list xml
            foreach ($row as $key => $value) {
                $value = preg_replace('!\s+!', ' ', $value);
                if($value !==' ') {
                    $row[$key] = $value;
                }
            }

            $row["st"]=1;

            // create row before save
            $itemList["table"][$node] = $row;
            // save item to file
            if (saveXMLFile($file, $itemList)) {
                $fileInfo = FOLDERORDER . $iId . ".xml";
                if (is_file($fileInfo)) {
                    $information = simplexml_load_file($fileInfo);
                    $information = json_encode($information);
                    $information = json_decode($information, true);
                }

                $information["db"] = $post["db"];
                $information["order"] = $tmpRow;
                // save file detail
                if (saveXMLFile($fileInfo, $information)) {
                    $dataResponse["table"][$node] = $post;
                    $code = 200;
                    $message = $language["updateSuccess"];
                    #SEND MAIL

                    $strEmailRow = null;
                    $emailConfig = isset($informationConfig["config"]["email"]) ? $informationConfig["config"]["email"] : null;
                    $strEmailto = isset($emailConfig["orders"])? $emailConfig["orders"] : "124phn@gmail.com";


                    if(!isset($database)) {
                      require "setting/db.php";
                    }
                    if(isset($post["db"]["cit"]) && isset($post["db"]["dis"])) {
                        $strCity = $database->get("local_city", ["ti"], ["id"=>$post["db"]["cit"]] );
                        $strDistrict = $database->get("local_district", ["ti"], ["id"=>$post["db"]["dis"]] );
                    }
                    $strCity = isset($strCity["ti"]) ? $strCity["ti"] : null ;
                    $strDistrict = isset($strDistrict["ti"]) ? $strDistrict["ti"] : null ;

                    if(isset($row["em"]) && $row["em"]) {
                        $strEmailRow = "<p><strong>{$language["yourEmail"]}:</strong> {$row["em"]}</p>";
                        $listMailCC = array(
                            array(
                                'email'=>$row["em"],
                                'name'=>$row["fn"],
                            )
                        );
                    }
                    $message = $language["orderSuccess"];
                    if(isset($informationWebsite["db"]["im"])) {
                        $strWebsite = "<a href=\"{$informationWebsite["db"]["url"]}\">
                                    <img src=\"{$protocol}{$domainName}/{$strLogoWebsite}\" alt=\"{$informationWebsite["db"]["name"]}\" width=\"200px\">
                                </a>";
                    } else {
                        $strWebsite = "<a href=\"{$informationWebsite["db"]["url"]}\">{$informationWebsite["db"]["name"]}</a>";
                    }

                    $strSubject = "From website {$informationWebsite["db"]["name"]} orders ".date('d-m-Y')." - MS#{$iId}";
                    $strAddress = (isset($row["add"]) && $strDistrict && $strCity) ? "<p><strong>{$language["address"]}:</strong> {$row["add"]} - <strong>{$strDistrict} - {$strCity}</strong></p>" : null;

                    $htmlSMS = "<table cellpadding=\"10\" cellspacing=\"0\">
                        <tr>
                            <td>
                                {$strWebsite}
                            </td>
                            <td>
                                <p><strong>{$language["fullname"]}:</strong> {$row["fn"]}</p>
                                {$strEmailRow}
                                <p><strong>{$language["yourNumber"]}:</strong> {$row["ph"]}</p>
                                {$strAddress}
                                <p><strong>{$language["noteOrder"]}:</strong> {$row["no"]}</p>
                                {$strPickupDatetime}
                            </td>
                        </tr>
                        </table>";
                    // require "{$strDataFolderTemplate}newsletter/order.php";

                    $htmlSMS = "<h3>{$strSubject}</h3><br>".$htmlSMS.$strOrderProductInfo;
                    $sendMailObj = isset($sendMailObj) ? $sendMailObj : array(
                        "from" => "info@phpvnn.com",
                        "to" => $strEmailto,
                        "sender" => "Phpvnn team website",
                        "receiver" => "User",
                        "reply" => "info@phpvnn.com",
                        "replyInfo" => "Phpvnn.com",
                        "subject" => $strSubject,
                        "content" => $htmlSMS,
                    );

                    require dirname(__FILE__) . "/sendmail.php";

                } else {
                    $code = 501;
                    $errors = $language["unknownErrors"];
                }
                unset($_SESSION["cart"][$storeId]);

            } else {
                $code = 501;
                $errors = $language["unknownErrors"];
            }
        }
        else {
            $code = 401;
            $errors = "No found product is bought";
        }
    }
} else {
    $code = 401;
    $errors = "Orders invalid, Day of week should be not monday";
}


?>
