<?php
// frontend purpose data

define('SITE_URL','https://absolute-internal-boa.ngrok-free.app/HotelBooking/');
define('ABOUT_IMG_PATH',SITE_URL.'images/about/');
define('CAROUSEL_IMG_PATH',SITE_URL.'images/carousel/');
define('FACILITIES_IMG_PATH',SITE_URL.'images/facilities/');
define('ROOMS_IMG_PATH',SITE_URL.'images/rooms/');
define('USERS_IMG_PATH',SITE_URL.'images/users/');
// backend upload process needs this data

define('UPLOAD_IMAGE_PATH', $_SERVER['DOCUMENT_ROOT'].'/HotelBooking/images/');
define('ABOUT_FOLDER', 'about/');
define('CAROUSEL_FOLDER', 'carousel/');
define('FACILITIES_FOLDER', 'facilities/');
define('ROOMS_FOLDER', 'rooms/');
define('USERS_FOLDER', 'users/');
// mail key
define('EMAIL','mengur05@gmail.com');
define('EMAIL_PASSWORD','eqtl ccri qnoj czop');
function adminLogin()
{
    session_start();
    if (!(isset($_SESSION["adminLogin"]) && $_SESSION["adminLogin"] == true)) {
        echo "<script>
        window.location.href='index.php';
        </script>";
        exit;
    }
    // session_regenerate_id(delete_old_session: true);
}

function redirect($url)
{
    echo "<script>
        window.location.href='$url';
        </script>";
        exit;
}
function alert($type, $msg)
{
    $bs_class = ($type == "success" ? "alert-success" : "alert-danger");
    echo <<<alert
                <div class="alert $bs_class alert-dismissible fade show custom-alert" role="alert">
                    <strong class = "me-3">$msg</strong> 
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            alert;
}

function uploadImage($image, $folder){
    $valid_mime = ['image/jpeg','image/png', 'image/webp'];
    $img_mime  = $image['type'];

    if(!in_array($img_mime, $valid_mime)){
        return 'inv_img'; // invalid image mime or format
    }

    else if(($image['size']/(1024*1024))>2){
        return 'inv_size'; // invalid size greater than 2mb
    }

    else{
        $ext = pathinfo($image['name'], PATHINFO_EXTENSION);
        $rname = 'IMG_' .random_int(11111, 99999).".$ext";
        
        $img_path = UPLOAD_IMAGE_PATH.$folder.$rname;
        if(move_uploaded_file($image['tmp_name'], $img_path)){
            return $rname;
        }
        else{
            return 'upd_failed';
        }
    }
}

function deleteImage($image, $folder){
    $file_path = UPLOAD_IMAGE_PATH . $folder . $image;

    if (!file_exists($file_path)) {
        return false; 
    }

    if (unlink($file_path)) {
        return true;
    } else {
        return false;
    }
}

function uploadSVGImage($image, $folder){
    $valid_mime = ['image/svg+xml'];
    $img_mime  = $image['type'];

    if(!in_array($img_mime, $valid_mime)){
        return 'inv_img'; // invalid image mime or format
    }

    else if(($image['size']/(1024*1024))>1){
        return 'inv_size'; // invalid size greater than 1mb
    }

    else{
        $ext = pathinfo($image['name'], PATHINFO_EXTENSION);
        $rname = 'IMG_' .random_int(11111, 99999).".$ext";
        
        $img_path = UPLOAD_IMAGE_PATH.$folder.$rname;
        if(move_uploaded_file($image['tmp_name'], $img_path)){
            return $rname;
        }
        else{
            return 'upd_failed';
        }
    }
}

function uploadUserImage($image) {
    $valid_mime = ['image/jpeg', 'image/png', 'image/webp'];
    $img_mime = $image['type'];

    // Kiểm tra loại MIME
    if (!in_array($img_mime, $valid_mime)) {
        return 'inv_img'; // Định dạng hình ảnh không hợp lệ
    }

    // Kiểm tra xem tệp có được tải lên thành công không
    if ($image['error'] !== UPLOAD_ERR_OK) {
        return 'upload_error_' . $image['error']; // Lỗi tải lên
    }

    // Kiểm tra xem tệp có tồn tại không
    if (!file_exists($image['tmp_name'])) {
        return 'file_not_found'; // Tệp không tồn tại
    }

    // Tạo tên tệp mới
    $ext = strtolower(pathinfo($image['name'], PATHINFO_EXTENSION));
    $rname = 'IMG_' . random_int(11111, 99999) . '.' . $ext; // Giữ nguyên định dạng gốc
    $img_path = UPLOAD_IMAGE_PATH . USERS_FOLDER . $rname;

    // Di chuyển tệp từ thư mục tạm đến thư mục đích
    if (move_uploaded_file($image['tmp_name'], $img_path)) {
        return $rname; // Trả về tên tệp nếu thành công
    } else {
        return 'upd_failed'; // Trả về lỗi nếu thất bại
    }
}
?>