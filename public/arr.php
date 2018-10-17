<?php
$arr = [1, 2];
$arrOne = lcfirst($arr);
var_dump($arr);
var_dump($arrOne);
settype($arr, "string");
$arrTwo = lcfirst($arr);
var_dump($arr);
var_dump($arrTwo);
?>