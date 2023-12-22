<?php
session_start();
include("main.php");
if(!isset($_SESSION["login_try"])){
    $_SESSION["login_try"] = 0;
}


if(isset($_SESSION["time"])){
$difference = time() - $_SESSION["time"] ;
var_dump($difference);
if ($difference > 10) {
    unset($_SESSION["time"]);
    $_SESSION['login_try'] = 0;
}

}
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
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <title>LoveJoy - Login Page</title>
    <style>
    </style>

</head>

<body>

  <div class="login-container">
    <div class="login-header">
      <h2>Login</h2>
    </div>
    
    <form action = "login.php" method = "POST">
       <?php if(isset($_SESSION['error'])){ ?> <div class="alert alert-danger" role="alert"> <?= $_SESSION['error'];  ?> </div>  <?php unset($_SESSION['error']); } ?>
      <div class="form-group">
        <label for="username"> Email: </label>
        <input type="text" class="form-control" id="username" placeholder="Enter your username" name = "email">
      </div>
      
      <div class="form-group">
        <label for="password"> Password: </label>
        <input type="password" class="form-control" id="password" placeholder="Enter your password" name = "password">
      </div>
                   <!-- Honey Pot Field -->
      <input type="text" name="honeypot" id="honeypot" style="display:none">

      <div class="form-group" style = "margin-top:20px;">
      <div class="g-recaptcha" data-sitekey="6Lc7iDEpAAAAAH6nNgaM7wmhENxeVtZZFaE4i82C"></div>
      </div>
     <?php if($_SESSION['login_try'] > 2) { ?> <p>Please wait for 10 seconds</p> <?php $_SESSION['time'] = time(); } else{ ?>
      <button type="submit" class="btn btn-primary login-btn" name = "login"> Login </button>
      <?php } ?>
      <a href="forgot.php"> Forgot Your Password? </a>
      <a href="signup.php" style="margin-left:130px;"> Register </a>
      
    </form>
  </div>

  <!-- Bootstrap JS and Popper.js CDN (required for Bootstrap JavaScript components) -->
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>

</body>
</html>

<?php 
if(isset($_POST['login'])){
  if (!empty($_POST['honeypot'])) {
    header("404 error");
    die();
  }
    $email = $_POST['email'];
    $filtered_email = filter_var($email, FILTER_VALIDATE_EMAIL);
    $pass = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);;
    $response = $_POST['g-recaptcha-response'];
    $captcha_key = '6Lc7iDEpAAAAAMuKgonqX_sGx1JgtFy1jyzT700X';
    $recaptchaVerifyUrl = "https://www.google.com/recaptcha/api/siteverify?secret={$captcha_key}&response={$response}";
    $recaptchaVerifyResult = json_decode(file_get_contents($recaptchaVerifyUrl));
    if($recaptchaVerifyResult->success){
        $ob = new Main();
        $ob->login($filtered_email, $pass);
        $_SESSION['login_try'] += 1;
    }
    else{
        $_SESSION['error'] = "Please verify that you are not a robot";
    }
}
?>