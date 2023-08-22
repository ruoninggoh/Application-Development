<?php
//create connection
include("connectdb.php");
$sql = "INSERT INTO contactForm (Name, Email, phoneNo, Subject, Description)
VALUES ('$_POST[name]','$_POST[email]','$_POST[phone]','$_POST[subject]','$_POST[description]')";
if (!mysqli_query($con, $sql)) {
    die('Error: ' . mysqli_connect_error());
}

mysqli_close($con);
header("Location:../user/contactuser.php?submitted=true");
exit();
?>