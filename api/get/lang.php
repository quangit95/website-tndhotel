<?php
$language["dropdownLocalOption"]["manager"] = [
        97 => "Only orders",
        98 => "Only thanh toán",
        99 => "Only user",
        100 => "All permission"
    ];
$language["dropdownLocalOption"]["yearrenew"] = [
        1 => "1 year",
        2 => "2 years",
        3 => "3 years",
        4 => "4 years"
    ];
$language["serveraddr"] = isset($_SERVER["SERVER_ADDR"]) ? $_SERVER["SERVER_ADDR"] : "103.254.12.242";
$language["discountPercent"]=10;
$language["maxsizeImage"] = 500000;
$language["folderImageBrand"] = FOLDERIMAGEBRAND;
$language["folderImageMenu"] = FOLDERIMAGEMENU;
$language["folderImageProduct"] = FOLDERIMAGEPRODUCT;
$language["folderImageBlog"] = FOLDERIMAGEBLOG;
$language["folderImageService"] = FOLDERIMAGESERVICE;
$language["folderImageReview"] = FOLDERIMAGEREVIEW;
$language['folderSlideMenu'] = FOLDERSLIDEMENU;
$language['folderSlideProduct'] = FOLDERSLIDEPRODUCT;
$language['folderSlideBlog'] = FOLDERSLIDEBLOG;
$language['folderImageTemplate'] = FOLDERIMAGETEMPLATE;
$language['folderUpload'] = FOLDERUPLOAD;
$language["urlOfWebsite"] = $protocol.$domainName;
$language["informationWebsite"] = $informationWebsite;

if(isset($language["informationWebsite"]["script"])) {
    unset($language["informationWebsite"]["script"]);
}
if(isset($language["informationWebsite"]["login"])) {
    unset($language["informationWebsite"]["login"]);
}

$dataResponse = $language;
?>
