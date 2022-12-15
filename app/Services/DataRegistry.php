<?php
/**
 * Created by PhpStorm.
 * User: Jazib Javed
 * Date: 07/11/2019
 * Time: 7:18 PM
 */

namespace App\Services;
use Exception;
use Illuminate\Support\Facades\Session;

class DataRegistry
{
    /**
     * @var $leadpops \stdClass
     */
    public $leadpops;

    public function __construct(){
    }

    public static function getInstance(){
        static $self = null;
        if ($self === null) {
            $self = new DataRegistry();
        }

        $self->_initProperties();
        return $self;
    }

    public function _initProperties($props = array()){
        $this->leadpops = new \stdClass();

        if(!empty($props)){
            $this->leadpops = $props;
        }
        else{
            if(Session::has('leadpops')){
                $this->leadpops = Session::get('leadpops');
            }
        }

    }

    public function updateRegistry(){
        Session::put('leadpops', $this->leadpops);
    }

}