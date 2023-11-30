<?php

include 'database.php';
require_once('functions.php');

if ($_SERVER['REQUEST_METHOD'] == "POST") {

    $email = mysqli_real_escape_string($conn, sanitizeEmail("email"));
    $token = bin2hex(random_bytes(16));

    $stmt = $conn->prepare("SELECT * FROM admin_account WHERE email = ? LIMIT 1");
    $stmt->bind_param("s", $email);

    if($stmt->execute()) {

        $result = $stmt->get_result();

        if(mysqli_num_rows($result) > 0) {

            // convert result into assoc array
            $row = mysqli_fetch_assoc($result);

            // get email
            $databaseEmail = $row["email"];

            // prepare and bind
            $stmt = $conn->prepare("UPDATE admin_account SET activation_code = ? WHERE email = ? LIMIT 1");
            $stmt->bind_param("ss", $token , $email);

            if($stmt->execute()) {

                sendPasswordReset($databaseEmail,$token);

                echo "<div class= 'alert alert-success alert-dismissible fade show' role='alert'>
                We sent you an email.
                <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                </div>";
                
                $stmt->close();
                mysqli_close($conn);
            } else {

                echo "<div class= 'alert alert-danger alert-dismissible fade show' role='alert'>
                Something Went Wrong!
                <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                </div>";

                $stmt->close();
                mysqli_close($conn);
            }

        } else {
            echo "<div class= 'alert alert-danger alert-dismissible fade show' role='alert'>
            Email does not exist!
            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
            </div>";

            $stmt->close();
            mysqli_close($conn);
        }

    } else {
        echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
        Error executing statement
        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
        </div>";

        $stmt->close();
        mysqli_close($conn);
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Codigo Forgot Password</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="forgotpass.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&display=swap" rel="stylesheet">
</head>
<nav class="navbar navbar-default navbar-fixed-top">
            <a href="index.php">Home</a>
            <a href="about.php">About</a>
            <a class="navbar-logo">
                <img src="img/codigo-name.png" alt="Logo">
            </a>
            <a href="contact.php">Contact Us</a>
            <a href="login.php">Admin Login</a>
        </nav>

<body>
    <div class="main-container">
        <div class="codigo">
            <form action="<?php htmlspecialchars($_SERVER['PHP_SELF']);?>" method="post">
                <div class="codigo-link">
                    <h3>Forgot your password</h3>
                    <hr>
                    <label for="email"><b>Please enter the email address associated to the existing admin account to reset password.</b></label>
                    <br>
                    <input type="email" class="form-control" placeholder="Enter Email" name="email" id="email" required>
                    <hr>
                    <button type="cancel" class="btn btn-success" onclick="document.location.href='login.php';">Cancel</button>
                    <button type="submit" name="resetPass" class="btn btn-success">Send</button>
                </div>
            </form>
        </div>
    </div>
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