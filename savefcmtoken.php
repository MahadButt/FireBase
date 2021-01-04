<?php

$servername = "localhost";
$username = "root";
$password = "";
$db_name = "test";

$conn = mysqli_connect($servername, $username, $password, $db_name);

if (!$conn) {
    die("Could not connect to the database: " . mysqli_connect_error());
} else {
    if (isset($_POST['token'])) {
        $sqlquery = "Insert Into fcmtoken(token) Values ('". $_POST['token']. "')";
        $result = mysqli_query($conn,$sqlquery);
        if ($result) {
            echo 'Token Inserted Successfully';
        } else {
            echo 'Unable to save token in db';
        }
    }
}