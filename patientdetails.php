<?php
session_start();
require ('dbconnection.php');
if(isset($_POST['submit']))
{    
     $name = $_REQUEST['name'];
     $email = $_REQUEST['email'];
     $pid = $_SESSION["patient_id"];
     $age = $_REQUEST['age'];
     $sex = $_REQUEST['sex'];
     $weight = $_REQUEST['weight'];
     $height = $_REQUEST['height'];
     $fluid = $_REQUEST['fluid'];
     $lifestyle = $_REQUEST['lifestyle'];
     $allergy = $_REQUEST['allergy'];
     $bmi= ($weight*10000)/($height*$height);
    $category="";
    $diet_range="";
    //  finding category of bmi
    if($bmi<18.5)
    {
        $category = "Underweight";
        $diet_range = "range_1";

    }
   else if(18.5<=$bmi && $bmi <=24.9)
    {
        $category = "Normal Weight";
        $diet_range = "range_2";
    }
    else if(25<=$bmi && $bmi <=29.9)
    {
        $category = "Overweight";
        $diet_range = "range_2";
    }
    else if(30<=$bmi && $bmi <=35)
    {
        $category = "Obese";
        $diet_range = "range_3";
    }
    else if (35 <= $bmi)
    {
    $category = "Extremely obese";
    $diet_range = "range_3";

    }
     
     $sql = "INSERT INTO `bmitables`(`id`, `name`, `patient_id`, `email`, `sex`, `age`, `weight`, `lifestyle`, `allergies`, `fluid`, `bmi`, `bmi_category`, `diet_range`) VALUES ('0','$name','$pid','$email','$sex','$age','$weight','$lifestyle','$allergy','$fluid','$bmi','$category','$diet_range')";
     if (mysqli_query($con, $sql)) {
        echo '<script>alert("We have recorded your data please check the dietplan below ")</script>';    
        header('location:index.php');
    
    } else {
        echo "Error: " . $sql . ":-" . mysqli_error($con);
     }
     
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
    <div class="detailswrapper">
        <div class="form-wrapper">
            <h2>Welcome To DoctorDiet </h2>
            
            <form class="signup-form" action="#" method="post">
                
            <input type="text" name="name"  class="signup-inputs" placeholder=" Name ">
            
            <div class="horizontal-fields">
            <input type="number" name="age" class="small-signup-inputs" placeholder="Age">
            <div class="spacer"></div>
            <select name="sex" class="">
<option>Sex</option>
<option value="male">Male</option>
<option value="female">Female</option>

</select>
</div>
            
            <input type="email" name="email"  class="signup-inputs" placeholder="Email Address">
            <div class="horizontal-fields">
            <input type="number" name="weight" class="small-signup-inputs" placeholder="Weight">
            <div class="spacer"></div>
            <input type="number" name="height" class="small-signup-inputs" placeholder="Height">
</div>
<select name="lifestyle" class="">
<option>Lifestyle</option>
<option value="sedentary">Sedentary</option>
<option value="moderate">Moderate</option>
<option value="active">Active</option>
</select>
<select name="allergy" class="">
<option>Food Allergies</option>
<option value="yes">yes</option>
<option value="no">no</option>
</select>
<select name="fluid" class="">
<option>Fluid Intake</option>
<option value="2">2L</option>
<option value="3">3L</option>
<option value="4">4L</option>
<option value="5">5L</option>
<option value="6">6L</option>
<option value="7">7L</option>
<option value="8">8L</option>
<option value="9">9L</option>
</select>



            <div class="button-wrapper">
                <button class="log-btn" type="submit" name="submit">Next</button>
                
            </div>
            
            </form>

        </div>
       
    </div>
</div>
</body>
</html>
