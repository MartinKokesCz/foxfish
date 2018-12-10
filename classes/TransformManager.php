<?php
class TransformManager
{
    private $optionsArr;

    public function __construct($optionsArr)
    {
        $this->optionsArr = $optionsArr;
    }



    public function transformImage()
    {
        var_dump($this->optionsArr);

        if ($this->optionsArr[1] == true) {
            if (!file_exists(Configuration::getTempFilePath())) {
                Logger::logToFile("File: " . Configuration::getTempFilePath() . "don't exist. Exiting. Code 3", "error");
                exit(3);
            }
            $handle = fopen(Configuration::getTempFilePath(), "r");
            if (!$handle) {
                Logger::logToFile("File: " . Configuration::getTempFilePath() . "couldn't be opened. Exiting. Code 4", "error");
                exit(4);
            }
            while (($line = fgets($handle)) !== false) {
                $line = trim($line);
                //var_dump($line);
                list($width, $height) = getimagesize($line);
                $largerSide = 0;
                if (($width == $height) || ($width > $height)) {
                    $largerSide = $width;
                } else {
                    $largerSide = $height;
                }

                $CImageLibCallURL = "localhost" . DIRECTORY_SEPARATOR . "classes" . DIRECTORY_SEPARATOR . "imgd.php?src=$line&w=$largerSide&h=$largerSide";
                $filedataTransformed = file_get_contents($CImageLibCallURL);
                $tranformedImagesFilePath =  $line;
                //var_dump($tranformedImagesFilePath);
                file_put_contents($tranformedImagesFilePath, $filedataTransformed);
            }
            //fopen(Configuration::getTempFilePath(), "w");
        }



        //$localURL = "http://localhost/foxfish/" . $uploadFolder . $filepath;
        //$transformedURL = "http://localhost/foxfish/libs/imgd.php?src=$localURL&w=$largerSide&h=$largerSide&fill-to-fit=ffffff";
        //$filedataTransformed = file_get_contents($transformedURL);
        //$uploadfilepathTransformed = $uploadpath . $filename;
        //file_put_contents($uploadfilepathTransformed, $filedataTransformed);
    }
}
