<?php

// edit the file in excel and remove all not needed columns and characters
// there should be only URLs one each line

echo "\n\n===Starting===\n\n";

$handle = fopen("example-small.txt", "r");
if ($handle) {
    while (($line = fgets($handle)) !== false) {
        $URL = preg_replace("/\r|\n/", "", $line);
        echo "URL: $URL\n";
        // remove the protocol and domain from string
        $filepath = parse_url($URL, PHP_URL_PATH);
        echo "Filepath: $filepath\n";

        // get file name only
        $filename = basename($filepath);
        echo "Filename: $filename\n";

        // remove file name from the path
        $folderpath = str_replace($filename, "", $filepath);
        echo "Folderpath: $folderpath\n";

        $uploadpath = __DIR__ . DIRECTORY_SEPARATOR . "upload" . $folderpath;
        // true - recursively
        mkdir($uploadpath, 0777, true);
        echo "Creating folder: $uploadpath\n";

        $filedata = file_get_contents($URL);
        echo "Downloading : $URL\n";
        $uploadfilepath = $uploadpath  . $filename;
        echo "Uploads filepath: $uploadfilepath\n";
        file_put_contents($uploadfilepath, $filedata);

        echo "File downloaded!\n\n";
    }

    fclose($handle);
} else {
}
