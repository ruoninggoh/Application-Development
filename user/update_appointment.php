<?php
    
    session_start();

    $con = mysqli_connect("localhost", "root", "", "unihealth");
        if (!$con) {
            die("Connection failed: " . mysqli_connect_error());
        }

    if ($_SERVER["REQUEST_METHOD"] === "POST"){
        $userID = $_SESSION['userID'];
        $newDate = mysqli_real_escape_string($con, $_POST['date']);
        $newTime = mysqli_real_escape_string($con, $_POST['time']);
        $newReason = mysqli_real_escape_string($con, $_POST['reason']);
        $appointment_id = mysqli_real_escape_string($con, $_POST['appointment_id']);
        $requestStatus = mysqli_real_escape_string($con, $_POST['requestStatus']);
        


        $count = 0;
        $checkQuery = "SELECT COUNT(*) AS count FROM appointment WHERE _date = ? && _time = ? && requestStatus = 'Approved'";
        /*$checkResult = mysqli_query($con, $checkQuery);
        

        if(mysqli_num_rows($checkResult)>0){
            echo "<script>alert('This time slot had been booked');</script>";
            header("Location:appointment_history.php");
        } else {
            $sql = "UPDATE appointment SET _date = '$newDate', _time = '$newTime', reason = '$newReason' WHERE user_id = $userID AND appointID = $appointment_id";

            if (mysqli_query($con, $sql)){
                echo "<script>alert('Edited successfully');</script>";
                echo "success";
                header(("Location:appointment_history.php"));
                exit;
            } else{
                echo "Error: " . mysqli_error(($con));
            }
        }*/
        if ($checkStmt = mysqli_prepare($con, $checkQuery)) {
            mysqli_stmt_bind_param($checkStmt, "ss", $newDate, $newTime);
            mysqli_stmt_execute($checkStmt);
            mysqli_stmt_bind_result($checkStmt, $count);
            mysqli_stmt_fetch($checkStmt);
            mysqli_stmt_close($checkStmt);
    
            if ($count > 0) {
                echo "<script>alert('This time slot had been booked');</script>";
                echo "<script>window.location.href = 'appointment_history.php';</script>";
            } else {
                if ($requestStatus == 'Pending'){
                $sql = "UPDATE appointment SET _date = ?, _time = ?, reason = ? WHERE user_id = ? AND appointID = ?";
                if ($stmt = mysqli_prepare($con, $sql)) {
                    mysqli_stmt_bind_param($stmt, "sssss", $newDate, $newTime, $newReason, $userID, $appointment_id);
                    if (mysqli_stmt_execute($stmt)) {

                        echo "<script>alert('Edited successfully');</script>";
                        echo "<script>window.location.href = 'appointment_history.php';</script>";
                        exit(); // Stop further script execution
                    } else {
                        echo "Error: " . mysqli_error($con);
                    }
                    mysqli_stmt_close($stmt);
                } else {
                    echo "Error: " . mysqli_error($con);
                }
            } else {
                echo "<script>alert('The request is no longer available');</script>";
                echo "<script>window.location.href = 'appointment_history.php';</script>";
            }
            }
        } else {
            echo "Error: " . mysqli_error($con);
        }
        
    } else{
        echo "Invalid request method";

    }

?>