<?php 
include 'database.php';
require_once('functions.php');


// check if the token and email is existent
if(isset($_GET['token'], $_GET['email'])){
    $token = sanitizeStringGet('token');
    $email = sanitizeEmailGet('email');

    // check if the token and email is valid
    if(verifyTokenAndEmail($email, $token)){

        // main
        if($_SERVER["REQUEST_METHOD"] == "POST"){
            
            $otp = mysqli_real_escape_string($conn,sanitizeString('otp'));

            // prepare to select the value in the database base on the otp provided
            $stmt = $conn->prepare("SELECT * FROM admin_account WHERE activation_code = ?");
            $stmt ->bind_param("i",$otp);

            // check if the query has been executed
            if($stmt -> execute()){

                $result = $stmt ->get_result();
                
                // check if the query got result
                if(mysqli_num_rows($result) > 0){

                    $row = mysqli_fetch_assoc($result);
                    $otpRow = $row['OTP'];
                    $signUptimeRow = $rowSelect['signupTime'];
                    
                    // create a 1 minute time limit
                    $signUptimeRow = date('d-m-Y h:i:s', strtotime($signUptimeRow));
                    $signUptimeRow = date_create($signUptimeRow);
                    date_modify($signUptimeRow, "+1 minutes");
                    $timeUp = date_format($signUptimeRow, 'd-m-Y h:i:s');


                    // check if the otp is correct
                    if(!strcmp($otp,$otpRow)){

                        // check if the code was entered past 1 minute
                        if (!(date('d-m-Y h:i:s') >= $timeUp)){

                            $str = "activated";

                            $stmt = $conn->prepare('UPDATE admin_account set activation_status = ? WHERE otp = ? ');
                            $stmt ->bind_param("si", $str , $otp);
                            $stmt ->execute();
                            $result = $stmt->affected_rows;

                            if($result > 0){
                                echo "<div class='alert alert-success alert-dismissible fade show' role='alert'> Register Successful!
                                <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                                </div>";
                                $stmt->close();
                                header("Refresh:1, url=login.php");
                            } else {
                                $stmt->close();
                                echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'> Register Failed!
                                <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                                </div>";
                                header("Refresh:1, url=register.php");
                            }
                           
                        } else {
                            echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>Time is up, try again
                            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                            </div>";
                            $stmt->close();
                            header("Refresh:1, url=register.php");

                        }

                    } else {
                        echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'> Please enter correct OTP code
                        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                        </div>"; 
                        $stmt->close();
                    }


                } else {
                    echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>Failed to fetch items from the database!
                    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                    </div>";
                    $stmt->close();
                }             

            } else {
                echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>There was a problem executing the query!
                <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                </div>";
                $stmt->close();
            }
            
        } 

    } else {
        $showModal = true;
       
    }

} else {
    $showModal = true;
  
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Codigo Register Verify</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="otpregister.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&display=swap" rel="stylesheet">
</head>
<body>
    <br>
    <br>
    <br>
    <br>
    <div class="wrapper">
    <div class="container-fluid">
        <div class="codigo"> 
            <form action="" method="post">
            <div class="codigo-link">
                <hr>
                <label for="otp"><b>Please enter the code you received to verify your account.</b></label>
                <br>
                <br>
                <input type="text" class="form-control" placeholder="Enter OTP Code" name="otp" id="otp" maxlength="6" required>
                <hr>
                <button type="cancel" class="btn btn-success" onclick=" document.location.href='register.php';">Cancel</button>
                <button type="submit" name="verify" class="btn btn-success">Verify</button>
            </div>
            </form>
        </div>
    </div>
</div>


    
<!-- MODAL for invalid access -->
<div class="modal fade" id="invalidAccessModal" data-bs-backdrop="static" data-bs-keyboard="false" data datatabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Invalid Access</h5>
            </div>
            <div class="modal-body">
                 You should register first!
            </div>
            <!-- Modal Footer -->
            <div class="modal-footer">
                <a class="btn btn-primary" href="register.php" role="button">Ok</a>
            </div>
        </div>
    </div>
</div>


<?php			
	if(!empty($showModal)) {
		// Illegal Access Modal
		echo '<script type="text/javascript">
			$(document).ready(function(){
				$("#invalidAccessModal").modal("show");
			});
		    </script>';
	} 
?>
    <br>
    <br>
    <br>
    <br>
    <footer class="footer">
        <h2 class="footer-title">Codigo</h2>
        <div class="footer-links">
        <a>Privacy Policy</a>
        <a>Terms of Service</a>
        <a>About</a>
        <a>Support</a>
        </div>
        <p class="all-rights">© 2023 Codigo. All rights reserved.</p>
    </footer> 
</body>
</html>