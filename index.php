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


$patient_id = $_SESSION["patient_id"];

$fsql = "SELECT * FROM `bmitables` WHERE patient_id =  $patient_id ";
$fresult= mysqli_query($con,$fsql);
$row= mysqli_fetch_assoc($fresult);

if($row){

}
else{
echo "no";
}


$diet_range = $row['diet_range'];
$dsql = "SELECT * FROM `dietplan` WHERE dietid = '$diet_range'";
$dresult= mysqli_query($con,$dsql);


if(isset($_REQUEST["appoint"]))
{ 
$aname = $_REQUEST['name'];
$aemail = $_REQUEST['email'];
$adate = $_REQUEST['date'];
$atime = $_REQUEST['time'];
$aappoint_details = $_REQUEST['appoint_details'];

$pages = range(100000,900000);
shuffle($pages);
$hrid = array_shift($pages);



if( $aname !== "" && $adate !== "" && $atime !== "" && $aappoint_details !== "" ){

if(mysqli_num_rows(mysqli_query($con,"select * from `appoint` where date='$adate' && time = '$atime' "))>0) {
    echo '<script>alert("Please choose different date & time" to " Appointment is not available on this date & time, so please choose an alternative date & time ")</script>';    

}
else{
   
$asql = "INSERT INTO `appoint`(`id`, `name`,`email`, `userid`, `date`, `time`, `appoint_details`, `token`) VALUES ('','$aname','$aemail','$patient_id','$adate','$atime','$aappoint_details','$hrid') ";
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
  
  
  $mail->setFrom('viwinnithyanand2310@gmail.com', 'Diet Plan');

$mail->addAddress($aemail);// user mail             


$mail->isHTML(true);                                 
$mail->Subject = 'Your Appointment Details';
$mail->Body    = "<b>Hello</b> <br>".$aname." <br> Your Appointment on  ".$adate." ".$time." Has been confirmed. Your Appointment token is".$hrid."<br><br><b>Here are your Appointment Details</b> -  ".$aappoint_details."<br> See You Soon";
$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

$mail->send();
echo '<script>alert("Your Appointment confirmed and mail sent ")</script>';
header('refresh:1; url:index.php');
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
if(isset($_REQUEST["check_appoint"]))
{ 
  header('location:appoint.php');
}
if(isset($_REQUEST["logout"]))
{ 
  session_destroy();
  header('location:login.php');
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
    <title>Dietplan</title>

    <script>
        function popup(){
    // Get the modal
    
    var modal = document.getElementById("myModal");
    
 
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
     <div class="logo"><h3>DoctorDiet</h3></div>
     <div class="navlinks">
      <form action="" method="post"> <button name="check_appoint" class="nav_btn"> Appointent Details </button> <button name="logout" class="nav_btn"> Logout </button></form>
     


     </div>
     
    </div>
        
    <div class="backdrop">
    </div>
    <div class="backdrop-oval">
    </div>
    

    <div class="detailswrapper">
    <table>
            <tr>
            <!-- Table Heading -->
            <th>Name</th>
            <th>Age</th>
            <th>lifestyle</th>
            <th>weight</th>
            <th>Sex</th>
            <th>BMI Value</th>
            <th>BMI Category</th>
        </tr>
        <tr>
<td><?php echo $row['name']; ?></td>
<td><?php echo $row['age']; ?></td>
<td><?php echo $row['lifestyle']; ?></td>
<td><?php echo $row['weight']; ?></td>
<td><?php echo $row['sex']; ?></td>
<td><?php echo $row['bmi']; ?></td>
<td><?php echo $row['bmi_category']; ?></td>

        </tr>


            </table>
            
       
    </div>
    <div class="detailswrapper">
    <table>
            <tr>
            <!-- Table Heading -->
            <th>Breakfast</th>
            <th>Lunch</th>
            <th>Dinner</th>
                    </tr>
                    <?php while($drow= mysqli_fetch_assoc($dresult))
                                    {
                                    ?>
                                    <form action="" method="post">
                      <tr  >
                        <td><textarea> <?php echo $drow['Breakfast'];?></textarea> </td>
                        <td> <textarea> <?php echo $drow['Lunch'];?></textarea></td>
                        <td><textarea> <?php echo $drow['Dinner'];?></textarea> </td>
                        
                      </tr>
                      </form>
                      <?php
                       }
                      ?>

            </table>
            
    </div>
    <br>
    <div class="appointment_btn" >
    <button onClick="popup()" > Book An Appointment</button>
</div>
<div id="myModal" style="background-color: rgba(255, 255, 0, 0.301);" class="modal">
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
                           
                            <label for="Name">Name:</label>
                            <input name="name" type="text" placeholder="Name" >
                            <label for="Name">Email:</label>
                            <input name="email" type="email" placeholder="email" >
                            <label for="appointment_description">Appointment Description:</label>
                            <textarea id="appointment_description" name="appoint_details" placeholder="I wish to get an appointment ..."></textarea>
                            <label for="date">Date*:</label>
                            <input type="date" name="date" >                            <br>
                            <label for="time">Time*:</label>
                            <input type="time" name="time" >
                            <br>
                         
                          </fieldset>
                        
                          
                         <button type="submit" name="appoint" >Request For Appointment</button></li>
                           <button  >Skip</button></li>
                         
                         
                            
                        </form>
                       
                      </div>
                      <!-- form ends here  -->


            </div>

        </div> 
 </div>
</div>
</body>
</html>
