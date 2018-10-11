<?php

//Домашняя страница
namespace App\Controllers;

use \Core\Sessions;
use \Core\View;
use \App\Models\User;

class Home {

	public function index(){
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