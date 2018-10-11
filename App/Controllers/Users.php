<?php

//Авторизация
namespace App\Controllers;

use \Core\View;
use \Core\Sessions;
use \App\Models\User;

class Users {
	
	//Авторизация в системе
	public function login(){

		if ((isset($_REQUEST['userLogin'])) && (isset($_REQUEST['userPwd']))){
			$userLogin = $_REQUEST['userLogin'];
			$userPwd = $_REQUEST['userPwd'];
			settype($userLogin, "string");
			settype($userPwd, "string");
			$userAuthorization = User::login($userLogin, $userPwd);
			if ($userAuthorization) {
				Sessions::setSession("userId", $userAuthorization[0]['id']);
				Sessions::setSession("userLogin", $userLogin);
				Sessions::setSession("userPwd", User::pwdHash($userPwd));
				Sessions::setSession("userName", $userAuthorization[0]['name']);
				Sessions::setSession("loggedIn", true);
				//Для обеспечения более безопасного хранения пароля записываем его в сессию в уже хэшированном виде
				$result = true;
			} else {
				throw new \Exception("Не удалось войти в систему.");
				$result = false;
			}
		} else {
			if (Sessions::getSession("loggedIn")){
				$result = true;
			} else {
				$result = false;
			}
		}

		if(!$result){
			View::render("loginForm.php", ["title" => "Вход в систему"]);
		} else {
			$userBalance = User::getBalance(Sessions::getSession("userId"));
			View::render("lkPage.php", ["title" => "Личный кабинет", "loggedIn" => Sessions::getSession("loggedIn"), "user" => Sessions::getSession("userName"), "balance" => $userBalance[0]['balance']]);
		}

	}

	//Проведение операции списания
	public function transaction(){
		//$qty = 0;
		if(isset($_REQUEST['quantity'])) {
			$quantity = $_REQUEST['quantity'];
			settype($quantity, "integer");
			if ($quantity != 0) {
				$userBalance = User::getBalance(Sessions::getSession("userId"));
				if($userBalance) {
					if($userBalance[0]['balance'] >= $quantity){
						$checkBalanceUpdate = User::updateBalance(Sessions::getSession("userId"), $quantity);
						if ($checkBalanceUpdate){
							$result = true;
						} else {
							//TODO
							$result = false;
						}
					} else {
						//TODO
						$result = false;
					}
				} else {
					//TODO
					$result = false;
				}
			} else {
				//TODO
				$result = false;
			}
		}
		$userBalance = User::getBalance(Sessions::getSession("userId"));
		View::render("lkPage.php", ["title" => "Личный кабинет", "loggedIn" => $_SESSION['loggedIn'], "user" => $_SESSION['userName'], "balance" => $userBalance[0]['balance'], "result" => $result, "quantity" => $quantity]);
	}

	//Выход из системы
	public function logout() {
		$logout = User::logout(Sessions::getSession("userId"));
		View::render("indexHome.php", ["title" => "Домашняя страница", "loggedIn" => false]);
	}

}

?>