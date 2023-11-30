<?php 


include 'database.php';
require_once ('functions.php');

// check if the token and email is existent
if(isset($_GET['token']) && $_GET['email']) {

   // assign and sanitize the value if existent
    $email = sanitizeEmailGet('email');
    $token = sanitizeStringGet('token');


        //check if the token and email is valid 
        if(verifyTokenAndEmail($email, $token)){
            
            // condition once the form was submitted
            if ($_SERVER["REQUEST_METHOD"] == "POST") {

                  // First Step: Check if the input fields are empty
                  if(!empty($_POST['email']) && !empty($_POST['newPass'])&& !empty($_POST['confirmPass'])) {

                    // Second Step: Sanitize the input and prepare them for insertion
                    $email = mysqli_real_escape_string($conn, sanitizeEmail('email'));
                    $new_pass = mysqli_real_escape_string($conn, sanitizeString('newPass'));
                    $confirm_pass = mysqli_real_escape_string($conn, sanitizeString('confirmPass'));
                    
                    // Third Step: Check if the password is the same
                    if(!strcmp($new_pass, $confirm_pass)) {

                        // Last Step: Check if the password is 8 characters atleast
                        if(strlen(trim($new_pass)) >= 8) {
                            // hash and insert to the database
                            $hash = hashPassword($new_pass);
                            insertUpdatedPassword($email, $hash, $token);
                        } else {
                            echo "<div class= 'alert alert-danger alert-dismissible fade show' role='alert'>
                            Password should be 8 characters atleast
                            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                            </div>"; 
                        }
                     

                    }else {
                    
                        echo "<div class= 'alert alert-danger alert-dismissible fade show' role='alert'>
                        Both passwords should be the same!
                        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                        </div>";  
                    }
                
                  } else {
                      echo "<div class= 'alert alert-danger alert-dismissible fade show' role='alert'>
                       Fill out the empty field!
                      <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                      </div>";
                  }
              
            }
        
        } else {
             $showModal = true;
        }
        
}else {
    $showModal = true;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Codigo Forgot Password</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="passwordchange.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&display=swap" rel="stylesheet">
</head>
<body>
    <br>
    <br>
    <br>
    <br>
    <div class="main-container">
        <div class="codigo"> 
            <form id = "update_pass_form" action="<?php htmlspecialchars($_SERVER["PHP_SELF"])?>" method="post">
            <div class="codigo-link">
                <h3>Password Reset</h3>
                <hr>
                <label for="email"><b>Email Address</b></label>
                <br>
                <input type="email" class="form-control" placeholder="Re-enter your email address" name="email" id="email" value ="<?php if (isset($_GET['email'])){echo $_GET['email']; } ?> ">
                <br>
                <label for="email"><b>Enter Your New Password</b></label>
                <br>
                <input type="password" class="form-control" placeholder="Enter your new password" name="newPass" id="new-pass">
                <br>
                <label for="email"><b>Confirm Password</b></label>
                <br>
                <input type="password" class="form-control" placeholder="Re-enter your new password" name="confirmPass" id="confirm-new-pass">
                <hr>
                <input type="button" name="update_password" value="Update Password" id="submitBtn" data-bs-toggle="modal" data-bs-target="#confirmUpdatePassword" class="btn btn-success" />
            </div>
            </form>
        </div>
    </div>
    <br>
    
    
<!-- MODAL for invalid access -->
<div class="modal fade" id="myModal"data-bs-backdrop="static" data-bs-keyboard="false"  datatabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Invalid Access</h5>
            </div>
           
            <!-- Modal Footer -->
            <div class="modal-footer">
                <a class="btn btn-primary" href="login.php" role="button">Go back to login</a>
            </div>
        </div>
    </div>
</div>


<!-- confirmation modal-->
<div class="modal fade" id="confirmUpdatePassword" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Confirmation</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        Are you sure you want to update your password?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
        <button type="button" class="btn btn-primary" onclick ="submitForm()">Yes</button>
      </div>
    </div>
  </div>
</div>



<script>
    function submitForm() {
        $('#update_pass_form').submit();
    }
</script>

</body>

<?php			
	if(!empty($showModal)) {
		// Illegal Access Modal
		echo '<script type="text/javascript">
			$(document).ready(function(){
				$("#myModal").modal("show");
			});
		    </script>';
	} 
?>
  
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

</html>