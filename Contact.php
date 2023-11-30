<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="Contact.css">
    <script src="contact_js.js"></script>
    <title>Contact Us</title>
</head>
<body>
       
<nav class="navbar navbar-default navbar-fixed-top">
            <a href="index.php">Home</a>
            <a href="about.php">About</a>
            <a class="navbar-logo">
                <img src="img/codigo-name.png" alt="Logo">
            </a>
            <a href="contact.php">Contact Us</a>
            <a href="login.php">Admin Login</a>
        </nav>

    <div class="main-container">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 mb-4">
                    <div class="container-img">
                        <img id="logo-img" src="img/Codigo-name.png" alt="LOGO NAME" style="display: none;">
                    </div>
                    <h5 id="sub-header-name" style="display: none;">Connect with Us: Reach Out and Let Your Voice Be Heard</h5>
                
                </div>
            </div>
        </div>
    </div>
    
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 mb-4 fade-scroll-container">
                <img src="img/user-feedback.png" alt="Image description" class="custom-image">
                <div class="text-center">
                    <h1>CONTACT US</h1>
                    <h3>Connecting Made Easy: Feel Free to Contact Us for Any Questions, Suggestions, or Assistance You May Need!</h3>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-lg-6" id="ctc-img">
                <img src="img/form-img.jpg" alt="Contact Image">
            </div>
            <div class="col-lg-6">
                <form id= "contactUsForm">
                    <div class="form-group">
                        <label for="name" class="label-name">Name:</label>
                        <input type="text" name = "name" class="form-control" id="name" placeholder="Enter your name">
                    </div> 
                    
                    <div class="form-group">
                        <label for="email" class="label-email">Email:</label>
                        <input type="email" name = "email" class="form-control" id="email" required placeholder="Enter your email">
                    </div>
        
                    <div class="form-group">
                        <label for="message" class="label-message">Message:</label>
                        <textarea class="form-control" name = "message" id="message" rows="5" placeholder="Enter your message"></textarea>
                    </div>
        
                    <input type="button" name="comment" value ="Submit" id="submitBtn" data-bs-toggle="modal" data-bs-target="#confirmComment" class="btn btn-primary"> 
                </form>
            </div>
        </div>
    </div>

<!-- confirmation modal-->
<div class="modal fade" id="confirmComment" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
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
                        <th>Name:</th>
                        <td id="Name"></td>
                    </tr>
                    <tr>
                        <th>Email:</th>
                        <td id="Email"></td>
                    </tr>
					<tr>
                        <th>Message:</th>
                        <td>
						<textarea  id="Message" cols="20" rows="5" readonly></textarea>
                        </td>
                    </tr>
        </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
        <button type="button" class="btn btn-success" id ="confirmSubmitComment">Yes</button>
      </div>
    </div>
  </div>
</div>



<!-- Success Modal -->
<div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="successModalLabel">Success</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Your message has been successfully submitted.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>


<!-- Error Modal -->
<div class="modal fade" id="errorModal" tabindex="-1" aria-labelledby="errorModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="errorModalLabel">Error</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                There was an error submitting your message. Please try again later.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>


<script>
/* when the button in the form is clicked, display the entered values in the modal */
$('#submitBtn').click(function() {
    $('#Name').text($('#name').val());
    $('#Email').text($('#email').val());
    $('#Message').val($('#message').val()); 
});

// get if the button was clicked
document.getElementById("confirmSubmitComment").addEventListener("click", submitComment);

// create submitComment function
function submitComment(e) {
    e.preventDefault();

    var name = document.getElementById("name").value;
    var email = document.getElementById("email").value;
    var message = document.getElementById("message").value;

    // check if the fields are empty
    if (!name || !email || !message) {
        // Show an alert or any other appropriate user feedback for empty fields
        alert("All field Must be Filled!");
        return;
    }


    var data =  'name=' + encodeURIComponent(name) +
                '&email=' + encodeURIComponent(email) +
                '&message=' + encodeURIComponent(message);

    //create xhr object
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "contact_us_controller.php", true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhr.onreadystatechange = function() {
        if (xhr.readyState == 4 && xhr.status == 200) {

            $('#confirmComment').modal('hide');

            if(xhr.responseText.trim() === "Successful"){
                $("#successModal").modal("show");
            } else {
                $("#errorModal").modal("show");
            }
        }
    }

    xhr.send(data);
  
}
</script>

    <br><br><br><br><br>

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