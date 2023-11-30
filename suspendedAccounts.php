<?php 

session_start();
include 'database.php';
require_once ('functions.php');

// check if 
if(isset($_GET['token']) && $_GET['userID']){
    $token = sanitizeStringGet('token');
    $userID = sanitizeStringGet('userID');

    if(verifyTokenAnduserID($userID, $token)){

        // check if the session is valid
        if(isset($_SESSION['user'])){
            $userID = $_SESSION['user'];
            // if valid fetch admins email
            $stmt = $conn->prepare("SELECT email FROM admin_account WHERE userID = ?");
            $stmt -> bind_param("i",$userID);
            $stmt -> execute();
            $result = $stmt -> get_result();
            $resultRow = mysqli_fetch_assoc($result);
            $email = $resultRow['email'];
    
        } else {
              $showSession = true;
        
        }

    } else {
        session_unset();
        session_destroy();
        $showModal = true;
    }

} else {

    session_unset();
    session_destroy();
    $showModal = true;
}



?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="dashboard.css">
</head>
<body>
    <div class="d-flex" id="wrapper">
        <!-- Sidebar -->
        <div class="bg-white" id="sidebar-wrapper">
        <!-- Logo -->
        <div class="sidebar-heading text-center py-4 primary-text fs-4 fw-bold text-uppercase">
            <div class="sidebar-logo">
                <img src="img/codigo-logo.png" alt="logo">
            </div>
        
            <div class="sidebar-logo-name">
                <img src="img/codigo-name.png" alt="logo">
            </div>
        </div>

        <!-- Items -->
        <div class="list-group list-group-flush my-3">
            <a href="dashboard.php" class="list-group-item list-group-item-action bg-transparent second-text-active fw-bold sidebar-link">
                <i class="fas fa-tachometer-alt me-2"></i> Dashboard
            </a>

            <a href="suspendedAccounts.php" class="list-group-item list-group-item-action bg-transparent second-text-active fw-bold sidebar-link">
                <i class="fa-solid fa-user me-2"></i> Suspended Profiles
            </a>

            <a href="comments.php" class="list-group-item list-group-item-action bg-transparent second-text-active fw-bold sidebar-link">
                <i class="fas fa-comment-dots me-2"></i> Comments
            </a>

            <a href="#" class="list-group-item list-group-item-action bg-transparent text-danger fw-bold " onclick="showConfirmModal()">
                <i class="fa-solid fa-right-from-bracket me-2"></i> Logout
            </a>
        </div>
    </div>
        <!-- /#sidebar-wrapper -->

        <!-- Page Content -->
        <div id="page-content-wrapper">

            <div class="page-content-head">
            <nav class="navbar navbar-expand-lg navbar-light bg-transparent py-4 px-4">
                <div class="d-flex align-items-center">
                    <i class="fas fa-align-left primary-text fs-4 me-3" id="menu-toggle" style="color:#ffffff"></i>
                     <div class="page-heading"><h2 class="fs-2 m-0"> Suspend Save Profiles</h2></div>    
                </div>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle second-text fw-bold" href="#" id="navbarDropdown"
                                role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-user me-2"></i><?php if(isset($email)){  echo $email;  }?>
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item" href="#"data-bs-toggle="modal" data-bs-target="#modalLoginAvatar">Profile</a></li>
                                <li><a class="dropdown-item" href="#"  onclick="showConfirmModal()" >Logout</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>

            </div>

            <div class="container-fluid px-4">
            <div class="row my-5">
                <h3 class="fs-4 mb-3">Save Profiles <button title="Refresh" id="refreshSaveProfile" class="btn btn-link"><i class="fa-solid fa-arrows-rotate" style="color: #3a833a;"></i></button> </h3>
                <div class="col">
                    <div class="table-responsive">
                        <table id="dashboardTable" class="table bg-white rounded shadow-sm table-hover">
                            <thead>
                                <tr>
                                    <th scope="col" width="50">#</th>
                                    <th scope="col">EntryID</th>
                                    <th scope="col">UserID</th>
                                    <th scope="col">Current Health</th>
                                    <th scope="col">Max Health</th>
                                    <th scope="col">Second Current Health</th>
                                    <th scope="col">Second Max Health</th>
                                    <th scope="col">HeartShield</th>
                                    <th scope="col">Current Room</th>
                                    <th scope="col">Map Tutorial</th>
                                    <th scope="col">Save Profile Name</th>
                                    <th scope="col">Time Suspended</th>
                                    <th scope="col">Operations</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    <!-- /#page-content-wrapper -->
    </div>


 <!-- Profile Modal-->
 <div class="modal fade" id="modalLoginAvatar" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <!--Content-->
            <div class="modal-content">

            <!--Header-->
            <div class="modal-header">
                <img src="img/Admin.png" style = "width: 170px; height: auto; margin: auto;"alt="avatar" class="rounded-circle img-responsive">
            </div>
            <!--Body-->
            <div class="modal-body text-center mb-1">
                <h3 class="mt-1 mb-2">Current Admin</h3>
                <br>
                <h5 class="mt-1 mb-2"><?php if(isset($email)){  echo $email;  }?></h5>
            </div>
        </div>
    </div>
</div>

        
        
<!-- Invalid Access Modal -->
<div class="modal fade" id="myModal"data-bs-backdrop="static" data-bs-keyboard="false"  datatabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h5 class="modal-title" id="ModalLabel">Invalid Access</h5>
            </div>
           
            <!-- Modal Footer -->
            <div class="modal-footer">
                <a class="btn btn-primary" href="login.php" role="button">Go back to login</a>
            </div>
        </div>
    </div>
</div>


<!-- Session Expired Modal -->
<div class="modal fade" id="sessionModal"data-bs-backdrop="static" data-bs-keyboard="false"  datatabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h5 class="modal-title" id="ModalLabel">Session Expired</h5>
            </div>
           
            <!-- Modal Footer -->
            <div class="modal-footer">
                <a class="btn btn-primary" href="login.php" role="button">Go back to login</a>
            </div>
        </div>
    </div>
</div>


<!-- Logout Confirm Modal -->
<div class="modal fade" id="confirmLogoutModal"data-bs-backdrop="static" data-bs-keyboard="false"  datatabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h5 class="modal-title" id="ModalLabel">Confirmation</h5>
            </div>
            <div class="modal-body">
            Are you sure you want to logout?
            </div>
            <!-- Modal Footer -->
            <div class="modal-footer">
                <a class="btn btn-secondary"  data-bs-dismiss ="modal" role="button">No</a>
                <a class="btn btn-primary"  id = "logoutBttn" role="button">Yes</a>
            </div>
        </div>
    </div>
</div>

<!-- Confirm Unsuspend Modal -->
<div class="modal fade" id="confirmUnsuspendModal" tabindex="-1" aria-labelledby="confirmUnsuspendModal" aria-hidden="true">
    <div class="modal-dialog modal-sm ">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="confirmSuspendModalTitle">Confirmation</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          Are you sure you want to unsuspend this profile?
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
          <button type="button" class="btn btn-success" id = "confirmUnsuspendModalBttn">Yes</button>
        </div>
      </div>
    </div>
</div>

<!-- Confirm block Modal -->
<div class="modal fade" id="confirmBlockModal" tabindex="-1" aria-labelledby="confirmBlockModal" aria-hidden="true">
    <div class="modal-dialog modal-sm ">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="confirmBlockModalTitle">Confirmation</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          The process cannot be reverted. Are you sure you want to continue?
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
          <button type="button" class="btn btn-success" id = "confirmBlockModalModalBttn">Yes</button>
        </div>
      </div>
    </div>
</div>

<!-- Success Modal -->
<div class="modal fade" id="successModal"  data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
    <div class="modal-dialog  modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="successModalLabel">Success</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="successAndRefresh" >Close</button>
            </div>
        </div>
    </div>
</div>


<!-- Error Modal -->
<div class="modal fade" id="errorModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="errorModalLabel" aria-hidden="true">
    <div class="modal-dialog  modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="errorModalLabel">Error</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                There was an error doing your request. Please try again later.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="errorAndRefresh">Close</button>
            </div>
        </div>
    </div>
</div>



<?php			
	if(!empty($showModal)) {
		// Illegal Access Modal
		echo '<script type="text/javascript">
			$(document).ready(function(){
				$("#myModal").modal("show");
			});
		    </script>';
	} 

    if(!empty($showSession)) {
		// Illegal Access Modal
		echo '<script type="text/javascript">
			$(document).ready(function(){
				$("#sessionModal").modal("show");
			});
		    </script>';
	} 
?>
  
  <script>

   // Event listener for link clicks
   document.addEventListener('DOMContentLoaded', function () {
        var links = document.querySelectorAll('.sidebar-link');
        
        links.forEach(function (link) {
            link.addEventListener('click', function (event) {
                var destination = this.getAttribute('href');
                handleLinkClick(event, destination);
            });
        });
    });


// function that ensures that the admin will be given the same id and token when clicking a link in the sidebar
function handleLinkClick(event, destination) {
        event.preventDefault(); // Prevent the default link behavior (page reload)
        
        // Assuming you have the token and userID available in your PHP code
        var token = <?php echo json_encode($token); ?>;
        var userID = <?php echo json_encode($userID); ?>;
        
        // Construct the URL with the token and userID parameters
        var url = destination + '?userID=' + encodeURIComponent(userID) + '&token=' + encodeURIComponent(token);
        
        // Navigate to the new page
        window.location.href = url;
    }
</script>
<script src="suspendedAccounts.js" type="text/javascript"></script>
</body>
</html>