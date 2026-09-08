<?php
if(isset($menuTable) && !empty($menuTable)) {
    $bannerSlide = arrSearch($menuTable, "st==3");
}

function main() {
    global $seo_name, $language,$langcode, $menuTable, $pageInfo, $informationConfig, $formatCurrency, $multiLanguage;
    $about = isset($informationConfig["config"]["about"])? $informationConfig["config"]["about"]:null;
    if(isset($about["customDescription"]) && !empty($about["customDescription"])) {
        echo $about["customDescription"];
    } else {
        echo isset($about["description"]) && !empty($about["description"]) ? $about["description"]:null;
        if(count($menuTable)) {
            $homeCat = arrSearch($menuTable, "st==4");
            # $homeCat = arrSearch($homeCat, "opp==3");
            usort($homeCat, function($a, $b)
            {
                return intval($a["so"]) > intval($b["so"]);
            });
        }

        echo '<div class="description">';

        if(isset($homeCat) && $homeCat) {
            foreach ($homeCat as $key => $value) {
                # code...
                $fileHomePage = FOLDERMENU . $value["id"] . ".xml";
                $homePageContent = simplexml_load_file($fileHomePage);
                $homePageContent = json_encode($homePageContent);
                $homePageContent = json_decode($homePageContent, true);
                if($multiLanguage) {
                    if(isset($homePageContent["more"][$langcode]) ){
                        $homePageContent["more"]["description"] = !empty($homePageContent["more"][$langcode]["description"]) ? $homePageContent["more"][$langcode]["description"]:null;
                    }
                }
                if(isset($homePageContent["more"]["description"]) && !empty($homePageContent["more"]["description"])) {
                    echo '<div id="page-id-'.$value["id"].'">'.$homePageContent["more"]["description"].'</div>';
                } else {
                    # default is title -> content
                }
            }
        }
        echo '</div>';
    }
}
