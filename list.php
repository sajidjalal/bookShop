<?php
session_start();

require_once "config.php";
$api_token = "<script>document.write(localStorage.getItem('api_token'));</script>";


$sql = "SELECT * from users as us WHERE  us.id = " . $_SESSION['id'];

$resultset = mysqli_query($con, $sql) or die("database error:" . mysqli_error($con));
$data = mysqli_fetch_assoc($resultset);


if (count($data) > 0) {

    if (is_null($data['api_token']) || empty($data['api_token'])) {
        header("location: 404.php?status_code=404&msg=unauthorized user");
    } else {
        require_once "header.php";
        require_once "listDetails.php";
        require_once "footer.php";
    }
} else {
    header("location: 404.php?status_code=404&msg=unauthorized user");
}
