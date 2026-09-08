<?php
require dirname(__FILE__) . '/state/us.php';
$dataResponse = array();
foreach ($countryState as $key => $value) {
    $dataResponse[$value["code"]] = $value["state"];
}
?>
