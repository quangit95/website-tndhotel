<?php

$listUrlDoNotUpdate = array("api", "configsite", "css", "dataxml", "img", "js", "lang", "plugins", "templates");
define('FILETYPESUPLOAD', 'txt,doc,docx,ppt,pptx,xls,xlsx,pdf,zip,rar,png,jpg,jpeg,gif');
$seo_name["page"]["menu"] = "m";
$seo_name["page"]["admin"] = "admincp";
$seo_name["page"]["home"] = "";
$seo_name["page"]["product"] = "p";
$seo_name["page"]["search"] = "q";
$seo_name["page"]["blog"] = "blog";
$seo_name["page"]["html"] = "html";
$seo_name["api"] = "api";

$urlDoNotUpdate = array(
    "config",
    "setting",
    "js",
    "api",
    "dataxml",
    "templates",
    "img",
    "lang",
    "libs",
    "vendor"
);

$userAccess = [
    "1" => "banned",
    "2" => "Pending",
    "3" => "Active",
    "100" => "Supper Admin"
];

define('STRFORMATDATE', 'Y-m-d');

#Database Define


#FOLDER Define

$dataOfWebsiteId = $websiteId ;

define('FOLDERDATAXMLADMIN', 'storage/management/dataxml');
define('FOLDERIMAGEADMIN', 'storage/management/img');
define('FOLDERDATAOFWEBSITE', 'storage/pagedata/');

define('FOLDERDATAXML', FOLDERDATAOFWEBSITE.$dataOfWebsiteId.'/dataxml');
define('FOLDERIMAGE', FOLDERDATAOFWEBSITE.$dataOfWebsiteId.'/img');

define('FOLDERHOME', FOLDERDATAXML.'/home/');
define('FOLDERMENU', FOLDERDATAXML.'/menu/');
define('FOLDERBRAND', FOLDERDATAXML.'/brand/');
define('FOLDERCONTACT', FOLDERDATAXML.'/contact/');
define('FOLDERPRODUCT', FOLDERDATAXML.'/product/');
define('FOLDERBLOG', FOLDERDATAXML.'/blog/');
define('FOLDERPAYMENT', FOLDERDATAXML.'/payment/');
define('FOLDERORDER', FOLDERDATAXML.'/order/');
define('FOLDERSERVICE', FOLDERDATAXML.'/service/');
define('FOLDERAGENCY', FOLDERDATAXML.'/agency/');
define('FOLDERREVIEW', FOLDERDATAXML.'/review/');
define('FOLDERTEMPLATE', FOLDERDATAXML.'/template/');
define('FOLDERWEBSITE', FOLDERDATAOFWEBSITE.'website/');

define('FOLDERIMAGEMENU', FOLDERIMAGE.'/images/menu/');
define('FOLDERIMAGEBRAND', FOLDERIMAGE.'/images/brand/');
define('FOLDERIMAGEPRODUCT', FOLDERIMAGE.'/images/product/');
define('FOLDERIMAGEBLOG', FOLDERIMAGE.'/images/blog/');
define('FOLDERIMAGECONTACT', FOLDERIMAGE.'/images/contact/');
define('FOLDERIMAGESERVICE', FOLDERIMAGE.'/images/service/');
define('FOLDERIMAGEREVIEW', FOLDERIMAGE.'/images/review/');
define('FOLDERIMAGETEMPLATE', FOLDERIMAGE.'/images/template/');
define('FOLDERIMAGEWEBSITE',FOLDERIMAGEADMIN.'/website/');
define('FOLDERSLIDEMENU', FOLDERIMAGE.'/slide/menu/');
define('FOLDERSLIDEPRODUCT', FOLDERIMAGE.'/slide/product/');
define('FOLDERSLIDEBLOG', FOLDERIMAGE.'/slide/blog/');
define('FOLDERSLIDETEMPLATE', FOLDERIMAGE.'/slide/template/');
define('FOLDERUPLOAD', FOLDERIMAGE.'/upload/');

define('TABLE_CONTACTUS', 'contactus');
define('TABLE_USER', 'user');
define('TABLE_WEBSITE', 'website');
define('TABLE_URL', 'url');
define('TABLE_VERIFYSIGNUP', 'verify_signup');
define('TABLE_USER_TOKEN', 'user_token');
define('APIPOSTSTR', '/api/post/');
define('APIGETSTR', '/api/get/');


# API GET
define('APIGETCONFIG', APIGETSTR.'config');
define('APIGETCONFIGPAGE', APIGETSTR.'config');
define('APIGETCONTACT', APIGETSTR.'contactus');
define('APIGETCHECKOUT', APIGETSTR.'checkout');
define('APIGETCITY', APIGETSTR.'city');
define('APIGETDISTRICT', APIGETSTR.'district');
define('APIGETMENU', APIGETSTR.'menu');
define('APIGETREVIEW', APIGETSTR.'review');
define('APIGETTEMPLATE', APIGETSTR.'template');
define('APIGETMODEL', APIGETSTR.'model');
define('APIGETPRODUCT', APIGETSTR.'product');
define('APIGETPRODUCTINFO', APIGETSTR.'productinfo');
define('APIGETBLOG', APIGETSTR.'blog');
define('APIGETUSER', APIGETSTR.'user');
define('APIGETSLIDEPRODUCT', APIGETSTR.'slide/product');
define('APIGETSLIDEBLOG', APIGETSTR.'slide/blog');
define('APIGETUSERMANAGER', APIGETSTR.'usermanager');
define('APIGETUPLOADFILE', APIGETSTR.'uploadfile');
define('APIGETWEBSITE', APIGETSTR.'website');


# API POST
define('APIPOSTADMINSIGNIN', APIPOSTSTR.'adminsignin');
define('APIPOSTVERIFYACCOUNT',APIPOSTSTR.'verify_account');
define('APIPOSTWEBSITE',APIPOSTSTR.'website');
define('APIPOSTAGENCY', APIPOSTSTR.'agency');
define('APIPOSTREVIEW', APIPOSTSTR.'review');
define('APIPOSTTEMPLATE', APIPOSTSTR.'template');
define('APIPOSTCONFIGPAGE', APIPOSTSTR.'config');
define('APIPOSTCONTACTUS',APIPOSTSTR.'contactus');
define('APIPOSTMENU', APIPOSTSTR.'menu');
define('APIPOSTMENUMORE', APIPOSTSTR.'menumore');
define('APIPOSTMENUDEL', APIPOSTSTR.'menudelete');
define('APIPOSTPRODUCT', APIPOSTSTR.'product');
define('APIPOSTSLIDEMENU', APIPOSTSTR.'slide/menu');
define('APIPOSTSLIDEPRODUCT', APIPOSTSTR.'slide/product');
define('APIPOSTSIGNIN',APIPOSTSTR.'signin');
define('APIPOSTSLIDEBLOG', APIPOSTSTR.'slide/blog');
define('APIPOSTUPLOADFILE', APIPOSTSTR.'uploadfile');
define('APIPOSTBLOG', APIPOSTSTR.'blog');
define('APIPOSTLOCATION', APIPOSTSTR.'location');
define('APIPOSTADMINACTIVE', APIPOSTSTR.'admin_active');
define('APIPOSTADMINHOT', APIPOSTSTR.'admin_hot');
define('APIPOSTIMAGEDELETE', APIPOSTSTR.'imagedelete');
define('APIPOSTADDTOCART', APIPOSTSTR.'addtocart');
define('APIPOSTORDER', APIPOSTSTR.'order');
define('APIPOSTBRAND', APIPOSTSTR.'brand');
define('APIPOSTLOGOUT', APIPOSTSTR.'logout');
define('APIPOSTPAYMENT', APIPOSTSTR.'payment');
define('APIPOSTSENDEMAIL', APIPOSTSTR.'sendemail');
define('APIPOSTCHECKURL', APIPOSTSTR.'url');
define('APIPOSTUSER', APIPOSTSTR.'user');
define('APIPOSTEMAILNEWSLETTER',APIPOSTSTR.'emailnewsletter');
define('APIPOSTFOLDERUPLOAD', APIPOSTSTR.'folderupload');

$language['folderImageWebsite'] = FOLDERIMAGEWEBSITE;
