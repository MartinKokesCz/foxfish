<?php
include_once __DIR__ . DIRECTORY_SEPARATOR . "vendor" . DIRECTORY_SEPARATOR . "autoload.php";

spl_autoload_register(function ($class) {
    include 'classes/' . $class . '.php';
});

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
    <script type="text/javascript" src="js/Utils.js"></script>
</head>

<body>
    <?php
        // Filtered file from upload.
        $uploadedFile = $_FILES['uploadfile'];
        // Null to false
        $nullToFalse = array('options' => array('default'=> false));
        //

        $optionsArr = array(
            $tranformQuestion = null,
            $squarer = null,
            $fillToFit = null

        );

        // Filtered options from form.
        $optionWidth = filter_input(INPUT_POST, "width");
        $optionHeight = filter_input(INPUT_POST, "height");
        
        if (!isset($_POST["tranformQuestion"]) && $_POST["tranformQuestion"] = "true") {
            $optionsArr[0] = true;
        } else {
            $optionsArr[0] = false;
        }

        if (isset($_POST["squarer"]) && $_POST["squarer"] = "true") {
            $optionsArr[1] = true;
        } else {
            $optionsArr[1] = false;
        }

        if (isset($_POST["FillToFit"]) && $_POST["FillToFit"] = "true") {
            $optionsArr[2] = true;
        } else {
            $optionsArr[2] = false;
        }
        








        // Absolute path to the destination.
        $fileWithProductUrlsPath = $_SERVER["DOCUMENT_ROOT"] . DIRECTORY_SEPARATOR . "urlsSource" . DIRECTORY_SEPARATOR . Utils::random_str(20) . ".txt";
        // If file already exits, stop execution.
        if (!file_exists($fileWithProductUrlsPath)) {
            // If file size is too big, stop execution.
            if ($uploadedFile['size'] > 524288) {
                ?><span class="color-whiteish">File is too big. (over 524288 Bytes or 0.524288 Megabytes)</span><?php
                Logger::logToFile("File is too big. (over 524288 Bytes or 0.524288 Megabytes)", "error");
                exit(1);
            }
            if ($uploadedFile['type'] != "text/plain") {
                ?><span class="color-whiteish">File type is NOT "text/plain"! Your file type: <?php echo $uploadedFile['type']; ?></span><?php
                Logger::logToFile("File type is NOT \"text/plain\"! Someone tried to upload" . $uploadedFile['type'], "error");
                exit(2);
            }
            move_uploaded_file($uploadedFile['tmp_name'], $fileWithProductUrlsPath); ?>
            <div class="color-whiteish">
                <span>File successfully uploaded to remote.</span><br>
                <span>Starting download. If you selected tranform, then transforming too.</span><br>
                <hr>
                <span>File name: <?php echo basename($fileWithProductUrlsPath); ?></span><br>
                <span>File path: <?php echo $fileWithProductUrlsPath; ?></span><br>
                <span>File type: <?php echo $uploadedFile['type']; ?></span><br>
                <span>Log folder: <?php echo Configuration::getLogDir(); ?></span><br>
            </div>
            <?php

            var_dump($optionWidth, $optionHeight);
            var_dump($optionsArr[0], $optionsArr[1], $optionsArr[2]);


            // Tranform Function TO DO
            if ($optionsArr[0] == false) {
                $downloadManager = new DownloadManager($fileWithProductUrlsPath);
                $downloadManager->downloadFilesWithStructure();
                exit(0);
            }

            if ($optionsArr[0] == true) {
                $downloadManager = new DownloadManager($fileWithProductUrlsPath);
                $downloadManager->downloadFilesWithStructure();
                $tranformManager = new TransformManager($optionsArr);
                $tranformManager->tranformImage();
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