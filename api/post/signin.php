<?php

if($isAdminPage) {
    if(!isset($post["db"]["password"]) || !isset($post["db"]["email"])) {
        die();
    }
    $mod = isset($post["mod"]) ? $post["mod"] : null;
    $password = md5($post["db"]["password"]);
    $email = $post["db"]["email"];


    $profile = $database->get(TABLE_USER, [
        "id",
        "email",
        "status"
    ], [
        "email" => $email,
        "password"=>$password
    ]);



    if ($profile) {
        $userId = $profile["id"];
        $file = FOLDERUSER . "{$userId}.xml";
        if (is_file($file)) {
            $code = 200;
            $readXML = simplexml_load_file($file);
            $information = json_encode($readXML);
            $information = json_decode($information, true);



            if(isset($profile["deactive"]) && $profile["deactive"]==1) {
                $code = 201;
                $errors = "User's blocked, please contact administrator";
            } elseif($profile["status"] < 1 ) {
                $code = 201;
                $errors = "User's chưa được verify, vui lòng kiểm tra email của bạn để kích hoạt tài khoản này!";
            } else {
                $_SESSION["userlog"] = $profile;
            }
        }

    } else {
        $code = 400;
        $errors = $language["signinError"];
    }
} else {
    $code = 401;
    $errors = $language["doNotAccessPage"];
}
?>
