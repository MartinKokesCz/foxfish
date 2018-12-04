<?php
final class Configuration
{

    public $dotenv;


    public static function getInstance()
    {
        static $inst = null;
        if ($inst === null) {
            $inst = new Configuration();
            
        }
        return $inst;
    }

    /**
     * Private ctor so nobody else can instantiate it
     *
     */
    private function __construct()
    {
        
        
    }

    private static function getBaseDir() {
        $basedir = __DIR__ . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR;
        return $basedir;
    }

    public function getLogDir() {
        self::getInstance();
        $this->dotenv = new Dotenv\Dotenv(__DIR__ . DIRECTORY_SEPARATOR . "..");
        $this->dotenv->load();
        
        $logDir = getenv("LOG_DIR");
        var_dump($logDir);
        //$dir = self::getBaseDir() . getenv("LOG_DIR");
        echo "tdstd: " . $dir;
        return $dir;
    }
    
}