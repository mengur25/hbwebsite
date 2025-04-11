<?php
require '../admin/inc/db_config.php';
require '../admin/inc/essentials.php';
require __DIR__ . '/../vendor/autoload.php';

date_default_timezone_set("Asia/Ho_Chi_Minh");

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

header('Content-Type: application/json');


function send_mail($to, $subject, $html, $type = 'email_confirmation')
{
    if ($type == "email_confirmation") {
        $page = 'email_confirm.php';
        $email_subject = "Account Verification Link";
        $content = "confirm your email";
        $url_param = "email_confirmation=1";
    } elseif ($type == "password_reset") {
        $page = 'index.php';
        $email_subject = "Password Reset Link";
        $content = "reset your password";
        $url_param = "email_confirmation=1";
    } else {
        error_log(date('Y-m-d H:i:s') . " - Invalid email type: $type");
        return false;
    }

    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = EMAIL;
        $mail->Password = EMAIL_PASSWORD;
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        $mail->setFrom('mengur05@gmail.com', 'YN Hotel');
        $mail->addAddress($to);
        $mail->isHTML(true);
        $mail->Subject = $email_subject;
        $confirm_url = SITE_URL . "$page?email_confirmation=1&email=" . urlencode($to) . "&token=" . urlencode($html);
        $htmlContent = "<html><body><h1>" . ($type == "email_confirmation" ? "Confirm your account" : "Reset your password") . "</h1><p>Hello $subject,</p><p>Click here to $content:</p><p><a href='$confirm_url'>Click me</a></p></body></html>";
        $mail->Body = $htmlContent;

        $mail->send();
        error_log(date('Y-m-d H:i:s') . " - Email ($type) sent successfully to $to via PHPMailer");
        return true;
    } catch (Exception $e) {
        error_log(date('Y-m-d H:i:s') . " - Failed to send email ($type) to $to via PHPMailer: " . $mail->ErrorInfo);
        return false;
    }
}

// Xử lý request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // register
    if (isset($_POST['register']) && $_POST['register'] == true) {
        error_log(date('Y-m-d H:i:s') . " - POST data: " . print_r($_POST, true));
        error_log(date('Y-m-d H:i:s') . " - FILES data: " . print_r($_FILES, true));

        $required_fields = ['name', 'email', 'pass', 'cpass', 'address', 'phonenum', 'pincode', 'dob'];
        foreach ($required_fields as $field) {
            if (!isset($_POST[$field]) || empty($_POST[$field])) {
                echo json_encode(['success' => false, 'message' => "missing_field_$field"]);
                exit;
            }
        }

        $data = filteration($_POST);
        $data['phonenum'] = (int)$data['phonenum'];
        $data['pincode'] = (int)$data['pincode'];

        if ($data['pass'] !== $data['cpass']) {
            echo json_encode(['success' => false, 'message' => 'pass_mismatch']);
            exit;
        }

        $u_exist = select(
            "SELECT * FROM `user_cred` WHERE `email` =? OR `phonenum` =? LIMIT 1",
            [$data['email'], $data['phonenum']],
            'ss'
        );

        if ($row = mysqli_fetch_assoc($u_exist)) {
            if ($row['email'] === $data['email']) {
                echo json_encode(['success' => false, 'message' => 'email_already']);
            } elseif ($row['phonenum'] === $data['phonenum']) {
                echo json_encode(['success' => false, 'message' => 'phonenum_already']);
            }
            exit;
        }

        if (!isset($_FILES['profile']) || $_FILES['profile']['error'] !== UPLOAD_ERR_OK) {
            echo json_encode(['success' => false, 'message' => 'inv_img']);
            exit;
        }

        $img = uploadUserImage($_FILES['profile']);
        if ($img == 'inv_img' || $img == 'upd_failed') {
            echo json_encode(['success' => false, 'message' => $img]);
            exit;
        }

        $token = bin2hex(random_bytes(16));
        $mailSent = send_mail($data['email'], $data['name'], $token, "email_confirmation");
        if (!$mailSent) {
            echo json_encode(['success' => false, 'message' => 'mail_failed']);
            exit;
        }

        $enc_pass = password_hash($data['pass'], PASSWORD_BCRYPT);
        $query = "INSERT INTO `user_cred`(`name`, `email`, `address`, `phonenum`, `pincode`, `dob`, `profile`, `password`, `token`) 
                  VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $values = [$data['name'], $data['email'], $data['address'], $data['phonenum'], $data['pincode'], $data['dob'], $img, $enc_pass, $token];
        $result = insert($query, $values, 'sssssssss');

        echo json_encode(['success' => $result > 0, 'message' => $result > 0 ? 'Đăng ký thành công' : 'ins_failed']);
        exit;
    }

    // login
    elseif (isset($_POST['login'])) {
        $data = filteration($_POST);
        $u_exist = select(
            "SELECT * FROM `user_cred` WHERE `email` =? OR `phonenum` =? LIMIT 1",
            [$data['email_mob'], $data['email_mob']],
            'ss'
        );

        $response = [];
        if (mysqli_num_rows($u_exist) == 0) {
            $response = ["success" => false, "message" => "inv_email_mob"];
        } else {
            $u_fetch = mysqli_fetch_assoc($u_exist);
            if ($u_fetch['is_verified'] == 0) {
                $response = ["success" => false, "message" => "not_verified"];
            } else if ($u_fetch['status'] == 0) {
                $response = ["success" => false, "message" => "inactive"];
            } else {
                if (!password_verify($data['pass'], $u_fetch['password'])) {
                    $response = ["success" => false, "message" => "invalid_pass"];
                } else {
                    session_start();
                    $_SESSION['login'] = true;
                    $_SESSION['uId'] = $u_fetch['id'];
                    $_SESSION['uName'] = $u_fetch['name'];
                    $_SESSION['uPic'] = $u_fetch['profile'];
                    $_SESSION['uPhone'] = $u_fetch['phonenum'];
                    $response = [
                        "success" => true,
                        "user" => [
                            "name" => $u_fetch['name'],
                            "profile" => isset($u_fetch['profile']) ? $u_fetch['profile'] : 'default.png'
                        ]
                    ];
                }
            }
        }
        echo json_encode($response);
        exit;
    }

    // forgot password
    elseif (isset($_POST['forgot_pass'])) {
        // Xử lý Forgot Password
        $data = filteration($_POST);
        $email_mob = $data['email'];

        $u_exist = select(
            "SELECT * FROM `user_cred` WHERE `email` =? LIMIT 1",
            [$email_mob],
            's'
        );

        if (mysqli_num_rows($u_exist) == 0) {
            echo json_encode(['success' => false, 'message' => 'inv_email']);
            exit;
        } else {
            $u_fetch = mysqli_fetch_assoc($u_exist);
            if ($u_fetch['is_verified'] == 0) {
                echo json_encode(['success' => false, 'message' => 'not_verified']);
                exit;
            } else if ($u_fetch['status'] == 0) {
                echo json_encode(['success' => false, 'message' => 'inactive']);
                exit;
            } else {
                $token = bin2hex(random_bytes(16));
                if(!send_mail($u_fetch['email'], $u_fetch['name'], $token, 'password_reset')){
                    echo 'mail_failed';
                    exit;
                }
                else{
                    $date = date("Y-m-d");

                    $query = mysqli_query($con,"UPDATE `user_cred` SET `token`='$token', t_expire = '$date' 
                    WHERE `id` ='$u_fetch[id]' ");

                    if($query){
                        echo 1;
                    }
                    else{
                        echo 'upd_failed';
                    }
                }
                $update_token = update(
                    "UPDATE `user_cred` SET `token`=?, `t_expire`=? WHERE `id`=?",
                    [$token, $date, $u_fetch['id']],
                    'ssi'
                );

            }
        }


    } 
    
    // reccover account
    elseif (isset($_POST['recover_user'])) {
        $data = filteration($_POST);
        $enc_pass = password_hash($data['pass'], PASSWORD_BCRYPT);

        $query = "UPDATE `user_cred` SET `password`=?, `token`=?, `t_expire`=? 
                  WHERE `email`=? AND `token`=?";
        $values = [$enc_pass, null, null, $data['email'], $data['token']];

        if (update($query, $values, 'sssss')) {
            echo json_encode(['success' => true, 'message' => 'password_reset_success']);
        } else {
            echo json_encode(['success' => false, 'message' => 'failed']);
        }
        exit;
    }

    else {
        echo json_encode(['success' => false, 'message' => 'invalid_request']);
        exit;
    }
} else {
    echo json_encode(['success' => false, 'message' => 'invalid_method']);
    exit;
}
