<?php
session_start();
include("../database/connectdb.php");
include("doctorHeader.php");

if(!isset($_SESSION['userID'])){
  header("Location:../database/signin_form.php");
  exit();
}
?>

<html>
  <head>
    <title>About Us</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../css/about.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  </head>

  <body>
    <div class="heading">
      <h1>About Us</h1>
      <hr>
    </div>

    <section class="about-us">
      <img src="../images/about.jpg">
      <div class="content">
        <h2>UniHealth UTM Timeline</h2>
        <p>Pusat Kesihatan Universiti (PKU) UTM was established in 1972 to provide medical care and health facilities to ensure the university’s 
          community (students and staffs) health and well-being. During this time, the unit was managed by four medical doctors, a dentist and several other support staff and assisted by a trained clinical staff.
        </p><br>
        <p>
          Beginning from September 1993, PKU UTM was officially recognized as a panel clinic for the UTM employees. Under this regulation, all UTM employees can have access to the PKU health and medical services. 
          In addition, PKU UTM also provides facilities to perform services outside of the community such as students, workers and visitors, to private universities.
        </p>
        <a href="https://studentaffairs.utm.my/healthcentre/about-us-2/" target="_blank" class="read-more-btn">Read More</a>
      </div>
    </section>

    <div class="container">
      <div class="header">
        <h1>Meet Our Doctors</h1>
      </div>
      <div class="sub-container">

      <div class="teams">
        <img src="../images/shaliza.jpg" alt="doctorAD">
        <div class="name">Dr. Shahliza Abd Halim</div>
        <div class="desig">B. MED. SC, MD (UKM), M. S. ORL-HEAD & NECK (UKM)</div>
        <div class="about">Specialty: ENT (Head & Neck Surgery)</div>
      </div>

      <div class="teams">
        <img src="../images/dr.jpg"  alt="doctorAD">
        <div class="name">PM DR MOHD YAZID BIN IDRIS</div>
        <div class="desig">MD (USM), MS ORTHO (MAL), FELLOW OF SPINE SURGERY UNIVERSITY OF TOHOKO, JAPAN</div>
        <div class="about">Specialty: Orthopaedic Surgery</div>

      
      </div>
      
      

      <div class="teams">
        <img src="../images/shahida.jpg"  alt="doctorAD">
        <div class="name"> Associate Prof. Dr. Shahida Sulaiman</div>
        <div class="desig">MD (USM), MRCP (UK) Board of Nephrology (MAL)</div>
        <div class="about">Specialty: General Medicine</div>
      </div>

    </div>
    </div>
  </body>