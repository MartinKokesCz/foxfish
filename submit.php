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
        // Absolute path to the destination.
        $uploadfilepath = __DIR__ . DIRECTORY_SEPARATOR . "source" . DIRECTORY_SEPARATOR . $uploadfile['name'];
        // If file already exits, stop execution.
        if (!file_exists($uploadfilepath)) 
        {
            if ($uploadfile['size'] > 524288) 
            {
                echo("File is too big. (over 524288 Bytes or 0.524288 Megabytes)");
                exit(1);
            }
            move_uploaded_file($uploadfile['tmp_name'], $uploadfilepath);
            ?>
            <span class="color-whiteish">File successfully uploaded to remote.</span><br>
            <span class="color-whiteish">Starting download and transform...</span><br>
            <span class="color-whiteish">Kecám, ještě to nic nedělá.</span><br>
            <?php
            // TO DO volání resize skriptu
            // include("download.php");
        }
        else
        {
            ?>
            <span class="color-whiteish">File already exist on remote. Delete it on FTP. No web interface avaible.</span><br>
            <a href="index.html" class="no-decoration">Back to the main page</a>

            <?php
        }
        
    ?>

</body>

</html>