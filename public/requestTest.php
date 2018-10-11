<?php

//Пояснение к $_REQUEST
if (isset($_REQUEST['text'])) {
	$result = strcmp('compare', $_REQUEST['text']);
	if ($result == 0) {
		echo "Вне сомнений. Это - строка.";
	} else {
		echo "Очевидно, что-то пошло не так.";
	}
	if (is_array($_REQUEST['text'])) {
		echo "<br>Возможно, что в качестве переменной был передан массив.";
	}
}

echo "<br>Тест окончен.";

?>