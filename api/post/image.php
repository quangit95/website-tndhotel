<?php
#if (!$sessionUserId)
$uid = isset($_POST["ui"]) ? $_POST["ui"] : null;
$id = $_POST["db_id"];
$maxSize = isset($_POST["db_size"]) ? intval($_POST["db_size"]):100000;
$strPath = null;
$strXML = null;
$file = null;
$table = null;

if (isset($url_data[3]) ) {
    if ($url_data[3] === "blog") {
        $strPath = FOLDERIMAGEBLOG;
        $strXML = FOLDERBLOG;
        $file = FOLDERBLOG . "blog.xml";
        $itemList = null;
    } elseif ($url_data[3] === "menu") {
        $strPath = FOLDERIMAGEMENU;
        $strXML = FOLDERMENU;
        $file = FOLDERMENU . "menu.xml";
        $itemList = null;
    } elseif ($url_data[3] === "brand") {
        $strPath = FOLDERIMAGEBRAND;
        $strXML = FOLDERBRAND;
        $file = FOLDERBRAND . "brand.xml";
        $itemList = null;
    } elseif ($url_data[3] === "product") {
        $strPath = FOLDERIMAGEPRODUCT;
        $strXML = FOLDERPRODUCT;
        $file = FOLDERPRODUCT . "product.xml";
        $itemList = null;
    } elseif ($url_data[3] === "review") {
        $strPath = FOLDERIMAGEREVIEW;
        $strXML = FOLDERREVIEW;
        $file = FOLDERREVIEW . "review.xml";
        $itemList = null;
    } elseif ($url_data[3] === "template") {
        $strPath = FOLDERIMAGETEMPLATE;
        $strXML = FOLDERTEMPLATE;
        $file = FOLDERTEMPLATE . "template.xml";
        $itemList = null;
    }

    if($uid && $uid == $sessionUserId) {
        if ($url_data[3] === "category") {
            $strPath = FOLDERIMAGECATEGORY;
            $strXML = FOLDERCATEGORY;
            $table = TABLE_CATEGORY;
        } elseif ($url_data[3] === "user" ) {
            $strPath = FOLDERIMAGEUSER;
            $strXML = FOLDERUSER;
            $table = TABLE_USER;
        } elseif ($url_data[3] === "website" ) {
            $strPath = FOLDERIMAGEWEBSITE;
            $strXML = FOLDERWEBSITE;
            $table = TABLE_WEBSITE;
        } elseif ($url_data[3] === "userbanner") {
            $strPath = FOLDERIMAGEUSER;
            $strXML = FOLDERUSER;
            $fileInfo = $strXML . $id . ".xml";
        }
    }
}

if( $strPath && $strXML ){
    require "api/uploadfile/avatar.php";
} else {
    $code = 401;
    $errors = $language["sessionExpiration"];
}
?>
