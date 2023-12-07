<?php

include "../db/conn.php";
$DB = new Database_Queries;
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $userId = $_POST['userId'];
    $username = $_POST['userName'];
    $message = $_POST['message'];
    $reciverId = $_POST['reciverId'];
    $sql = "INSERT INTO `messages`(`userid`, `message`, `sendto`) VALUES ('$userId','$message','$reciverId')";
    if ($DB->Query($sql)) {
        $response = ['response' => true, 'message' => 'Message Send Successfuly'];
    } else {
        $response = ['response' => false, 'message' => 'Something went wrong'];
    }

    // Output JSON response
    header('Content-Type: application/json');
    echo json_encode($response);
    // echo json_encode($_POST['reciverId']);
} else {
    // Handle other types of requests if needed
    echo "Unsupported request method";
}
