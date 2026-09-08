<?php
$isDone = false;
if(isset($post["your-email"]) && $post["your-email"]) {
    $strEmail = $post["your-email"];
    $str_query = "SELECT id, email, name FROM ".TABLE_USER." WHERE email='{$strEmail}' LIMIT 0,1";

    $row = $db->db_array($str_query);

    if($row) {
        # create url access to reset password

        $arrayInsert =  array(
            "ui" => $row["id"],
            "url" =>$row["id"]."-".md5($currentTime),
            "st" => 0,
            "cr" =>$currentTime,
        );

        $strQueryDel = "DELETE FROM ".TABLE_USER_RECOVERYPW." WHERE ui = {$row["id"]}";

        $db->db_query($strQueryDel);

        if ($db->db_insert($arrayInsert, TABLE_USER_RECOVERYPW)) {

            # send url access to email user
            $link = $_SERVER['HTTP_HOST']."/html?resetpassword=".$arrayInsert["url"];
            $name = $row["name"];
            $strBody = isset($informationConfig["config"]["emailcontent"]["forgotPassword"]["{$langcode}"])? $informationConfig["config"]["emailcontent"]["forgotPassword"]["{$langcode}"] : "...";
            $strBody = formatStrArguments($strBody,$link);

            $sendMailObj = isset($sendMailObj) ? $sendMailObj : array(
                "from" => "no-reply@123veso.vn",
                "to" => $post["your-email"],
                "sender" => "Recovery Password from 123veso.vn",
                "receiver" => $name,
                "reply" => "reply@123veso.vn",
                "replyInfo" => "123veso Developer",
                "subject" => "Recovery Password from 123veso.vn",
                "content" => $strBody,
            );
            require dirname(__FILE__) . "/sendmail.php";
            $isDone = true;
            $message = "Vui lòng kiểm tra email để tìm lại mật khẩu mới";
        }
    }
} elseif (isset($post["password"])) {
    #update password
    $pw = $post["password"];

    $str_query = "SELECT * FROM ".TABLE_USER_RECOVERYPW." WHERE url='{$pw["reset"]}' AND st=0 LIMIT 0,1";
    $row = $db->db_array($str_query);
    if($row) {
        $update["password"] = md5($pw["passwordNew"]);
        $update["status"] = $row["status"]==0 ? 1 : $row["status"];
        if( $db->db_update($update, TABLE_USER, array("id" => $row["ui"]) ) ) {
            $db->db_update(array("st"=>1), TABLE_USER_RECOVERYPW, array("id" => $row["id"]) );
            $isDone = true;
            $code = 200;
            $dataResponse = $post;
            $message = "Mật khẩu đã được cập nhật";
        } else {
            $code = 201;
            $message = "Link update password is used";
        }
    }
    else {
        $code = 401;
        $message = "Link update password is invalid";
    }
}

?>
