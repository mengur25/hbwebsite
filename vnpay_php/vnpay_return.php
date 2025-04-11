<?php
require_once __DIR__ . "/config.php";
require_once __DIR__ . "/../admin/inc/db_config.php";
require_once __DIR__ . "/../admin/inc/essentials.php";

// Lấy dữ liệu từ VNPay và kiểm tra checksum
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
$orderId = $inputData['vnp_TxnRef'];
$amount = $inputData['vnp_Amount'] / 100;

// Kiểm tra và cập nhật cơ sở dữ liệu
$order = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM `booking_order` WHERE `order_id`='$orderId'"));
if ($secureHash == $vnp_SecureHash && $order && $order['trans_amt'] == $amount) {
    if ($inputData['vnp_ResponseCode'] == '00') {
        mysqli_query($con, "UPDATE `booking_order` SET `booking_status`='booked', `trans_id`='$inputData[vnp_TransactionNo]' WHERE `order_id`='$orderId'");
    } else {
        mysqli_query($con, "UPDATE `booking_order` SET `booking_status`='failed' WHERE `order_id`='$orderId'");
    }
}

if ($secureHash == $vnp_SecureHash) {
    $order_id = $inputData['vnp_TxnRef'];
    $trans_id = $inputData['vnp_TransactionNo'];
    $trans_amt = $inputData['vnp_Amount'] / 100; // Chia 100 để lấy giá trị thực
    $trans_status = $inputData['vnp_ResponseCode']; // Lưu mã phản hồi trực tiếp
    $trans_resp_msg = getVnpResponseMessage($trans_status);

    // Cập nhật trạng thái đơn hàng
    $upd_query = "UPDATE `booking_order` SET `trans_id`=?, `trans_amt`=?, `trans_status`=?, `trans_resp_msg`=? WHERE `order_id`=?";
    $values = [$trans_id, $trans_amt, $trans_status, $trans_resp_msg, $order_id];
    $datatypes = "sdsss";
    update($upd_query, $values, $datatypes);

    // Chuyển hướng đến trang trạng thái thanh toán
    // redirect($vnp_Url);
    // redirect('bookings.php');

} else {
    redirect('index.php');
}

// Hàm lấy mô tả trạng thái từ mã phản hồi
function getVnpResponseMessage($code)
{
    $messages = [
        '00' => 'Giao dịch VNPAY thành công',
        '01' => 'Giao dịch chưa hoàn tất',
        '02' => 'Giao dịch bị lỗi',
        '07' => 'Giao dịch bị nghi ngờ gian lận',
        '09' => 'Giao dịch thất bại: Số dư không đủ',
        '24' => 'Người dùng hủy giao dịch',
    ];
    return $messages[$code] ?? 'Lỗi không xác định';
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>VNPAY RESPONSE</title>
    <link href="/vnpay_php/assets/bootstrap.min.css" rel="stylesheet" />
    <link href="/vnpay_php/assets/jumbotron-narrow.css" rel="stylesheet">
    <script src="/vnpay_php/assets/jquery-1.11.3.min.js"></script>
</head>

<body>
    <div class="container">
        <div class="header clearfix">
            <h3 class="text-muted">VNPAY RESPONSE</h3>
        </div>
        <div class="table-responsive">
            <div class="form-group">
                <label>Mã đơn hàng:</label>
                <label><?php echo htmlspecialchars($orderId); ?></label>
            </div>
            <div class="form-group">
                <label>Số tiền:</label>
                <label><?php echo number_format($amount); ?> VND</label>
            </div>
            <div class="form-group">
                <label>Nội dung thanh toán:</label>
                <label><?php echo htmlspecialchars($inputData['vnp_OrderInfo']); ?></label>
            </div>
            <div class="form-group">
                <label>Mã phản hồi (vnp_ResponseCode):</label>
                <label><?php echo htmlspecialchars($inputData['vnp_ResponseCode']); ?></label>
            </div>
            <div class="form-group">
                <label>Mã GD Tại VNPAY:</label>
                <label><?php echo htmlspecialchars($inputData['vnp_TransactionNo']); ?></label>
            </div>
            <div class="form-group">
                <label>Mã Ngân hàng:</label>
                <label><?php echo htmlspecialchars($inputData['vnp_BankCode']); ?></label>
            </div>
            <div class="form-group">
                <label>Thời gian thanh toán:</label>
                <label><?php echo htmlspecialchars($inputData['vnp_PayDate']); ?></label>
            </div>
            <div class="form-group">
                <label>Kết quả:</label>
                <label>
                    <?php
                    if ($secureHash == $vnp_SecureHash) {
                        if ($inputData['vnp_ResponseCode'] == '00') {
                            echo "<span style='color:blue'>GD Thanh cong</span>";
                        } else {
                            echo "<span style='color:red'>GD Khong thanh cong</span>";
                        }
                    } else {
                        echo "<span style='color:red'>Chu ky khong hop le</span>";
                    }
                    ?>
                </label>
            </div>
            <div class="form-group">
                <a href="../pay_status.php?<?php echo http_build_query($_GET); ?>">Continue to Payment Status</a>
            </div>
        </div>
        <footer class="footer">
            <p>© VNPAY <?php echo date('Y'); ?></p>
        </footer>
    </div>
</body>

</html>