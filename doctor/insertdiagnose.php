<?php
ob_start();
session_start();
include("doctorHeader.html");
include("../database/connectdb.php");

    if(isset($_GET['appointID'])){
      $appointID=$_GET['appointID'];

      $sqlUser="SELECT * FROM user_profiles
                INNER JOIN appointment ON user_profiles.user_id=appointment.user_id
                INNER JOIN diagnose ON appointment.appointID = diagnose.appointID
                WHERE appointment.appointID = $appointID";

      $resultUser = mysqli_query($con, $sqlUser);

      if($resultUser && mysqli_num_rows($resultUser)>0){
        $userData=mysqli_fetch_assoc($resultUser);
        $name=$userData['full_name'];
        $age=$userData['age'];
        $gender=$userData['gender'];
      }else{
        $errorMsg="Error: Unable to retrieve user information.";
      }
    }else{
      $errorMsg="Error: No appointID provided in the URL";
    }
  


?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="../css/diagnose.css">

    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">

    <title>Insert Patient Diagnose Form</title>
  </head>

  <body>
   <?php 
   
   ?>

    <div class="container">
      <header>Patient Diagnose Form</header>

      <form action="#">
        <div class="form first">
          <div class="details personal">
            <span class="title"><b>Personal Details<b></span>

            <div class="fields">

            <!--<td><label for="foodName">Name: </label></td>
                            <td><input type="text" name="foodName" id="foodName" value="<?php echo $name?>" required/></td>
                        </tr>-->
              <div class="input-field">
              <label>Full Name</label>
              <input type="text" name="full_name" id="full_name" value="<?php echo $name; ?>" placeholder="Enter your name" required>
              </div>

            <div class="input-field">
            <label>Age</label>
            <input type="number" name="age" id="age"placeholder="Enter your birth date" required>
            </div>

          <div class="input-field">
          <label>Email</label>
          <input type="text"name="email" id="email" placeholder="Enter your email" required>
          </div>


        <div class="input-field">
          <label>Phone Number</label>
          <input type="text" name="phone" id="phone" placeholder="Enter your phone number" required>
        </div>

        <div class="input-field">
        <label>Gender</label>
        <input type="text" name="gender" id="gender"placeholder="Enter your gender" required>
      </div>

      <div class="input-field">
      <label>Today's Date</label>
      <input type="text" placeholder="Enter your age" required>
      </div>


          </div>

        </div>


        <div class="fields">

        <div class="details ID">
          <span class="title" style="margin: 10px 0;"><b>Diagnose Details</b></span>
          <table>
            <tr>
              <td style="font-size:13px; font-weight:500; color:#341111;"><label for="diagnose">Diagnose:</label></td>
              <td><textarea name="diagnose" id="diagnose" rows="4" required></textarea></td>
            </tr>

            <tr>
              <td style="font-size:13px; font-weight:500; color:#341111;"><label for="description">Summary: </label></td>
              <td><textarea name="description" id="description" rows="4" required></textarea></td>
            </tr>
          </table>

      

        


        </div>
    
        <button class="nextBtn">
          <span class="btnText">Next</span>
          <i class="uil uil-navigator"></i>
        </button>
      </div>
        </div>


        <div class="form second">
          <div class="details mc">
            <span class="title"><b>Sijil Cuti Sakit Purpose</b> [No need to fill in If there is not necessary to have it]</span>

            <div class="fields" style="margin:30px;">

              <div class="input-field">
              <label>Start Date</label>
              <input type="date"  placeholder="Enter start date for MC" required>
              </div>

            <div class="input-field">
            <label>End Date</label>
            <input type="date" placeholder="Enter your end date for MC" required>
            </div>

         
          </div>

        </div>



       
    
        <div class="buttons">
          <div class="backBtn">
            <i class="uil uil-navigator"></i>
            <span class="btnText">Back</span>
          </div>
  
          <button class="sumbit">
            <span class="submit">Submit</span>
            <i class="uil uil-navigator"></i>
          </button>
        </div>
      </div>
        </div>



        

        
      </form>
    </div>

    <script src="../js/diagnose.js"></script>

  </body>
</html>