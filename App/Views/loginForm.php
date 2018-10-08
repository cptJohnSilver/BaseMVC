<?php
require 'baseTop.php';
?>
		<a href='index.php'>Главная</a>
		<h1>Авторизация</h1>
		<form action='index.php?section=users&action=login' method='post'>
			Имя пользователя:<br>
			<input type='text' name='userName'><br>
			Пароль:<br>
			<input type='password' name='userPwd'><br>
			<input type='submit' name='regSubmit' value='Войти'>
		</form>
<?php
require 'baseFooter.php';
?>