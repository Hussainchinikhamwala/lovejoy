<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="style.css">
    <title>Sign Up - Assignment</title>
    <style>
    </style>

</head>
<?php

include("main.php");
if(isset($_POST["signup"])){
  // Check the honey pot field
  if (!empty($_POST['honeypot'])) {
    header("404 error");
    die();
  }
  if($_POST["pass"] != $_POST["cpass"]){
    $_SESSION["error"] = "Passwords don't match";
  }
  else{
    $pass = $_POST["pass"];
    $cpass = $_POST["cpass"];
    if (!preg_match("#.*^(?=.{8,20})(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*\W).*$#", $pass)){
      $_SESSION["error"] = "Please choose a strong password with upper and lower case letters and a combination of number and symbols ";
    } 
    else {
      $email = $_POST['email'];
      $fname = filter_input(INPUT_POST, 'fname', FILTER_SANITIZE_STRING);
      $filtered_email = filter_var($email, FILTER_VALIDATE_EMAIL);
      $pass = filter_input(INPUT_POST, 'pass', FILTER_SANITIZE_STRING);
      $phone = filter_input(INPUT_POST, 'phone', FILTER_SANITIZE_STRING);
      $ob = new Main();
      $ob->sendEmail($fname,$filtered_email,$pass,$phone);
      // if($ob->checkEmail()){
      // $ob->signUp();  
    
  }
    }
}


?>

<body>

  <div class="container">
    <div class="row">
      <div class="col-md-6 offset-md-3">
        <div class="login-container" style = "border: 1px solid black;">
          <div class="login-header">
            <h2>Welcome To LoveJoy! Sign Up Here</h2>
          </div>
          
          <form action = "signup.php" method = "POST">
            <div class="form-group">
              <label for="name">Full Name:</label>
              <input type="text" class="form-control" id="fname" placeholder="Enter your name" name = "fname" required>
            </div>

            
            <div class="form-group">
              <label for="email">Email:</label>
              <input type="email" class="form-control" id="email" placeholder="Enter your email" name = "email" required>
            </div>

            <div class="form-group">
                <label for="phoneNumber">Phone Number: </label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text">+44</span>
                    </div>
                    <input type="tel" class="form-control" id="phoneNumber" placeholder="Enter phone number" pattern="[0-9]{10}" name = "phone" required>
                </div>
                <small class="form-text text-muted">Please enter a 10-digit phone number.</small>
            </div>
            
            <div class="form-group">
              <label for="password">Password:</label>
              <input type="password" class="form-control" id="password" placeholder="Enter your password" name = "pass" required>
            </div>
            
            <div class="form-group" style = "margin-bottom:10px;">
              <label for="confirm-password">Confirm Password:</label>
              <input type="password" class="form-control" id="confirm-password" placeholder="Confirm your password" name = "cpass" required>
            </div>

             <!-- Honey Pot Field -->
            <input type="text" name="honeypot" id="honeypot" style="display:none">

            <?php if(isset($_SESSION['error'])){ ?> <div class="alert alert-danger" role="alert"> <?= $_SESSION['error'];  ?> </div>  <?php unset($_SESSION['error']); } ?>
            <button type="submit" class="btn btn-secondary login-btn" style = "background-color:brown;" name = "signup">Sign Up</button>
          </form>
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