<?php 
include("connectdb.php");

$sql="CREATE TABLE Diagnose(
  diagnoseID int NOT NULL AUTO_INCREMENT PRIMARY KEY,
  diagnosis VARCHAR(300) NOT NULL,
  description VARCHAR(300) NOT NULL,
  startdate DATE NOT NULL,
  enddate DATE NOT NULL,
  appointID int NOT NULL,
  FOREIGN KEY (appointID) REFERENCES appointment(appointID)
)";
mysqli_query($con, $sql);

mysqli_close($con);

?>