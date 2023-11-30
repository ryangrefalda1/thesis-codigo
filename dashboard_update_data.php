<?php 

include ("database.php");
require_once("functions.php");

if($_SERVER['REQUEST_METHOD'] == "POST"){

    // fetch and sanitize
    $userID =  mysqli_real_escape_string ($conn, sanitizeString('userID')); 
    $currentHealth =  mysqli_real_escape_string ($conn, sanitizeString('currentHealth')); 
    $maxHealth =  mysqli_real_escape_string ($conn, sanitizeString('maxHealth')); 
    $secondCurrentHealth =  mysqli_real_escape_string ($conn, sanitizeString('secondCurrentHealth'));
    $secondMaxHealth =  mysqli_real_escape_string ($conn, sanitizeString('secondMaxHealth'));
    $heartshield =  mysqli_real_escape_string ($conn, sanitizeString('heartshield'));
    $currentRoom =  mysqli_real_escape_string ($conn, sanitizeString('currentRoom')); 
    $saveName =  mysqli_real_escape_string ($conn, sanitizeString('saveName')); 
    $entryID =  mysqli_real_escape_string ($conn, sanitizeString('entryId')); 
    

    // prepare and bind
    $stmt = $conn ->prepare("UPDATE user_saveprofiles SET saveProfileID = ? , mcCurrentHealth = ? , maxHealth = ? , secondCurrentMcHealth = ? , secondMaxHealth = ? , Heartshield = ?, currentRoom = ?, filename = ? WHERE entryID = ? ");
    $stmt ->bind_param("iiiiiissi", $userID, $currentHealth, $maxHealth,$secondCurrentHealth,$secondMaxHealth,$heartshield,$currentRoom,$saveName, $entryID);
   
    if( $stmt -> execute()) {
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