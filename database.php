<?php 

$hostname = "localhost";
$username = "root";
$password = "";
$database = "web_final_project";


try{
    $conn = new mysqli($hostname, $username, $password, $database);
}
catch(mysqli_sql_exception){
    echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>Can't connect to the database!
				<button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
				</div>";
};


?>