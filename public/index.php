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
	    $root = dirname(__DIR__);
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
	settype($_REQUEST['section'], "string");
	$section = preg_replace("/[^a-z,-]/i", '', $_REQUEST['section']);
} else {
	$section = "Home";
}

if ((isset($_REQUEST['action'])) && (!empty($_REQUEST['action']))){
	settype($_REQUEST['action'], "string");
	$action = preg_replace("/[^a-z,-]/i", '', $_REQUEST['action']);
} else {
	$action = "index";
}

$router = new Core\Router();
$router->findRoute($section, $action);

?>
