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
    email VARCHAR(100) NOT NULL,
    phone VARCHAR(20),
    matric_no VARCHAR(20),
    street VARCHAR(100),
    city VARCHAR(50),
    state VARCHAR(50),
    zip_code VARCHAR(10),
    FOREIGN KEY (user_id) REFERENCES User (userID)
)";
mysqli_query($con, $sql);

$sql = "CREATE TABLE doctor (
    doctor_id INT PRIMARY KEY AUTO_INCREMENT,
    full_name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    phone VARCHAR(20),
    matric_no VARCHAR(20),
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
        Description VARCHAR(300)
    )";
mysqli_query($con, $sql);

mysqli_close($con);

?>
