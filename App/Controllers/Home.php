<?php

//Домашняя страница
namespace App\Controllers;

use \Core\View;
use \App\Models\User;

class Home {

	public function index(){
		if ((isset($_SESSION['loggedIn'])) && ($_SESSION['loggedIn'] == true)) {
			$userName = $_SESSION['userLogin'];
			$userPwd = $_SESSION['userPwd'];
			$loggedIn = User::login($userName, $userPwd);
			if ($loggedIn) {
				$userBalance = User::getBalance($_SESSION['userId']);
				View::render("lkPage.php", ["title" => "Личный кабинет", "loggedIn" => $_SESSION['loggedIn'], "user" => $loggedIn[0]['name'], "balance" => $userBalance[0]['balance']]);
			} else {
				if ((isset($_SESSION['loggedIn'])) && ($_SESSION['loggedIn'] == true) && (isset($_SESSION['userName']))) {
					$name = $_SESSION['userName'];
					(bool) $loggedIn = true;
				} else {
					$name = "";
					(bool) $loggedIn = false;
				}
				View::render("indexHome.php", ["title" => "Домашняя страница", "loggedIn" => $loggedIn, "user" => $name]);
			}
		} else {
			$name = "";
			$loggedIn = false;
			View::render("indexHome.php", ["title" => "Домашняя страница", "loggedIn" => $loggedIn, "user" => $name]);
		}
	}

}

?>