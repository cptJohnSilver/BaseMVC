<?php

//Генерация HTML-страницы
namespace Core;

class View {
	public static function render ($page, $args = []){
		extract($args, EXTR_SKIP);
		$page = "../App/Views/$page";
		if (is_readable($page)) {
            require $page;
        } else {
            echo "Такой страницы не существует.";
        }
	}
}

?>