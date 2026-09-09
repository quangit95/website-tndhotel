<?php
if(isset($websiteIsLive)) {
    if (!class_exists('PHPMailer')) {
        require_once dirname(dirname(__DIR__)) . '/vendor/autoload.php';
    }

    // Determine SMTP configuration
    // 1. Environment variables (recommended for Docker, Render, etc.)
    $smtpHost = getenv('SMTP_HOST') ?: ($_ENV['SMTP_HOST'] ?? ($_SERVER['SMTP_HOST'] ?? 'mail92176.maychuemail.com'));
    $smtpPort = intval(getenv('SMTP_PORT') ?: ($_ENV['SMTP_PORT'] ?? ($_SERVER['SMTP_PORT'] ?? 465)));
    $smtpSecure = getenv('SMTP_SECURE') ?: ($_ENV['SMTP_SECURE'] ?? ($_SERVER['SMTP_SECURE'] ?? 'ssl'));
    $smtpUser = getenv('SMTP_USER') ?: (getenv('SMTP_USERNAME') ?: ($_ENV['SMTP_USER'] ?? ($_SERVER['SMTP_USER'] ?? 'info@tndhotelnhatrang.com')));
    $smtpPass = getenv('SMTP_PASS') ?: (getenv('SMTP_PASSWORD') ?: ($_ENV['SMTP_PASS'] ?? ($_SERVER['SMTP_PASS'] ?? 'Tnd@2022!@#')));
    $smtpFrom = getenv('SMTP_FROM') ?: ($_ENV['SMTP_FROM'] ?? ($_SERVER['SMTP_FROM'] ?? 'info@tndhotelnhatrang.com'));
    $smtpFromName = getenv('SMTP_FROM_NAME') ?: ($_ENV['SMTP_FROM_NAME'] ?? ($_SERVER['SMTP_FROM_NAME'] ?? 'TND Hotel Nha Trang'));

    // 2. XML config fallback
    if (empty($smtpUser) && isset($informationConfig["config"]["smtp"])) {
        $smtpCfg = $informationConfig["config"]["smtp"];
        $smtpHost = !empty($smtpCfg["host"]) ? $smtpCfg["host"] : $smtpHost;
        $smtpPort = !empty($smtpCfg["port"]) ? intval($smtpCfg["port"]) : $smtpPort;
        $smtpSecure = !empty($smtpCfg["secure"]) ? $smtpCfg["secure"] : $smtpSecure;
        $smtpUser = !empty($smtpCfg["user"]) ? $smtpCfg["user"] : (!empty($smtpCfg["username"]) ? $smtpCfg["username"] : '');
        $smtpPass = !empty($smtpCfg["pass"]) ? $smtpCfg["pass"] : (!empty($smtpCfg["password"]) ? $smtpCfg["password"] : '');
        $smtpFrom = !empty($smtpCfg["from"]) ? $smtpCfg["from"] : $smtpFrom;
        $smtpFromName = !empty($smtpCfg["from_name"]) ? $smtpCfg["from_name"] : $smtpFromName;
    }

    // 3. OAuth config
    $oauthUserEmail = isset($informationWebsite["backendConfig"]["phpmailer"]["oauthUserEmail"]) ? $informationWebsite["backendConfig"]["phpmailer"]["oauthUserEmail"] : "";
    $oauthClientId = isset($informationWebsite["backendConfig"]["phpmailer"]["oauthClientId"]) ? $informationWebsite["backendConfig"]["phpmailer"]["oauthClientId"] : "";
    $oauthClientSecret = isset($informationWebsite["backendConfig"]["phpmailer"]["oauthClientSecret"]) ? $informationWebsite["backendConfig"]["phpmailer"]["oauthClientSecret"] : "";
    $oauthRefreshToken = isset($informationWebsite["backendConfig"]["phpmailer"]["oauthRefreshToken"]) ? $informationWebsite["backendConfig"]["phpmailer"]["oauthRefreshToken"] : "";

    $sendMailObj = isset($sendMailObj) ? $sendMailObj : array(
        "from" => "info@tndhotelnhatrang.com",
        "to" => "info@tndhotelnhatrang.com",
        "sender" => "TND Hotel Nha Trang",
        "receiver" => "User",
        "reply" => "info@tndhotelnhatrang.com",
        "replyInfo" => "TND Hotel Nha Trang",
        "subject" => "Thông báo từ TND Hotel",
        "content" => 'Nội dung thông báo',
    );

    $fromEmail = !empty($smtpFrom) ? $smtpFrom : (!empty($smtpUser) ? $smtpUser : ($sendMailObj["from"] ?? "info@tndhotelnhatrang.com"));
    $fromName = !empty($smtpFromName) ? $smtpFromName : ($sendMailObj["sender"] ?? "TND Hotel Nha Trang");

    // Case 1: Standard SMTP authentication (Gmail App Password, Brevo, SendGrid, etc.)
    if (!empty($smtpUser) && !empty($smtpPass)) {
        static $smtpConnectivityChecked = false;
        static $smtpIsReachable = false;
        static $activePort = null;
        static $activeSecure = null;

        if (!$smtpConnectivityChecked) {
            $smtpConnectivityChecked = true;
            // Prefer port 587 (TLS) first as it is standard and supported across cloud providers
            $candidatePorts = [
                ['port' => 587, 'secure' => 'tls', 'prefix' => ''],
                ['port' => 465, 'secure' => 'ssl', 'prefix' => 'ssl://']
            ];
            // If another port was explicitly configured in config, check it first
            if ($smtpPort != 587 && $smtpPort != 465 && $smtpPort > 0) {
                array_unshift($candidatePorts, [
                    'port' => $smtpPort,
                    'secure' => $smtpSecure ?: 'tls',
                    'prefix' => ($smtpSecure === 'ssl' ? 'ssl://' : '')
                ]);
            }

            foreach ($candidatePorts as $candidate) {
                $fp = @fsockopen($candidate['prefix'] . $smtpHost, $candidate['port'], $errno, $errstr, 1.0);
                if ($fp) {
                    fclose($fp);
                    $smtpIsReachable = true;
                    $activePort = $candidate['port'];
                    $activeSecure = $candidate['secure'];
                    break;
                }
            }

            if (!$smtpIsReachable) {
                error_log("[Mail Warning] SMTP host {$smtpHost} unreachable on ports 587 & 465 within 1.0s timeout. Synchronous email sending skipped to protect user response time.");
            }
        }

        if ($smtpIsReachable) {
            try {
                $mail = new PHPMailer(true);
                $mail->isSMTP();
                $mail->SMTPDebug = 0;
                $mail->Host = $smtpHost;
                $mail->Port = $activePort ?: $smtpPort;
                $mail->SMTPAuth = true;
                $mail->SMTPSecure = $activeSecure ?: $smtpSecure;
                $mail->Username = $smtpUser;
                $mail->Password = $smtpPass;
                $mail->CharSet = "utf-8";
                $mail->Timeout = 3;
                $mail->Timelimit = 3;
                $mail->SMTPOptions = array(
                    'ssl' => array(
                        'verify_peer' => false,
                        'verify_peer_name' => false,
                        'allow_self_signed' => true
                    )
                );

                $mail->setFrom($fromEmail, $fromName);
                $mail->addReplyTo($sendMailObj["reply"] ?? $fromEmail, $sendMailObj["replyInfo"] ?? $fromName);
                $mail->addAddress($sendMailObj["to"], $sendMailObj["receiver"] ?? "");
                $mail->isHTML(true);
                $mail->Subject = $sendMailObj["subject"];
                $mail->Body = $sendMailObj["content"];
                $mail->AltBody = isset($sendMailObj["altBody"]) ? $sendMailObj["altBody"] : strip_tags($sendMailObj["content"]);

                if(isset($listMailCC) && is_array($listMailCC)) {
                    foreach ($listMailCC as $val) {
                        if(!empty($val["email"])) {
                            $mail->addCC($val["email"], $val["name"] ?? "");
                        }
                    }
                }

                if(isset($listMailBCC) && is_array($listMailBCC)) {
                    foreach ($listMailBCC as $val) {
                        if(!empty($val["email"])) {
                            $mail->addBCC($val["email"], $val["name"] ?? "");
                        }
                    }
                }

                if ($mail->send()) {
                    error_log("[Mail] Email sent successfully to: " . $sendMailObj["to"] . " (port: " . ($activePort ?: $smtpPort) . ")");
                    $isDone = true;
                } else {
                    error_log("[Mail Error] Failed to send to " . $sendMailObj["to"] . ": " . $mail->ErrorInfo);
                }
            } catch (Exception $e) {
                error_log("[Mail Exception] " . $e->getMessage());
            }
        }
    }
    // Case 2: OAuth2 authentication (if configured)
    elseif (!empty($oauthClientId) && !empty($oauthRefreshToken)) {
        try {
            $mail = new PHPMailerOAuth;
            $mail->isSMTP();
            $mail->SMTPDebug = 0;
            $mail->Host = 'smtp.gmail.com';
            $mail->Port = 587;
            $mail->SMTPSecure = 'tls';
            $mail->SMTPAuth = true;
            $mail->CharSet = 'utf-8';
            $mail->AuthType = 'XOAUTH2';
            $mail->oauthUserEmail = $oauthUserEmail;
            $mail->oauthClientId = $oauthClientId;
            $mail->oauthClientSecret = $oauthClientSecret;
            $mail->oauthRefreshToken = $oauthRefreshToken;
            $mail->SMTPOptions = array(
                'ssl' => array(
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true
                )
            );

            $mail->setFrom($fromEmail, $fromName);
            $mail->addReplyTo($sendMailObj["reply"] ?? $fromEmail, $sendMailObj["replyInfo"] ?? $fromName);
            $mail->addAddress($sendMailObj["to"], $sendMailObj["receiver"] ?? "");
            $mail->isHTML(true);
            $mail->Subject = $sendMailObj["subject"];
            $mail->Body = $sendMailObj["content"];
            $mail->AltBody = isset($sendMailObj["altBody"]) ? $sendMailObj["altBody"] : strip_tags($sendMailObj["content"]);

            if(isset($listMailCC) && is_array($listMailCC)) {
                foreach ($listMailCC as $val) {
                    if(!empty($val["email"])) {
                        $mail->addCC($val["email"], $val["name"] ?? "");
                    }
                }
            }

            if ($mail->send()) {
                error_log("[Mail OAuth] Email sent successfully to: " . $sendMailObj["to"]);
                $isDone = true;
            } else {
                error_log("[Mail OAuth Error] Failed to send: " . $mail->ErrorInfo);
            }
        } catch (Exception $e) {
            error_log("[Mail OAuth Exception] " . $e->getMessage());
        }
    }
    // Case 3: No credentials configured
    else {
        error_log("[Mail Notice] SMTP credentials not configured (SMTP_USER / SMTP_PASS). Email notification to '" . ($sendMailObj["to"] ?? "unknown") . "' was skipped.");
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


