<?php
require('dbconnection.php');
session_start();

  $patient_id = $_SESSION["patient_id"]; // patieint id capture through session 
  
  $qsql = "SELECT * FROM `appoint` WHERE userid = '$patient_id'";
  $res = mysqli_query($con,$qsql);

  
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
      <form>
       
     
     <button class="nav_btn" name="logout" > Logout  </button>

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
       <?php while($row= mysqli_fetch_assoc($res))
                                    {
                                      if(isset($_REQUEST['edit'])){
                                        $_SESSION['tokenid'] = $row['token']; // Sending token id through session 
                                        header('location:edit-appoint.php');
                                    }
                                    ?>
                                    
                      <tr  >
                        <form action="" method="post"> 
                      <td> <?php echo $row['name'];?></td>
                        <td> <?php echo $row['date'];?></td>
                        <td> <?php echo $row['time'];?></td>
                        <td> <?php echo $row['appoint_details'];?></td>
                        <td> <?php echo $row['token'];?></td>
                        <td><button name="edit">Edit</button> 
                        
                      </tr>
                      </form>
                      <?php
                       }
                      ?>

       
       
       <table>

      


    </div>
 
 

</body>
</html>
