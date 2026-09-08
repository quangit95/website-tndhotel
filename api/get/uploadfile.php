<?php
$list_file = [];
if(isset($_GET["folders"]) && $_GET["folders"]) {
  $folders = explode(',',$_GET["folders"]);
  for($i=0;$i<count($folders); $i++) {
    if(is_dir(FOLDERUPLOAD.$folders[$i])) {
      $list_file = array_merge($list_file, readFilesInfoInDir(FOLDERUPLOAD.$folders[$i]) );
    }
    
  }
} else {
  if (isset($_GET['dir']) && $_GET['dir'] ) {
      $path = FOLDERUPLOAD.$_GET['dir'];
  } else {
      $path = FOLDERUPLOAD;
  }

  $list_file = readFilesInfoInDir($path);
}

$dataResponse = $list_file;
?>
