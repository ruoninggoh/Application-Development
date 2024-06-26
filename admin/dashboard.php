<?php
session_start();

// Check for update success message
if (isset($_SESSION['update'])) {
    echo $_SESSION['update'];
    unset($_SESSION['update']); // Clear the message
}
if(isset($_SESSION['remove-failed'])){
  echo $_SESSION['remove-failed'];
  unset($_SESSION['remove-failed']);
}

// Check for MySQL error message
if (isset($_SESSION['mysql_error'])) {
    echo $_SESSION['mysql_error'];
    unset($_SESSION['mysql_error']); // Clear the message
}

if(isset($_SESSION['upload'])){
    echo $_SESSION['upload'];
    unset($_SESSION['upload']);
}


// ... rest of your dashboard.php code
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <title>Admin Dashboard</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="../css/userdashboard.css">
  
   <!-- slider stylesheet -->
   <link rel="stylesheet" type="text/css"
    href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.1.3/assets/owl.carousel.min.css" />

     <!-- font awesome style -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">


    <!-- bootstrap core css -->
  <link rel="stylesheet" type="text/css" href="../css/bootstrap.css" />

  <!-- fonts style -->
  <link href="https://fonts.googleapis.com/css?family=Poppins:400,600,700|Roboto:400,700&display=swap" rel="stylesheet">
  
  <!-- Custom styles for this template -->
  <link href="../css/style.css" rel="stylesheet" />
  <!-- responsive style -->
  <link href="../css/responsive.css" rel="stylesheet" />

</head>
<body>

  <div class="hero">
    <?php
    include("../database/connectdb.php");
    include("./adminHeader.html");
    /*

    if(isset($_SESSION['update'])){
        echo $_SESSION['update'];
        unset($_SESSION['update']);
    }
    if(!isset($_SESSION['userID'])){
      header("Location:../database/signin_form.php");
      exit();
    }
    */
    $userID = $_SESSION['userID'];
    $sqlProfile = "SELECT * FROM admin_profiles WHERE admin_id = $userID";
    $resultProfile = mysqli_query($con, $sqlProfile);
   
   if (mysqli_num_rows($resultProfile) === 0) {
       // User profile is empty, display confirmation message and redirect
       echo '<script>
           if (confirm("Your profile is empty. Do you must update your profile first.")) {
               window.location.href = "profile-edit.php";
           }
       </script>';
       // Additional logic or message if needed
   } 

    ?>
    <div class="dash-body" >
      <table>
      <tr>
        <td colspan="2" class="nav-bar">
        <button class="btn-label">
        <img src="../images/calendar.svg" >
  </button>
  <div class="date-wrapper">
        <b>Today's Date: 
            
            <?php
            date_default_timezone_set('Asia/Kuala_Lumpur');
            $today=date('Y-m-d');
            echo $today;

            $userrow=mysqli_query($con, "select*from user");
            $numUser=mysqli_num_rows($userrow);


            $doctorrow=mysqli_query($con,"select * from doctor_profiles");
            $numDoc=mysqli_num_rows($doctorrow);

            $numbooking=0;
            $bookingrow=mysqli_query($con, "select * from appointment");
            while($row=mysqli_fetch_assoc($bookingrow)){
              if(strtotime($row['_date'])>=strtotime(date('Y-m-d 00:00:00'))){
                $numbooking++;
              }
            }


            $numappointm = 0;
          $today = date('Y-m-d'); // Get the current date in 'Y-m-d' format

          // Use prepared statement to query appointments for the current day
          $query = "SELECT * FROM appointment WHERE DATE(_date) = ?";
          $stmt = mysqli_prepare($con, $query);
          mysqli_stmt_bind_param($stmt, 's', $today);
          mysqli_stmt_execute($stmt);
          $appointmentrow = mysqli_stmt_get_result($stmt);

          // Loop through the results and count the appointments
          while ($row = mysqli_fetch_assoc($appointmentrow)) {
            $numappointm++;
          }

          // Close the prepared statement
          mysqli_stmt_close($stmt);

            
            ?>
<b>
      </div>
        </td>
      </tr>
   
</table>
  </div>


  <!-- slider section -->
  
        
  <section class=" slider_section position-relative">
      <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
        <ol class="carousel-indicators">
          <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
          <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
          <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
        </ol>
        <div class="carousel-inner">
          <div class="carousel-item active">
            <div class="container">
              <div class="row">
                <div class="col-md-4">
                  <div class="img-box">
                    <img src="../images/pku.jpg" alt="">
                  </div>
                </div>
                <div class="col-md-8">
                  <div class="detail-box">
                    <h1>
                      Welcome To  <br>
                      <span >
                        UTM Health Centre
                      </span>

                    </h1>
                    <p ><br>
                    <b>Contact Us:</b>
                      <table>
                       
                      <tr>
                      <td>Counter: +6 07 553 7233<br></td>
                      </tr>
                      <tr>
                        <td>
                      Emergency (24 hours): +6 07 553 0999</td>
                      </tr>
                      </table>
                    </p>
                    <div>
                      <a href="./appointment_form.php">
                        Book an Appointment
                      </a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="carousel-item">
            <div class="container">
              <div class="row">
                <div class="col-md-4">
                  <div class="img-box">
                    <img src="../images/medicine.png" alt="">
                  </div>
                </div>
                <div class="col-md-8">
                  <div class="detail-box">
                    <h1>
                      Academic Week <br>
                      <span>
                        <b>Operating Hours</b> 
                      </span>

                    </h1>
                    <p>
                      <table>
                        <tr>
                          <td>SUNDAY to WEDNESDAY </td>
                          <td>8:00 AM - 5:00 PM</td>
                        </tr>

                          <tr>
                          <td>THURSDAY</td>
                          <td>8:00 AM - 3:30 PM </td>
                        </tr>
                        <tr>
                          <td>FRIDAY, SATURDAY</td>
                          <td>8:30 AM - 12:30 PM</td>
                        </tr>
                        <tr>
                          <td>PUBLIC HOLIDAY</td>
                          <td><b>CLOSE</b></td>
                        </table>
        
                    </p>
                    <div>
                      <a href="./appointment_form.php">
                       Book an Appointment
                      </a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="carousel-item">
            <div class="container">
              <div class="row">
                <div class="col-md-4">
                  <div class="img-box">
                    <img src="../images/doctor.jpg" alt="">
                  </div>
                </div>
                <div class="col-md-8">
                  <div class="detail-box">
                  <h1>
                     SEMESTER BREAK<br>
                      <span>
                        <b>Operating Hours</b> 
                      </span>

                    </h1>
                    <p>
                      <table>
                        <tr>
                          <td>SUNDAY to WEDNESDAY </td>
                          <td>8:00 AM - 10:00 PM</td>
                        </tr>

                          <tr>
                          <td>THURSDAY</td>
                          <td>8:00 AM - 10:00 PM </td>
                        </tr>
                        <tr>
                          <td>FRIDAY, SATURDAY</td>
                          <td>8:30 AM - 12:30 PM</td>
                        </tr>
                        <tr>
                          <td>PUBLIC HOLIDAY</td>
                          <td><b>CLOSE</b></td>
                        </table>
        
                    </p>
                    <div>
                      <a href="./appointment_form.php">
                        Book an Appointment
                      </a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
          <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
          <span class="sr-only">Next</span>
        </a>
      </div>


    </section>
    <!-- end slider section -->

<table style="margin-left:20px">
<tr>
  <td colspan="4">
    <table border="0" width="100%">
      <tr>
        <td width="50%">
          <center>
          <table class="filter-container">
      <tr>
          <td colspan="4">
              <p><b>Status</b></p>
          </td>
      </tr>

      <tr>
        <td style="width:25%">
          <div class="dashboard-items" >
            <div>
              <div class="h1-dashboard">
                <?php echo $doctorrow->num_rows ?>
              </div><br>
              <div class="h3-dashboard">
                All Doctors &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
              </div>
          </div>

            <div class="btn-icon-back1 dashboard-icons" >
          
          </div>
          </td>


        <td style="width: 25%;">
          <div  class="dashboard-items" >
              <div>
                      <div class="h1-dashboard">
                      <?php echo $userrow->num_rows ?>
                       
                      </div><br>
                      <div class="h3-dashboard">
                          All Patients &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                      </div>
              </div>
                      <div class="btn-icon-back2 dashboard-icons" ></div>
          </div>
      </td>
      </tr>
      <tr>
      <td style="width: 25%;">
          <div  class="dashboard-items" >
              <div>
                      <div class="h1-dashboard" >
                        <?php echo $numbooking;?>
                      </div><br>
                      <div class="h3-dashboard" >
                          NewBooking &nbsp;&nbsp;
                      </div>
              </div>
                      <div class="btn-icon-back3 dashboard-icons"></div>
          </div>
          
      </td>

      <td style="width: 25%;">
          <div  class="dashboard-items">
              <div>
                      <div class="h1-dashboard">
                      <?php echo $numappointm; ?>
                      </div><br>
                      <div class="h3-dashboard" style="font-size: 19px">
                          Today Sessions
                      </div>
              </div>
                      <div class="btn-icon-back4 dashboard-icons"></div>
          </div>
      </td>


      
      
  </tr>
</table>

            
          </center>
        </td>

        

        
       
        <table>
        <tr>

        <?php
            $result=mysqli_query($con, "SELECT * FROM dashboard");
            $count=mysqli_num_rows($result);
            $num=0;
            if($count!=0){
                while($row=mysqli_fetch_array($result, MYSQLI_ASSOC)){
                $id=$row['id'];
                $title=$row['title'];
                $description = $row['description']; // Fetch description from the database
                $image=$row['image'];
                $num++;
                
            ?>

        <div class="edit-button-container" style="text-align:right; padding-top:50px; padding-right:80px;">
        <a href="edit_dashboard.php?id=<?php echo $id; ?>"class="edit-button" style="background-color: #B31312;  color: #fff;
            border: none; padding: 10px 20px;   display: inline-block; border-radius: 5px;  font-size: 16px;  text-decoration: none;
            cursor: pointer;transition: background-color 0.3s ease;"
            onmouseover="this.style.backgroundColor='#E74646';"
            onmouseout="this.style.backgroundColor='#B31312';" >Edit Information</a>
        </div>

        
      
            <tr>

            <td colspan="4">
            <p style="padding-left: 35px;"><b> Additional Information </b></p>

                <div class="additional-content"style="padding:20px 40px;display:flex; align-items:center;">
                    <br><br>
                    <?php 
                    if($image==""){
                        echo"<div>Image is not added</div>";
                    }else{
                        echo"<img class='dashboardPhoto' src=../images/dashboard/$image />";

                    }
                    ?>
                    <div>
                        <h2 style="margin-left:50px; flex:1;"><b><?php echo $title ?></b></h2>
                        <p style="margin-left:50px;margin-right:20px; margin-top:40px;font-weight:40px;flex:1;"><?php echo $description?></p>
        </div>
        </div>
        </td>
        </tr>
        <?php
                }
            }
        ?>
        </table>
    
    


  </td>
  
</tr>



</div>



</body>
</html>

  <script>
    let subMenu=document.getElementById("subMenu");

    function toggleMenu(){
      subMenu.classList.toggle("open-menu");
    }
  </script>

<script type="text/javascript" src="../js/jquery-3.4.1.min.js"></script>
  <script type="text/javascript" src="../js/bootstrap.js"></script>
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.2.1/owl.carousel.min.js">
  </script>
  <script type="text/javascript">
    $(".owl-carousel").owlCarousel({
      loop: true,
      margin: 10,
      nav: true,
      navText: [],
      autoplay: true,
      responsive: {
        0: {
          items: 1
        },
        600: {
          items: 2
        },
        1000: {
          items: 4
        }
      }
    });
  </script>
  <script type="text/javascript">
    $(".owl-2").owlCarousel({
      loop: true,
      margin: 10,
      nav: true,
      navText: [],
      autoplay: true,

      responsive: {
        0: {
          items: 1
        },
        600: {
          items: 2
        },
        1000: {
          items: 4
        }
      }
    });
  </script>