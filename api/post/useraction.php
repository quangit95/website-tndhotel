<?php
$isAction = false;
$userId = isset($_SESSION["userlog"]["id"]) ? $_SESSION["userlog"]["id"] : null;

if(isset($_SESSION["adminlog"]["uid"]) && isset($post["db"]["ui"]) && isset($post["db"]["mo"]) && $_SESSION["adminlog"]["uid"] == $post["db"]["ui"]) {
    $isAction = true;
} elseif ($userId && isset($post["db"]["ui"]) && $post["db"]["ui"] == $userId ) {
    $isUser = true;
}

if($isAction) {
    $mod = $post["db"]["mo"];
    $post["db"]["cr"] = $currentTime;

    $code = 200;
    $comfirmRowUpdate = array("id" => $post["db"]["wi"]);

    $message = $language["updateSuccess"];
    if($mod == 1) {
        # todo change owner website
        $infoUpdate["uid"] = $post["uid"];
        $data = $database->update(TABLE_WEBSITE, $infoUpdate, $comfirmRowUpdate );
        $database->insert(TABLE_USER_ACTION, $post["db"]);

        $post["db"]["uid"] = $post["uid"];
    } elseif($mod == 2) {
        # todo renewed expiry website date
        if(isset($post["optiondate"]) && $post["optiondate"]) {
            $post["db"]["no"]= $post["optiondate"];
            unset($post["db"]["am"]);
            $infoUpdate["exp"] = datetime::createfromformat('d-m-Y',$post["optiondate"]);
            $infoUpdate["exp"] = $infoUpdate["exp"]->format('Y-m-d');

        } elseif(isset($post["db"]["am"]) && $post["db"]["am"]) {

            $item = $database->get(TABLE_WEBSITE, [
                "id",
                "exp"
            ], $comfirmRowUpdate);

            $d1 = new DateTime();
            $d2 = new DateTime($item["exp"]);
            if($d1 >= $d2) {
                $infoUpdate["exp"] = date("Y-m-d", strtotime("+{$post["db"]["am"]} year"));
            } else {
                $infoUpdate["exp"] = date("Y-m-d", strtotime("{$item["exp"]} +{$post["db"]["am"]} year"));
            }
        }

        $data = $database->update(TABLE_WEBSITE, $infoUpdate, $comfirmRowUpdate );
        $database->insert(TABLE_USER_ACTION, $post["db"]);

        # Get infomation form file
        $file = FOLDERWEBSITE . "{$comfirmRowUpdate["id"]}.xml";
        if (is_file($file)) {
            $information = simplexml_load_file($file);
            $information = json_encode($information);
            $information = json_decode($information, true);

            $information["db"]["exp"] = $infoUpdate["exp"];
            saveXMLFile($file, $information);
        }

        $post["db"]["exp"] = $infoUpdate["exp"];
    } elseif($mod == 3) {
        # todo upgrade website

    }
    $dataResponse = $post["db"];

} elseif(isset($isUser) && $isUser) {

    $mod = $post["db"]["mo"];
    $post["db"]["cr"] = $currentTime;
    $database->insert(TABLE_USER_ACTION, $post["db"]);
    $code = 200;
    $comfirmRowUpdate = array("id" => $post["db"]["wi"], "ui" => $userId );

    $message = $language["updateSuccess"];

    if($mod == 1) {
        # todo change owner website
        $infoUpdate["uid"] = $post["uid"];
        $data = $database->update(TABLE_WEBSITE, $infoUpdate, $comfirmRowUpdate );
        $post["db"]["uid"] = $post["uid"];
    } elseif($mod == 2) {
        # todo renewed expiry website date

    } elseif($mod == 3) {
        # todo upgrade website

    }

    $dataResponse = $post["db"];

} else {
    $code = 201;
}
?>
