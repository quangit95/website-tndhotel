<script src="/api/get/statecode?var=window.statecode"></script>
<div class="row hidden-xs home-google-map">
    <div data-google-map="map-product"
        data-map-point="#home-location .point"
        data-latitude="36.778261"
        data-longitude="-119.417932"
        data-zoom="8"
        data-map-point-sms=".msm-content"></div>
    <div class="col-xs-12 col-md-4 hidden-xs hidden-sm">
        <ul id="home-location" style="height: 480px; overflow: scroll;">
            <?php
            $fileProduct = FOLDERPRODUCT . "product.xml";
            $productList = null;
            if (is_file($fileProduct)) {
                $productList = simplexml_load_file($fileProduct);
                $productList = json_encode($productList);
                $productList = json_decode($productList, true);
            }
            if($productList) {
                $productList = $productList["table"];
            }
            foreach ($productList as $key => $value) {
                if(isset($value["lng"]) && !empty($value["lng"]) && isset($value["lat"]) && !empty($value["lat"]) && $value["st"]>1) {
                    $price = isset($value["pr"])? $value["pr"]:null;
                    $linkFriendly = '/'.preg_replace('/[^a-zA-Z0-9]+/', '-', trim(strtolower(endcode_vn($value["ti"]))) );
                ?>
                <li class="point"
                    data-latitude="<?=$value["lat"]?>"
                    data-longitude="<?=$value["lng"]?>"
                    data-id="<?="{$value["id"]}"?>">
                    <div class="msm-content">
                        <div class="msm-content-detail">
                            <?php
                            if(isset($value["im"]) && $value["im"]) {
                                echo '<img src="/'.FOLDERIMAGEPRODUCT."/".$value["im"].'" alt="'.$value["ti"].'">';
                            }
                            ?>
                            <h3><?=$value["ti"]?></h3>
                            <div class="location">
                                <?php
                                $strCity = null;
                                if(isset($value["ci"]) && !empty($value["ci"])) {
                                    $strCity = $value["ci"]." {$language["city"]}, ";
                                }

                                if(isset($value["si"]) && $value["si"]) {
                                    echo '<span>'.$value["si"].' +/- Acres, </span>';
                                }
                                if(isset($value["sta"]) && $value["sta"]) {
                                    echo '<p>In '.$strCity.'<span data-show-json-object data-json-object="statecode" data-json-key="'.$value["sta"].'" >'.$value["sta"].'</span></p>';
                                }
                                if($price["sale"]) {
                                    echo '<p>'.$language["price"].': <span data-format-currency class="price-main">'.$price["sale"].'</span></p>';
                                }
                                ?>
                            </div>
                            <div class="text-right more-link">
                                <a href="<?=$seo_name["page"]["product"].'/'.$value["id"].$linkFriendly?>" class="btn btn-default"><?=$language["viewDetail"]?></a>
                            </div>
                        </div>
                    </div>
                </li>
                <?php
                }
            }
            ?>
        </ul>
    </div>
    <div class="col-xs-12 col-md-8 ">
        <div id="map-product" style="width: 100%; height: 480px;">&nbsp;</div>
    </div>
</div>
