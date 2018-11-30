<?php
include_once $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . "libs" . DIRECTORY_SEPARATOR . "Logger.php";
class CImageManager
{
    // Dodělat, prosím.
    private const LOCAL = "/tmp";

    private $websiteURL;
    private $uploadFolder;
    private $inputFilePath;

    public function __construct($websiteURL, $inputFilePath) {
        $this->websiteURL = $websiteURL;
        $this->downloadsFolder = "downloads" . DIRECTORY_SEPARATOR . "upload" . "-" . date("Y-m-d-H_m-i-s");
        $this->inputFilePath = $inputFilePath;
    }


    /**
     * Downloads files from source file.
     * Directory structure remains the same.
     * 
     * 
     * 
     */
    public function downloadFilesWithStructure()
    {

        if (file_exists($this->inputFilePath)) 
        {
            $handle = fopen($this->inputFilePath, "r");
            if ($handle) 
            {

                while (($line = fgets($handle)) !== false) 
                {
                    $URL = preg_replace("/\r|\n/", "", $line);
                    // remove the protocol and domain from string
                    $filepath = parse_url($URL, PHP_URL_PATH);
                    $filename = basename($filepath);

                    // remove file name from the path
                    $folderpath = str_replace($filename, "", $filepath);

                    $uploadpath = $uploadFolder . $folderpath;
                    mkdir($uploadpath, 0777, true);

                    // Download image from formatted URL
                    $filedata = file_get_contents($URL);

                    // Write the downloaded image to local file
                    $inputFilePath = $uploadpath  . $filename;
                    file_put_contents($inputFilePath, $filedata);
                }
                fclose($handle);
                LogToFile("File \"" . $this->inputFilePath . "\" successfully downloaded.", "info");
            } 
            else 
            {
                echo "The file could " . $this->inputFilePath . " not be opened";
                LogToFile("The file could " . $this->inputFilePath . " not be opened", "error");
            }
        }
        else 
        {
            echo "The file " . $this->inputFilePath . " doesn't exist";
            LogToFile("The file " . $this->inputFilePath . " doesn't exist", "error");
        }

    }
}
