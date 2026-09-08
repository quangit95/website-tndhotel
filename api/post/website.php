<?php
$nodeUpdate = isset($post["updateNode"])? $post["updateNode"]:null;
$uid = isset($post["db"]["uid"]) ? $post["db"]["uid"] : null;
$id = isset($post["db"]["id"]) ? $post["db"]["id"] : null;
$isUpdate = false;

if (isset($_SESSION["adminlog"]) && $_SESSION["adminlog"]) {
    $isUpdate = true;
} elseif($isAdminPage && $sessionUserId == $uid ) {
    $isUpdate = true;
}

if($isUpdate) {
    $infoUpdate = $post["{$nodeUpdate}"];

    if($id) {
        # update company website

        # Get infomation form file
        $file = FOLDERWEBSITE . "{$id}.xml";
        if (is_file($file)) {
            $information = simplexml_load_file($file);
            $information = json_encode($information);
            $information = json_decode($information, true);
        }

        # check node update is db
        if($nodeUpdate=="db") {

            $comfirmRowUpdate = array("id" => $id);

            if(isset($infoUpdate["deactive"]) && $infoUpdate["deactive"]) {
                $data = $database->update(TABLE_WEBSITE, $infoUpdate, $comfirmRowUpdate );
                if( $data->rowCount() > 0 ) {
                    $code = 200;
                    $message = $language["updateSuccess"];
                } else {
                    $code = 202;
                    $message = $language["unknownErrors"];
                }
            } else {
                if(isset($infoUpdate["exp"])) {
                    unset($infoUpdate["exp"]);
                }

                foreach ($infoUpdate as $key => $value) {
                    $information["db"][$key] = $value;
                }

                $data = $database->update(TABLE_WEBSITE, $infoUpdate, $comfirmRowUpdate );

                if( $data->rowCount() > 0 ) {
                    saveXMLFile($file, $information);
                    $code = 200;
                    $message = $language["updateSuccess"];
                } else {
                    $code = 204;
                    $errors = $language["invalidPost"];
                }
            }
        } else {
            #update more infomation

            if(isset($infoUpdate["password"]) && $infoUpdate["password"]) {
                $infoUpdate["password"] = md5($infoUpdate["password"]);
            }

            if(isset($infoUpdate["boxchat"]) && $infoUpdate["boxchat"] ) {
                $webChatbox = array("wid"=>$id, "cre"=>$currentTime, "sta"=>1);
                if($infoUpdate["boxchat"] == 2 ) {
                    # has box chat todo update boxchat code and store code to file
                    if(isset($infoUpdate["boxchatcode"]) && $infoUpdate["boxchatcode"]) {
                        $webChatbox["pass"] = $infoUpdate["boxchatcode"];
                        $webChatbox["ex"] = strtotime("+1 month", $currentTime);
                        $database->insert(TABLE_WEBSITE_REGISTER_CHAT, $webChatbox);
                        $webchat_id = $database->id();
                        if($webchat_id) {

                        } else {
                            $database->update(TABLE_WEBSITE_REGISTER_CHAT, ["pass"=>$webChatbox["pass"]], ["wid"=>$id] );
                        }
                    }
                    $infoUpdate["boxchatcode"] = md5($infoUpdate["boxchatcode"]);
                } else {
                    # remove box chat
                    $database->delete(TABLE_WEBSITE_REGISTER_CHAT, ["wid" => $id]);
                }
                #update list login chat code and save into file json
                $data = $database->select(TABLE_WEBSITE_REGISTER_CHAT, ["wid(w)","pass(p)"]);

                $fileLogin = "../../boxchatapp/validationchat/webchat.json";
                $pf = fopen ($fileLogin, "w");
                fwrite ($pf, json_encode($data) );
                fclose ($pf);
                // echo json_encode($data);
            }

            foreach ($infoUpdate as $key => $value) {
                $information["{$nodeUpdate}"][$key] = $value;
            }

            saveXMLFile($file, $information);
            $code = 200;
            $message = $language["updateSuccess"];
        }
    } else {
        # create new company website
        $infoUpdate["created"] = $currentTime;
        $infoUpdate["devid"] = $uid;
        $infoUpdate["status"] = 1;
        // $infoUpdate["exp"] = $final = date("Y-m-d", strtotime("+1 month"));
        $infoUpdate["exp"] = $final = date("Y-m-d");
        $infoUpdate["capacity"] = 300;

        $database->insert(TABLE_WEBSITE, $infoUpdate);
        $account_id = $database->id();

        if($account_id) {

            $file = FOLDERWEBSITE . "{$account_id}.xml";
            $information["db"] = $infoUpdate;


            $strOldFolder = FOLDERDATAOFWEBSITE."demo";
            $strNewFolder = FOLDERDATAOFWEBSITE.$account_id;

            # clone website from
            if(isset($post["clonedata"]) && $post["clonedata"]) {
                $tmpCloneid = intval($post["clonedata"]);
                $itemWebsiteOfUser = $database->get(TABLE_WEBSITE, [
                    "id",
                ], [
                    "id" => $tmpCloneid,
                    "uid"=>$uid
                ]);
                if($itemWebsiteOfUser) {
                    $strOldFolder = FOLDERDATAOFWEBSITE.$tmpCloneid;
                }

                # Get infomation form file
                $fileWebsiteClone = FOLDERWEBSITE . "{$post["clonedata"]}.xml";
                if (is_file($fileWebsiteClone)) {
                    $information = simplexml_load_file($fileWebsiteClone);
                    $information = json_encode($information);
                    $information = json_decode($information, true);
                    # overwrite node db to new website
                    $information["db"] = $infoUpdate;
                }
            }
            saveXMLFile($file, $information);
            $code = 200;

            exec("cp -R {$strOldFolder} {$strNewFolder}");
            if(chmod("{$strNewFolder}", 0755)) {
                $code = 200;
                $message = $language["websiteCreatedSuccess"];
            } else {
                $code = 201;
                $errors = $language["websiteCreatedErrors"];
            }

        } else {
            $code = 201;
            $errors = $language["invalidPost"];
        }
    }
}

?>
