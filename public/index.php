<?php
//Подключение автозагрузчика классов
require '../vendor/autoload.php';

//Назначаем обработчик ошибок и исключений по умолчанию
set_error_handler('Core\Error::errorHandler');
set_exception_handler('Core\Error::exceptionHandler');

	//Функциональность исключена
	/*
	//Автозагрузка классов
	spl_autoload_register(function ($class) {
	    $root = dirname(__DIR__);   // get the parent directory
    	$file = $root . '/' . str_replace('\\', '/', $class) . '.php';
	    if (is_readable($file)) {
        	require $root . '/' . str_replace('\\', '/', $class) . '.php';
	    }
	});
	*/

	//Функциональность исключена
	//error_reporting(E_ALL);

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

?>