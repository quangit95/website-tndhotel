<!DOCTYPE html>
<!--[if lt IE 9]><html class="no-js ie lt-ie9"><![endif]-->
<!--[if gt IE 8]><!-->
<html lang="<?=$langcode?>">
<!--<![endif]-->
  <?php
  require dirname(__FILE__) . "/morescript.php";
  require dirname(__FILE__) . '/meta/head.php';
  ?>
  <body class="<?=$strClassPage; ?> <?= isset($url_data[0]) && $url_data[0] == $seo_name["page"]["search"] ? "page-search":null ?> lang-<?=$langcode?>" data-add-class-active-to-obj="li.menu-item-<?=$strPageId?>,active" data-fixed="#header + .space-header" data-fixed-class="has-fixed" <?php echo $strValidateExp; ?>>
      <?=$strElementBodytop?>
      <div class="website" <?=$attributeOfWebsiteBlock?> >
        <?php
        require dirname(__FILE__) . '/top/header7.php';
        require dirname(__FILE__) . '/container/main.php';
        require dirname(__FILE__) . '/bottom/footer.php';
        ?>
      </div>
      
      <!--[if lt IE 9]><div class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</div><![endif]-->
      <noscript>JavaScript is off. Please enable to view full site.</noscript>
      <?php
        foreach ($listJavascript as $key => $value) {
            echo $value ? '<script src="'.$value.'"></script>' : null;
        }
        echo isset($scriptStyle["javascript"]) && !empty($scriptStyle["javascript"])? $scriptStyle["javascript"]:null;
      ?>
      <?=$strElementBodybottom?>
  </body>
</html>
