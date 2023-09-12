<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  include("../database/connectdb.php");

    $diagnosis = mysqli_real_escape_string($con, $_POST['diagnose']);
    $description = mysqli_real_escape_string($con, $_POST['description']);
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end-date'];
    $appointID = $_POST['appointID']; 

   
    $checkSql = "SELECT * FROM Diagnose WHERE appointID = '$appointID'";
    $checkResult = mysqli_query($con, $checkSql);

    if ($checkResult) {
        if (mysqli_num_rows($checkResult) > 0) {
            echo "<script>alert('This form already insert for this appointment.'); window.location.href='doctorManageAppoint.php';</script>";
        } else {
            // Insert data into Diagnose table
            $sql = "INSERT INTO Diagnose (diagnosis, description, startdate, enddate, appointID) 
                    VALUES ('$diagnosis', '$description', '$start_date', '$end_date', '$appointID')";

            if (mysqli_query($con, $sql)) {
                echo "<script>alert('Diagnosis and description inserted successfully.'); window.location.href='doctorManageAppoint.php';</script>";
            } else {
                echo "Error: " . mysqli_error($con);
            }
        }
    } else {
        echo "Error: " . mysqli_error($con);
    }

    mysqli_close($con);
} else {
    echo "Invalid request. Please submit the form.";

}
?>
