<?php
// Using Medoo namespace
use Medoo\Medoo;
$filename = isset($post["filename"]) ? $post["filename"] : null;
$dbname = isset($post["dbname"]) ? $post["dbname"] : null;
$unique = isset($post["unique"]) ? $post["unique"] : null;
$nodeUpdate = isset($post["updateNode"])? $post["updateNode"]:null;

$validationcode = isset($post["validationcode"]) ? $post["validationcode"] : null;


if($validationcode && is_file(FOLDERUPLOAD.$validationcode)) {
	/*$fileContent = file_get_contents('http://alomua.info/vouchercode10.txt');
	$validationList = preg_split('/\s+/', $fileContent);*/
	$validationList = file(FOLDERUPLOAD.$validationcode);
}

if($filename) {
	$file = FOLDERHOME ."s_{$filename}.xml";
	if(isset($post["reset"]) && is_file($file) ) {
		unlink($file);
		$code = 200;
	} else {
		$information = null;
		if (is_file($file)) {
		    $itemList = simplexml_load_file($file);
		    $itemList = json_encode($itemList);
		    $itemList = json_decode($itemList, true);
		}


		if(isset($_SESSION[$filename]) && $_SESSION[$filename] == $post) {
		    $code = 201;
		    $errors = '<p>Cảm ơn bạn đã liên hệ.</p><p>Chúng đã tiếp nhận thông tin!</p>';
		} else {
		    if($nodeUpdate == "db") {
		        $infoUpdate = isset($post[$nodeUpdate]) ? $post[$nodeUpdate] : $infoUpdate;
		        $iId = 0;
		        if (!isset($itemList)) {
		            $iId = 1;
		        } else {

		            // edit Item
		            if (isset($infoUpdate["id"]) && intval($infoUpdate["id"]) > 0) {
		                $iId = intval($infoUpdate["id"]);
		            } else {
		                // add Item
		                $endElmTable = end($itemList["table"]);
		                $iId = intval($endElmTable["id"]) + 1;
		            }
		        }

		        $node = 'id_' . $iId;

		        if(isset($infoUpdate["st"]) && intval($infoUpdate["st"])){
		            $infoUpdate["st"] = intval($infoUpdate["st"]);
		        }
		        else {
		            $infoUpdate["st"] = 0;
		        }

		        # set id for post
		        $infoUpdate["id"] = $iId;
		        $infoUpdate["cr"] = $currentTime;
	            if($unique && $infoUpdate[$unique] && isset($itemList["table"])) {

	            	$new_array = array_filter($itemList["table"], function($obj){
	            		global $unique, $infoUpdate;
					    if (isset($obj[$unique]) && $obj[$unique] === $infoUpdate[$unique] ) {
					        return true;
					    }
					    return false;
					});
	            }

	            if($unique && isset($validationList) && isset($infoUpdate[$unique]) ) {
	            	if(in_array($infoUpdate[$unique]."\n", $validationList)) {
	            		$hasValidation = true;
	            	} else {
	            		$hasValidation = false;
	            	}
	            }

	            if(isset($hasValidation) && !$hasValidation) {
		            $code = 201;
		            $errors = $language["codeGameInvalid"];
		            $infoUpdate["txtMessage"] = $errors;
		        } else {
		        	if(isset($new_array) && $new_array) {
		            	$code = 201;
		            	$errors = $language["codeGameAlready"];
		            	$infoUpdate["txtMessage"] = $errors;
		            } else {
			            # update row before save
			            foreach ($infoUpdate as $key => $value) {
			                if($value !==' ') {
			                    $itemList["table"][$node][$key] = $value;
			                }
			            }
			            # save item to file
			            if (saveXMLFile($file, $itemList)) {
			                $code = 200;
			                $message = $language["codeGameNoteSuccess"];
			                $infoUpdate["txtMessage"] = $message;
			            }
		            }
		            # $_SESSION[$filename] = $post;
		        }
	            $dataResponse = $infoUpdate;


		    } elseif($nodeUpdate == "del" && isset($post["id"])) {
		        # delete node
		        $iId = $post["id"];
		        $node = 'id_' . $iId;
		        try {
		            # remove item from file database
		            if(isset($itemList["table"][$node])) {
		                unset($itemList["table"][$node]);
		                if (saveXMLFile($file, $itemList)) {
		                    $code = 200;
		                    $message = $language["updateSuccess"];
		                }
		            }
		            else {
		                $code = 404;
		                $errors = "Not found ITEM";
		            }
		        } catch (Exception $ex) {
		            $code = 501;
		            $errors = $language["unknownErrors"];
		        }
		    }
		}
	}
} elseif($dbname) {

	$tablename = "registerinfo";
	$database = new Medoo([
      'database_type' => 'sqlite',
      'database_file' => FOLDERHOME ."{$dbname}.db"
  ]);
  if($nodeUpdate == "db") {
      $infoUpdate = isset($post[$nodeUpdate]) ? $post[$nodeUpdate] : null;
  }
  $infoUpdate["cre"] = $currentTime;
  # insert information into table
  $database->insert($tablename, $infoUpdate);

  $iid = $database->id();
  if($iid) {
      $code = 200;
  } else {
      $code = 201;
  }
  $message = $language["codeGameNoteSuccess"];
  $infoUpdate["txtMessage"] = $message;
  $dataResponse = $infoUpdate;
	/*# create table
  $strCreateTable = 'CREATE TABLE IF NOT EXISTS '.$tablename.' (
    id INTEGER PRIMARY KEY,
    code text NULL UNIQUE,
    ph text NOT NULL,
    fn text NOT NULL,
    cmnd text NOT NULL,
    cre INTEGER  NOT NULL
  );';
  $database->query($strCreateTable);*/
}


?>
