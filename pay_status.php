<?php
session_start();
require 'admin/inc/db_config.php';
require 'admin/inc/essentials.php';
date_default_timezone_set("Asia/Ho_Chi_Minh");

if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
    redirect('index.php');
}

$frm_data = filteration($_GET);
if (!isset($frm_data['order'])) {
    redirect('index.php');
}

$order_id = $frm_data['order'];

$booking_q = "SELECT bo.*, bd.* FROM `booking_order` bo 
    INNER JOIN `booking_details` bd ON bo.booking_id = bd.booking_id
    WHERE bo.order_id=? AND bo.user_id=?";
$booking_res = select($booking_q, [$order_id, $_SESSION['uId']], 'si');

if (mysqli_num_rows($booking_res) == 0) {
    redirect('index.php');
}

$booking_fetch = mysqli_fetch_assoc($booking_res);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php require 'inc/links.php' ?>
    <title><?php echo $settings_r['site_title'] ?> - PAYMENT STATUS</title>
</head>
<body class="bg-light">
    <?php require('inc/header.php'); ?>

    <div class="container">
        <div class="row">
            <div class="col-12 my-5 mb-3 px-4">
                <h2 class="fw-bold">PAYMENT STATUS</h2>
            </div>

            <?php
            if ($booking_fetch['trans_status'] == "00") {
                echo <<<data
                    <div class='col-12 px-4'>
                        <p class="fw-bold alert alert-success">
                            <i class="bi bi-check-circle-fill"></i>
                            Payment successful! Booking done!
                            <br><br>
                            <a href='bookings.php'>Go to booking</a>
                        </p>
                    </div>
                data;
            } elseif ($booking_fetch['trans_status'] == "COD") {
                echo <<<data
                    <div class='col-12 px-4'>
                        <p class="fw-bold alert alert-info">
                            <i class="bi bi-info-circle-fill"></i>
                            Booking done! Please payable on arrival.
                            <br><br>
                            <a href='bookings.php'>Go to booking</a>
                        </p>
                    </div>
                data;
            } else {
                echo <<<data
                    <div class='col-12 px-4'>
                        <p class="fw-bold alert alert-danger">
                            <i class="bi bi-exclamation-triangle-fill"></i>
                            Payment failed! {$booking_fetch['trans_resp_msg']} (ID: {$booking_fetch['trans_status']})
                            <br><br>
                            <a href='bookings.php'>Go to booking</a>
                        </p>
                    </div>
                data;
            }
            ?>
        </div>
    </div>

    <?php require 'inc/footer.php'; ?>
</body>
</html>