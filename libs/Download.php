<?php
require_once $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . "libs" . DIRECTORY_SEPARATOR . "Config.php";
include_once $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . "libs" . DIRECTORY_SEPARATOR . "Logger.php";

if (!file_exists("./libs/imgd.php")) 
{
    $imgdDataTemp = file_get_contents(CIMAGE_URL);
    $imgDataRemoteEnabled = str_replace("//'remote_allow'", "'remote_allow'", $imgdDataTemp);
    file_put_contents("./libs/imgd.php", $imgDataRemoteEnabled);
}


