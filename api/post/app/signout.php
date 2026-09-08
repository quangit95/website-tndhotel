<?php
if(isset($post["signout"]["uid"])) {
    if($db->db_delete(TABLE_USER_TOKEN, array("uid"=>$post["signout"]["uid"])) ) {
        $code = 200;
        $message ="logout successed";
    }
} else {

}
?>
