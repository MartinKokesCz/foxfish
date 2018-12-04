<?php
final class Configuration
{
    private $dotenv;


    public static function getInstance()
    {
        static $inst = null;
        if ($inst === null) {
            $inst = new Configuration();
        }
        return $inst;
    }

    /**
     * Private constructor so nobody else can instantiate it.
     */
    private function __construct()
    {
    }

    /**
     * Returns a document root.
     */
    private static function getBaseDir()
    {
        return $_SERVER["DOCUMENT_ROOT"];
    }

    /**
     * Returns directory of log files.
     */
    public static function getLogDir()
    {
        self::getInstance();
        $dotenv = new Dotenv\Dotenv($_SERVER["DOCUMENT_ROOT"]);
        $dotenv->load();
        $logDir = getenv("LOG_DIR");
        $dir = self::getBaseDir() . getenv("LOG_DIR");
        return $dir;
    }

    /**
     * Returns directory of temporary file.
     */
    public static function getTempFilePath()
    {
        self::getInstance();
        $dotenv = new Dotenv\Dotenv(__DIR__ . DIRECTORY_SEPARATOR . "..");
        $dotenv->load();
        $tmpFilePath = getenv("TMP_FILE_PATH");
        $path = self::getBaseDir() . getenv("TMP_FILE_PATH");
        return $path;
    }

        /**
     * Returns directory of trasformed files.
     */
    public static function getTransformedDirPath()
    {
        self::getInstance();
        $dotenv = new Dotenv\Dotenv(__DIR__ . DIRECTORY_SEPARATOR . "..");
        $dotenv->load();
        $tmpFilePath = getenv("TRANSFORMED_DATA_FOLDER");
        $path = self::getBaseDir() . getenv("TRANSFORMED_DATA_FOLDER");
        return $path;
    }
}
