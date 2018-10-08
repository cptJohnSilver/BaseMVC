<?php
require 'baseTop.php';
?>
		<h1>Добро пожаловать!</h1>
		<?php if ($loggedIn) {?>
		<p>Приветствую, <?= htmlspecialchars($user, ENT_QUOTES); ?>!</p>
		<p>Для работы с системой, Вы можете перейти в <a href='index.php?section=users&action=lk'>личный кабинет</a>.</p>
		<?php } else { ?>
		<p>Чтобы начать работу, необходима <a href='index.php?section=users&action=login'>авторизация</a>.</p>
		<?php } ?>
	</body>
</html>