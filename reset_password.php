<?php 
session_start();
include("main.php");

if(isset($_POST["submit"]) && isset($_POST['token'])){

    $token = filter_input(INPUT_POST, 'token', FILTER_SANITIZE_STRING);

    $_SESSION['token'] = $token;
    if($_POST["pwd"] == $_POST["confirm_pwd"] ){
        $password = filter_input(INPUT_POST, 'pwd', FILTER_SANITIZE_STRING);
        $cpassword = filter_input(INPUT_POST, 'confirm_pwd', FILTER_SANITIZE_STRING);
        if (!preg_match("#.*^(?=.{8,20})(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*\W).*$#", $password)){
            
            $_SESSION['error'] = "Please choose a strong password with upper and lower case letters and a combination of number and symbols ";
            
        } 
        else{
            $ob = new Main();
            $ob->updatePassword($password,$token);
        }
    
    }

    else{

        
        $_SESSION['error'] = "passwords don't match";
        
    }

}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h2>Recover Your Account</h2>
                    <form action="reset_password.php" method="POST">
                    <?php if(isset($_SESSION['error'])){ ?> <div class="alert alert-danger" role="alert"> <?= $_SESSION['error'];  ?> </div>  <?php unset($_SESSION['error']); } ?>

                        <div class="form-group">
                            <label for="password">Enter New Password:</label>
                            <input type="password" class="form-control" id="email" name="pwd" required>
                        </div>
                        <div class="form-group">
                            <label for="password">Confirm New Password:</label>
                            <input type="password" class="form-control" id="email" name="confirm_pwd" required>
                        </div>
                        <input type="hidden" name="token" value = <?php if(isset($_GET['token'])){ $token = substr($_GET['token'], 1, -1); } else{ echo $_SESSION['token']; } ?>>
                                     <!-- Honey Pot Field -->
          
                        <button type="submit" class="btn btn-primary" name = "submit">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

</body>
</html>
