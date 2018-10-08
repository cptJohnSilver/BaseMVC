<?php

//Авторизация
namespace App\Controllers;

use \Core\View;
use \App\Models\User;

class Users {
	
	//Авторизация в системе
	public function login(){
		if ((isset($_REQUEST['userName'])) && (isset($_REQUEST['userPwd']))){
			$userName = $_REQUEST['userName'];
			$userPwd = $_REQUEST['userPwd'];
			settype($userName, "string");
			settype($userPwd, "string");
			$userLogin = User::login($userName, $userPwd);
			if ($userLogin) {
				$_SESSION['userLogin'] = $_REQUEST['userName'];
				$_SESSION['userName'] = $userLogin[0]['name'];
				$_SESSION['userId'] = $userLogin[0]['id'];
				//Для обеспечения более безопасного хранения пароля записываем его в сессию в уже хэшированном виде
				$_SESSION['userPwd'] = User::pwdHash($_REQUEST['userPwd']);
				$_SESSION['loggedIn'] = true;
				$result = true;
			} else {
				throw new \Exception("Не удалось войти в систему.");
				$result = false;
			}
		} else {
			if ((isset($_SESSION['loggedIn'])) && ($_SESSION['loggedIn'] == true)){
				$result = true;
			} else {
				$result = false;
			}
		}

		if(!$result){
			View::render("loginForm.php", ["title" => "Вход в систему"]);
		} else {
			$userBalance = User::getBalance($_SESSION['userId']);
			View::render("lkPage.php", ["title" => "Личный кабинет", "loggedIn" => $_SESSION['loggedIn'], "user" => $_SESSION['userName'], "balance" => $userBalance[0]['balance']]);
		}

	}

	//Проведение операции списания
	public function transaction(){
		//$qty = 0;
		if(isset($_REQUEST['qty'])) {
			$qty = $_REQUEST['qty'];
			settype($qty, "integer");
			$userBalance = User::getBalance($_SESSION['userId']);
			if($userBalance) {
				if($userBalance[0]['balance'] >= $qty){
					$checkBalanceUpdate = User::updateBalance($_SESSION['userId'], $qty);
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
		}
		$userBalance = User::getBalance($_SESSION['userId']);
		View::render("lkPage.php", ["title" => "Личный кабинет", "loggedIn" => $_SESSION['loggedIn'], "user" => $_SESSION['userName'], "balance" => $userBalance[0]['balance'], "result" => $result, "qty" => $qty]);
	}

	//Выход из системы
	public function logout() {
		$logout = User::logout($_SESSION['userId']);
		View::render("indexHome.php", ["title" => "Домашняя страница", "loggedIn" => false]);
	}

}

?>