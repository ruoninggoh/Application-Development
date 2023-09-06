<?php
    session_start();

    if(isset($_SESSION['doctor_id'])){
        $doctor_id = $_SESSION['user_id'];
    } else {
        echo "Error: You are not logged in";
        exit();
    }
    $conn = mysqli_connect("localhost", "root", "", "unihealth");

    if(!$conn){
        die("Connection failed: " . mysqli_connect_error());
    }

    if ($_SERVER["REQUEST_METHOD"] === "POST"){
        $appointID = mysqli_real_escape_string($conn, $_POST["appointID"]);
        $status = mysqli_real_escape_string($conn, $_POST["status"]);
        $sql = "UPDATE appointment SET requestStatus = ?, doctor_id = ? WHERE appointID = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "sii", $status, $doctor_id, $appointID);

        if (mysqli_stmt_execute($stmt)){
            echo "success";
        } else {
            echo "error: " . mysqli_error($conn);
        }

        mysqli_stmt_close($stmt);
    }
?>