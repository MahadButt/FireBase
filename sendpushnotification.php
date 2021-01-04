<?php

$servername = "localhost";
$username = "root";
$password = "";
$db_name = "test";

$conn = mysqli_connect($servername, $username, $password, $db_name);

if (!$conn) {
    die("Could not connect to the database: " . mysqli_connect_error());
} else {
//    if (isset($_POST['token'])) {
    $sqlquery = "Select * from fcmtoken";
    $result = mysqli_query($conn, $sqlquery);
    while ($row = mysqli_fetch_array($result)) {
        $fcmtoken[] = $row['token'];
    }
#API access key from Google API's Console
    $serverKey = 'AAAACQ-R544:APA91bEh2miV5NjFtajpeBMW3MDyY9XwF7bScBlWTijKbDwaPSuq8FkvdS38ifmuOYCNQM0e0TpH1yDM4l4TCPEo9ecNDqhrC0utsn1iNPwleTMQb6toC2Ckx_I2Hnu_BofEMj9kD3sz';

    define('Server_KEY', $serverKey);
    //        $fcmtoken = 'ePHjg9UgqZQ8iX5Btxtp--:APA91bFRH-GCS5rX-A3s0LlsGdJXgOYN_DMUuuv5XxmWhkyUOPKAP3LI8orIfYBLxazuWSwnmVk83qHRGUdn2nQPLS4P7QlFyyMQ962DElvH57EFEq-kDdMEuhYAXNxBOj_od3ula3di';
    $msg = array(
        'title' => 'Testing Notification',
        'body' => 'Push Notification With FireBase',
        'icon' => "firebase-logo.png",
        'click_action' => 'https://localhost.com/MyProjects/firebase(FCMToken)/'
    );
    $push_payload = array(
//      1)  to – Type String – (Optional) [Recipient of the message
//      2)  registration_ids – Type String array – (Optional) [Recipients of the message]
//        Multiple registration tokens, min 1 max 1000.
//         'to' => $fcmtoken,
        'registration_ids' => $fcmtoken,
        'priority' => 'high',
        'data' => $msg
    );
    $headers = array
        (
        'Authorization: key=' . Server_KEY,
        'Content-Type: application/json'
    );
    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => "https://fcm.googleapis.com/fcm/send",
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POSTFIELDS => json_encode($push_payload),
        CURLOPT_HTTPHEADER => $headers
    ));

    $response = curl_exec($curl);
    if (curl_error($curl)) {
        echo 'Error:' . curl_error($curl);
    } else {
        echo $response;
    }
    curl_close($curl);
}


