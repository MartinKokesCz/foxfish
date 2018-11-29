<?php
require_once $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . "libs" . DIRECTORY_SEPARATOR . "Config.php";
include_once $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . "libs" . DIRECTORY_SEPARATOR . "Logger.php";

// edit the file in excel and remove all not needed columns and characters
// there should be only URLs one each line

if (!file_exists("./libs/imgd.php")) 
{
    $imgdDataTemp = file_get_contents(CIMAGE_URL);
    $imgDataRemoteEnabled = str_replace("//'remote_allow'", "'remote_allow'", $imgdDataTemp);
    file_put_contents("./libs/imgd.php", $imgDataRemoteEnabled);
}

function DownloadFilesWithStructure($urlsSourceFile)
{
    define("FILEPATH_IMAGE_URLS", $urlsSourceFile);
    if (file_exists(FILEPATH_IMAGE_URLS)) 
    {
        $handle = fopen(FILEPATH_IMAGE_URLS, "r");
        if ($handle) 
        {
            $uploadFolder = "downloads" . DIRECTORY_SEPARATOR . "upload" . "-" . date("Y-m-d-H_m-i-s");
            while (($line = fgets($handle)) !== false) 
            {
                $URL = preg_replace("/\r|\n/", "", $line);
                // remove the protocol and domain from string
                $filepath = parse_url($URL, PHP_URL_PATH);

                // get file name only
                $filename = basename($filepath);

                // remove file name from the path
                $folderpath = str_replace($filename, "", $filepath);

                $uploadpath = $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . $uploadFolder . $folderpath;
                // true - recursively
                mkdir($uploadpath, 0777, true);

                // Download image from formatted URL
                $filedata = file_get_contents($URL);

                // Write the downloaded image to local file
                $uploadfilepath = $uploadpath  . $filename;
                file_put_contents($uploadfilepath, $filedata);

                // Dimensions check (calculate dimensions to make square)
                //list($width, $height) = getimagesize($uploadfilepath);
                //$largerSide = 0;
                //if (($width == $height) || ($width > $height)) 
                //{
                //    $largerSide = $width;
                //} 
                //else 
                //{
                //    $largerSide = $height;
                //}

                // Resizing

                //$localURL = "http://localhost/foxfish/" . $uploadFolder . $filepath;
                //$transformedURL = "http://localhost/foxfish/libs/imgd.php?src=$localURL&w=$largerSide&h=$largerSide&fill-to-fit=ffffff";  
                //$filedataTransformed = file_get_contents($transformedURL);
                //echo "Transforming: $transformedURL\n";
                //$uploadfilepathTransformed = $uploadpath . $filename;
                //file_put_contents($uploadfilepathTransformed, $filedataTransformed);
                //echo "Image transformed and saved successfully!\n\n\n";
            }
            fclose($handle);
            LogToFile("File . \"" . FILEPATH_IMAGE_URLS . "\" successfully downloaded.", "info");
        } 
        else 
        {
            echo "The file could " . FILEPATH_IMAGE_URLS . " not be opened";
            LogToFile("The file could " . FILEPATH_IMAGE_URLS . " not be opened", "error");
        }
    }
    else 
    {
        echo "The file " . FILEPATH_IMAGE_URLS . " doesn't exist";
        LogToFile("The file " . FILEPATH_IMAGE_URLS . " doesn't exist", "error");
    }

}
