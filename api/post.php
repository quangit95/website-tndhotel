<?php
$post = json_decode(file_get_contents('php://input'), true);
$dataResponse = null;
$currentTime = time();

if (isset($url_data[2])) {

    $validationPostUrl = array("convertjstoxmlfile", "product", "blog", "menu", "config");
    if (in_array($url_data[2], $validationPostUrl)) {
      if(!isset($_SESSION["adminlog"])) {
        die();
      }
    }
    $apiPostFile = "api/post/" . $url_data[2] . ".php";
    if (is_file($apiPostFile)) {
        require $apiPostFile;
    } else {
        $code = 500;
        $errors = "Internal Server Error";
    }
} else {
    // die();
}
if (!isset($responseSent) || !$responseSent) {
    response($dataResponse, $code, $message, $errors);
}
?>
