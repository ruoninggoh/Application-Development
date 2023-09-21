<?php
include("connectdb.php");

$sql = "CREATE TABLE User (
        userID int NOT NULL AUTO_INCREMENT PRIMARY KEY,
        username varchar(50),
        email varchar(100),
        password varchar(250),
        role varchar(250),
        CONSTRAINT UC_User_Username UNIQUE (username),
        CONSTRAINT UC_User_Email UNIQUE (email)
    )";

mysqli_query($con, $sql);

// Create the User table first, then create the user_profiles table with the foreign key reference
$sql = "CREATE TABLE user_profiles (
    user_id INT PRIMARY KEY AUTO_INCREMENT,
    picture VARCHAR(100) NOT NULL,
    full_name VARCHAR(100) NOT NULL,
    phone VARCHAR(20),
    gender VARCHAR(20),
    age VARCHAR(20),
    street VARCHAR(100),
    city VARCHAR(50),
    state VARCHAR(50),
    zip_code VARCHAR(10),
    FOREIGN KEY (user_id) REFERENCES User (userID)
)";
mysqli_query($con, $sql);
$sql = "CREATE TABLE admin_profiles (
    admin_id INT PRIMARY KEY AUTO_INCREMENT,
    picture VARCHAR(100) NOT NULL,
    full_name VARCHAR(100) NOT NULL,
    phone VARCHAR(20),
    gender VARCHAR(20),
    age VARCHAR(20),
    street VARCHAR(100),
    city VARCHAR(50),
    state VARCHAR(50),
    zip_code VARCHAR(10),
    FOREIGN KEY (admin_id) REFERENCES User (userID)
)";
mysqli_query($con, $sql);

$sql = "CREATE TABLE doctor_profiles (
    doctor_id INT PRIMARY KEY AUTO_INCREMENT,
    picture VARCHAR(100) NOT NULL,
    full_name VARCHAR(100) NOT NULL,
    phone VARCHAR(20),
    gender VARCHAR(20),
    age VARCHAR(20),
    street VARCHAR(100),
    city VARCHAR(50),
    state VARCHAR(50),
    zip_code VARCHAR(10),
    FOREIGN KEY (doctor_id) REFERENCES User (userID)
)";
mysqli_query($con, $sql);

$sql = "CREATE TABLE contactForm (
        contactFormID INT NOT NULL AUTO_INCREMENT,
        PRIMARY KEY (contactFormID),
        Name VARCHAR(191),
        Email VARCHAR(191),
        phoneNo VARCHAR(20),
        Subject VARCHAR(50),
        Description textarea(300)
    )";
mysqli_query($con, $sql);


$sql = "CREATE TABLE Appointment (
    appointID int NOT NULL AUTO_INCREMENT PRIMARY KEY,
    _date DATE NOT NULL,
    _time TIME NOT NULL,
    reason varchar(150) NOT NULL,
    requestStatus varchar(30) DEFAULT 'Pending',
    user_id int NOT NULL,
    doctor_id int,
    FOREIGN KEY (user_id) REFERENCES user_profiles(user_id)
)";
mysqli_query($con,$sql);

mysqli_close($con);



?>
