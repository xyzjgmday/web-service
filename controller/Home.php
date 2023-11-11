<?php

$url = $_SERVER['$_REQUEST_URI'];

// jIKA MENGGUNAKAN FOLDER PATH
$urlArr = explode("index.php", $url);
if (count($urlArr) >= 2) {
    $url = $urlArr[1];
}

// Jika menggunakan php -S localhost:500
if(strpos($url,"/") !== 0){
    $url = "/". $url;
}

// Untuk handle URL /
if($url == '/' && $_SERVER['REQUEST_METHOD'] == 'GET') {
    echo json_encode(array('service_name' => 'PHP Sevice App', 'status' => 'Running'));
}

?>