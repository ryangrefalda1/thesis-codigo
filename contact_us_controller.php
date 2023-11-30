<?php

include('database.php');
require_once("functions.php");

if ($_SERVER['REQUEST_METHOD'] == "POST") {

    // fetch and sanitize
    $name = sanitizeString("name");
    $email = sanitizeEmail("email");
    $message = sanitizeString("message");

    // prepare the raw value for binding
    $name = mysqli_real_escape_string($conn, $name);
    $email = mysqli_real_escape_string($conn, $email);
    $message = mysqli_real_escape_string($conn, $message);

   if(insertCommentToDatabase($name, $email, $message)) {
        echo "Successful";
   } else{
        echo "Error Inserting Comment in Database";

    }
}
?>