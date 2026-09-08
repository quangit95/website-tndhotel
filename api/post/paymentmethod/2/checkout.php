<?php
    $provider = $post["sms"]["provider"];
    $cardpin = $post["sms"]["pin"];
    $serial = $post["sms"]["serial"];
    $username= "phaphn@gmail.com";


    require_once(dirname(__FILE__) ."/libs/nusoap.php");
    require_once(dirname(__FILE__) ."/Entries.php");
    //set_time_limit(0);
    // load SOAP library

    //$webservice = "http://115.78.133.42:9090/CardChargingGW/services/Services?wsdl";
    $webservice = "http://charging-test.megapay.net.vn:10001/CardChargingGW_V2.0/services/Services?wsdl";
    $soapClient = new SoapClient(null, array('location' => $webservice, 'uri' => "http://113.161.78.134/VNPTEPAY/"));

    //if($CardCharging == null)
    //$CardCharging = new CardCharging();
    $m_PartnerID = "charging01";
    $m_MPIN = "pajwtlzcb";
    $m_UserName = "charging01";
    $m_Pass = "bcblcn";
    $m_PartnerCode = "00477";

    //Ten tai khoan nguoi dung tren he thong doi tac
    $m_Target = "useraccount1";
    $CardCharging = new CardCharging();
    $CardCharging->m_UserName = $m_UserName;
    $CardCharging->m_PartnerID = $m_PartnerID;
    $CardCharging->m_MPIN = $m_MPIN;
    $CardCharging->m_Target = $m_Target;
    $CardCharging->m_Card_DATA = $serial.":".$cardpin.":"."0".":".$provider;
    $CardCharging->m_SessionID = "";
    $CardCharging->m_Pass  = $m_Pass;
    $CardCharging->soapClient = $soapClient;

    $transid = $m_PartnerCode.date("YmdHms"); //gen transaction id

    $CardCharging -> m_TransID = $transid;

    $CardChargingResponse = new CardChargingResponse();
    $CardChargingResponse = $CardCharging->CardCharging_();

    //Xu ly cong tien
    if($CardChargingResponse->m_Status==1)
    {
        $insertData["am"] = $CardChargingResponse-> m_RESPONSEAMOUNT;
        $insertData["ps"] = 3;
        # update money to user
        if($db->db_insert($insertData, TABLE_USER_PAYMENT))
        {
            updateMoneyIntoUserAccount($insertData["ui"], $insertData["am"]);
            $code = 200;
            $isSuccessPost = true;
            $message = "Nạp tiền {$CardChargingResponse-> m_RESPONSEAMOUNT} thành công";
        } else {
            $code = 201;
            $errors = "Lỗi hệ thông website 123veso.vn";
        }
    } else {
        $code = 401;
        $errors = "";
    }
    var_dump($CardChargingResponse);
?>
