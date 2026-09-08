<?php
$uid = isset($post["uid"]) ? $post["uid"]: null;
if(isset($_GET["uid"]) && $_GET["uid"]) {
    $uid = $_GET["uid"];
}

if(isset($_POST["inputid"]) && $_POST["inputid"]) {
    $inputid = $_POST["inputid"];
}
if(isset($post["inputid"]) && $post["inputid"]) {
    $inputid = $post["inputid"];
}

$isUpdate = false;
if (isset($_SESSION["adminlog"]) && $_SESSION["adminlog"]) {
    $isUpdate = true;
} elseif (isset($_SESSION["userlog"]["id"]) && $_SESSION["userlog"]["id"] == $uid ) {
    $isUpdate = true;
}

if($isUpdate) {
    $dirName = null;

    $code=200;
    $message = $_SESSION["browserFolder"];

    if(isset($post["creatin"]) && isset($post["title"])) {
        $strMKdir = FOLDERUPLOAD.$post["creatin"];
        $dirName = $strMKdir.$post["title"];
    }

    if($dirName ) {
        if(is_dir($dirName)) {
            $errors=201;
            $errors = $language["folderExist"];
        } else {
            mkdir($dirName);
        }
    }

    if(isset($post["folder"]) && $post["folder"]) {
        if($post["folder"]=="/" || $post["folder"]=="//") {
            $_SESSION["browserFolder"] = null;
        } else {
            $_SESSION["browserFolder"] = $post["folder"];
        }
    }

    if(!isset($_SESSION["browserFolder"])) {
        $_SESSION["browserFolder"] = null;
    }

    if(!is_dir(FOLDERUPLOAD.$_SESSION["browserFolder"])) {
        $_SESSION["browserFolder"] = null;
    }

    $listPath = explode('/', $_SESSION["browserFolder"]);
    $arrayPath = array(array('name' => 'root', 'folder' => '/'));

    $linkPath =  null;

    foreach ($listPath as $value) {
        if($value) {
            $linkPath .= "{$value}/";
            $pathDetail = array(
                    'name' => $value,
                    'folder' => $linkPath );

            array_push($arrayPath, $pathDetail);
        }
    }

    $dataResponse["inputid"] = $inputid;
    $dataResponse["uid"] = $uid;
    $dataResponse["browserFolder"] = $arrayPath;
    $dataResponse["currentFolder"] = $_SESSION["browserFolder"];
} else {
    $code=401;
    $errors = "Missing session, please refress to relogin";
    $dataResponse["urlRedirect"] = ".";

}

?>
