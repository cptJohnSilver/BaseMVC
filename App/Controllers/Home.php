<?php

//Домашняя страница
namespace App\Controllers;

use \Core\Sessions;
use \Core\View;
use \App\Models\User;

class Home {

	//Главная страница
	public function index(){

		//Проверяем, был ли выполнен вход в систему
		if (Sessions::getSession("loggedIn")) {
			$name = Sessions::getSession("userName");
			$loggedIn = true;
			View::render("indexHome.php", ["title" => "Домашняя страница", "loggedIn" => $loggedIn, "user" => $name]);
		} else {
			$name = "";
			$loggedIn = false;
			View::render("indexHome.php", ["title" => "Домашняя страница", "loggedIn" => $loggedIn, "user" => $name]);
		}
	}

}

?>