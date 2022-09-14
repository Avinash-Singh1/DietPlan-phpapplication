<?php
require('dbconnection.php');
session_start();
if(isset($_REQUEST['signup'])){
    header('location:signup.php');
}
if(isset($_REQUEST['submit'])){

    $email = $_REQUEST["email"];
    $password = $_REQUEST["password"];
	$res=mysqli_query($con,"select * from `users` where email ='$email'");
	
	
	if(mysqli_num_rows($res)>0){
		$row=mysqli_fetch_assoc($res);
		$verify=password_verify($password,$row['password']);

       

		if($verify==1){

			$pid = $row['patient_id'];

            $qres=mysqli_query($con,"select * from `bmitables` where patient_id ='$pid'");
            if(mysqli_num_rows($qres)>0){
                $_SESSION['patient_id']=$pid; // session created on patients id 
                header('location:index.php');
			die();

            }
            else{
			$_SESSION['patient_id']=$pid;
            // echo $row['patient_id'];
			header('location:patientdetails.php');
			die();
            }
		}else{

            ?><script type="text/javascript">alert("Password Dosen't match");</script><?php   		}
	}
    else{

        ?><script type="text/javascript">alert("Username Dosen't match");</script><?php   	}
	
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
</head>
<body>
    <div class="main">
        
    <div class="backdrop">
    </div>
    <div class="backdrop-oval">
    </div>
    <div class="login_wrapper">
        <div class="form-wrapper">
            <h2>Welcome To DietPlan </h2>
            
            <form class="login-form" method="post">
            <label>Email </label>
            <input type="text" name="email" id="user-input" class="log-inputs" placeholder="Enter Email">
            <br>
            <label>Password  </i></label>
            <input type="Password" name="password" id="pass-input" class="log-inputs" placeholder="Enter Password">
            <div class="button-wrapper">
                <button class="log-btn" type="submit" name="submit">Login</button>
                <button class="log-btn signup" name="signup" >Signup</button>
            </div>
            </form>

        </div>
       
    </div>
</div>
</body>
</html>