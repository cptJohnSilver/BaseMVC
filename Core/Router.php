<?php

//Определение маршрута
namespace Core;

class Router {

	//Поиск маршрута
	public function findRoute($section, $action){
		$section = $this->convertToStudlyCaps($section);
		$section = "App\Controllers\\".$section;
		if (class_exists($section)){
			$runController = new $section();
			$action = $this->convertToCamelCase($action);
			if (is_callable([$runController, $action])){
				$runController->$action();
			} else {
				throw new \Exception('Маршрут не найден.', 404);
			}
		} else {
			throw new \Exception('Маршрут не найден.', 404);
		}
	}

	//Конвертация строки в формат StudlyCaps
	private function convertToStudlyCaps ($string){
		return str_replace(' ', '', ucwords(str_replace('-', ' ', $string)));
	}

	//Конвертация строки в формат camelCase
	private function convertToCamelCase ($string){
        return lcfirst($this->convertToStudlyCaps($string));
    }

}

?>