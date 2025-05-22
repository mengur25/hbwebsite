<?php
require '../admin/inc/db_config.php';
require '../admin/inc/essentials.php';
require __DIR__ . '/../vendor/autoload.php';

date_default_timezone_set("Asia/Ho_Chi_Minh");
session_start();

if (!(isset($_SESSION['login']) && $_SESSION['login'] == true)) {
    redirect('index.php');
}

if (isset($_POST['cancel_booking'])) {
    $frm_data = filteration($_POST);

    // Lấy thông tin trans_resp_msg để xác định loại thanh toán
    $booking_query = "SELECT `trans_resp_msg` FROM `booking_order` WHERE `booking_id`=? AND `user_id`=?";
    $booking_res = select($booking_query, [$frm_data['id'], $_SESSION['uId']], 'ii');
    
    if (mysqli_num_rows($booking_res) == 0) {
        echo 0;
        exit;
    }
    
    $booking_data = mysqli_fetch_assoc($booking_res);
    $trans_resp_msg = $booking_data['trans_resp_msg'];

    // Kiểm tra trans_resp_msg để quyết định trạng thái refund
    if ($trans_resp_msg === 'Payment on COD') {
        // COD: Không cần hoàn tiền, đặt refund = 1
        $query = "UPDATE `booking_order` SET `booking_status`=?, `refund`=? WHERE `booking_id`=? AND `user_id`=?";
        $values = ['cancelled', 1, $frm_data['id'], $_SESSION['uId']];
        $result = update($query, $values, 'siii');
    } else {
        // VNPay hoặc các phương thức khác: Chờ hoàn tiền, đặt refund = 0
        $query = "UPDATE `booking_order` SET `booking_status`=?, `refund`=? WHERE `booking_id`=? AND `user_id`=?";
        $values = ['cancelled', 0, $frm_data['id'], $_SESSION['uId']];
        $result = update($query, $values, 'siii');
    }

    echo $result;
}
?>