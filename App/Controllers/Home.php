<?php

//Домашняя страница
namespace App\Controllers;

use \Core\View;
use \App\Models\User;

class Home {

	public function index(){
		if ((isset($_SESSION['loggedIn'])) && ($_SESSION['loggedIn'] == true)) {
			if (isset($_SESSION['userName'])) {
				$name = $_SESSION['userName'];
				$loggedIn = true;
			} else {
				$name = "";
				$loggedIn = false;
			}
			View::render("indexHome.php", ["title" => "Домашняя страница", "loggedIn" => $loggedIn, "user" => $name]);
		} else {
			$name = "";
			$loggedIn = false;
			View::render("indexHome.php", ["title" => "Домашняя страница", "loggedIn" => $loggedIn, "user" => $name]);
		}
	}

}

?>