<?php

//Модель работы с данными пользователя
namespace App\Models;

use \Core\Sessions;
use \App\configuration;
use PDO;

class User extends \Core\Model {

	//Авторизация пользователя в системе
	public static function login($userLogin, $userPwd) {
		settype($userLogin, "string");
		settype($userPwd, "string");
		$userPwd = self::pwdHash($userPwd);
		try {
			$db = static::dbConnect();
			$query = $db->prepare("SELECT id, login, name FROM users WHERE login = :user AND password = :pwd");
			$query->bindParam(":user", $userLogin);
			$query->bindParam(":pwd", $userPwd);
			$query->execute();
			if($query->rowCount() == 1) {
				$result = $query->fetchAll(PDO::FETCH_ASSOC);
				return $result;
			} else {
				return false;
			}
		} catch (PDOException $e) {
			echo $e->getMessage();
		}
	}

	//Получение данных о состоянии счета
	public static function getBalance ($userId) {
		settype($userId, "integer");
		try {
			$db = static::dbConnect();
			$query = $db->prepare("SELECT balance FROM users WHERE id = :userId");
			$query->bindParam(":userId", $userId);
			$query->execute();
			$result = $query->fetchAll(PDO::FETCH_ASSOC);
			return $result;
		} catch (PDOException $e) {
			echo $e->getMessage();
		}
	}

	//Обновление данных о балансе в БД
	public static function updateBalance ($userId, $quantity) {
		settype($userId, "integer");
		settype($quantity, "integer");
		try {
			$db = static::dbConnect();
			$db->beginTransaction();
			$query = $db->prepare("SELECT balance FROM users WHERE id = :userId FOR UPDATE");
			$query->bindParam(":userId", $userId);
			$query->execute();
			$currentBalance = $query->fetchAll(PDO::FETCH_ASSOC);

			//Удостоверяемся, что баланс пользователя достаточный для списания
			if ($currentBalance[0]['balance'] >= $quantity) {
				$newUserBalance = $currentBalance[0]['balance'] - $quantity;
				$query = $db->prepare("UPDATE users SET balance = :newUserBalance WHERE id = :userId");
				$query->bindParam(":newUserBalance", $newUserBalance);
				$query->bindParam(":userId", $userId);
				$query->execute();
				$db->commit();
				if ($query){
					return true;
				} else {
					return false;
				}
			} else {
				return false;
			}
		} catch (PDOException $e) {
			echo $e->getMessage();
		}
	}

	//Хэширование пароля по запросу
	public static function pwdHash ($password){
		$result = sha1($password.configuration::PWD_SALT);
		return $result;
	}

	//Выход из системы
	public static function logout(){
		Sessions::destroySession();
	}

}

?>