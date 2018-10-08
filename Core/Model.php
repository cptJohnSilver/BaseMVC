<?php

//Базовая модель подключения к БД
namespace Core;

use \App\configuration;
use PDO;

abstract class Model {

	protected static function dbConnect(){
		static $db = null;
		if($db == null) {
			$dbConnection = 'mysql:host=' . configuration::DB_HOST . ';dbname=' . configuration::DB_NAME . ';charset=utf8';
            $db = new PDO($dbConnection, configuration::DB_USER, configuration::DB_PWD);
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		}
		return $db;
	}

}

?>