<?php
require('dbconnection.php');
session_start();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;


require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

$mail = new PHPMailer(true);
$token = $_SESSION["tokenid"]; // token id in session
  
  $qsql = "SELECT * FROM `appoint` WHERE token = $token";
  $res = mysqli_query($con,$qsql);
  $row = mysqli_fetch_assoc($res);

  if(isset($_REQUEST['delete'])){
    $tokenid = $_REQUEST['tokenid'];
    $deletesql = "DELETE FROM `appoint` WHERE token = '$tokenid'";
    $delres = mysqli_query($con,$deletesql);
    if($deletesql){
        echo"your appointment has been deleted";
        
    }
else{
    echo " Sorry error came up";
}

}


if(isset($_REQUEST["update"]))
{ 


$adate = $_REQUEST['date'];
$atime = $_REQUEST['time'];
$email = $row['email'];
$name = $row['name'];





if( $adate !== "" && $atime !== "" ){

if(mysqli_num_rows(mysqli_query($con,"select * from `appoint` where date='$adate' && time = '$atime' "))>0) {
    echo '<script>alert("Please choose different date & time" to " Appointment is not available on this date & time, so please choose an alternative date & time ")</script>';    

}
else{
   
$asql = "UPDATE `appoint` SET `date`='$adate',`time`='$atime' WHERE token = '$token'";
$aresult = mysqli_query($con,$asql);

if($aresult){
    
   
    



try {

              
$mail->isSMTP();                                           
$mail->Host       = 'smtp.gmail.com';                     
$mail->SMTPAuth   = true;                                   
$mail->Username   = 'viwinnithyanand2310@gmail.com';    //sender email                
$mail->Password   = 'hnrpujtkqtemkshr';     //sender email password generated from google apps specific                        
$mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            
$mail->Port       = 465;                                    


$mail->setFrom('viwinnithyanand2310@gmail.com', 'Diet Plan');// sender gmail and site identity

$mail->addAddress($email);   //user email is $email          


$mail->isHTML(true);                                 
$mail->Subject = 'Your Appointment Details';
$mail->Body    = "<b>Hello</b> <br>".$name." <br> Your Appointment has been rescheduled  ".$adate."  ".$atime."<br>You can track your appointment using the Appointment Token  ".$token." ";
$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

$mail->send();
echo '<script>alert("Your Appointment has been rescheduled and details have been emailed ")</script>';
header("Refresh:1; url=index.php");
} catch (Exception $e) {
echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}

}
else{
    echo '<script>alert("Appointment Failed Please Try Again ")</script>';
}

}
}
else{
    echo '<script>alert("Please Fill All the details")</script>';    }


}
if(isset($_REQUEST["logout"]))
{ 
    header("Refresh:0; url=login.php");
    session_destroy();


}
if(isset($_REQUEST["index"]))
{ 
    header("Refresh:0; url=index.php");
    


}
?>
<html lang="en">
<head>
<meta charset="UTF-8">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="assets/css/all.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Encode+Sans+Expanded:wght@400;700&family=Teko:wght@500&display=swap" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <script>
        function popup(){
    // Get the modal
    
    var modal = document.getElementById("updateappointment");
    
 
    // Get the <span> element that closes the modal
    var span = document.getElementsByClassName("close")[0];
    modal.style.display = "block";

    
    // When the user clicks on <span> (x), close the modal
    span.onclick = function() {
      modal.style.display = "none";
    }
    
    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function(event) {
      if (event.target == modal) {
        modal.style.display = "none";
      }
    }
    
    }
    
    </script>

</head>
<body>
    


    <div class="main">
    <div class="navbar">
     <div class="logo"><h3>DietPlan</h3></div>
     <div class="navlinks">
        <form action="" class="nav buttons" method="post">
     <button  name="index" class="nav_btn"> Index </button>
     <button name="logout" class="nav_btn"> Logout </button>
     
</form>

     </div>
     
    </div>
        
    <div class="backdrop">
    </div>
    <div class="backdrop-oval">
    </div>
    
    <div class="tokenwrapper">
        
       <table>
       <tr>
       <th> Name</th>
        <th> Date</th>
        <th> Time</th>
        <th> Appointment Details</th>
        <th> Appointment Token</th>
       </tr> 
      
                                    
                      <tr  >
                      <td> <?php echo $row['name'];?></td>
                        <td> <?php echo $row['date'];?></td>
                        <td> <?php echo $row['time'];?></td>
                        <td> <?php echo $row['appoint_details'];?></td>
                        <td> <?php echo $row['token'];?></td>
                        <td><button onClick="popup()" > Update</button></td>
                        <form>
                        <input type="hidden" value="<?php echo $row['token'];?>" name="tokenid">
                        <td><button name="delete">Delete</button></td> 
</form>
                      </tr>
                     

       
       
       <table>

       <div id="updateappointment"  class="modal">
            <!-- Modal content -->
            <div class="modal-content">
                <span class="close">&times;</span>
               
                    
                    <!-- popup form  -->
                    <div id="container">
                        <!--This is a division tag for body container-->
                        <div id="body_header">
                          <!--This is a division tag for body header-->
                          <h1>Appointment Request Form</h1>
                          <p>Make your appointments more easier</p>
                    
                        </div>
                        <form action="#" method="post">
                     
                          <fieldset>
                            <legend><span class="number">2</span>Appointment Details</legend>
                           
                           
                            <label for="date">Date*:</label>
                            <input type="date" name="date" >                            <br>
                            <label for="time">Time*:</label>
                            <input type="time" name="time" >
                            <br>
                            <input type="hidden" value="<?php echo $row['token'];?>" name="tokenid">
                          </fieldset>
                        
                          
                         <button type="submit" name="update" >Request For Appointment</button>
                           
                         
                         
                            
                        </form>
                       
                      </div>
                      <!-- form ends here  -->


            </div>

        </div> 
 </div>
</div>


    </div>
 
 

</body>
</html>
