<?php
require 'admin/inc/essentials.php';
require 'admin/inc/db_config.php';
require_once 'vendor/autoload.php';

session_start();
if (!(isset($_SESSION['login']) && $_SESSION['login'] == true)) {
    redirect('index.php');
}

if (isset($_GET['gen_pdf']) && isset($_GET['id'])) {
    $frm_data = filteration($_GET);

    $query = "SELECT bo.*, bd.*, uc.*
    FROM `booking_order` bo
    INNER JOIN `booking_details` bd ON bo.booking_id = bd.booking_id
    INNER JOIN `user_cred` uc ON bo.user_id = uc.id
    WHERE ((bo.booking_status = 'booked' AND bo.arrival = 1)
                OR (bo.booking_status = 'cancelled' AND bo.refund = 1)
                OR (bo.booking_status = 'failed'))    
    AND bo.booking_id = '$frm_data[id]'";

    $res = mysqli_query($con, $query);

    $total_rows = mysqli_num_rows($res);
    if ($total_rows == 0) {
        header('location: index.php');
        exit;
    }

    $data = mysqli_fetch_assoc($res);
    $date = date("h:ia | d-m-Y", strtotime($data['datentime']));
    $checkin = date("d-m-Y", strtotime($data['check_in']));
    $checkout = date("d-m-Y", strtotime($data['check_out']));

    $table_data = "
        <h2>BOOKING RECEIPT<h2>
        <table border ='1'>
            <tr>
                <td>Order ID: $data[order_id]</td>
                <td>Booking Date: $date</td>
            </tr>

            <tr>
                <td colspan='2'>Status: $data[booking_status]</td>
            </tr>

            <tr>
                <td>Name: $data[user_name]</td>
                <td>Email: $data[email]</td>
            </tr>

            <tr>
                <td>Phone Number: $data[phonenum]</td>
                <td>Address: $data[address]</td>
            </tr>

            <tr>
                <td>Room Name: $data[room_name]</td>
                <td>Total pay:\$$data[price]</td>
            </tr>

            <tr>
                <td>Check-in: $checkin</td>
                <td>Check-out:$checkout</td>
            </tr>
        
    ";


    $pdf = new TCPDF();
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetTitle('Booking Receipt');
    $pdf->AddPage();
    $pdf->SetFont('helvetica', '', 12);

    // Nội dung PDF
    $html = "<h2 style='text-align: center;'>BOOKING RECEIPT</h2>
        <table border='1' cellspacing='3' cellpadding='5'>
            <tr><td>Order ID:</td><td>{$data['order_id']}</td></tr>
            <tr><td>Booking Date:</td><td>{$date}</td></tr>
            <tr><td>Status:</td><td>{$data['booking_status']}</td></tr>
            <tr><td>Name:</td><td>{$data['user_name']}</td></tr>
            <tr><td>Email:</td><td>{$data['email']}</td></tr>
            <tr><td>Phone:</td><td>{$data['phonenum']}</td></tr>
            <tr><td>Address:</td><td>{$data['address']}</td></tr>
            <tr><td>Room Name:</td><td>{$data['room_name']}</td></tr>
            <tr><td>Total Pay:</td><td>\${$data['price']}</td></tr>
            <tr><td>Check-in:</td><td>{$checkin}</td></tr>
            <tr><td>Check-out:</td><td>{$checkout}</td></tr>";

    // Xử lý các trường hợp đặc biệt
    if ($data['booking_status'] == 'cancelled') {
        $refund = ($data['refund'] ? "Amount Refunded" : "Not Yet Refunded");
        $html .= "<tr><td>Amount Paid:</td><td>{$data['trans_amt']}</td></tr>
                  <tr><td>Refund:</td><td>{$refund}</td></tr>";
    } elseif ($data['booking_status'] == 'failed') {
        $html .= "<tr><td>Transaction Amount:</td><td>{$data['trans_amt']}</td></tr>
                  <tr><td>Failure Response:</td><td>{$data['trans_resp_msg']}</td></tr>";
    } else {
        $html .= "<tr><td>Room Number:</td><td>{$data['room_no']}</td></tr>
                  <tr><td>Amount Paid:</td><td>{$data['trans_amt']}</td></tr>";
    }

    $html .= "</table>";

    // Ghi nội dung HTML vào PDF
    $pdf->writeHTML($html, true, false, true, false, '');

    // Xuất PDF
    $pdf->Output($data['order_id'] . '.pdf', 'D');
}

else{
    header('location: index.php');
}