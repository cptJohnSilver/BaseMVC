<?php
//Настройки
namespace App;

class configuration {

	//Сервер БД
	const DB_HOST = 'db host';

	//Имя БД
	const DB_NAME = 'db name';

	//Пользователь БД
	const DB_USER = 'db user';

	//Пароль БД
	const DB_PWD = 'db password';

	//Соль к паролю
	const PWD_SALT = 'password salt';

	//Отображений ошибок для отладки
	const SHOW_ERRORS = false;
	
}
?>