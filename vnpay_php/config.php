<?php
date_default_timezone_set('Asia/Ho_Chi_Minh');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
  
 $vnp_TmnCode = "LNPZ96LU"; //Mã định danh merchant kết nối (Terminal Id)
 $vnp_HashSecret = "HL3I7OB6W2E4KHDYCRE9A8NZ6RYMOQ6K"; //Secret key
 $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
 $vnp_Returnurl = "https://absolute-internal-boa.ngrok-free.app/HotelBooking/vnpay_php/vnpay_return.php";
 $vnp_apiUrl = "http://sandbox.vnpayment.vn/merchant_webapi/merchant.html";
 $apiUrl = "https://sandbox.vnpayment.vn/merchant_webapi/api/transaction";
//Config input format
//Expire
$startTime = date("YmdHis");
$expire = date('YmdHis',strtotime('+15 minutes',strtotime($startTime)));
