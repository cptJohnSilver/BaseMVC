<?php

@session_start();

//Автозагрузка классов
spl_autoload_register(function ($class) {
    $root = dirname(__DIR__);   // get the parent directory
    $file = $root . '/' . str_replace('\\', '/', $class) . '.php';
    if (is_readable($file)) {
        require $root . '/' . str_replace('\\', '/', $class) . '.php';
    }
});

error_reporting(E_ALL);
set_error_handler('Core\Error::errorHandler');
set_exception_handler('Core\Error::exceptionHandler');

//Определяем и переходим по маршруту
if((isset($_REQUEST['section'])) && (!empty($_REQUEST['section']))){
	$section = preg_replace("/[^a-z,-]/i", '', $_REQUEST['section']);
	settype($section, "string");
} else {
	$section = "Home";
}

if ((isset($_REQUEST['action'])) && (!empty($_REQUEST['action']))){
	$action = preg_replace("/[^a-z,-]/i", '', $_REQUEST['action']);
	settype($action, "string");
} else {
	$action = "index";
}

$router = new Core\Router();
$router->findRoute($section, $action);

@session_write_close();

?>