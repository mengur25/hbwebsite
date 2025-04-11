<?php
/* Payment Notify
 * IPN URL: Ghi nhận kết quả thanh toán từ VNPAY
 */
require_once __DIR__ . "/config.php";
require_once __DIR__ . "/../admin/inc/db_config.php";

$inputData = array();
$returnData = array();
foreach ($_GET as $key => $value) {
    if (substr($key, 0, 4) == "vnp_") {
        $inputData[$key] = $value;
    }
}

$vnp_SecureHash = $inputData['vnp_SecureHash'];
unset($inputData['vnp_SecureHash']);
ksort($inputData);
$i = 0;
$hashData = "";
foreach ($inputData as $key => $value) {
    if ($i == 1) {
        $hashData .= '&' . urlencode($key) . "=" . urlencode($value);
    } else {
        $hashData .= urlencode($key) . "=" . urlencode($value);
        $i = 1;
    }
}

$secureHash = hash_hmac('sha512', $hashData, $vnp_HashSecret);
$vnpTranId = $inputData['vnp_TransactionNo'];
$vnp_BankCode = $inputData['vnp_BankCode'];
$vnp_Amount = $inputData['vnp_Amount'] / 100;
$orderId = $inputData['vnp_TxnRef'];

$Status = 0;

try {
    if ($secureHash == $vnp_SecureHash) {
        $order = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM `booking_order` WHERE `order_id`='$orderId'"));
        if ($order != NULL) {
            if ($order['trans_amt'] == $vnp_Amount) {
                if ($order['booking_status'] == 'pending') {
                    if ($inputData['vnp_ResponseCode'] == '00' && $inputData['vnp_TransactionStatus'] == '00') {
                        $Status = 1; // Thành công
                        mysqli_query($con, "UPDATE `booking_order` SET `booking_status`='booked', `trans_id`='$vnpTranId' WHERE `order_id`='$orderId'");
                    } else {
                        $Status = 2; // Thất bại
                        mysqli_query($con, "UPDATE `booking_order` SET `booking_status`='failed' WHERE `order_id`='$orderId'");
                    }
                    $returnData['RspCode'] = '00';
                    $returnData['Message'] = 'Confirm Success';
                } else {
                    $returnData['RspCode'] = '02';
                    $returnData['Message'] = 'Order already confirmed';
                }
            } else {
                $returnData['RspCode'] = '04';
                $returnData['Message'] = 'Invalid amount';
            }
        } else {
            $returnData['RspCode'] = '01';
            $returnData['Message'] = 'Order not found';
        }
    } else {
        $returnData['RspCode'] = '97';
        $returnData['Message'] = 'Invalid signature';
    }
} catch (Exception $e) {
    $returnData['RspCode'] = '99';
    $returnData['Message'] = 'Unknown error';
}

echo json_encode($returnData);