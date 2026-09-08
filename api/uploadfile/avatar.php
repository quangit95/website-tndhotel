<?php
if($table) {

	$rowUpdate = $database->get($table, [
        "id",
        "im"
    ], [
        "id" => $id,
    ]);

	if($rowUpdate) {
		$strOldFile = isset($rowUpdate["im"]) && $rowUpdate["im"] ? $rowUpdate["im"] : null;
		$maxSize = isset($maxSize) && $maxSize ? $maxSize:100000;
		$img = uploadImage($_FILES["file"], $strOldFile, $strPath, $id, $maxSize);

		$code = $img["code"];
		$message = $img["message"];

		$comfirmRowUpdate = array("id" => $id);
		$infoUpdate = array("im" => $img["file"]);

		if (isset($img["code"]) && $img["code"]==200 ) {

			$data = $database->update($table, $infoUpdate, $comfirmRowUpdate );

			if( $data->rowCount() > 0 ) {
                // save file detail
                $fileInfo = $strXML . $id . ".xml";

				if (is_file($fileInfo)) {
					$information = simplexml_load_file($fileInfo);
					$information = json_encode($information);
					$information = json_decode($information, true);
				}

				if( $url_data[3] === "user" ) {
					$information["userinfo"]["db"]["im"] = $img["file"];
                }
                else {
                	$information["db"]["im"] = $img["file"];
                }

				if (saveXMLFile($fileInfo, $information)) {
					$code = 200;
					$message = $language["updateSuccess"];
					$dataResponse = $img;
				} else {
					$code = 501;
					$errors = $language["unknownErrors"];
				}
            }
		}
	}
} elseif (is_file($file)) {
	$itemList = simplexml_load_file($file);
	$itemList = json_encode($itemList);
	$itemList = json_decode($itemList, true);
	$node = 'id_' . $id;
	$rowUpdate = isset($itemList["table"][$node]) ? $itemList["table"][$node] : null;
	if ($rowUpdate) {
		$strOldFile = isset($rowUpdate["im"]) && $rowUpdate["im"] ? $rowUpdate["im"] : null;
		$maxSize = isset($maxSize) && $maxSize ? $maxSize:100000;
		$img = uploadImage($_FILES["file"], $strOldFile, $strPath, $id, $maxSize);
		if (isset($img)) {

			$code = $img["code"];
			$message = $img["message"];
			if (isset($img["file"])) {
				$rowUpdate["im"] = $img["file"];
				$itemList["table"][$node] = $rowUpdate;
				// save item to file
				if (saveXMLFile($file, $itemList)) {
					// save file detail
					$fileInfo = $strXML . $id . ".xml";

					if (is_file($fileInfo)) {
						$information = simplexml_load_file($fileInfo);
						$information = json_encode($information);
						$information = json_decode($information, true);
					}

					$information["db"] = $rowUpdate;

					if (saveXMLFile($fileInfo, $information)) {
						$code = 200;
						$message = $language["updateSuccess"];
						$dataResponse = $img;
					} else {
						$code = 501;
						$errors = $language["unknownErrors"];
					}
				} else {
					$code = 404;
					$errors = "Can't update image";
				}
			}
		} else {
			$code = 404;
			$errors = "Can't update image";
		}

	} else {
		$code = 501;
		$errors = "Not found ITEM";
	}

	$itemList["table"][$node] = $rowUpdate;

} elseif (isset($fileInfo) && is_file($fileInfo)){
	$information = simplexml_load_file($fileInfo);
	$information = json_encode($information);
	$information = json_decode($information, true);
	if($url_data[3]) {
		$strOldFile = isset($information[$url_data[3]]) && $information[$url_data[3]] ? $information[$url_data[3]] : null;
		$maxSize = isset($maxSize) && $maxSize ? $maxSize:100000;
		$img = uploadImage($_FILES["file"], $strOldFile, $strPath, $id, $maxSize);
		$code = $img["code"];
		$message = $img["message"];
		if (isset($img["code"]) && $img["code"]==200 ) {
			$information[$url_data[3]] = $img["file"];

			if (saveXMLFile($fileInfo, $information)) {
				$code = 200;
				$message = $language["updateSuccess"];
				$dataResponse = $img;
			} else {
				$code = 501;
				$errors = $language["unknownErrors"];
			}
		}
	}

}  else {
	$code = 501;
	$errors = "Not found ITEM";
}
?>
