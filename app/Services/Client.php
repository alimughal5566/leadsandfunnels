<?php
/**
 * Created by PhpStorm.
 * User: Jazib Javed
 * Date: 14/11/2019
 * Time: 2:32 AM
 */

namespace App\Services;

/**
 * Class Client
 * @package League\ColorExtractor
 */
class Client
{
    /**
     * @param $imagePath
     *
     * @return Image
     */
    public function loadJpeg($imagePath)
    {
        return new Image(imagecreatefromjpeg($imagePath));
    }

    /**
     * @param $imagePath
     *
     * @return Image
     */
    public function loadPng($imagePath)
    {
        return new Image(imagecreatefrompng($imagePath));
    }

    /**
     * @param $imagePath
     *
     * @return Image
     */
    public function loadGif($imagePath)
    {
        return new Image(imagecreatefromgif($imagePath));
    }
}
