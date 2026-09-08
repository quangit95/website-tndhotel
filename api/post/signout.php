<?php
if(isset($_SESSION["userlog"])) {
    unset($_SESSION["userlog"]);
}

if(isset($_SESSION["adminlog"])) {
    unset($_SESSION["adminlog"]);
}
$node = isset($post["node"]) && $post["node"] ? $post["node"] : null;

if(isset($isAdminPage) && $isAdminPage) {
  if($node="signout" && $post["signout"]) {
    $database->delete(TABLE_USER_TOKEN, [
      "AND" => $post["signout"]
    ]);
  }
}

$code = 200;
$message = $language["updateSuccess"];
?>
