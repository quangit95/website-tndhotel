<?php
$post["password"] = md5($post["password"]);
$post["created"] = $currentTime;
$post["status"] = 1;

// INSERT DATA
if ($db->db_insert($post, TABLE_USER)) {

  $str_query = "SELECT * FROM ".TABLE_USER."
                WHERE email='" . $post["email"] . "' AND created=$currentTime LIMIT 0,1";

  $row = $db->db_array($str_query);

  // var_dump($row);

  if ($row) {
    if(isset($row["password"])) {
      unset($row["password"]);
    }
    $file = FOLDERUSER . $row["id"] . ".xml";
    $information["userinfo"] = array(
      "db" => $row,
    );
    saveXMLFile($file, $information);
    $_SESSION["userlog"] = $row;

    // var_dump($information);

    # require dirname(__FILE__) . "/sendmail.php";

    $code = 200;
    $message = $language["signupSuccess"];

  }
  $isDone = true;

} else {
  $code = 401;
  $errors = $language["signupErrors"];
}
?>
