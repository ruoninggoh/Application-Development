<?php
    $con = mysqli_connect("localhost", "Tan", "abc123");
    if (!$con){
        die("Could not connect" . mysqli_connect_error($con));
    }
    if(mysqli_query($con, "CREATE DATABASE appointDB")){
        echo "Database created successfully";
    }
    else{
        echo "Failed creating database";
    }
    mysqli_close($con);
?>