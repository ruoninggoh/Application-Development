<?php

session_status() === PHP_SESSION_ACTIVE ? TRUE : session_start();
include_once("./model/UserModel.php");

class UserManagementController {

    public function __construct() {
        $this->config = new config();
        $this->userModel = new UserModel($this->config);
    }

    public function actionHandler() {
        $action = isset($_POST['action']) ? $_POST['action'] : null;

        if ($action === null) {
            $action = isset($_GET['action']) ? $_GET['action'] : 'index';
        }

        $action = $action ?: 'index';
        switch ($action) {
            case 'index':
                $this->index();
                break;
            case 'edituserform':
                $this->editUserForm();    
            case 'editUser':
                $this->editUser();
                break;
            case 'delete':
                $this->deleteUserPage();
                break;
            case 'add':
                $this->addUserForm();
                break;
            case 'addUser':
                $this->addUser();
                break;
            case 'delete':
                $this->deleteUser();
            default:
                $this->index();
        }
    }

    public function index() {
        header("Location: ./admin/userManagement.php");
    }

    public function editUserForm() {
        // Assuming you have user ID in the query parameter
        $userID = isset($_GET['userID']) ? $_GET['userID'] : null;

        if ($userID) {
            
            // Redirect to edit page with user details
            header("Location: ./admin/edit_user.php?userID={$userID}");
        } else {
            // Handle error or redirect to manage user page
            header("Location: ./admin/userManagement.php");
        }
    }

    public function deleteUserPage() {
        // Assuming you have user ID in the query parameter
        $userID = isset($_GET['userID']) ? $_GET['userID'] : null;

        if ($userID) {
            // Redirect to manage user page with a success or error message
            header("Location: ./database/delete_user.php?userID={$userID}");
        } else {
            // Handle error or redirect to manage user page
            header("Location: ./admin/userManagement.php");
        }
    }

    public function addUserForm() {
        // Redirect to the add user page
        header("Location: ./admin/add_user.php");
    }

    public function addUser(){
        
        $newUsername = isset($_POST['newUsername']) ? $_POST['newUsername'] : '';
        $newEmail = isset($_POST['newEmail']) ? $_POST['newEmail'] : '';
        $newPassword = isset($_POST['newPassword']) ? $_POST['newPassword'] : '';
        $newRole = isset($_POST['newRole']) ? $_POST['newRole'] : '';
        
        $status = $this->userModel->addUser($newUsername, $newPassword, $newEmail, $newRole);

        if ($status == "emailExist") {
            echo '<script>';
            echo 'alert("Email already exists. Please choose a different one.");';
            echo 'window.location.href = "./admin/add_user.php";';
            echo '</script>';
            exit();
        } elseif ($status == "usernameExist") {
            echo '<script>';
            echo 'alert("Username already exists. Please choose a different one.");';
            echo 'window.location.href = "./admin/add_user.php";';
            echo '</script>';
            exit();
        } elseif($status == "success"){
            echo '<script>';
            echo 'alert("New user successfully add!");';
            echo 'window.location.href = "./admin/userManagement.php";';
            echo '</script>';
        } elseif($status == "emailFormatError"){
            echo '<script>alert("Email must end with @graduate.utm.my");';
            echo 'window.location.href = "admin/add_user.php";';
            echo '</script>';
        } else{
            echo '<script>';
            echo 'alert("Error occur, please try again.");';
            echo 'window.location.href = "./admin/add_user.php";';
            echo '</script>';
        }
    }

    public function editUser(){
        $newUsername = isset($_POST['newUsername']) ? $_POST['newUsername'] : '';
        $newEmail = isset($_POST['newEmail']) ? $_POST['newEmail'] : '';
        $newRole = isset($_POST['newRole']) ? $_POST['newRole'] : '';
        $userID = isset($_POST['userID']) ? $_POST['userID'] : '';
        
        $status = $this->userModel->editUser($userID, $newUsername, $newEmail, $newRole);

        if ($status == "emailExist") {
            echo '<script>';
            echo 'alert("Email already exists. Please choose a different one.");';
            echo 'window.location.href = "./admin/edit_user.php?userID=' . $userID . '";';
            echo '</script>';
            exit();
        } elseif ($status == "usernameExist") {
            echo '<script>';
            echo 'alert("Username already exists. Please choose a different one.");';
            echo 'window.location.href = "./admin/edit_user.php?userID=' . $userID . '";';
            echo '</script>';
            exit();
        } elseif($status == "success"){
            echo '<script>';
            echo 'alert("The user information has been updated successfully!");';
            echo 'window.location.href = "./admin/userManagement.php";';
            echo '</script>';
        } elseif($status == "emailFormatError"){
            echo '<script>alert("Email must end with @graduate.utm.my");';
            echo 'window.location.href = "admin/edit_user.php?userID=' . $userID . '";';
            echo '</script>';
        } else{
            echo '<script>';
            echo 'alert("Error occur, please try again.");';
            echo 'window.location.href = "./admin/userManagement.php";';
            echo '</script>';
        }


    }

    public function deleteUser(){
        $userID = isset($_GET['userID']) ? $_GET['userID'] : '';
        $status = $this->userModel->delete($userID);

        if ($status == "success") {
            echo '<script>';
            echo 'alert("User deleted successfully.");';
            echo 'window.location.href = "./admin/userManagement.php;"';
            echo '</script>';
            
        } else {
            echo '<script>';
            echo 'alert("Error deleting user.");';
            echo 'window.location.href = "./admin/userManagement.php;"';
            echo '</script>';
        }

    }

}

?>
