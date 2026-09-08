<?php
$strRoot = FOLDERUPLOAD;
$queryString = null;
# $_SESSION["browserFolder"] = null;
if(isset($_SESSION["browserFolder"])) {
    $queryString = $_SESSION["browserFolder"];
}

$path = $strRoot.$queryString;

if (!empty($_SERVER['HTTP_REFERER'])) {
    $message = "Location: " . $_SERVER['HTTP_REFERER'];
} else {
    $message = "get director url";
}


if(is_dir($path)) {

    if(isset($_GET["files"]) && $_GET["files"]==1) {
        $list_file = readImageInfoInDir($path);
        $dataResponse = $list_file;
        $code = 200;


    } else {
        $folders = array();
        if(isset($_REQUEST["dir"]) && $_REQUEST["dir"]) {
            $path = $strRoot.$_REQUEST["dir"];
        }
        
        if ($handle = opendir($path)) {
            while (false !== ($entry = readdir($handle))) {
                if ($entry != "." && $entry != ".." && is_dir($path."/".$entry)) {
                    $folder = array(
                        'name'=>$entry,
                    );
                    array_push($folders, $folder);
                }
            }
            closedir($handle);
        }

        $dataResponse = $folders;
        $code = 200;
    }
} else {
    $_SESSION["browserFolder"] = null;
    $message = "path:{$path}";
    $code = 200;
    if(isset($_GET["files"]) && $_GET["files"]==1) {
        $list_file = readImageInfoInDir($path);
        $dataResponse = $list_file;
        $code = 200;
    } else {
        $folders = array();
        $dataResponse = $folders;
        $code = 200;
    }
}



?>
