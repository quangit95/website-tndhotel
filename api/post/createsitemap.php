<?php
$fileSitemap = "sitemaps/id{$websiteId}.xml";
#file menu
$fileMenu = FOLDERMENU . "menu.xml";
$menuList = null;
if (is_file($fileMenu)) {
    $menuList = simplexml_load_file($fileMenu);
    $menuList = json_encode($menuList);
    $menuList = json_decode($menuList, true);
}
if(isset($menuList["table"])) {
	$menuList = $menuList["table"];
} else {
	$menuList = null;
}


#file product
$fileProduct = FOLDERPRODUCT . "product.xml";
$productList = null;
if (is_file($fileProduct)) {
    $productList = simplexml_load_file($fileProduct);
    $productList = json_encode($productList);
    $productList = json_decode($productList, true);
}
if(isset($productList["table"])) {
	$productList = $productList["table"];
} else {
	$productList = null;
}

#file blogs

$fileBlog = FOLDERBLOG . "blog.xml";
$blogList = null;
if (is_file($fileBlog)) {
    $blogList = simplexml_load_file($fileBlog);
    $blogList = json_encode($blogList);
    $blogList = json_decode($blogList, true);
}
if(isset($blogList["table"])) {
	$blogList = $blogList["table"];
} else {
	$blogList = null;
}

$pf = fopen ($fileSitemap, "w");
fwrite ($pf, "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n" .
             "<urlset xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\">\n");

#scan url
$strScanUrl = null;

if($menuList) {
	foreach ($menuList as $key => $value) {
		if( isset($value["st"]) && $value["st"]>1 ) {
			$priority = 0.8;
			if($value["link"] && $value["link"]) {
				$strLoc = $protocol.$domainName.$value["link"];
				$priority = 1;
			} else {
				$strLoc = substr($_SERVER['HTTP_REFERER'], 0, -7).$value["url"];
			}

			$strScanUrl .= "  <url>\n" ."    <loc>".$strLoc."</loc>\n" . "    <changefreq>monthly</changefreq>\n" . "    <priority>".$priority."</priority>\n" . "  </url>\n";
		}
	}
}

if($productList) {
	foreach ($productList as $key => $value) {
		if( isset($value["st"]) && $value["st"]>1 ) {
			$priority = 0.5;
			$strLoc = $protocol.$domainName."/".$seo_name["page"]["product"]."/".urlFriendly($value["ti"]).".".$value["id"];
			$strScanUrl .= "  <url>\n" ."    <loc>".$strLoc."</loc>\n" . "    <changefreq>monthly</changefreq>\n" . "    <priority>".$priority."</priority>\n" . "  </url>\n";
		}
	}
}

if($blogList) {
	foreach ($blogList as $key => $value) {
		if( isset($value["st"]) && $value["st"]>1 ) {
			$priority = 0.5;
			$strLoc = $protocol.$domainName."/".$seo_name["page"]["blog"]."/".urlFriendly($value["ti"]).".".$value["id"];
			$strScanUrl .= "  <url>\n" ."    <loc>".$strLoc."</loc>\n" . "    <changefreq>monthly</changefreq>\n" . "    <priority>".$priority."</priority>\n" . "  </url>\n";
		}
	}
}
fwrite ($pf, $strScanUrl);
fwrite ($pf, "</urlset>\n");
fclose ($pf);
# save data to sitemap.xml file


