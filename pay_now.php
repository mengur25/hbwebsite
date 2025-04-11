<?php
session_start();
require 'admin/inc/db_config.php';
require 'admin/inc/essentials.php';
require_once __DIR__ . '/vnpay_php/config.php';
require_once 'inc/vnpay/encdec_vnpay.php';

date_default_timezone_set("Asia/Ho_Chi_Minh");

if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
    redirect('index.php');
    exit;
}

if (
    !isset($_SESSION['uId']) ||
    !isset($_SESSION['room']['payment']) ||
    !isset($_SESSION['room']['id']) ||
    !isset($_SESSION['room']['name']) ||
    !isset($_SESSION['room']['price'])
) {
    die("Error: Missing required session data (uId, room payment, id, name, or price).");
}

if (isset($_POST['pay_now'])) {
    $frm_data = filteration($_POST);

    $required_form_fields = ['checkin', 'checkout', 'name', 'phonenum', 'address'];
    $missing_fields = array_diff($required_form_fields, array_keys($frm_data));
    if (!empty($missing_fields)) {
        die("Error: Missing required form data (" . implode(", ", $missing_fields) . ").");
    }

    $uid = $_SESSION['uId'];
    $orderId = 'ORD_' . $uid . '_' . random_int(11111, 99999);
    $usdAmount = $_SESSION['room']['payment'];

    $exchangeRate = 25000;
    $vnp_Amount = $usdAmount * $exchangeRate * 100;
    $trans_amt = intval($vnp_Amount / 100);

    // Kiểm tra phương thức thanh toán
    $isCOD = (isset($frm_data['bankCode']) && $frm_data['bankCode'] === "COD");
    $booking_status = $isCOD ? 'booked' : 'pending';
    $trans_status = $isCOD ? 'COD' : 'pending';
    $trans_resp_msg = $isCOD ? 'Payment on COD' : '';
    $trans_id = $isCOD ? 'COD_' . $orderId : '';
    // Chèn vào bảng booking_order với trạng thái phù hợp
    $query1 = "INSERT INTO `booking_order`
    (`user_id`, `room_id`, `check_in`, `check_out`, `order_id`, `arrival`, `refund`, `booking_status`, `trans_id`, `trans_amt`, `trans_status`, `trans_resp_msg`)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $values1 = [
        $uid,
        $_SESSION['room']['id'],
        $frm_data['checkin'],
        $frm_data['checkout'],
        $orderId,
        0,                 
        NULL,            
        $booking_status,
        $trans_id,   
        $trans_amt,         
        $trans_status,    
        $trans_resp_msg   
    ];
    $datatypes1 = "iisssissssis";
    $result1 = insert($query1, $values1, $datatypes1);

    if ($result1 != 1) {
        die("Error: Failed to save order to booking_order. MySQL Error: " . mysqli_error($GLOBALS['con']));
    }

    $booking_id = mysqli_insert_id($GLOBALS['con']);
    if (!$booking_id) {
        die("Error: Failed to retrieve booking ID.");
    }

    // Chèn vào bảng booking_details
    $query2 = "INSERT INTO `booking_details`
        (`booking_id`, `room_name`, `price`, `total_pay`, `user_name`, `phonenum`, `address`)
        VALUES (?, ?, ?, ?, ?, ?, ?)";
    $values2 = [
        $booking_id,
        $_SESSION['room']['name'],
        $_SESSION['room']['price'],
        $usdAmount,
        $frm_data['name'],
        $frm_data['phonenum'],
        $frm_data['address']
    ];
    $datatypes2 = "isddsss";
    $result2 = insert($query2, $values2, $datatypes2);

    if ($result2 != 1) {
        die("Error: Failed to save order to booking_details. MySQL Error: " . mysqli_error($GLOBALS['con']));
    }

    // Xử lý theo phương thức thanh toán
    if ($isCOD) {
        redirect('pay_status.php?order=' . $orderId);
        exit;
    } else {
        $vnp_OrderInfo = "Payment for hotel booking order #$orderId";
        $vnp_IpAddr = $_SERVER['REMOTE_ADDR'];
        $vnp_CreateDate = date('YmdHis');
        $vnp_Locale = "en";
        $vnp_OrderType = "other";

        $inputData = [
            "vnp_Version"   => "2.1.0",
            "vnp_TmnCode"   => $vnp_TmnCode,
            "vnp_Amount"    => $vnp_Amount,
            "vnp_Command"   => "pay",
            "vnp_CreateDate"=> $vnp_CreateDate,
            "vnp_CurrCode"  => "VND",
            "vnp_IpAddr"    => $vnp_IpAddr,
            "vnp_Locale"    => $vnp_Locale,
            "vnp_OrderInfo" => $vnp_OrderInfo,
            "vnp_OrderType" => $vnp_OrderType,
            "vnp_ReturnUrl" => $vnp_Returnurl,
            "vnp_TxnRef"    => $orderId,
            "vnp_ExpireDate"=> $expire
        ];

        if (isset($frm_data['bankCode1'])) {
            $inputData['vnp_BankCode'] = $frm_data['bankCode'];
        }

        ksort($inputData);

        $query = http_build_query($inputData);
        $vnp_SecureHash = hash_hmac('sha512', $query, $vnp_HashSecret);

        error_log("inputData: " . json_encode($inputData));
        error_log("Query: " . $query);
        error_log("vnp_SecureHash: " . $vnp_SecureHash);

        $vnp_Url = $vnp_Url . "?" . $query . "&vnp_SecureHash=" . $vnp_SecureHash;

        if (filter_var($vnp_Url, FILTER_VALIDATE_URL) === false) {
            die("Error: Invalid VNPay URL generated: $vnp_Url");
        }

        redirect($vnp_Url);
        exit;
    }
} else {
    die("Error: Invalid request. 'pay_now' not set in POST data.");
}
?>