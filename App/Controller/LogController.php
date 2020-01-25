<?php

class LogController {
    private static $logFolder = __DIR__ . '/../../logs/';
    private static $errorFile = __DIR__ . '/../../logs/error.log';

    /**
     * Setup tous les fichiers et dossier nécessaires
     *
     * @return void
     */
    private static function SetupFiles(): void {
        if (!is_dir(self::$logFolder)) {
            mkdir(self::$logFolder);
        }

        if (!is_file(self::$errorFile)) {
            touch(self::$errorFile);
        }
    }

    /**
     * Formate le log d'une erreur
     *
     * @param string $timestamp Timestamp de l'erreur
     * @param string $from Chemin de l'erreur Ex.: UserController->Login(...)
     * @param int $line Ligne où l'erreur à été lancée
     * @param string $message Message customisé du lanceur d'erreur
     * @param string $error Message d'exception
     *
     * @return string
     */
    private static function ErrorFormat(string $timestamp, string $from, int $line, string $message, string $error): string {
        return sprintf('[%s] [%s] (line %s) %s --> %s \r\n', $timestamp, $from, $line, $message, $error);
    }

    /**
     * Formate le log du warning
     *
     * @param string $timestamp Timestamp de l'erreur
     * @param string $from Chemin de l'erreur Ex.: UserController->Login(...)
     * @param int $line Ligne où l'erreur à été lancée
     * @param string $message Message customisé du lanceur d'erreur
     *
     * @return string
     */
    private static function WarningFormat(string $timestamp, string $from, int $line, string $message): string {
        return sprintf('Warning: [%s] [%s] (line %s) --> %s \r\n', $timestamp, $from, $line, $message);
    }

    
    /**
     * Log une erreur
     *
     * @param string $data Message customisé
     * @param string $error Message d'exception
     *
     * @return void
     */
    public static function Error(string $data, string $error): void {
        self::SetupFiles();

        $backtrace = debug_backtrace();
        $backtrace = end($backtrace);

        $from = $backtrace['class'] . $backtrace['type'] . $backtrace['function'];
        file_put_contents(self::$errorFile, self::ErrorFormat(date('Y-m-d H:i:s'), $from, $backtrace['line'], $data, $error), FILE_APPEND);
    }

    /**
     * Log un warning
     *
     * @param string $data Message customisé
     *
     * @return void
     */
    public static function Warning(string $data): void {
        self::SetupFiles();

        $backtrace = debug_backtrace();
        $backtrace = end($backtrace);

        $from = $backtrace['class'] . $backtrace['type'] . $backtrace['function'];
        file_put_contents(self::$errorFile, self::WarningFormat(date('Y-m-d H:i:s'), $from, $backtrace['line'], $data), FILE_APPEND);
    }
}