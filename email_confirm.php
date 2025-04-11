<?php

require 'admin/inc/db_config.php';
require 'admin/inc/essentials.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

function send_mail($to, $subject, $html) {
    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'mengur05@gmail.com'; 
        $mail->Password = ' '; 
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        $mail->setFrom('mengur05@gmail.com', 'YN Hotel');
        $mail->addAddress($to);
        $mail->isHTML(true);
        $mail->Subject = 'Account Verification Link';
        $confirm_url = SITE_URL . "email_confirm.php?email_confirmation=1&email=" . urlencode($to) . "&token=" . urlencode($html);        
        // Nội dung email với liên kết xác nhận
        $htmlContent = "<html><body><h1>Xác nhận đăng ký</h1><p>Xin chào $subject,</p><p>Nhấn vào liên kết dưới đây để xác nhận email của bạn:</p><p><a href='$confirm_url'>Nhấn vào đây để xác nhận</a></p></body></html>";
        $mail->Body = $htmlContent;

        $mail->send();
        error_log(date('Y-m-d H:i:s') . " - Email sent successfully to $to via PHPMailer");
        return true;
    } catch (Exception $e) {
        error_log(date('Y-m-d H:i:s') . " - Failed to send email to $to via PHPMailer: " . $mail->ErrorInfo);
        return false;
    }
}

if(isset($_GET['email_confirmation'])){
    $data = filteration($_GET);
    $query = select("SELECT * FROM `user_cred` WHERE `email`=? AND `token`=? LIMIT 1"
    ,[$data['email'], $data['token']],'ss' );

    if(mysqli_num_rows($query)==1){
        $fetch= mysqli_fetch_assoc($query);

        if($fetch['is_verified']==1){
            echo"<script>alert('Email already verified') </script>";
        }
        else{
            $update = update("UPDATE `user_cred` SET `is_verified`=? WHERE `id`=?",[1,$fetch['id']],'ii');
            if($update){
                echo "<script>alert('Email verification successful!'); setTimeout(function(){ window.location.href='index.php'; }, 1000);</script>";
                
            }
            else{
                echo"<script>alert('Email verification failed! Server Down!') </script>";
            }
        }
        redirect("index.php");
    }
    else{
        echo"<script>alert('Invalid or Expired Link!') </script>";
        redirect("index.php");
    }
}


?>