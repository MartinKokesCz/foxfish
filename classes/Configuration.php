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
        return $_SERVER["DOCUMENT_ROOT"] . DIRECTORY_SEPARATOR;
    }

    /**
     * Returns directory of log files.
     */
    public static function getLogDir()
    {
        self::getInstance();
        $dotenv = new Dotenv\Dotenv(self::getBaseDir());
        $dotenv->load();
        $dir = self::getBaseDir() . getenv("LOG_DIR");
        return $dir;
    }

    /**
     * Returns directory of temporary file.
     */
    public static function getTempFilePath()
    {
        self::getInstance();
        $dotenv = new Dotenv\Dotenv(self::getBaseDir());
        $dotenv->load();
        $path = self::getBaseDir() . getenv("TMP_FILE_PATH");
        return $path;
    }

    /**
     * Returns directory of trasformed files.
     */
    public static function getTransformedDirPath()
    {
        self::getInstance();
        $dotenv = new Dotenv\Dotenv(self::getBaseDir());
        $dotenv->load();
        $path = self::getBaseDir() . getenv("TRANSFORMED_DATA_FOLDER");
        return $path;
    }

    public static function getDownloadsDirPath()
    {
        self::getInstance();
        $dotenv = new Dotenv\Dotenv(self::getBaseDir());
        $dotenv->load();
        $path = self::getBaseDir() . getenv("DOWNLOADS_DATA_FOLDER");
        return $path;
    }
}
