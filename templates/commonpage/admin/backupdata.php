<?php
$path = FOLDERDATAXML;
if(isset($_GET["folder"]) && $_GET["folder"] =="img" ) {
    $path = 'img';
}

$compressFolder = $path.'.zip';
$cmd = "zip -r backup/{$compressFolder} {$path}";
$compress = exec($cmd ." 2>&1" );

echo $compress;

if($compress)
{
    echo 'Done';
}
else
{
    echo 'Not Done';
}

?>
