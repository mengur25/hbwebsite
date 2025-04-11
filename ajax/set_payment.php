<?php
session_start();

if (isset($_POST['set_payment'])) {
    $payment = floatval($_POST['set_payment']);
    $_SESSION['room']['payment'] = $payment;
    echo "success";
} else {
    echo "error";
}
?>