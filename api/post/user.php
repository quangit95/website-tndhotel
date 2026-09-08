<?php
$nodeUpdate = isset($post["updateNode"])? $post["updateNode"]:null;
$uid = isset($post["db"]["ui"]) ? $post["db"]["ui"] : null;
$id = isset($post["db"]["id"]) ? $post["db"]["id"] : null;
$isUpdate = false;

if (isset($_SESSION["adminlog"]) && $_SESSION["adminlog"]) {
    $isUpdate = true;
} elseif (isset($_SESSION["userlog"]["id"]) && $_SESSION["userlog"]["id"] == $id ) {
    $isUpdate = true;
}

if($nodeUpdate == "checkemail") {
    $email = isset($post["value"]) ? $post["value"]:null;

    $item = $database->get(TABLE_USER, [
        "id",
        "email"
    ], [
        "email" => $email
    ]);

    if($item) {
        $code = 201;
        $errors = $language["emailAlreadyRegistered"];
    }
    else {
        $code = 200;
        $message = $strQuery;
    }
} elseif($nodeUpdate == "db") {
    $infoUpdate = $post["{$nodeUpdate}"];

    if($id) {
        if($isUpdate) {

            $comfirmRowUpdate = array("id" => $id);
            if(isset($infoUpdate["dob"])) {
                $infoUpdate["dob"] = date("Y-m-d", strtotime($infoUpdate["dob"]));
            }

            # some field do not update email, suppend

            if(isset($infoUpdate["email"])) {
                unset($infoUpdate["email"]);
            }


            #update user
            if(isset($infoUpdate["deactive"]) && $infoUpdate["deactive"]) {
                # var_dump($infoUpdate["deactive"]);
                $data = $database->update(TABLE_USER, $infoUpdate, $comfirmRowUpdate );
                if( $data->rowCount() > 0 ) {
                    $code = 200;
                    $message = $language["updateSuccess"];
                } else {
                    $code = 201;
                    $message = $language["unknownErrors"];
                }

            } else {
                $file = FOLDERUSER . $id . ".xml";
                if (is_file($file)) {
                    $information = simplexml_load_file($file);
                    $information = json_encode($information);
                    $information = json_decode($information, true);
                }

                $strResponse = null;
                foreach ($infoUpdate as $key => $value) {
                    $information["userinfo"]["db"][$key] = $value;
                    if($key=="city" || $key == "district" || $key == "gender") {
                        $strResponse[$key] = $value;
                    }
                }

                if($strResponse) {
                    $dataResponse = $strResponse;
                }


                $data = $database->update(TABLE_USER, $infoUpdate, $comfirmRowUpdate );

                if( $data->rowCount() > 0 ) {
                    saveXMLFile($file, $information);
                    $code = 200;
                    $message = $language["updateSuccess"];
                } else {
                    $code = 201;
                    if(isset($infoUpdate["email"]) && $infoUpdate["email"]) {
                        $errors = $language["emailAlready"];
                    } else {
                        $errors = $language["updateSuccess"];
                    }
                }
            }
        } else {
            $code = 201;
            $errors = $language["unknownErrors"];
        }

    } else {
        # create new user

        # check verify code before make signup

        $verifyaccount = $database->get(TABLE_VERIFYSIGNUP, [
            "email",
            "code"
        ], $infoUpdate);

        if(isset($verifyaccount["code"]) && isset($post["verifycode"]) && $verifyaccount["code"] == $post["verifycode"]) {
            $infoUpdate["status"] = 1;
            if(isset($infoUpdate["dob"])) {
                $infoUpdate["dob"] = date(STRFORMATDATE, strtotime($infoUpdate["dob"]));
            } else {
                $infoUpdate["dob"] = "1981-01-23";
            }
            $database->insert(TABLE_USER, $infoUpdate);
            $account_id = $database->id();

            if($account_id) {
                $file = FOLDERUSER . "{$account_id}.xml";

                if(isset($infoUpdate["password"])) {
                    unset($infoUpdate["password"]);
                }

                $information["userinfo"]["db"] = $infoUpdate;
                $information["userinfo"]["db"]["id"] = $account_id;
                saveXMLFile($file, $information);
                $code = 200;

                # Login and access to user page
                $_SESSION["userlog"] = $infoUpdate;

                $dataResponse["urlRedirect"] = "/user";
                # sent email to notification signup successed

                /*
                $link = $_SERVER['HTTP_HOST']."/html?verifyaccount={$infoUpdate["password"]}{$infoUpdate["created"]}&email={$infoUpdate["email"]}";
                $name = $row["name"];
                $strBody = isset($informationConfig["config"]["emailcontent"]["signup"]["{$langcode}"])? $informationConfig["config"]["emailcontent"]["signup"]["{$langcode}"] : "...";
                $strBody = formatStrArguments($strBody,$link, $infoUpdate["email"], $infoUpdate["name"]);
                $sendMailObj = isset($sendMailObj) ? $sendMailObj : array(
                    "from" => "no-reply@123veso.vn",
                    "to" => $infoUpdate["email"],
                    "sender" => "Signup with 123veso.vn",
                    "receiver" => $name,
                    "reply" => "reply@123veso.vn",
                    "replyInfo" => "123veso Developer",
                    "subject" => "Signup with 123veso.vn",
                    "content" => $strBody,
                );
                require dirname(__FILE__) . "/sendmail.php";*/

            } else {
                $code = 201;
                $errors = $language["insertErrors"];
            }
        } else {
            $code = 202;
            $errors = $language["verifyCodeInvalid"] = "Mã xác thực không hợp lệ";;
        }
    }
} elseif($nodeUpdate == "password") {

    $uid = isset($post["db"]["id"]) ? $post["db"]["id"] : null;
    $infoUpdate = $post["{$nodeUpdate}"];

    if( !isset($_SESSION["userlog"]["id"]) || $_SESSION["userlog"]["id"] != $uid || !$uid || !isset($infoUpdate["passwordNew"]) || !isset($infoUpdate["passwordOld"]) ) {
        $code = 201;
        $errors = $language["unknownErrors"];
    } else {
        $isOldPassword = false;

        $row = $database->get(TABLE_USER, [
            "password"
        ], [
            "id" => $uid
        ]);

        if($row["password"] == md5($infoUpdate["passwordOld"]) ) {
            $row["password"] = md5($infoUpdate["passwordNew"]);
            $data = $database->update(TABLE_USER, $row, array("id" => $uid) );
            if( $data ) {
                $isOldPassword = true;
                #update time change password
                $information["userinfo"][$nodeUpdate]["lastupdate"] = $currentTime;
                saveXMLFile($file, $information);
            }
        }

        if($isOldPassword == true) {
            $code = 200;
            $message = $language["passwordChangeSuccess"];
        }
        else {
            $code = 201;
            $errors = $language["passwordDonotChange"];
        }
    }
} elseif($nodeUpdate == "recoveryPassword") {

    $whereSignup = array();

    if (filter_var($post["identify"], FILTER_VALIDATE_EMAIL)) {
        $whereSignup = array("email" => $post["identify"]);
        $strCodeConfirmNote = "Mã xác thực đã được gởi vào email {1}";
    } else {
        $whereSignup = array("phone" => $post["identify"]);
        $strCodeConfirmNote = "Ma xac thuc da duoc goi vao so {1}";
    }

    $profile = $database->get(TABLE_USER, [
        "id",
        "email",
        "phone",
        "status"
    ], $whereSignup );

    if(isset($profile["id"])) {
        $recoveryPw["id"] = $profile["id"];
        $recoveryPw["cre"] = $currentTime;
        $eInputHidden = array(
            array(
                "type"=>"hidden",
                "name"=>"updateNode",
                "value"=>"verifyRecoveryPassword",
                "data-validate"=>"",
                "data-required"=>"{$language["requireInput"]}"
            )
        );
        foreach ($recoveryPw as $key => $value) {
            $eInputHidden[]= array(
                "type"=>"hidden",
                "name"=>"verify.{$key}",
                "value"=>$value,
                "data-validate"=>"",
                "data-required"=>"{$language["requireInput"]}"
            );
        }

        $recoveryPw["cod"] = generateRandomString(8);

        #insert verify code into database before signup account
        $database->insert(TABLE_USER_RECOVERYPASSWORD, $recoveryPw);
        $account_id = $database->id();
        if(!$account_id) {
            $database->update(TABLE_USER_RECOVERYPASSWORD, $recoveryPw, array("id"=>$recoveryPw["id"]) );
        }
        # make notification to email phone then make new form to update password.
        $formResetPassword =  array(
            array(
                "iLabel"=>$language["passwordNew"],
                "iName"=>"passwordNew",
                "iValue"=>"",
                "iTypeInput"=>"password",
                "iAttr"=> array(
                    "data-validate"=>"",
                    "data-required"=>$language["requireInput"],
                    "data-min-length"=>6,
                    "data-hidden-message"=>true,
                    "data-pattern-message"=>formatStrArguments($language["requireRuleMinLength"],6),
                    "data-compare"=>"#accountPasswordConfirm",
                    "data-compare-message"=>"Password don't match",
                    "id"=>"accountPasswordNew"
                ),
                "iClass"=>"form-control"
            ),
            array(
                "iLabel"=>$language["passwordConfirm"],
                "iName"=>"passwordConfirm",
                "iValue"=>"",
                "iTypeInput"=>"password",
                "iAttr"=> array(
                    "data-validate"=>"",
                    "data-required"=>$language["requireInput"],
                    "data-min-length"=>6,
                    "data-hidden-message"=>true,
                    "data-pattern-message"=>formatStrArguments($language["requireRuleMinLength"],6),
                    "data-compare"=>"#accountPasswordNew",
                    "data-compare-message"=>"Password don't match",
                    "id"=>"accountPasswordConfirm"
                ),
                "iClass"=>"form-control"
            ),
            array(
                "iLabel"=>$language["verifyCode"],
                "iNote"=>formatStrArguments($strCodeConfirmNote, $post["identify"]),
                "iName"=>"verify.cod",
                "iValue"=>"",
                "iTypeInput"=>"input",
                "iAttr"=> array(
                    "data-validate"=>"",
                    "data-required"=>$language["requireInput"],
                    "data-min-length"=>"8",
                    "data-max-length"=>"8",
                    "data-pattern-message"=>formatStrArguments($language["requireRuleOnlyLength"],8),
                ),
                "iClass"=>"form-control"
            )
        );

        $modeDesign = array(
            "modal" => array(
                "title"=>$language["passwordReset"],
                "class"=>"modal-dialog modal-signup"
            ),
            "eDesign" => array(
                "row"=>"row form-group",
                "left"=>"col-xs-12 col-sm-4 col-md-3",
                "right"=>"col-xs-12 col-sm-8 col-md-9",
            ),
            "eForm" => $formResetPassword,
            "attrForm" => array(
                "class"=>"post-form form-horizontal"
            ),
            "eInputHidden" => $eInputHidden,
            "button" => array(
                array(
                    "iLabel"=>'<span>'.$language["btnConfirm"].'</span>',
                    "iClassCustom"=>"col-xs-12 col-sm-offset-4 col-md-offset-3",
                    "iAttr"=>array(
                        "data-button-magic"=>"",
                        "data-method"=>"POST",
                        "data-params-form"=>".post-form",
                        "data-format-json"=>"true",
                        "data-ajax-url"=>APIPOSTUSER,
                        "data-view-template"=>".form-signin",
                        "data-template-id"=>"entryFormElement",
                        "data-show-success"=>".alert-footer.alert",
                        "data-show-errors"=>".alert-footer.alert-error",
                        "data-trigger-click"=>".modal-content [data-closet-toggle-class]",
                        "class"=>"btn btn-warning text-uppercase"
                    )
                ),
            ),
            "buttonClass"=>"form-group"
        );

        $strVerifyPasswordCode = "Ma xac nhan cai dat lai mat khau: {$recoveryPw["cod"]}";
        if (filter_var($post["identify"], FILTER_VALIDATE_EMAIL)) {
            #SEND MAIL
            $strBody = $strVerifyPasswordCode;
            $sendMailObj = isset($sendMailObj) ? $sendMailObj : array(
                "to" => $post["identify"],
                "receiver" => "Account of {$domainName}",
                "subject" => "Recovery password from {$domainName}",
                "content" => $strBody,
            );
            require dirname(__FILE__) . "/sendmail.php";
        } else {
            # todo send message phone
            $bluesea_send_sms["userID"] = $post["identify"];
            $bluesea_send_sms["message"] = $strVerifyPasswordCode;
            require dirname(__FILE__) . "/sendsms.php";
        }

        $code = 200;
        $message = formatStrArguments($strCodeConfirmNote, $post["identify"]);
        $dataResponse = $modeDesign;

    } else {
        $code = 201;
        $errors = "Don't have account with {$post["identify"]}";
    }
} elseif($nodeUpdate == "verifyRecoveryPassword") {

    if(isset($post["verify"]) && $post["verify"] && isset($post["passwordNew"]) && isset($post["passwordConfirm"])) {
        $verifyRow = $database->get(TABLE_USER_RECOVERYPASSWORD, [
            "id",
            "cod",
            "cre"
        ], $post["verify"] );

        if($verifyRow && $post["passwordNew"] == $post["passwordConfirm"] ) {
            #update password's user

            $data = $database->update(TABLE_USER,
                array("password"=>md5($post["passwordNew"])),
                array("id"=>$verifyRow["id"])
            );

            if( $data->rowCount() > 0 ) {
                $code = 200;
                $message = $language["updateSuccess"];
            } else {
                $code = 201;
                $message = $language["unknownErrors"];
            }

        } else {
            $code = 201;
            $errors = $language["verifyCodeInvalid"];
        }

    } else {
        $code = 201;
        $errors = $language["verifyCodeInvalid"];
    }

}
?>
