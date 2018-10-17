<?php

//Авторизация пользователя, личный кабинет и проведение транзакций
namespace App\Controllers;

use \Core\View;
use \Core\Sessions;
use \App\Models\User;

class Users {
	
	//Авторизация пользователя в системе
	public function login(){

		if ((isset($_REQUEST['userLogin'])) && (isset($_REQUEST['userPwd']))){
			$userLogin = $_REQUEST['userLogin'];
			$userPwd = $_REQUEST['userPwd'];
			settype($userLogin, "string");
			settype($userPwd, "string");
			$userAuthorization = User::login($userLogin, $userPwd);
			
			//Проверяем правильность логина и пароля, введенных пользователем
			if ($userAuthorization) {
				Sessions::setSession("userId", $userAuthorization[0]['id']);
				Sessions::setSession("userLogin", $userLogin);
				//Для обеспечения более безопасного хранения пароля записываем его в сессию в уже хэшированном виде
				Sessions::setSession("userPwd", User::pwdHash($userPwd));
				Sessions::setSession("userName", $userAuthorization[0]['name']);
				Sessions::setSession("loggedIn", true);
				$result = true;
			} else {
				throw new \Exception("Не удалось войти в систему.");
				$result = false;
			}
		} else {
			//Проверяем, был ли выполнен вход ранее
			if (Sessions::getSession("loggedIn")){
				$result = true;
			} else {
				$result = false;
			}
		}

		//Генерируем страницу
		if(!$result){
			View::render("loginForm.php", ["title" => "Вход в систему"]);
		} else {
			$userBalance = User::getBalance(Sessions::getSession("userId"));
			View::render("lkPage.php", ["title" => "Личный кабинет", "loggedIn" => Sessions::getSession("loggedIn"), "user" => Sessions::getSession("userName"), "balance" => $userBalance[0]['balance']]);
		}

	}

	//Проведение операции списания средств
	public function transaction(){

		if(isset($_REQUEST['quantity'])) {
			$quantity = $_REQUEST['quantity'];
			settype($quantity, "integer");
			
			//Ноль списывать со счета нет никакого смысла
			if ($quantity != 0) {
				
				$userBalance = User::getBalance(Sessions::getSession("userId"));
				//Проверяем, вернула ли БД баланс пользователя
				if($userBalance) {

					//Удостоверяемся, что текущий баланс больше или равен запрашиваемой сумме
					if($userBalance[0]['balance'] >= $quantity){
						$checkBalanceUpdate = User::updateBalance(Sessions::getSession("userId"), $quantity);
						
						//Проверяем результат операции обновления баланса
						if ($checkBalanceUpdate){
							$result = true;
						} else {
							throw new \Exception("Возникла ошибка при обновлении баланса.");
							$result = false;
						}
					} else {
						$result = false;
					}
				} else {
					throw new \Exception("Возникла ошибка при получении информации о балансе.");
					$result = false;
				}
			} else {
				$result = false;
			}
		}

		//Получаем обновленный баланс и генерируем страницу
		$userBalance = User::getBalance(Sessions::getSession("userId"));
		View::render("lkPage.php", ["title" => "Личный кабинет", "loggedIn" => $_SESSION['loggedIn'], "user" => $_SESSION['userName'], "balance" => $userBalance[0]['balance'], "result" => $result, "quantity" => $quantity]);
	}

	//Выход из системы
	public function logout() {
		User::logout(Sessions::getSession("userId"));
		View::render("indexHome.php", ["title" => "Домашняя страница", "loggedIn" => false]);
	}

}

?>