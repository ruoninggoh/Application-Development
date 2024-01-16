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
        
        $status = mysqli_query($this->con, "UPDATE User SET password='$password' WHERE email='$email'");

        return $status;
    }

    public function addUser($username, $password, $email, $role){
        $status = "none";

        $newUsername = mysqli_real_escape_string($this->con, $username);
        $newEmail = mysqli_real_escape_string($this->con, $email);
        $newPassword = mysqli_real_escape_string($this->con, $password);
        $newRole = mysqli_real_escape_string($this->con, $role);

        if (strpos($newEmail, "@graduate.utm.my") === false) {
            return "emailFormatError";
        }
    
        $emailExistsQuery = "SELECT COUNT(*) FROM User WHERE email = '$newEmail'";
        $usernameExistsQuery = "SELECT COUNT(*) FROM User WHERE username = '$newUsername'";
    
        $emailExistsResult = mysqli_query($this->con, $emailExistsQuery);
        $usernameExistsResult = mysqli_query($this->con, $usernameExistsQuery);
    
        if (!$emailExistsResult || !$usernameExistsResult) {
            // echo "Error checking email and username existence: " . mysqli_error($con);
            return "error";
        }
    
        $emailExists = mysqli_fetch_row($emailExistsResult)[0];
        $usernameExists = mysqli_fetch_row($usernameExistsResult)[0];
    
        if ($emailExists > 0) {
            $status = "emailExist";
            
        } elseif ($usernameExists > 0) {
            $status = "usernameExist";
        }
        
        
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

        $sqlAddUser = "INSERT INTO User (username, email, password, role) 
                    VALUES ('$newUsername', '$newEmail', '$hashedPassword', '$newRole')";

        if (mysqli_query($this->con, $sqlAddUser)) {
            $status = "success";
        } else {
            
            return "error";
        }

        return $status;
    }
        
    public function editUser($userID, $username, $email, $role){
        $status = "none";

        $newUsername = mysqli_real_escape_string($this->con, $username);
        $newEmail = mysqli_real_escape_string($this->con, $email);
        $userID = mysqli_real_escape_string($this->con, $userID);
        $newRole = mysqli_real_escape_string($this->con, $role);

        if (strpos($newEmail, "@graduate.utm.my") === false) {
            return "emailFormatError";
        }

        $checkUsernameQuery = "SELECT COUNT(*) FROM User WHERE username = '$newUsername' AND userID != '$userID'";
        $checkEmailQuery = "SELECT COUNT(*) FROM User WHERE email = '$newEmail' AND userID != '$userID'";

        $usernameExistsResult = mysqli_query($this->con, $checkUsernameQuery);
        $emailExistsResult = mysqli_query($this->con, $checkEmailQuery);

        if (!$usernameExistsResult || !$emailExistsResult) {
            //echo "Error checking username and email existence: " . mysqli_error($con);
            return "error";
        }
    
        $emailExists = mysqli_fetch_row($emailExistsResult)[0];
        $usernameExists = mysqli_fetch_row($usernameExistsResult)[0];
    
        if ($emailExists > 0) {
            return "emailExist";
            
        } elseif ($usernameExists > 0) {
            return "usernameExist";
        }

        $sqlUpdateUser = "UPDATE User SET username = '$newUsername', email = '$newEmail', role = '$newRole' WHERE userID = '$userID'";
        if (mysqli_query($this->con, $sqlUpdateUser)) {
            return "success";
        } else {
            return "error";
        }

        return $status;
    }
    
    public function delete($userID){
        $status = "none";

        $sqlDeleteUser = "DELETE FROM User WHERE userID = '$userID'";
        if (mysqli_query($this->con, $sqlDeleteUser)) {
            mysqli_commit($this->con);
            $successMessage = "User deleted successfully.";
            return "success";
            
        } else {
            return "error";
            
        }
    } 
    
}