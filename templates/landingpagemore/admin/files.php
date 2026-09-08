<?php
$queryString = "";
if(isset($_GET["dir"]) && $_GET["dir"]) {
    $queryString = $_GET["dir"];
}

if(isset($_GET["del"]) && $_GET["del"]){

    $dirNameDelete = FOLDERUPLOAD.$_GET["del"];
    if(is_dir($dirNameDelete))
        deleteDirectory($dirNameDelete);
}

if(isset($_POST["title"]) && isset($_POST["root"])) {
    $dirName = FOLDERUPLOAD.$queryString."/".$_POST["title"];
    if(is_dir($dirName))
        $txt_message = $language["folderExist"];
    else
        mkdir($dirName);
}

$path = FOLDERUPLOAD.$queryString;
$strMenuFolder = null;
if(is_dir($path)) {
    if ($handle = opendir($path)) {
        while (false !== ($entry = readdir($handle))) {
            if ($entry != "." && $entry != ".." && is_dir($path."/".$entry)) {
                $strMenuFolder .= '<li class="row">
                    <span class="col-xs-9"><a href="?mod=files&dir='.$queryString."/".$entry.'">'.$entry.'</a></span>
                    <span class="col-xs-3 text-center"><a href="?mod=files&dir='.$queryString.'&del='.$queryString."/".$entry.'" data-confirm-question ><span class="fa fa-trash-o"></span></a></span></li>';
            }
        }
        closedir($handle);
    }
}
else {
    die();
}
?>

<div class="admin-title">
    <h2><?=$language["manage"]?> : <?=$language["files"]?></h2>
</div>
<div class="folder-menu">
<?php
$listPath = explode('/', $queryString);
$strListPath = "";
$linkPath = "";
foreach ($listPath as $value) {
    if($value =='') {
        $value = "Root";
    }
    else {
        $linkPath .= "/{$value}";
    }
    $strListPath .= '<li><a href="?mod=files&dir='.$linkPath.'"><i class="fa fa-caret-right"></i> <span>'.$value.'</span></a></li>';
}
?>
<?="<ul>{$strListPath}</ul>";?>
    <div class="clearfix"></div>
</div>
<div class="row">
    <div class="col-xs-3">
        <?php
        if($strMenuFolder) {
            echo '<div class="folder-list"><ul>'.$strMenuFolder.'</ul></div>';
        }
        ?>
        <div class="makeFolder">
            <form method="post" action="?mod=files&dir=<?=$queryString?>" data-form-validate >
                <div class="form-group">
                    <input type="hidden" name="root" value="">
                    <input  type="text"
                            name="title"
                            data-validate
                            data-required="<?=$language["requireTitle"];?>"
                            data-pattern-message="<?=$language["requireFolderNameRule"];?>"
                            data-pattern="^[a-zA-Z0-9]*[a-zA-Z]+[a-zA-Z0-9]*$"
                            placeholder="<?=$language["folderName"]?>"
                            class="form-control">
                    <span class="error"></span>
                </div>
                <div class="form-group">
                    <input type="submit" value="<?=$language["btnAdd"]?>" data-button-upload class="btn btn-primary"/>
                </div>
            </form>
        </div>
        <?php
        if(isset($txt_message)) {
            echo '<div class="text-danger"><lable>'.$txt_message.'</lable></div>';
        }
        ?>
    </div>
    <div class="col-xs-9">
        <div class="item-view-slide-image admin-list rectangle2"
            data-view-list-by-handlebar
            data-ignore-hash="true"
            data-init-button-magic=".item-view-slide-image [data-button-magic]"
            data-url="<?=APIGETUPLOADFILE?>"
            data-params="dir=<?=$queryString?>"
            data-method="GET"
            data-show-page="10"
            data-show-item="20"
            data-show-all="false"
            data-scroll-view="false"
            data-template-id="entrySlideItemIcon" >
            <div class="view-items"
                data-content
                data-center-items
                data-class-name="item-img-icon"
                data-item-class=".img"
                data-space-item="[20,20]"
                data-space-max="[30,30]"
                data-items-custom="[1000,5], [880,4], [680,3],[480,2],[0,1]"
                data-responsive="true">
            </div>
            <div data-footer></div>
        </div>
        <div class="update-slide-image"
            data-copy-template
            data-elm-data='{
                "urlPost":"<?=APIPOSTUPLOADFILE?>",
                "folder":"<?=$queryString?>",
                "maxSize":"5000000",
                "types":"<?=FILETYPESUPLOAD?>"
            }'
            data-view-template=".update-slide-image"
            data-template-id="entrySlideImage">
        </div>
    </div>
</div>
