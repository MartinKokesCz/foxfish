<?php
include_once $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . "libs" . DIRECTORY_SEPARATOR . "Download.php";
include_once $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . "libs" . DIRECTORY_SEPARATOR . "Logger.php";
include_once $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . "libs" . DIRECTORY_SEPARATOR . "Utils.php";
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
        $uploadfile = $_FILES['uploadfile'];
        // Filtered options from form.
        $optionSquarer = filter_input(INPUT_POST, "squarer");
        // Absolute path to the destination.
        $uploadfilepath = $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . "urlsSource" . DIRECTORY_SEPARATOR . random_str(20);
        // If file already exits, stop execution.
        if (!file_exists($uploadfilepath)) 
        {
            // If file size is too big, stop execution.
            if ($uploadfile['size'] > 524288) 
            {
                ?><span class="color-whiteish">File is too big. (over 524288 Bytes or 0.524288 Megabytes)</span><?php
                LogToFile("File is too big. (over 524288 Bytes or 0.524288 Megabytes)", "error");
                exit(1);
            }
            if ($uploadfile['type'] != "text/plain") 
            {
                ?><span class="color-whiteish">File type is NOT "text/plain"! Your file type: <?php echo $uploadfile['type']; ?></span><?php
                LogToFile("File type is NOT \"text/plain\"! Someone tried to upload" . $uploadfile['type'], "error");
                exit(2);
            }
            move_uploaded_file($uploadfile['tmp_name'], $uploadfilepath);
            ?>
            <span class="color-whiteish">File successfully uploaded to remote.</span><br>
            <span class="color-whiteish">Starting download and transform...</span><br>
            <span class="color-whiteish">Kecám, ještě to nic nedělá.</span><br><hr>
            <span class="color-whiteish">Debug info:<span><br>
            <span class="color-whiteish">File name: <?php echo basename($uploadfilepath); ?></span><br>
            <span class="color-whiteish">File type: <?php echo $uploadfile['type']; ?></span>
            <?php
            DownloadFilesWithStructure($uploadfilepath);
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