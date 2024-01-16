<?php
session_start();
include('../database/connectdb.php');

if (!isset($_SESSION['userID'])) {
    header("Location: ../signin.php");
    exit();
}

$successMessage = '';

if (isset($_GET['userID'])) {
    $userID = mysqli_real_escape_string($con, $_GET['userID']);

    // Start a transaction
    mysqli_begin_transaction($con);

    try {
        // Attempt to delete the user from the User table
        $sqlDeleteUser = "DELETE FROM User WHERE userID = '$userID'";
        if (mysqli_query($con, $sqlDeleteUser)) {
            // User deleted successfully, commit the transaction
            mysqli_commit($con);
            $successMessage = "User deleted successfully.";
            if (!empty($successMessage)) {
                echo "<script>alert('$successMessage'); window.location.href = '../admin/userManagement.php';</script>";
            }
        } else {
            // Error deleting user, rollback the transaction
            throw new Exception("Error deleting user: " . mysqli_error($con));
        }
    } catch (Exception $e) {
        // Handle exceptions here (you can log or display an error message)
        echo $e->getMessage();
        mysqli_rollback($con);
    }
}

mysqli_close($con);
?>
