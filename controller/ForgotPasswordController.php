<?php

session_status() === PHP_SESSION_ACTIVE ? TRUE : session_start();
include_once("./model/UserModel.php");

class ForgotPasswordController{

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
            case 'verifyEmail' :                    
                $this->verifyEmail();
                break;
            case 'saveNewPassword':
                $this->saveNewPassword();
                break;												
            default:
                $this->index();
        }
    }	

    public function verifyEmail(){
        if(isset($_POST["recover"])){
            $email = $_POST["email"];

            $isEmailExist = $this->userModel->checkEmailExistence($email);

            if(!$isEmailExist){
                echo '<script>';
                echo 'alert("Sorry, no emails exist");';
                echo 'window.location.href = "./view/recover_psw.php";';
                echo '</script>';
            } else {
                // generate token by binaryhexa 
                $token = bin2hex(random_bytes(50));

                $_SESSION['token'] = $token;
                $_SESSION['email'] = $email;

                require "Mail/phpmailer/PHPMailerAutoload.php";
                $mail = new PHPMailer;

                $mail->isSMTP();
                $mail->Host='smtp.gmail.com';
                $mail->Port=587;
                $mail->SMTPAuth=true;
                $mail->SMTPSecure='tls';

                // h-hotel account
                $mail->Username='ting02@graduate.utm.my';
                $mail->Password='ting@881608';

                // send by h-hotel email
                $mail->setFrom('ting02@graduate.utm.my', 'Password Reset');
                // get email from input
                $mail->addAddress($_POST["email"]);
                //$mail->addReplyTo('lamkaizhe16@gmail.com');

                // HTML body
                $mail->isHTML(true);
                $mail->Subject="Recover your password";
                $mail->Body="<b>Dear User</b>
                <h3>We received a request to reset your password.</h3>
                <p>Kindly click the below link to reset your password</p>
                http://localhost/utm/AppDev/Application-Development/reset_psw.php
                <br><br>
                <p>With regrads,</p>
                <b>Programming with Lam</b>";

                if (!$mail->send()) {
                    echo '<script>';
                    echo 'alert("Invalid Email");';
                    echo 'window.location.href = "./view/recover_psw.php";';
                    echo '</script>';
                } else {
                    header("Location: ./view/notification.html");
                    exit();
                }
            }

        }
        
    }

    public function saveNewPassword(){
        if (isset($_SESSION["token"]) && isset($_SESSION["email"])) {
            $Email = $_SESSION['email'];
        
            if (isset($_POST["reset"])) {
                $psw = $_POST["password"];
        
                $hash = password_hash($psw, PASSWORD_DEFAULT);
        
                $isEmailExist = $this->userModel->checkEmailExistence($Email);
        
                if ($isEmailExist) {
                    $new_pass = $hash;
                    $status = $this->userModel->updatePassword($Email, $new_pass);
                    echo '<script>';
                    echo 'alert("Your password has been successfully reset");';
                    echo 'window.location.replace("./view/signin.php");';
                    echo '</script>';
                } else {
                    echo '<script>';
                    echo 'alert("Please try again");';
                    echo 'window.location.replace = "./view/reset_psw.php";';
                    echo '</script>';
                }
                
            }
        } else {
            // Handle the case where "token" or "email" is not set in the session
            // You may want to redirect the user or display an error message
            echo "Session data is missing. Please check your session handling logic.";
        }
    }

    public function logout(){
        
    }
}

?>