<?php
session_start();
include("main.php");
if(isset($_POST["signup"]) && isset($_SESSION['token'])){
    $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
    $email = $_POST['email'];    
    $filtered_email = filter_var($email, FILTER_VALIDATE_EMAIL);
    $pass = filter_input(INPUT_POST, 'pass', FILTER_SANITIZE_STRING);
    $phone = filter_input(INPUT_POST, 'phone', FILTER_SANITIZE_STRING);
    $code =  filter_input(INPUT_POST, 'code', FILTER_SANITIZE_STRING);
    $token = $_SESSION['token'];
    $ob = new Main();
    if($code == $token){
        $ob->signUp($name,$filtered_email,$pass,$phone);
        header('location:login.php');
    }
    else{
        $_SESSION['error'] = "code is invalid";
    }
    
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Reset Confirmation</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container mt-5" >
    <div class="row justify-content-center" >
        <div class="col-md-5" style = "background-color:white;margin:10px;padding:35px;">
        <h2>Email Verification:</h2>
            <form action="email_verification.php" method="post">
            <?php if(isset($_SESSION['error'])){ ?> <div class="alert alert-danger" role="alert"> <?= $_SESSION['error'];  ?> </div>  <?php unset($_SESSION['error']); } ?>
            <input type="hidden" name="name" value = <?=htmlspecialchars($_GET['name']) ?>>
                <input type="hidden" name="email" value = <?= htmlspecialchars($_GET['email']) ?> >
                <input type="hidden" name="pass" value = <?php if(isset($_SESSION['pass'])){ echo htmlspecialchars($_SESSION['pass']); } else{ header('location:login.php'); } ?> >
                <input type="hidden" name="phone" value = <?= htmlspecialchars($_GET['phone']) ?> >
                             <!-- Honey Pot Field -->
            <input type="text" name="honeypot" id="honeypot" style="display:none">
                <div class="form-group">
                <label for="password">Enter The Verification code sent to your email:</label>
                <input type="password" class="form-control" id="password" placeholder="Enter your password" name = "code" required>
                </div>
                <button type="submit" class="btn btn-secondary login-btn" style = "background-color:brown;" name = "signup">Sign Up</button>
            </form>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

</body>
</html>

