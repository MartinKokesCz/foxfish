<?php
/**
 * Transform manager
 * php version 7.2
 *
 * @category ImageManipulation\TranformManager
 * @package  KokyIMage
 * @author   Martin Kokeš <info@martinkokes.cz>
 * @author   Jan Pilař <pilarjan4111@gmail.com>
 * @license  GPL https://choosealicense.com/licenses/gpl-3.0/
 * @link     imgmod.martinkokes.cz
 */

/**
 * Transform manager class
 * php version 7.2
 *
 * @category ImageManipulation\TranformManager\TranformManager
 * @package  KokyIMage
 * @author   Martin Kokeš <info@martinkokes.cz>
 * @author   Jan Pilař <pilarjan4111@gmail.com>
 * @license  GPL https://choosealicense.com/licenses/gpl-3.0/
 * @link     imgmod.martinkokes.cz
 */
class TransformManager
{
    /**
     * Constructor class
     */
    public function __construct()
    {
    }


    /**
     * Transform downloaded file structure
     * with images with parameters from options input.
     *
     * @return void
     */
    public function transformImage()
    {
        $handle = fopen(Configuration::getTempFilePath(), "r");

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

            $CImageLibCallURL = "localhost" . DIRECTORY_SEPARATOR . "classes" . DIRECTORY_SEPARATOR
                . "imgd.php?src=$line&w=$largerSide&h=$largerSide";
            $filedataTransformed = file_get_contents($CImageLibCallURL);
            $tranformedImagesFilePath =  $line;
            //var_dump($tranformedImagesFilePath);
            file_put_contents($tranformedImagesFilePath, $filedataTransformed);
        }
        //fopen(Configuration::getTempFilePath(), "w");
        



        //$localURL = "http://localhost/foxfish/" . $uploadFolder . $filepath;
        //$transformedURL = "http://localhost/foxfish/libs/imgd.php?src=$localURL&w=$largerSide&h=$largerSide&fill-to-fit=ffffff";
        //$filedataTransformed = file_get_contents($transformedURL);
        //$uploadfilepathTransformed = $uploadpath . $filename;
        //file_put_contents($uploadfilepathTransformed, $filedataTransformed);
    }
}
