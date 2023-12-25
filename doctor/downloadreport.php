<?php
ob_start();
session_start();

include("../database/connectdb.php");



$diagnose = '';
$description='';
$startdate='';
$enddate='';
$today = date('M j, Y');

if(isset($_GET['appointID'])){
  $appointID = $_GET['appointID'];

  $sqlDiagnose="SELECT * FROM diagnose WHERE appointID=$appointID";
  $resultDiagnose = mysqli_query($con, $sqlDiagnose);


  if($resultDiagnose && mysqli_num_rows($resultDiagnose)> 0){
    $diagnoseData = mysqli_fetch_assoc($resultDiagnose);
    $diagnose = $diagnoseData['diagnosis'];
    $description = $diagnoseData['description'];
    $startdate = $diagnoseData['startdate'];
    $enddate = $diagnoseData['enddate'];
  }

  $sqlUser="SELECT u.*, a._date, a._time
  FROM user u
  INNER JOIN appointment a ON u.userID=a.user_id
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
    <style>
      /*Google Font */
@import url('https://fonts.googleapis.com/css2?family=Roboto+Condensed:wght@400;700&display=swap');

.logo{
  width:300px;
  margin: 20px;
}

body{
  margin: 0;
  padding:0;
  font-size:16px;
  font-weight:300;
  width:100%;
  background: #DBE2EF;
  font-family:'Roboto Condensed', sans-serif;
}

h2, h4, p{
  margin: 0;
}

.page {
  background:#fff;
  display:block;
  margin:3rem auto 3rem auto;
  position:relative;
  box-shadow: 0 0 5px rgba(0,0,0,0.5);
  width: 21cm; /* Add this line */
  height: 29.7cm; /* Add this line */;
  
}

.page[size="A4"]{
  width:21cm;
  height:29.7cm;
  overflow-x:hidden;
}

/*Top Section */
.top-section{
  color:#fff;
  padding:20px;
  height:130px;
  background-color: #112D4E;
}

.top-section h2{
  font-size:42px;
  margin-bottom:13px;
  font-weight:510;
}

.top-section .contact,
.top-section .address{
  width:50%;
  height:100%;
  float: left;
}

.top-section .address-content{
  max-width: 190px;
}

.contact .contact-content{
  max-width:250px;
  margin-top:66px;
  float:right;
}

/*Billing Invoice */
.billing-invoice{
  padding:20px;
  font-size:20px;
  margin-bottom:15px;
}

.billing-invoice .title{
  font-weight:600;
  float:left;
}

.billing-invoice .des{
  font-weight:400;
  float:right;
}

.billing-invoice .code{
  font-weight:200;
  text-align:left;
}

.billing-invoice .issue{
  text-align:left;
  font-size:15px;
}

/*Billing To*/
.billing-to{
  padding:20px;
}

.billing-to .title{
  font-weight:400;
  font-size: 20px;
  margin-bottom: 7px;

}

.billing-to .billing-sec{
  width:50%;
  font-size:18px;
  margin-bottom:25px;
}


.form .title{
  font-weight: 500;
  margin-bottom: 20px;
  font-size: 20px;
}

.form .title b{
  margin-bottom: 80px;
  font-size: 20px;
}


.input-field {
  display: flex;
  align-items: center;
  margin-bottom: 10px; /* Add some spacing between each input field */
  
}

.input-field label {
  flex: 1; /* Make the label take up available space */
  
  margin-right: 10px; /* Add some spacing between label and input field */
  
}

.input-field input {
  flex: 2; /* Make the input field take up available space */
  margin-right: 30px;
  border-radius: 3px;
  border: 1px solid #989696;
  height: 22px;
  padding: 0 15px;
}

.details {
  margin-top: 20px;
  padding:20px 0;
}

.details .title {
  font-weight: 500;
  margin-bottom: 20px;
  margin-top: 10px;
  font-size: 20px;
  display: block; /* Make the title a block element */
}

.details .input-field {
  display: flex;
  align-items: center;
  margin-bottom: 19px;
}

.details label {
  flex: 1;
  margin-right: 10px;
}

.details input {
  flex: 2;
  border-radius: 3px;
  border: 1px solid #989696;
  height: 72px;
  padding: 0 15px;
  width: 100%; /* Make the input field take up 100% width */
  box-sizing: border-box; /* Include padding and border in the element's total width and height */
}


/*.details {
  background-color: #f9f9f9;
  border: 1px solid #ccc;
  padding: 10px;
  margin-bottom: 20px;
}

*/

.sijil-fields .title{
  justify-content: center;
  text-align: center;
  margin-top: 10px;
  margin-bottom: 20px;
}

.third{
  background-color: #F9F7F7;
  border:1px solid #ccc;
  padding:15px;
  height:250px;
}

.sijil-fields .input-field{
  text-align: left;
  justify-content: center;
  line-height: 2;
  
}


.address{
  float: right;
  margin-bottom: 25px;
}


      </style>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE-edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src=
"https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.2/jspdf.min.js">
    </script>
    <script src="https://html2canvas.hertzen.com/dist/html2canvas.min.js"></script>

    <link rel="stylesheet" href="../css/report.css">
    
    <title>Patient Report</title>

  </head>

  <body>
    <div class="page" size="A4">
      <div class="top-section">
        <div class="address">
          <div class="address-content">
           <!--<img src="../images/LOGO.png" class="logo">-->
            <h2>UniHealth </h2>
            <p>Pusat Kesihatan Universiti,
              Universiti Teknologi Malaysia,
              81110 Johor Bahru,<br>
              Johor Darul Ta’zim.</p>
          </div>
        </div>

        <div class="contact">
          <div class="contact-content">
            <div class="email">Email: <span class="span">
             &nbsp;pku@utm.my
            </span></div>

            <div class="number">Contact:<span class="span">
              &nbsp;+607 553 7233
            <br>
            Emergency (24 hours):&nbsp;+607 553 0999
            </span></div>
          </div>
        </div>
        </div>
    
        <div class="billing-invoice">
          <div class="title">
            UniHealth Medical Report
          </div>
          <div class="des">
          
            <p class="issue"><span><?php echo $today?> </span></p>
          </div>

        </div>


        <!--Billed to-->
        <div class="billing-to">
         
       

        <div class="form">
            <div class="title"><b>Personal Details</b></div>
            <div class="fields">
              <div class="input-field">
                <label>Full Name</label>
                <input type="text" name="full_name" id="full_name" value="<?php echo $name; ?>" readonly>
              </div>

              <div class="input-field">
                <label>Age</label>
                <input type="text" name="age" id="age" value="<?php echo $age; ?>" readonly>
              </div>

              <div class="input-field">
                <label>Email</label>
                <input type="text" name="email" id="email" value="<?php echo $email; ?>" readonly>
              </div>

              <div class="input-field">
                <label>Phone Number</label>
                <input type="text" name="phone" id="phone" value="<?php echo $phone;?>" readonly>
              </div>

              <div class="input-field">
                <label>Gender</label>
                <input type="text" name="gender" id="gender" value="<?php echo $gender;?>"readonly>
              </div>

              <div class="input-field">
                <label>Appointment Date and Time</label>
                <input type="text" value="<?php echo $date . '. ' . $time; ?>" readonly>
              </div>

            </div>
        </div>
        <div class="fields">
          <div class="details ID">
            <div class="title"><b>Diagnose Details</b></div>
            <div class="input-field">
              <label for="diagnose">Diagnose:</label>
              <input type="text" name="diagnose" id="diagnose" rows="4" value="<?php echo $diagnose;?>" readonly>
            </div>

            <div class="input-field">
              <label for="description">Summary:</label>
              <input type="text" name="description" id="description" rows="4" value="<?php echo $description; ?>" readonly>
            </div>
            
          </div>
          <hr style="margin-bottom: 30px; border: none; border-top: 1px dotted #0c0c0c;">
        </div>

  <div class="sijil-fields">
    <div class="third">
        <div class="title"><b><u>Medical Certificate</u></b></div>
        <div class="input-field">
            <p>I have examined Mr./Mrs./Miss:&nbsp; &nbsp; <b><?php echo $name; ?></b>&nbsp; &nbsp;
            on the appointment of&nbsp; &nbsp; <b><?php echo $date . '. ' . $time; ?></b> &nbsp;<br>
              found that he/she is unfit for duty/attend school from  &nbsp; <b><?php echo $startdate; ?></b> &nbsp; to
            <b> <?php echo $enddate; ?></b>  &nbsp; <br>for days
            <?php 
            $datetime1 = new DateTime($startdate);
            $datetime2 = new DateTime($enddate);
            $interval = $datetime1->diff($datetime2);
            echo $interval->format('<b>%a days</b>');
            ?>.</p>

        </div>
        <div class="address">
        <h4 style="font-size:15px;">UniHealth </h4>
            <p style="font-size:15px;">Pusat Kesihatan Universiti,</p>
              <p style="font-size:15px;">Universiti Teknologi Malaysia,</p>
              <p style="font-size:15px;">81110 Johor Bahru,</p>
              <p style="font-size:15px;"> Johor Darul Ta’zim.</p>
</div>
    </div>
    
</div>

          </div>


    </div>
       
    <script>
         // Wrap the download logic in a function
    function downloadPDF() {
      html2canvas(document.querySelector(".page")).then(function(canvas) {
        let pdf = new jsPDF();
        pdf.addImage(canvas.toDataURL('image/jpeg'), 'JPEG', 0, 0, 210, 297);
        pdf.save("Patient Report.pdf");
      });
    }

    // Trigger the download function when the page loads
    window.onload = function() {
      downloadPDF();
    };


    </script>
</html>