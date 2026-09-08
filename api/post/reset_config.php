<?php
$file = FOLDERHOME . "config.xml";
$information = null;
if (is_file($file)) {
    $fileInfo = simplexml_load_file($file);
    $information = json_encode($fileInfo);
    $information = json_decode($information, true);
}

$nodeReset = isset($post["node"]) ? $post["node"] : null;

if($nodeReset=="javascript") {
	unset($information["config"]["script"]["javascript"]);
	$code = 200;
	// save file
    saveXMLFile($file, $information);

}

?>