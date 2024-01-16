<?php

session_status() === PHP_SESSION_ACTIVE ? TRUE : session_start();
include_once("./model/UserModel.php");

class UserManagementController {
    private $userModel;

    public function __construct() {
        $this->userModel = new UserModel(new Config()); // You may need to adjust this based on your project structure
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
            case 'edit':
                $this->editUser();
                break;
            case 'delete':
                $this->deleteUser();
                break;
            case 'add':
                $this->addUser();
                break;
            default:
                $this->index();
        }
    }

    public function index() {
      
        header("Location: ./admin/manageuser.php");
    }

    public function editUser() {
        // Assuming you have user ID in the query parameter
        $userID = isset($_GET['userID']) ? $_GET['userID'] : null;

        if ($userID) {
            
            // Redirect to edit page with user details
            header("Location: ./admin/edit_user.php?userID={$userID}");
        } else {
            // Handle error or redirect to manage user page
            header("Location: ./admin/manageuser.php");
        }
    }

    public function deleteUser() {
        // Assuming you have user ID in the query parameter
        $userID = isset($_GET['userID']) ? $_GET['userID'] : null;

        if ($userID) {
           
            // Redirect to manage user page with a success or error message
            header("Location: ./database/delete_user.php?userID={$userID}");
        } else {
            // Handle error or redirect to manage user page
            header("Location: ./admin/manageuser.php");
        }
    }

    public function addUser() {
        // Redirect to the add user page
        header("Location: ./admin/add_user.php");
    }
}

?>
