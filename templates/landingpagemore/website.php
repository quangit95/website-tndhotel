<?php
$sessionUserId = null;
if(isset($_SESSION["userlog"]["id"]) && $_SESSION["userlog"]["id"]) {
    $sessionUserId = $_SESSION["userlog"]["id"];
}

$strLayout = "home7";

if (isset($url_data[0])) {

    if($url_data[0] == $seo_name["api"]) {
        require "api/index.php";
    }
    else {
        if($url_data[0] == "") {
            require dirname(__FILE__) . "/page/home.php";
        } elseif($url_data[0] == "admincp") {
            require "backend/admin.php";
            $strLayout = "admin";
        } elseif($url_data[0] == $seo_name["page"]["blog"]) {
            require_once "frontend/layout/page/page_blog.php";
            require dirname(__FILE__) . "/page/blog.php";
        } elseif($url_data[0] == $seo_name["page"]["product"]) {
            require_once "frontend/layout/page/page_product.php";
            require dirname(__FILE__) . "/page/product.php";
        } elseif($url_data[0] == $seo_name["page"]["search"]) {
            require dirname(__FILE__) . "/page/search.php";
        } elseif($url_data[0] == $seo_name["page"]["html"]) {
            require dirname(__FILE__) . "/page/html.php";
        } elseif($pageMenu) {
            require_once "frontend/layout/page/page_menu.php";
            // require dirname(__FILE__) . "/page/menu.php";
        } else {
            require dirname(__FILE__) . "/page/notfound.php";
        }

        require_once "frontend/layout/{$strLayout}.php";
    }
}
else {
    require dirname(__FILE__) . "/page/home.php";
    require_once "frontend/layout/{$strLayout}.php";
}
?>
