<?php
namespace App\Helpers;
use Illuminate\Support\Facades\Mail;

class ImageCompression_Helper
{

    static $instance = null;

    /**
     * @return return current class object
     */
    public static function getInstance(){
        if(self::$instance == null) {
            self::$instance = new ImageCompression_Helper();
        }
        return self::$instance;
    }

    private function __construct()
    {
        \Tinify\setKey(getenv('TINIFY_API_KEY'));
    }

    public function urlOk($url)
    {
        $headers = get_headers($url);
        $httpStatus = intval(substr($headers[0], 9, 3));
        if ($httpStatus < 400) {
            return true;
        }
        return false;
    }

    public function getRemoteFilesize($url, $formatSize = true, $useHead = true)
    {
        if (false !== $useHead) {
            stream_context_set_default(array('http' => array('method' => 'HEAD')));
        }
        $head = array_change_key_case(get_headers($url, 1));
        // content-length of download (in bytes), read from Content-Length: field
        $clen = isset($head['content-length']) ? $head['content-length'] : 0;

        // cannot retrieve file size, return "-1"
        if (!$clen) {
            return -1;
        }

        if (!$formatSize) {
            return $clen; // return size in bytes
        }

        return self::getImgFileSize($clen);
    }

    private function getImgFileSize($fileSize) {
        switch ($fileSize) {
            case $fileSize < 1024:
                $size = $fileSize . ' B';
                break;
            case $fileSize < 1048576:
                $size = round($fileSize / 1024, 2) . ' KiB';
                break;
            case $fileSize < 1073741824:
                $size = round($fileSize / 1048576, 2) . ' MiB';
                break;
            case $fileSize < 1099511627776:
                $size = round($fileSize / 1073741824, 2) . ' GiB';
                break;
        }

        return $size; // return formatted size
    }

    public function compress($localPath, $imagePath){
        try {
            $source = \Tinify\fromFile($localPath);
            $compressedImagePath = public_path("rs_tmp") . "/" . $imagePath;
            $source->toFile($compressedImagePath);
        } catch(\Tinify\AccountException $e) {
            // Verify your API key and account limit.
            $this->sendEmailToSupportTeam($e);
            return $localPath;
        } catch(\Tinify\ClientException $e) {
            // Check your source image and request options.
            return $localPath;
        } catch(\Tinify\ServerException $e) {
            // Temporary issue with the Tinify API.
            return $localPath;
        } catch(\Tinify\ConnectionException $e) {
            // A network connection error occurred.
            return $localPath;
        } catch(Exception $e) {
            // Something else went wrong, unrelated to the Tinify API.
            return $localPath;
        }

        return $compressedImagePath;
    }

    private function sendEmailToSupportTeam($exception) {
        $supportEmails = explode(",", getenv('SUPPORT_EMAILS'));
        $html = "Dear Support Team, <br/><br/>" .
            "An exception is with tinify library on LP Admin below are details <br/>" .
            "Error Code:" . $exception->getCode() . "<br/>".
            "Error Message:" . $exception->getMessage() . "<br/><br/>" .
            "Thanks";

        Mail::send([], [], function ($message) use ($supportEmails, $html) {
            $message->from("no-reply@leadpops.com", "Leadpops Admin")
                ->to($supportEmails)
                ->subject("LP Admin :: Tinify Account Exception")
                ->setBody($html, 'text/html');
        });
    }

}
