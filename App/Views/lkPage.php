<?php
require 'baseTop.php';
?>
		<a href='index.php'>Главная</a>
		<h1>Личный кабинет</h1>
		<?php if ($loggedIn) {
			if ((isset($result)) && ($result == true) && (isset($qty))){
				echo "<div class='alert alert-success'>Операция выполнена успешно.</div>";
				echo "<div class='alert alert-success'>С вашего счета списано ".$qty." условных единиц.</div>";
			} elseif ((isset($result)) && ($result == false) && (isset($qty))) {
				echo "<div class='alert alert-danger'>При выполнении операции возникла ошибка.</div>";
				echo "<div class='alert alert-danger'>Не удалось списать ".$qty." условных единиц с Вашего счета.</div>";
			}
		?>
		<p>Приветствую, <b><?= htmlspecialchars($user, ENT_QUOTES); ?></b>!</p>
		<p>На Вашем счете <b><?= $balance; ?></b> условных единиц.</p>
		<p>Чтобы списать денежные средства, Вы можете воспользоваться формой ниже:</p>
		<form action='index.php?section=users&action=transaction' method='post'>
			<input type='text' name='qty'><br>
			<input type='submit' name='getTransaction' value='Списать'>
		</form>
		<p><a href='index.php?section=users&action=logout'>Завершить работу в системе</a></p>
		<?php } else { ?>
		<p>Чтобы начать работу, необходима <a href='index.php?section=users&action=login'>авторизация</a>.</p>
		<?php } ?>
<?php
require 'baseFooter.php';
?>