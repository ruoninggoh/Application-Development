<!DOCTYPE html>
<html lang="en">
<head>
  <title>User Dashboard</title>
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
    include("userHeader.html");
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
                      <a href="">
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
                      <a href="">
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
                      <a href="">
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
                <!--php-->
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
                         <!-- <?php    echo $appointmentrow ->num_rows  ?>-->
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
                         <!--  <?php    echo $schedulerow ->num_rows  ?>-->
                      </div><br>
                      <div class="h3-dashboard" >
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


        <td>
          <p style="font-size:20px; font-weight:800;padding-left:40px;padding-top:30px;"class="anime">Your Upcoming Booking&nbsp;
          <img src="../images/calendar.svg" style="padding-bottom:5px;">
        </p>
          <center>
            <div class="abc scroll" style="height:250px;padding:0;margin:0;padding-left:50px">
            <table width="85%" class="sub-table scrolldown" border="0">
              <thead>
                <tr>
                  <th class="table-headin">
                    Appointment No
                  </th>
                  
                  <th class="table-headin">
                    Session Title
                  </th>

                  <th class="table-headin">
                    Scheduled Date 
                  </th>
                
                  </tr>

              </thead>

              <tbody>
              <!--
                <?php
                $nextweek=date("Y-m-d", strtotime("+1 week"));
                //php

                if($result->num_rows==0){
                  echo '<tr>
                  <td colspan="4">
                  <br><br><br><br>
                  <center>
                  <img src="../images/notfound.svg" width="25%">
                  </td>
                  </tr>';
                }
                ?>

              -->

                  


          
        
        </td>
      </tr>
    </table>
  </td>
</tr>







</div>
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