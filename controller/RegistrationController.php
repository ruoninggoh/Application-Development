<?php

session_status() === PHP_SESSION_ACTIVE ? TRUE : session_start();
include_once("./model/UserModel.php");

class RegistrationController{

    function __construct(){
        $this->config = new config();
        $this->userModel = new UserModel($this->config);
    }

    public function index(){
        header("Location: ./view/main.php");
    }

    public function actionHandler() 
    {
        $action = isset($_POST['action']) ? $_POST['action'] : null;

        if ($action === null) {
            $action = isset($_GET['action']) ? $_GET['action'] : 'index';
        }

        $action = $action ?: 'index';
        switch ($action) 
        {
            case 'validate':
                $this->validate();
                break;
            case 'insertUser' :                    
                $this->insertUser();
                break;											
            default:
                $this->index();
        }
    }	

    public function validate(){

        if (isset($_POST["registerSubmit"])) {
            $username = $_POST['username'];
            $password = $_POST['password'];
            $confirmPassword = $_POST['confirmPassword']; // Add this line
            $email = $_POST['email'];

            if ($password !== $confirmPassword) {
                // Passwords don't match, redirect to signup page with error message
                header("Location: ../signup.php?error=password_mismatch");
                exit();
            }

            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $check = $this->userModel->checkDuplicate($username, $confirmPassword, $email);

            if ($check[0] == true) {
                echo '<script>alert("Username \'' . $username . '\' is already taken. Please choose another username.");
                    window.location.href = "./view/signup.php";</script>';
            } elseif ($check[1] == true) {
                echo '<script>alert("Email \'' . $email . '\' is already registered. Please use a different email.");
                    window.location.href = "./view/signup.php";</script>';
            } elseif ($check[2] == true) {

                $success = $this->userModel->insertUser($username, $hashedPassword, $email);
                if($success){
                    echo '<script>';
                    echo 'var signInAgain = confirm("Sign up successful. Please sign in again.");';
                    echo 'if (signInAgain) {';
                    echo '  window.location.href = "./view/signin.php";';
                    echo '}';
                    echo '</script>';
                }
                
            }

        } 
    }

    
}

?>