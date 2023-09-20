<?php
session_start();
include("../database/connectdb.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $diagnoseID = mysqli_real_escape_string($con, $_POST['diagnoseID']); 
    $diagnosis = mysqli_real_escape_string($con, $_POST['diagnose']);
    $description = mysqli_real_escape_string($con, $_POST['description']);
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end-date'];
    $appointID = $_POST['appointID'];
    $editMode = isset($_POST['editMode']) && $_POST['editMode'] == 'true';

    if (empty($diagnosis) || empty($description) || empty($start_date) || empty($end_date) || empty($appointID)) {
        echo "Error: Please fill in all required fields.";
    } else {
        // Check if the appointID already exists in the database
        $checkSql = "SELECT * FROM Diagnose WHERE appointID = '$appointID'";
        $result = mysqli_query($con, $checkSql);

        if (!$result) {
            echo "Error checking appointID: " . mysqli_error($con);
        } else {
            $rowCount = mysqli_num_rows($result);

            if ($editMode && $rowCount > 0) {
                // Update operation
                $updateSql = "UPDATE Diagnose SET diagnosis = '$diagnosis', description = '$description',
                    startdate = '$start_date', enddate = '$end_date' WHERE appointID = '$appointID'";

                if (mysqli_query($con, $updateSql)) {
                    echo "<script>alert('Updated successfully.'); window.location.href='doctorManageAppoint.php';</script>";
                } else {
                    echo "Error updating diagnosis: " . mysqli_error($con);
                }
            } else {
                // Insert operation
                $sql = "INSERT INTO Diagnose (diagnosis, description, startdate, enddate, appointID) 
                        VALUES ('$diagnosis', '$description', '$start_date', '$end_date', '$appointID')";

                if (mysqli_query($con, $sql)) {
                    echo "<script>alert('This patient\'s appointment diagnosis has been inserted successfully.'); 

                    window.location.href='doctorManageAppoint.php';
                    </script>";
                } else {
                    echo "Error inserting diagnosis: " . mysqli_error($con);
                }
            }
        }
    }

    mysqli_close($con);
} else {
    echo "Invalid request. Please submit the form.";
}

?>
