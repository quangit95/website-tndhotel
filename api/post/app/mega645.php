<?php
$numberOfTicket = null;
$kyid=null;
$baoid=null;

if(isset($post["kyid"]) && $post["kyid"]) {
    if(in_array($post["kyid"], $language["dropdownLocalOption"]["ky"])) {
        $kyid = $post["kyid"];
    }
}

if(isset($post["baoid"]) && $post["baoid"]) {
    if(in_array($post["baoid"], $language["dropdownLocalOption"]["bao"])) {
        $baoid = $post["baoid"];
    }
}

if(isset($post["ticket"]) && $post["ticket"] ) {
    foreach ($post["ticket"] as $key => $value) {
        if(count($value)==6 || count($value) == $baoid) {
            $numberOfTicket[$key] = implode(',', $value);
        }
    }
}

if(isset($post["del"])){
    $delId = $post["del"];
    if($delId == -1) {
        unset($information["cartinfo"]);
    } elseif(isset($information["cartinfo"]["items"]["n_{$delId}"]) && $information["cartinfo"]["items"]["n_{$delId}"]) {
        unset($information["cartinfo"]["items"]["n_{$delId}"]);
        $code =200;
        $message = "Tờ vé đã xóa";
    }

} elseif(!$numberOfTicket) {
    $code =404;
    $errors = "bạn chưa chọn số";
} else {
    $totalItem = count($numberOfTicket);
    $total = MEGAMONEYPERITEM*$totalItem;

    $pickedTicket = array(
        'number'=>$numberOfTicket,
        "totalItem"=>$totalItem
    );

    if($baoid) {
        $pickedTicket['bao']=$baoid;
        if($baoid==5) {
            $total = $totalItem * 400000;
        } elseif($baoid==7) {
            $total = $totalItem * 70000;
        } elseif($baoid==8) {
            $total = $totalItem * 280000;
        } elseif($baoid==9) {
            $total = $totalItem * 840000;
        } elseif($baoid==10) {
            $total = $totalItem * 2100000;
        } elseif($baoid==11) {
            $total = $totalItem * 4620000;
        } elseif($baoid==12) {
            $total = $totalItem * 9240000;
        } elseif($baoid==13) {
            $total = $totalItem * 17120000;
        } elseif($baoid==14) {
            $total = $totalItem * 30030000;
        } elseif($baoid==15) {
            $total = $totalItem * 50050000;
        } elseif($baoid==18) {
            $total = $totalItem * 185640000;
        }
    }

    if($kyid) {
        $pickedTicket['ky']=$kyid;
        $total = $kyid*$total;
        $pickedTicket["drawdate"]= drawDateOfLottery($kyid);
    } else {
        $pickedTicket["drawdate"]= drawDateOfLottery(1);
    }

    $idUpdate = 1;

    $listCartinfo = isset($information["cartinfo"]["items"]) ? $information["cartinfo"]["items"]:array();

    if( isset($post["update"]) ) {
        $idUpdate = intval($post["update"]);
    } else {
        $endElm = end($listCartinfo);
        $idUpdate = intval($endElm["id"]) + 1;
    }

    $pickedTicket['total']= $total;
    $pickedTicket["id"]= $idUpdate;

    $information["cartinfo"]["items"]["n_{$idUpdate}"] = $pickedTicket;

}

if(isset($information["cartinfo"]["items"]) && count($information["cartinfo"]["items"])) {
    $code =200;
    $total = array_sum(array_column($information["cartinfo"]["items"], 'total'));
    $totalItem = array_sum(array_column($information["cartinfo"]["items"], 'totalItem'));
    $information["cartinfo"]["more"] = array(
        "total" => $total,
        "totalItem"=>$totalItem

    );
} else {
    unset($information["cartinfo"]);
}

saveXMLFile($file, $information);
$dataResponse = $information;
?>
