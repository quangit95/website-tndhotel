<head>
    <meta charset="utf-8">
    <!--[if IE]><meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"><![endif]-->
    <meta name="HandheldFriendly" content="True">
    <meta name="MobileOptimized" content="320">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="apple-mobile-web-app-title" content="" />
    <meta property="og:title" content="<?=$seoTitle;?>">
    <meta property="og:type" content="article">
    <meta property="og:description" content="<?=$seoDescription;?>">
    <?php
    if(isset($strOgImage) && $strOgImage) {
        echo $strOgImage;
    }

    if(isset($informationConfig["config"]["metatag"]["content1"]) && !empty($informationConfig["config"]["metatag"]["content1"])) {
        echo $informationConfig["config"]["metatag"]["content1"];
    }
    
    if(isset($informationWebsite["script"]["headelm"]) && !empty($informationWebsite["script"]["headelm"]) ) {
        echo $informationWebsite["script"]["headelm"];
    }

    $strElementBodytop = isset($informationConfig["config"]["metatag"]["contentBodytop"]) && !empty($informationConfig["config"]["metatag"]["contentBodytop"]) ? strval($informationConfig["config"]["metatag"]["contentBodytop"]):null;

    $strElementBodybottom = isset($informationConfig["config"]["metatag"]["contentBodybottom"]) && !empty($informationConfig["config"]["metatag"]["contentBodybottom"]) ? strval($informationConfig["config"]["metatag"]["contentBodybottom"]):null;

    if(isset($pageInfo["meta"]["topscript"]) && is_string($pageInfo["meta"]["topscript"]) && !empty(trim($pageInfo["meta"]["topscript"]))) {
        echo $pageInfo["meta"]["topscript"];
    }
    if(isset($pageInfo["meta"]["bottomscript"]) && is_string($pageInfo["meta"]["bottomscript"]) && !empty(trim($pageInfo["meta"]["bottomscript"]))) {
        $strElementBodybottom .= $pageInfo["meta"]["bottomscript"];
    }
    ?>

    <meta name="description" content="<?=$seoDescription;?>" />
    <meta name="keywords" content="<?=$seoKeyword;?>"/>
    <title><?=$seoTitle;?></title>
    <link rel="stylesheet" href="/frontend/css/daterangepicker.css" />
    <link rel="stylesheet" href="/frontend/css/style.css?t=2" />
    <link rel="stylesheet" href="/<?=$strDataFolderTemplate?>css/custom.css" />


    <style>
        <?= isset($scriptStyle["css"]) && !empty($scriptStyle["css"])? $scriptStyle["css"]:'';?>
    </style>
    <script src="/frontend/js/modernizr.js"></script>
    <?php if($googleAnalyticsCode ) {
    echo formatStrArguments("<script>
      (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
      (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
      m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
      })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
      ga('create', '{1}', 'auto');
      ga('send', 'pageview');
    </script>",$googleAnalyticsCode);
    } ?>
</head>
