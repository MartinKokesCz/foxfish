<?php
require_once $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . "libs" . DIRECTORY_SEPARATOR . "Config.php";

/**
 * Logs a specified message to log file.
 * Log file has specified path in config file.
 * 
 * @param string $log_msg   Message to log.
 * @param string $level     Log level. Optional.
 */
function LogToFile(string $log_msg, string $level = "Unspecified")
{
    $level = strtoupper($level);
    if (!file_exists(LOG_DIR)) 
    {
        mkdir($log_dir, 0777, true);
    }
    $log_filename_data = LOG_DIR . DIRECTORY_SEPARATOR . "log_" . date("Y-m-d") . ".log";
    file_put_contents($log_filename_data, "[" . date("Y/m/d H:i:s") . "] [$level] $log_msg\n", FILE_APPEND);
}