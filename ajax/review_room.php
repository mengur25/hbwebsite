<?php
require '../admin/inc/db_config.php';
require '../admin/inc/essentials.php';
require __DIR__ . '/../vendor/autoload.php';

date_default_timezone_set("Asia/Ho_Chi_Minh");
session_start();

if (!(isset($_SESSION['login']) && $_SESSION['login'] == true)) {
    redirect('index.php');
}

if(isset($_POST['review_form'])){
    $frm_data = filteration($_POST);

    $udp_query ="UPDATE `booking_order` SET `rate_review`=?
    WHERE `booking_id`=? AND `user_id`=?";

    $udp_values=[1,$frm_data['booking_id'],$_SESSION['uId']];

    $udp_result = update($udp_query,$udp_values,'iii');


    $ins_query = "INSERT INTO `rating_review`( `booking_id`, `room_id`, `user_id`, `rating`, `review`) VALUES (?,?,?,?,?)";
    $ins_values = [$frm_data['booking_id'], $frm_data['room_id'], $_SESSION['uId'], $frm_data['rating'], $frm_data['review']];
    $ins_result = insert($ins_query, $ins_values, 'iiiis');

    // var_dump($ins_result); 
    // exit;

    echo $ins_result;
}
?>