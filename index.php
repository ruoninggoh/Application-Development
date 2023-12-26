<?php
    include_once 'config.php';
    spl_autoload_register(function ($class) {
        if(file_exists('controller/'.$class.'.php')){
            include_once 'controller/' . $class . '.php';
        }

        if(file_exists('model/'.$class.'.php')){
            include_once 'model/' . $class . '.php';
        }
        
    });

    $controllerName = isset($_POST['controller']) ? $_POST['controller'] : null;

    if ($controllerName === null) {
        $controllerName = isset($_GET['controller']) ? $_GET['controller'] : 'LoginController';
    }
    
    $controllerName = $controllerName ?: 'LoginController';
    
    $controllerClassName = ucfirst($controllerName);

    if (class_exists($controllerClassName)) {

        $controller = new $controllerClassName();
        $controller->actionHandler();

    } else {
        echo 'Controller not found.';
    }

?>