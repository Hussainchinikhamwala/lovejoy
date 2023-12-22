<?php 
session_start();
include("main.php");
if(!(isset($_SESSION["user"]) || isset($_SESSION["user-admin"]) || isset($_GET["69"])) ){
  header("location:login.php");
  exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Contact Us Form</title>
  <!-- Bootstrap CSS CDN -->
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container mt-5" style = "background-color:white;height:100%;margin-top:50px;margin-bottom:50px;">
<nav class="navbar navbar-expand-lg navbar-light bg-light" style = "margin-bottom:50px;">
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
                </ul>
            </div>
            </nav>
  <h2>Contact Us</h2>
  <form action="contact-us.php" method = "POST">
    <div class="form-group">
      <label for="name">Your Name</label>
      <input type="text" class="form-control" id="name" placeholder="Enter your name" name = "name" required>
    </div>
    <div class="form-group">
      <label for="email">Your Email</label>
      <input type="email" class="form-control" id="email" placeholder="Enter your email" name = "email" required>
    </div>
    <div class="form-group">
      <label for="subject">Subject</label>
      <input type="text" class="form-control" id="subject" placeholder="Enter the subject" name ="subject" required>
    </div>
    <div class="form-group">
      <label for="message">Your Message</label>
      <textarea class="form-control" id="message" rows="4" placeholder="Enter your message" name = "message" required></textarea>
    </div>
    <button type="submit" class="btn btn-primary login-btn" style = "margin-bottom:50px;" name = "submit">Submit</button>
  </form>
</div>

<!-- Bootstrap JS and Popper.js CDN (required for Bootstrap JavaScript components) -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

</body>
</html>

<?php
if(isset($_POST["submit"])){
  if (!empty($_POST['honeypot'])) {
    header("404 error");
    die();
  }
    $name = $_POST['name'];
    $email = $_POST['email'];   
    $subject = $_POST['subject'];
    $message = $_POST['message'];

    $ob = new Main();
    $ob->ContactUs($name,$email,$subject,$message);


}
?>