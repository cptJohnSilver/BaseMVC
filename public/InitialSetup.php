<?php

//Начальная инициализация

require '../vendor/autoload.php';

use \App\configuration;

class InitialSetup extends \Core\Model {

	public function createDB (){
		//Создание таблицы и добавление информации о пользователе
		try {
			$db = static::dbConnect();
			$query = $db->prepare("CREATE TABLE IF NOT EXISTS users (id INT NOT NULL AUTO_INCREMENT, login TINYTEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL, password TINYTEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL, name TINYTEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL, balance INT NOT NULL, UNIQUE id (id)) ENGINE = InnoDB;");
			$query->execute();
			$userLogin = "first_user";
			$userPassword = "qwerty123".configuration::PWD_SALT;
			$userName = "Пользователь";
			$userBalance = 1000;
			$query = $db->prepare("INSERT INTO users (login, password, name, balance) VALUES (:userLogin, :userPassword, :userName, :userBalance)");
			$query->bindParam(":userLogin", $userLogin);
			$query->bindParam(":userPassword", sha1($userPassword));
			$query->bindParam(":userName", $userName);
			$query->bindParam(":userBalance", $userBalance);
			$query->execute();
			echo "Установка завершена.";
		} catch (PDOException $e) {
			echo $e->getMessage();
		}
	}

}

$setupDB = new InitialSetup();
$setupDB->createDB();
unset($setupDB);
unlink('InitialSetup.php');

?>