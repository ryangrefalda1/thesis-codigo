<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="account_style.css">
    <script src="account_js.js"></script>
    <title>Account</title>
</head>
<body>


        <nav class="navbar navbar-default navbar-fixed-top">
            <a href="HomeIn.php">Home</a>
            <a href="aboutIn">About</a>
            <a class="navbar-logo">
                <img src="img/codigo-name.png" alt="Logo">
            </a>
            <a href="ContactIn.php">Contact</a>
            <a href="">Account</a>
        </nav>

    <div class="main-container">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 mb-4">
                    <div class="container-img">
                        <img id="logo-img" src="img/Codigo-name.png" alt="LOGO NAME" style="display: none;">
                    </div>
                    <h5 id="sub-header-name" style="display: none;">A Pixel Game to Teach Python Programming Fundamentals</h5>
                
                </div>
            </div>
        </div>
    </div>

    <div class="container mt-5">
    <div class="row justify-content-center">
      <div class="col-md-6">

        <div class="card">
          <div class="card-header">
            <h5 class="mb-0">Edit Profile</h5>
          </div>
          <div class="card-body">

            <form action="edit-profile.php" method="POST">
              <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" class="form-control" id="name" name="name" value="John Doe" required>
              </div>

              <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" class="form-control" id="email" name="email" value="john@example.com" required>
              </div>

              <div class="form-group">
                <label for="bio">Bio:</label>
                <textarea class="form-control" id="bio" name="bio" rows="4" required>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</textarea>
              </div>

              <div class="text-center">
                <a href="Account.php"><button type="submit" class="btn btn-primary">Save Changes</button>
              </div>
            </form>

          </div>
        </div>

      </div>
    </div>
  </div>

    <br><br><br><br><br><br>

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