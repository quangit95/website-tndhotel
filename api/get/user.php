<?php
try{

    if(isset($url_data[3]) && $url_data[3] ) {
        # Get detail
        $uid = intval($url_data[3]);
        $file   = FOLDERUSER.$uid.".xml";

        $fileInfo = simplexml_load_file($file);
        $information = json_encode($fileInfo);
        $information = json_decode($information, true);

        $dataResponse = $information;

        if(!isset($dataResponse["userinfo"]["db"]["dob"]) || $dataResponse["userinfo"]["db"]["dob"]=="0000-00-00") {
            $dataResponse["userinfo"]["db"]["dob"] = "1980-01-01";
        }

        if(isset($_SESSION["adminlog"]) && count($_SESSION["adminlog"])) {
            unset($information["adminlog"]);
            $dataResponse["adminlog"] = $_SESSION["adminlog"];
        } elseif(!isset($_SESSION["userlog"]["id"]) || $_SESSION["userlog"]["id"] != $uid || !is_file($file)){
            die();
        }
        $code = 200;
    } elseif(isset($_GET["admin"]) && $_GET["admin"]==1) {
        # List User

        $objOrder = ["id" => "DESC"];


        /*if (isset($_GET["from"]) && isset($_GET["to"])) {
            $objSqlMore["AND"]["created[<>]"] = [intval($_GET["from"]), intval($_GET["to"])];
        }*/

        if (isset($_GET["st"]) && $_GET["st"]) {
            $objSqlMore["AND"]["status"] = $_GET["st"];
        }


        $objSqlMore["ORDER"] = $objOrder;


        $dataResponse = $database->select(TABLE_USER, [
                TABLE_USER.'.id(i)',
                TABLE_USER.'.email(e)',
                TABLE_USER.'.address(ad)',
                TABLE_USER.'.city(ci)',
                TABLE_USER.'.district(di)',
                TABLE_USER.'.name(n)',
                TABLE_USER.'.phone(p)',
                TABLE_USER.'.status(s)',
                TABLE_USER.'.created(c)'
            ], $objSqlMore);

        /*$dataResponse = $database->select(TABLE_USER, [
                'i['.TABLE_USER.'.id]',
                'e['.TABLE_USER.'.email]',
                'ad['.TABLE_USER.'.address]',
                'di['.TABLE_USER.'.district]',
                'ci['.TABLE_USER.'.city]',
                'n['.TABLE_USER.'.name]',
                'p['.TABLE_USER.'.phone]',
                's['.TABLE_USER.'.status]',
                'cr[FROM_UNIXTIME(created,\'%d-%m-%Y\')]'
            ]
        );*/

        if($dataResponse) {
            $message = "total Item: ".count($dataResponse);
            $code =200;
        } else {
            $message = $language["dataNotfound"];
        }

    } else {

    }

} catch (Exception $ex) {
   $code = 501;
   $errors = $language["unknownErrors"];
}
?>
