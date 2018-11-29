<?php
function LogToFile($log_msg, $level = "Unspecified level")
{
    $log_dir = $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . "log";
    if (!file_exists($log_dir)) 
    {
        mkdir($log_dir, 0777, true);
    }
    $log_filename_data = $log_dir . DIRECTORY_SEPARATOR . "log_" . date("d-M-Y") . ".log";
    file_put_contents($log_filename_data, "[" . date("Y-m-d-H_m-i-s") . "]  [$level] $log_msg\n", FILE_APPEND);
}
