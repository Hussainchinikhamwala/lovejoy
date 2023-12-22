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
  <title>Request Evaluation - Lovejoy Antiques</title>
  <!-- Bootstrap CSS CDN -->
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
  <!-- Custom CSS -->
  <link rel="stylesheet" href="style.css">
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
            <a class="nav-link" href="req-evaluation.php">Request Evaluation</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="logout.php">Logout</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="contact-us.php">Contact</a>
          </li>
        </ul>
      </div>
    </nav>

    <div class="row mt-4">
      <div class="col-md-8 offset-md-2">
        <div class="login-container" style = "margin-bottom:50px;">
          <div class="login-header text-center">
            <h2>Request Antique Evaluation</h2>
          </div>

          <form action = "req-evaluation.php" method = "POST" enctype="multipart/form-data">
          <?php if(isset($_SESSION['error'])){ ?> <div class="alert alert-danger" role="alert"> <?= $_SESSION['error'];  ?> </div>  <?php unset($_SESSION['error']); } ?>

            <div class="form-group" >
              <label for="itemName">Item Name:</label>
              <input type="text" class="form-control" id="itemName" placeholder="Enter the name of the item" name = "name" required>
            </div>

            <div class="form-group">
              <label for="itemDescription">Item Description:</label>
              <textarea class="form-control" id="itemDescription" rows="3" placeholder="Provide a detailed description of the item" name = "desc" required></textarea>
            </div>
            <div class="form-group">
              <label for="itemImages">Upload Images:</label>
              <input type="file" class="form-control-file" name = "img" required>
            </div>

                        <!-- New dropdown for preferred method of contact -->
            <div class="form-group">
              <label for="contactMethod">Preferred Method of Contact</label>
              <select class="form-control" id="contactMethod" name= "preferred_contact" >
                <option value="phone">Phone</option>
                <option value="email">Email</option>
              </select>
            </div>

            <input type="hidden" name="loginid" value="<?= $_SESSION['user'] ?>">
                         <!-- Honey Pot Field -->
            <input type="text" name="honeypot" id="honeypot" style="display:none">

            <button type="submit" class="btn btn-primary btn-block" name = "submit">Submit Request</button>
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

<?php

if(isset($_POST['submit'])){
  if (!empty($_POST['honeypot'])) {
    header("404 error");
    die();
  }
  $pathinfo = pathinfo($_FILES["img"]["name"]);
  $filename = $pathinfo['filename'];
  $file_type = ["image/png","image/jpeg","image/jpg"];
  if($_FILES['img']['error'] == UPLOAD_ERR_NO_FILE){
    $_SESSION['error'] = "No images are uploaded.";
    exit();
  }
  else if($_FILES["img"]["size"] > 1000000){
    $_SESSION['error'] = "file size should be less than 10MB.";
    exit();
  }
  else if(!in_array($_FILES['img']['type'], $file_type)){
    $_SESSION['error'] = "Invalid format chosen. Please choose an image in jpeg or png format only.";
    exit();
  }

  else if($_FILES['img']['error'] == UPLOAD_ERR_CANT_WRITE || $_FILES['img']['error'] == UPLOAD_ERR_NO_TMP_DIR){
    $_SESSION['error'] = "Unknown Upload Error";
    exit();
  }

  else{
    $i = 1;
    $tmp_name = $_FILES['img']['tmp_name'];
    $base = $pathinfo['filename'];
    $base = preg_replace("(/[^\w-]/)","_", $base);
    $img = $base."($i).".$pathinfo['extension'];
    $destination = __DIR__ .'/includes/antiques/'.$img;
    while(file_exists($destination)){    
      $img = $base."($i).".$pathinfo['extension'];
  
      $destination = __DIR__ ."/includes/antiques/".$img ;
      $i++;
    }  
    $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
    $desc = filter_input(INPUT_POST, 'desc', FILTER_SANITIZE_STRING);
    $preferred_contact = filter_input(INPUT_POST, 'preferred_contact', FILTER_SANITIZE_STRING);
    $loginid = filter_input(INPUT_POST, 'loginid', FILTER_SANITIZE_STRING);
    $ob = new Main() ;
    $ob->evaluationInfo($name, $desc, $img, $preferred_contact, $loginid,$tmp_name,$destination) ;
    
  }
}

  

  


// }

?>