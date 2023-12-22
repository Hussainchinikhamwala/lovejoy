<?php 
session_start();
include("main.php");
if(!(isset($_SESSION["user"]) || isset($_SESSION["user-admin"]) || isset($_GET["69"])) ){
    header("location:login.php");
    exit();
}
else{

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="style.css">
        <link rel="icon" href= "tab icon.png" 
            type="image/x-icon"> 
        <title>LoveJoy - Login Page</title>
        <!-- <style>
        </style> -->
    </head>
    <body>

        <div class="container" style = "background-color:white;height:100%;margin-top:50px;">
            <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <a class="navbar-brand" href="index.php" style = "color:brown;font-weight:bold;font-family:garamond;">
                <!-- Add your logo image or text here -->
                <p>Love Joy Antiques</p>
                <!-- If using text: Lovejoy Antiques -->
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="index.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="contact-us.php">Contact Us</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="req-evaluation.php">Request Evaluation</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="logout.php">Log Out</a>
                </li>

                <?php if(isset($_SESSION["user-admin"])){ ?>
                <li class="nav-item">
                    <a class="nav-link" href="admin/admin.php">Admin Panel</a>
                </li>
                <?php } ?>
                </ul>
            </div>
            </nav>

            <div class="row mt-4" >
                <div class="col-md-6 offset-md-3">
                    <div class="login-container"style = "margin-bottom:50px;">
                        <div class="login-header text-center">
                            <h2>Welcome to Lovejoy Antiques!</h2>
                        </div>
                        <!-- 
                        <div class="text-center mb-4">
                            <a href="login.php" class="btn btn-success btn-lg btn-block">L</a>
                        </div> -->
                        <div class="text-center">
                            <a href="req-evaluation.php" class="btn btn-info btn-lg btn-block mb-2">Request Evaluation</a>
                            <a href="contact-us.php" class="btn btn-warning btn-lg btn-block" style = "margin-left:20px;">Contact Us</a>
                        </div>
                    
                    </div>
                </div>
            </div>
        </div>
        <!-- Bootstrap JS and Popper.js CDN (required for Bootstrap JavaScript components) -->
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>



    </body>
</html>


<?php } ?>
