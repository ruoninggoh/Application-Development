<?php

session_status() === PHP_SESSION_ACTIVE ? TRUE : session_start();
include_once("./model/UserModel.php");

class LoginController{

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
            case 'index':
                $this->index();
                break;
            case 'validateUser' :                    
                $this->validateUser();
                break;
            case 'logout':
                $this->logout();
                break;												
            default:
                $this->index();
        }
    }	

    public function validateUser(){

        if (isset($_POST["loginSubmit"])) {
            $role = $_POST["selectedRole"];
            $username = $_POST["username"];
            $providedPassword = $_POST["password"];

            $role = $this->userModel->findUser($username, $providedPassword, $role);

            if($role != ""){
                if ($role == 'Patient') {
                    header("Location: ./user/userdashboard.php");
                } elseif ($role == 'Doctor') {
                    header("Location: ./doctor/dashboard.php");
                } elseif ($role == 'Staff') {
                    header("Location: ./admin/dashboard.php");
                }
            } else {
                $error = "<script>
                    var signInAgain = confirm('Wrong Username/ Password/ Role! Please try again...'); 
                    if (signInAgain) {
                        window.location.href = './view/signin.php';
                    }
                </script>";
                echo $error;
            }  

        } else {
            $error = "<script>
                var signInAgain = confirm('Wrong Username/ Password/ Role! Please try again...'); 
                if (signInAgain) {
                    window.location.href = './view/signin.php';
                } 
            </script>";
            echo $error;
        }
    }

    public function validateUserRole(){}

    public function logout(){
        $_SESSION = array();

        session_destroy();

        header("Location: ./view/main.php");
    }
}

?>