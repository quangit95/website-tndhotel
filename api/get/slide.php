<?php
$code = 200;
if (!isset($url_data[3]) || !isset($url_data[4]) ) {
    $code = 404;
    $errors = "not found slide";
} else {
    $id= $url_data[4];
    $slide = $url_data[3];

    if($slide=="menu") {
        $path = FOLDERSLIDEMENU.$id;
    }
    elseif($slide=="product"){
        $path = FOLDERSLIDEPRODUCT.$id;
    }
    elseif($slide=="blog"){
        $path = FOLDERSLIDEBLOG.$id;
    } elseif($slide=="template"){
        $path = FOLDERSLIDETEMPLATE.$id;
    }
    if($path && intval($id) > 0 ) {
        $list_file = readImageInfoInDir($path);

        if(!$list_file) {
            if(is_dir($path))
                deleteDirectory($path);
        }
        $dataResponse =$list_file;
    } else {
        $code = 404;
        $errors = "not found slide";
    }
}
?>
