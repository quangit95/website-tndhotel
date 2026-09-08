<?php
if($isPageNotFound) {
    require dirname(__FILE__) . '/notfound.php';
} else {

    function main() {
        global $blogDetailLayout, $language, $pageInfo, $actual_link, $informationWebsite;

        $strFormatDetailBlog = '
            <div class="style-detail-page-list-path">{3}</div>
            <div class="style-detail-page-title">{4}</div>
            <div class="style-detail-page-descrioption">{5}</div>
            <div class="style-detail-page-descrioption-more">{6}</div>
            <div class="style-detail-page-display-image">{7}</div>
            <div class="style-detail-page-youtube">{8}</div>
            <div class="style-detail-page-facebook">{11}</div>
            <div class="style-detail-page-sametag">{9}</div>
            <div class="style-detail-page-samecategory">{10}</div>';

        if(isset($informationWebsite["template"]["customPageBlog"]) && !empty($informationWebsite["template"]["customPageBlog"]) ) {            
            $strFormatDetailBlog = $informationWebsite["template"]["customPageBlog"];
        }

        $blogDetailLayout["strCommentFb"] = isset($pageInfo["db"]["cmf"]) && $pageInfo["db"]["cmf"]==2 ? '<div class="fb-comments" data-href="'.$actual_link.'" data-numposts="5"></div>' : null;


        // var_dump($blogDetailLayout);
        echo formatStrArguments($strFormatDetailBlog,
            $blogDetailLayout["strId"], // 1
            $blogDetailLayout["strCat"], // 2
            $blogDetailLayout["strListPath"],   // 3
            $blogDetailLayout["strTitle"], // 4
            $blogDetailLayout["strDescription"], // 5
            $blogDetailLayout["strDescriptionMore"],    // 6
            $blogDetailLayout["strDisplayImages"],   // 7
            $blogDetailLayout["strBlockYoutube"], // 8
            $blogDetailLayout["strBlockSameTag"], // 9
            $blogDetailLayout["strBlockSameCategory"],    // 10
            $blogDetailLayout["strCommentFb"],    // 11
            $actual_link // 12
        );

    }
}
