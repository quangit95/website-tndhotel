<?php
#if (!$sessionUserId)
if (!isset($_SESSION["adminlog"])) {
    $code = 401;
    $message = $language["sessionExpiration"];
} else {
    if(isset($_POST["folder"])) {
        $path = FOLDERUPLOAD.$_POST["folder"];

        $maxSize = isset($_POST["db_size"]) ? intval($_POST["db_size"]):1000000;
        $types = isset($_POST["db_types"]) ? explode(",", $_POST["db_types"]) : array("jpeg", "jpg", "png", "gif");

        if($path && is_dir($path)) {
            $filterFiles = null;
            if(isset($_POST["filesoptioned"])&& $_POST["filesoptioned"] ) {
                $filterFiles = explode('::::', $_POST["filesoptioned"]);
            }
            $validextensions = array("size"=>$maxSize, "type" => $types );
            $uploadStatus = multiUploadFile($_FILES["file"], $validextensions, $path, $filterFiles);
        }
        else {
            $code = 404;
            $errors = "not found path";
        }
    } else {
        $code = 403;
        $errors = "folder is not post";
    }
}
?>
