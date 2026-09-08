<?php
session_start();
/*
 * jQuery File Upload Plugin PHP Example 5.14
 * https://github.com/blueimp/jQuery-File-Upload
 *
 * Copyright 2010, Sebastian Tschan
 * https://blueimp.net
 *
 * Licensed under the MIT license:
 * http://www.opensource.org/licenses/MIT
 */

error_reporting(E_ALL | E_STRICT);
require 'UploadHandler.php';

if (isset($_SESSION["manageImage"])) {
	$root_dir = $_SESSION["manageImage"];

	$upload_handler = new UploadHandler(array(
		'upload_dir' => '../../' . $root_dir . '/',
		'upload_url' => '/' . $root_dir . '/',
		'image_versions' => array(),
	));
} else {
	$upload_handler = new UploadHandler(array(
		'upload_dir' => '../../' . $_SESSION["storage"]["folder"] . $_SESSION["storage"]["id"] . "/",
		'upload_url' => '/' . $_SESSION["storage"]["folder"] . $_SESSION["storage"]["id"] . "/",
		'image_versions' => array(),
	));
}
