<?php
if($isPageNotFound) {
    require dirname(__FILE__) . '/notfound.php';
} else {
    function main() {
        global $language, $productDetailLayout, $informationConfig, $informationWebsite, $actual_link;
        echo '<script src="'.APIGETPRODUCT."/".$productDetailLayout["strProductId"].'?var=window.itemDetail"></script>';
        $strFormatDetailProduct = '{3} 
        <div class="init-none share-block-button" data-view-template=".share-block-button" data-view-template-local="true" data-copy-template="" data-template-id="entryItemShareLink"></div>
        <div class="description-info product-detail product-detail-layout">
                <div class="row">
                    <div class="col-xs-12 col-sm-6 col-right">
                        {12}
                    </div>
                    <div class="col-xs-12 col-sm-6">
                        <div class="info">
                            {4}{8}{5}{6}{7}
                        </div>
                        {9}
                    </div>
                </div>
            </div>
            <div class="description">{10}{18}{19}{11}{13}</div>
            {14}{15}{16}{17}';

        if(isset($informationWebsite["template"]["customPageProduct"]) && !empty($informationWebsite["template"]["customPageProduct"]) ) {
            $strFormatDetailProduct = $informationWebsite["template"]["customPageProduct"];
        }

        $productDetailLayout["strBlockCommentFb"] = isset($pageInfo["db"]["cmf"]) && $pageInfo["db"]["cmf"]==2 ? '<div class="fb-comments" data-href="'.$actual_link.'" data-numposts="5"></div>' : null;

        echo formatStrArguments($strFormatDetailProduct,
            $productDetailLayout["strProductId"], // 1
            $productDetailLayout["strProductCat"], // 2
            $productDetailLayout["strListPath"],   // 3
            $productDetailLayout["strBlockTitle"], // 4
            $productDetailLayout["strBlockPrice"], // 5
            $productDetailLayout["strBlockOrders"],    // 6
            $productDetailLayout["strBlockSortContent"],   // 7
            $productDetailLayout["strBlockAddress"], // 8
            $productDetailLayout["strBlockNoteDetail"], // 9
            $productDetailLayout["strDescription"],    // 10
            $productDetailLayout["strBlockNoteProductDes"], // 11
            $productDetailLayout["strSlideImage"], // 12
            $productDetailLayout["strBlockMapInfo"],   // 13
            $productDetailLayout["strBlockYoutube"],  // 14
            $productDetailLayout["strBlockCommentFb"], //15
            $productDetailLayout["strBlockSameTag"], //16
            $productDetailLayout["strBlockSameCategory"], //17,
            $productDetailLayout["strDescriptionMore"],    // 18,
            $productDetailLayout["strDisplayImages"],    // 19,
            $actual_link,   // 20,
            $productDetailLayout["templateBooking"] // 21
        );
    }
}

?>
