<?php
/**
 * Created by PhpStorm.
 * User: haroon
 * Date: 21/07/2020
 * Time: 17:28
 */

namespace App\Helpers;


class LauncherHelper
{
   public static function resizeImage($CurWidth, $CurHeight, $DestFolder, $SrcImage, $Quality, $ImageType, $resize, $TempSrc, $mobileDestination, $DestImageNameOrignal)
    {
        if ($CurWidth <= 0 || $CurHeight <= 0) {
            return false;
        }

        //move_uploaded_file($TempSrc, $DestImageNameOrignal);
        if ($resize) {
            //			320 X 70 is mobile

            $NewWidth = "";
            $NewHeight = "";
            $dimensions = explode("~", self::getImageDimensions($CurWidth, $CurHeight));
            $NewWidth = $dimensions[0];
            $NewHeight = $dimensions[1];
            //	die($dimensions);

            $NewCanves = imagecreatetruecolor($NewWidth, $NewHeight);
            switch ($ImageType) {
                case 'image/png':
                    // integer representation of the color black (rgb: 0,0,0)
                    $background = imagecolorallocate($NewCanves, 0, 0, 0);
                    // removing the black from the placeholder
                    imagecolortransparent($NewCanves, $background);

                    // turning off alpha blending (to ensure alpha channel information
                    // is preserved, rather than removed (blending with the rest of the
                    // image in the form of black))
                    imagealphablending($NewCanves, false);

                    // turning on alpha channel information saving (to ensure the full range
                    // of transparency is preserved)
                    imagesavealpha($NewCanves, true);

                    break;
                case "image/gif":
                    // integer representation of the color black (rgb: 0,0,0)
                    $background = imagecolorallocate($NewCanves, 0, 0, 0);
                    // removing the black from the placeholder
                    imagecolortransparent($NewCanves, $background);

                    break;
            }

            // Resize Image
            imagecopyresampled($NewCanves, $SrcImage, 0, 0, 0, 0, $NewWidth, $NewHeight, $CurWidth, $CurHeight);
            imagepng($NewCanves, $DestFolder);

            unset($NewCanves);
            // now resize the image to mobile 320 x 70
            // now resize the image to mobile 320 x 70
            //return "png";

            $NewWidth = "";
            $NewHeight = "";
            $dimensions = explode("~", self::getMobileImageDimensions($CurWidth, $CurHeight));
            $NewWidth = $dimensions[0];
            $NewHeight = $dimensions[1];
            //	die($dimensions);

            $NewCanves = imagecreatetruecolor($NewWidth, $NewHeight);
            switch ($ImageType) {
                case 'image/png':
                    // integer representation of the color black (rgb: 0,0,0)
                    $background = imagecolorallocate($NewCanves, 0, 0, 0);
                    // removing the black from the placeholder
                    imagecolortransparent($NewCanves, $background);

                    // turning off alpha blending (to ensure alpha channel information
                    // is preserved, rather than removed (blending with the rest of the
                    // image in the form of black))
                    imagealphablending($NewCanves, false);

                    // turning on alpha channel information saving (to ensure the full range
                    // of transparency is preserved)
                    imagesavealpha($NewCanves, true);

                    break;
                case "image/gif":
                    // integer representation of the color black (rgb: 0,0,0)
                    $background = imagecolorallocate($NewCanves, 0, 0, 0);
                    // removing the black from the placeholder
                    imagecolortransparent($NewCanves, $background);

                    break;
            }

            // Resize Image
            imagecopyresampled($NewCanves, $SrcImage, 0, 0, 0, 0, $NewWidth, $NewHeight, $CurWidth, $CurHeight);
            imagepng($NewCanves, $mobileDestination);

            // now resize the image to mobile 320 x 70
            // now resize the image to mobile 320 x 70
            move_uploaded_file($TempSrc, $DestImageNameOrignal);
            return "png";
        } else {
            // still need to create mobile image
            $NewWidth = "";
            $NewHeight = "";
            $dimensions = explode("~", self::getMobileImageDimensions($CurWidth, $CurHeight));
            $NewWidth = $dimensions[0];
            $NewHeight = $dimensions[1];
            //	die($dimensions);

            $NewCanves = imagecreatetruecolor($NewWidth, $NewHeight);
            switch ($ImageType) {
                case 'image/png':
                    // integer representation of the color black (rgb: 0,0,0)
                    $background = imagecolorallocate($NewCanves, 0, 0, 0);
                    // removing the black from the placeholder
                    imagecolortransparent($NewCanves, $background);

                    // turning off alpha blending (to ensure alpha channel information
                    // is preserved, rather than removed (blending with the rest of the
                    // image in the form of black))
                    imagealphablending($NewCanves, false);

                    // turning on alpha channel information saving (to ensure the full range
                    // of transparency is preserved)
                    imagesavealpha($NewCanves, true);

                    break;
                case "image/gif":
                    // integer representation of the color black (rgb: 0,0,0)
                    $background = imagecolorallocate($NewCanves, 0, 0, 0);
                    // removing the black from the placeholder
                    imagecolortransparent($NewCanves, $background);

                    break;
            }

            // Resize Image
            imagecopyresampled($NewCanves, $SrcImage, 0, 0, 0, 0, $NewWidth, $NewHeight, $CurWidth, $CurHeight);
            imagepng($NewCanves, $mobileDestination);

            // now resize the image to mobile 320 x 70
            // now resize the image to mobile 320 x 70


            if (move_uploaded_file($TempSrc, $DestFolder)) {
                copy($DestFolder, $DestImageNameOrignal);
            }
            //move_uploaded_file($TempSrc, $DestImageNameOrignal);
            return "original-name";
        }

    }

   public static function getImageDimensions ($w,$h) {

        if ($w <= 350 && $h <= 130 ) {
            return $w . "~" . $h;
        }
        else { // must resize
            $ratio = ($w / $h);
            //die($ratio);
            // 1309/718
            do  {
                $w -= $ratio;
                $h -= 1;
            } while ($w > 350 || $h > 130);
            return $w . "~" . $h;
        }


    }

    public static function generateRandomString($length = 5) {
        return substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, $length);
    }


   public static function  getMobileImageDimensions ($w,$h) {
        if ($w <= 320 && $h <= 71 ) {
            return $w . "~" . $h;
        }
        else { // must resize
            $ratio = ($w / $h);
            //die($ratio);
            // 1309/718
            do  {
                $w -= $ratio;
                $h -= 1;
            } while ($w > 320 || $h > 71);
            return $w . "~" . $h;
        }
    }

}