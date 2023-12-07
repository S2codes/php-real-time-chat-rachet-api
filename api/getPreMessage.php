<?php

include "../db/conn.php";
$DB = new Database_Queries;
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $userid = $_POST['userId'];
    $sendtoId = $_POST['reciverId'];

    $qry = "SELECT * FROM `messages` WHERE  (userid = '$userid' AND sendto = '$sendtoId') OR (userid = '$sendtoId' AND sendto = '$userid')";
    $data = $DB->RetriveArray($qry);

    $user = $DB->RetriveSingle("SELECT * FROM `users` WHERE `id` = $userid");
    $reciver = $DB->RetriveSingle("SELECT * FROM `users` WHERE `id` = $sendtoId ");

    $response = [
        'response' => true,
        'message' => 'Message Send Successfuly',
        'data' => $data,
        'sender' => $user['username'],
        'reciver' => $reciver['username']
    ];

    // Output JSON response
    header('Content-Type: application/json');
    echo json_encode($response);
    // echo json_encode($_POST['reciverId']);
} else {
    // Handle other types of requests if needed
    echo "Unsupported request method";
}
