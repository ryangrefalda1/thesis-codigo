<?php
include("database.php");

$currentStatus  = "Suspended";
$getSaveProfiles = "SELECT * FROM user_saveprofiles WHERE current_status = '$currentStatus' ORDER BY timeUpdated DESC";
$getSaveProfilesQuery = mysqli_query($conn, $getSaveProfiles);

$saveProfiles = mysqli_fetch_all($getSaveProfilesQuery, MYSQLI_ASSOC);

header('Content-Type: application/json');
echo json_encode($saveProfiles);

mysqli_close( $conn );
?>
