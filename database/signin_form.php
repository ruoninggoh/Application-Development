<?php

session_start();
include("connectdb.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $role = $_POST["selectedRole"];
    $username = $_POST["username"];
    $providedPassword = $_POST["password"];

    $sql = "SELECT * FROM User WHERE username='$username' AND role='$role'";
    $result = mysqli_query($con, $sql);
    $user = mysqli_fetch_assoc($result);


    if ($user && password_verify($_POST['password'], $user['password'])) {
        $_SESSION['login'] = "YES";
        $_SESSION['userID'] = $user['userID'];
        $_SESSION['email'] = $user['email'];
        $_SESSION['role'] = $user['role']; // Assuming role is stored as 'role' in the User table
        $userid=$_SESSION['userID'];

        if ($user['role'] == 'Patient') {
            header("Location: ../user/userdashboard.php");
        } elseif ($user['role'] == 'Doctor') {
            header("Location: ../doctor/dashboard.php");
        } elseif ($user['role'] == 'Staff') {
            header("Location: ../admin/dashboard.php");
            if ($_SESSION['profileCompleted'] === 0) {
                header("Location: profile-edit.php");
                exit;
            } else {
        }}
        exit();

    } else {

        

        $error = "<script>
                var signInAgain = confirm('Wrong Username/ Password/ Role! Please try again...'); 
                if (signInAgain) {
                    window.location.href = '../signin.php';
                }
            </script>";
        echo $error;
    }
} else {


    $error = "<script>
            var signInAgain = confirm('Wrong Username/ Password/ Role! Please try again...'); 
            if (signInAgain) {
                window.location.href = '../signin.php';
            } 
        </script>";
    echo $error;
}

?>