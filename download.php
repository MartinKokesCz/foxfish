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


        //path for the image
        $source_url = $uploadfilepath;

        //separate the file name and the extention
        $source_url_parts = pathinfo($source_url);
        $filename = $source_url_parts['filename'];
        $extension = $source_url_parts['extension'];

        //define the quality from 1 to 100
        $quality = 100;

        //detect the width and the height of original image
        list($width, $height) = getimagesize($source_url);
        $width;
        $height;

        //define any width that you want as the output. mine is 200px.
        $after_width = 250;

        //resize only when the original image is larger than expected with.
        //this helps you to avoid from unwanted resizing.
        if ($width > $after_width) {

      //get the reduced width
            $reduced_width = ($width - $after_width);
            //now convert the reduced width to a percentage and round it to 2 decimal places
            $reduced_radio = round(($reduced_width / $width) * 100, 2);

            //ALL GOOD! let's reduce the same percentage from the height and round it to 2 decimal places
            $reduced_height = round(($height / 100) * $reduced_radio, 2);
            //reduce the calculated height from the original height
            $after_height = $height - $reduced_height;

            //Now detect the file extension
            //if the file extension is 'jpg', 'jpeg', 'JPG' or 'JPEG'
            if ($extension == 'jpg' || $extension == 'jpeg' || $extension == 'JPG' || $extension == 'JPEG') {
                //then return the image as a jpeg image for the next step
                $img = imagecreatefromjpeg($source_url);
            } elseif ($extension == 'png' || $extension == 'PNG') {
                //then return the image as a png image for the next step
                $img = imagecreatefrompng($source_url);
            } else {
                //show an error message if the file extension is not available
                echo 'image extension is not supporting';
            }

            //HERE YOU GO :)
            //Let's do the resize thing
            //imagescale([returned image], [width of the resized image], [height of the resized image], [quality of the resized image]);
            $imgResized = imagescale($img, $after_width, $after_height, $quality);

            //now save the resized image with a suffix called "-resized" and with its extension.
            imagejpeg($imgResized, $filename . '-resized.'.$extension);

            //Finally frees any memory associated with image
            //**NOTE THAT THIS WONT DELETE THE IMAGE
            imagedestroy($img);
            imagedestroy($imgResized);
        }


        echo "File downloaded!\n\n";
    }

    fclose($handle);
} else {
}
