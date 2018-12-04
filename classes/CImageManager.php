<?php
class CImageManager
{
    private $fileWithProductUrlsPath;
    private $downloadsFolder;
    private $localFilesPathsList;
    
    public function __construct($fileWithProductUrlsPath)
    {
        echo "jedu construct";
        
        $this->downloadsFolder = "downloads" . DIRECTORY_SEPARATOR . "download" . "-" . date("Y-m-d-H_m-i-s");
        $this->sourceFilePath = $this->fileWithProductUrlsPath;
    }

    /**
     * Downloads files from source file.
     * Directory structure remains the same.
     *
     * @param string $fileWithProductUrlsPath  Source file with urls.
     *
     */
    public function downloadFilesWithStructure()
    {
        if (file_exists($this->fileWithProductUrlsPath)) {
            $handle = fopen($this->fileWithProductUrlsPath, "r");
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
                    $outputFilePath = $downloadPath . $filename;
                    file_put_contents($outputFilePath, $filedata);
                    // Write local image path to a file
                    $formattedTextInput = $outputFilePath . PHP_EOL;
                    file_put_contents($tmp_path, $formattedTextInput, FILE_APPEND);
                }
                fclose($handle);
                Logger::logToFile("File \"" . $this->fileWithProductUrlsPath . "\" successfully uploaded and files downloaded with same structure.", "info");
            } else {
                echo "The file could " . $this->fileWithProductUrlsPath . " not be opened";
                Logger::logToFile("The file could " . $this->fileWithProductUrlsPath . " not be opened", "error");
            }
        } else {
            echo "The file " . $this->fileWithProductUrlsPath . " doesn't exist";
            Logger::logToFile("The file " . $this->fileWithProductUrlsPath . " doesn't exist", "error");
        }
    }
}
