<?php
include_once 'config.php';

// Include the necessary files
include_once 'controller/LoginController.php';
include_once 'controller/UserManagementController.php';

spl_autoload_register(function ($class) {
    if (file_exists('controller/' . $class . '.php')) {
        include_once 'controller/' . $class . '.php';
    }

    if (file_exists('model/' . $class . '.php')) {
        include_once 'model/' . $class . '.php';
    }
});

$controllerName = isset($_GET['controller']) ? $_GET['controller'] : 'LoginController';
$action = isset($_GET['action']) ? $_GET['action'] : 'actionHandler';

$controllerClassName = ucfirst($controllerName);

if (class_exists($controllerClassName)) {
    $controller = new $controllerClassName();

    // Check if the specified action method exists, otherwise call the default actionHandler
    if (method_exists($controller, $action)) {
        $controller->$action();
    } else {
        echo 'Action not found.';
    }
} else {
    echo 'Controller not found.';
}
?>
