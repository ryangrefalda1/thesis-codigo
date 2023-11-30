<?php 

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;


// Function that sanitizes the raw input post
function sanitizeEmail(String $key){
    $email = filter_input(INPUT_POST, $key, FILTER_SANITIZE_EMAIL);
    return $email;
};

function sanitizeString(String $key){
    $str = filter_input(INPUT_POST, $key ,FILTER_SANITIZE_SPECIAL_CHARS);
    return $str;
}

// Function that sanitizes the raw input get
function sanitizeEmailGet(String $key){
    $email = filter_input(INPUT_GET, $key, FILTER_SANITIZE_EMAIL);
    return $email;
};

function sanitizeStringGet(String $key){
    $str = filter_input(INPUT_GET, $key ,FILTER_SANITIZE_SPECIAL_CHARS);
    return $str;
}



// Function that inserts the sanitized comment in the database
function insertCommentToDatabase(String $name, String $email, String $message){
    include('database.php');

    // prepare and bind
    $stmt = $conn ->prepare("INSERT INTO user_comments (name, email, message) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $name, $email, $message);
    
    // execute and check 
    if ( $stmt->execute() ){
         // close after using
        $stmt->close();
        mysqli_close($conn);
        return true;
    } else {
         // close after using
        $stmt->close();
        mysqli_close($conn);
        return false;
    }

}


// Function that returns the encrypted version of the string provided
function hashPassword(String $str){
    $str = password_hash($str, PASSWORD_DEFAULT);
    return $str;
}


// Function that returns the User ID if the login was verified otherwise null.
function verifyLogin(String $user, String $user_password){
    
    include('database.php');

    $username = mysqli_real_escape_string($conn, $user);
    $password = mysqli_real_escape_string($conn, $user_password);

    // prepare and bind
    $stmt = $conn->prepare("SELECT * FROM admin_account WHERE username = ? AND activation_status = 'activated'");
    $stmt->bind_param("s", $username);
    
    if($stmt->execute()){

        // fetch pass
        $result = $stmt->get_result();

        // check if any rows are returned
        if (mysqli_num_rows($result)> 0) {
            
            // convert the result into an associative array
            $row = mysqli_fetch_assoc($result);

            if (!strcmp($username , $row['username'])){

            // check if the password is the same as the hashed password in the database
            if(password_verify($password, $row['password'])){

                // create a query to fetch the userID of the valid account 
                $stmt = $conn->prepare("SELECT userID FROM admin_account WHERE username = ? AND activation_status = 'activated'");
                $stmt->bind_param("s", $username);
                $stmt->execute();
                $result = $stmt->get_result();
                
                // check if any rows are returned
                if (mysqli_num_rows($result)> 0) {
                    $row = mysqli_fetch_assoc($result);
                    $uid = $row['userID'];
                    
                    // close 
                    $stmt->close();
                    mysqli_close($conn);
                    return $uid;
                } else {
                    $stmt->close();
                    mysqli_close($conn);
                    return null; // Handle non-existent userID
                }
            } else {
                echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                Incorrect Password
                <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                </div>";

                $stmt->close();
                mysqli_close($conn);
                return null;
            }


            } else {
                echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                Username should be the same with the one you registered!
                <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                </div>";
    
                $stmt->close();
                mysqli_close($conn);
                return null;
            }
        
          
        }
         else {
            echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
            Nonexistent Username!
            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
            </div>";

            $stmt->close();
            mysqli_close($conn);
            return null;
        }
    }  else {
        echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
        Error executing statement
        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
        </div>";

        mysqli_close($conn);

        return null;
    }
}


// Function that send reset password notification in gmail
function sendPasswordReset($get_email, $token)
{
    //Load Composer's autoloader
    require 'vendor/autoload.php';

    $mail = new PHPMailer(true);                   //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP

    $mail->Host       = "smtp.gmail.com";                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication

    $mail->Username   = "codigoproduction@gmail.com";                     //SMTP username
    $mail->Password   = "dwmdkasbmqatguwj";                               //SMTP password

    $mail->SMTPSecure = "tls";            //Enable implicit TLS encryption
    $mail->Port       = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    //Recipients
    $mail->setFrom('codigoproduction@gmail.com');
    $mail->FromName = 'Codigo';
    $mail->addAddress($get_email);

    $mail->isHTML(true);
    $mail->Subject = "Reset Password Notification";

    $email_template = "
        <h2>Hello</h2>
        <h3>Here's your password reset link</h3>
        <br><br>
        <h2><a href ='http://localhost/Thesis/final/passwordchange.php?token=$token&email=$get_email'>Click Here</a></h2>
    ";

    $mail->Body = $email_template;
    $mail->send();
}

// Function that verifies the userID and token returns true otherwise false
function verifyTokenAnduserID($userID,$token){
    include('database.php');

    $email = mysqli_real_escape_string($conn, $userID);
    $token = mysqli_real_escape_string($conn, $token);

    // check first if the parameter is the same in the database
    $stmt = $conn ->prepare('SELECT * FROM admin_account WHERE activation_code = ? AND userID = ?');
    $stmt -> bind_param('si', $token, $userID);

    if($stmt->execute()){

        $result = $stmt->get_result();

        if(mysqli_num_rows($result) > 0){
            $stmt->close();
            mysqli_close($conn);
            return true;   

        } else {
            $stmt->close();
            mysqli_close($conn);
            return false;
        }
          
    } else {

        $stmt->close();
        mysqli_close($conn);
        return false;
    }

}


// Function that verifies the token from the website is the same as the one in database
function verifyTokenAndEmail($email,$token){
    include('database.php');

    $email = mysqli_real_escape_string($conn, $email);
    $token = mysqli_real_escape_string($conn, $token);

    // check first if the parameter is the same in the database
    $stmt = $conn ->prepare('SELECT * FROM admin_account WHERE activation_code = ? AND email = ?');
    $stmt -> bind_param('ss', $token, $email);

    if($stmt->execute()){

        $result = $stmt->get_result();

        if(mysqli_num_rows($result) > 0){
            $stmt->close();
            mysqli_close($conn);
            return true;   

        } else {
            $stmt->close();
            mysqli_close($conn);
            return false;
        }
          
    } else {

        $stmt->close();
        mysqli_close($conn);
        return false;
    }

}


// Function to insert updated password
function insertUpdatedPassword(String $email, String $hash, String $token){
    include('database.php');
  
    $stmt = $conn->prepare('UPDATE admin_account SET password = ? WHERE email = ? AND activation_code = ?');
    $stmt->bind_param("sss", $hash, $email, $token);
    
    if($stmt->execute()){

        $result = $stmt->affected_rows; 
        if($result > 0){
            echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
                Password has been updated! <a href='login.php'>Go back to login</a>
                <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                </div>";
                $stmt->close();
                mysqli_close($conn);

        } else {
            echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                Cannot change your password at the moment.
                <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                </div>";
                $stmt->close();
                mysqli_close($conn);
        }   

    } else {
        echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                Failed to execute query
                <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                </div>";

        $stmt->close();
        mysqli_close($conn);
    }




}


// Function that sends the otp using php mailer
function sendOTP(int $otp, String $email){
    require 'vendor/autoload.php';
    
    $mail = new PHPMailer(true);
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'codigoproduction@gmail.com';
    $mail->Password = 'dwmdkasbmqatguwj';
    $mail->SMTPSecure = 'tls';
    $mail->SMTPDebug = 2;
    $mail->Port = 587;
    $mail->FromName = 'Codigo';
    $mail->AddAddress($email);	
    $mail->isHTML(true); 
    $mail->Subject = 'OTP Verification';
    $mail->Body    = '<p>Here is your OTP '.$otp.'<p>';
        
    if($mail->Send()){
        return true;
    }
    else{
        $message = $mail->ErrorInfo;

        echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
        .$message.
        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
        </div>";
        return false;
    }
}









?>