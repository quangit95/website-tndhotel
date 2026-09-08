<?php
if(isset($websiteIsLive)) {
    require 'vendor/phpmailer/phpmailer/PHPMailerAutoload.php';
    require 'vendor/autoload.php';

    $mail = new PHPMailerOAuth;

    $smtp = array(
        "host"=>"smtp.gmail.com",
        "port"=>587,
        "secure"=> "tls", #tls
        "authenticate" => true,
    );

    $sendMailObj = isset($sendMailObj) ? $sendMailObj : array(
            "from" => "info@phpvnn.com",
            "to" => "phaphn@gmail.com",
            "sender" => "Phpvnn",
            "receiver" => "User",
            "reply" => "phaphn@gmail.com",
            "replyInfo" => "Phpvnn.com",
            "subject" => "Check Send Mail - PHPMailerAutoload",
            "content" => 'This is the HTML message body <b>in bold!</b>',
        );

    if(!isset($sendMailObj["from"])) {
        $sendMailObj["from"] = "team@phpvnn.com";
    }
    if(!isset($sendMailObj["sender"])) {
        $sendMailObj["sender"] = "team@phpvnn.com";
    }
    if(!isset($sendMailObj["reply"])) {
        $sendMailObj["reply"] = "phaphn@gmail.com";
    }
    if(!isset($sendMailObj["replyInfo"])) {
        $sendMailObj["replyInfo"] = "Phpvnn.com";
    }


    $sendMailObj["smtp"] = $smtp;

    if($sendMailObj) {
         if(isset($sendMailObj["smtp"])) {
            $mail->isSMTP();
            $mail->SMTPDebug = 0;
            $mail->Host = $smtp["host"];
            $mail->Port = $smtp["port"];
            $mail->SMTPSecure = $smtp["secure"];
            $mail->SMTPAuth = $smtp["authenticate"];
            $mail->SMTPOptions = array(
                'ssl' => array(
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true
                )
            );

            $mail->AuthType = 'XOAUTH2';
            $mail->oauthUserEmail    = "";
            $mail->oauthClientId     = "";
            $mail->oauthClientSecret = "";
            $mail->oauthRefreshToken = "";

            if(isset($informationWebsite["backendConfig"]["phpmailer"]["oauthUserEmail"]) && !empty($informationWebsite["backendConfig"]["phpmailer"]["oauthUserEmail"]) ) {
                $mail->oauthUserEmail = $informationWebsite["backendConfig"]["phpmailer"]["oauthUserEmail"];
            }
            if(isset($informationWebsite["backendConfig"]["phpmailer"]["oauthClientId"]) && !empty($informationWebsite["backendConfig"]["phpmailer"]["oauthClientId"]) ) {
                $mail->oauthClientId = $informationWebsite["backendConfig"]["phpmailer"]["oauthClientId"];
            }
            if(isset($informationWebsite["backendConfig"]["phpmailer"]["oauthClientId"]) && !empty($informationWebsite["backendConfig"]["phpmailer"]["oauthClientId"]) ) {
                $mail->oauthClientSecret = $informationWebsite["backendConfig"]["phpmailer"]["oauthClientSecret"];
            }
            if(isset($informationWebsite["backendConfig"]["phpmailer"]["oauthRefreshToken"]) && !empty($informationWebsite["backendConfig"]["phpmailer"]["oauthRefreshToken"]) ) {
                $mail->oauthRefreshToken = $informationWebsite["backendConfig"]["phpmailer"]["oauthRefreshToken"];
            }

            $mail->Mailtype         = 'html';
            $mail->Charset          = 'utf-8';
            $mail->Crlf             = "\r\n";
            $mail->Newline          = "\r\n";
        }

        if(isset($informationWebsite["backendConfig"]["phpmailer"]["textsender"]) && !empty($informationWebsite["backendConfig"]["phpmailer"]["textsender"])) {
            $sendMailObj["sender"] = $informationWebsite["backendConfig"]["phpmailer"]["textsender"];
        }

        $mail->setFrom($sendMailObj["from"], $sendMailObj["sender"]);
        $mail->addReplyTo($sendMailObj["reply"], $sendMailObj["replyInfo"]);
        $mail->addAddress($sendMailObj["to"]);
        $mail->CharSet= "utf-8";
        $mail->isHTML(true);
        $mail->Subject = $sendMailObj["subject"];
        $mail->Body    = $sendMailObj["content"];
        $mail->AltBody = isset($sendMailObj["altBody"]) ? $sendMailObj["altBody"] : $sendMailObj["content"];

        if(isset($listMailCC) && $listMailCC) {
            foreach ($listMailCC as $key => $value) {
                $mail->AddCC($value["email"], $value["name"]);
            }
        } elseif(isset($listMailBCC) && $listMailBCC) {
            foreach ($listMailBCC as $key => $value) {
                $mail->AddBCC($value["email"], $value["name"]);
            }
        }

        if (!$mail->send()) {
            $code = 500;
            $errors = 'Mailer Error: ' . $mail->ErrorInfo;
        } else {
            $code = 200;
            $message = $message ? $message : "Message sent !!!";
            $isDone = true;
        }
    }
} else {
    $isDone = true;
}


