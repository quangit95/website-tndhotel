<?php
// Using Medoo namespace
use Medoo\Medoo;
$filename = isset($_GET["file"]) ? $_GET["file"] : null;
$sqlite = isset($_GET["sqlite"]) ? $_GET["sqlite"] : null;

if($filename) {
	$file = FOLDERHOME ."s_{$filename}.xml";
	$dataList = array();
    $information = null;
    if (is_file($file)) {
        $information = simplexml_load_file($file);
        $information = json_encode($information);
        $information = json_decode($information, true);
    }
    $code = 200;
    if (!$information) {
        $dataResponse = array();
    } else {
        $dataList = $information["table"];
    }

    if (isset($get["from"])) {
        $dtime = DateTime::createFromFormat("d-m-yy G:i", $get["from"]." 00:01");
        if($dtime) {
            $dataList = arrSearch($dataList, "dt>={$dtime->getTimestamp()}");
        }
    }

    if (isset($get["to"])) {
        $dtime = DateTime::createFromFormat("d-m-yy G:i", $get["to"]." 23:59");
        if($dtime) {
            $dataList = arrSearch($dataList, "dt<={$dtime->getTimestamp()}");
        }
    }

    if (isset($_GET["limit"])) {
        $dataList = array_slice( $dataList, 0, intval($_GET["limit"]) );
    } else {
        $dataResponse = array_values($dataList);
    }

    if(isset($_GET["sortId"]) && $_GET["sortId"] == 'ASC') {
        usort($dataList, function($a, $b)
        {
            return intval($a["id"] ?? 0) <=> intval($b["id"] ?? 0);
        });
    } else {
        usort($dataList, function($a, $b)
        {
            return intval($b["id"] ?? 0) <=> intval($a["id"] ?? 0);
        });
    }
} elseif($sqlite && is_file(FOLDERHOME ."{$sqlite}.db")) {
    $tablename = "registerinfo";
    $database = new Medoo([
        'database_type' => 'sqlite',
        'database_file' => FOLDERHOME ."{$sqlite}.db"
    ]);

    $objSqlMore["ORDER"] = ["{$tablename}.id" => "DESC"];


    if(isset($_GET["unique"]) && $_GET["unique"]) {
        $objSqlMore["GROUP"] = [$_GET["unique"]];
    }

    $strQuery = [
        $tablename.'.id(i)',
        $tablename.'.code(c)',
        $tablename.'.fn(f)',
        $tablename.'.ph(p)',
        $tablename.'.cmnd(pi)',
        'cr' => Medoo::raw('strftime(\'%d-%m-%Y\','.$tablename.'.cre,\'unixepoch\',\'+7 hours\')')
    ];
    $dataResponse = $database->select($tablename, $strQuery, $objSqlMore);
}

?>
