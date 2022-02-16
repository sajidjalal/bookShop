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

            $sql = "SELECT * FROM users WHERE api_token='$api_token'";
            $resultset = mysqli_query($con, $sql) or die("database error:" . mysqli_error($con));
            $row = mysqli_fetch_assoc($resultset);

            session_start();
            $_SESSION['id'] = $row['id'];

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

if (isset($_POST['logoutFunction'])) {
    session_start();
    $sql = "UPDATE users SET api_token = '' where id = " . $_SESSION['id'];
    if ($con->query($sql) === TRUE) {
        $data['message'] = "success";
        $data['status'] = true;

        $data['message'] = "Logout Succefully";
        $data['status'] = true;
        $result = json_encode($data);
        print_r($result);
    } else {
        $data['message'] = "In-Valid Login Credentioal";
        $data['status'] = false;
        $result = json_encode($data);
        print_r($result);
    }
}


if (isset($_POST['fileFunction'])) {

    $time = time();
    $target_dir = "public/uploads/" . $time . "_";

    $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    $ext = pathinfo($target_file, PATHINFO_EXTENSION);

    $msg = "";
    // Allow certain file formats
    if ($imageFileType != "json") {
        $status = false;
        $msg .= "Sorry, only JSON files are allowed.";
        $uploadOk = 0;
    }


    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        $status = false;
        $msg .= "Sorry, your file was not uploaded.";
        // if everything is ok, try to upload file
    } else {

        if (!is_dir(dirname($target_file))) {
            mkdir(dirname($target_file), 0755, true);
        }

        // Read the JSON file 
        $json = file_get_contents($_FILES["fileToUpload"]["tmp_name"]);

        // Decode the JSON file
        $json_data = json_decode($json, true);

        // Display data
        if (empty($json_data) || is_null($json_data)) {
            $status = false;
            $msg .= "In valid JSON file content";
            $data['message'] = $msg;
            $data['status'] = $status;
            $result = json_encode($data);
            print_r($result);
            return;
        }

        $validateArrya = ['sale_id', 'customer_name', 'customer_mail', 'product_id', 'product_name', 'product_price', 'sale_date'];
        $count = 0;
        $new_ms = "";
        foreach ($json_data as $key => $value) {
            $getArray = array_keys($value);

            $value['product_name'] = str_replace("'", "''", $value['product_name']);

            foreach ($getArray as $key => $value_NEW) {
                if (!in_array($value_NEW, $validateArrya)) {
                    $status = false;
                    $msg = "In valid JSON file key";
                    $data['message'] = $msg;
                    $data['status'] = $status;
                    $result = json_encode($data);
                    print_r($result);
                    return;
                }
            }


            $sql = "INSERT INTO sales  (sale_id, product_id, customer_name, customer_mail, product_name, product_price, sale_date ) VALUES ('" . $value['sale_id'] . "', '" . $value['product_id'] . "', '" . $value['customer_name'] . "','" . $value['customer_mail'] . "','" . $value['product_name'] . "','" . $value['product_price'] . "','" . $value['sale_date'] . "')";

            // $sql = "INSERT INTO sales  (sale_id, product_id, customer_name, customer_mail, product_name, product_price, sale_date ) VALUES (' $value['sale_id'] ', ' $value['product_id'] ', ' $value['customer_name'] ',' $value['customer_mail'] ',' $value['product_name'] ',' $value['product_price'] ',' $value['sale_date'] ')";

            $new_ms .= " " . $value['sale_id'];
            try {
                $con->query($sql);
                $count++;
            } catch (\Throwable $th) {
                $status = false;
                $msg .= "In valid JSON file content";
                $data['message'] = $msg;
                $data['status'] = $status;
                $result = json_encode($data);
                print_r($result);
                return;
            }
        }

        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
            $status = true;
            $msg = "The file " . htmlspecialchars(basename($_FILES["fileToUpload"]["name"])) . " has been uploaded.";
        } else {
            $status = false;
            $msg .= "Sorry, there was an error uploading your file.";
        }
    }

    $data['message'] = $msg;
    $data['status'] = $status;
    $result = json_encode($data);
    print_r($result);
}


function generateRandomString($length = 10)
{
    // $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $characters = time() . '0123456789';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}
