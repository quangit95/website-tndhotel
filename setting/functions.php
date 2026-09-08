<?php
class Array2XML {
    private static $xml = null;
    private static $encoding = 'UTF-8';

    /**
     * Initialize the root XML node [optional]
     * @param $version
     * @param $encoding
     * @param $format_output
     */
    public static function init($version = '1.0', $encoding = 'UTF-8', $format_output = true) {
        self::$xml = new DomDocument($version, $encoding);
        self::$xml->formatOutput = $format_output;
        self::$encoding = $encoding;
    }

    /**
     * Convert an Array to XML
     * @param string $node_name - name of the root node to be converted
     * @param array $arr - aray to be converterd
     * @return DomDocument
     */
    public static function &createXML($node_name, $arr = array()) {
        $xml = self::getXMLRoot();
        $xml->appendChild(self::convert($node_name, $arr));

        self::$xml = null; // clear the xml node in the class for 2nd time use.
        return $xml;
    }

    /**
     * Convert an Array to XML
     * @param string $node_name - name of the root node to be converted
     * @param array $arr - aray to be converterd
     * @return DOMNode
     */
    private static function &convert($node_name, $arr = array()) {

        //print_arr($node_name);
        $xml = self::getXMLRoot();
        $node = $xml->createElement($node_name);

        if (is_array($arr)) {
            // get the attributes first.;
            if (isset($arr['@attributes'])) {
                foreach ($arr['@attributes'] as $key => $value) {
                    if (!self::isValidTagName($key)) {
                        throw new Exception('[Array2XML] Illegal character in attribute name. attribute: ' . $key . ' in node: ' . $node_name);
                    }
                    $node->setAttribute($key, self::bool2str($value));
                }
                unset($arr['@attributes']); //remove the key from the array once done.
            }

            // check if it has a value stored in @value, if yes store the value and return
            // else check if its directly stored as string
            if (isset($arr['@value'])) {
                $node->appendChild($xml->createTextNode(self::bool2str($arr['@value'])));
                unset($arr['@value']); //remove the key from the array once done.
                //return from recursion, as a note with value cannot have child nodes.
                return $node;
            } else if (isset($arr['@cdata'])) {
                $node->appendChild($xml->createCDATASection(self::bool2str($arr['@cdata'])));
                unset($arr['@cdata']); //remove the key from the array once done.
                //return from recursion, as a note with cdata cannot have child nodes.
                return $node;
            }
        }

        //create subnodes using recursion
        if (is_array($arr)) {
            // recurse to get the node for that key
            foreach ($arr as $key => $value) {
                if (!self::isValidTagName($key)) {
                    throw new Exception('[Array2XML] Illegal character in tag name. tag: ' . $key . ' in node: ' . $node_name);
                }
                if (is_array($value) && is_numeric(key($value))) {
                    // MORE THAN ONE NODE OF ITS KIND;
                    // if the new array is numeric index, means it is array of nodes of the same kind
                    // it should follow the parent key name
                    foreach ($value as $k => $v) {
                        $node->appendChild(self::convert($key, $v));
                    }
                } else {
                    // ONLY ONE NODE OF ITS KIND
                    $node->appendChild(self::convert($key, $value));
                }
                unset($arr[$key]); //remove the key from the array once done.
            }
        }

        // after we are done with all the keys in the array (if it is one)
        // we check if it has any text value, if yes, append it.
        if (!is_array($arr)) {
            $node->appendChild($xml->createTextNode(self::bool2str($arr)));
        }

        return $node;
    }

    /*
     * Get the root XML node, if there isn't one, create it.
     */
    private static function getXMLRoot() {
        if (empty(self::$xml)) {
            self::init();
        }
        return self::$xml;
    }

    /*
     * Get string representation of boolean value
     */
    private static function bool2str($v) {
        //convert boolean to text value.
        $v = $v === true ? 'true' : $v;
        $v = $v === false ? 'false' : $v;
        return $v;
        # return stripcslashes($v);
    }

    /*
     * Check if the tag name or attribute name contains illegal characters
     * Ref: http://www.w3.org/TR/xml/#sec-common-syn
     */
    private static function isValidTagName($tag) {
        $pattern = '/^[a-z_]+[a-z0-9\:\-\.\_]*[^:]*$/i';
        return preg_match($pattern, $tag, $matches) && $matches[0] == $tag;
    }
}

function response($data, $code=null, $message=null, $errors=null, $more=null) {
    $response = array(
        "data" => $data,
        "code" => $code,
        "message" => $message,
        "errors" => $errors,
        "more" => $more
    );
    header("Content-type: application/json; charset=utf-8");
    #echo json_encode($response, JSON_PRETTY_PRINT);
    echo json_encode($response, true);
}

function formatStrArguments ($str) {
    $theString = $str;
    for($i=0; $i<func_num_args(); $i++) {
        $re = '/({)'.($i).'(})/';
        preg_match($re, $theString, $regEx);
        if(isset($regEx[0]) && $regEx[0]) {
            $theString = str_replace($regEx[0], func_get_arg($i), $theString );
        }
    }
    return $theString;
};


function urlFriendly($str){
    return preg_replace('/[^a-zA-Z0-9]+/', '-', trim(strtolower(endcode_vn($str))) );
}

function saveXMLFileOld($file, $information) {
    if (!$file || !$information) {
        return false;
    }
    try {
        $xml = Array2XML::createXML("information", $information);
        if(is_file($file)) {
            $element = @simplexml_load_file($file);
            if ($element === false) {
                // error!
                return false;
            } else {
                $xml->save($file);
            }
        } else {
            $xml->save($file);
        }

        return true;
    } catch (Exception $ex) {
        return false;
    }
}

function saveXMLFile($file, $information) {
    global $websiteId;
    if (!$file || !$information) {
        return false;
    }
    try {
        $xml = Array2XML::createXML("information", $information);
        if(isset($websiteId)) {
            $strFileCopy = "storage/checkxml/{$websiteId}.xml";
            $xml->save($strFileCopy);
            $element = @simplexml_load_file($strFileCopy);
            if($element) {
                $xml->save($file);
            } else {
                return false;
            }
        }
        return true;
    } catch (Exception $ex) {
        return false;
    }
}

function saveJSONFile($file, $data) {
    if (!$file || !$data) {
        return false;
    }
    try {
        $fp = fopen($file, 'w');
        fwrite($fp, json_encode($data));
        fclose($fp);
        return true;
    } catch (Exception $ex) {

        return false;
    }
}

function getDirectorySize( $path )
{
    if( !is_dir( $path ) ) {
        return 0;
    }
    $path   = strval( $path );
    $io     = popen( "ls -ltrR {$path} |awk '{print \$5}'|awk 'BEGIN{sum=0} {sum=sum+\$1} END {print sum}'", 'r' );
    # $io = popen('/usr/bin/du -sk '.$path, 'r');
    $size   = intval( fgets( $io, 80 ) );
    pclose( $io );
    return $size;
}

/*function sizeOfDirectory( $f )
{
    $io = popen ( '/usr/bin/du -sk ' . $f, 'r' );
    $size = fgets ( $io, 4096);
    $size = substr ( $size, 0, strpos ( $size, "\t" ) );
    pclose ( $io );
    return $size;
}*/


function readImageDir($path_dir) {
    if (!is_dir($path_dir)) {
        return false;
    }

    $folder = opendir($path_dir); // Use 'opendir(".")' if the PHP file is in the same folder as your images. Or set a relative path 'opendir("../path/to/folder")'.
    $pic_types = array("jpg", "jpeg", "gif", "png");
    $video_types = array("mp4");
    $index["image"] = array();
    $index["video"] = array();
    while ($file = readdir($folder)) {
        if (in_array(substr(strtolower($file), strrpos($file, ".") + 1), $pic_types)) {
            array_push($index["image"], $file);
        }
        if (in_array(substr(strtolower($file), strrpos($file, ".") + 1), $video_types)) {
            array_push($index["video"], $file);
        }
    }
    closedir($folder);
    return $index;
}

function readImageInfoInDir($path_dir) {

    $path_dir = str_replace("//","/",$path_dir);

    if (!is_dir($path_dir)) {
        return false;
    }

    $folder = opendir($path_dir); // Use 'opendir(".")' if the PHP file is in the same folder as your images. Or set a relative path 'opendir("../path/to/folder")'.
    $pic_types = array("jpg", "jpeg", "gif", "png");

    $files = array();
    while ($file = readdir($folder)) {
        if (in_array(substr(strtolower($file), strrpos($file, ".") + 1), $pic_types)) {
            $strPath_dir = $path_dir."/";
            $strPath_dir = str_replace("//","/",$strPath_dir);
            $fileDetail = array(
                'file'=>$strPath_dir.$file,
                'name'=>$file,
                'size'=>round((filesize($strPath_dir.$file)/1000),0).' KB' );
            array_push($files, $fileDetail);
        }
    }
    closedir($folder);
    return $files;
}

function readFilesInfoInDir($path_dir) {

    $path_dir = str_replace("//","/",$path_dir);

    if (!is_dir($path_dir)) {
        return false;
    }

    $folder = opendir($path_dir); // Use 'opendir(".")' if the PHP file is in the same folder as your images. Or set a relative path 'opendir("../path/to/folder")'.
    $pic_types = explode(",", FILETYPESUPLOAD);

    $files = array();
    while ($file = readdir($folder)) {
        if (in_array(substr(strtolower($file), strrpos($file, ".") + 1), $pic_types)) {
            $strPath_dir = $path_dir."/";
            $strPath_dir = str_replace("//","/",$strPath_dir);

            $fileDetail = array(
                'ext'=>strtolower(pathinfo($path_dir."/".$file, PATHINFO_EXTENSION)),
                'file'=>$path_dir."/".$file,
                'name'=>$file,
                'size'=>round((filesize($path_dir."/".$file)/1000),0).' KB'
            );
            array_push($files, $fileDetail);
        }
    }
    closedir($folder);
    return $files;
}

function deleteDirectory($dir) {
    if (!file_exists($dir)) {
        return true;
    }

    if (!is_dir($dir) || is_link($dir)) {
        return unlink($dir);
    }

    foreach (scandir($dir) as $item) {
        if ($item == '.' || $item == '..') {
            continue;
        }
        if (!deleteDirectory($dir . "/" . $item)) {
            chmod($dir . "/" . $item, 0777);
            if (!deleteDirectory($dir . "/" . $item)) {
                return false;
            }
        }
    }
    return rmdir($dir);
}

function strDate($int) {
    if ($int) {
        return date("d-m-Y", $int);
    }
    return null;
}

function nicetime($date) {
    if (empty($date)) {
        return "No date provided";
    }
    $periods = array("sec", "min", "hr", "day", "week", "month", "year", "decade");
    $lengths = array("60", "60", "24", "7", "4.35", "12", "10");

    $now = time();
    $unix_date = strtotime($date);

    // check validity of date
    if (empty($unix_date)) {
        return "Bad date";
    }

    // is it future date or past date
    if ($now > $unix_date) {
        $difference = $now - $unix_date;
        $tense = "ago";
    } else {
        $difference = $unix_date - $now;
        $tense = "from now";
    }

    for ($j = 0; $difference >= $lengths[$j] && $j < count($lengths) - 1; $j++) {
        $difference /= $lengths[$j];
    }

    $difference = round($difference);

    if ($difference != 1) {
        $periods[$j] .= "s";
    }
    return "$difference $periods[$j] {$tense}";
}

function curPageURL() {
    $pageURL = 'http';
    if ($_SERVER["HTTPS"] == "on") {
        $pageURL .= "s";
    }

    $pageURL .= "://";

    if ($_SERVER["SERVER_PORT"] != "80") {
        $pageURL .= $_SERVER["SERVER_NAME"] . ":" . $_SERVER["SERVER_PORT"] . $_SERVER["REQUEST_URI"];
    } else {
        $pageURL .= $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"];
    }
    return $pageURL;
}

function htmlListOption($obj) {
    $strOption = '';
    if ($obj):
        foreach ($obj as $key => $value) {
            $strOption .= ' <option value="' . $key . '">' . $value . '</option>';
        }
    endif;
    return $strOption;
}

function htmlListOptionGroup($obj) {
    global $language;
    $strOption = '';
    if ($obj):
        foreach ($obj as $key => $value) {
            if (is_array($value)) {
                $strOption .= '<optgroup label="' . $key . '">';
                foreach ($value as $key1 => $value1) {
                    $strOption .= ' <option value="' . $key1 . '">' . $value1 . '</option>';
                }
                $strOption .= '</optgroup>';
            }
        }
    endif;
    return $strOption;
}

function uploadImage($file, $strOldFile, $path, $user_id = null, $size=100000) {

    $validextensions = array("jpeg", "jpg", "png", "gif");
    $temporary = explode(".", $file["name"]);
    $file_extension = strtolower(end($temporary));

    if (($file["size"] < $size) && in_array($file_extension, $validextensions)) {
        if ($file["error"] > 0) {
            return array("code" => 404, 'message' => $file["error"]);
        } else {
            $oldFile = $path . $strOldFile;
            if (is_file($oldFile)) {
                // delete file
                unlink($oldFile);
            }
            $sourcePath = $file['tmp_name']; // Storing source path of the file in a variable
            $fileName = $user_id . "_" . $file['name'];
            $targetPath = $path . $fileName; // Target path where file is to be stored
            move_uploaded_file($sourcePath, $targetPath); // Moving Uploaded file
            return array("code" => 200, "message" => "Image Uploaded Successfully...!", "file" => $fileName);
        }
    } else {
        return array("code" => 404, "message" => "***Invalid file Size or Type***");
    }
}


function ImageResize($src, $type, $w, $h, $maxwidth, $maxheight){

    /* Calculate new image size*/
    $newSize = scaleImage($w,$h,$maxwidth,$maxheight);
    $width  = $newSize[0];
    $height = $newSize[1];

    /* set new file name */
    $path = $src;

    $ratio = max($width/$w, $height/$h);
    $h = ceil($height / $ratio);
    $x = ($w - $width / $ratio) / 2;
    $w = ceil($width / $ratio);

    /* Save image */
    if($type=='image/jpeg')
    {
        /* Get binary data from image */
        $imgString = file_get_contents($src);
        /* create image from string */
        $imageSet = imagecreatefromstring($imgString);
        $tmp   = imagecreatetruecolor($width, $height);

        imagecopyresampled($tmp, $imageSet, 0, 0, $x, 0, $width, $height, $w, $h);
        imagejpeg($tmp, $path, 100);
    }
    else if($type=='image/png')
    {
        $imageSet = imagecreatefrompng($src);
        $tmp = imagecreatetruecolor($width,$height);
        imagealphablending($tmp, false);
        imagesavealpha($tmp, true);
        imagecopyresampled($tmp, $imageSet,0,0,$x,0,$width,$height,$w, $h);
        imagepng($tmp, $path, 0);
    }
    else if($type=='image/gif')
    {
        $imageSet = imagecreatefromgif($src);

        $tmp = imagecreatetruecolor($width,$height);
        $transparent = imagecolorallocatealpha($tmp, 0, 0, 0, 127);
        imagefill($tmp, 0, 0, $transparent);
        imagealphablending($tmp, true);

        imagecopyresampled($tmp, $imageSet,0,0,0,0,$width,$height,$w, $h);
        imagegif($tmp, $path);
    }
    else
    {
        return false;
    }

    return true;
    imagedestroy($imageSet);
    imagedestroy($tmp);
}


function scaleImage($x,$y,$cx,$cy) {
    //Set the default NEW values to be the old, in case it doesn't even need scaling
    list($nx,$ny)=array($x,$y);

    //If image is generally smaller, don't even bother
    if ($x>=$cx || $y>=$cx) {

        //Work out ratios
        if ($x>0) $rx=$cx/$x;
        if ($y>0) $ry=$cy/$y;

        //Use the lowest ratio, to ensure we don't go over the wanted image size
        if ($rx>$ry) {
            $r=$ry;
        } else {
            $r=$rx;
        }

        //Calculate the new size based on the chosen ratio
        $nx=intval($x*$r);
        $ny=intval($y*$r);
    }

    //Return the results
    return array($nx,$ny);
}



function fixFilesArray(&$files)
{
    $names = array( 'name' => 1, 'type' => 1, 'tmp_name' => 1, 'error' => 1, 'size' => 1);

    foreach ($files as $key => $part) {
        // only deal with valid keys and multiple files
        $key = (string) $key;
        if (isset($names[$key]) && is_array($part)) {
            foreach ($part as $position => $value) {
                $files[$position][$key] = $value;
            }
            // remove old key reference
            unset($files[$key]);
        }
    }
}

// kill charater vn
function endcode_vn($str)
{
    if(!$str) return false;
    $unicode = array(
        'a'=>array('á','à','ả','ã','ạ','ă','ắ','ặ','ằ','ẳ','ẵ','â','ấ','ầ','ẩ','ẫ','ậ'),
        'A'=>array('Á','À','Ả','Ã','Ạ','Ă','Ắ','Ặ','Ằ','Ẳ','Ẵ','Â','Ấ','Ầ','Ẩ','Ẫ','Ậ'),
        'd'=>array('đ'),
        'D'=>array('Đ'),
        'e'=>array('é','è','ẻ','ẽ','ẹ','ê','ế','ề','ể','ễ','ệ'),
        'E'=>array('É','È','Ẻ','Ẽ','Ẹ','Ê','Ế','Ề','Ể','Ễ','Ệ'),
        'i'=>array('í','ì','ỉ','ĩ','ị'),
        'I'=>array('Í','Ì','Ỉ','Ĩ','Ị'),
        'o'=>array('ó','ò','ỏ','õ','ọ','ô','ố','ồ','ổ','ỗ','ộ','ơ','ớ','ờ','ở','ỡ','ợ'),
        'O'=>array('Ó','Ò','Ỏ','Õ','Ọ','Ô','Ố','Ồ','Ổ','Ỗ','Ộ','Ơ','Ớ','Ờ','Ở','Ỡ','Ợ'),
        'u'=>array('ú','ù','ủ','ũ','ụ','ư','ứ','ừ','ử','ữ','ự'),
        'U'=>array('Ú','Ù','Ủ','Ũ','Ụ','Ư','Ứ','Ừ','Ử','Ữ','Ự'),
        'y'=>array('ý','ỳ','ỷ','ỹ','ỵ'),
        'Y'=>array('Ý','Ỳ','Ỷ','Ỹ','Ỵ')
        );

    foreach($unicode as $nonUnicode=>$uni)
    {
        $str = str_replace($uni,$nonUnicode,$str);
    }
    return $str;
}

function multiUploadFile($files, $validextensions , $path, $filterFile) {

    $validextensions = $validextensions? $validextensions : array("size"=>100000, "type" => array("jpeg", "jpg", "png", "gif") );

    if(!isset($validextensions["size"]) || !isset($validextensions["type"] ) || !$path )
    {
        return array("code" => 404, "message" => "type and size");
    }

    if($files) {
        fixFilesArray($files);
        foreach ($files as $key => $file) {
            $temporary = explode(".", $file["name"]);
            $file_extension = end($temporary);
            $file_extension = strtolower($file_extension);
            if($file["size"] < $validextensions["size"] && in_array($file_extension, $validextensions["type"]))
            {
                if ($file["error"] > 0) {
                    // do something error file;
                } else {
                    if($filterFile) {
                        if(in_array($file['name'], $filterFile)) {
                            $sourcePath = $file['tmp_name']; // Storing source path of the file in a variable
                            $targetPath = $path."/".$file['name']; // Target path where file is to be stored
                            move_uploaded_file($sourcePath, $targetPath); // Moving Uploaded file
                        }
                    }
                    else {
                        $sourcePath = $file['tmp_name']; // Storing source path of the file in a variable
                        $targetPath = $path."/".$file['name']; // Target path where file is to be stored
                        move_uploaded_file($sourcePath, $targetPath); // Moving Uploaded file
                    }
                }
            }
        }
        return array("code" => 200, "message" => "upload success");
    } else {
        return array("code" => 404, "message" => "file Invalid");
    }
}

function sortByFunc(&$arr, $func) {
    $tmpArr = array();
    foreach ($arr as $k => &$e) {
        $tmpArr[] = array('f' => $func($e), 'k' => $k, 'e' => &$e);
    }
    sort($tmpArr);
    $arr = array();
    foreach ($tmpArr as &$fke) {
        $arr[$fke['k']] = &$fke['e'];
    }
}

/*~~~~~~~~~~~~~~~~~~ multi array sort ~~~~~~~~~~~~~~~~~~*/
function multiArrayMsort($array, $cols) {
    $colarr = array();
    foreach ($cols as $col => $order) {
        $colarr[$col] = array();
        foreach ($array as $k => $row) {$colarr[$col]['_' . $k] = strtolower($row[$col]);}
    }
    $params = array();
    foreach ($cols as $col => $order) {
        $params[] = &$colarr[$col];
        $params = array_merge($params, (array) $order);
    }
    call_user_func_array('array_multisort', $params);
    $ret = array();
    $keys = array();
    $first = true;
    foreach ($colarr as $col => $arr) {
        foreach ($arr as $k => $v) {
            if ($first) {$keys[$k] = substr($k, 1);}
            $k = $keys[$k];
            if (!isset($ret[$k])) {
                $ret[$k] = $array[$k];
            }

            $ret[$k][$col] = $array[$k][$col];
        }
        $first = false;
    }
    return $ret;
}
//ex:$arr2 = multiArrayMsort($arr1, array('name'=>SORT_DESC, 'id'=>SORT_DESC));

/*~~~~~~~~~~~~~~~~~~ array search ~~~~~~~~~~~~~~~~~~*/

function arrSearch($array, $expression) {
    $result = array();
    $expression = preg_replace("/([^\s]+?)(=|<|>|!)/", "\$a['$1']$2", $expression);
    if($array) {
        foreach ($array as $a) {
            try {
                if (eval("return $expression;")) {
                    $result[] = $a;
                }
            } catch (Exception $ex) {
            }
        }
    }

    return $result;
}
//ex: phn_arr_search ( $data, "age>=30" );

function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

function updateMoneyIntoUserAccount($user_id, $moneyPlus) {
    global $db;
    $file  = FOLDERUSER.$user_id.".xml";
    if ( is_file($file) && isset($moneyPlus) && $moneyPlus > 0 ) {
        $fileinfo = simplexml_load_file($file);
        $information = json_encode($fileinfo);
        $information = json_decode($information, true);
        $moneyleft = isset($information["userinfo"]["db"]["moneyleft"]) ? $information["userinfo"]["db"]["moneyleft"] : 0;
        $user_update["moneyleft"] = $moneyleft + $moneyPlus;
        if ($db->db_update($user_update, TABLE_USER, array("id" => $user_id))) {
            $information["userinfo"]["db"]["moneyleft"] = $user_update["moneyleft"];
            saveXMLFile($file, $information);
        }
    }
}

if (!function_exists('array_column')) {
    function array_column($array, $column) {
        $col = array();
        foreach ($array as $k => $v) {
            if(isset($v[$column])) {
                $col[]=$v[$column];
            }
        }
        return $col;
    }
}

?>
