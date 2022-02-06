<?php

require_once "config.php";


if (isset($_POST['loginFunction'])) {

    $sql = "SELECT * FROM users AS us WHERE us.email = '" . $_POST['email'] . "' AND us.password = '" . $_POST['password'] . "' AND us.`status` = 'Y' AND deleted_at IS NULL";
    $result = $con->query($sql);

    if ($result->num_rows > 0) {
        $obj = $result->fetch_assoc();
        // $obj2 = (mysqli_fetch_array($result));

        $api_token = generateRandomString(25);
        $obj['api_token'] = $api_token;

        $sql = "UPDATE users SET api_token = '" . $api_token . "' where id = " . $obj['id'];
        if ($con->query($sql) === TRUE) {
            $data['message'] = "success";
            $data['object'] = $obj;
            $data['status'] = true;

            $result = json_encode($data);
            print_r($result);
        } else {
            $data['message'] = "In-Valid Login Credentioal";
            $data['status'] = false;
            $result = json_encode($data);
            print_r($result);
        }
    } else {
        $data['message'] = "In-Valid Login Credentioal";
        $data['status'] = false;
        $result = json_encode($data);
        print_r($result);
    }
}


function generateRandomString($length = 10)
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}
