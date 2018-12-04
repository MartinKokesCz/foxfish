<?php
class Transform
{
    private $optionsArr;

    public function __construct($optionsArr)
    {
        $this->optionsArr = $optionsArr;
    }



    public function transformImage()
    {
        var_dump($this->optionsArr);
        //list($width, $height) = getimagesize($uploadfilepath);
        //$largerSide = 0;
        //if (($width == $height) || ($width > $height)) {
        //    $largerSide = $width;
        //} else {
        //    $largerSide = $height;
        //}
        //// Resizin
        //$localURL = "http://localhost/foxfish/" . $uploadFolder . $filepath;
        //$transformedURL = "http://localhost/foxfish/libs/imgd.php?src=$localURL&w=$largerSide&h=$largerSide&fill-to-fit=ffffff";
        //$filedataTransformed = file_get_contents($transformedURL);
        //$uploadfilepathTransformed = $uploadpath . $filename;
        //file_put_contents($uploadfilepathTransformed, $filedataTransformed);
    }
}
