<?php
    session_start();
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        if (!isset($_SESSION["userID"])){
            header("Location:signin_form.php");
            exit();
        }
    }
    $date = $_POST["date"];
    $time = $_POST["time"];
    $reason = $_POST["reason"];

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "unihealth";

    $isSlotAvailable = checkTimeSlotAvailability($date,$time);

    if(!$isSlotAvailable){
        echo "<script>alert(The selected time slot is not available. Please choose another time slot)<script>";
        header("Location:../user/userdashboard.php");
    } else{
        $userid = $_SESSION["userID"]; // Retrieve user ID from session

        $conn = mysqli_connect($servername,$username,$password,$dbname);

        if(!$conn){
            die("Connection failed: ". mysqli_connect_error());
        }

        $sql = "INSERT INTO Appointment(_date, _time, reason,user_id) VALUES ('$date', '$time', '$reason', '$userid')";

        if (mysqli_query($conn,$sql)){
            echo "<script>alert('Appointment booked successfully'); window.location.href = '../user/userdashboard.php';</script>";

        } else{
            echo "Error: " . mysqli_error($conn);
        }
    }

    function checkTimeSlotAvailability($date, $time){
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "unihealth";

        $conn = mysqli_connect($servername, $username, $password, $dbname);
        if (!$conn){
            die("Connection failed: " . mysqli_connect_error());
        }

        $sql = "SELECT * FROM Appointment WHERE _date = '$date' AND _time = '$time'";
        $result = mysqli_query($conn, $sql);

        if(mysqli_num_rows($result) > 0){
            mysqli_close($conn);
            return false;
        } else{
            mysqli_close($conn);
            return true;
        }
    }
?>