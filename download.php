<?php

require_once "config.php";


// test
// edit the file in excel and remove all not needed columns and characters
// there should be only URLs one each line

if (!file_exists("./imgd.php")) {
    $imgdDataTemp = file_get_contents(CIMAGE_URL);

    //$imgDataRemoteEnabled = str_replace("//'remote_allow'", "'remote_allow'", $imgdDataTemp);
    //file_put_contents("imgd.php", $imgDataRemoteEnabled);

    //unlink('imgdTemp.php');
}

$counter;

if (file_exists(FILEPATH_IMAGE_URLS)) {
    echo "\n\n===Starting===\n\n";

    $handle = fopen(FILEPATH_IMAGE_URLS, "r");
    if ($handle) {
        $uploadFolder = "upload" . "-" . date("Y-m-d-H_m-i-s");
        while (($line = fgets($handle)) !== false) {

            if ($counter % 1000 == 0) {
                echo $counter." files processed.";
            }


            $URL = preg_replace("/\r|\n/", "", $line);
            //echo "URL: $URL\n";
            // remove the protocol and domain from string
            $filepath = parse_url($URL, PHP_URL_PATH);
            //echo "Filepath: $filepath\n";


            // get file name only
            $filename = basename($filepath);
            //echo "Filename: $filename\n";

            // remove file name from the path
            $folderpath = str_replace($filename, "", $filepath);
            //echo "Folderpath: $folderpath\n";


            $uploadpath = __DIR__ . DIRECTORY_SEPARATOR . $uploadFolder . $folderpath;
            // true - recursively
            mkdir($uploadpath, 0777, true);
            //echo "Creating folder: $uploadpath\n";

            // Download image from formatted URL
            $filedata = file_get_contents($URL);
            if ($filedata == null) {
                echo "Image empty! Skipping download and reversing!".PHP_EOL.PHP_EOL;
                rmdir($uploadpath);
                continue;
            }
            //echo "Downloaded: $URL\n";

            // Write the downloaded image to local file
            $uploadfilepath = $uploadpath  . $filename;
            file_put_contents($uploadfilepath, $filedata);
            //echo "Uploads filepath: $uploadfilepath\n";

            // Dimensions check (calculate dimensions to make square)
            list($width, $height) = getimagesize($uploadfilepath);
            $largerSide = 0;
            if (($width == $height) || ($width > $height)) {
                $largerSide = $width;
            } else {
                $largerSide = $height;
            }

            //echo "File downloaded!\n\n";

            $localURL = "http://localhost/foxfish/" . $uploadFolder . $filepath;
            //echo $localURL.PHP_EOL;

            $transformedURL = "http://localhost/foxfish/imgd.php?src=$localURL&w=$largerSide&h=$largerSide&fill-to-fit=ffffff";

            $filedataTransformed = file_get_contents($transformedURL);
            //echo "Downloading transformed: $transformedURL\n";
            $uploadfilepathTransformed = $uploadpath . $filename;
            file_put_contents($uploadfilepathTransformed, $filedataTransformed);
            $counter++
        }
        fclose($handle);
    } else {
        echo " the file could " . FILEPATH_IMAGE_URLS . " not be opened";
    }
} else {
    echo "the file " . FILEPATH_IMAGE_URLS . " doesn't exist";
}

echo "DONE!";