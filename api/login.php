<?php

include "../db/conn.php";
$DB = new Database_Queries();

function validateLogin($email, $password, $DB)
{
    $sql = "SELECT * FROM `users` WHERE `useremail` = '$email'";
    $isUser = $DB->CountRows("SELECT * FROM `users` WHERE `useremail` = '$email'");
    if (!$isUser) {
        return ['response' => false, 'message' => 'Invalid email or password'];
    }
    $user = $DB->RetriveSingle($sql);
    if (password_verify($password, $user['password'])) {
        return ['response' => true, 'user' => array($user['username'], $user['useremail'], $user['id'])];
    } else {
        return ['response' => false, 'message' => 'Invalid email or password'];
    }
}

// Check if the request is a POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get user data from the request
    $email = $_POST['email'];
    $password = $_POST['password'];
    // Validate login credentials
    $result = validateLogin($email, $password, $DB);
    // Output JSON response
    header('Content-Type: application/json');
    echo json_encode($result);
} else {
    // Handle other types of requests if needed
    echo "Unsupported request method";
}
?>