<?php 
include("connectdb.php");

$sql="CREATE TABLE Diagnose(
  diagnoseID int NOT NULL AUTO_INCREMENT PRIMARY KEY,
  today_date DATETIME DEFAULT CURRENT_TIMESTAMP,
  diagnosis VARCHAR(300) NOT NULL,
  description VARCHAR(300) NOT NULL,
  startdate DATE NOT NULL,
  enddate DATE NOT NULL,
  user_id int NOT NULL,
  doctor_id int NOT NULL,
  FOREIGN KEY (user_id) REFERENCES user_profiles(user_id),
  FOREIGN KEY (doctor_id) REFERENCES doctor_profiles(doctor_id)
)";
mysqli_query($con, $sql);

mysqli_close($con);

?>