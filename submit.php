<?php
/**
 * Input form
 * php version 7.2
 *
 * @category ImageManipulation\submit
 * @package  KokyIMage
 * @author   Martin Kokeš <info@martinkokes.cz>
 * @author   Jan Pilař <pilarjan4111@gmail.com>
 * @license  GPL https://choosealicense.com/licenses/gpl-3.0/
 * @version  GIT: $Id$ In development. Unstable.
 * @link     imgmod.martinkokes.cz
 */

require_once __DIR__ . DIRECTORY_SEPARATOR . "vendor" . DIRECTORY_SEPARATOR . "autoload.php";

spl_autoload_register(
    function ($class) {
        include 'classes/' . $class . '.php';
    }
);

//Configuration::getInstance();

?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Results</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="css/main.css" />
</head>

<body>
    <?php
        // Filtered file from upload.
        $uploadedFile = $_FILES['uploadfile'];

        $optionsArr = array(
            $tranformQuestion = null,
            $squarer = null,
            $fillToFit = null

        );
        
        if (!isset($_POST["tranformQuestion"])
            && $_POST["tranformQuestion"] = "true"
        ) {
            $optionsArr[0] = true;
        } else {
            $optionsArr[0] = false;
        }

        if (isset($_POST["squarer"])
            && $_POST["squarer"] = "true"
        ) {
            $optionsArr[1] = true;
        } else {
            $optionsArr[1] = false;
        }

        if (isset($_POST["FillToFit"])
            && $_POST["FillToFit"] = "true"
        ) {
            $optionsArr[2] = true;
        } else {
            $optionsArr[2] = false;
        }
        








        // Absolute path to the destination.
        $fileWithProductUrlsPath = __DIR__ . DIRECTORY_SEPARATOR
        . "urlsSource" . DIRECTORY_SEPARATOR . Utils::randomStr(20) . ".txt";
        // If file already exits, stop execution.
        if (!file_exists($fileWithProductUrlsPath)) {
            // If file size is too big, stop execution.
            if ($uploadedFile['size'] > 524288) {
                ?><span class="color-whiteish">File is too big. (over 524288 Bytes or 0.524288 Megabytes)</span><?php
                Logger::logToFile("File is too big. Over 524288 Bytes or 0.524288 Megabytes)", "error");
                exit(1);
            }
            if ($uploadedFile['type'] != "text/plain") {
                ?><span class="color-whiteish">File type is NOT "text/plain"! Your file type: <?php echo $uploadedFile['type']; ?></span><?php
                Logger::logToFile("File type is NOT \"text/plain\"! Someone tried to upload" . $uploadedFile['type'], "error");
                exit(2);
            }
            move_uploaded_file($uploadedFile['tmp_name'], $fileWithProductUrlsPath); ?>
            <div class="color-whiteish">
                <span>Input file successfully uploaded to remote.</span><br>
                <span>Starting download. If you selected tranform, then transforming too.</span><br>
                <hr>
                <span>File name: <?php echo basename($fileWithProductUrlsPath); ?></span><br>
                <span>File path: <?php echo $fileWithProductUrlsPath; ?></span><br>
                <span>File type: <?php echo $uploadedFile['type']; ?></span><br>
                <span>Log folder: <?php echo Configuration::getLogDir(); ?></span><br>
            </div>
            <?php

            $downloadManager = new DownloadManager($fileWithProductUrlsPath);
            // Tranform Function TO DO
            if ($optionsArr[0] == false) {
                $downloadManager->downloadFilesWithStructure();
                exit(0);
            }

            if ($optionsArr[0] == true) {
                $downloadManager->downloadFilesWithStructure();
                $tranformManager = new TransformManager($optionsArr);
                $tranformManager->transformImage();
            }
        } else {
            ?>
            <span class="color-whiteish">File already exist on remote. Delete it on FTP or change the filename. No web interface avaible.</span><br>
            <a href="index.html" class="no-decoration">Back to the main page</a>
            <?php
        }
        
        ?>

</body>

</html>