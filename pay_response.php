<?php
require 'admin/inc/db_config.php';
require 'admin/inc/essentials.php';
require_once __DIR__ . '/vnpay_php/config.php';
require_once 'inc/vnpay/encdec_vnpay.php';
date_default_timezone_set("Asia/Ho_Chi_Minh");
session_start();
unset($_SESSION['room']);

function regenerate_session($uId)
{
    $user_q = select("SELECT * FROM `user_cred` WHERE `id`=? LIMIT 1", [$uId], 'i');
    $user_fetch = mysqli_fetch_assoc($user_q);

    $_SESSION['login'] = true;
    $_SESSION['uId'] = $user_fetch['id'];
    $_SESSION['uName'] = $user_fetch['name'];
    $_SESSION['uPic'] = $user_fetch['profile'];
    $_SESSION['uPhone'] = $user_fetch['phonenum'];
}

// Lấy dữ liệu từ VNPay
$vnp_SecureHash = $_GET['vnp_SecureHash'];
$inputData = array();
foreach ($_GET as $key => $value) {
    if (substr($key, 0, 4) == "vnp_") {
        $inputData[$key] = $value;
    }
}

unset($inputData['vnp_SecureHash']);
ksort($inputData);
$hashData = "";
$i = 0;
foreach ($inputData as $key => $value) {
    if ($i == 1) {
        $hashData .= '&' . urlencode($key) . "=" . urlencode($value);
    } else {
        $hashData .= urlencode($key) . "=" . urlencode($value);
        $i = 1;
    }
}

$secureHash = hash_hmac('sha512', $hashData, $vnp_HashSecret);

// Hàm lấy mô tả trạng thái từ mã phản hồi của VNPay
function getVnpResponseMessage($code) {
    $messages = [
        '00' => 'Payment by VNPAY',
        '01' => 'Giao dịch chưa hoàn tất',
        '02' => 'Giao dịch bị lỗi',
        '07' => 'Giao dịch bị nghi ngờ gian lận',
        '09' => 'Giao dịch thất bại: Số dư không đủ',
        '24' => 'Người dùng hủy giao dịch',
        // Thêm các mã khác nếu cần từ tài liệu VNPay
    ];
    return $messages[$code] ?? 'Lỗi không xác định (Mã: ' . $code . ')';
}

// Kiểm tra checksum
if ($secureHash == $vnp_SecureHash) {
    $order_id = $inputData['vnp_TxnRef'];
    $trans_id = $inputData['vnp_TransactionNo'];
    $trans_amt = $inputData['vnp_Amount'] / 100; // Chia 100 để lấy giá trị thực
    $trans_status = $inputData['vnp_ResponseCode']; // Lưu mã phản hồi trực tiếp
    $trans_resp_msg = getVnpResponseMessage($trans_status);

    // Kiểm tra đơn hàng trong cơ sở dữ liệu
    $slct_query = "SELECT `booking_id`, `user_id` FROM `booking_order` WHERE `order_id`=?";
    $slct_res = select($slct_query, [$order_id], 's');

    if (mysqli_num_rows($slct_res) == 0) {
        redirect('index.php');
    }

    $slct_fetch = mysqli_fetch_assoc($slct_res);

    // Kiểm tra và tái tạo session nếu cần
    if (!(isset($_SESSION['login']) && $_SESSION['login'] == true)) {
        regenerate_session($slct_fetch['user_id']);
    }

    // Cập nhật trạng thái đơn hàng dựa trên mã phản hồi
    if ($trans_status == "00") {
        $upd_query = "UPDATE `booking_order` SET `booking_status`='booked', `trans_id`=?, `trans_amt`=?, `trans_status`=?, `trans_resp_msg`=? WHERE `booking_id`=?";
        $values = [$trans_id, $trans_amt, $trans_status, $trans_resp_msg, $slct_fetch['booking_id']];
        $datatypes = "sdssi";
        update($upd_query, $values, $datatypes);
    } else {
        $upd_query = "UPDATE `booking_order` SET `booking_status`='failed', `trans_id`=?, `trans_amt`=?, `trans_status`=?, `trans_resp_msg`=? WHERE `booking_id`=?";
        $values = [$trans_id, $trans_amt, $trans_status, $trans_resp_msg, $slct_fetch['booking_id']];
        $datatypes = "sdssi";
        update($upd_query, $values, $datatypes);
    }

    // Chuyển hướng đến trang trạng thái thanh toán
    redirect($vnp_Url);
    redirect('booking.php');
} else {
    redirect('index.php');
}
?>