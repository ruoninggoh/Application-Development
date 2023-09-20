<?php
//create connection
include("connectdb.php");
$sql = "INSERT INTO contactForm (Name, Email, phoneNo, Subject, Description)
VALUES ('$_POST[name]','$_POST[email]','$_POST[contact]','$_POST[subject]','$_POST[message]')";
if (!mysqli_query($con, $sql)) {
    die('Error: ' . mysqli_connect_error());
}

mysqli_close($con);
header("Location: ../contact.php?submitted=true");
exit();
?>