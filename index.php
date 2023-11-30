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
    <link rel="stylesheet" href="index.css">
    <script src="home_js.js"></script>
    <title>Home</title>
</head>
<body>


        <nav class="navbar navbar-default navbar-fixed-top">
            <a href ="index.php">Home</a>
            <a href ="about.php" >About</a>
            <a class="navbar-logo">
                <img src="img/codigo-name.png" alt="Logo">
            </a>
            <a href ="Contact.php" >Contact Us</a>
            <a href ="login.php">Admin Login</a>
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
            <div class = "container-download">
                <a href="https://www.dropbox.com/scl/fi/0ejie1u5xk27t2qqqb2jz/Codigo.exe?rlkey=6kpvjy8gw6q8r93ew8v8daiwx&dl=1" class="btn btn-lg btn-success"><h1 class = "download-button-h1"> Download Now</h1></a>
            </div>


        </div>
    </div>

    <div class="container">
        <div class="row align-items-center">
            <div class="col-6 col-md-3 mb-4">
                <img src="img/snake.png" alt="snake" class="snake-icon">
            </div>
                <div class="col-6 col-md-9 mb-4">
                <h1 id="headline" style="display: none;">What will you Expect:</h1>
                <p class="headline-subheader" style="display: none;">
                    "Codigo" is an immersive pixel game that combines the 
                    captivating world of programming with the addictive gameplay of classic arcade 
                    adventures. Your mission is to explore the intricate circuits of a vast virtual 
                    world, brimming with challenges and secrets waiting to be unveiled.Immerse yourself 
                    in the mesmerizing world of "Codigo" and unravel thesecrets of the digital realm as 
                    you harness the power of Python programming to overcome challenges, save the virtual 
                    world, and become the ultimate coder-hero. But beware, as you delve deeper into the 
                    virtual realm, you'll encounter formidable enemies and treacherous traps designed to 
                    test your skills to their limits.
                </p>
            </div>
            <div class="col-md-3 mb-4">
                <img src="img/Forestv2.png" alt="image" class="third-image">
            </div>
        </div> 
    </div>

    <div class="container new-container">
        <div class="row align-items-center">
            <div class="col-12 mb-4">
                <h1 class="headline-2">LEARN, CODE AND ENJOY!</h1>
            </div>
            <div class="col-12 col-md-4 mb-4">
                <div class="box">
                <p class="box-number">LEARN</p>
                <h2 class="box-title">LEARN BASIC PYTHON FUNDAMENTALS WHILE PLAYING THE GAME BY FIGHTING THE ENEMIES AND SET BOSSES IN EVERY LEVELS</h2>
                </div>
            </div>
            <div class="col-12 col-md-4 mb-4">
                <div class="box">
                <p class="box-number">Code</p>
                <h2 class="box-title">CODE IS YOUR WEAPON TO DEFEAT THE ENEMIES AS WELL AS THE BOSS, THINK LOGICALLY AND FIGHT FAIRLY!</h2>
                </div>
            </div>
            <div class="col-12 col-md-4 mb-4">
                <div class="box">
                <p class="box-number">ENJOY</p>
                <h2 class="box-title">ENJOY AND HAVE FUN WITH THE EXCITING NEW PIXEL GAME TO LEARN THE FUNDAMENTALS OF PYTHON PROGRAMMING</h2>
                </div>
            </div>
        </div>
    </div>

    <br><br><br>

    <div class="container new-container">
        <div class="row align-items-center">
            <div class="col-12 mb-4">
                <div class="content-wrapper">
                    <h1 class="headline-3">Unlock the Power of Code: A Journey into Digital Creation</h1>
                    <img src="img/3.png" alt="" class="rounded" id="carousel-img">
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