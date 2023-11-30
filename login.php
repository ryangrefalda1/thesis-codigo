<?php
  session_start();
  require_once('functions.php');
  include('database.php');
  

 
  if($_SERVER["REQUEST_METHOD"] == "POST"){
    // sanitize raw inputs
    $user = sanitizeString('user');
    $user_password = sanitizeString('user_password'); 

    //if not null create session and new token and redirect
    if(!empty(verifyLogin($user,$user_password))){

    // create session
    $_SESSION['user'] = verifyLogin($user, $user_password);

    $userID = $_SESSION['user'];
    $token = bin2hex(random_bytes(16));

    // insert the new generated token
    $stmt = $conn->prepare("UPDATE admin_account SET activation_code = ? WHERE userID = ?");
    $stmt->bind_param("si", $token, $userID);
    $stmt->execute();
    $result = $stmt->affected_rows;

    // check if the row was successfully updated
    if($result > 0){
      header("Location: dashboard.php?userID=".$userID."&token=".$token);
    } else {
        echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>Something Went Wrong
        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
        </div>";
      
    }
   
    }
   
  }

?>

<!DOCTYPE html>
<html>
<head>
  <title>Codigo Admin</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="login.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&display=swap" rel="stylesheet">
</head>
<body style="background-image: url('img/BG.gif');">

<nav class="navbar navbar-default navbar-fixed-top">
            <a href="index.php">Home</a>
            <a href="about.php">About</a>
            <a class="navbar-logo">
                <img src="img/codigo-name.png" alt="Logo">
            </a>
            <a href="contact.php">Contact Us</a>
            <a href="login.php">Admin Login</a>
        </nav>
  <br>
  <br>
  <div class="container-fluid">
    <div class="codigo codigo-link">
      <img src="title.png" alt="Codigo" class="codigo-img">
      <form action="<?php htmlspecialchars($_SERVER["PHP_SELF"])?>" method="post">
        <input type="text" class="form-control" name="user" id="username"  placeholder="Username">
        <br>
        <input type="password" class="form-control" name="user_password" id="password"  placeholder="Password">
        <br>
        <a href="forgotpass.php" target="_self">Forgot Password?</a>
        <br>
        <br>
        <input type="submit" name="login" class="btn btn-success form-control" value="Login">
        <br>
        <br>
      </form>
      <div class="codigo-link">
      </div>
    </div>
  </div>
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