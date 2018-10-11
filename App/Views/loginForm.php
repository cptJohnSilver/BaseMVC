<?php
require 'baseTop.php';
?>
		</div>
	</div>
	<div class='row'>
		<div class='col-md-3'>
		<br><a href='index.php'>Главная</a><br>
		<h1>Авторизация</h1>
		<form action='index.php?section=users&action=login' method='post'>
			<div class='form-group'>
				<label for='userLogin'>Имя пользователя:</label>
				<input class='form-control' type='text' name='userLogin'>
			</div>
			<div class='form-group'>
				<label for='userPwd'>Пароль:</label>
				<input class='form-control' type='password' name='userPwd'>
			</div>
			<div class='form-group'>
				<button type='submit' class='btn btn-primary'>Войти</button>
			</div>
		</form>
<?php
require 'baseFooter.php';
?>