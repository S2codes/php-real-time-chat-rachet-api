<?php

include "../db/conn.php";
$DB = new Database_Queries;


// Function to check if a user with a given email already exists
function userExists($email, $DB)
{
    $count = $DB->CountRows("SELECT * FROM `users` WHERE `useremail` ='$email' ");
    return $count > 0;
}

// Function to register a new user
function registerUser($username, $email, $password, $DB)
{
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
    $result = $DB->Query("INSERT INTO `users` (`username`, `useremail`, `password`) VALUES ('$username', '$email', '$hashedPassword')");
    return $result;
}

// Check if the request is a POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Check if the user with the given email already exists
    if (userExists($email, $DB)) {
        $response = ['response' => false, 'message' => 'User with this email already exists'];
    } else {
        // Register the new user
        if (registerUser($username, $email, $password, $DB)) {
            $response = ['response' => true, 'message' => 'User registered successfully'];
        } else {
            $response = ['response' => false, 'message' => 'Error registering the user'];
        }
    }

    header('Content-Type: application/json');
    echo json_encode($response);
} else {
 
    echo "Unsupported request method";
}
