<?php
include("database.php");

if (isset($_GET["limit"])) {

$limit = intval($_GET["limit"]);

$getComments = "SELECT * FROM user_comments ORDER BY comment_time DESC LIMIT $limit";
$getCommentsQuery = mysqli_query($conn, $getComments);

$comments = mysqli_fetch_all($getCommentsQuery, MYSQLI_ASSOC);



header('Content-Type: application/json');
echo json_encode($comments);

}

?>
