<?php
$code = 200;
$message = "Success";
if(isset($_GET)) {
    foreach ($_GET as $key => $value) {
        $post[$key]= $value;
    }
}

if(isset($_GET["dellast"])){
  if(isset($post["db"][$_GET["dellast"]]) && is_array($post["db"][$_GET["dellast"]])) {
    array_pop($post["db"][$_GET["dellast"]]);
  }
}

$dataResponse = $post;
?>
