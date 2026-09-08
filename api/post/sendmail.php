<?php
if(isset($websiteIsLive)) {
    if (!class_exists('PHPMailerOAuth')) {
        require_once dirname(dirname(__DIR__)) . '/vendor/autoload.php';
    }

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

    $oauthUserEmail = isset($informationWebsite["backendConfig"]["phpmailer"]["oauthUserEmail"]) ? $informationWebsite["backendConfig"]["phpmailer"]["oauthUserEmail"] : "";
    $oauthClientId = isset($informationWebsite["backendConfig"]["phpmailer"]["oauthClientId"]) ? $informationWebsite["backendConfig"]["phpmailer"]["oauthClientId"] : "";
    $oauthClientSecret = isset($informationWebsite["backendConfig"]["phpmailer"]["oauthClientSecret"]) ? $informationWebsite["backendConfig"]["phpmailer"]["oauthClientSecret"] : "";
    $oauthRefreshToken = isset($informationWebsite["backendConfig"]["phpmailer"]["oauthRefreshToken"]) ? $informationWebsite["backendConfig"]["phpmailer"]["oauthRefreshToken"] : "";

    // Only attempt to send mail via OAuth if credentials are configured
    if(!empty($oauthClientId) && !empty($oauthRefreshToken)) {
        try {
            $mail = new PHPMailerOAuth;
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
            $mail->oauthUserEmail    = $oauthUserEmail;
            $mail->oauthClientId     = $oauthClientId;
            $mail->oauthClientSecret = $oauthClientSecret;
            $mail->oauthRefreshToken = $oauthRefreshToken;

            $mail->Mailtype         = 'html';
            $mail->Charset          = 'utf-8';
            $mail->Crlf             = "\r\n";
            $mail->Newline          = "\r\n";

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
                error_log('Mailer Error: ' . $mail->ErrorInfo);
            } else {
                $isDone = true;
            }
        } catch (Exception $e) {
            error_log('Mailer Exception: ' . $e->getMessage());
        }
    } else {
        $isDone = true;
    }
} else {
    $isDone = true;
}

if (!isset($code) || $code === null) {
    $code = 200;
}
if (!isset($message) || empty($message)) {
    $message = "Message sent !!!";
}


