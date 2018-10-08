<?php

//Обработчик ошибок
namespace Core;
use \App\configuration;


class Error {

    //Конвертация всех ошибок в исключения
    public static function errorHandler($level, $message, $file, $line) {
        if (error_reporting() !== 0) {
            throw new \ErrorException($message, 0, $level, $file, $line);
        }
    }

    //Обработка исключений
    public static function exceptionHandler($exception) {
        $code = $exception->getCode();
        if ($code != 404) {
            $code = 500;
        }
        if (configuration::SHOW_ERRORS) {
            echo "<h1>Возникла ошибка</h1>";
            echo "<p>Тип ошибки: '" . get_class($exception) . "'</p>";
            echo "<p>Сообщение: '" . $exception->getMessage() . "'</p>";
            echo "<p>Подробности:<pre>" . $exception->getTraceAsString() . "</pre></p>";
            echo "<p>Ошибка в файле '" . $exception->getFile() . "' на линии " . $exception->getLine() . "</p>";
        } else {
            $log = dirname(__DIR__).'\logs\\'.date('Y-m-d H-i-s-').microtime().'.txt';
            $writeLog = fopen($log, "x+");
            $message = "Ошибка типа: '" . get_class($exception) . "'";
            $message .= " с сообщением '" . $exception->getMessage() . "'";
            $message .= "\nПодробности: " . $exception->getTraceAsString();
            $message .= "\nВозникла в '" . $exception->getFile() . "' на линии " . $exception->getLine();
            fwrite($writeLog, $message);
            View::render("$code.php", ["title" => "Возникла ошибка"]);
        }
    }
}
