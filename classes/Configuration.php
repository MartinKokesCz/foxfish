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
        //$basedir = __DIR__ . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR;
        $basedir = $_SERVER["DOCUMENT_ROOT"];
        return $basedir;
    }

    /**
     * Returns directory of log files.
     */
    public static function getLogDir()
    {
        self::getInstance();
        $dotenv = new Dotenv\Dotenv(__DIR__ . DIRECTORY_SEPARATOR . "..");
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
}
