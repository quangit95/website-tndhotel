<head>
    <meta charset="utf-8">
    <!--[if IE]><meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"><![endif]-->
    <meta name="HandheldFriendly" content="True">
    <meta name="MobileOptimized" content="320">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="apple-mobile-web-app-title" content="" />
    <meta name="description" content="Control Management System" />
    <title>Admincp:: <?=isset($titlePage)? $titlePage:"Home"?></title>
    <link rel="stylesheet" href="/frontend/css/daterangepicker.css" />
    <link rel="stylesheet" href="/frontend/css/style.css" />
    <link rel="stylesheet" href="/frontend/css/custom_admin.css?time=<?=time();?>" />
    <?php
    if(is_file($strDataFolderTemplate."css/custom_admin.css")) {
        echo '<link rel="stylesheet" href="/'.$strDataFolderTemplate."css/custom_admin.css".'?time='.time().'" />';
    }
    ?>
    <style>
        <?= isset($scriptStyle["css"]) && !empty($scriptStyle["css"])? $scriptStyle["css"]:'';?>
    </style>
    <script src="/frontend/js/modernizr.js"></script>
    <?php
    if(isset($informationConfig["config"]["metatag"]["content1"]) && !empty($informationConfig["config"]["metatag"]["content1"])) {
        echo $informationConfig["config"]["metatag"]["content1"];
    }
    if(isset($informationWebsite["script"]["headelm"]) && !empty($informationWebsite["script"]["headelm"]) ) {
        echo $informationWebsite["script"]["headelm"];
    }
    ?>
</head>
