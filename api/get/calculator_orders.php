<?php
$cartInfo = array();
$storeId = 1;
$totalMoney = 0;
$totalItem = 0;
$i = 0;
$strOrderProductInfo = null;
if(isset($_SESSION["cart"][$storeId])) {
  foreach ($_SESSION["cart"][$storeId] as $key => $value) {
      $fileInfo = FOLDERPRODUCT . "{$key}.xml";
      $i++;

      if (is_file($fileInfo)) {
          $information = simplexml_load_file($fileInfo);
          $information = json_encode($information);
          $information = json_decode($information, true);
          $totalItem += $value;

          $price = isset($information["db"]["pr"]) ? $information["db"]["pr"] : array();

          $item = array(
              "id"=>$information["db"]["id"],
              "ti"=>$information["db"]["ti"],
              "qt"=>$value,
              "im"=>isset($information["db"]["im"]) ?$information["db"]["im"]:null,
          );

          $item["pr"] = isset($price["sale"]) && !empty($price["sale"]) ? $price["sale"] : 0;

          $strPrice = '<span style="color:#F01;">'.$item["pr"].'</span>';
          if(isset($price["off"]) && !empty($price["off"]) ){
              $item["sa"] = $price["off"];
              $totalMoney += $item["sa"]*$value;
              $strPrice = '<span style="text-decoration: line-through;">'.$item["pr"].'</span><span style="color:#F01;">'.$item["sa"].'</span>';
          } else {
              $totalMoney += $item["pr"]*$value;
          }


          $tmpRow["pid_{$key}"] = $item;
          unset($tmpRow["pid_{$key}"]["im"]);


          $strTitle = $item["ti"];
          if($multiLanguage) {
            $strTitle= $strTitle[$langcode];
          }

          $strOrderProductInfo .= "<tr>
                    <td>{$i}</td>
                    <td>#{$key}</td>
                    <td><strong>{$strTitle}</strong></td>
                    <td>{$value}</td>
                    <td align=\"right\">{$strPrice}</td>
                </tr>";

          $cartInfo[]= $item;
      }
  }
  $dataResponse["items"] = $cartInfo;
  $dataResponse["more"] = array(
      "total"=>$totalMoney,
      "totalItem"=>$totalItem
  );
}
?>
