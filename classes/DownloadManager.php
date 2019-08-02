<?php
/**
 * Download manager
 * php version 7.2
 *
 * @category ImageManipulation\DownloadManager
 * @package  KokyIMage
 * @author   Martin Kokeš <info@martinkokes.cz>
 * @author   Jan Pilař <pilarjan4111@gmail.com>
 * @version  GIT: $Id$ In development. Unstable.
 * @link     imgmod.martinkokes.cz
 */


/**
 * Manages downloads from submitted plain text file.
 *
 * @category ImageManipulation\DownloadManager\DownloadManager
 * @package  KokyIMage
 * @author   Martin Kokeš <info@martinkokes.cz>
 * @author   Jan Pilař <pilarjan4111@gmail.com>
 * @link     imgmod.martinkokes.cz
 */
class DownloadManager
{
    private $downloadsFolder;
    private $tmpFolder;
    private $tmpFile;
    private $transformFolder;
    
    /**
     * Constructor class
     */
    public function __construct()
    {
        $this->downloadsFolder = getenv("DOWNLOADS_DATA_FOLDER")
        . DIRECTORY_SEPARATOR . "download" . "-" . date("Y-m-d-H_m-i-s");
        $this->tmpFolder = getenv("TMP_FOLDER");
        $this->tmpFile = getenv("TMP_FILE");
        $this->transformFolder = getenv("TRANSFORM_FOLDER");
    }

    /**
     * Downloads files from source file.
     * Directory structure remains the same.
     *
     * @return void
     */
    public function downloadFilesWithStructure($fileWithProductUrlsPath)
    {
        if (file_exists($fileWithProductUrlsPath)) {
            $handle = fopen($fileWithProductUrlsPath, "r");
            if ($handle) {
                while (($line = fgets($handle)) !== false) {
                    $URL = preg_replace("/\r|\n/", "", $line);
                    $filepath = parse_url($URL, PHP_URL_PATH);
                    $filename = basename($filepath);
                    // remove file name from the path
                    $folderpath = str_replace($filename, "", $filepath);

                    $downloadPath = $this->downloadsFolder . $folderpath;
                    mkdir($downloadPath, 0777, true);
                    // Download image from formatted URL
                    $filedata = file_get_contents($URL);
                    // Write the downloaded image to local file
                    $outputFilePath = $downloadPath . $filename;
                    file_put_contents($outputFilePath, $filedata);

                    var_dump($outputFilePath);
                    //var_dump($this->transformFolder);
                    $call = "http://localhost/foxfish/classes/imgd.php?src=$outputFilePath&fill-to-fit=006600";
                    $transformedData = file_get_contents($call);
                    file_put_contents($this->transformFolder.$outputFilePath, $transformedData);

                    // Write local image path to a file
                    //$formattedTextInput = $outputFilePath . PHP_EOL;
                    //if (!file_exists($this->tmpFile)) {
                    //    touch($this->tmpFile);
                    //}
                    //file_put_contents($this->tmpFile, $formattedTextInput, FILE_APPEND);
                }
                fclose($handle);
            }
        }
    }

    private function transform($urlTransform)
    {
        
    }


}
