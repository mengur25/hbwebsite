<?php
require 'vendor/autoload.php';

use Http\Discovery\Psr18ClientDiscovery;

try {
    $client = Psr18ClientDiscovery::find();
    echo "Đã tìm thấy client PSR-18: " . get_class($client) . "\n";
} catch (Exception $e) {
    echo "Lỗi: " . $e->getMessage() . "\n";
}


// $conn = mysqli_connect('localhost', 'root', '', 'hbwebsite', 3306);
// if ($conn) {
//     echo "Connected successfully!";
// } else {
//     echo "Connection failed: " . mysqli_connect_error();
// }
// if (!$con) {
//     die("Cannot connect to Database" . mysqli_connect_error());
// }