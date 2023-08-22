<?php
    $con = mysqli_connect("localhost", "Tan", "abc123","appointDB");
    if (!$con){
        die("Could not connect" . mysqli_connect_error($con));
    }
    $sql = "CREATE TABLE Appointment(
        appointID int NOT NULL AUTO_INCREMENT, PRIMARY KEY(appointID),
        _date DATE NOT NULL,
        _time TIME NOT NULL,
        reason varchar(150) NOT NULL,
        requestStatus varchar(30) DEFAULT 'Pending'),
        user_id int NOT NULL,
        doctor_id int,
        FOREIGN KEY (user_id) REFERENCES user_profiles(user_id)";
        

    mysqli_query($con,$sql);
?>