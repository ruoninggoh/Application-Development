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
            case 'getProfileInfo':
                $this->getProfileInfo();
                break;
            case 'insertUser' :                    
                $this->insertUser();
                break;											
            default:
                $this->index();
        }
    }	

    
}

?>