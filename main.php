<?php
include("includes/dbh.php");
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;
require 'vendor/autoload.php';
Class Main extends Dbh{
    public function signUp($fname,$email,$pass,$phone){

        try{
                $password = password_hash($pass,PASSWORD_DEFAULT);
                $query2 = "SELECT * FROM lovejoy WHERE Email = '".$email."'";
                $insert2 = mysqli_query($this->connect(),$query2);
                if(mysqli_num_rows($insert2) == 0){
                    $query = "INSERT INTO `lovejoy`(FirstName,Email,Pass,Phone,user_type) VALUES ('".$fname."','".$email."','".$password."','".$phone."','user')";
                    $insert  = mysqli_query($this->connect(),$query);
                    if($insert){
                        header("location:index.php");
                    }
                }

                else{
                    echo "Email exists already. <a href =login.php>Login to continue</a> ";
                    exit;
                }
            }         
        catch(mysqli_sql_exception $e){
            var_dump($e->getMessage());
        }
    }

    public function login($email,$pass){
            try{
                
                $query = "SELECT * FROM lovejoy WHERE Email = '".$email."' ";
                $login = mysqli_query($this->connect(),$query);
                if(mysqli_num_rows($login) > 0 ){
                    while($res = mysqli_fetch_assoc($login)){
                        $pwd = $res["Pass"];
                        if(password_verify($pass,$pwd)){
                            if(hash_equals($res['user_type'],"admin")){

                                $_SESSION['user-admin'] = $res['ID'];
                                header("location:\lovejoy\admin\admin.php");
                            
                            }

                            else{
                                $_SESSION['user'] = $res['ID'];
                                header('location:index.php');
                            }
            
                        }

                        else{   
                            
                            $_SESSION['error'] = "Email or Password incorrect";
                        }

                    }
                }

                else{

                    
                    $_SESSION['error'] = "Email or Password incorrect";
                    
                }
            }

            catch(mysqli_sql_exception $e ){
                var_dump($e);
            
            }
    }

    public function evaluationInfo($name,$desc,$img,$preferred_contact,$loginid,$tmp_name,$destination){
        try{ 
             
            $upload = move_uploaded_file($tmp_name,$destination);
            if($upload){    
                $query = "INSERT INTO `evaluation`(name,description,images,preferred_contact,loginid) VALUES ('".$name."','".$desc."','".$img."','".$preferred_contact."','".$loginid."')";
                $insert  = mysqli_query($this->connect(),$query);
                if($insert){
                    header("location:index.php");
                }

                else{
                    echo "record not inserted";
                }
            }

            else{
                echo "Sorry there is an unknown error";
            }
        }
        catch(mysqli_sql_exception $e){

            var_dump($e);
        }
    }

    public function listEvaluation($sno){
        $query = "SELECT ev.name, ev.description, ev.images, ev.preferred_contact, lj.Email, lj.Phone 
        FROM evaluation ev
        JOIN lovejoy lj ON ev.loginid = lj.ID";
        $result = mysqli_query($this->connect(),$query);
        if (mysqli_num_rows($result)>0) {
            while($row = mysqli_fetch_assoc($result)){?>
                <tbody>
                <tr> 
                        <th scope = "row"><?= $sno++ ?></th>
                        <td><?= $row['name']?></td>
                        <td><?= $row['description']?></td>
                        <td><a href="<?= '../includes/antiques/'.$row['images'] ?>" download class= "btn btn-primary"> Download Image </a></td>
                        <td><?=$row['preferred_contact']?></td>
                        <td><?= $row['Email']?></td>
                        <td><?= $row['Phone']?></td>
                    </tr>
                    </tbody>
    <?php   
        }
        }
        else{
            ?>
                <tr><td>  No Results to show. </td></tr>
<?php }

    }

    public function ContactUs($name,$email,$subject,$message){
        try{
            $query = "INSERT INTO `contactus`(name,email,subject,message) VALUES ('".$name."','".$email."','".$subject."','".$message."')";
            $insert  = mysqli_query($this->connect(),$query);
            if($insert){
                header("location:index.php");
            }
        }
        catch(mysqli_sql_exception $e){
            var_dump($e);
        }
    }

    public function emailValidation($email){
        try{
            $query = "SELECT * FROM lovejoy WHERE Email = '".$email."' ";
            $result = mysqli_query($this->connect(),$query);
            if(mysqli_num_rows($result) > 0){
                while($row = mysqli_fetch_assoc($result)){
                    $name = $row['FirstName'];
                    $token = rand(1111,9999);
                    $query2 = "UPDATE lovejoy SET code = '".$token."' WHERE Email = '".$email."'";
                    $result2 = mysqli_query($this->connect(),$query2);
                    if($result2){
                        $mail = new PHPMailer(true);
                        try {
                                        //Server settings
                            $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      
                            $mail->isSMTP();                                            
                            $mail->Host       = 'smtp.gmail.com';                     
                            $mail->SMTPAuth   = true;                                 
                            $mail->Username   = '96lovejoy69@gmail.com';              
                            $mail->Password   = 'apcbyprcczfnxvin';                     
                            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            
                            $mail->Port       = 465;                                    
                            $mail->setFrom('noreply@lovejoy.com', 'Love Joy');
                            $mail->addAddress($email,$name);   
                            
                            $resetLink = "http://localhost/lovejoy/reset_password.php?token=".rand(1,9).$token.rand(1,9);
                            $mail->isHTML(true);                                  
                            $mail->Subject = 'Email Verification';
                            $mail->Body    = "Click the following link to reset your password: $resetLink";
                            header("Location:pwd_last.php?token=0069");       
                            $mail->send();            
                            exit;
                        } catch(Exception $e) { 
        
                        var_dump($e);
                        }
                    }
                }
            }
            else{

                $_SESSION['error'] = "Please enter a valid email";


            }

        }
        catch(mysqli_sql_exception $e){ 

            var_dump($e);
        }

    }



    public function updatepassword($password,$token){
        $hashed_pass = password_hash($password,PASSWORD_DEFAULT);
        $query= "UPDATE lovejoy SET Pass = '".$hashed_pass."' WHERE code = '".$token."'";
        $result = mysqli_query($this->connect(),$query);
        if($result){ ?>
            <script>alert('Password changed successfully')</script>
        
        <?php header('location:login.php'); }
    }


    public function sendEmail($fname,$email,$pass,$phone){
        try{

                    $token = rand(1111,9999);

                        $mail = new PHPMailer(true);
                        try {
                            $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      
                            $mail->isSMTP();                                            
                            $mail->Host       = 'smtp.gmail.com';                     
                            $mail->SMTPAuth   = true;                                 
                            $mail->Username   = '96lovejoy69@gmail.com';              
                            $mail->Password   = 'apcbyprcczfnxvin';                   
                            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;          
                            $mail->Port       = 465;                                  
                            $mail->setFrom('noreply@lovejoy.com', 'Love Joy');
                            $mail->addAddress($email,$fname);   
                            $mail->isHTML(true);                                  
                            $mail->Subject = 'Email Verification';
                            $mail->Body    = "Here is Your verification code: $token"; 
                            session_start();
                            $_SESSION['token'] = $token;
                            $_SESSION['pass'] = $pass;
                            header("location:email_verification.php?name=$fname&email=$email&phone=$phone");
                            $mail->send();            
                            return true;
                            
                        } 
                            catch(Exception $e) { 
                            var_dump($e);

                        }
        
                    }
        catch(mysqli_sql_exception $e){ 

            var_dump($e);
        }

    }

}



    ?>
