<?php
require 'vendor/autoload.php';

use Http\Discovery\Psr18ClientDiscovery;

try {
    $client = Psr18ClientDiscovery::find();
    echo "Đã tìm thấy client PSR-18: " . get_class($client) . "\n";
} catch (Exception $e) {
    echo "Lỗi: " . $e->getMessage() . "\n";
}



// $hname = "localhost";
// $uname = "root";
// $pass = "";
// $dbname = "hbwebsite";
// $con = mysqli_connect($hname, $uname, $pass, $dbname, 3306);
// if (!$con) {
//     die("Connection failed: " . mysqli_connect_error());
// } else {
//     echo "Connected successfully to database: $dbname";
// }
?>