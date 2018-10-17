<?php
require 'baseTop.php';
?>
		<h1>Ошибка</h1>
		<p>К сожалению, возникла ошибка.</p>
		<?php
		if (isset($message)){
			echo "<p>".$message."</p>";
		}
		?>
		<p><a href='index.php'>Перейти на главную</a></p>
<?php
require 'baseFooter.php';
?>