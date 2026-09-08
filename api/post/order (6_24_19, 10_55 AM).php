<?php

$ordersValidate = false;
if(isset($post["db"]["pickup"]["date"]) && $post["db"]["pickup"]["date"]) {
    $pickupDate = $post["db"]["pickup"]["date"];

    $dayofweek = date('w', strtotime($pickupDate));
    if($dayofweek !=1) {
        $ordersValidate = true;
    }
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

    # Update status for each order
    if (isset($post["db"]["id"]) && intval($post["db"]["id"]) && isset($post["db"]["st"]) > 0 ) {

        $iId = intval($post["db"]["id"]);
        $node = 'id_' . $iId;

        if(isset($itemList["table"][$node]) && isset($post["db"]["st"]) ) {
            $itemList["table"][$node]["st"] = intval($post["db"]["st"]);
            $code = 200;
        }
        else {
            $code = 404;
            $errors = "not found order";
            die;
        }

        // save item to file
        if ($code ==200 && saveXMLFile($file, $itemList)) {
            $fileInfo = FOLDERORDER . $iId . ".xml";
            if (is_file($fileInfo)) {
                $information = simplexml_load_file($fileInfo);
                $information = json_encode($information);
                $information = json_decode($information, true);
            }
            $information["db"] = $itemList["table"][$node];
            // save file detail
            if (saveXMLFile($fileInfo, $information)) {
                $code = 200;
                $message = $language["updateSuccess"];
            } else {
                $code = 501;
                $errors = $language["unknownErrors"];
            }

        } else {
            $code = 501;
            $errors = $language["unknownErrors"];
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
            $tmpRow = array();
            $total = 0;
            $i = 0;
            $strOrderProductInfo = null;
            foreach ($_SESSION["cart"][$storeId] as $key => $value) {
                $i++;
                $fileInfo = FOLDERPRODUCT . "{$key}.xml";
                if (is_file($fileInfo)) {
                    $productInfo = simplexml_load_file($fileInfo);
                    $productInfo = json_encode($productInfo);
                    $productInfo = json_decode($productInfo, true);
                    $price = 0;
                    if(isset($productInfo["db"]["pr"])) {
                        $price = $productInfo["db"]["pr"];
                        if(isset($price["off"]) && count($price["off"]) ){
                            $price = $price["off"];
                        }
                        else {
                            $price = $price["sale"];
                        }
                    }
                    $total += $price*$value;

                    $tmpRow["pid_{$key}"] = array('id'=>$key,
                        "title"=>$productInfo["db"]["ti"],
                        'quantity'=>$value,
                        'price'=>$price
                    );

                    $strOrderProductInfo .= "<tr>
                        <td>{$i}</td>
                        <td>#{$key}</td>
                        <td><strong>{$productInfo["db"]["ti"]}</strong></td>
                        <td>{$value}</td>
                        <td>{$price}</td>
                    </tr>";
                }
            }

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
                    <td colspan=\"5\" align=\"right\"><strong>{$language["total"]}: {$total}</strong></td>
                </tr>
            </table>";

            // set id for post
            $post["db"]["id"] = $iId;
            $post["db"]["tt"] = $total;
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
                    require "{$strDataFolderTemplate}newsletter/order.php";
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
