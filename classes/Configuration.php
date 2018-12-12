<?php
/**
 * Configuration file
 * php version 7.2
 *
 * @category ImageManipulation\Configuration
 * @package  KokyIMage
 * @author   Martin Kokeš <info@martinkokes.cz>
 * @author   Jan Pilař <pilarjan4111@gmail.com>
 * @license  GPL https://choosealicense.com/licenses/gpl-3.0/
 * @link     imgmod.martinkokes.cz
 */

/**
 * Configuration class
 * php version 7.2
 *
 * @category ImageManipulation\Configuration\Configuration
 * @package  KokyIMage
 * @author   Martin Kokeš <info@martinkokes.cz>
 * @author   Jan Pilař <pilarjan4111@gmail.com>
 * @license  GPL https://choosealicense.com/licenses/gpl-3.0/
 * @link     imgmod.martinkokes.cz
 */
final class Configuration
{
    private $_dotenv;


    /**
     * If instance of Configuration class doesn't exist, create it.
     * 
     * @return Configuration instance
     */
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
     * 
     * @return Document root.
     */
    private static function _getBaseDir()
    {
        return $_SERVER["DOCUMENT_ROOT"] . DIRECTORY_SEPARATOR;
    }

    /**
     * Returns directory of log files.
     * 
     * @return Directory of log files.
     */
    public static function getLogDir()
    {
        self::getInstance();
        $dotenv = new Dotenv\Dotenv(self::_getBaseDir());
        $dotenv->load();
        $dir = self::_getBaseDir() . getenv("LOG_DIR");
        return $dir;
    }

    /**
     * Returns directory of temporary file.
     * 
     * @return Directory path of temporary file.
     */
    public static function getTempFilePath()
    {
        self::getInstance();
        $dotenv = new Dotenv\Dotenv(self::_getBaseDir());
        $dotenv->load();
        $path = self::_getBaseDir() . getenv("TMP_FILE_PATH");
        return $path;
    }

    /**
     * Returns directory of trasformed files.
     * 
     * @return Directory path of transformed/outputed files.
     */
    public static function getTransformedDirPath()
    {
        self::getInstance();
        $dotenv = new Dotenv\Dotenv(self::_getBaseDir());
        $dotenv->load();
        $path = self::_getBaseDir() . getenv("TRANSFORMED_DATA_FOLDER");
        return $path;
    }


    /**
     * Returns directory path of downloads folder.
     * 
     * @return Directory path of downloads folder.
     */
    public static function getDownloadsDirPath()
    {
        self::getInstance();
        $dotenv = new Dotenv\Dotenv(self::_getBaseDir());
        $dotenv->load();
        $path = self::_getBaseDir() . getenv("DOWNLOADS_DATA_FOLDER");
        return $path;
    }
}
