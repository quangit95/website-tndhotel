<?php
$isDone = false;
if(!isset($post["db"]["password"]) || !isset($post["db"]["email"])) {
    $code = 201;
    $errors = $language["invalidPost"];
} else {

    #todo check if already user and waiting send sms form server during in set time of cookie

    $post["db"]["password"] = md5($post["db"]["password"]);
    $isEmailAlready = $database->get("user", [
        "id",
        "email"
    ], [
        "email" => $post["db"]["email"]
    ]);

    if($isEmailAlready) {
        $code = 201;
        $errors = $language["emailAlready"];
    } else {
        $post["db"]["code"] = generateRandomString(8);
        $post["db"]["created"] = $currentTime;

        #insert verify code into database before signup account
        $database->insert(TABLE_VERIFYSIGNUP, $post["db"]);
        $account_id = $database->id();

        if(!$account_id) {
            $comfirmRowUpdate = array("email"=>$post["db"]["email"]);
            $data = $database->update(TABLE_VERIFYSIGNUP, $post["db"], $comfirmRowUpdate );
        }

        $formSignup =  array(
            array(
                "iLabel"=>$language["verifyCode"],
                "iName"=>"verifycode",
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
        if($iswebsite) {
            $code = 200;
            $strNotification = formatStrArguments($language["verifyCodeNote"], $post["db"]["email"]);
            $message = $strNotification;
            $modeDesign = array(
                "eInfo"=> $strNotification,
                "eDesign" => array(
                    "row"=>"row form-group",
                    "left"=>"col-xs-4 col-sm-4 col-md-3",
                    "right"=>"col-xs-8 col-sm-8 col-md-9",
                ),
                "eInputHidden" => array(

                    array(
                        "type"=>"hidden",
                        "name"=>"updateNode",
                        "value"=>"db",
                        "data-validate"=>"",
                        "data-required"=>"{$language["requireInput"]}"
                    ),
                    array(
                        "type"=>"hidden",
                        "name"=>"db.password",
                        "value"=>$post["db"]["password"],
                        "data-validate"=>"",
                        "data-required"=>"{$language["requireInput"]}"
                    ),
                    array(
                        "type"=>"hidden",
                        "name"=>"db.created",
                        "value"=>$post["db"]["created"],
                        "data-validate"=>"",
                        "data-required"=>"{$language["requireInput"]}"
                    ),
                    array(
                        "type"=>"hidden",
                        "name"=>"db.email",
                        "value"=>$post["db"]["email"],
                        "data-validate"=>"",
                        "data-required"=>"{$language["requireInput"]}"
                    )
                ),
                "eForm" => $formSignup,
                "attrForm" => array(
                    "class"=>"post-form form-horizontal"
                ),
                "button" => array(
                    array(
                        "iLabel"=>'<span>'.$language["btnConfirm"].'</span>',
                        "iClassCustom"=>"col-xs-6 col-xs-offset-4 col-sm-offset-4  col-md-offset-3",
                        "iAttr"=>array(
                            "data-button-magic"=>"",
                            "data-method"=>"POST",
                            "data-params-form"=>".post-form",
                            "data-format-json"=>"true",
                            "data-ajax-url"=>APIPOSTUSER,
                            "data-show-success"=>".alert-footer.alert",
                            "data-show-errors"=>".alert-footer.alert-error",
                            "class"=>"btn btn-block btn-warning text-uppercase"
                        )
                    ),
                ),
                "buttonClass"=>"form-group"
            );

            $strBody = isset($informationConfig["config"]["emailcontent"]["signupverify"])? $informationConfig["config"]["emailcontent"]["signupverify"] : "...";
            $strBody = formatStrArguments($strBody,$post["db"]["code"]);

            $sendMailObj = isset($sendMailObj) ? $sendMailObj : array(
                "to" => $post["db"]["email"],
                "receiver" => "User signup from phpvnn.com",
                "subject" => "Signup with phpvnn.com",
                "content" => $strBody,
            );
            require dirname(__FILE__) . "/sendmail.php";

        } else {
            # if signup is app developing ...
        }
        $dataResponse = $modeDesign;
    }

}

?>
