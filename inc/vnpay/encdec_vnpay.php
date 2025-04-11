<?php
// Hàm tạo checksum (mã hóa dữ liệu)
function vnpayChecksum($data) {
    ksort($data);
    $hashData = "";
    foreach ($data as $key => $value) {
        if ($hashData != "") {
            $hashData .= '&';
        }
        $hashData .= $key . "=" . $value;
    }
    return hash_hmac("sha512", $hashData, VNPAY_HASH_SECRET);
}

// Hàm kiểm tra tính toàn vẹn dữ liệu
function vnpayVerifyChecksum($data, $vnp_SecureHash) {
    $inputData = array();
    foreach ($data as $key => $value) {
        if (substr($key, 0, 4) == "vnp_") {
            $inputData[$key] = $value;
        }
    }
    unset($inputData['vnp_SecureHash']);
    ksort($inputData);
    $hashData = "";
    foreach ($inputData as $key => $value) {
        if ($hashData != "") {
            $hashData .= '&';
        }
        $hashData .= $key . "=" . $value;
    }
    $secureHash = hash_hmac("sha512", $hashData, VNPAY_HASH_SECRET);
    return $secureHash === $vnp_SecureHash;
}
?>