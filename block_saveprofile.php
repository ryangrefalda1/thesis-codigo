<?php 
include("database.php");
require_once("functions.php");


if($_SERVER['REQUEST_METHOD'] == "POST"){
    $currentStatus  = "Blocked";
    $entryId = mysqli_real_escape_string($conn, sanitizeString('entryId'));

    $stmt = $conn->prepare('UPDATE user_saveprofiles SET current_status = ? WHERE entryID = ?');
    $stmt->bind_param('si', $currentStatus, $entryId);

    if($stmt->execute()){
        $result = $stmt->affected_rows;

        if($result > 0){
            echo "Successful";
            $stmt->close();
        } else {
            echo "Unsuccessful";
            $stmt->close();
        }

    } else {
        echo "Error Executing Query";
        $stmt->close();
    }

}

?>