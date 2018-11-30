<?php
require_once $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . "libs" . DIRECTORY_SEPARATOR . "Config.php";
include_once $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . "libs" . DIRECTORY_SEPARATOR . "Logger.php";

$options = array
(
    array("square", $optionSquarer),
    array("fillToFit", false),



);

function TransformImage(bool $squarer = false)
{
    list($width, $height) = getimagesize($uploadfilepath);
    $largerSide = 0;
    if (($width == $height) || ($width > $height)) 
    {
        $largerSide = $width;
    } 
    else 
    {
        $largerSide = $height;
    }
    // Resizin
    $localURL = "http://localhost/foxfish/" . $uploadFolder . $filepath;
    $transformedURL = "http://localhost/foxfish/libs/imgd.php?src=$localURL&w=$largerSide&h=$largerSide&fill-to-fit=ffffff";  
    $filedataTransformed = file_get_contents($transformedURL);
    echo "Transforming: $transformedURL\n";
    $uploadfilepathTransformed = $uploadpath . $filename;
    file_put_contents($uploadfilepathTransformed, $filedataTransformed);
}