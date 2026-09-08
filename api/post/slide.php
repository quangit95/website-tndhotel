<?php
# check is admin and user is admin
$path = null;
$id= isset($_POST["id"]) ? $_POST["id"] : null;
$maxSize = isset($_POST["db_size"]) ? intval($_POST["db_size"]):100000;
$uid = isset($_POST["ui"]) ? $_POST["ui"] : null;

if ($uid && $id && $sessionUserId == $uid ) {
    if($url_data[3] == "category") {
        $path = FOLDERSLIDECATEGORY.$id;
    } elseif($url_data[3] == "user") {
        $path = FOLDERSLIDEUSER.$id;
    } elseif($url_data[3] == "news") {
        $path = FOLDERSLIDENEWS.$id;
    } elseif($url_data[3] == "menu") {
        $path = FOLDERSLIDEMENU.$id;
    } elseif($url_data[3] == "gallery") {
        $path = FOLDERSLIDEGALLERY.$id;
    }
} elseif (isset($url_data[3]) && isset($_SESSION["adminlog"]) && $_SESSION["adminlog"]) {
    if($id) {
        if($url_data[3] == "category") {
            $path = FOLDERSLIDECATEGORY.$id;
        } elseif($url_data[3] == "product"){
            $path = FOLDERSLIDEPRODUCT.$id;
        } elseif($url_data[3] == "blog"){
            $path = FOLDERSLIDEBLOG.$id;
        } elseif($url_data[3] == "menu") {
            $path = FOLDERSLIDEMENU.$id;
        } elseif($url_data[3] == "news"){
            $path = FOLDERSLIDENEWS.$id;
        } elseif($url_data[3] == "gallery"){
            $path = FOLDERSLIDEGALLERY.$id;
        } elseif($url_data[3] == "template"){
            $path = FOLDERSLIDETEMPLATE.$id;
        }
    }
}

if($path) {
    if(!is_dir($path)) {
        mkdir($path);
    }
    $filterFiles = null;
    if(isset($_POST["filesoptioned"])&& $_POST["filesoptioned"] ) {
        $filterFiles = explode('::::', $_POST["filesoptioned"]);
    }
    $validextensions = array("size"=>$maxSize, "type" => array("jpeg", "jpg", "png") );
    $img = multiUploadFile($_FILES["file"], $validextensions, $path, $filterFiles);
    //$dataResponse = $img;
    $code = 200;
    $message = $language["updateSuccess"];
} else {
    $code = 404;
    $errors = "not found path";
}
?>
