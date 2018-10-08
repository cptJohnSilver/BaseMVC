<?php
require 'baseTop.php';
?>
					<h1>Добро пожаловать!</h1>
					<?php if ($loggedIn) {?>
					<p>Приветствую, <b><?= htmlspecialchars($user, ENT_QUOTES); ?></b>!</p>
					<p>Для работы с системой, Вы можете перейти в <a href='index.php?section=users&action=login'>личный кабинет</a>.</p>
					<?php } else { ?>
					<p>Чтобы начать работу, необходима <a href='index.php?section=users&action=login'>авторизация</a>.</p>
					<?php } ?>
<?php
require 'baseFooter.php';
?>