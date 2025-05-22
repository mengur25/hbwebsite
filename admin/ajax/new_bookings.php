<?php
require '../inc/essentials.php';
require '../inc/db_config.php';
adminLogin();

if (isset($_POST['get_bookings'])) {
    $frm_data = filteration($_POST);

    $query = "SELECT bo.*, bd.* FROM `booking_order` bo
    INNER JOIN `booking_details` bd ON bo.booking_id = bd.booking_id
    WHERE (bo.order_id LIKE ? OR bd.phonenum LIKE ? OR bd.user_name LIKE ?)
    AND bo.booking_status = ? AND bo.arrival = ? ORDER BY bo.booking_id ASC";

    $res = select($query, ["%$frm_data[search]%", "%$frm_data[search]%", "%$frm_data[search]%", "booked", 0], 'ssssi');
    $i = 1;
    $table_data = "";

    if (mysqli_num_rows($res) == 0) {
        echo "<b>No Data Found</b>";
        exit;
    }

    while ($data = mysqli_fetch_assoc($res)) {
        $date = date("d-m-Y", strtotime($data['datentime']));
        $checkin = date("d-m-Y", strtotime($data['check_in']));
        $checkout = date("d-m-Y", strtotime($data['check_out']));

        $table_data .= "
            <tr>
                <td>$i</td>
                <td>
                    <span class='badge bg-primary'>
                        Order ID: $data[order_id]
                    </span>
                    <br>
                    <b>Name:</b> $data[user_name]
                    <br>
                    <b>Phone No:</b> $data[phonenum]
                </td>
                <td>
                    <b>Room:</b> $data[room_name]
                    <br>
                    <b>Price: </b> \$$data[price]
                </td>
                <td>
                    <b>Check-in:</b> $checkin
                    <br>
                    <b>Check-out: </b> $checkout
                    <br>
                    <b>Paid: </b> $data[trans_amt] VND
                    <br>
                    <b>Date: </b> $date
                    <br>
                </td>
                <td>
                    <button type='button' onclick='assign_room($data[booking_id])' class='btn text-white btn-sm fw-bold custom-bg shadow-none' data-bs-toggle='modal' data-bs-target='#assign-room'>
                        <i class='bi bi-check2-square'></i> Assign Room
                    </button>
                    <br>
                    <button type='button' onclick='cancel_booking($data[booking_id])' class='btn btn-outline-danger mt-2 btn-sm fw-bold shadow-none'>
                        <i class='bi bi-trash'></i> Cancel Booking
                    </button>
                </td>
            </tr>
        ";
        $i++;
    }

    echo $table_data;
}

if (isset($_POST['assign_room'])) {
    $frm_data = filteration($_POST);

    $query = "UPDATE `booking_order` bo INNER JOIN `booking_details` bd
    ON bo.booking_id = bd.booking_id
    SET bo.arrival =?, bo.rate_review=?, bd.room_no =?
    WHERE bo.booking_id =?";

    $values = [1, 0, $frm_data['room_no'], $frm_data['booking_id']];
    $res = update($query, $values, 'iisi');
    if ($res == 2) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false]);
    }
}

if (isset($_POST['cancel_booking'])) {
    $frm_data = filteration($_POST);

    // Lấy thông tin trans_resp_msg để xác định loại thanh toán
    $booking_query = "SELECT `trans_resp_msg` FROM `booking_order` WHERE `booking_id`=?";
    $booking_res = select($booking_query, [$frm_data['booking_id']], 'i');
    
    if (mysqli_num_rows($booking_res) == 0) {
        echo json_encode(['success' => false, 'message' => 'Booking not found']);
        exit;
    }
    
    $booking_data = mysqli_fetch_assoc($booking_res);
    $trans_resp_msg = $booking_data['trans_resp_msg'];

    // Kiểm tra trans_resp_msg để quyết định trạng thái refund
    if ($trans_resp_msg === 'Payment on COD') {
        // COD: Không cần hoàn tiền, đặt refund = 1
        $query = "UPDATE `booking_order` SET `booking_status`=?, `refund`=? WHERE `booking_id`=?";
        $values = ['cancelled', 1, $frm_data['booking_id']];
    } else {
        // VNPay hoặc các phương thức khác: Chờ hoàn tiền, đặt refund = 0
        $query = "UPDATE `booking_order` SET `booking_status`=?, `refund`=? WHERE `booking_id`=?";
        $values = ['cancelled', 0, $frm_data['booking_id']];
    }

    $res = update($query, $values, 'sii');
    echo json_encode(['success' => ($res == 1)]);
}
?>