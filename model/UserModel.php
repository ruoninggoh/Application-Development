<?php

session_status() === PHP_SESSION_ACTIVE ? TRUE : session_start();

class UserModel{
    
    private $userID;
    private $username;
    private $email;
    private $password; 
    private $role; 
    private $full_name;
    private $picture;
    private $phone;
    private $gender; 
    private $age;
    private $street;
    private $city;
    private $state; 
    private $zip_code;
    
    function __construct($consetup)
    {
        $this->host = $consetup->host;
        $this->user = $consetup->user;
        $this->pass =  $consetup->pass;
        $this->db = $consetup->db;
        $this->open_db();        					
    }

    public function open_db()
    {
        $this->con = new mysqli($this->host,$this->user,$this->pass,$this->db);
        if ($this->con->connect_error) 
        {
            die("Erron in connection: " . $this->con->connect_error);
        }
    }

    public function insertUser($username, $hashedPassword, $email){
        $defaultRole = "Patient";
        $username = mysqli_real_escape_string($this->con, $username);
        $hashedPassword = mysqli_real_escape_string($this->con, $hashedPassword);
        $email = mysqli_real_escape_string($this->con, $email);
        $signupSuccessful = false;
        $insertQuery = "INSERT INTO User(username, password, email, role)
                        VALUES ('$username', '$hashedPassword', '$email', '$defaultRole')";

        if (!mysqli_query($this->con, $insertQuery)) {
            die('Error: ' . mysqli_error($this->con));
        } else {
            $signupSuccessful = true;
        }

        return $signupSuccessful;
    }

    public function findUser($username, $password, $role){
        
        $sql = "SELECT * FROM User WHERE username='$username' AND role='$role'";
        $result = mysqli_query($this->con, $sql);
        $user = mysqli_fetch_assoc($result);

        if ($user && password_verify($_POST['password'], $user['password'])) {
            $_SESSION['login'] = "YES";
            $_SESSION['userID'] = $user['userID'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['role'] = $user['role']; // Assuming role is stored as 'role' in the User table
            $userid=$_SESSION['userID'];

            $role = $user['role'];

        } else {
            $role = "";
        }

        return $role;

    }

    public function checkDuplicate($username, $password, $email){
        $checkUsernameQuery = "SELECT username FROM User WHERE username = '$username'";
        $checkUsernameResult = mysqli_query($this->con, $checkUsernameQuery);
        $usernameTaken=false;
        $emailTaken = false;
        $unique = false;
        if (mysqli_num_rows($checkUsernameResult) > 0) {
            // Username already exists, set a flag
            $usernameTaken = true;
        } 

        // Check if the email already exists
        $checkEmailQuery = "SELECT email FROM User WHERE email = '$email'";
        $checkEmailResult = mysqli_query($this->con, $checkEmailQuery);
        if (mysqli_num_rows($checkEmailResult) > 0) {
            $emailTaken = true;
        } 

        if(!$usernameTaken && !$emailTaken){
            $unique = true;
        }

        return array($usernameTaken, $emailTaken, $unique);

    }

    public function checkEmailExistence($email) {
        
        $sql = mysqli_query($this->con, "SELECT * FROM User WHERE email='$email'");
        $query = mysqli_num_rows($sql);
        $fetch = mysqli_fetch_assoc($sql);
        $emailExist = false;
    
        if ($query <= 0) {
            $emailExist = false;
            
        } else {
            $emailExist = true;
        }

        return $emailExist;
    }
    
    public function updatePassword($email, $password) {
        
        $status = mysqli_query($this->con, "UPDATE User SET password='$new_pass' WHERE email='$Email'");

        return $status;
    }

}