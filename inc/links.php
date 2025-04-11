<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Inter&family=Merienda:wght@300..900&family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<link rel="stylesheet" href="css/common.css">

<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
date_default_timezone_set("Asia/Ho_Chi_Minh");

require_once __DIR__ . '/../admin/inc/db_config.php';
require_once __DIR__ . '/../admin/inc/essentials.php';

$contact_q = "SELECT * FROM `contact_details` WHERE`sr_no` = ?";
$settings_q = "SELECT * FROM `settings` WHERE`sr_no` = ?";
$values = [1];
$contact_r = mysqli_fetch_assoc(select($contact_q, $values, 'i'));
$settings_r = mysqli_fetch_assoc(select($settings_q, $values, 'i'));

if($settings_r['shutdown']){
    echo <<< alertbar
        <div class="bg-danger text-center p2 fw-bold">
            <i class="bi bi-exclamation-triangle-fill"></i>
            Bookings are temporarily closed!
        </div>
    alertbar;   
}
?>
