<?php
include("connectdb.php");

$hashedPassword = password_hash('staff123', PASSWORD_DEFAULT);
$hashedPassword1 = password_hash('doctor123', PASSWORD_DEFAULT);
$hashedPassword2 = password_hash('12345678', PASSWORD_DEFAULT);



$sql = "CREATE TABLE User (
        userID int NOT NULL AUTO_INCREMENT PRIMARY KEY,
        username varchar(50),
        email varchar(100),
        password varchar(250),
        role varchar(250),
        CONSTRAINT UC_User_Username UNIQUE (username),
        CONSTRAINT UC_User_Email UNIQUE (email)
    )";

if (mysqli_query($con, $sql)) {
    echo 'Table created successfully';
} else {
    echo 'Error creating table: ' . mysqli_error($con);
}

$sql = "INSERT INTO user (userID, username, email, password, role)
        VALUES (1, 'staff', 'staff@graduate.utm.my', '$hashedPassword', 'Staff'), (2, 'doctor', 'doctor@graduate.utm.my', '$hashedPassword1', 'Doctor'), (3, 'jiauting','jiauting@graduate.utm.my', '$hashedPassword2', 'Patient')";



if (mysqli_query($con, $sql)) {
    echo "Users has been added to the database successfully.<br>";
} else {
    echo "Error: " . mysqli_error($con) . "<br>";
}






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
if (mysqli_query($con, $sql)) {
    echo 'Table created successfully';
} else {
    echo 'Error creating table: ' . mysqli_error($con);
}


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
if (mysqli_query($con, $sql)) {
    echo 'Table created successfully';
} else {
    echo 'Error creating table: ' . mysqli_error($con);
}



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
if (mysqli_query($con, $sql)) {
    echo 'Table created successfully';
} else {
    echo 'Error creating table: ' . mysqli_error($con);
}



$sql = "CREATE TABLE contactForm (
        contactFormID INT NOT NULL AUTO_INCREMENT,
        PRIMARY KEY (contactFormID),
        Name VARCHAR(191),
        Email VARCHAR(191),
        phoneNo VARCHAR(20),
        Subject VARCHAR(50),
        Description varchar(300)
    )";
if (mysqli_query($con, $sql)) {
    echo 'Table created successfully';
} else {
    echo 'Error creating table: ' . mysqli_error($con);
}




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
if (mysqli_query($con, $sql)) {
    echo 'Table created successfully';
} else {
    echo 'Error creating table: ' . mysqli_error($con);
}




$sql="CREATE TABLE Diagnose(
    diagnoseID int NOT NULL AUTO_INCREMENT PRIMARY KEY,
    diagnosis VARCHAR(300) NOT NULL,
    description VARCHAR(300) NOT NULL,
    startdate DATE NOT NULL,
    enddate DATE NOT NULL,
    appointID int NOT NULL,
    FOREIGN KEY (appointID) REFERENCES appointment(appointID)
  )";
if (mysqli_query($con, $sql)) {
    echo 'Table created successfully';
} else {
    echo 'Error creating table: ' . mysqli_error($con);
}


$sql="CREATE TABLE dashboard(
    id INT AUTO_INCREMENT PRIMARY KEY,
    image VARCHAR(255) NOT NULL,
    title VARCHAR(100) NOT NULL,
    description TEXT NOT NULL
    )";
  
    if(mysqli_query($con, $sql)){
      echo 'Table created successfully';
  
    }else{
      echo 'Error creating table: '.mysqli_error($con);
    };
  
    $dashboard=array(
      array(
        'title' => 'STEPS TO PREVENT ILLNESS',
        'description' => 'The spread of respiratory diseases like COVID-19 can be alarming, but you can help minimize their impact. By following these simple guidelines from the Centers for Disease Control and Prevention (CDC), you’ll help keep more people in our community safe and healthy:
          <br><br>
          
          -->>Avoid close contact with people who are sick<br>
          -->>Wash your hands regularly with soap and water for a least 20 seconds<br>
          -->>Avoid touching your eyes, nose and mouth<br>
          -->>Stay home if you are sick, unless you need medical care<br>
          -->>Wear a facemask if you are ill and in contact with others<br>
          -->>Cover your nose and mouth with a tissue or inside of your elbow when you cough and sneeze, then dispose of the tissue immediately and wash your hands<br>
          -->>Clean and disinfect frequently touched surfaces daily including doorknobs, light switches, countertops, handles, desks, phones, keyboards, toilets, faucets, sinks, etc.<br>
          ',
          'image'=>'info1.png'
        )
        );
  
        foreach ($dashboard as $item) {
          $title = mysqli_real_escape_string($con, $item['title']);
          $description = mysqli_real_escape_string($con, $item['description']);
          $image = mysqli_real_escape_string($con, $item['image']);
        
          $sql = "INSERT INTO dashboard (title, description, image) VALUES ('$title', '$description', '$image')";
        
          if (mysqli_query($con, $sql)) {
            echo 'Data inserted successfully<br>';
          } else {
            echo 'Error inserting data: ' . mysqli_error($con) . '<br>';
          }
        }
  


?>
