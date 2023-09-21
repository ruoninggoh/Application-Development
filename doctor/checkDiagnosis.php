<?php
// Perform a database query to retrieve the diagnosis data for the given appointment ID
include("../database/connectdb.php");

$appointID = $_POST['appointID'];

// Example: Check if a record exists with the given appointment ID
$conn = mysqli_connect("localhost", "root", "", "unihealth");
if (!$conn) {
    die("Connection failed:" . mysqli_connect_error());
}

$sql = "SELECT diagnosis FROM diagnose WHERE appointID = $appointID";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    // Fetch the diagnosis data
    $row = mysqli_fetch_assoc($result);
    $diagnosisText = $row['diagnosis'];

    if (!empty($diagnosisText)) {
        // Diagnosis data is not empty, allow direct download
        echo "data_found";
    } else {
        // Diagnosis data is empty, show a message
        echo "blank";
    }
} else {
    // Diagnosis data does not exist
    echo "not_exists";
}

mysqli_close($conn);
?>
