<?php
date_default_timezone_set('Asia/Ho_Chi_Minh');
session_start();
// Notice:

error_reporting(E_ALL & ~E_DEPRECATED & ~E_WARNING & ~E_NOTICE);
ini_set('display_errors', 0);

require "vendor/autoload.php";
require "setting/functions.php";
$websiteIsLive = true;
$langcode = "vi";
$websiteId = 101131;

# check www for domain
$domainName = $_SERVER["HTTP_HOST"];

$protocol = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') ||
    $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";

$strDataFolderTemplate = "default/";

# check www for domain
if(substr($domainName, 0, 4)=="www.") {
    $domainName = substr($domainName, 4, strlen($domainName));
}

require "setting/config.php";

# Get infomation form file
$websiteSettingFile = FOLDERWEBSITE . "{$websiteId}.xml";
if (is_file($websiteSettingFile)) {
    $informationWebsite = simplexml_load_file($websiteSettingFile);
    $informationWebsite = json_encode($informationWebsite);
    $informationWebsite = json_decode($informationWebsite, true);

} else {
    # echo $domainName;
    $pageNotFound = true;
}

$strDataFolderTemplate = isset($informationWebsite["template"]["code"])? $informationWebsite["template"]["code"]."/":"default/";
$langcode = isset($informationWebsite["template"]["language"])? $informationWebsite["template"]["language"]:$langcode;


$multiLanguage = isset($informationWebsite["language"]["id"]) && count($informationWebsite["language"]["id"]) > 1 ? $informationWebsite["language"]["id"] : null;
$str_q = isset($_REQUEST["q"]) ? $_REQUEST["q"] : "";
$url_data = explode("/", $str_q);

// Read only file txt
if(isset($url_data[0]) && strpos($url_data[0],".txt")) {
    if(is_file(FOLDERUPLOAD.$url_data[0])){
        $myfile = fopen(FOLDERUPLOAD.$url_data[0], "r");
        // some code to be executed....
        echo fgets($myfile);
        fclose($myfile);
        die();
    }
}
if($multiLanguage && isset($url_data[0]) && isset($multiLanguage[$url_data[0]])) {
    $_SESSION["lang"] = $url_data[0];
    array_shift($url_data);
}

if(isset($_SESSION["lang"])){
    $langcode = $_SESSION["lang"];
}

if(!is_file("lang/{$langcode}.php")) {
    $langcode = "vi";
}

require "lang/{$langcode}.php";

$strDataFolderTemplate = "templates/{$strDataFolderTemplate}";

if(!is_dir($strDataFolderTemplate)) {
    $strDataFolderTemplate = "templates/default/";
}

$web_description = $web_keyword = $web_title = null;

if(isset($pageNotFound) && $pageNotFound) {
    # var_dump("Page not found");
} else {
    include_once("site.php");
}

?>
