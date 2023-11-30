<?php
include("database.php");

$getComments = "SELECT * FROM user_comments ORDER BY comment_time DESC LIMIT 5";
$getCommentsQuery = mysqli_query($conn, $getComments);

$comments = mysqli_fetch_all($getCommentsQuery, MYSQLI_ASSOC);

header('Content-Type: application/json');
echo json_encode($comments);

mysqli_close( $conn );
?>
