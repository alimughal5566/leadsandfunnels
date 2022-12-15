<?php

/**
 * Created by PhpStorm.
 * User: Jazib Javed
 * Date: 25/11/2019
 * Time: 8:32 PM
 */

namespace App\Services;
class Overlay
{

    const LP_VERSION = '1.3.1';
    private $path;
    private $url;
    private $data;
    private $db;
    private $client_id;
    private $overlay_flag;
    private $vertical_id;
    private $service_base_url;
    const MODE = "live";

    public static function getInstance(){
        static $self = null;
        if($self===null){
            $self= new Overlay();
        }
        return $self;
    }

    /**
     * Overlay constructor.
     */
    private function __construct()
    {

        $this->data = false;
        $this->path = __DIR__.'/leadpops_helper/';
        if(Overlay::MODE=='dev'){
            $this->url = "http://myleads.local/application/external/leadpops_helper/";
            $this->service_base_url = "http://leadpops-helper.local/";
        }else{
            $this->url = "https://myleads.leadpops.com/application/external/leadpops_helper/";
            $this->service_base_url = "http://leadpops_helper.leadpops.com/";
        }
        $this->overlay_flag=false;
        $this->vertical_id = 13; // Todo: Mortgage


        $registry = Zend_Registry::getInstance();
        if(@$_SESSION['leadpops']['client_id'] && @$_SESSION['leadpops']['client_id']==830 && $registry->leadpops->show_overlay==1){
//            $registry->leadpops->show_overlay = 0;
            $dbAdapters = Zend_Registry::get('dbAdapters');
            $this->db = $dbAdapters['client'];
            $this->client_id = $_SESSION['leadpops']['client_id'];
            $this->overlay_flag = $this->db->fetchOne("select overlay_flag from clients where client_id=".$this->client_id);

        }
        $this->get_overlay_detail();
    }

    public function get_overlay_detail(){
        if($this->overlay_flag){
            $service_url = $this->service_base_url.'api/v1/vertical/'.$this->vertical_id;
            $curl = curl_init($service_url);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            $curl_response = curl_exec($curl);
            curl_close($curl);
            if(@$curl_response){
                $this->data = json_decode($curl_response);
            }
        }
    }


    public function get_html(){
        if($this->overlay_flag){
            $attr = [
                'lp_base_path' => $this->path,
                'lp_base_url' => $this->url,
                'lp_data' => $this->data,
                'client_id' => $this->client_id,
                'lp_vertical_summry_title' => $this->vertical_summry_title
            ];
            extract($attr);
            include $this->path.'index.php';
        }
    }

    /**
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * @param string $path
     */
    public function setPath($path)
    {
        $this->path = $path;
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param string $url
     */
    public function setUrl($url)
    {
        $this->url = $url;
    }

    /**
     * @return bool
     */
    public function isData()
    {
        return $this->data;
    }

    /**
     * @param bool $data
     */
    public function setData($data)
    {
        $this->data = $data;
    }

    /**
     * @return mixed
     */
    public function getDb()
    {
        return $this->db;
    }

    /**
     * @param mixed $db
     */
    public function setDb($db)
    {
        $this->db = $db;
    }

    /**
     * @return mixed
     */
    public function getClientId()
    {
        return $this->client_id;
    }

    /**
     * @param mixed $client_id
     */
    public function setClientId($client_id)
    {
        $this->client_id = $client_id;
    }

    /**
     * @return mixed
     */
    public function getOverlayFlag()
    {
        return $this->overlay_flag;
    }

    /**
     * @param mixed $overlay_flag
     */
    public function setOverlayFlag($overlay_flag)
    {
        $this->overlay_flag = $overlay_flag;
    }

    /**
     * @return int
     */
    public function getVerticalId()
    {
        return $this->vertical_id;
    }

    /**
     * @param int $vertical_id
     */
    public function setVerticalId($vertical_id)
    {
        $this->vertical_id = $vertical_id;
    }

    /**
     * @return string
     */
    public function getServiceBaseUrl()
    {
        return $this->service_base_url;
    }

    /**
     * @param string $service_base_url
     */
    public function setServiceBaseUrl($service_base_url)
    {
        $this->service_base_url = $service_base_url;
    }
}