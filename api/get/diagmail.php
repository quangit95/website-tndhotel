<?php
// Diagnostics for mail server connectivity
$results = [];

// Test port 465
$t0 = microtime(true);
$fp465 = @fsockopen('ssl://mail92176.maychuemail.com', 465, $errno, $errstr, 3);
$t465 = microtime(true) - $t0;
if ($fp465) {
    $banner465 = fgets($fp465, 512);
    fclose($fp465);
    $results['port465'] = ['status' => 'OK', 'time' => round($t465, 3), 'banner' => trim($banner465)];
} else {
    $results['port465'] = ['status' => 'FAILED', 'time' => round($t465, 3), 'error' => "$errno: $errstr"];
}

// Test port 587
$t0 = microtime(true);
$fp587 = @fsockopen('mail92176.maychuemail.com', 587, $errno, $errstr, 3);
$t587 = microtime(true) - $t0;
if ($fp587) {
    $banner587 = fgets($fp587, 512);
    fclose($fp587);
    $results['port587'] = ['status' => 'OK', 'time' => round($t587, 3), 'banner' => trim($banner587)];
} else {
    $results['port587'] = ['status' => 'FAILED', 'time' => round($t587, 3), 'error' => "$errno: $errstr"];
}

// Also test smtp.gmail.com:587
$t0 = microtime(true);
$fpg = @fsockopen('smtp.gmail.com', 587, $errno, $errstr, 3);
$tg = microtime(true) - $t0;
if ($fpg) {
    $bannerg = fgets($fpg, 512);
    fclose($fpg);
    $results['gmail587'] = ['status' => 'OK', 'time' => round($tg, 3), 'banner' => trim($bannerg)];
} else {
    $results['gmail587'] = ['status' => 'FAILED', 'time' => round($tg, 3), 'error' => "$errno: $errstr"];
}

$dataResponse = $results;
$code = 200;
$message = "Diagnostics complete";
