<?php
class Logger
{
    /**
    * Logs a specified message to log file.
    * Log file has specified path in config file.
    *
    * @param string $log_msg   Message to log.
    * @param string $level     Log level. Optional.
    */
    public static function logToFile(string $log_msg, string $level = "Unspecified")
    {
        $level = strtoupper($level);
        if (!file_exists(Configuration::getLogDir())) {
            mkdir(Configuration::getInstance()->getLogDir(), 0777, true);
        }
        $log_filename_data = Configuration::getInstance()->getLogDir() . DIRECTORY_SEPARATOR . "log_" . date("Y-m-d") . ".log";
        file_put_contents($log_filename_data, "[" . date("Y/m/d H:i:s") . "] [$level] $log_msg\n", FILE_APPEND);
    }
}
