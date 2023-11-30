<?php 
	require_once('functions.php');
	include 'database.php';

	// initialize otp and activation code
	$otp_value = rand(000000, 999999);
	$activation_code = bin2hex(random_bytes(16));
	
	if($_SERVER['REQUEST_METHOD'] == "POST"){

		$otp = $otp_value;
		$act_code = mysqli_real_escape_string($conn, sanitizeString('activation_code'));
		$name = mysqli_real_escape_string($conn, sanitizeString('uname'));
		$email =  mysqli_real_escape_string($conn, sanitizeString('email'));
		$password = mysqli_real_escape_string($conn, sanitizeString('psw'));
		$confirm_pass = mysqli_real_escape_string($conn, sanitizeString('psw-confirmation'));

		// check if the password are the same
		if (strcmp($password, $confirm_pass)){
			echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>Password do not match
			<button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
			</div>";

		// check if the password is 8 character atleast	
		} elseif(strlen(trim($password)) >= 8){
			echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>Characters must be atleast 8
			<button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
			</div>";
		}

		else{
		
		// hash the password
		$hash = hashPassword($password);
		
		// prepare to get the email from the database
		$stmt = $conn->prepare('SELECT * FROM admin_account WHERE email =?');
		$stmt -> bind_param('s', $email);
		$stmt -> execute();
		$result = $stmt->get_result();
		

		// this condition will check if the user is already
		if(mysqli_num_rows($result) > 0){
			
			$row  = mysqli_fetch_array($result);
			
			$status = $row['activation_status'];
			
			// throw this if the email is already registered and activated
			if ($status == 'activated'){
				echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>Email already activated
				<button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
				</div>";

				// close the connection
				$stmt->close();
				mysqli_close($conn);
			}

			// else send the user an otp
			else{

				// prepare to update
				$stmt = $conn->prepare("UPDATE admin_account SET name = ?, password = ?, OTP = ?, activation_code = ?");
				$stmt -> bind_param("ssis", $name, $hash, $otp, $activation_code);
				$stmt ->execute();
				$result = $stmt->affected_rows;
				
				if($result > 0){
					
					// if successful in sending email proceed to the otp page
					if(sendOTP($otp,$email)){

						// close the connection
						$stmt->close();
						mysqli_close($conn);

						header("Location: otpregister.php?token=".$activation_code."&email=".$email);
					}
				}

			}
		}
	
		else{

			if(sendOTP($otp,$email)){

				// prepare to insert
				$stmt = $conn -> prepare("INSERT INTO admin_account (username, email, password, otp, activation_code) VALUES (?, ?, ?, ?, ?)");
				$stmt -> bind_param("sssis", $name, $email, $hash,$otp, $activation_code);
				$stmt -> execute();
				$result = $stmt->affected_rows;

				if($result > 0){
					
					// close the connection
					$stmt->close();
					mysqli_close($conn);
					header("Location: otpregister.php?token=".$activation_code."&email=".$email);
				} else {
					echo "<script>Insertion of data failed</script>";
				}
			}

		}
	}
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Codigo Admin Registration</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
	<script src="https://kit.fontawesome.com/b52e60601c.js" crossorigin="anonymous"></script>
	<link rel="stylesheet" href="register.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&display=swap" rel="stylesheet">
</head>
<body>
    <br>
    <br>

<!--Create Account-->
	<div class ="main-container">
    <div class="container-fluid">
        <div class="codigo codigo-link"> 
            <form id="register_form"action="<?php htmlspecialchars($_SERVER['PHP_SELF'])?>" method="post">
			<input type="hidden" name="activation_code" value="<?php echo $activation_code; ?>"> 
			<div class="codigo-link">
                <h3>Create Admin Account</h3>
                <p>Please fill in this form to create an account.</p>
                <hr>
                <label for="email"><b>Email:</b></label>
                <input type="text" class="form-control" placeholder="Enter Email" name="email" id="email" required>
                <br>
                <label for="uname"><b>Create Your Username:</b></label>
                <input type="text" class="form-control" placeholder="Enter Username" name="uname" id="uname" required>
                <br>
                <label for="psw"><b>Password:</b></label>
                <input type="password" class="form-control" placeholder="Enter Password" name="psw" id="psw" required>
                <br>
                <label for="psw-confirmation"><b>Re-enter Password:</b></label>
                <input type="password" class="form-control" placeholder="Confirm Password" name="psw-confirmation" id="psw-confirmation" required>
                <br>
                <input type="button" name="register" value ="Register" id="submitBtn" data-bs-toggle="modal" data-bs-target="#confirmRegister" class="btn btn-success form-control">
            </div>
            <div class="codigo-link">
                <p>Already have an account? <a href="login.php">Sign in</a>.</p>
            </div>
            </form>
        </div>
    </div>
</div>

<!-- confirmation modal-->
<div class="modal fade" id="confirmRegister" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="myModalLabel">Confirmation</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        Are you sure you want to submit the following?
		
		<table class="table table-striped">
		<br>
		<br>
                    <tr>
                        <th>Email:</th>
                        <td id="Email"></td>
                    </tr>
                    <tr>
                        <th>Username:</th>
                        <td id="Username"></td>
                    </tr>
					<tr>
                        <th>Password:</th>
                        <td>
						<input type="password" id="Password" readonly>
                                <button class="btn btn-outline-secondary" type="button" id="togglePasswordBtn"
                                    onclick="togglePasswordVisibility()">
									<i class="fa-regular fa-eye fa-sm"></i> <!-- You can use an eye icon or any other icon -->
						</td>
                    </tr>
        </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
        <button type="button" class="btn btn-primary" onclick ="submitForm()">Yes</button>
      </div>
    </div>
  </div>
</div>



<script>
	$('#submitBtn').click(function() {
     /* when the button in the form, display the entered values in the modal */
     $('#Email').text($('#email').val());
     $('#Username').text($('#uname').val());
	 $('#Password').val($('#psw').val()); // Set the value attribute for password input
});

	function togglePasswordVisibility() {
        var passwordInput = $('#Password');
        var toggleButton = $('#togglePasswordBtn');

        if (passwordInput.attr('type') === 'password') {
            passwordInput.attr('type', 'text');
            toggleButton.html('<i class="fa-solid fa-eye fa-sm"></i>'); // Change to a slash icon or any other icon
        } else {
            passwordInput.attr('type', 'password');
            toggleButton.html('<i class="fa-regular fa-eye fa-sm"></i>'); // Change to an eye icon or any other icon
        }
    }

    function submitForm() {
        $('#register_form').submit();
    }
</script>

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