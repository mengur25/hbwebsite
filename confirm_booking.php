<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php require 'inc/links.php' ?>
    <title><?php echo $settings_r['site_title'] ?> - CONFIRM BOOKING</title>

</head>

<body class="bg-light">
    <!-- nav-bar -->
    <?php require('inc/header.php'); ?>

    <?php

    /*
        Check room id from url is present or not
        Shutdown mode is active or not
        User is logged in or not
    */

    if (!isset($_GET['id']) || $settings_r['shutdown'] == true) {
        redirect('rooms.php');
    } else if (!(isset($_SESSION['login']) && $_SESSION['login'] == true)) {
        redirect('rooms.php');
    }

    // filter and get room and user data

    $data = filteration($_GET);

    $room_res = select("SELECT * FROM `rooms` WHERE `id`=? AND `status`=? AND `removed`=?", [$data['id'], 1, 0], 'iii');

    if (mysqli_num_rows($room_res) == 0) {
        redirect('rooms.php');
    }

    $room_data = mysqli_fetch_assoc($room_res);

    $_SESSION['room'] = [
        "id" => $room_data['id'],
        "name" => $room_data['name'],
        "price" => $room_data['price'],
        "payment" => null,
        "available" => false
    ];

    $user_res = select(
        "SELECT * FROM `user_cred` WHERE `id` =? LIMIT 1",
        [$_SESSION['uId']],
        'i'
    );

    $user_data = mysqli_fetch_assoc($user_res);
    ?>



    <div class="container">
        <div class="row">

            <div class="col-12 my-5 px-4">
                <h2 class="fw-bold"><?php echo $room_data['name'] ?></h2>
                <div style="font-size: 14px;">
                    <a href="index.php" class="text-secondary text-decoration-none">HOME</a>
                    <span class="text-secondary"> > </span>
                    <a href="index.php" class="text-secondary text-decoration-none">ROOMS</a>
                    <span class="text-secondary"> > </span>
                    <a href="#" class="text-secondary text-decoration-none">CONFIRM</a>
                </div>
            </div>

            <div class="col-lg-7 col-md-12 px-4 mb-3">
                <?php
                $room_thumb = ROOMS_IMG_PATH . "thumbnail.jpg";
                $thumb_q = mysqli_query($con, "SELECT * FROM `room_images` 
                                WHERE `room_id`='$room_data[id]' AND `thumb` ='1'");

                if (mysqli_num_rows($thumb_q) > 0) {
                    $thumb_res = mysqli_fetch_assoc($thumb_q);
                    $room_thumb = ROOMS_IMG_PATH . $thumb_res['image'];
                }

                echo <<< data
                        <div class="card p-3 shadow-sm rounded">
                            <img src="$room_thumb" class="img-fluid rounded mb-3">
                            <h5>$room_data[name]</h5>
                            <h6>\$$room_data[price]</h6>
                        </div>
                    data;
                ?>
            </div>

            <div class="col-lg-5 col-md-12 px-4">
                <div class="card mb-4 border-0 shadow-sm rounded-3">
                    <div class="card-body">
                        <form action="pay_now.php" id="booking_form" method="POST">
                            <h6 class="mb-3">BOOKING DETAILS</h6>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="exampleFormControlInput1" class="form-label">Name</label>
                                    <input name="name" type="text" value="<?php echo $user_data['name'] ?>" class="form-control shadow-none" placeholder="Your name" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="exampleFormControlInput1" class="form-label">Phone Number</label>
                                    <input name="phonenum" type="number" value="<?php echo $user_data['phonenum'] ?>" class="form-control shadow-none" placeholder="Your name" required>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label for="exampleFormControlInput1" class="form-label">Address</label>
                                    <textarea name="address" class="form-control shadow-none" rows="1" required><?php echo $user_data['address'] ?></textarea>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="exampleFormControlInput1" class="form-label">Check-in</label>
                                    <input name="checkin" onchange="check_availability()" type="date" class="form-control shadow-none" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="exampleFormControlInput1" class="form-label">Check-out</label>
                                    <input name="checkout" onchange="check_availability()" type="date" class="form-control shadow-none" required>
                                </div>
                                <div class="col-12 mb-3">
                                    <h6>Payment Method</h6>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="bankCode" id="bankCode1" value="VNPAYQR" checked>
                                        <label class="form-check-label" for="bankCode1">VNPAY Default (Choose on VNPay page)</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="bankCode" id="bankCode2" value="COD">
                                        <label class="form-check-label" for="bankCode2">COD</label>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="spinner-border text-info mb-3 d-none" id="info_loader" role="status">
                                        <span class="visually-hidden">Loading...</span>
                                    </div>

                                    <h6 class="mb-3 text-danger" id="pay_info">Provide check-in & check-out date!</h6>

                                    <button name="pay_now" type="submit" class="btn w-100 text-white custom-bg shadow-none mb-1" disabled>PAY NOW</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <!-- Footer -->
    <?php require 'inc/footer.php'; ?>

    <script>
        let booking_form = document.getElementById('booking_form');
        let info_loader = document.getElementById('info_loader');
        let pay_info = document.getElementById('pay_info');

        function check_availability() {
            let checkin_val = booking_form.elements['checkin'].value;
            let checkout_val = booking_form.elements['checkout'].value;

            booking_form.elements['pay_now'].setAttribute('disabled', true);

            if (checkin_val != '' && checkout_val != '') {

                pay_info.classList.add('d-none');
                pay_info.classList.replace('text-dark', 'text-danger');
                info_loader.classList.remove('d-none');

                let data = new FormData();

                data.append('check_availability', '');
                data.append('check_in', checkin_val);
                data.append('check_out', checkout_val);

                let xhr = new XMLHttpRequest();
                xhr.open("POST", "ajax/confirm_booking.php", true);

                xhr.onload = function() {
                    console.log("AJAX response:", this.responseText);
                    try {
                        let data = JSON.parse(this.responseText);
                        if (data.status == 'check_in_out_equal') {
                            pay_info.innerText = "You cannot check-out on the same day!";
                        } else if (data.status == 'check_out_earlier') {
                            pay_info.innerText = "Check-out date is earlier than check-in date!";
                        } else if (data.status == 'check_in_earlier') {
                            pay_info.innerText = "Check-in date is earlier than today's date!";
                        } else if (data.status == 'unavailable') {
                            pay_info.innerText = "Room not available for this check-in date!";
                        } else {
                            pay_info.innerHTML = "No. of Days:" + data.days + "<br> Total Amount to Pay: $" + data.payment;
                            pay_info.classList.replace('text-danger', 'text-dark');
                            booking_form.elements['pay_now'].removeAttribute('disabled');


                            // Lưu total payment vào session bằng AJAX
                            let paymentData = new FormData();
                            paymentData.append('set_payment', data.payment);

                            let paymentXhr = new XMLHttpRequest();
                            paymentXhr.open("POST", "ajax/set_payment.php", true);
                            paymentXhr.onload = function() {
                                if (this.status !== 200) {
                                    console.error('Failed to set payment in session');
                                }
                            };
                            paymentXhr.send(paymentData);
                        }

                        pay_info.classList.remove('d-none');
                        info_loader.classList.add('d-none');
                    } catch (e) {
                        alert('error', 'Invalid response from server!');
                        console.error('Parse error:', this.responseText);
                    }
                };
                xhr.onerror = function() {
                    alert('error', 'An error occurred while processing your request.');
                };
                xhr.send(data);
            }
        }
    </script>

</body>

</html>