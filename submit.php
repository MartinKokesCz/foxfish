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
    <title>submit file</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="css/main.css" />
</head>

<body>
    <?php
        // Filtered file from upload.
        $uploadedFile = $_FILES['uploadfile'];
        // Filtered options from form.
        $optionSquarer = filter_input(INPUT_POST, "squarer");

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
            move_uploaded_file($uploadedFile['tmp_name'], $fileWithProductUrlsPath);
            
            ?>
            <div class="color-whiteish">
                <span>File successfully uploaded to remote.</span><br>
                <span>Starting download and transform...</span><br>
                <span>Kecám, ještě to nic nedělá.</span><br><hr>
                <span>Debug info:<span><br>
                <span>File name: <?php echo basename($fileWithProductUrlsPath); ?></span><br>
                <span>File path: <?php echo $fileWithProductUrlsPath; ?></span><br>
                <span>File type: <?php echo $uploadedFile['type']; ?></span><br>
                <span>Log folder: <?php echo Configuration::getLogDir(); ?></span><br>
            </div>
            <?php
            var_dump($fileWithProductUrlsPath);
            $cImageManager = new CImageManager($fileWithProductUrlsPath);
            $cImageManager->downloadFilesWithStructure();
        }
        else
        {
            ?>
            <span class="color-whiteish">File already exist on remote. Delete it on FTP or change the filename. No web interface avaible.</span><br>
            <a href="index.html" class="no-decoration">Back to the main page</a>
            <?php
        }
        
    ?>

</body>

</html>