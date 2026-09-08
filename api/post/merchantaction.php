<?php
$mod = isset($post["mod"]) ? $post["mod"] : null;
$mi = isset($post["db"]["mi"]) ? $post["db"]["mi"] : null;

$isAction = false;
#validate merchant

if (isset($_SESSION["merchantlog"]["id"]) && $_SESSION["merchantlog"]["id"] == $mi ) {
    $isAction = true;
}

if($isAction) {
    if($mod == 'orders') {
        $infoUpdate = $post["db"];
        if( $db->db_update($infoUpdate, TABLE_ORDERS, array("id" => $infoUpdate["id"], "mi"=> $mi ))) {
            $code = 200;
            $message = $language["updateSuccess"];
        }
    } elseif($mod == 'mega645') {
        $infoUpdate = $post["db"];
        if( $db->db_update($infoUpdate, TABLE_ORDERSLOTTERY, array("id" => $infoUpdate["id"], "mi"=> $mi ))) {
            $code = 200;
            $message = $language["updateSuccess"];
        }
    } else {
        $code = 201;
        $message = $language["unknownErrors"];
    }

} else {
    $code = 404;
    $message = $language["unknownErrors"];
}
?>
