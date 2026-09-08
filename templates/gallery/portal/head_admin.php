<head>
    <meta charset="utf-8">
    <!--[if IE]><meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"><![endif]-->
    <meta name="HandheldFriendly" content="True">
    <meta name="MobileOptimized" content="320">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="apple-mobile-web-app-title" content="" />
    <meta name="description" content="CMS is developer by PHPVNN tel: 0944112199" />
    <title>Admincp:: <?=isset($titlePage)?$titlePage:"Home"?></title>
    <link rel="stylesheet" href="/frontend/css/daterangepicker.css" />
    <link rel="stylesheet" href="/frontend/css/style.css" />
    <link rel="stylesheet" href="/<?=$strDataFolderTemplate?>css/custom_admin.css" />
    <style>
        <?= isset($scriptStyle["css"]) && count($scriptStyle["css"])? $scriptStyle["css"]:'';?>
    </style>
    <script src="/frontend/js/modernizr.js"></script>
</head>
