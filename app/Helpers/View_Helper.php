<?php

use App\Services\DataRegistry;

/**
 * This file include all helper functions which were defined in `Zend_View_Helpers`
 * Created by PhpStorm.
 * User: Jazib Javed
 * Date: 13/11/2019
 * Time: 4:33 AM
 */
class View_Helper
{
    /** @var  \App\Services\DbService $db */
    private $db;

    public $logo_color;

    /**
     * View_Helper constructor.
     */
    private function __construct()
    {
        $this->db = App::make('App\Services\DbService');
    }

    public static function getInstance()
    {
        static $self = null;
        if ($self === null) {
            $self = new View_Helper();
        }
        return $self;
    }

    /**
     * @return \App\Services\DbService
     */
    private function _getDB()
    {
        return $this->db;
    }


    /*
    ### ### ### ### ### ### ### ### ### ### ### ### ### ### ### ### ### ### ### ###
    ###      Source Class: Zend_View_Helper_GetSecureClixStatus                 ###
    ###      Source File: GetSecureClixStatus.php                               ###
    ### ### ### ### ### ### ### ### ### ### ### ### ### ### ### ### ### ### ### ###
    */
    function getSecureClixStatus($client_id)
    {
        $this->db = $this->_getDB();
        $s = "SELECT enable_secure_clix FROM clients WHERE client_id = " . $client_id;
        $res = $this->db->fetchRow($s);
        $ret = $res['enable_secure_clix'];
        return $ret;
    }


    /*
    ### ### ### ### ### ### ### ### ### ### ### ### ### ### ### ### ### ### ### ###
    ###      Source Class: Zend_View_Helper_GetClientName                       ###
    ###      Source File: GetClientName.php                                     ###
    ### ### ### ### ### ### ### ### ### ### ### ### ### ### ### ### ### ### ### ###
    */
    public function getClientName($client_id)
    {
        $s = "SELECT first_name,last_name  ";
        $s .= " from clients where client_id = " . $client_id;
        //die($s);
        $res = $this->db->fetchRow($s);
        $ret = ucfirst($res['first_name']) . " " . ucfirst($res['last_name']);
        return $ret;
    }

    public function substringBetween($haystack, $start, $end)
    {
        if (strpos($haystack, $start) === false || strpos($haystack, $end) === false) {
            return false;
        } else {
            $start_position = strpos($haystack, $start) + strlen($start);
            $end_position = strpos($haystack, $end);
            return substr($haystack, $start_position, $end_position - $start_position);
        }
    }


    function getCarriers($carrier = 'none')
    {
        $ret = array();
        $s = "SELECT * from carriers group by carrier order by name";
        $res = $this->db->fetchAll($s);
        $s = "";
        for ($i = 0; $i < count($res); $i++) {
            $s .= '<option ' . ($carrier == $res[$i]['carrier'] ? 'selected=\"selected\"' : '') . "  value='" . $res[$i]['carrier'] . "'>" . $res[$i]['name'] . '</option>';
        }
        return $s;
    }

    function getLeadRecipients($client_id, $funnel)
    {
        $s = "SELECT recipients.id, recipients.client_id, recipients.full_name, recipients.email_address, recipients.is_primary,
         text_recipients.phone_number, text_recipients.carrier";
        $s .= " FROM lp_auto_recipients recipients LEFT JOIN lp_auto_text_recipients text_recipients ON recipients.id = text_recipients.lp_auto_recipients_id";
        $s .= " WHERE recipients.client_id = " . $client_id;
        $s .= " AND recipients.leadpop_id = " . $funnel['leadpop_id'];
        $s .= " AND recipients.leadpop_type_id = " . $funnel['leadpop_type_id'];
        $s .= " AND recipients.leadpop_vertical_id = " . $funnel['leadpop_vertical_id'];
        $s .= " AND recipients.leadpop_vertical_sub_id = " . $funnel['leadpop_vertical_sub_id'];
        $s .= " AND recipients.leadpop_template_id = " . $funnel['leadpop_template_id'];
        $s .= " AND recipients.leadpop_version_id = " . $funnel['leadpop_version_id'];
        $s .= " AND recipients.leadpop_version_seq = " . $funnel['leadpop_version_seq'];
        $s .= " ORDER BY recipients.id ASC";
        $rec = $this->db->fetchAll($s);
        return $rec;
    }


    /*
    ### ### ### ### ### ### ### ### ### ### ### ### ### ### ### ### ### ### ### ###
    ###      Source Class: Zend_View_Helper_GetCurrentFrontImageSource          ###
    ###      Source File: GetCurrentFrontImageSource.php                        ###
    ### ### ### ### ### ### ### ### ### ### ### ### ### ### ### ### ### ### ### ###
    */
    public function getCurrentFrontImageSource($client_id, $funnel_data = array(), $responseWithImageScalingProperties = false)
    {
        $r = '';
        $imgResponse = [
            "imgsrc" => "",
            'scaling_maxWidthPx' => config('leadpops.design.featureImage.maxAllowedWidthPx'),
            'scaling_defaultWidthPercentage' => config('leadpops.design.featureImage.sliderDefault')
        ];
        $this->db = $this->_getDB();
        if (!empty($funnel_data)) {
            $vertical_id = $funnel_data["leadpop_vertical_id"];
            $subvertical_id = $funnel_data["leadpop_vertical_sub_id"];
            $leadpop_id = $funnel_data["leadpop_id"];
            $version_seq = $funnel_data["leadpop_version_seq"];
        } else {
            $registry = DataRegistry::getInstance();
            $vertical_id = $registry->leadpops->customVertical_id;
            $subvertical_id = $registry->leadpops->customSubvertical_id;
            $leadpop_id = $registry->leadpops->customLeadpopid;
            $version_seq = $registry->leadpops->customLeadpopVersionseq;
        }

        $s = "select * from leadpops where id = " . $leadpop_id;
        $lpres = $this->db->fetchRow($s);

        $leadpop_template_id = $lpres['leadpop_template_id'];
        $leadpop_version_id = $lpres['leadpop_version_id'];
        $leadpop_type_id = $lpres['leadpop_type_id'];

        $s = "select * from leadpop_images where client_id = " . $client_id;
        $s .= " and leadpop_id = " . $leadpop_id;
        $s .= " and leadpop_type_id = " . $leadpop_type_id;
        $s .= " and leadpop_vertical_id = " . $vertical_id;
        $s .= " and leadpop_vertical_sub_id = " . $subvertical_id;
        $s .= " and leadpop_template_id = " . $leadpop_template_id;
        $s .= " and leadpop_version_id  = " . $leadpop_version_id;
        $s .= " and leadpop_version_seq = " . $version_seq;
        $images = $this->db->fetchRow($s);
        // if(@$_COOKIE['devtest'] == 1) debug($images, $s, false);
        if (isset($_GET["v"]) && $_GET["v"] == "v") {
            $r = $s;
        }

        $registry = DataRegistry::getInstance();
        if ($registry->leadpops->clientInfo['is_fairway'] == 1) $trial_launch_defaults = "trial_launch_defaults_fairway";
        else if ($registry->leadpops->clientInfo['is_mm'] == 1) $trial_launch_defaults = "trial_launch_defaults_mm";
        else $trial_launch_defaults = "trial_launch_defaults";

        // get trial info from version_seq = 1 because if funnel is cloned manny times the higher version_seq not exist in trial tables
        $s = "select * from " . $trial_launch_defaults;
        $s .= " where leadpop_vertical_sub_id = " . $subvertical_id;
        #$s .= " and leadpop_vertical_id = " . $vertical_id;
        #$s .= " and leadpop_type_id = " . $leadpop_type_id;;
        $s .= " and leadpop_template_id = " . $leadpop_template_id;
        $s .= " and leadpop_version_id  = " . $leadpop_version_id;
        $s .= " ORDER BY leadpop_version_seq ASC";
        $trialDefaults = $this->db->fetchRow($s);
        if (isset($_GET["v"]) && $_GET["v"] == "v") {
            echo $r . " " . $s;
            exit;
        }
        // if(@$_COOKIE['devtest'] == 1) debug($trialDefaults, $s, false);
        $imagesrc = "";
        if ($images) {
            //blank image use for create new custom funnel
            if($images['image_src'] === 'blank.png'){
                $imagesrc = "default";
                $imagesrc .= "~" . rackspace_stock_assets() . 'images/'.$images['image_src'].'~';
            }
            else {
                if ($trialDefaults) {
                    $defaultimagename = $trialDefaults['image_name'];
                } else {
                    $defaultimagename = config('leadpops.default_feature_image_name');
                }


                    if ($images['use_default'] == 'y') {
                        // DEFAULT IMAGE CASE
                        $imagesrc = "default";
                        $s = "SELECT * FROM current_container_image_path WHERE cdn_type = 'default-assets'";
                        $defaultCdn = $this->db->fetchRow($s);

                        $imagesrc = "default";
                        $imagesrc .= "~" . $defaultCdn['image_path'] . config('rackspace.rs_featured_image_dir') . $defaultimagename;
                    if ($responseWithImageScalingProperties) {
                        $imgResponse['imgsrc'] = $imagesrc;
                    }
                } elseif (($images['use_default'] == 'n' && trim($images["image_src"]) == $defaultimagename) || $this->isDefaultFeaturedImage($images["image_src"], $defaultimagename)) {
                        // DEFAULT IMAGE CASE # 2
                        $s = "SELECT * FROM current_container_image_path WHERE cdn_type = 'default-assets'";
                        $defaultCdn = $this->db->fetchRow($s);

                        $imagesrc = "default";
                        $imagesrc .= "~" . $defaultCdn['image_path'] . config('rackspace.rs_featured_image_dir') . $defaultimagename;

                    if ($responseWithImageScalingProperties) {
                        $imgResponse['imgsrc'] = $imagesrc;
                    }
                } else {
                        // CUSTOM IMAGE (ENABLE + Disable) CASE
                        $imagesrc = "mine";
                        if($images['image_src']) {
                            $pics_dir = getCdnLink() . '/pics/';
                            $imagesrc .= "~" . $pics_dir . str_replace($pics_dir, "", $images['image_src']);
                    } else {
                            $imagesrc .='~';
                        }

                    if ($responseWithImageScalingProperties) {
                        $imgResponse['imgsrc'] = @$imagesrc;
                        $imgResponse['image_id'] = @$images['id'];

                        if(isset($images['scaling_properties']) && $images['scaling_properties'] != ""){
                            $scaling_properties = json_decode($images['scaling_properties'], 1);
                            $imgResponse['scaling_maxWidthPx'] = $scaling_properties['maxWidth'];
                            $imgResponse['scaling_defaultWidthPercentage'] = $scaling_properties['scalePercentage'];
                        }
                    }
                    }


                    if ($images['use_default'] == 'n' && $images['use_me'] == 'n') {
                        $imagesrc .= "~noimage";
                } else {
                        $imagesrc .= "~";
                    }

            }
        }

        if ($responseWithImageScalingProperties) {
            $imgResponse['imgsrc'] = @$imagesrc;
            $imgResponse['image_id'] = @$images['id'];
            if(isset($images['scaling_properties']) && $images['scaling_properties'] != ""){
                $scaling_properties = json_decode($images['scaling_properties'], 1);
                $imgResponse['scaling_maxWidthPx'] = $scaling_properties['maxWidth'];
                $imgResponse['scaling_defaultWidthPercentage'] = $scaling_properties['scalePercentage'];
            }
            return $imgResponse;
        }

        // if(@$_COOKIE['devtest'] == 1) debug($imagesrc, "#3", true);
        return $imagesrc;
    }

    /**
     * This function will return true if image name will be matched with defaults image name
     * case 1 - will return true if name directly matched without any parsing
     * case 2 - explode by _ than match with defaults name, return true if matched
     * @return bool
     */
    private function isDefaultFeaturedImage($featuredImage, $defaultFeaturedImage)
    {
        if (!empty($featuredImage)) {
            $tmpArr = explode("_", $featuredImage);
            $imageName = end($tmpArr);
            if (strtolower($imageName) == strtolower($defaultFeaturedImage)) {
                return true;
            }
        }
        return false;
    }

    private function getHttpAdminServer()
    {
        $s = "select http from httpadminserver limit 1 ";
        $http = $this->db->fetchOne($s);
        return $http;
    }

    private function _getCdnLink()
    {
        $registry = DataRegistry::getInstance();
        $client_base_url = $registry->leadpops->clientInfo['rackspace_image_base'];
        if (substr("testers", -1) === "/") $client_base_url = substr($client_base_url, 0, -1);
        return $client_base_url;
    }

    /*
    ### ### ### ### ### ### ### ### ### ### ### ### ### ### ### ### ### ### ### ###
    ###      Source Class: Zend_View_Helper_GetTreeCookie                       ###
    ###      Source File: GetTreeCookie.php                                     ###
    ### ### ### ### ### ### ### ### ### ### ### ### ### ### ### ### ### ### ### ###
    */
    public function getTreeCookie($client_id, $firstkeys)
    {
        /*var_dump($client_id);
        var_dump($firstkeys);
        exit;*/
        $akeys = explode("~", $firstkeys);
        $this->db = $this->_getDB();
        $s = "select * from leadpops where id = " . $akeys[2]; // index 2 is the leadpop_id
        if (isset($akeys[2]) && $akeys[2] != "") {
            $lp = $this->db->fetchAll($s);
        } else {
            header("Location: https://myleads.leadpops.com");
            exit;
        }
        if ($lp[0]) {
            $vertical_id = $lp[0]['leadpop_vertical_id'];
            $subvertical_id = $lp[0]['leadpop_vertical_sub_id'];
            $leadpop_version_id = $lp[0]['leadpop_version_id'];
            $leadpoptype_id = $lp[0]['leadpop_type_id'];
            $client_leadpop_seq = $akeys[3];
            $mylpname = $this->getLpNamesFromVerticalIdSubverticalId($vertical_id, $subvertical_id, $client_id);
            if ($mylpname) {
                $myverticalName = $this->getVerticalNameFromVerticalId($vertical_id);
                $mysubverticalName = $this->getSubVerticalNameFromSubverticalId($subvertical_id);
                $myleadpop_id = $this->getLeadpopId($vertical_id, $subvertical_id, $leadpoptype_id, $leadpop_version_id);
                $comparekey = $myverticalName . "~" . $mysubverticalName . "~" . $myleadpop_id . "~" . $client_leadpop_seq . "~" . $client_id . "~" . $mylpname['leadpop_title'] . "-" . $mylpname['leadpop_version_seq'];
                $leadpopList = $this->getLeadpopList($client_id);
                $cookie = "";
                for ($i = 0; $i < count($leadpopList); $i++) {
                    $cookie .= "0";
                    $verticalName = $this->getVerticalNameFromVerticalId($leadpopList[$i]['leadpop_vertical_id']);
                    $subverticals = $this->getSubverticalIdsFromVerticalId($leadpopList[$i]['leadpop_vertical_id'], $client_id);
                    for ($j = 0; $j < count($subverticals); $j++) {
                        $cookie .= "0";
                        $subverticalName = $this->getSubVerticalNameFromSubverticalId($subverticals[$j]['id']);
                        $lpnames = $this->getAllLpNamesFromVerticalIdSubverticalId($leadpopList[$i]['leadpop_vertical_id'], $subverticals[$j]['id'], $client_id);
                        for ($k = 0; $k < count($lpnames); $k++) {
                            $key = $verticalName . "~" . $subverticalName . "~" . $lpnames[$k]['leadpop_id'] . "~" . $client_leadpop_seq . "~" . $client_id . "~" . $lpnames[$k]['leadpop_title'] . "-" . $lpnames[$k]['leadpop_version_seq'];
                            if ($comparekey == $key) {
                                $cookie = substr($cookie, 0, strlen($cookie) - 2);
                                $cookie .= "11";
                                return $cookie;
                            }
                        }
                    }
                }
            } else {
                return 'not lp';
            }

            //die("goose");
        } else {
            return 'not lp';
        }
    }

    private function getAllLpNamesFromVerticalIdSubverticalId($vertical_id, $subvertical_id, $client_id)
    {
        $s = " select a.leadpop_id,a.leadpop_version_seq,c.leadpop_title  ";
        $s .= " from clients_leadpops a, leadpops b,leadpops_descriptions c ";
        $s .= " where a.leadpop_id = b.id ";
        $s .= " and b.leadpop_vertical_id = " . $vertical_id;
        $s .= " and b.leadpop_vertical_sub_id = " . $subvertical_id;
        $s .= " and a.client_id = " . $client_id;
        //          $s .= " and a.leadpop_active = '1' ";
        $s .= " and c.leadpop_vertical_id = b.leadpop_vertical_id ";
        $s .= " and c.leadpop_vertical_sub_id = b.leadpop_vertical_sub_id ";
        $s .= " and c.leadpop_vertical_id = " . $vertical_id;
        $s .= " and c.leadpop_vertical_sub_id = " . $subvertical_id;
        $s .= " order by a.leadpop_version_seq ";
        //         die($s);
        $lpName = $this->db->fetchAll($s);
        return $lpName;
    }

    private function getSubverticalIdsFromVerticalId($vertical_id, $client_id)
    {
        $s = " select distinct a.id  ";
        $s .= " from leadpops_verticals_sub a,clients_leadpops b,leadpops c ";
        $s .= " where a.leadpop_vertical_id = c.leadpop_vertical_id ";
        $s .= " and a.id = c.leadpop_vertical_sub_id";
        $s .= " and a.leadpop_vertical_id = " . $vertical_id;
        $s .= " and b.leadpop_id = c.id ";
        $s .= " and b.client_id = ".$client_id;
        //$s .= " and b.leadpop_active = '1' ";
        $subverticalIds = $this->db->fetchAll($s);
        return $subverticalIds;
    }

    private function getLeadpopList($client_id)
    {
        $s = " select distinct a.leadpop_vertical_id ";
        $s .= " from leadpops a,clients_leadpops b ";
        $s .= " where b.client_id = " . $client_id;
        //           $s .= " and b.leadpop_active = '1' " ;
        $s .= " and b.leadpop_id = a.id ";
        $res = $this->db->fetchAll($s);
        return $res;
    }

    private function getLeadpopId($vertical_id, $subvertical_id, $leadpoptype_id, $leadpop_version_id)
    {
        $s = "select id from leadpops ";
        $s .= " where leadpop_type_id = " . $leadpoptype_id;
        $s .= " and leadpop_vertical_id = " . $vertical_id;
        $s .= " and leadpop_vertical_sub_id = " . $subvertical_id;
        $s .= " and leadpop_version_id = " . $leadpop_version_id;
        $s .= " limit 1 ";
        $leadpop_id = $this->db->fetchOne($s);
        return $leadpop_id;
    }

    private function getSubVerticalNameFromSubverticalId($subvertical_id)
    {
        $s = " select lead_pop_vertical_sub ";
        $s .= " from leadpops_verticals_sub  ";
        $s .= " where id =  " . $subvertical_id;
        $subverticalName = $this->db->fetchOne($s);
        return $subverticalName;
    }

    private function getLpNamesFromVerticalIdSubverticalId($vertical_id, $subvertical_id, $client_id)
    {
        $s = " select a.leadpop_id,a.leadpop_version_seq,c.leadpop_title  ";
        $s .= " from clients_leadpops a, leadpops b,leadpops_descriptions c ";
        $s .= " where a.leadpop_id = b.id ";
        $s .= " and b.leadpop_vertical_id = " . $vertical_id;
        $s .= " and b.leadpop_vertical_sub_id = " . $subvertical_id;
        $s .= " and a.client_id = " . $client_id;
        $s .= " and c.leadpop_vertical_id = b.leadpop_vertical_id ";
        $s .= " and c.leadpop_vertical_sub_id = b.leadpop_vertical_sub_id ";
        $s .= " and c.leadpop_vertical_id = " . $vertical_id;
        $s .= " and c.leadpop_vertical_sub_id = " . $subvertical_id;
        $s .= " and b.leadpop_version_id = c.id "; // added 11/13/2011
        $s .= " and a.leadpop_version_seq = ";
        $s .= "    (select max(l.leadpop_version_seq) ";
        $s .= "    from clients_leadpops l, leadpops m,leadpops_descriptions n ";
        $s .= "    where l.leadpop_id = b.id ";
        $s .= "    and m.leadpop_vertical_id = " . $vertical_id;
        $s .= "    and m.leadpop_vertical_sub_id = " . $subvertical_id;
        $s .= "    and l.client_id = " . $client_id;
        $s .= "    and n.leadpop_vertical_id = m.leadpop_vertical_id ";
        $s .= "    and n.leadpop_vertical_sub_id = m.leadpop_vertical_sub_id ";
        $s .= "    and m.leadpop_version_id = n.id "; // added 11/13/2011
        $s .= "    and n.leadpop_vertical_id = " . $vertical_id;
        $s .= "    and n.leadpop_vertical_sub_id = " . $subvertical_id . ")";
        //die($s);
        $lpName = $this->db->fetchRow($s);
        return $lpName;
    }

    public function getVerticalNameFromVerticalId($vertical_id)
    {
        $s = " select lead_pop_vertical ";
        $s .= " from leadpops_verticals  ";
        $s .= " where id =  " . $vertical_id;
        //die($s);
        $verticalName = $this->db->fetchOne($s);
        return $verticalName;
    }


    /*
    ### ### ### ### ### ### ### ### ### ### ### ### ### ### ### ### ### ### ### ###
    ###      Source Class: Zend_View_Helper_GetCurrentLogoImageSource           ###
    ###      Source File: GetCurrentLogoImageSource.php                         ###
    ### ### ### ### ### ### ### ### ### ### ### ### ### ### ### ### ### ### ### ###
    */
    function getCurrentLogoImageSource($client_id, $return = 0, $funnel_data = array(), $responseWithLogoScalingProperties = false)
    {
        $logosrc = "";
        $logoResponse = [
            "id" => "",
            "logosrc" => "",
            "use" => "",
            'scaling_maxHeightPx' => config('leadpops.design.logo.maxAllowedHeightPx'),
            'scaling_defaultHeightPercentage' => config('leadpops.design.logo.defaultHeight'),
            'current_logo_height' => config('leadpops.design.logo.defaultHeightPx')
        ];
        $vertical_id = $funnel_data["leadpop_vertical_id"];
        $subvertical_id = $funnel_data["leadpop_vertical_sub_id"];
        $leadpop_id = $funnel_data["leadpop_id"];
        $leadpop_template_id = $funnel_data['leadpop_template_id'];
        $leadpop_version_id = $funnel_data['leadpop_version_id']??'';
        $leadpop_type_id = $funnel_data['leadpop_type_id'];

        $leadpop_version_seq = $funnel_data["leadpop_version_seq"];
        $verticalName = strtolower($funnel_data["lead_pop_vertical"]??'');
        $subverticalName = strtolower($funnel_data["lead_pop_vertical_sub"]??'');

        $s = "select * from leadpop_logos where client_id = " . $client_id;
//        $s .= " and leadpop_id = " . $leadpop_id;
//        $s .= " and leadpop_type_id = " . $leadpop_type_id;
//        $s .= " and leadpop_vertical_id = " . $vertical_id;
//        $s .= " and leadpop_vertical_sub_id = " . $subvertical_id;
//        $s .= " and leadpop_template_id = " . $leadpop_template_id;
        $s .= " and leadpop_version_id  = " . $leadpop_version_id;
        $s .= " and leadpop_version_seq = " . $leadpop_version_seq;
        $logos = $this->db->fetchAll($s);

        if ($logos) {
            for ($i = 0; $i < count($logos); $i++) {
                $logoResponse['scaling_maxHeightPx'] = config('leadpops.design.logo.maxAllowedHeightPx');
                $logoResponse['current_logo_height'] = config('leadpops.design.logo.defaultHeightPx');
                $logoResponse['scaling_defaultHeightPercentage'] = config('leadpops.design.logo.defaultHeight');
                //blank image use for create new custom funnel
                if ($logos[$i]["logo_src"] === 'blank.png') {
                    $logosrc = rackspace_stock_assets() . 'images/' . $logos[$i]["logo_src"];
                }
                else {
                    if ($logos[$i]['use_default'] == 'y') {
                        if ($subverticalName == "") {
                            $logosrc = $stocklogopath = rackspace_stock_assets() . config('rackspace.rs_stock_logo_dir') . strtolower(str_replace(" ", "", $verticalName)) . '/' . $this->getDefaultLogoName($vertical_id, $subvertical_id, $leadpop_version_id);
                        } else {
                            $logosrc = $stocklogopath = rackspace_stock_assets() . config('rackspace.rs_stock_logo_dir') . strtolower(str_replace(" ", "", $verticalName)) . '/' . strtolower(str_replace(" ", "", $subverticalName)) . '_logos/' . $this->getDefaultLogoName($vertical_id, $subvertical_id, $leadpop_version_id);
                        }
                        $logosrc = str_replace(" ", "", $logosrc);

                        if ($responseWithLogoScalingProperties) {
                            $logoResponse['id'] = $logos[$i]['id'];
                            $logoResponse['logosrc'] = $logosrc;
                            $logoResponse['use'] = 'default';

                            if ($logos[$i]['scaling_properties'] != "") {
                                $scaling_properties = json_decode($logos[$i]['scaling_properties'], 1);
                                $logoResponse['scaling_maxHeightPx'] = $scaling_properties['maxHeight'];
                                $logoResponse['scaling_defaultHeightPercentage'] = $scaling_properties['scalePercentage'];
                                $logoResponse['current_logo_height'] = @$scaling_properties['current_logo_height'];
                            }
                        }
                    }
                    else if ($logos[$i]['use_me'] == 'y') {
                        $section = substr($client_id, 0, 1);

                        #$logosrc = $this->getHttpAdminServer() . '/images/clients/' . $section . '/' . $client_id . '/logos/' . $logos[$i]['logo_src'];
                        $logosrc = getCdnLink() . '/logos/' . $logos[$i]['logo_src'];
                        if (@$logos[$i]['logo_dimension']) {
                            $logosrc .= "###" . $logos[$i]['logo_dimension'];
                        }

                        if ($responseWithLogoScalingProperties) {
                            $logoResponse['id'] = $logos[$i]['id'];
                            $logoResponse['logosrc'] = $logosrc;
                            $logoResponse['use'] = 'client';

                            if ($logos[$i]['scaling_properties'] != "" && strlen($logos[$i]['scaling_properties']) > 10) {
                                $scaling_properties = json_decode($logos[$i]['scaling_properties'], 1);
                                $logoResponse['scaling_maxHeightPx'] = $scaling_properties['maxHeight'];
                                $logoResponse['scaling_defaultHeightPercentage'] = $scaling_properties['scalePercentage'];
                                $logoResponse['current_logo_height'] = @$scaling_properties['current_logo_height'];
                            }
                        }
                        break;
                    }
                }
            }
        }

        // http://itclix.com/images/education/sparktoy_logos/home.png
        if ($return) {
            if (@$logo_color) {
                return $logosrc . '~~~' . implode('-', $this->hex2rgb($logo_color));
            } else {
                return $logosrc . '~~~ ';
            }
        }


        if ($responseWithLogoScalingProperties) {
            return $logoResponse;
        } else {
            return $logosrc;
        }

    }

    /**
     * @param $funnelData
     * @return mixed|string
     */
    function getFunnelCurrentLogo($funnelData, $stocklogosource = null) {
        if(!isset($funnelData['lead_pop_vertical'])) {
            $funnelData['lead_pop_vertical'] = LP_Helper::getInstance()->getVerticalName($funnelData["leadpop_vertical_id"]);
            $funnelData['lead_pop_vertical_sub'] = LP_Helper::getInstance()->getSubVerticalName($funnelData["leadpop_vertical_sub_id"]);
        }

        $registry = DataRegistry::getInstance();
        $selected_logo_src = \View_Helper::getInstance()->getCurrentLogoImageSource($registry->leadpops->client_id, 0, @$funnelData, true);

        if($selected_logo_src['logosrc'] == ""){
            if($stocklogosource && !empty($stocklogosource)) {
                $selected_logo_src['logosrc'] = $stocklogosource;
            } else {
                $customize = new App\Repositories\CustomizeRepository($this->db);
                $stock = $customize->getStockLogoSources($registry, @$funnelData);
                $astock = explode("~", $stock);
                $selected_logo_src['logosrc'] = $astock[1];
            }
            $selected_logo_src['use'] = "default";
        }
        return $selected_logo_src;
    }

    private function getDefaultLogoName($vertical_id, $subvertical_id, $leadpop_version_id)
    {
        $s = "select logo_src from stock_leadpop_logos ";
        $s .= " where leadpop_vertical_id = " . $vertical_id;
        $s .= " and leadpop_vertical_sub_id = " . $subvertical_id;
        $s .= " and leadpop_version_id = " . $leadpop_version_id . " limit 1 ";
        //    die($s);
        $src = $this->db->fetchOne($s);
        return $src;
    }

    private function getHttpServer()
    {
        $s = "select http from httpclientserver limit 1 ";
        $http = $this->db->fetchOne($s);
        return $http;
    }

    public function hex2rgb($hex)
    {
        $hex = str_replace("#", "", $hex);

        if (strlen($hex) == 3) {
            $r = hexdec(substr($hex, 0, 1) . substr($hex, 0, 1));
            $g = hexdec(substr($hex, 1, 1) . substr($hex, 1, 1));
            $b = hexdec(substr($hex, 2, 1) . substr($hex, 2, 1));
        } else {
            $r = hexdec(substr($hex, 0, 2));
            $g = hexdec(substr($hex, 2, 2));
            $b = hexdec(substr($hex, 4, 2));
        }
        $rgb = array($r, $g, $b);
        //return implode(",", $rgb); // returns the rgb values separated by commas
        return $rgb; // returns an array with the rgb values
    }


    /*
    ### ### ### ### ### ### ### ### ### ### ### ### ### ### ### ### ### ### ### ###
    ###      Source Class: Zend_View_Helper_GetClientSubDomainTops              ###
    ###      Source File: GetClientSubDomainTops.php                            ###
    ### ### ### ### ### ### ### ### ### ### ### ### ### ### ### ### ### ### ### ###
    */

    function getClientSubDomainTops($subdomaintop, $client_id)
    {
        $db = $this->_getDB();
        $s = "select * from top_level_domains ";
        $res = $db->fetchAll($s);


        # NOW every sub-domain is moved to https so we don't need to remove anything from array of allowed top level domains for funnels (Jaz)
        /*
        $q = "SELECT enable_secure_clix FROM clients WHERE client_id = " . $client_id;
        $res_ssl = $db->fetchRow($q);

        for($i=0; $i<count($res); $i++) {
            if (!$res_ssl['enable_secure_clix'] && $res[$i]['domain'] =='secure-clix.com') {
                unset($res[$i]);
            }
        }
        */

        $s = "";
        for ($i = 0; $i < count($res); $i++) {

            $s .= "<option " . ($subdomaintop == $res[$i]['domain'] ? 'selected=\"selected\"' : '') . " value='" . $res[$i]['domain'] . "'>" . $res[$i]['domain'] . "</option>\n";
        }
        return $s;
    }
}
