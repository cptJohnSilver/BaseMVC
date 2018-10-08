<?php

//Модель личного кабинета
namespace App\Models;

use \App\configuration;
use PDO;

class User extends \Core\Model {

	//Авторизация
	public static function login($user, $userPwd) {
		settype($user, "string");
		settype($userPwd, "string");
		//$pwd = sha1($pwd.configuration::PWD_SALT);
		$userPwd = self::pwdHash($userPwd);
		try {
			$db = static::dbConnect();
			$query = $db->prepare("SELECT id, login, name FROM users WHERE login = :user AND password = :pwd");
			$query->bindParam(":user", $user);
			$query->bindParam(":pwd", $userPwd);
			$query->execute();
			if($query->rowCount() == 1) {
				$result = $query->fetchAll(PDO::FETCH_ASSOC);
				return $result;
			} else {
				return false;
			}
		} catch (PDOException $e) {
			//TODO
			echo $e->getMessage();
		}
	}

	//Получение данных о состоянии счета
	public static function getBalance ($userId) {
		settype($userId, "integer");
		//$userPwd = sha1($_SESSION['userPwd'].configuration::PWD_SALT);
		$userPwd = $_SESSION['userPwd'];
		try {
			$db = static::dbConnect();
			$query = $db->prepare("SELECT balance FROM users WHERE id = :user AND password = :pwd");
			$query->bindParam(":user", $userId);
			$query->bindParam(":pwd", $userPwd);
			$query->execute();
			$result = $query->fetchAll(PDO::FETCH_ASSOC);
			return $result;
		} catch (PDOException $e) {
			//TODO
			echo $e->getMessage();
		}
	}

	//Обновление данных о балансе в БД
	public static function updateBalance ($userId, $qty) {
		settype($userId, "integer");
		settype($qty, "integer");
		//$userPwd = sha1($_SESSION['userPwd'].configuration::PWD_SALT);
		$userPwd = $_SESSION['userPwd'];
		$db = static::dbConnect();
		$query = $db->prepare("SELECT balance FROM users WHERE id = :userId AND password = :userPwd FOR UPDATE");
		$query->bindParam(":userId", $userId);
		$query->bindParam(":userPwd", $userPwd);
		$query->execute();
		$currentBalance = $query->fetchAll(PDO::FETCH_ASSOC);
		unset($query);
		if ($currentBalance[0]['balance'] >= $qty) {
			$newUserBalance = $currentBalance[0]['balance'] - $qty;
			$query = $db->prepare("UPDATE users SET balance = :newUserBalance WHERE id = :userId AND password = :userPwd");
			$query->bindParam(":newUserBalance", $newUserBalance);
			$query->bindParam(":userId", $userId);
			$query->bindParam(":userPwd", $userPwd);
			$query->execute();
			if ($query){
				return true;
			} else {
				return false;
			}
		} else {
			return false;
		}
	}

	//Хэширование пароля по запросу
	public static function pwdHash ($password){
		$result = sha1($password.configuration::PWD_SALT);
		return $result;
	}

	//Выход из системы
	public static function logout($userId){
		//TODO
		settype($userId, "integer");
		session_destroy();
		return true;
	}

}

?>