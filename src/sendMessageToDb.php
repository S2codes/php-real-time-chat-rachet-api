<?php


function saveMessageToDatabase($message)
{
    $db = new Database_Queries();

    // Escape the message to prevent SQL injection
    $escapedMessage = $db->real_escape_string($message);

    // Prepare and execute the SQL query to insert the message into the 'messages' table
    $sql = "INSERT INTO `chats`(`userid`, `message`) VALUES ('1','$escapedMessage')";

    if ($db->Query($sql)) {
        echo "Message saved to database successfully\n";
    } else {
        echo "Error: Unable to save message to database\n";
    }
}

?>
