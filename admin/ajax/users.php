<?php
require '../inc/essentials.php';
require '../inc/db_config.php';
adminLogin();

if (isset($_POST['get_users'])) {
    $res = selectAll('user_cred');
    $i = 1;

    $path = USERS_IMG_PATH;

    $data = "";
    while ($row = mysqli_fetch_assoc($res)) {

        $del_btn = "<button type='button'onclick ='remove_user($row[id])' class='btn btn-danger shadow-none btn-sm'>
                        <i class='bi bi-trash'></i>
                    </button>";
        $verified="<span class='badge bg-warning'><i class='bi bi-x-lg'></i></span>";
        if($row['is_verified']){
            $verified="<span class='badge bg-success'><i class='bi bi-check-lg'></i></span>";
            $del_btn ="";
        }

        $status=  "<button onclick ='toggle_status($row[id],0)' class ='btn btn-dark btn-sm shadow-none'>
            active
        </button>";

        if(!$row['status']){
            $status= "<button onclick ='toggle_status($row[id],1)' class ='btn btn-danger btn-sm shadow-none'>
                inactive
            </button>";
        }

        $date = date("d-m-Y", strtotime($row['datentime']));
        $data .= "
            <tr>
            <td>$i</td>
            <td>
                <img src='$path$row[profile]' width ='55px'>
                $row[name]
            </td>
            <td>$row[email]</td>
            <td>$row[phonenum]</td> 
            <td>$row[address] | $row[pincode]</td> 
            <td>$row[dob]</td>
            <td>$verified</td>
            <td>$status</td>
            <td>$date</td>
            <td>$del_btn</td>
            </tr>
        ";
        $i++;
    }

    echo $data;
}


if (isset($_POST['toggle_status'])) {
    header('Content-Type: application/json');

    $frm_data = filteration($_POST);


    if (!isset($frm_data['value']) || !isset($frm_data['toggle_status'])) {
        echo json_encode(["status" => "error", "message" => "Missing parameters"]);
        exit;
    }

    $q = "UPDATE `user_cred` SET `status`=? WHERE `id`=?";
    $v = [$frm_data['value'], $frm_data['toggle_status']];

    if (update($q, $v, 'ii')) {
        echo json_encode(["status" => "success"]);
    } else {
        echo json_encode(["status" => "error"]);
    }
    exit;
}

if (isset($_POST['remove_user'])) {
    $frm_data = filteration($_POST); 


    $res = delete("DELETE FROM `user_cred` WHERE `id` = ? AND `is_verified`=?", [$frm_data['user_id'],0], 'ii');

    if ( $res) {
        echo json_encode(["success" => true]);
    } else {
        echo json_encode(["success" => false, "error" => "Failed to remove user"]);
    }
}


if (isset($_POST['search_user'])) {
    $frm_data= filteration($_POST);
    $query ="SELECT *FROM `user_cred` WHERE `name` LIKE ?";
    $res = select($query,["%$frm_data[name]%"],'s');
    $i = 1;

    $path = USERS_IMG_PATH;

    $data = "";
    while ($row = mysqli_fetch_assoc($res)) {

        $del_btn = "<button type='button'onclick ='remove_user($row[id])' class='btn btn-danger shadow-none btn-sm'>
                        <i class='bi bi-trash'></i>
                    </button>";
        $verified="<span class='badge bg-warning'><i class='bi bi-x-lg'></i></span>";
        if($row['is_verified']){
            $verified="<span class='badge bg-success'><i class='bi bi-check-lg'></i></span>";
            $del_btn ="";
        }

        $status=  "<button onclick ='toggle_status($row[id],0)' class ='btn btn-dark btn-sm shadow-none'>
            active
        </button>";

        if(!$row['status']){
            $status= "<button onclick ='toggle_status($row[id],1)' class ='btn btn-danger btn-sm shadow-none'>
                inactive
            </button>";
        }

        $date = date("d-m-Y", strtotime($row['datentime']));
        $data .= "
            <tr>
            <td>$i</td>
            <td>
                <img src='$path$row[profile]' width ='55px'>
                $row[name]
            </td>
            <td>$row[email]</td>
            <td>$row[phonenum]</td> 
            <td>$row[address] | $row[pincode]</td> 
            <td>$row[dob]</td>
            <td>$verified</td>
            <td>$status</td>
            <td>$date</td>
            <td>$del_btn</td>
            </tr>
        ";
        $i++;
    }

    echo $data;
}