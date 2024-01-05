<?php
// Create connection
include("connectdb.php");

// Escape and quote the values
$name = mysqli_real_escape_string($con, $_POST['name']);
$email = mysqli_real_escape_string($con, $_POST['email']);
$contact = mysqli_real_escape_string($con, $_POST['contact']);
$subject = mysqli_real_escape_string($con, $_POST['subject']);
$message = mysqli_real_escape_string($con, $_POST['message']);

$sql = "INSERT INTO inquiry (Name, Email, phoneNo, Subject, Description)
        VALUES ('$name', '$email', '$contact', '$subject', '$message')";

if (!mysqli_query($con, $sql)) {
    die('Error: ' . mysqli_error($con));
}

mysqli_close($con);
header("Location: ../view/contact.php?submitted=true");
exit();
?>
