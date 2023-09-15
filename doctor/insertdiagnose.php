<?php
ob_start();
session_start();

include("doctorHeader.php");
include("../database/connectdb.php");


if(isset($_GET['appointID'])){
  $appointID = $_GET['appointID'];

  
  // Get the diagnoseID from the URL
  if(isset($_GET['diagnoseID'])){
    $diagnoseID = $_GET['diagnoseID'];
  } else {
    // If diagnoseID is not in the URL, you might handle this case accordingly (e.g., set it to a default value)
    $diagnoseID = null; // You can set it to an appropriate default value if needed
  }


  $sqlUser="SELECT up.* , u.email, a._date, a._time
  FROM user_profiles up
  INNER JOIN appointment a ON up.user_id=a.user_id
  INNER JOIN User u ON up.user_id = u.userID
  WHERE a.appointID = $appointID";

  $resultUser = mysqli_query($con, $sqlUser);

  if(!$resultUser) {
    $errorMsg = "Error: " . mysqli_error($con);
  }

  if($resultUser && mysqli_num_rows($resultUser)>0){
    $userData=mysqli_fetch_assoc($resultUser);
    $name=$userData['full_name'];
    $age=$userData['age'];
    $gender=$userData['gender'];
    $phone=$userData['phone'];
    $email = $userData['email'];
    $date = $userData['_date']; 
    $time = $userData['_time'];
  } else {
    $errorMsg="Error: Unable to retrieve user information.";
  }
} else {
  $errorMsg="Error: No appointID provided in the session";
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
    <div class="container">
      <header>Patient Diagnose Form</header>

      <form action="diagnose.php" method="POST">

        <div class="form first">
          <div class="details personal">
            <span class="title"><b>Personal Details<b></span>

            <div class="fields">
              <div class="input-field">
              <label>Full Name</label>
              <input type="text" name="full_name" id="full_name" value="<?php echo $name; ?>"  readonly>
              </div>

            <div class="input-field">
            <label>Age</label>
            <input type="text" name="age" id="age" value="<?php echo $age; ?>"placeholder="Enter your birth date" readonly>
            </div>

          <div class="input-field">
          <label>Email</label>
          <input type="text"name="email" id="email" value="<?php echo $email; ?>" placeholder="Enter your email" readonly>
          </div>


        <div class="input-field">
          <label>Phone Number</label>
          <input type="text" name="phone" id="phone" value="<?php echo $phone;?>"placeholder="Enter your phone number" readonly>
        </div>

        <div class="input-field">
        <label>Gender</label>
        <input type="text" name="gender" id="gender"value="<?php echo $gender;?>"placeholder="Enter your gender" readonly>
      </div>

    
      <div class="input-field">
      <label>Today's Date and Time</label>
      <input type="text" value="<?php echo $date . '. ' . $time; ?>" readonly>
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
            <span class="title"><b>Sijil Cuti Sakit Purpose</b> [If there is only 1day just insert the same date]</span>

            <div class="fields" style="margin:30px;">

              <div class="input-field">
              <label>Start Date</label>
              <input type="date" name="start_date" required>
              </div>

            <div class="input-field">
            <label>End Date</label>
            <input type="date" name="end-date" required>
            </div>

         
          </div>

        </div>

        <input type="hidden" name="appointID" value="<?php echo $appointID; ?>">
        <input type="hidden" name="diagnoseID" value="<?php echo $diagnoseID; ?>">



       
    
        <div class="buttons">
          <div class="backBtn">
            <i class="uil uil-navigator"></i>
            <span class="btnText">Back</span>
          </div>
  
          <input type="hidden" name="editMode" value="true">

          <button class="submit">
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