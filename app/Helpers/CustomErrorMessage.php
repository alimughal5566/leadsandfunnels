<?php


namespace App\Helpers;
use Session;

class CustomErrorMessage
{
    private static $instance = null;
    private $errorMessages = [
        'logos_count' => "Maximum of three logos uploaded at one time. Delete one logo then upload its replacement.",
        'max_image_size' => "The file is too large. Maximum allowed file size is [:IMAGE_SIZE]MB.",
        'image_mimes' => "Please use an image in one of these formats: GIF, PNG, JPG, or JPEG."
    ];

    public static function getInstance(){
        if(self::$instance == null) {
            self::$instance = new CustomErrorMessage();
        }
        return self::$instance;
    }

    public function getMessages() {
        return $this->errorMessages;
    }

    public function getByKey($key, $error = null) {
        $error_message = $this->errorMessages[$key];

        if($error && isset($error["Max"])) {
            $error_message = str_replace("[:IMAGE_SIZE]", ($error["Max"][0]/1024), $error_message);
        }
        return $error_message;
    }

    public function getFirstError($validator, $firstKey = false) {
        $failed = $validator->failed();
        if(!$firstKey) {
            $firstKey = array_key_first($failed);
        }
        if(isset($failed[$firstKey]["Mimes"])) {
            /**
             * As GIF isn't allowed for background image, so removing it from message too
             */
            if($firstKey == "background_name") {
                return str_replace(" GIF,", "", $this->getByKey("image_mimes"));
            }
            return $this->getByKey("image_mimes");
        }

        return $this->getByKey("max_image_size", $failed[$firstKey]);
    }

    public function setFirstError($validator, $firstKey = false) {
        $error_message = $this->getFirstError($validator, $firstKey);
        return $error_message;
    }
}
