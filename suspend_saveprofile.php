<?php 

include("database.php");
require_once("functions.php");

if($_SERVER['REQUEST_METHOD'] == "POST"){
    $entryID = sanitizeString('entryId');
    $status = "Suspended";

    $stmt = $conn->prepare('UPDATE user_saveprofiles SET current_status = ? WHERE entryID = ?');
    $stmt->bind_param("si", $status, $entryID);

    if($stmt->execute()){
        $result = $stmt->affected_rows;

        if($result > 0){
           
            echo "Successful";
            $stmt->close();
        } else {
            echo "Error";
            $stmt->close();
        }


    } else {
       
        echo "Error Executing Query";
        $stmt->close();
    }

}


?>