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

    // Attempt to delete the user from the User table
    $sqlDeleteUser = "DELETE FROM User WHERE userID = '$userID'";
    if (mysqli_query($con, $sqlDeleteUser)) {
        // If the user was deleted from User table, delete related profiles
        $sqlDeleteProfiles = "DELETE FROM user_profiles WHERE user_id = '$userID'";
        if (mysqli_query($con, $sqlDeleteProfiles)) {
            // Both deletions were successful, commit the transaction
            mysqli_commit($con);
            $successMessage = "User deleted successfully.";
        } else {
            // Error deleting profiles, rollback the transaction
            mysqli_rollback($con);
            echo "Error deleting user profiles: " . mysqli_error($con);
        }
    } else {
        // Error deleting user, no need to delete profiles, rollback the transaction
        mysqli_rollback($con);
        echo "Error deleting user: " . mysqli_error($con);
    }
}

mysqli_close($con);
?>

<!DOCTYPE html>
<html>
<head>
    <!-- Include your HTML head content here -->
</head>
<body>
    <!-- Include your HTML body content here -->
    
    <?php
    if (!empty($successMessage)) {
        echo "<script>alert('$successMessage'); window.location.href = 'userManagement.php';</script>";
    }
    ?>
</body>
</html>
