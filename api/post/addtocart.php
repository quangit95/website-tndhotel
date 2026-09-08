<?php
if(!isset($post["pid"]) || !isset($post["sid"]) ) {
    $code = 401;
    $message = "store not found";
}
else {
    if($post["sid"] && $post["pid"]) {
        $pid = $post["pid"];
        $nodeStore = $post["sid"];

        $isdelete = false;

        if( isset($_SESSION["cart"][$nodeStore][$pid]) ) {
            $total = intval($_SESSION["cart"][$nodeStore][$pid]);
        }
        else {
            $total = 0;
        }

        if(isset($post["add"]) && intval($post["add"])) {
            $total += intval($post["add"]);
        }

        if(isset($post["remove"]) && intval($post["remove"])) {
            $total -= intval($post["remove"]);
        }

        if(isset($post["update"]) && intval($post["update"])) {
            $total = intval($post["update"]);
        }

        if(isset($post["del"]) && $post["del"]==1) {
            $isdelete = true;
        }

        $_SESSION["cart"][$nodeStore][$pid] = $total;

        if($total <= 0 || $isdelete) {
            unset($_SESSION["cart"][$nodeStore][$pid]);
        }

        $code = 200;
        $message = isset($post["ti"]) ? $post["ti"] : $language["productAddedToCart"];
    }
    else {
        $code = 401;
        $message = "store not found";
    }
}

if( $code == 200 ) {
    require dirname(__FILE__)."/../get/calculator_orders.php";
}
?>
