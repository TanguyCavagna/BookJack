<?php

class LogController {
    private static $logFolder = __DIR__ . '/../../logs/';
    private static $errorFile = __DIR__ . '/../../logs/error.log';

    private static function SetupFiles() {
        if (!is_dir(self::$logFolder)) {
            mkdir(self::$logFolder);
        }

        if (!is_file(self::$errorFile)) {
            touch(self::$errorFile);
        }
    }

    private static function ErrorFormat($timestamp, $from, $line, $message, $error) {
        return sprintf('[%s] [%s] (line %s) %s --> %s \r\n', $timestamp, $from, $line, $message, $error);
    }

    private static function WarningFormat($timestamp, $from, $line, $message) {
        return sprintf('Warning: [%s] [%s] (line %s) --> %s \r\n', $timestamp, $from, $line, $message);
    }

    public static function Error($data, $error) {
        self::SetupFiles();

        $backtrace = debug_backtrace();
        $backtrace = end($backtrace);

        $from = $backtrace['class'] . $backtrace['type'] . $backtrace['function'];
        file_put_contents(self::$errorFile, self::ErrorFormat(date('Y-m-d H:i:s'), $from, $backtrace['line'], $data, $error), FILE_APPEND);
    }

    public static function Warning($data) {
        self::SetupFiles();

        $backtrace = debug_backtrace();
        $backtrace = end($backtrace);

        $from = $backtrace['class'] . $backtrace['type'] . $backtrace['function'];
        file_put_contents(self::$errorFile, self::WarningFormat(date('Y-m-d H:i:s'), $from, $backtrace['line'], $data), FILE_APPEND);
    }
}