<?php
$uid = isset($post["ui"]) ? $post["ui"] : null;

$isAccess = $uid && $sessionUserId == $uid ? true: false;
$isAccess = isset($_SESSION["adminlog"]) && $_SESSION["adminlog"] ? true : $isAccess;
if ( $isAccess ) {
    if(isset($post["file"]) && isset($post["name"])) {
        $file = $post["file"];
        $fileName = $post["name"];
        if(is_file($file)) {
            $websiteIdFolder = explode('/', $file)[2];
            if($websiteId == $websiteIdFolder) {
                $fileDoNotDel = array("php", "htaccess");
                if (! in_array(substr(strtolower($fileName), strrpos($fileName, ".") + 1), $fileDoNotDel)) {
                    unlink($file);
                }
            }
        }
    }
    else {
        $code = 401;
        $errors = "not found file";
    }
}
else {
    $code = 402;
    $errors = "not found user access";
}
?>
