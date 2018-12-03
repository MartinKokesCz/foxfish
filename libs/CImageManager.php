<?php
include_once $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . "libs" . DIRECTORY_SEPARATOR . "Logger.php";
class CImageManager
{
    private $sourceFilePath;
    private $downloadsFolder;
    private $tmp_path;
    
    public function __construct($sourceFilePath, $tmp_path, $downloadsFolder)
    {
        $this->$tmp_path = $_SERVER['DOCUMENT_ROOT'] . "/tmp" . DIRECTORY_SEPARATOR . "temporary.tmp";
        $this->downloadsFolder = "downloads" . DIRECTORY_SEPARATOR . "download" . "-" . date("Y-m-d-H_m-i-s");
        $this->sourceFilePath = $sourceFilePath;
    }

    /**
     * Downloads files from source file.
     * Directory structure remains the same.
     *
     * @param string $sourceFilePath  Source file with urls.
     *
     */
    public function downloadFilesWithStructure($sourceFilePath)
    {
        if (file_exists($sourceFilePath)) {
            $handle = fopen($sourceFilePath, "r");
            if ($handle) {
                while (($line = fgets($handle)) !== false) {
                    $URL = preg_replace("/\r|\n/", "", $line);
                    $filepath = parse_url($URL, PHP_URL_PATH);
                    $filename = basename($filepath);
                    // remove file name from the path
                    $folderpath = str_replace($filename, "", $filepath);

                    $downloadPath = $this->$downloadsFolder . $folderpath;
                    mkdir($downloadPath, 0777, true);
                    // Download image from formatted URL
                    $filedata = file_get_contents($URL);
                    // Write the downloaded image to local file
                    $outputFilePath = $downloadPath  . $filename;
                    file_put_contents($outputFilePath, $filedata);
                    // Write local image path to a file
                    $formattedTextInput = $outputFilePath . PHP_EOL;
                    file_put_contents($tmp_path, $formattedTextInput, FILE_APPEND);
                }
                fclose($handle);
                log_to_file("File \"" . $sourceFilePath . "\" successfully uploaded and files downloaded with same structure.", "info");
            } else {
                echo "The file could " . $sourceFilePath . " not be opened";
                log_to_file("The file could " . $sourceFilePath . " not be opened", "error");
            }
        } else {
            echo "The file " . $sourceFilePath . " doesn't exist";
            log_to_file("The file " . $sourceFilePath . " doesn't exist", "error");
        }
    }
}
