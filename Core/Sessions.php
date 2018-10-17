<?php

//Работа с сессиями
namespace Core;

class Sessions {

	//Инициализация сессии
	public static function startSession (){
		session_start();
	}

	//Назначение и изменение параметров сессии
	public static function setSession ($name, $value) {
		self::startSession();
		$_SESSION[$name] = $value;
		self::closeSession();

	}

	//Получение значения сессии
	public static function getSession ($name) {
		self::startSession();
		if (isset($_SESSION[$name])){
			$result = $_SESSION[$name];
		} else {
			$result = "";
		}
		self::closeSession();
		return $result;
	}

	//Закрытие сессии
	public static function closeSession () {
		session_write_close();
	}

	//Удаление сессии
	public static function destroySession(){
		self::startSession();
		session_destroy();
	}

}

?>