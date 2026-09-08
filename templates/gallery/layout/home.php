<!DOCTYPE html>
<!--[if lt IE 9]><html class="no-js ie lt-ie9"><![endif]-->
<!--[if gt IE 8]><!-->
<html lang="vi">
<!--<![endif]-->
  <?php
  require 'frontend/morescript.php';
  require dirname(__FILE__) . '/../portal/head.php';
  ?>
  <body id="translation" class="<?=$strClassPage; ?> <?= isset($_SESSION["adminlog"])? "has-admin":""?>" data-add-class-active-to-obj="li.menu-item-<?=$strPageId?>,active">
    <div id="map"></div>
    <div class="website">
      <?php
      require dirname(__FILE__) . '/../portal/header.php';
      require dirname(__FILE__) . '/../portal/menu.php';
      require dirname(__FILE__) . '/../portal/banner.php';
      require dirname(__FILE__) . '/../portal/main.php';
      require dirname(__FILE__) . '/../portal/footer.php';
      ?>
    </div>
    <div id="google_translate_element" class="hidden"></div>
    <!--<script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>-->
    <!--[if lt IE 9]><div class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</div><![endif]-->
    <noscript>JavaScript is off. Please enable to view full site.</noscript>
    <?php
      foreach ($listJavascript as $key => $value) {
          echo $value ? '<script src="'.$value.'"></script>' : null;
      }
      echo isset($scriptStyle["javascript"]) && count($scriptStyle["javascript"])? $scriptStyle["javascript"]:'';
    ?>
  </body>
</html>
