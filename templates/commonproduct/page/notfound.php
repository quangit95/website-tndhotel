<?php
$code = 404;
$data = $message = null;

function main() {
    global $seo_name, $language, $informationConfig;
    $about = isset($informationConfig["config"]["about"])? $informationConfig["config"]["about"] : null;
    $errors = isset($about["pageNotfound"]) && !empty($about["pageNotfound"]) ? $about["pageNotfound"] : "page not found";
    echo $errors;
}
?>
