<?php
require("dbconnection.php");

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;


require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

$mail = new PHPMailer(true);

if(isset($_REQUEST["submit"]))
	{
        $name = $_REQUEST["name"];
        $email = $_REQUEST["email"];
        $pass = $_REQUEST["password"];

        $pages = range(100000,900000);
        // Shuffle numbers
        shuffle($pages);
        // Get a page
        $pid = array_shift($pages);

        if( $name !== ""  && $email  !=="" && $pass !=="" ){

        if(mysqli_num_rows(mysqli_query($con,"select * from `users` where email='$email'"))>0){
             
            echo "Userame already present"; 
        }
        else{
            $password=password_hash($pass,PASSWORD_DEFAULT);
		    $res=mysqli_query($con,"insert into `users` (`id`, `patient_id`, `name`, `email`, `password`) values('0','$pid','$name','$email','$password')");

            if($res)
            {
                
    
try {

    $mail->isSMTP();                                           
    $mail->Host       = 'smtp.gmail.com';                     
    $mail->SMTPAuth   = true;                                   
    $mail->Username   = 'viwinnithyanand2310@gmail.com';    //sender email                
    $mail->Password   = 'hnrpujtkqtemkshr';     //sender email password generated from google apps specific                        
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            
    $mail->Port       = 465;                                    
    
    
    $mail->setFrom('viwinnithyanand2310@gmail.com', 'Diet Plan');
    
    $mail->addAddress($email);       // sender gmail and site identity      
    
    
    $mail->isHTML(true);                                 
    $mail->Subject = 'Your Appointment Details';
    $mail->Body    = "<b>Hello</b> <br>".$name." <br> Your Accout  on  Diet Plan Has been created.  <br> You can Now login <br>See You Soon";
    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
    
    $mail->send();
    echo '<script>alert("Your Appointment confirmed and mail sent ")</script>';
    header('location:login.php');
    } catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
    
               
            }
            else{

                ?><script type="text/javascript">alert("Please try again");</script><?php             
            }

        }
    }
    else{

        ?><script type="text/javascript">alert("Please Fill all the fields correctly");</script><?php      
    }

    }
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style.css">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DietPlan</title>
</head>
<body>
    <div class="main">
        
    <div class="backdrop">
    </div>
    <div class="backdrop-oval">
    </div>
    <div class="signup_wrapper">
        <div class="form-wrapper">
            <h2>Welcome To DietPlan</h2>
            <form class="signup-form" action="" method="post">
            <input type="text" name="name"  class="signup-inputs" placeholder="Full Name ">
            <br>
           
            <input type="email" name="email"  class="signup-inputs" placeholder="Email Address">
            <br>
            <input type="Password" name="password" class="signup-inputs" placeholder="Password">
            <div class="button-wrapper">
                <button class="log-btn" name="submit">Signup</button>
                <div class="link-wrapper">
                    <h5>Already a Member?<a href="#"> Login Instead </a> </h5>
                    <h4>Forgot Password ?</h4>
                </div>
            </div>
            
            </form>
        </div>
        
    </div>
</div>
</body>
</html>