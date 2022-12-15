<?php
/**
 * Created by PhpStorm.
 * User: mzac90
 * Date: 30/03/2020
 * Time: 9:23 PM
 */
class FunnelProcess

{
    private $db;
    private static $instance = null;
    public  $thissub_domain, $thistop_domain, $leadpoptype  = '';
    public  $logo_color;
    public  $logosrc = "";
    public  $imgsrc = "";
    public  $uploadedLogo = "";
    public  $globallogosrc = "";
    public  $globalfavicon_dst = "";
    public  $globallogo_color = "";
    public  $globalcolored_dot = "";
    // set mobile logo varibale
    public  $origlogo = "";
    public  $newlogo = "";
    public  $newlogoname = "";
    public  $logopath = "";
    public  $origcolored_dot_src = "";
    public  $newcolored_dot_src = "";
    public  $origfavicon_dst_src = "";
    public  $newfavicon_dst_src = "";
    public  $image_location = "";
    public  $favicon_location = "";
    public  $favicon_dst_src = "";
    public  $colored_dot_src = "";
    public  $colored_dot = "";
    public  $favicon_dst = "";
    private $favicon;
    private $check;
    private $dot;
    private $ring;
    public  $file_list =  array();

    /**
     * @param mixed $db
     */
    public function setDb($db){
        $this->db = $db;
    }

    /**
     * @return mixed
     */
    public function getFavicon()
    {
        return $this->favicon;
    }

    /**
     * @param mixed $favicon
     */
    public function setFavicon($favicon): void
    {
        $this->favicon = $favicon;
    }

    /**
     * @return mixed
     */
    public function getCheck()
    {
        return $this->check;
    }

    /**
     * @param mixed $check
     */
    public function setCheck($check): void
    {
        $this->check = $check;
    }

    /**
     * @return mixed
     */
    public function getDot()
    {
        return $this->dot;
    }

    /**
     * @param mixed $dot
     */
    public function setDot($dot): void
    {
        $this->dot = $dot;
    }

    /**
     * @return mixed
     */
    public function getRing()
    {
        return $this->ring;
    }

    /**
     * @param mixed $ring
     */
    public function setRing($ring): void
    {
        $this->ring = $ring;
    }

    /**
     * @return mixed
     */
    public function getLogoColor()
    {
        return $this->logo_color;
    }

    /**
     * @param mixed $logo_color
     */
    public function setLogoColor($logo_color): void
    {
        $this->logo_color = $logo_color;
    }


    public static function getInstance(){
        if (!isset(self::$instance)) {
            self::$instance = new FunnelProcess();
        }
        return self::$instance;
    }
    /* start non enterprise vertical to existing client function */
    function addNonEnterpriseVerticalToExistingClient($ppvertical_id, $subvertical_id, $version_id, $client_id, $logo = "", $mobilelogo = "",
                                                      $origvertical_id = "", $origsubvertical_id = "", $origversion_id = "", $origleadpop_type_id = "",
                                                      $origleadpop_template_id = "",
                                                      $origleadpop_id = "", $origleadpop_version_id = "", $origleadpop_version_seq = "")
    {

        $section = substr($client_id, 0, 1);

        if ($ppvertical_id == "1") {
            $vertical = "insurance";
        } else if ($ppvertical_id == "3") {
            $vertical = "mortgage";
        } else if ($ppvertical_id == "5") {
            $vertical = "realestate";
        }


        $s = "select * from clients where client_id = " . $client_id;
        $client = $this->db->fetchRow($s);
        $client ['company_name'] = ucfirst(strtolower($client ['company_name']));
        $freeTrialBuilderAnswers = array("emailaddress" => $client["contact_email"], "phonenumber" => $client["phone_number"]);

        switch ($vertical) {
            case "mortgage":
                $emmaAccount = '1758432';
                $emma_account_type = "mortgage";
                break;
            case "insurance":
                $emmaAccount = '1760824';
                $emma_account_type = "insurance";
                break;
            case "realestate":
                $emmaAccount = '1758435';
                $emma_account_type = "realestate";
                break;
        }
        $emma_account_name = preg_replace('/[^a-zA-Z]/', '', $client ['company_name']);

        $generatecolors = false;
        if ($logo == "" && $mobilelogo == "") { // inother words use defaults for logo and mobile logo
            $useUploadedLogo = false;
            $default_background_changed = "n";
        } else if ($logo != "" && $mobilelogo != "" && $origleadpop_type_id != "" && $origleadpop_template_id != "" && $origleadpop_id != "" && $origleadpop_version_id != "" && $origleadpop_version_seq != "") {
            $default_background_changed = "y";
            $generatecolors = false;  // in other workds use existing logo and mobile logo and copy them to new funnel as if no upload was done
            $useUploadedLogo = true;
        } else if ($logo != "" && $mobilelogo == "" && $origleadpop_type_id == "" && $origleadpop_template_id == "" && $origleadpop_id == "" && $origleadpop_version_id == "" && $origleadpop_version_seq == "") {
            $default_background_changed = "y";
            $generatecolors = true;  // in other words act as if a new logo was uploaded & generate mobile logo
            $useUploadedLogo = true;
        }

        $s = "select * from trial_launch_defaults where leadpop_vertical_id = " . $ppvertical_id;
        $trialDefaults = $this->db->fetchAll($s);

        for ($zz = 0; $zz < count($trialDefaults); $zz++) {

            if ($generatecolors == false && $useUploadedLogo == false) { // not uploaded logo or have previous funnel to use
               //$finalTrialColors, $background_css we are using this variable in this case
                //remove logo_name_mobile copy cmd from @mzac90
                $this->logosrc = $this->getRackspaceUrl ('image_path', 'default-assets') . 'stockimages/classicimages/'.$trialDefaults[$zz]["logo_name"];
                $this->insertDefaultClientUploadLogo( $trialDefaults[$zz]["logo_name"], $trialDefaults[$zz], $client_id);
                $this->imgsrc = $this->insertClientDefaultImage($trialDefaults[$zz], $client_id);
                $this->setClientDefaultFaviconColor($trialDefaults[$zz]);
            }
            else if ($generatecolors == false && $useUploadedLogo == true) { // get colors from leadpops_background_swatches

                $s = "select * from leadpop_background_swatches ";
                $s .= " where  client_id = " . $client_id;
                $s .= " and leadpop_vertical_id = " . $origvertical_id;
                $s .= " and leadpop_vertical_sub_id = " . $origsubvertical_id;
                $s .= " and leadpop_type_id  = " . $origleadpop_type_id;
                $s .= " and leadpop_template_id = " . $origleadpop_template_id;
                $s .= " and  leadpop_id = " . $origleadpop_id;
                $s .= " and leadpop_version_id = " . $origleadpop_version_id;
                $s .= " and leadpop_version_seq = " . $origleadpop_version_seq;
                $finalTrialColors = $this->db->fetchAll($s);


                for ($t = 0; $t < count($finalTrialColors); $t++) {
                    $leadpop_background_swatches  = array(
                        'client_id'=> $client_id,
                        'leadpop_vertical_id'=>$trialDefaults[$zz]["leadpop_vertical_id"],
                        'leadpop_vertical_sub_id'=>$trialDefaults[$zz]["leadpop_vertical_sub_id"],
                        'leadpop_type_id'=>$this->leadpoptype,
                        'leadpop_template_id'=>$trialDefaults[$zz]['leadpop_template_id'],
                        'leadpop_id' => $trialDefaults[$zz]["leadpop_id"],
                        'leadpop_version_id'=> $trialDefaults[$zz]["leadpop_version_id"],
                        'leadpop_version_seq'=>  $trialDefaults[$zz]["leadpop_version_seq"],
                        'swatch'=>$finalTrialColors[$t]["swatch"],
                        'is_primary'=>$finalTrialColors[$t][""],
                        'active' => 'y'
                    );
                    $this->insert('leadpop_background_swatches' ,$leadpop_background_swatches);
                }

                $s = "select background_color from leadpop_background_color ";
                $s .= " where  client_id = " . $client_id;
                $s .= " and leadpop_version_id = " . $origleadpop_version_id;
                $s .= " and leadpop_version_seq = " . $origleadpop_version_seq . " limit 1 ";
                $background_css = $this->db->fetchOne($s);

                $leadpop_background_color  = array(
                    'client_id'=> $client_id,
                    'leadpop_vertical_id'=>$trialDefaults[$zz]["leadpop_vertical_id"],
                    'leadpop_vertical_sub_id'=>$trialDefaults[$zz]["leadpop_vertical_sub_id"],
                    'leadpop_type_id'=>$this->leadpoptype,
                    'leadpop_template_id'=>$trialDefaults[$zz]['leadpop_template_id'],
                    'leadpop_id' => $trialDefaults[$zz]["leadpop_id"],
                    'leadpop_version_id'=> $trialDefaults[$zz]["leadpop_version_id"],
                    'leadpop_version_seq'=>  $trialDefaults[$zz]["leadpop_version_seq"],
                    'background_color'=>addslashes($background_css),
                    'active' => 'y',
                    'default_changed' => $default_background_changed
                );
                $this->insert('leadpop_background_color' ,$leadpop_background_color);

                $s = "select logo_color  from leadpop_logos ";
                $s .= " where  client_id = " . $client_id;
                $s .= " and leadpop_vertical_id = " . $origvertical_id;
                $s .= " and leadpop_vertical_sub_id = " . $origsubvertical_id;
                $s .= " and leadpop_type_id  = " . $origleadpop_type_id;
                $s .= " and leadpop_template_id = " . $origleadpop_template_id;
                $s .= " and  leadpop_id = " . $origleadpop_id;
                $s .= " and leadpop_version_id = " . $origleadpop_version_id;
                $s .= " and leadpop_version_seq = " . $origleadpop_version_seq . " limit 1 ";
                $colors = $this->db->fetchRow($s);

                //			$s = "select * from trial_launch_defaults where leadpop_vertical_id = " . $vertical_id . " and leadpop_vertical_sub_id = " . $subvertical_id . " and leadpop_version_id = " . $version_id . " limit 1 ";
                //			$trialDefaults = $this->db->fetchAll($s);

                // copy logo to new logo name
                $this->newlogoname = strtolower($client_id . "_" . $trialDefaults[$zz]["leadpop_id"] . "_" . $trialDefaults[$zz]["leadpop_type_id"] . "_" . $trialDefaults[$zz]["leadpop_vertical_id"] . "_" . $trialDefaults[$zz]["leadpop_vertical_sub_id"] . "_" . $trialDefaults[$zz]["leadpop_template_id"] . "_" . $trialDefaults[$zz]["leadpop_version_id"] . "_" . $trialDefaults[$zz]["leadpop_version_seq"] . "_" . $logo);
                $logo_url = $this->getRackspaceUrl ('image_path','clients-assets').$section . '/' . $client_id . '/logos/' . $logo;
                $this->file_list[] = array(
                    'server_file' => $logo_url,
                    'container' => 'clients',
                    'rackspace_path' => 'images1/'.$section . '/' . $client_id . '/logos/' . $this->newlogoname
                );

                // copy mobile logo to new name remove code from @mzac90
                $oldfilename = strtolower($client_id . "_" . $origleadpop_id . "_" . $origleadpop_type_id . "_" . $origvertical_id . "_" . $origsubvertical_id . "_" . $origleadpop_template_id . "_" . $origleadpop_version_id . "_" . $origleadpop_version_seq);
                $newfilename = $client_id . "_" . $trialDefaults[$zz]["leadpop_id"] . "_1_" . $trialDefaults[$zz]["leadpop_vertical_id"] . "_" . $trialDefaults[$zz]["leadpop_vertical_sub_id"] . "_" . $trialDefaults[$zz]['leadpop_template_id'] . "_" . $trialDefaults[$zz]["leadpop_version_id"] . "_" . $trialDefaults[$zz]["leadpop_version_seq"];

                $this->origfavicon_dst_src =  $this->getRackspaceUrl ('image_path','clients-assets').$section . '/' . $client_id . '/logos/' . $oldfilename . '_favicon-circle.png';
                $this->newfavicon_dst_src =   $newfilename . '_favicon-circle.png';

                $this->file_list[] = array(
                    'server_file' => $this->origfavicon_dst_src,
                    'container' => 'clients',
                    'rackspace_path' => 'images1/'.$section . '/' . $client_id . '/logos/' . $this->newfavicon_dst_src
                );

                $this->origcolored_dot_src =  $this->getRackspaceUrl ('image_path','clients-assets').$section . '/' . $client_id. '/logos/' . $oldfilename . '_dot_img.png';
                $this->newcolored_dot_src =   $newfilename . '_dot_img.png';

                $this->file_list[] = array(
                    'server_file' =>  $this->origcolored_dot_src,
                    'container' => 'clients',
                    'rackspace_path' => 'images1/'.$section . '/' . $client_id . '/logos/' . $this->newcolored_dot_src
                );

                $this->logosrc =  $this->newinsertClientUploadLogo($this->newlogoname, $trialDefaults[$zz], $client_id);
                $this->imgsrc = $this->insertClientNotDefaultImage($trialDefaults[$zz], $client_id, $origleadpop_id, $origleadpop_type_id, $origvertical_id, $origsubvertical_id, $origleadpop_template_id, $origleadpop_version_id, $origleadpop_version_seq);

                $this->globallogosrc =  $this->logosrc;
                $this->globalfavicon_dst =  $this->getRackspaceUrl ('image_path','clients-assets').$section . '/' . $client_id. '/logos/' .$this->newfavicon_dst_src;
                $this->globallogo_color = $colors["logo_color"];
                $this->globalcolored_dot = $this->getRackspaceUrl ('image_path','clients-assets').$section . '/' . $client_id. '/logos/' .$this->newcolored_dot_src;

                // set mobile logo varibale
                $this->newlogoname = "";
                $this->origcolored_dot_src = "";
                $this->newcolored_dot_src = "";

            }
            else if ($generatecolors == true && $useUploadedLogo == true) { //


                //			$s = "select * from trial_launch_defaults where leadpop_vertical_id = " . $vertical_id . " and leadpop_vertical_sub_id = " . $subvertical_id . " and leadpop_version_id = " . $version_id . " limit 1 ";
                //			$trialDefaults = $this->db->fetchAll($s);
                $this->origlogo = $this->getRackspaceUrl ('image_path','clients-assets').$section . '/' . $client_id . '/logos/' . $logo;
                $this->newlogoname = strtolower($client_id . "_" . $trialDefaults[$zz]["leadpop_id"] . "_" . $trialDefaults[$zz]["leadpop_type_id"] . "_" . $trialDefaults[$zz]["leadpop_vertical_id"] . "_" . $trialDefaults[$zz]["leadpop_vertical_sub_id"] . "_" . $trialDefaults[$zz]["leadpop_template_id"] . "_" . $trialDefaults[$zz]["leadpop_version_id"] . "_" . $trialDefaults[$zz]["leadpop_version_seq"] . "_" . $logo);
                $oldlogo =  $this->downloadRackspaceImage( $this->origlogo);

                $this->file_list[] = array(
                    'server_file' => $this->origlogo,
                    'container' => 'clients',
                    'rackspace_path' => 'images1/'.$section . '/' . $client_id . '/logos/' . $this->newlogoname
                );
                $oclient = new Client();

                //print($newlogo . "\r\n");
                $gis = getimagesize($oldlogo);
                $type = $gis[2];
                switch ($type) {
                    case "1":
                        //imagecreatefromgif removed for mobile logo from @mzac90
                        $image = $oclient->loadGif($oldlogo);
                        $this->logo_color = $image->extract();
                        break;
                    case "2":
                        //imagecreatefromjpeg removed for mobile logo from @mzac90
                        $image = $oclient->loadJpeg($oldlogo);
                        $this->logo_color = $image->extract();
                        break;
                    case "3":
                        //imagecreatefrompng removed for mobile logo from @mzac90
                        $image = $oclient->loadPng($oldlogo);
                        $this->logo_color = $image->extract();
                        break;
                    default:
                        //imagecreatefromjpeg removed for mobile logo from @mzac90

                }


                if (is_array($this->logo_color)) {
                    $this->logo_color = $this->logo_color[0];
                }

                $imagetype = image_type_to_mime_type($type);
                if ($imagetype != 'image/jpeg' && $imagetype != 'image/png' && $imagetype != 'image/gif') {
                    return 'bad';
                }

                $leadpop_logos = array(
                    'client_id'=> $client_id,
                    'leadpop_id'=> $trialDefaults[$zz]["leadpop_id"],
                    'leadpop_type_id'=> $trialDefaults[$zz]["leadpop_type_id"],
                    'leadpop_vertical_id'=> $trialDefaults[$zz]["leadpop_vertical_id"],
                    'leadpop_vertical_sub_id'=>  $trialDefaults[$zz]["leadpop_vertical_sub_id"],
                    'leadpop_template_id' => $trialDefaults[$zz]["leadpop_template_id"],
                    'leadpop_version_id'=> $trialDefaults[$zz]["leadpop_version_id"],
                    'leadpop_version_seq'=>  $trialDefaults[$zz]["leadpop_version_seq"],
                    'use_default'=> 'n',
                    'logo_src' => $this->newlogoname,
                    'use_me' => 'y',
                    'numpics' => 1,
                    'logo_color' => $this->logo_color,
                    'ini_logo_color'  => $this->logo_color
                );
                $this->insert('leadpop_logos' ,$leadpop_logos);

                $this->logosrc =  $this->getRackspaceUrl ('image_path','clients-assets').$section . '/' . $client_id . '/logos/' . $this->newlogoname;

                $this->image_location = $this->getRackspaceUrl ('image_path','default-assets')."images/dot-img.png";
                $this->favicon_location =  $this->getRackspaceUrl ('image_path','default-assets')."images/favicon-circle.png";
                $this->favicon_dst_src =  public_path().'/'.env('RACKSPACE_TMP_DIR', '').'/'. $this->newlogoname . '_favicon-circle.png';
                $this->colored_dot_src =  public_path().'/'.env('RACKSPACE_TMP_DIR', '').'/' . $this->newlogoname . '_dot_img.png';

                if (isset($this->logo_color) && $this->logo_color != "") {
                    $new_clr = $this->hex2rgb($this->logo_color);
                }

                $myRed = $new_clr[0];
                $myGreen = $new_clr[1];
                $myBlue = $new_clr[2];

                $this->colorizeBasedOnAplhaChannnel($this->image_location, $myRed, $myGreen, $myBlue, $this->colored_dot_src);
                $this->colorizeBasedOnAplhaChannnel($this->favicon_location, $myRed, $myGreen, $myBlue, $this->favicon_dst_src);

                $this->colored_dot = $this->getRackspaceUrl ('image_path','clients-assets').$section . '/' . $client_id . '/logos/' . $this->newlogoname . '_dot_img.png';
                $this->favicon_dst = $this->getRackspaceUrl ('image_path','clients-assets').$section . '/' . $client_id . '/logos/' . $this->newlogoname . '_favicon-circle.png';

                $this->file_list[] = array(
                    'server_file' =>   LP_BASE_URL.'/'.env('RACKSPACE_TMP_DIR', '').'/'.$this->newlogoname . '_dot_img.png',
                    'container' => 'clients',
                    'rackspace_path' => 'images1/'.$section . '/' . $client_id . '/logos/' . $this->newlogoname . '_dot_img.png'
                );

                $this->file_list[] = array(
                    'server_file' => LP_BASE_URL.'/'.env('RACKSPACE_TMP_DIR', '').'/'. $this->newlogoname . '_favicon-circle.png',
                    'container' => 'clients',
                    'rackspace_path' => 'images1/'.$section . '/' . $client_id . '/logos/' .  $this->newlogoname . '_favicon-circle.png'
                );
                $swatches = "213-230-229#23-177-163#159-182-183#65-88-96#110-158-159#132-212-204";

                $result = explode("#", $swatches);
                $new_color = $this->hex2rgb($this->logo_color);
                $index = 0;
                array_unshift($result, implode('-', $new_color));

                // SET BACKGROUND COLOR
                $background_from_logo = '/*###>*/background-color: rgba(' . $new_color[0] . ', ' . $new_color[1] . ', ' . $new_color[2] . ', 1);/*@@@*/
			background-image: linear-gradient(to right bottom,rgba(' . $new_color[0] . ', ' . $new_color[1] . ', ' . $new_color[2] . ', 1) 0%,rgba(' . $new_color[0] . ', ' . $new_color[1] . ', ' . $new_color[2] . ', 1) 100%); /* W3C */';

                $leadpop_background_color = array(
                    'client_id'=> $client_id,
                    'leadpop_vertical_id'=> $trialDefaults[$zz]["leadpop_vertical_id"],
                    'leadpop_vertical_sub_id'=> $trialDefaults[$zz]["leadpop_vertical_sub_id"],
                    'leadpop_type_id'=> $this->leadpoptype,
                    'leadpop_template_id'=> $trialDefaults[$zz]['leadpop_template_id'],
                    'leadpop_id' => $trialDefaults[$zz]["leadpop_id"],
                    'leadpop_version_id'=> $trialDefaults[$zz]["leadpop_version_id"],
                    'leadpop_version_seq'=>  $trialDefaults[$zz]["leadpop_version_seq"],
                    'background_color'=> addslashes($background_from_logo),
                    'active' => 'y',
                    'default_changed' => 'y'
                );

                $this->insert('leadpop_background_color' ,$leadpop_background_color);

                foreach ($result as $key => $value) {

                    list($red, $green, $blue) = explode("-", $value);

                    if ($key < 1) {
                        $str0 = "linear-gradient(to bottom, rgba(" . $red . "," . $green . "," . $blue . ",1.0) 0%,rgba(" . $red . "," . $green . "," . $blue . ",1.0) 100%)";
                    } else {
                        $str0 = "linear-gradient(to bottom, rgba(" . $red . "," . $green . "," . $blue . ",1.0) 0%,rgba(" . $red . "," . $green . "," . $blue . ",.7) 100%)";
                    }

                    $str1 = "linear-gradient(to top, rgba(" . $red . "," . $green . "," . $blue . ",1.0) 0%,rgba(" . $red . "," . $green . "," . $blue . ",.7) 100%)";
                    $str2 = "linear-gradient(to bottom right, rgba(" . $red . "," . $green . "," . $blue . ",1.0) 0%,rgba(" . $red . "," . $green . "," . $blue . ",.7) 100%)";
                    $str3 = "linear-gradient(to bottom, rgba(" . $red . "," . $green . "," . $blue . ",1.0) 0%,rgba(" . $red . "," . $green . "," . $blue . ",1.0) 100%)";

                    $swatches = array($str0, $str1, $str2, $str3);
                    for ($i = 0; $i < 4; $i++) {
                        $index++;
                        $is_primary = 'n';
                        if ($index == 1) {
                            $is_primary = 'y';
                        }

                        $leadpop_background_swatches = array(
                            'client_id'=> $client_id,
                            'leadpop_vertical_id'=> $trialDefaults[$zz]["leadpop_vertical_id"],
                            'leadpop_vertical_sub_id'=> $trialDefaults[$zz]["leadpop_vertical_sub_id"],
                            'leadpop_type_id'=> $trialDefaults[$zz]["leadpop_type_id"],
                            'leadpop_template_id'=> $trialDefaults[$zz]['leadpop_template_id'],
                            'leadpop_id' => $trialDefaults[$zz]["leadpop_id"],
                            'leadpop_version_id'=> $trialDefaults[$zz]["leadpop_version_id"],
                            'leadpop_version_seq'=>  $trialDefaults[$zz]["leadpop_version_seq"],
                            'swatch'=> addslashes($swatches[$i]),
                            'is_primary' => $is_primary,
                            'active' => 'y'
                        );

                        $this->insert('leadpop_background_swatches' ,$leadpop_background_swatches);

                    }
                }
                // $background_css,  $finalTrialColors removed, we are usgin  variable in this case. @mzac90

               //mobile logo generate functionality removed from @mzac90

                $this->logosrc = $this->newinsertClientUploadLogo($this->newlogoname, $trialDefaults[$zz], $client_id);
                $this->imgsrc = $this->insertClientDefaultImage($trialDefaults[$zz], $client_id);
                $this->setClientDefaultFaviconColor($trialDefaults[$zz]);

                $this->globallogosrc = $this->logosrc;
                $this->globalfavicon_dst = $this->favicon_dst;
                $this->globallogo_color = $this->logo_color;
                $this->globalcolored_dot = $this->colored_dot;
                print($this->logosrc . "\r\n");
                unset($this->origlogo);
                unset($this->newlogoname);
                unset($this->origcolored_dot_src);
                unset($this->newcolored_dot_src);
                unset($oclient);
                print($zz . " at zz \r\n");
            }

            $this->insertDefaultAutoResponders($client_id, $trialDefaults[$zz], $client["contact_email"], $client["phone_number"]);
            //$template_info removed because we are not using placeholder css, js path variable right now @mzac90

            $s = "select * from leadpops_verticals where id = " . $trialDefaults[$zz]["leadpop_vertical_id"];
            $vertres = $this->db->fetchRow($s);
            $verticalName = $vertres ['lead_pop_vertical'];
            /*
            * Add default vertical name in leadpops_folders table
            * */
            $folder_id  = $this->addFolder($verticalName,$client_id);

            $lead_line = '<span style="font-family: ' . $trialDefaults[$zz]["main_message_font"] . '; font-size: ' . $trialDefaults[$zz]["main_message_font_size"] . '; color: ' . ($this->globallogo_color == "" ? $trialDefaults[$zz]["mainmessage_color"] : $this->globallogo_color) . '">' . $trialDefaults[$zz]["main_message"] . '</span>';
            $second_line = '<span style="font-family: ' . $trialDefaults[$zz]["description_font"] . '; font-size: ' . $trialDefaults[$zz]["description_font_size"] . '; color: ' . $trialDefaults[$zz]["description_color"] . '">' . $trialDefaults[$zz]["description"] . '</span>';

            if($trialDefaults[$zz]["conditional_logic"]==null || $trialDefaults[$zz]["conditional_logic"]=="null"){
                $trialDefaults[$zz]["conditional_logic"] = "{}";
            }

            $now = new DateTime();
            $clients_leadpops  = array(
                'client_id'=> $client_id,
                'question_sequence' =>  addslashes($trialDefaults[$zz]["question_sequence"]),
                'funnel_questions' => addslashes($trialDefaults[$zz]["funnel_questions"]),
                'conditional_logic' =>  $trialDefaults[$zz]["conditional_logic"],
                'lead_line' =>  addslashes($lead_line),
                'second_line_more' =>  addslashes($second_line),
                'funnel_name' => $trialDefaults[$zz]["funnel_name"],
                'leadpop_folder_id' => $folder_id,
                'leadpop_id'=>  $trialDefaults[$zz]["leadpop_id"],
                'leadpop_version_id'=> $trialDefaults[$zz]["leadpop_version_id"],
                'leadpop_active'=>  '1',
                'access_code'=> '',
                'leadpop_version_seq' =>  $trialDefaults[$zz]["leadpop_version_seq"],
                'date_added'=> $now->format("Y-m-d H:i:s")
            );
            $client_leadpop_id = $this->insert('clients_leadpops' ,$clients_leadpops);

            $this->assignTagToFunnel($client_leadpop_id,$trialDefaults[$zz],$client_id);

            $clients_leadpops_content  = array(
                'client_id'=> $client_id,
                'leadpop_id'=>  $trialDefaults[$zz]["leadpop_id"],
                'leadpop_version_id'=> $trialDefaults[$zz]["leadpop_version_id"],
                'leadpop_active'=>  '1',
                'access_code'=> '',
                'leadpop_version_seq' => $trialDefaults[$zz]["leadpop_version_seq"],
                'section1'=> '<h4>section one</h4>',
                'section2'=> '<h4>section two</h4>',
                'section3'=> '<h4>section three</h4>',
                'section4'=> '<h4>section four</h4>',
                'section5'=> '<h4>section five</h4>',
                'section6'=> '<h4>section six</h4>',
                'section7'=> '<h4>section seven</h4>',
                'section8'=> '<h4>section eight</h4>',
                'section9'=> '<h4>section nine</h4>',
                'section10'=> '<h4>section ten</h4>',
                'template'=> 1
            );
            $this->insert('clients_leadpops_content' ,$clients_leadpops_content);
            $this->checkIfNeedMultipleStepInsert($trialDefaults[$zz]["leadpop_version_id"], $client_id);
            // look up domain name
            $s = "select * from clients where client_id = " . $client_id . " limit 1 ";
            $client = $this->db->fetchRow($s);
            $subdomain = $client ['company_name'];
            $subdomain = preg_replace('/[^a-zA-Z]/', '', $subdomain);
            $s = "select domain from top_level_domains where primary_domain = 'y' limit 1 ";
            $topdomain = $this->db->fetchOne($s);
            if ($this->leadpoptype == $this->thissub_domain) {
                $s = "select  count(*) from clients_funnels_domains where  ";
                $s .= " subdomain_name = '" . $subdomain . "' ";
                $s .= " and top_level_domain = '" . $topdomain . "' ";
                $foundsubdomain = $this->db->fetchOne($s);
                if ($foundsubdomain > 0) {
                    $s = "select domain from top_level_domains where primary_domain != 'y' ";
                    $nonprimary = $this->db->fetchAll($s);
                    $foundone = false;
                    while ($foundone == false) {
                        for ($k = 0; $k < count($nonprimary); $k++) {
                            $s = "select  count(*) from clients_funnels_domains where  ";
                            $s .= " subdomain_name = '" . $subdomain . "' ";
                            $s .= " and top_level_domain = '" . $nonprimary [$k] ['domain'] . "' ";
                            $foundsubdomain = $this->db->fetchOne($s);
                            if ($foundsubdomain == 0) {

                                $clients_subdomains  = array(
                                    'client_id'=> $client_id,
                                    'subdomain_name'=> $subdomain,
                                    'top_level_domain'=> $nonprimary [$k] ['domain'],
                                    'leadpop_vertical_id'=>  $trialDefaults[$zz]["leadpop_vertical_id"],
                                    'leadpop_vertical_sub_id'=> $trialDefaults[$zz]["leadpop_vertical_sub_id"],
                                    'leadpop_type_id' => $this->leadpoptype,
                                    'leadpop_template_id'=> $trialDefaults[$zz]['leadpop_template_id'],
                                    'leadpop_id'=>  $trialDefaults[$zz]["leadpop_id"],
                                    'leadpop_version_id'=> $trialDefaults[$zz]["leadpop_version_id"],
                                    'leadpop_version_seq' => $trialDefaults[$zz]["leadpop_version_seq"],
                                );

                                $this->insert('clients_funnels_domains' ,$clients_subdomains);

                                /* emma insert */
                                $s = "  select * from client_emma_group  ";
                                $s .= " where leadpop_vertical_id = " . $trialDefaults[$zz]["leadpop_vertical_id"];
                                $s .= " and leadpop_subvertical_id = " .  $trialDefaults[$zz]["leadpop_vertical_sub_id"];
                                $s .= " and client_id = " .$client_id . "";
                                $emmaExists =  $this->db->fetchRow($s);
                                if ($emmaExists) {
                                    $client_emma_group  = array(
                                        'client_id'=> $client_id,
                                        'domain_name'=>  $subdomain . "." . $nonprimary [$k] ['domain'],
                                        'member_account_id'=> $emmaExists["member_account_id"],
                                        'member_group_id'=>   $emmaExists["member_group_id"],
                                        'group_name'=> $emmaExists["group_name"],
                                        'total_contacts' => '0',
                                        'leadpop_vertical_id' => $trialDefaults[$zz]["leadpop_vertical_id"],
                                        'leadpop_subvertical_id'=> $trialDefaults[$zz]["leadpop_vertical_sub_id"],
                                        'active'=> 'y'
                                    );
                                    $this->insert('client_emma_group' ,$client_emma_group);
                                }
                                else{
                                    //Taking basic information for emma from one of existing entry
                                    $sql = "SELECT id, emma_default_group, account_name, master_account_ids FROM client_emma_cron WHERE ";
                                    $sql .= " client_id= ".$client_id." and leadpop_vertical_id = ".$trialDefaults[$zz]["leadpop_vertical_id"]."
                                    and leadpop_subvertical_id = ".$trialDefaults[$zz]["leadpop_vertical_sub_id"]."";
                                    $ex_emma_cron = $this->db->fetchRow( $sql );

                                    if($ex_emma_cron) {
                                        $EmmaAccountName = $ex_emma_cron['account_name'];
                                        $master_account_ids = $ex_emma_cron['master_account_ids'];
                                        $emma_default_group = $ex_emma_cron['emma_default_group'];

                                        //Check the entry in client_emma_account table
                                        $emma_account = "SELECT * FROM client_emma_account WHERE client_id= " . $client_id . "";
                                        $emma_account_res = $this->db->fetchRow($emma_account);
                                        if (empty($emma_account_res)) {
                                            /* emma insert */
                                            $client_emma_cron = array(
                                                'client_id'=> $client_id,
                                                'emma_default_group'=>  $emma_default_group,
                                                'account_type'=> $emma_account_type,
                                                'domain_name'=>   strtolower($subdomain . "." . $nonprimary [$k] ['domain']),
                                                'account_name'=> $EmmaAccountName,
                                                'master_account_ids' => addslashes($master_account_ids),
                                                'has_run'=> 'n',
                                                'leadpop_vertical_id'=>   $trialDefaults[$zz]["leadpop_vertical_id"],
                                                'leadpop_subvertical_id'=> $trialDefaults[$zz]["leadpop_vertical_sub_id"]
                                            );
                                            $this->insert('client_emma_cron' ,$client_emma_cron);
                                        } else {
                                            /*if already existing the entry then insert entry in the client_emma_group table*/
                                            $client_emma_group  = array(
                                                'client_id'=> $client_id,
                                                'domain_name'=>  $subdomain . "." . $nonprimary [$k] ['domain'],
                                                'member_account_id'=> $emmaExists["member_account_id"],
                                                'member_group_id'=>   $emmaExists["member_group_id"],
                                                'group_name'=> $emmaExists["group_name"],
                                                'total_contacts' => '0',
                                                'leadpop_vertical_id' => $trialDefaults[$zz]["leadpop_vertical_id"],
                                                'leadpop_subvertical_id'=> $trialDefaults[$zz]["leadpop_vertical_sub_id"],
                                                'active'=> 'y'
                                            );
                                            $this->insert('client_emma_group' ,$client_emma_group);
                                        }
                                    }

                                }
                                /* emma insert */
                               //mobile client functionality removed from @mzac90
                                $googleDomain = $subdomain . "." . $nonprimary [$k] ['domain'];
                                $this->insertPurchasedGoogle($client_id, $googleDomain);

                                if ($generatecolors == false && $useUploadedLogo == true) { // get mobile from old funnel
                                    // set 	client_or_domain_logo_image to 'c'  to use upploaded logo
                                    /* mobile domain and logo */
                                    $s = "select * from bottom_links  where client_id = " . $client_id;
                                    $s .= " and leadpop_id = " . $origleadpop_id;
                                    $s .= " and leadpop_type_id = " . $origleadpop_type_id;
                                    $s .= " and leadpop_vertical_id = " . $origvertical_id;
                                    $s .= " and leadpop_vertical_sub_id = " . $origsubvertical_id;
                                    $s .= " and leadpop_template_id = " . $origleadpop_template_id;
                                    $s .= " and leadpop_version_id = " . $origleadpop_version_id;
                                    $s .= " and leadpop_version_seq = " . $origleadpop_version_seq . " limit 1 ";
                                    $oldbototm = $this->db->fetchRow($s);
                                    $bottom_links  = array(
                                        'client_id'=> $client_id,
                                        'leadpop_id'=>  $trialDefaults[$zz]["leadpop_id"],
                                        'leadpop_type_id'=>  $trialDefaults[$zz]["leadpop_type_id"],
                                        'leadpop_vertical_id'=>   $trialDefaults[$zz]["leadpop_vertical_id"],
                                        'leadpop_vertical_sub_id'=> $trialDefaults[$zz]["leadpop_vertical_sub_id"],
                                        'leadpop_template_id' => $trialDefaults[$zz]['leadpop_template_id'],
                                        'leadpop_version_id'=> $trialDefaults[$zz]["leadpop_version_id"],
                                        'leadpop_version_seq'=>   $trialDefaults[$zz]["leadpop_version_seq"],
                                        'privacy'=> '',
                                        'terms'=> '',
                                        'disclosures'=>  '',
                                        'licensing'=> '',
                                        'about'=>   '',
                                        'contact'=> '',
                                        'privacy_active' => 'n',
                                        'terms_active'=> 'n',
                                        'disclosures_active'=>  'n',
                                        'licensing_active'=> 'n',
                                        'about_active'=> 'n',
                                        'contact_active'=>  'n',
                                        'privacy_type'=> 'm',
                                        'terms_type'=>   'm',
                                        'disclosures_type'=> 'm',
                                        'licensing_type' => 'm',
                                        'about_type'=> 'm',
                                        'contact_type'=>   'm',
                                        'privacy_url'=> '',
                                        'terms_url'=> '',
                                        'disclosures_url'=>  '',
                                        'licensing_url'=> '',
                                        'about_url'=>   '',
                                        'contact_url'=> '',
                                        'privacy_text' => '',
                                        'terms_text'=> '',
                                        'disclosures_text'=> '',
                                        'licensing_text'=> '',
                                        'about_text'=> '',
                                        'contact_text'=>  '',
                                        'compliance_text'=> $oldbototm["compliance_text"],
                                        'compliance_is_linked'=>  $oldbototm["compliance_is_linked"],
                                        'compliance_link'=>$oldbototm["compliance_link"],
                                        'compliance_active' => $oldbototm["compliance_active"],
                                        'license_number_active'=> $oldbototm["license_number_active"],
                                        'license_number_is_linked'=> $oldbototm["license_number_is_linked"],
                                        'license_number_text'=> $oldbototm["license_number_text"],
                                        'license_number_link'=> $oldbototm["license_number_link"]
                                    );
                                    $this->insert('bottom_links' ,$bottom_links);

                                } else {
                                    if (($vertical == "mortgage" || $vertical == "realestate")) {
                                        $bottom_links  = array(
                                            'client_id'=> $client_id,
                                            'leadpop_id'=>  $trialDefaults[$zz]["leadpop_id"],
                                            'leadpop_type_id'=>  $trialDefaults[$zz]["leadpop_type_id"],
                                            'leadpop_vertical_id'=>   $trialDefaults[$zz]["leadpop_vertical_id"],
                                            'leadpop_vertical_sub_id'=> $trialDefaults[$zz]["leadpop_vertical_sub_id"],
                                            'leadpop_template_id' => $trialDefaults[$zz]['leadpop_template_id'],
                                            'leadpop_version_id'=> $trialDefaults[$zz]["leadpop_version_id"],
                                            'leadpop_version_seq'=>   $trialDefaults[$zz]["leadpop_version_seq"],
                                            'privacy'=> '',
                                            'terms'=> '',
                                            'disclosures'=>  '',
                                            'licensing'=> '',
                                            'about'=>   '',
                                            'contact'=> '',
                                            'privacy_active' => 'n',
                                            'terms_active'=> 'n',
                                            'disclosures_active'=>  'n',
                                            'licensing_active'=> 'n',
                                            'about_active'=> 'n',
                                            'contact_active'=>  'n',
                                            'privacy_type'=> 'm',
                                            'terms_type'=>   'm',
                                            'disclosures_type'=> 'm',
                                            'licensing_type' => 'm',
                                            'about_type'=> 'm',
                                            'contact_type'=>   'm',
                                            'privacy_url'=> '',
                                            'terms_url'=> '',
                                            'disclosures_url'=>  '',
                                            'licensing_url'=> '',
                                            'about_url'=>   '',
                                            'contact_url'=> '',
                                            'privacy_text' => '',
                                            'terms_text'=> '',
                                            'disclosures_text'=> '',
                                            'licensing_text'=> '',
                                            'about_text'=> '',
                                            'contact_text'=>  '',
                                            'compliance_text'=> 'NMLS Consumer Look Up',
                                            'compliance_is_linked'=>  'y',
                                            'compliance_link'=> 'http://www.nmlsconsumeraccess.org',
                                            'compliance_active' => 'y',
                                            'license_number_active'=> 'y',
                                            'license_number_is_linked'=> 'n',
                                            'license_number_text'=> '',
                                            'license_number_link'=> ''
                                        );
                                        $this->insert('bottom_links' ,$bottom_links);
                                    } else if ($vertical == "insurance") {
                                        $bottom_links  = array(
                                            'client_id'=> $client_id,
                                            'leadpop_id'=>  $trialDefaults[$zz]["leadpop_id"],
                                            'leadpop_type_id'=>  $trialDefaults[$zz]["leadpop_type_id"],
                                            'leadpop_vertical_id'=>   $trialDefaults[$zz]["leadpop_vertical_id"],
                                            'leadpop_vertical_sub_id'=> $trialDefaults[$zz]["leadpop_vertical_sub_id"],
                                            'leadpop_template_id' => $trialDefaults[$zz]['leadpop_template_id'],
                                            'leadpop_version_id'=> $trialDefaults[$zz]["leadpop_version_id"],
                                            'leadpop_version_seq'=>   $trialDefaults[$zz]["leadpop_version_seq"],
                                            'privacy'=> '',
                                            'terms'=> '',
                                            'disclosures'=>  '',
                                            'licensing'=> '',
                                            'about'=>   '',
                                            'contact'=> '',
                                            'privacy_active' => 'n',
                                            'terms_active'=> 'n',
                                            'disclosures_active'=>  'n',
                                            'licensing_active'=> 'n',
                                            'about_active'=> 'n',
                                            'contact_active'=>  'n',
                                            'privacy_type'=> 'm',
                                            'terms_type'=>   'm',
                                            'disclosures_type'=> 'm',
                                            'licensing_type' => 'm',
                                            'about_type'=> 'm',
                                            'contact_type'=>   'm',
                                            'privacy_url'=> '',
                                            'terms_url'=> '',
                                            'disclosures_url'=>  '',
                                            'licensing_url'=> '',
                                            'about_url'=>   '',
                                            'contact_url'=> '',
                                            'privacy_text' => '',
                                            'terms_text'=> '',
                                            'disclosures_text'=> '',
                                            'licensing_text'=> '',
                                            'about_text'=> '',
                                            'contact_text'=>  '',
                                            'compliance_text'=> 'NMLS Consumer Look Up',
                                            'compliance_is_linked'=>  'y',
                                            'compliance_link'=> 'http://www.nmlsconsumeraccess.org',
                                            'compliance_active' => 'y',
                                            'license_number_active'=> 'y',
                                            'license_number_is_linked'=> 'n',
                                            'license_number_text'=> '',
                                            'license_number_link'=> ''
                                        );
                                        $this->insert('bottom_links' ,$bottom_links);

                                        $this->db->query($s);
                                    } else {
                                        $bottom_links  = array(
                                            'client_id'=> $client_id,
                                            'leadpop_id'=>  $trialDefaults[$zz]["leadpop_id"],
                                            'leadpop_type_id'=>  $trialDefaults[$zz]["leadpop_type_id"],
                                            'leadpop_vertical_id'=>   $trialDefaults[$zz]["leadpop_vertical_id"],
                                            'leadpop_vertical_sub_id'=> $trialDefaults[$zz]["leadpop_vertical_sub_id"],
                                            'leadpop_template_id' => $trialDefaults[$zz]['leadpop_template_id'],
                                            'leadpop_version_id'=> $trialDefaults[$zz]["leadpop_version_id"],
                                            'leadpop_version_seq'=>   $trialDefaults[$zz]["leadpop_version_seq"],
                                            'privacy'=> '',
                                            'terms'=> '',
                                            'disclosures'=>  '',
                                            'licensing'=> '',
                                            'about'=>   '',
                                            'contact'=> '',
                                            'privacy_active' => 'n',
                                            'terms_active'=> 'n',
                                            'disclosures_active'=>  'n',
                                            'licensing_active'=> 'n',
                                            'about_active'=> 'n',
                                            'contact_active'=>  'n',
                                            'privacy_type'=> 'm',
                                            'terms_type'=>   'm',
                                            'disclosures_type'=> 'm',
                                            'licensing_type' => 'm',
                                            'about_type'=> 'm',
                                            'contact_type'=>   'm',
                                            'privacy_url'=> '',
                                            'terms_url'=> '',
                                            'disclosures_url'=>  '',
                                            'licensing_url'=> '',
                                            'about_url'=>   '',
                                            'contact_url'=> '',
                                            'privacy_text' => '',
                                            'terms_text'=> '',
                                            'disclosures_text'=> '',
                                            'licensing_text'=> '',
                                            'about_text'=> '',
                                            'contact_text'=>  '',
                                            'compliance_text'=> '',
                                            'compliance_is_linked'=>  '',
                                            'compliance_link'=> '',
                                            'compliance_active' => '',
                                            'license_number_active'=> '',
                                            'license_number_is_linked'=> '',
                                            'license_number_text'=> '',
                                            'license_number_link'=> ''
                                        );
                                        $this->insert('bottom_links' ,$bottom_links);
                                    }
                                }

                                $x1 = '<p style="text-align: center;">';
                                $x1 .= '     <span style="font-family:arial,helvetica,sans-serif;">';
                                $x1 .= '     <span style="font-size: 22px;">';
                                $x1 .= '     <span style="color: rgb(51, 102, 255);">Thank You For Your Submission!</span><br />';
                                $x1 .= '     <span style="color: rgb(51, 51, 51);">';
                                $x1 .= '     <span style="font-size: 14px;">We have received your inquiry. An expert will follow up with you shortly.';
                                $x1 .= '     </span>';
                                $x1 .= '     </span>';
                                $x1 .= '     </span>';
                                $x1 .= '     </span>        ';
                                $x1 .= '   </p>   ';

                                $contact_options  = array(
                                    'client_id'=> $client_id,
                                    'leadpop_id'=>  $trialDefaults[$zz]["leadpop_id"],
                                    'leadpop_type_id'=>  $trialDefaults[$zz]["leadpop_type_id"],
                                    'leadpop_vertical_id'=>   $trialDefaults[$zz]["leadpop_vertical_id"],
                                    'leadpop_vertical_sub_id'=> $trialDefaults[$zz]["leadpop_vertical_sub_id"],
                                    'leadpop_template_id' => $trialDefaults[$zz]['leadpop_template_id'],
                                    'leadpop_version_id'=> $trialDefaults[$zz]["leadpop_version_id"],
                                    'leadpop_version_seq'=>   $trialDefaults[$zz]["leadpop_version_seq"],
                                    'companyname'=> addslashes($client ['company_name']),
                                    'phonenumber'=> 'Call Today! ' . $client ['phone_number'],
                                    'email'=>  $client ['contact_email'],
                                    'companyname_active'=> 'n',
                                    'phonenumber_active'=>   'y',
                                    'email_active'=> 'n'
                                );
                                $this->insert('contact_options' ,$contact_options);

                                //add review bar
                                $trustpilot_reviewbar  = array(
                                    'client_id'=> $client_id,
                                    'leadpop_id'=>  $trialDefaults[$zz]["leadpop_id"],
                                    'leadpop_type_id'=>  $trialDefaults[$zz]["leadpop_type_id"],
                                    'leadpop_vertical_id'=>   $trialDefaults[$zz]["leadpop_vertical_id"],
                                    'leadpop_vertical_sub_id'=> $trialDefaults[$zz]["leadpop_vertical_sub_id"],
                                    'leadpop_template_id' => $trialDefaults[$zz]['leadpop_template_id'],
                                    'leadpop_version_id'=> $trialDefaults[$zz]["leadpop_version_id"],
                                    'leadpop_version_seq'=>   $trialDefaults[$zz]["leadpop_version_seq"],
                                    'bar_active'=> 'n',
                                    'bar_text'=> 'What Our Customers Say:',
                                    'bar_score'=>  '',
                                    'bar_reviews'=> ''
                                );
                                $this->insert('trustpilot_reviewbar' ,$trustpilot_reviewbar);

                                $autotext =$this->getAutoResponderText($trialDefaults[$zz]["leadpop_vertical_id"], $trialDefaults[$zz]["leadpop_vertical_sub_id"], $trialDefaults[$zz]["leadpop_id"]);
                                if ($autotext == "not found") {
                                    $thehtml = "";
                                    $thesubject = "";
                                } else {
                                    $thehtml = $autotext[0]["html"];
                                    $thesubject = $autotext[0]["subject_line"];
                                }
                                $autoresponder_options  = array(
                                    'client_id'=> $client_id,
                                    'leadpop_id'=>  $trialDefaults[$zz]["leadpop_id"],
                                    'leadpop_type_id'=>  $trialDefaults[$zz]["leadpop_type_id"],
                                    'leadpop_vertical_id'=>   $trialDefaults[$zz]["leadpop_vertical_id"],
                                    'leadpop_vertical_sub_id'=> $trialDefaults[$zz]["leadpop_vertical_sub_id"],
                                    'leadpop_template_id' => $trialDefaults[$zz]['leadpop_template_id'],
                                    'leadpop_version_id'=> $trialDefaults[$zz]["leadpop_version_id"],
                                    'leadpop_version_seq'=>   $trialDefaults[$zz]["leadpop_version_seq"],
                                    'html'=> addslashes($thehtml),
                                    'thetext'=> '',
                                    'html_active'=>  'y',
                                    'text_active'=> 'n',
                                    'subject_line'=>  addslashes($thesubject)
                                );
                                $this->insert('autoresponder_options' ,$autoresponder_options);

                                $title_tag = " FREE " . $trialDefaults[$zz]["display_name"] . " | " . addslashes(ucwords($client ['company_name']));
                                //FREE Home Purchase Qualifier | Sentinel Mortgage Company
                                $seo_options  = array(
                                    'client_id'=> $client_id,
                                    'leadpop_id'=>  $trialDefaults[$zz]["leadpop_id"],
                                    'leadpop_type_id'=>  $trialDefaults[$zz]["leadpop_type_id"],
                                    'leadpop_vertical_id'=>   $trialDefaults[$zz]["leadpop_vertical_id"],
                                    'leadpop_vertical_sub_id'=> $trialDefaults[$zz]["leadpop_vertical_sub_id"],
                                    'leadpop_template_id' => $trialDefaults[$zz]['leadpop_template_id'],
                                    'leadpop_version_id'=> $trialDefaults[$zz]["leadpop_version_id"],
                                    'leadpop_version_seq'=>   $trialDefaults[$zz]["leadpop_version_seq"],
                                    'titletag'=>  addslashes($title_tag),
                                    'description'=> '',
                                    'metatags'=>  '',
                                    'titletag_active'=> 'y',
                                    'description_active'=> 'n',
                                    'metatags_active' => 'n'
                                );
                                $this->insert('seo_options' ,$seo_options);
                                //$verticalName , $subverticalName removed because we are not using placeholder right now @mzac90
                                $submissionText = $this->getSubmissionText($trialDefaults[$zz]["leadpop_id"], $trialDefaults[$zz]["leadpop_vertical_id"], $trialDefaults[$zz]["leadpop_vertical_sub_id"]);
                                $submissionText = str_replace("##clientlogo##", $this->logosrc, $submissionText);
                                $submissionText = str_replace("##clientphonenumber##", $freeTrialBuilderAnswers['phonenumber'], $submissionText);

                                $submission_options  = array(
                                    'client_id'=> $client_id,
                                    'leadpop_id'=>  $trialDefaults[$zz]["leadpop_id"],
                                    'leadpop_type_id'=>  $trialDefaults[$zz]["leadpop_type_id"],
                                    'leadpop_vertical_id'=>   $trialDefaults[$zz]["leadpop_vertical_id"],
                                    'leadpop_vertical_sub_id'=> $trialDefaults[$zz]["leadpop_vertical_sub_id"],
                                    'leadpop_template_id' => $trialDefaults[$zz]['leadpop_template_id'],
                                    'leadpop_version_id'=> $trialDefaults[$zz]["leadpop_version_id"],
                                    'leadpop_version_seq'=>   $trialDefaults[$zz]["leadpop_version_seq"],
                                    'thankyou'=>  addslashes($submissionText),
                                    'information'=> '',
                                    'thirdparty'=>  '',
                                    'thankyou_active'=> 'y',
                                    'information_active'=> 'n',
                                    'thirdparty_active' => 'n'
                                );
                                $this->insert('submission_options' ,$submission_options);
                                $foundone = true;
                                break 2;
                            }
                        }
                        $subdomain = $subdomain . $this->getRandomCharacter();
                    }
                }
                else {

                    $clients_subdomains  = array(
                        'client_id'=> $client_id,
                        'subdomain_name'=> $subdomain,
                        'top_level_domain'=> $topdomain,
                        'leadpop_vertical_id'=>  $trialDefaults[$zz]["leadpop_vertical_id"],
                        'leadpop_vertical_sub_id'=> $trialDefaults[$zz]["leadpop_vertical_sub_id"],
                        'leadpop_type_id' => $trialDefaults[$zz]["leadpop_type_id"],
                        'leadpop_template_id'=> $trialDefaults[$zz]['leadpop_template_id'],
                        'leadpop_id'=>  $trialDefaults[$zz]["leadpop_id"],
                        'leadpop_version_id'=> $trialDefaults[$zz]["leadpop_version_id"],
                        'leadpop_version_seq' => $trialDefaults[$zz]["leadpop_version_seq"],
                    );

                    $this->insert('clients_funnels_domains' ,$clients_subdomains);

                    /* emma insert */
                    $s = "  select * from client_emma_group  ";
                    $s .= " where leadpop_vertical_id = " . $trialDefaults[$zz]["leadpop_vertical_id"];
                    $s .= " and leadpop_subvertical_id = " .  $trialDefaults[$zz]["leadpop_vertical_sub_id"];
                    $s .= " and client_id = " .$client_id . "";
                    $emmaExists =  $this->db->fetchRow($s);
                    if ($emmaExists) {
                        $client_emma_group  = array(
                            'client_id'=> $client_id,
                            'domain_name'=>   strtolower($subdomain . "." . $topdomain),
                            'member_account_id'=> $emmaExists["member_account_id"],
                            'member_group_id'=>   $emmaExists["member_group_id"],
                            'group_name'=> $emmaExists["group_name"],
                            'total_contacts' => '0',
                            'leadpop_vertical_id' => $trialDefaults[$zz]["leadpop_vertical_id"],
                            'leadpop_subvertical_id'=> $trialDefaults[$zz]["leadpop_vertical_sub_id"],
                            'active'=> 'y'
                        );
                        $this->insert('client_emma_group' ,$client_emma_group);
                    }
                    else{
                        //Taking basic information for emma from one of existing entry
                        $sql = "SELECT id, emma_default_group, account_name, master_account_ids FROM client_emma_cron WHERE ";
                        $sql .= " client_id= ".$client_id." and leadpop_vertical_id = ".$trialDefaults[$zz]["leadpop_vertical_id"]."
                                    and leadpop_subvertical_id = ".$trialDefaults[$zz]["leadpop_vertical_sub_id"]."";
                        $ex_emma_cron = $this->db->fetchRow( $sql );

                        if($ex_emma_cron) {
                            $EmmaAccountName = $ex_emma_cron['account_name'];
                            $master_account_ids = $ex_emma_cron['master_account_ids'];
                            $emma_default_group = $ex_emma_cron['emma_default_group'];

                            //Check the entry in client_emma_account table
                            $emma_account = "SELECT * FROM client_emma_account WHERE client_id= " . $client_id . "";
                            $emma_account_res = $this->db->fetchRow($emma_account);
                            if (empty($emma_account_res)) {
                                /* emma insert */
                                $client_emma_cron = array(
                                    'client_id'=> $client_id,
                                    'emma_default_group'=>  $emma_default_group,
                                    'account_type'=> $emma_account_type,
                                    'domain_name'=>   strtolower($subdomain . "." . $topdomain),
                                    'account_name'=> $EmmaAccountName,
                                    'master_account_ids' => addslashes($master_account_ids),
                                    'has_run'=> 'n',
                                    'leadpop_vertical_id'=>   $trialDefaults[$zz]["leadpop_vertical_id"],
                                    'leadpop_subvertical_id'=> $trialDefaults[$zz]["leadpop_vertical_sub_id"]
                                );
                                $this->insert('client_emma_cron' ,$client_emma_cron);
                            } else {
                                /*if already existing the entry then insert entry in the client_emma_group table*/
                                $client_emma_group  = array(
                                    'client_id'=> $client_id,
                                    'domain_name'=>  strtolower($subdomain . "." . $topdomain),
                                    'member_account_id'=> $emmaExists["member_account_id"],
                                    'member_group_id'=>   $emmaExists["member_group_id"],
                                    'group_name'=> $emmaExists["group_name"],
                                    'total_contacts' => '0',
                                    'leadpop_vertical_id' => $trialDefaults[$zz]["leadpop_vertical_id"],
                                    'leadpop_subvertical_id'=> $trialDefaults[$zz]["leadpop_vertical_sub_id"],
                                    'active'=> 'y'
                                );
                                $this->insert('client_emma_group' ,$client_emma_group);
                            }
                        }

                    }
                    /* emma insert */
                    //remove mobileclients code from @mzac90
                    $googleDomain = $subdomain . "." . $topdomain;
                    $this->insertPurchasedGoogle($client_id, $googleDomain);

                    if ($generatecolors == false && $useUploadedLogo == true) { // get mobile from old funnel
                        // set 	client_or_domain_logo_image to 'c'  to use upploaded logo
                        /* mobile domain and logo */
                        $s = "select * from bottom_links  where client_id = " . $client_id;
                        $s .= " and leadpop_id = " . $origleadpop_id;
                        $s .= " and leadpop_type_id = " . $origleadpop_type_id;
                        $s .= " and leadpop_vertical_id = " . $origvertical_id;
                        $s .= " and leadpop_vertical_sub_id = " . $origsubvertical_id;
                        $s .= " and leadpop_template_id = " . $origleadpop_template_id;
                        $s .= " and leadpop_version_id = " . $origleadpop_version_id;
                        $s .= " and leadpop_version_seq = " . $origleadpop_version_seq . " limit 1 ";
                        $oldbototm = $this->db->fetchRow($s);
                        $bottom_links  = array(
                            'client_id'=> $client_id,
                            'leadpop_id'=>  $trialDefaults[$zz]["leadpop_id"],
                            'leadpop_type_id'=>  $trialDefaults[$zz]["leadpop_type_id"],
                            'leadpop_vertical_id'=>   $trialDefaults[$zz]["leadpop_vertical_id"],
                            'leadpop_vertical_sub_id'=> $trialDefaults[$zz]["leadpop_vertical_sub_id"],
                            'leadpop_template_id' => $trialDefaults[$zz]['leadpop_template_id'],
                            'leadpop_version_id'=> $trialDefaults[$zz]["leadpop_version_id"],
                            'leadpop_version_seq'=>   $trialDefaults[$zz]["leadpop_version_seq"],
                            'privacy'=> '',
                            'terms'=> '',
                            'disclosures'=>  '',
                            'licensing'=> '',
                            'about'=>   '',
                            'contact'=> '',
                            'privacy_active' => 'n',
                            'terms_active'=> 'n',
                            'disclosures_active'=>  'n',
                            'licensing_active'=> 'n',
                            'about_active'=> 'n',
                            'contact_active'=>  'n',
                            'privacy_type'=> 'm',
                            'terms_type'=>   'm',
                            'disclosures_type'=> 'm',
                            'licensing_type' => 'm',
                            'about_type'=> 'm',
                            'contact_type'=>   'm',
                            'privacy_url'=> '',
                            'terms_url'=> '',
                            'disclosures_url'=>  '',
                            'licensing_url'=> '',
                            'about_url'=>   '',
                            'contact_url'=> '',
                            'privacy_text' => '',
                            'terms_text'=> '',
                            'disclosures_text'=> '',
                            'licensing_text'=> '',
                            'about_text'=> '',
                            'contact_text'=>  '',
                            'compliance_text'=> $oldbototm["compliance_text"],
                            'compliance_is_linked'=>  $oldbototm["compliance_is_linked"],
                            'compliance_link'=>$oldbototm["compliance_link"],
                            'compliance_active' => $oldbototm["compliance_active"],
                            'license_number_active'=> $oldbototm["license_number_active"],
                            'license_number_is_linked'=> $oldbototm["license_number_is_linked"],
                            'license_number_text'=> $oldbototm["license_number_text"],
                            'license_number_link'=> $oldbototm["license_number_link"]
                        );
                        $this->insert('bottom_links' ,$bottom_links);
                    }
                    else {
                        if (($vertical == "mortgage" || $vertical == "realestate")) {
                            $bottom_links  = array(
                                'client_id'=> $client_id,
                                'leadpop_id'=>  $trialDefaults[$zz]["leadpop_id"],
                                'leadpop_type_id'=>  $trialDefaults[$zz]["leadpop_type_id"],
                                'leadpop_vertical_id'=>   $trialDefaults[$zz]["leadpop_vertical_id"],
                                'leadpop_vertical_sub_id'=> $trialDefaults[$zz]["leadpop_vertical_sub_id"],
                                'leadpop_template_id' => $trialDefaults[$zz]['leadpop_template_id'],
                                'leadpop_version_id'=> $trialDefaults[$zz]["leadpop_version_id"],
                                'leadpop_version_seq'=>   $trialDefaults[$zz]["leadpop_version_seq"],
                                'privacy'=> '',
                                'terms'=> '',
                                'disclosures'=>  '',
                                'licensing'=> '',
                                'about'=>   '',
                                'contact'=> '',
                                'privacy_active' => 'n',
                                'terms_active'=> 'n',
                                'disclosures_active'=>  'n',
                                'licensing_active'=> 'n',
                                'about_active'=> 'n',
                                'contact_active'=>  'n',
                                'privacy_type'=> 'm',
                                'terms_type'=>   'm',
                                'disclosures_type'=> 'm',
                                'licensing_type' => 'm',
                                'about_type'=> 'm',
                                'contact_type'=>   'm',
                                'privacy_url'=> '',
                                'terms_url'=> '',
                                'disclosures_url'=>  '',
                                'licensing_url'=> '',
                                'about_url'=>   '',
                                'contact_url'=> '',
                                'privacy_text' => '',
                                'terms_text'=> '',
                                'disclosures_text'=> '',
                                'licensing_text'=> '',
                                'about_text'=> '',
                                'contact_text'=>  '',
                                'compliance_text'=> 'NMLS Consumer Look Up',
                                'compliance_is_linked'=>  'y',
                                'compliance_link'=> 'http://www.nmlsconsumeraccess.org',
                                'compliance_active' => 'y',
                                'license_number_active'=> 'y',
                                'license_number_is_linked'=> 'n',
                                'license_number_text'=> '',
                                'license_number_link'=> ''
                            );
                            $this->insert('bottom_links' ,$bottom_links);
                        } else if ($vertical == "insurance") {
                            $bottom_links  = array(
                                'client_id'=> $client_id,
                                'leadpop_id'=>  $trialDefaults[$zz]["leadpop_id"],
                                'leadpop_type_id'=>  $trialDefaults[$zz]["leadpop_type_id"],
                                'leadpop_vertical_id'=>   $trialDefaults[$zz]["leadpop_vertical_id"],
                                'leadpop_vertical_sub_id'=> $trialDefaults[$zz]["leadpop_vertical_sub_id"],
                                'leadpop_template_id' => $trialDefaults[$zz]['leadpop_template_id'],
                                'leadpop_version_id'=> $trialDefaults[$zz]["leadpop_version_id"],
                                'leadpop_version_seq'=>   $trialDefaults[$zz]["leadpop_version_seq"],
                                'privacy'=> '',
                                'terms'=> '',
                                'disclosures'=>  '',
                                'licensing'=> '',
                                'about'=>   '',
                                'contact'=> '',
                                'privacy_active' => 'n',
                                'terms_active'=> 'n',
                                'disclosures_active'=>  'n',
                                'licensing_active'=> 'n',
                                'about_active'=> 'n',
                                'contact_active'=>  'n',
                                'privacy_type'=> 'm',
                                'terms_type'=>   'm',
                                'disclosures_type'=> 'm',
                                'licensing_type' => 'm',
                                'about_type'=> 'm',
                                'contact_type'=>   'm',
                                'privacy_url'=> '',
                                'terms_url'=> '',
                                'disclosures_url'=>  '',
                                'licensing_url'=> '',
                                'about_url'=>   '',
                                'contact_url'=> '',
                                'privacy_text' => '',
                                'terms_text'=> '',
                                'disclosures_text'=> '',
                                'licensing_text'=> '',
                                'about_text'=> '',
                                'contact_text'=>  '',
                                'compliance_text'=> 'NMLS Consumer Look Up',
                                'compliance_is_linked'=>  'y',
                                'compliance_link'=> 'http://www.nmlsconsumeraccess.org',
                                'compliance_active' => 'y',
                                'license_number_active'=> 'y',
                                'license_number_is_linked'=> 'n',
                                'license_number_text'=> '',
                                'license_number_link'=> ''
                            );
                            $this->insert('bottom_links' ,$bottom_links);
                        } else {
                            $bottom_links  = array(
                                'client_id'=> $client_id,
                                'leadpop_id'=>  $trialDefaults[$zz]["leadpop_id"],
                                'leadpop_type_id'=>  $trialDefaults[$zz]["leadpop_type_id"],
                                'leadpop_vertical_id'=>   $trialDefaults[$zz]["leadpop_vertical_id"],
                                'leadpop_vertical_sub_id'=> $trialDefaults[$zz]["leadpop_vertical_sub_id"],
                                'leadpop_template_id' => $trialDefaults[$zz]['leadpop_template_id'],
                                'leadpop_version_id'=> $trialDefaults[$zz]["leadpop_version_id"],
                                'leadpop_version_seq'=>   $trialDefaults[$zz]["leadpop_version_seq"],
                                'privacy'=> '',
                                'terms'=> '',
                                'disclosures'=>  '',
                                'licensing'=> '',
                                'about'=>   '',
                                'contact'=> '',
                                'privacy_active' => 'n',
                                'terms_active'=> 'n',
                                'disclosures_active'=>  'n',
                                'licensing_active'=> 'n',
                                'about_active'=> 'n',
                                'contact_active'=>  'n',
                                'privacy_type'=> 'm',
                                'terms_type'=>   'm',
                                'disclosures_type'=> 'm',
                                'licensing_type' => 'm',
                                'about_type'=> 'm',
                                'contact_type'=>   'm',
                                'privacy_url'=> '',
                                'terms_url'=> '',
                                'disclosures_url'=>  '',
                                'licensing_url'=> '',
                                'about_url'=>   '',
                                'contact_url'=> '',
                                'privacy_text' => '',
                                'terms_text'=> '',
                                'disclosures_text'=> '',
                                'licensing_text'=> '',
                                'about_text'=> '',
                                'contact_text'=>  '',
                                'compliance_text'=> '',
                                'compliance_is_linked'=>  '',
                                'compliance_link'=> '',
                                'compliance_active' => '',
                                'license_number_active'=> '',
                                'license_number_is_linked'=> '',
                                'license_number_text'=> '',
                                'license_number_link'=> ''
                            );
                            $this->insert('bottom_links' ,$bottom_links);
                        }
                    }

                    $x1 = '<p style="text-align: center;">';
                    $x1 .= '     <span style="font-family:arial,helvetica,sans-serif;">';
                    $x1 .= '     <span style="font-size: 22px;">';
                    $x1 .= '     <span style="color: rgb(51, 102, 255);">Thank You For Your Submission!</span><br />';
                    $x1 .= '     <span style="color: rgb(51, 51, 51);">';
                    $x1 .= '     <span style="font-size: 14px;">We have received your inquiry. An expert will follow up with you shortly.';
                    $x1 .= '     </span>';
                    $x1 .= '     </span>';
                    $x1 .= '     </span>';
                    $x1 .= '     </span>        ';
                    $x1 .= '   </p>   ';

                    $contact_options  = array(
                        'client_id'=> $client_id,
                        'leadpop_id'=>  $trialDefaults[$zz]["leadpop_id"],
                        'leadpop_type_id'=>  $trialDefaults[$zz]["leadpop_type_id"],
                        'leadpop_vertical_id'=>   $trialDefaults[$zz]["leadpop_vertical_id"],
                        'leadpop_vertical_sub_id'=> $trialDefaults[$zz]["leadpop_vertical_sub_id"],
                        'leadpop_template_id' => $trialDefaults[$zz]['leadpop_template_id'],
                        'leadpop_version_id'=> $trialDefaults[$zz]["leadpop_version_id"],
                        'leadpop_version_seq'=>   $trialDefaults[$zz]["leadpop_version_seq"],
                        'companyname'=> addslashes($client ['company_name']),
                        'phonenumber'=> 'Call Today! ' . $client ['phone_number'],
                        'email'=>  $client ['contact_email'],
                        'companyname_active'=> 'n',
                        'phonenumber_active'=>   'y',
                        'email_active'=> 'n'
                    );
                    $this->insert('contact_options' ,$contact_options);

                    //add review bar
                    $trustpilot_reviewbar  = array(
                        'client_id'=> $client_id,
                        'leadpop_id'=>  $trialDefaults[$zz]["leadpop_id"],
                        'leadpop_type_id'=>  $trialDefaults[$zz]["leadpop_type_id"],
                        'leadpop_vertical_id'=>   $trialDefaults[$zz]["leadpop_vertical_id"],
                        'leadpop_vertical_sub_id'=> $trialDefaults[$zz]["leadpop_vertical_sub_id"],
                        'leadpop_template_id' => $trialDefaults[$zz]['leadpop_template_id'],
                        'leadpop_version_id'=> $trialDefaults[$zz]["leadpop_version_id"],
                        'leadpop_version_seq'=>   $trialDefaults[$zz]["leadpop_version_seq"],
                        'bar_active'=> 'n',
                        'bar_text'=> 'What Our Customers Say:',
                        'bar_score'=>  '',
                        'bar_reviews'=> ''
                    );
                    $this->insert('trustpilot_reviewbar' ,$trustpilot_reviewbar);


                    $autotext = $this->getAutoResponderText($trialDefaults[$zz]["leadpop_vertical_id"], $trialDefaults[$zz]["leadpop_vertical_sub_id"], $trialDefaults[$zz]["leadpop_id"]);
                    if ($autotext == "not found") {
                        $thehtml = "";
                        $thesubject = "";
                    } else {
                        $thehtml = $autotext[0]["html"];
                        $thesubject = $autotext[0]["subject_line"];
                    }

                    $autoresponder_options  = array(
                        'client_id'=> $client_id,
                        'leadpop_id'=>  $trialDefaults[$zz]["leadpop_id"],
                        'leadpop_type_id'=>  $trialDefaults[$zz]["leadpop_type_id"],
                        'leadpop_vertical_id'=>   $trialDefaults[$zz]["leadpop_vertical_id"],
                        'leadpop_vertical_sub_id'=> $trialDefaults[$zz]["leadpop_vertical_sub_id"],
                        'leadpop_template_id' => $trialDefaults[$zz]['leadpop_template_id'],
                        'leadpop_version_id'=> $trialDefaults[$zz]["leadpop_version_id"],
                        'leadpop_version_seq'=>   $trialDefaults[$zz]["leadpop_version_seq"],
                        'html'=> addslashes($thehtml),
                        'thetext'=> '',
                        'html_active'=>  'y',
                        'text_active'=> 'n',
                        'subject_line'=>  addslashes($thesubject)
                    );
                    $this->insert('autoresponder_options' ,$autoresponder_options);

                    try {
                        $this->db->query($s);
                    } catch (PDOException $e) {
                        print ("Error!: " . $e->getMessage() . "<br/>");
                        print($s);
                        die();
                    }


                    $title_tag = " FREE " . $trialDefaults[$zz]["display_name"] . " | " . addslashes(ucwords($client ['company_name']));
                    //FREE Home Purchase Qualifier | Sentinel Mortgage Company
                    $seo_options  = array(
                        'client_id'=> $client_id,
                        'leadpop_id'=>  $trialDefaults[$zz]["leadpop_id"],
                        'leadpop_type_id'=>  $trialDefaults[$zz]["leadpop_type_id"],
                        'leadpop_vertical_id'=>   $trialDefaults[$zz]["leadpop_vertical_id"],
                        'leadpop_vertical_sub_id'=> $trialDefaults[$zz]["leadpop_vertical_sub_id"],
                        'leadpop_template_id' => $trialDefaults[$zz]['leadpop_template_id'],
                        'leadpop_version_id'=> $trialDefaults[$zz]["leadpop_version_id"],
                        'leadpop_version_seq'=>   $trialDefaults[$zz]["leadpop_version_seq"],
                        'titletag'=>  addslashes($title_tag),
                        'description'=> '',
                        'metatags'=>  '',
                        'titletag_active'=> 'y',
                        'description_active'=> 'n',
                        'metatags_active' => 'n'
                    );
                    $this->insert('seo_options' ,$seo_options);
                    $submissionText = $this->getSubmissionText($trialDefaults[$zz]["leadpop_id"], $trialDefaults[$zz]["leadpop_vertical_id"], $trialDefaults[$zz]["leadpop_vertical_sub_id"]);
                    $submissionText = str_replace("##clientlogo##", $this->logosrc, $submissionText);
                    $submissionText = str_replace("##clientphonenumber##", $freeTrialBuilderAnswers['phonenumber'], $submissionText);
                    $submission_options  = array(
                        'client_id'=> $client_id,
                        'leadpop_id'=>  $trialDefaults[$zz]["leadpop_id"],
                        'leadpop_type_id'=>  $trialDefaults[$zz]["leadpop_type_id"],
                        'leadpop_vertical_id'=>   $trialDefaults[$zz]["leadpop_vertical_id"],
                        'leadpop_vertical_sub_id'=> $trialDefaults[$zz]["leadpop_vertical_sub_id"],
                        'leadpop_template_id' => $trialDefaults[$zz]['leadpop_template_id'],
                        'leadpop_version_id'=> $trialDefaults[$zz]["leadpop_version_id"],
                        'leadpop_version_seq'=>   $trialDefaults[$zz]["leadpop_version_seq"],
                        'thankyou'=>  addslashes($submissionText),
                        'information'=> '',
                        'thirdparty'=>  '',
                        'thankyou_active'=> 'y',
                        'information_active'=> 'n',
                        'thirdparty_active' => 'n'
                    );
                    $this->insert('submission_options' ,$submission_options);
                }
            }
            $this->addPlaceholder($trialDefaults[$zz], $this->logosrc, $this->imgsrc, $client);
            /*
                        * old leadpops_templates_placeholders_info functionality remove from @mzac90
                        */

         //end ********************************************
        }
        print("addNonEnterpriseVerticalToExistingClient added " . $client_id);
    }
    /* end  non enterprise vertical to existing client function */

    /**
     * Add single funnel to a for a specific version
     * - Insert Logo
     * - Insert Default Auto Responders
     * - Add Folder
     * - Insert JSON to clients_leadpops
     * - Assign tags to funnels
     * - Insert into clients_leadpops_content
     * - Insert Multiple Step
     * - Insert clients_subdomains
     * - insert Purchased Google Analytics
     * - bottom_links
     * - contact_options
     * - trustpilot_reviewbar
     * - autoresponder_options
     * - seo_options
     * - submission_options
     */
    function addNonEnterpriseVerticalSubverticalVersionToExistingClient($xpvertical_id , $subvertical_id,$version_id,$client_id,$logo="",$mobilelogo="",
        $origvertical_id="",$origsubvertical_id="",$origversion_id="",$origleadpop_type_id="", $origleadpop_template_id="",
        $origleadpop_id="",$origleadpop_version_id="",$origleadpop_version_seq="")
    {

        $section = substr($client_id,0,1);

        if ($xpvertical_id == "1") {
            $vertical = "insurance";
        }
        else if ($xpvertical_id == "3") {
            $vertical = "mortgage";
        }
        else if ($xpvertical_id == "5") {
            $vertical = "realestate";
        }
        else if ($xpvertical_id == "2") {
            $vertical = "financial";
        }
        else if ($xpvertical_id == "8") {
            $vertical = "home improvement";
        }


        $s = "select * from clients where client_id = " . $client_id;
        $client = $this->db->fetchRow($s);
        if(empty($client)){
            die("Client id is invalid");
        }


        $client ['company_name'] = ucfirst(strtolower($client ['company_name']));
        $generatecolors = false;
        if ($logo == "" && $mobilelogo == "") { // inother words use defaults for logo and mobile logo
            $useUploadedLogo = false;
            $default_background_changed = "n";
        }
        else if ($logo != "" && $mobilelogo != "" && $origleadpop_type_id != "" && $origleadpop_template_id != "" && $origleadpop_id != "" && $origleadpop_version_id !="" && $origleadpop_version_seq !="") {
            $default_background_changed = "y";
            $generatecolors = false;  // in other words use existing logo and mobile logo and copy them to new funnel as if no upload was done
            $useUploadedLogo = true;
        }
        else if ($logo != "" && $mobilelogo == "" && $origleadpop_type_id == "" && $origleadpop_template_id == "" && $origleadpop_id == "" && $origleadpop_version_id =="" && $origleadpop_version_seq =="") {
            $default_background_changed = "y";
            $generatecolors = true;  // in other words act as if a new logo was uploaded & generate mobile logo
            $useUploadedLogo = true;
        }

        $s = "select * from trial_launch_defaults where leadpop_vertical_id = " . $xpvertical_id . " and leadpop_vertical_sub_id = " . $subvertical_id . " and leadpop_version_id = " . $version_id . " limit 1 ";
        $trialDefaults = $this->db->fetchRow($s);

        if ($generatecolors == false && $useUploadedLogo == false) { // not uploaded logo or have previous funnel to use
            $s = "select * from default_swatches where active = 'y' order by id ";
            $finalTrialColors = $this->db->fetchAll($s);
            $background_css = "linear-gradient(to bottom, rgba(108, 124, 156, 0.99) 0%, rgba(108, 124, 156, 0.99) 100%)";

            //remove logo_name_mobile copy cmd from @mzac90
            $this->logosrc = $this->getRackspaceUrl ('image_path', 'default-assets') . 'images/mortgage/multidebtconsolidation_logos/'.$trialDefaults["logo_name"];
            $this->insertDefaultClientUploadLogo( $trialDefaults["logo_name"], $trialDefaults, $client_id);
            $this->imgsrc = $this->insertClientDefaultImage($trialDefaults, $client_id);
        }
        else if ($generatecolors == false && $useUploadedLogo == true) { // get colors from leadpops_background_swatches

            $s = "select * from leadpop_background_swatches ";
            $s .= " where  client_id = " . $client_id;
            $s .= " and leadpop_vertical_id = " . $origvertical_id;
            $s .= " and leadpop_vertical_sub_id =  " . $origsubvertical_id;
            $s .= " and leadpop_type_id  = " . $origleadpop_type_id;
            $s .= " and leadpop_template_id = " . $origleadpop_template_id;
            $s .= " and  leadpop_id = " . $origleadpop_id;
            $s .= " and leadpop_version_id = " . $origleadpop_version_id;
            $s .= " and leadpop_version_seq = " . $origleadpop_version_seq;
            $finalTrialColors = $this->db->fetchAll($s);

            for($t = 0; $t < count($finalTrialColors); $t++) {
                $leadpop_background_swatches  = array(
                    'client_id'=> $client_id,
                    'leadpop_vertical_id'=>$trialDefaults["leadpop_vertical_id"],
                    'leadpop_vertical_sub_id'=>$trialDefaults["leadpop_vertical_sub_id"],
                    'leadpop_type_id'=>$this->leadpoptype,
                    'leadpop_template_id'=>$trialDefaults['leadpop_template_id'],
                    'leadpop_id' => $trialDefaults["leadpop_id"],
                    'leadpop_version_id'=> $trialDefaults["leadpop_version_id"],
                    'leadpop_version_seq'=>  $trialDefaults["leadpop_version_seq"],
                    'swatch'=>$finalTrialColors[$t]["swatch"],
                    'is_primary'=>$finalTrialColors[$t]["is_primary"],
                    'active' => 'y'
                );
                $this->insert('leadpop_background_swatches' ,$leadpop_background_swatches);
            }

            $s = "select background_color from leadpop_background_color ";
            $s .= " where  client_id = " . $client_id;
            $s .= " and leadpop_version_id = " . $origleadpop_version_id;
            $s .= " and leadpop_version_seq = " . $origleadpop_version_seq . " limit 1 ";
            $background_css = $this->db->fetchOne($s);

            $leadpop_background_color  = array(
                'client_id'=> $client_id,
                'leadpop_vertical_id'=>$trialDefaults["leadpop_vertical_id"],
                'leadpop_vertical_sub_id'=>$trialDefaults["leadpop_vertical_sub_id"],
                'leadpop_type_id'=>$this->leadpoptype,
                'leadpop_template_id'=>$trialDefaults['leadpop_template_id'],
                'leadpop_id' => $trialDefaults["leadpop_id"],
                'leadpop_version_id'=> $trialDefaults["leadpop_version_id"],
                'leadpop_version_seq'=>  $trialDefaults["leadpop_version_seq"],
                'background_color'=>addslashes($background_css),
                'active' => 'y',
                'default_changed' => $default_background_changed
            );
            $this->insert('leadpop_background_color' ,$leadpop_background_color);


            $s = "select logo_color  from leadpop_logos ";
            $s .= " where  client_id = " . $client_id;
            $s .= " and leadpop_vertical_id = " . $origvertical_id;
            $s .= " and leadpop_vertical_sub_id  = " . $origsubvertical_id;
            $s .= " and leadpop_type_id  = " . $origleadpop_type_id;
            $s .= " and leadpop_template_id = " . $origleadpop_template_id;
            $s .= " and  leadpop_id = " . $origleadpop_id;
            $s .= " and leadpop_version_id = " . $origleadpop_version_id;
            $s .= " and leadpop_version_seq = " . $origleadpop_version_seq . " limit 1 ";
            $colors = $this->db->fetchRow($s);

            // copy logo to new logo name
            $this->newlogoname = strtolower($client_id . "_" . $trialDefaults["leadpop_id"] . "_" . $trialDefaults["leadpop_type_id"] . "_" . $trialDefaults["leadpop_vertical_id"] . "_" . $trialDefaults["leadpop_vertical_sub_id"] . "_" . $trialDefaults["leadpop_template_id"] . "_" . $trialDefaults["leadpop_version_id"] . "_" . $trialDefaults["leadpop_version_seq"] . "_" . $logo);
            $logo_url = $this->getRackspaceUrl ('image_path','clients-assets').$section . '/' . $client_id . '/logos/' . $logo;
            $this->file_list[] = array(
                'server_file' => $logo_url,
                'container' => 'clients',
                'rackspace_path' => 'images1/'.$section . '/' . $client_id . '/logos/' . $this->newlogoname
            );

            // copy mobile logo to new name remove code from @mzac90
            $oldfilename = strtolower($client_id."_".$origleadpop_id."_".$origleadpop_type_id."_".$origvertical_id."_".$origsubvertical_id."_".$origleadpop_template_id."_".$origleadpop_version_id."_".$origleadpop_version_seq);
            $newfilename = $client_id."_".$trialDefaults["leadpop_id"]."_1_".$trialDefaults["leadpop_vertical_id"]."_".$trialDefaults["leadpop_vertical_sub_id"]."_".$trialDefaults['leadpop_template_id']."_".$trialDefaults["leadpop_version_id"]."_".$trialDefaults["leadpop_version_seq"];

            $this->origfavicon_dst_src =  $this->getRackspaceUrl ('image_path','clients-assets').$section . '/' . $client_id . '/logos/' . $oldfilename . '_favicon-circle.png';
            $this->newfavicon_dst_src =   $newfilename . '_favicon-circle.png';

            $this->file_list[] = array(
                'server_file' => $this->origfavicon_dst_src,
                'container' => 'clients',
                'rackspace_path' => 'images1/'.$section . '/' . $client_id . '/logos/' . $this->newfavicon_dst_src
            );

            $this->file_list[] = array(
                'server_file' =>  $this->origcolored_dot_src,
                'container' => 'clients',
                'rackspace_path' => 'images1/'.$section . '/' . $client_id . '/logos/' . $this->newcolored_dot_src
            );

            $this->logosrc =  $this->newinsertClientUploadLogo($this->newlogoname, $trialDefaults, $client_id);
            $this->imgsrc = $this->insertClientNotDefaultImage($trialDefaults, $client_id, $origleadpop_id, $origleadpop_type_id, $origvertical_id, $origsubvertical_id, $origleadpop_template_id, $origleadpop_version_id, $origleadpop_version_seq);

            $this->globallogosrc =  $this->logosrc;
            $this->globalfavicon_dst =  $this->getRackspaceUrl ('image_path','clients-assets').$section . '/' . $client_id. '/logos/' .$this->newfavicon_dst_src;
            $this->globallogo_color = $colors["logo_color"];
            $this->globalcolored_dot = $this->getRackspaceUrl ('image_path','clients-assets').$section . '/' . $client_id. '/logos/' .$this->newcolored_dot_src;
            // set mobile logo varibale
        }
        else if ($generatecolors == true && $useUploadedLogo == true) { //
            // pass in logo name only
            $this->origlogo = $this->getRackspaceUrl ('image_path','clients-assets').$section . '/' . $client_id . '/logos/' . $logo;
            $this->newlogoname = strtolower($client_id . "_" . $trialDefaults["leadpop_id"] . "_" . $trialDefaults["leadpop_type_id"] . "_" . $trialDefaults["leadpop_vertical_id"] . "_" . $trialDefaults["leadpop_vertical_sub_id"] . "_" . $trialDefaults["leadpop_template_id"] . "_" . $trialDefaults["leadpop_version_id"] . "_" . $trialDefaults["leadpop_version_seq"] . "_" . $logo);
            $oldlogo =  $this->downloadRackspaceImage( $this->origlogo);

            $this->file_list[] = array(
                'server_file' => $this->origlogo,
                'container' => 'clients',
                'rackspace_path' => 'images1/'.$section . '/' . $client_id . '/logos/' . $this->newlogoname
            );


            $oclient = new Client();

            $gis       = getimagesize($oldlogo);
            $type = $gis[2];
            switch($type)
            {
                case "1":
                    //imagecreatefromgif removed for mobile logo from @mzac90
                    $image = $oclient->loadGif($oldlogo);
                    $this->logo_color = $image->extract();
                    break;
                case "2":
                    //imagecreatefromjpeg removed for mobile logo from @mzac90
                    $image = $oclient->loadJpeg($oldlogo);
                    $this->logo_color = $image->extract();
                    break;
                case "3":
                    //imagecreatefrompng removed for mobile logo from @mzac90
                    $image = $oclient->loadPng($oldlogo);
                    $this->logo_color = $image->extract();
                    break;
                default:
                    //imagecreatefromjpeg removed for mobile logo from @mzac90
            }

            if(is_array($this->logo_color)){
                $this->logo_color = $this->logo_color[0];
            }

            $imagetype = image_type_to_mime_type($type);
            if($imagetype != 'image/jpeg' && $imagetype != 'image/png' &&  $imagetype != 'image/gif' ) {
                return 'bad' ;
            }
            $leadpop_logos = array(
                'client_id'=> $client_id,
                'leadpop_id'=> $trialDefaults["leadpop_id"],
                'leadpop_type_id'=> $trialDefaults["leadpop_type_id"],
                'leadpop_vertical_id'=> $trialDefaults["leadpop_vertical_id"],
                'leadpop_vertical_sub_id'=>  $trialDefaults["leadpop_vertical_sub_id"],
                'leadpop_template_id' => $trialDefaults["leadpop_template_id"],
                'leadpop_version_id'=> $trialDefaults["leadpop_version_id"],
                'leadpop_version_seq'=>  $trialDefaults["leadpop_version_seq"],
                'use_default'=> 'n',
                'logo_src' => $this->newlogoname,
                'use_me' => 'y',
                'numpics' => 1,
                'logo_color' => $this->logo_color,
                'ini_logo_color'  => $this->logo_color
            );
            $this->insert('leadpop_logos' ,$leadpop_logos);


            $this->logosrc =  $this->getRackspaceUrl ('image_path','clients-assets').$section . '/' . $client_id . '/logos/' . $this->newlogoname;

            $this->image_location = $this->getRackspaceUrl ('image_path','default-assets')."images/dot-img.png";
            $this->favicon_location =  $this->getRackspaceUrl ('image_path','default-assets')."images/favicon-circle.png";
            $this->favicon_dst_src =  public_path().'/'.env('RACKSPACE_TMP_DIR', '').'/'. $this->newlogoname . '_favicon-circle.png';
            $this->colored_dot_src =  public_path().'/'.env('RACKSPACE_TMP_DIR', '').'/' . $this->newlogoname . '_dot_img.png';

            if (isset($this->logo_color) && $this->logo_color != "") {
                $new_clr = $this->hex2rgb($this->logo_color);
            }

            $myRed = $new_clr[0];
            $myGreen = $new_clr[1];
            $myBlue = $new_clr[2];

            $this->colorizeBasedOnAplhaChannnel($this->image_location, $myRed, $myGreen, $myBlue, $this->colored_dot_src);
            $this->colorizeBasedOnAplhaChannnel($this->favicon_location, $myRed, $myGreen, $myBlue, $this->favicon_dst_src);

            $this->colored_dot = $this->getRackspaceUrl ('image_path','clients-assets').$section . '/' . $client_id . '/logos/' . $this->newlogoname . '_dot_img.png';
            $this->favicon_dst = $this->getRackspaceUrl ('image_path','clients-assets').$section . '/' . $client_id . '/logos/' . $this->newlogoname . '_favicon-circle.png';

            $this->file_list[] = array(
                'server_file' =>   LP_BASE_URL.'/'.env('RACKSPACE_TMP_DIR', '').'/'.$this->newlogoname . '_dot_img.png',
                'container' => 'clients',
                'rackspace_path' => 'images1/'.$section . '/' . $client_id . '/logos/' . $this->newlogoname . '_dot_img.png'
            );

            $this->file_list[] = array(
                'server_file' => LP_BASE_URL.'/'.env('RACKSPACE_TMP_DIR', '').'/'. $this->newlogoname . '_favicon-circle.png',
                'container' => 'clients',
                'rackspace_path' => 'images1/'.$section . '/' . $client_id . '/logos/' .  $this->newlogoname . '_favicon-circle.png'
            );

            $swatches =   "213-230-229#23-177-163#159-182-183#65-88-96#110-158-159#132-212-204" ;

            $result = explode("#",$swatches);
            $new_color = $this->hex2rgb($this->logo_color);
            $index = 0;
            array_unshift($result, implode('-', $new_color));

            // SET BACKGROUND COLOR
            $background_from_logo = '/*###>*/background-color: rgba('.$new_color[0].', '.$new_color[1].', '.$new_color[2].', 1);/*@@@*/
			background-image: linear-gradient(to right bottom,rgba('.$new_color[0].', '.$new_color[1].', '.$new_color[2].', 1) 0%,rgba('.$new_color[0].', '.$new_color[1].', '.$new_color[2].', 1) 100%); /* W3C */';
            $leadpop_background_color  = array(
                'client_id'=> $client_id,
                'leadpop_vertical_id' => $trialDefaults["leadpop_vertical_id"],
                'leadpop_vertical_sub_id' => $trialDefaults["leadpop_vertical_sub_id"],
                'leadpop_type_id' => $trialDefaults["leadpop_type_id"],
                'leadpop_template_id'=>$trialDefaults['leadpop_template_id'],
                'leadpop_id' => $trialDefaults["leadpop_id"],
                'leadpop_version_id' => $trialDefaults["leadpop_version_id"],
                'leadpop_version_seq' =>  $trialDefaults["leadpop_version_seq"],
                'background_color' =>addslashes($background_from_logo),
                'active' => 'y',
                'default_changed' => 'y'
            );
            $this->insert('leadpop_background_color' ,$leadpop_background_color);


            foreach($result as $key => $value) {

                list($red,$green,$blue) = explode("-",$value);

                if($key<1){
                    $str0 = "linear-gradient(to bottom, rgba(".$red.",".$green.",".$blue.",1.0) 0%,rgba(".$red.",".$green.",".$blue.",1.0) 100%)";
                }else{
                    $str0 = "linear-gradient(to bottom, rgba(".$red.",".$green.",".$blue.",1.0) 0%,rgba(".$red.",".$green.",".$blue.",.7) 100%)";
                }

                $str1 = "linear-gradient(to top, rgba(".$red.",".$green.",".$blue.",1.0) 0%,rgba(".$red.",".$green.",".$blue.",.7) 100%)";
                $str2 = "linear-gradient(to bottom right, rgba(".$red.",".$green.",".$blue.",1.0) 0%,rgba(".$red.",".$green.",".$blue.",.7) 100%)";
                $str3 = "linear-gradient(to bottom, rgba(".$red.",".$green.",".$blue.",1.0) 0%,rgba(".$red.",".$green.",".$blue.",1.0) 100%)";

                $swatches = array($str0,$str1,$str2,$str3);
                for($i=0;  $i<4; $i++) {
                    $index++;
                    $is_primary = 'n';
                    if($index==1){
                        $is_primary = 'y';
                    }

                    $leadpop_background_swatches  = array(
                        'client_id'=> $client_id,
                        'leadpop_vertical_id'=>$trialDefaults["leadpop_vertical_id"],
                        'leadpop_vertical_sub_id'=>$trialDefaults["leadpop_vertical_sub_id"],
                        'leadpop_type_id'=>$this->leadpoptype,
                        'leadpop_template_id'=>$trialDefaults['leadpop_template_id'],
                        'leadpop_id' => $trialDefaults["leadpop_id"],
                        'leadpop_version_id'=> $trialDefaults["leadpop_version_id"],
                        'leadpop_version_seq'=>  $trialDefaults["leadpop_version_seq"],
                        'swatch'=> addslashes($swatches[$i]),
                        'is_primary'=> $is_primary,
                        'active' => 'y'
                    );
                    $this->insert('leadpop_background_swatches' ,$leadpop_background_swatches);
                }
            }

            $s = "select background_color from leadpop_background_color ";
            $s .= " where  client_id = " . $client_id;
            $s .= " and leadpop_version_id = " . $trialDefaults["leadpop_version_id"];
            $s .= " and leadpop_version_seq = " . $trialDefaults["leadpop_version_seq"] . " limit 1 ";
            $background_css = $this->db->fetchOne($s);

            $s = "select * from leadpop_background_swatches ";
            $s .= " where  client_id = " . $client_id;
            $s .= " and leadpop_vertical_id = " . $trialDefaults["leadpop_vertical_id"];
            $s .= " and leadpop_vertical_sub_id = " . $trialDefaults["leadpop_vertical_sub_id"];
            $s .= " and leadpop_type_id  = " . $trialDefaults["leadpop_type_id"];
            $s .= " and leadpop_template_id = " . $trialDefaults["leadpop_template_id"];
            $s .= " and  leadpop_id = " . $trialDefaults["leadpop_id"];
            $s .= " and leadpop_version_id = " . $trialDefaults["leadpop_version_id"];
            $s .= " and leadpop_version_seq = " . $trialDefaults["leadpop_version_seq"] . " limit 1 ";
            $finalTrialColors = $this->db->fetchAll($s);

            //remove mobileclients code from @mzac90
            $this->logosrc = $this->newinsertClientUploadLogo($this->newlogoname,$trialDefaults,$client_id);
            $this->imgsrc = $this->insertClientDefaultImage($trialDefaults,$client_id);

            $this->globallogosrc =  $this->$this->logosrc;
            $this->globalfavicon_dst =  $this->getRackspaceUrl ('image_path','clients-assets').$section . '/' . $client_id. '/logos/' .$this->favicon_dst_src;
            $this->globallogo_color = $this->logo_color;
            $this->globalcolored_dot = $this->getRackspaceUrl ('image_path','clients-assets').$section . '/' . $client_id. '/logos/' .$this->colored_dot_src;
            // set mobile logo varibale
        }

        // craete this array so as not to have to chg code
        $freeTrialBuilderAnswers = array("emailaddress" => $client["contact_email"],"phonenumber" => $client["phone_number"]);

        $this->insertDefaultAutoResponders ($client_id, $trialDefaults, $client["contact_email"], $client["phone_number"]) ;

        //$template_info removed because we are not using placeholder right now @mzac90
        $s = "select * from leadpops_verticals where id = " . $trialDefaults["leadpop_vertical_id"];
        $vertres = $this->db->fetchRow($s);
        $verticalName = $vertres ['lead_pop_vertical'];
        /*
        * Add default vertical name in leadpops_folders table
        * */
        $folder_id  = $this->addFolder($verticalName,$client_id);

        $lead_line = '<span style="font-family: ' . $trialDefaults["main_message_font"] . '; font-size: ' . $trialDefaults["main_message_font_size"] . '; color: ' . ($this->globallogo_color == "" ? $trialDefaults["mainmessage_color"] : $this->globallogo_color) . '">' . $trialDefaults["main_message"] . '</span>';
        $second_line = '<span style="font-family: ' . $trialDefaults["description_font"] . '; font-size: ' . $trialDefaults["description_font_size"] . '; color: ' . $trialDefaults["description_color"] . '">' . $trialDefaults["description"] . '</span>';

        if($trialDefaults["conditional_logic"]==null || $trialDefaults["conditional_logic"]=="null"){
            $trialDefaults["conditional_logic"] = "{}";
        }

        $now = new DateTime();
        $clients_leadpops  = array(
            'client_id'=> $client_id,
            'question_sequence' =>  addslashes($trialDefaults["question_sequence"]),
            'funnel_questions' => addslashes($trialDefaults["funnel_questions"]),
            'conditional_logic' =>  $trialDefaults["conditional_logic"],
            'lead_line' =>  addslashes($lead_line),
            'second_line_more' =>  addslashes($second_line),
            'funnel_name' => $trialDefaults["funnel_name"],
            'leadpop_folder_id' => $folder_id,
            'leadpop_id'=>  $trialDefaults["leadpop_id"],
            'leadpop_version_id'=> $trialDefaults["leadpop_version_id"],
            'leadpop_active'=>  '1',
            'access_code'=> '',
            'leadpop_version_seq' =>  $trialDefaults["leadpop_version_seq"],
            'static_thankyou_active' => 'y',
            'static_thankyou_slug' => 'thank-you.html',
            'date_added'=> $now->format("Y-m-d H:i:s")
        );
        $client_leadpop_id = $this->insert('clients_leadpops' ,$clients_leadpops);

        $this->assignTagToFunnel($client_leadpop_id,$trialDefaults,$client_id);

        $clients_leadpops_content  = array(
            'client_id'=> $client_id,
            'leadpop_id'=>  $trialDefaults["leadpop_id"],
            'leadpop_version_id'=> $trialDefaults["leadpop_version_id"],
            'leadpop_active'=>  '1',
            'access_code'=> '',
            'leadpop_version_seq' => $trialDefaults["leadpop_version_seq"],
            'section1'=> '<h4>section one</h4>',
            'section2'=> '<h4>section two</h4>',
            'section3'=> '<h4>section three</h4>',
            'section4'=> '<h4>section four</h4>',
            'section5'=> '<h4>section five</h4>',
            'section6'=> '<h4>section six</h4>',
            'section7'=> '<h4>section seven</h4>',
            'section8'=> '<h4>section eight</h4>',
            'section9'=> '<h4>section nine</h4>',
            'section10'=> '<h4>section ten</h4>',
            'template'=> 1
        );
        $this->insert('clients_leadpops_content' ,$clients_leadpops_content);


        $this->checkIfNeedMultipleStepInsert ( $trialDefaults["leadpop_version_id"], $client_id );
        // look up domain name
        $s = "select * from clients where client_id = " . $client_id . " limit 1 ";
        $client = $this->db->fetchRow($s);
        $subdomain = $client ['company_name'];
        $subdomain = preg_replace ( '/[^a-zA-Z]/', '', $subdomain ). "-" .$this->generateRandomString(8);

        $s = "select domain from top_level_domains where primary_domain = 'y' limit 1 ";
        $topdomain = $this->db->fetchOne ( $s );
        if ($this->leadpoptype == $this->thissub_domain) {
            $s = "select  count(*) from clients_funnels_domains where  ";
            $s .= " subdomain_name = '" . $subdomain . "' ";
            $s .= " and top_level_domain = '" . $topdomain . "' ";
            $foundsubdomain = $this->db->fetchOne ( $s );
            if ($foundsubdomain > 0) {
                //die("ass");
                $s = "select domain from top_level_domains where primary_domain != 'y' ";
                $nonprimary = $this->db->fetchAll ( $s );
                $foundone = false;
                while ( $foundone == false ) {
                    for($k = 0; $k < count ( $nonprimary ); $k ++) {
                        $s = "select  count(*) from clients_funnels_domains where  ";
                        $s .= " subdomain_name = '" . $subdomain . "' ";
                        $s .= " and top_level_domain = '" . $nonprimary [$k] ['domain'] . "' ";
                        $foundsubdomain = $this->db->fetchOne ( $s );
                        if ($foundsubdomain == 0) {
                            $s = "insert into clients_funnels_domains (id,client_id,subdomain_name,top_level_domain,leadpop_vertical_id,";
                            $clients_subdomains  = array(
                                'client_id'=> $client_id,
                                'subdomain_name'=> $subdomain,
                                'top_level_domain'=> $nonprimary [$k] ['domain'],
                                'leadpop_vertical_id'=>  $trialDefaults["leadpop_vertical_id"],
                                'leadpop_vertical_sub_id'=> $trialDefaults["leadpop_vertical_sub_id"],
                                'leadpop_type_id' => $this->leadpoptype,
                                'leadpop_template_id'=> $trialDefaults['leadpop_template_id'],
                                'leadpop_id'=>  $trialDefaults["leadpop_id"],
                                'leadpop_version_id'=> $trialDefaults["leadpop_version_id"],
                                'leadpop_version_seq' => $trialDefaults["leadpop_version_seq"],
                            );

                            $this->insert('clients_funnels_domains' ,$clients_subdomains);

                            /* emma insert */
                            /* no emma for these folks
                            $s = "insert into client_emma_cron (id,client_id,emma_default_group,account_type,domain_name,account_name,master_account_ids,has_run, leadpop_vertical_id,leadpop_subvertical_id) values (null,";
                            $s .= $client_id . ",'". $trialDefaults[0]['emma_default_group'] ."','".$emma_account_type."','". strtolower($subdomain . "." . $nonprimary [$k] ['domain']) ."','". $emma_account_name ."','";
                            $s .= addslashes($emmaAccount) . "','n',".$trialDefaults[$i]["leadpop_vertical_id"].",".$trialDefaults[$i]["leadpop_vertical_sub_id"].")";
                            $this->db->query ($s);
                            */
                            /* emma insert */

                            //mobile logo generate functionality removed from @mzac90

                            $googleDomain = $subdomain . "." . $nonprimary [$k] ['domain'];
                            $this->insertPurchasedGoogle ( $client_id, $googleDomain );

                            if ($generatecolors == false && $useUploadedLogo == true) { // get mobile from old funnel
                                // set 	client_or_domain_logo_image to 'c'  to use upploaded logo
                                /* mobile domain and logo */
                                $s = "select * from bottom_links  where client_id = " . $client_id ;
                                $s .= " and leadpop_id = " . $origleadpop_id;
                                $s .= " and leadpop_type_id = " . $origleadpop_type_id;
                                $s .= " and leadpop_vertical_id = " . $origvertical_id;
                                $s .= " and leadpop_vertical_sub_id = " . $origsubvertical_id;
                                $s .=  " and leadpop_template_id = " . $origleadpop_template_id;
                                $s .= " and leadpop_version_id = " . $origleadpop_version_id;
                                $s .= " and leadpop_version_seq = " . $origleadpop_version_seq . " limit 1 ";
                                $oldbototm = $this->db->fetchRow($s);
                                $bottom_links  = array(
                                    'client_id'=> $client_id,
                                    'leadpop_id'=>  $trialDefaults["leadpop_id"],
                                    'leadpop_type_id'=>  $trialDefaults["leadpop_type_id"],
                                    'leadpop_vertical_id'=>   $trialDefaults["leadpop_vertical_id"],
                                    'leadpop_vertical_sub_id'=> $trialDefaults["leadpop_vertical_sub_id"],
                                    'leadpop_template_id' => $trialDefaults['leadpop_template_id'],
                                    'leadpop_version_id'=> $trialDefaults["leadpop_version_id"],
                                    'leadpop_version_seq'=>   $trialDefaults["leadpop_version_seq"],
                                    'privacy'=> '',
                                    'terms'=> '',
                                    'disclosures'=>  '',
                                    'licensing'=> '',
                                    'about'=>   '',
                                    'contact'=> '',
                                    'privacy_active' => 'n',
                                    'terms_active'=> 'n',
                                    'disclosures_active'=>  'n',
                                    'licensing_active'=> 'n',
                                    'about_active'=> 'n',
                                    'contact_active'=>  'n',
                                    'privacy_type'=> 'm',
                                    'terms_type'=>   'm',
                                    'disclosures_type'=> 'm',
                                    'licensing_type' => 'm',
                                    'about_type'=> 'm',
                                    'contact_type'=>   'm',
                                    'privacy_url'=> '',
                                    'terms_url'=> '',
                                    'disclosures_url'=>  '',
                                    'licensing_url'=> '',
                                    'about_url'=>   '',
                                    'contact_url'=> '',
                                    'privacy_text' => '',
                                    'terms_text'=> '',
                                    'disclosures_text'=> '',
                                    'licensing_text'=> '',
                                    'about_text'=> '',
                                    'contact_text'=>  '',
                                    'compliance_text'=> $oldbototm["compliance_text"],
                                    'compliance_is_linked'=>  $oldbototm["compliance_is_linked"],
                                    'compliance_link'=>$oldbototm["compliance_link"],
                                    'compliance_active' => $oldbototm["compliance_active"],
                                    'license_number_active'=> $oldbototm["license_number_active"],
                                    'license_number_is_linked'=> $oldbototm["license_number_is_linked"],
                                    'license_number_text'=> $oldbototm["license_number_text"],
                                    'license_number_link'=> $oldbototm["license_number_link"]
                                );
                                $this->insert('bottom_links' ,$bottom_links);
                            }
                            else {
                                if (($vertical == "mortgage" || $vertical == "realestate")) {
                                    $bottom_links  = array(
                                        'client_id'=> $client_id,
                                        'leadpop_id'=>  $trialDefaults["leadpop_id"],
                                        'leadpop_type_id'=>  $trialDefaults["leadpop_type_id"],
                                        'leadpop_vertical_id'=>   $trialDefaults["leadpop_vertical_id"],
                                        'leadpop_vertical_sub_id'=> $trialDefaults["leadpop_vertical_sub_id"],
                                        'leadpop_template_id' => $trialDefaults['leadpop_template_id'],
                                        'leadpop_version_id'=> $trialDefaults["leadpop_version_id"],
                                        'leadpop_version_seq'=>   $trialDefaults["leadpop_version_seq"],
                                        'privacy'=> '',
                                        'terms'=> '',
                                        'disclosures'=>  '',
                                        'licensing'=> '',
                                        'about'=>   '',
                                        'contact'=> '',
                                        'privacy_active' => 'n',
                                        'terms_active'=> 'n',
                                        'disclosures_active'=>  'n',
                                        'licensing_active'=> 'n',
                                        'about_active'=> 'n',
                                        'contact_active'=>  'n',
                                        'privacy_type'=> 'm',
                                        'terms_type'=>   'm',
                                        'disclosures_type'=> 'm',
                                        'licensing_type' => 'm',
                                        'about_type'=> 'm',
                                        'contact_type'=>   'm',
                                        'privacy_url'=> '',
                                        'terms_url'=> '',
                                        'disclosures_url'=>  '',
                                        'licensing_url'=> '',
                                        'about_url'=>   '',
                                        'contact_url'=> '',
                                        'privacy_text' => '',
                                        'terms_text'=> '',
                                        'disclosures_text'=> '',
                                        'licensing_text'=> '',
                                        'about_text'=> '',
                                        'contact_text'=>  '',
                                        'compliance_text'=> 'NMLS Consumer Look Up',
                                        'compliance_is_linked'=>  'y',
                                        'compliance_link'=> 'http://www.nmlsconsumeraccess.org',
                                        'compliance_active' => 'y',
                                        'license_number_active'=> 'y',
                                        'license_number_is_linked'=> 'n',
                                        'license_number_text'=> '',
                                        'license_number_link'=> ''
                                    );
                                    $this->insert('bottom_links' ,$bottom_links);
                                }
                                else if ($vertical == "insurance") {
                                    $bottom_links  = array(
                                        'client_id'=> $client_id,
                                        'leadpop_id'=>  $trialDefaults["leadpop_id"],
                                        'leadpop_type_id'=>  $trialDefaults["leadpop_type_id"],
                                        'leadpop_vertical_id'=>   $trialDefaults["leadpop_vertical_id"],
                                        'leadpop_vertical_sub_id'=> $trialDefaults["leadpop_vertical_sub_id"],
                                        'leadpop_template_id' => $trialDefaults['leadpop_template_id'],
                                        'leadpop_version_id'=> $trialDefaults["leadpop_version_id"],
                                        'leadpop_version_seq'=>   $trialDefaults["leadpop_version_seq"],
                                        'privacy'=> '',
                                        'terms'=> '',
                                        'disclosures'=>  '',
                                        'licensing'=> '',
                                        'about'=>   '',
                                        'contact'=> '',
                                        'privacy_active' => 'n',
                                        'terms_active'=> 'n',
                                        'disclosures_active'=>  'n',
                                        'licensing_active'=> 'n',
                                        'about_active'=> 'n',
                                        'contact_active'=>  'n',
                                        'privacy_type'=> 'm',
                                        'terms_type'=>   'm',
                                        'disclosures_type'=> 'm',
                                        'licensing_type' => 'm',
                                        'about_type'=> 'm',
                                        'contact_type'=>   'm',
                                        'privacy_url'=> '',
                                        'terms_url'=> '',
                                        'disclosures_url'=>  '',
                                        'licensing_url'=> '',
                                        'about_url'=>   '',
                                        'contact_url'=> '',
                                        'privacy_text' => '',
                                        'terms_text'=> '',
                                        'disclosures_text'=> '',
                                        'licensing_text'=> '',
                                        'about_text'=> '',
                                        'contact_text'=>  '',
                                        'compliance_text'=> 'NMLS Consumer Look Up',
                                        'compliance_is_linked'=>  'y',
                                        'compliance_link'=> 'http://www.nmlsconsumeraccess.org',
                                        'compliance_active' => 'y',
                                        'license_number_active'=> 'y',
                                        'license_number_is_linked'=> 'n',
                                        'license_number_text'=> '',
                                        'license_number_link'=> ''
                                    );
                                    $this->insert('bottom_links' ,$bottom_links);
                                }
                                else {
                                    $bottom_links  = array(
                                        'client_id'=> $client_id,
                                        'leadpop_id'=>  $trialDefaults["leadpop_id"],
                                        'leadpop_type_id'=>  $trialDefaults["leadpop_type_id"],
                                        'leadpop_vertical_id'=>   $trialDefaults["leadpop_vertical_id"],
                                        'leadpop_vertical_sub_id'=> $trialDefaults["leadpop_vertical_sub_id"],
                                        'leadpop_template_id' => $trialDefaults['leadpop_template_id'],
                                        'leadpop_version_id'=> $trialDefaults["leadpop_version_id"],
                                        'leadpop_version_seq'=>   $trialDefaults["leadpop_version_seq"],
                                        'privacy'=> '',
                                        'terms'=> '',
                                        'disclosures'=>  '',
                                        'licensing'=> '',
                                        'about'=>   '',
                                        'contact'=> '',
                                        'privacy_active' => 'n',
                                        'terms_active'=> 'n',
                                        'disclosures_active'=>  'n',
                                        'licensing_active'=> 'n',
                                        'about_active'=> 'n',
                                        'contact_active'=>  'n',
                                        'privacy_type'=> 'm',
                                        'terms_type'=>   'm',
                                        'disclosures_type'=> 'm',
                                        'licensing_type' => 'm',
                                        'about_type'=> 'm',
                                        'contact_type'=>   'm',
                                        'privacy_url'=> '',
                                        'terms_url'=> '',
                                        'disclosures_url'=>  '',
                                        'licensing_url'=> '',
                                        'about_url'=>   '',
                                        'contact_url'=> '',
                                        'privacy_text' => '',
                                        'terms_text'=> '',
                                        'disclosures_text'=> '',
                                        'licensing_text'=> '',
                                        'about_text'=> '',
                                        'contact_text'=>  '',
                                        'compliance_text'=> '',
                                        'compliance_is_linked'=>  '',
                                        'compliance_link'=> '',
                                        'compliance_active' => '',
                                        'license_number_active'=> '',
                                        'license_number_is_linked'=> '',
                                        'license_number_text'=> '',
                                        'license_number_link'=> ''
                                    );
                                    $this->insert('bottom_links' ,$bottom_links);
                                }
                            }

                            $x1 = '<p style="text-align: center;">';
                            $x1 .= '     <span style="font-family:arial,helvetica,sans-serif;">';
                            $x1 .= '     <span style="font-size: 22px;">';
                            $x1 .= '     <span style="color: rgb(51, 102, 255);">Thank You For Your Submission!</span><br />';
                            $x1 .= '     <span style="color: rgb(51, 51, 51);">';
                            $x1 .= '     <span style="font-size: 14px;">We have received your inquiry. An expert will follow up with you shortly.';
                            $x1 .= '     </span>';
                            $x1 .= '     </span>';
                            $x1 .= '     </span>';
                            $x1 .= '     </span>        ';
                            $x1 .= '   </p>   ';

                            $contact_options  = array(
                                'client_id'=> $client_id,
                                'leadpop_id'=>  $trialDefaults["leadpop_id"],
                                'leadpop_type_id'=>  $trialDefaults["leadpop_type_id"],
                                'leadpop_vertical_id'=>   $trialDefaults["leadpop_vertical_id"],
                                'leadpop_vertical_sub_id'=> $trialDefaults["leadpop_vertical_sub_id"],
                                'leadpop_template_id' => $trialDefaults['leadpop_template_id'],
                                'leadpop_version_id'=> $trialDefaults["leadpop_version_id"],
                                'leadpop_version_seq'=>   $trialDefaults["leadpop_version_seq"],
                                'companyname'=> addslashes($client ['company_name']),
                                'phonenumber'=> 'Call Today! ' . $client ['phone_number'],
                                'email'=>  $client ['contact_email'],
                                'companyname_active'=> 'n',
                                'phonenumber_active'=>   'y',
                                'email_active'=> 'n'
                            );
                            $this->insert('contact_options' ,$contact_options);


                            //add review bar
                            $trustpilot_reviewbar  = array(
                                'client_id'=> $client_id,
                                'leadpop_id'=>  $trialDefaults["leadpop_id"],
                                'leadpop_type_id'=>  $trialDefaults["leadpop_type_id"],
                                'leadpop_vertical_id'=>   $trialDefaults["leadpop_vertical_id"],
                                'leadpop_vertical_sub_id'=> $trialDefaults["leadpop_vertical_sub_id"],
                                'leadpop_template_id' => $trialDefaults['leadpop_template_id'],
                                'leadpop_version_id'=> $trialDefaults["leadpop_version_id"],
                                'leadpop_version_seq'=>   $trialDefaults["leadpop_version_seq"],
                                'bar_active'=> 'n',
                                'bar_text'=> 'What Our Customers Say:',
                                'bar_score'=>  '',
                                'bar_reviews'=> ''
                            );
                            $this->insert('trustpilot_reviewbar' ,$trustpilot_reviewbar);

                            $autotext = $this->getAutoResponderText ( $trialDefaults["leadpop_vertical_id"], $trialDefaults["leadpop_vertical_sub_id"] , $trialDefaults["leadpop_id"]);
                            if ($autotext == "not found") {
                                $thehtml =  "";
                                $thesubject = "";
                            }
                            else {
                                $thehtml =  $autotext[0]["html"];
                                $thesubject = $autotext[0]["subject_line"];
                            }
                            $autoresponder_options  = array(
                                'client_id'=> $client_id,
                                'leadpop_id'=>  $trialDefaults["leadpop_id"],
                                'leadpop_type_id'=>  $trialDefaults["leadpop_type_id"],
                                'leadpop_vertical_id'=>   $trialDefaults["leadpop_vertical_id"],
                                'leadpop_vertical_sub_id'=> $trialDefaults["leadpop_vertical_sub_id"],
                                'leadpop_template_id' => $trialDefaults['leadpop_template_id'],
                                'leadpop_version_id'=> $trialDefaults["leadpop_version_id"],
                                'leadpop_version_seq'=>   $trialDefaults["leadpop_version_seq"],
                                'html'=> addslashes($thehtml),
                                'thetext'=> '',
                                'html_active'=>  'y',
                                'text_active'=> 'n',
                                'subject_line'=>  addslashes($thesubject)
                            );
                            $this->insert('autoresponder_options' ,$autoresponder_options);

                            $title_tag =  " FREE " . $trialDefaults[0]["display_name"] . " | " . addslashes ( ucwords($client ['company_name']) );
                            //FREE Home Purchase Qualifier | Sentinel Mortgage Company
                            $seo_options  = array(
                                'client_id'=> $client_id,
                                'leadpop_id'=>  $trialDefaults["leadpop_id"],
                                'leadpop_type_id'=>  $trialDefaults["leadpop_type_id"],
                                'leadpop_vertical_id'=>   $trialDefaults["leadpop_vertical_id"],
                                'leadpop_vertical_sub_id'=> $trialDefaults["leadpop_vertical_sub_id"],
                                'leadpop_template_id' => $trialDefaults['leadpop_template_id'],
                                'leadpop_version_id'=> $trialDefaults["leadpop_version_id"],
                                'leadpop_version_seq'=>   $trialDefaults["leadpop_version_seq"],
                                'titletag'=>  addslashes($title_tag),
                                'description'=> '',
                                'metatags'=>  '',
                                'titletag_active'=> 'y',
                                'description_active'=> 'n',
                                'metatags_active' => 'n'
                            );
                            $this->insert('seo_options' ,$seo_options);

                                //$verticalName , $subverticalName removed because we are not using placeholder right now @mzac90

                            $submissionText = $this->getSubmissionText($trialDefaults["leadpop_id"],$trialDefaults["leadpop_vertical_id"],$trialDefaults["leadpop_vertical_sub_id"]);
                            $submissionText = str_replace("##clientlogo##",$this->logosrc,$submissionText);
                            $submissionText = str_replace("##clientphonenumber##",$freeTrialBuilderAnswers['phonenumber'],$submissionText);

                            $submission_options  = array(
                                'client_id'=> $client_id,
                                'leadpop_id'=>  $trialDefaults["leadpop_id"],
                                'leadpop_type_id'=>  $trialDefaults["leadpop_type_id"],
                                'leadpop_vertical_id'=>   $trialDefaults["leadpop_vertical_id"],
                                'leadpop_vertical_sub_id'=> $trialDefaults["leadpop_vertical_sub_id"],
                                'leadpop_template_id' => $trialDefaults['leadpop_template_id'],
                                'leadpop_version_id'=> $trialDefaults["leadpop_version_id"],
                                'leadpop_version_seq'=>   $trialDefaults["leadpop_version_seq"],
                                'thankyou'=>  addslashes($submissionText),
                                'information'=> '',
                                'thirdparty'=>  '',
                                'thankyou_active'=> 'y',
                                'information_active'=> 'n',
                                'thirdparty_active' => 'n'
                            );
                            $this->insert('submission_options' ,$submission_options);

                            $foundone = true;
                            break 2;
                        }
                    }
                    $subdomain = $subdomain . $this->getRandomCharacter ();
                }
            } else {
                $clients_subdomains  = array(
                    'client_id'=> $client_id,
                    'subdomain_name'=> $subdomain,
                    'top_level_domain'=> $topdomain,
                    'leadpop_vertical_id'=>  $trialDefaults["leadpop_vertical_id"],
                    'leadpop_vertical_sub_id'=> $trialDefaults["leadpop_vertical_sub_id"],
                    'leadpop_type_id' => $trialDefaults["leadpop_type_id"],
                    'leadpop_template_id'=> $trialDefaults['leadpop_template_id'],
                    'leadpop_id'=>  $trialDefaults["leadpop_id"],
                    'leadpop_version_id'=> $trialDefaults["leadpop_version_id"],
                    'leadpop_version_seq' => $trialDefaults["leadpop_version_seq"],
                );

                $this->insert('clients_funnels_domains' ,$clients_subdomains);
                //mobileclients  generate functionality removed from @mzac90

                $googleDomain = $subdomain . "." . $topdomain;
                $this->insertPurchasedGoogle ( $client_id, $googleDomain );

                if ($generatecolors == false && $useUploadedLogo == true) { // get mobile from old funnel
                    // set 	client_or_domain_logo_image to 'c'  to use upploaded logo
                    /* mobile domain and logo */
                    $s = "select * from bottom_links  where client_id = " . $client_id ;
                    $s .= " and leadpop_id = " . $origleadpop_id;
                    $s .= " and leadpop_type_id = " . $origleadpop_type_id;
                    $s .= " and leadpop_vertical_id = " . $origvertical_id;
                    $s .= " and leadpop_vertical_sub_id = " . $origsubvertical_id;
                    $s .=  " and leadpop_template_id = " . $origleadpop_template_id;
                    $s .= " and leadpop_version_id = " . $origleadpop_version_id;
                    $s .= " and leadpop_version_seq = " . $origleadpop_version_seq . " limit 1 ";
                    $oldbototm = $this->db->fetchRow($s);
                    $bottom_links  = array(
                        'client_id'=> $client_id,
                        'leadpop_id'=>  $trialDefaults["leadpop_id"],
                        'leadpop_type_id'=>  $trialDefaults["leadpop_type_id"],
                        'leadpop_vertical_id'=>   $trialDefaults["leadpop_vertical_id"],
                        'leadpop_vertical_sub_id'=> $trialDefaults["leadpop_vertical_sub_id"],
                        'leadpop_template_id' => $trialDefaults['leadpop_template_id'],
                        'leadpop_version_id'=> $trialDefaults["leadpop_version_id"],
                        'leadpop_version_seq'=>   $trialDefaults["leadpop_version_seq"],
                        'privacy'=> '',
                        'terms'=> '',
                        'disclosures'=>  '',
                        'licensing'=> '',
                        'about'=>   '',
                        'contact'=> '',
                        'privacy_active' => 'n',
                        'terms_active'=> 'n',
                        'disclosures_active'=>  'n',
                        'licensing_active'=> 'n',
                        'about_active'=> 'n',
                        'contact_active'=>  'n',
                        'privacy_type'=> 'm',
                        'terms_type'=>   'm',
                        'disclosures_type'=> 'm',
                        'licensing_type' => 'm',
                        'about_type'=> 'm',
                        'contact_type'=>   'm',
                        'privacy_url'=> '',
                        'terms_url'=> '',
                        'disclosures_url'=>  '',
                        'licensing_url'=> '',
                        'about_url'=>   '',
                        'contact_url'=> '',
                        'privacy_text' => '',
                        'terms_text'=> '',
                        'disclosures_text'=> '',
                        'licensing_text'=> '',
                        'about_text'=> '',
                        'contact_text'=>  '',
                        'compliance_text'=> $oldbototm["compliance_text"],
                        'compliance_is_linked'=>  $oldbototm["compliance_is_linked"],
                        'compliance_link'=>$oldbototm["compliance_link"],
                        'compliance_active' => $oldbototm["compliance_active"],
                        'license_number_active'=> $oldbototm["license_number_active"],
                        'license_number_is_linked'=> $oldbototm["license_number_is_linked"],
                        'license_number_text'=> $oldbototm["license_number_text"],
                        'license_number_link'=> $oldbototm["license_number_link"]
                    );
                    $this->insert('bottom_links' ,$bottom_links);
                }
                else {
                    if (($vertical == "mortgage" || $vertical == "realestate")) {
                        $bottom_links  = array(
                            'client_id'=> $client_id,
                            'leadpop_id'=>  $trialDefaults["leadpop_id"],
                            'leadpop_type_id'=>  $trialDefaults["leadpop_type_id"],
                            'leadpop_vertical_id'=>   $trialDefaults["leadpop_vertical_id"],
                            'leadpop_vertical_sub_id'=> $trialDefaults["leadpop_vertical_sub_id"],
                            'leadpop_template_id' => $trialDefaults['leadpop_template_id'],
                            'leadpop_version_id'=> $trialDefaults["leadpop_version_id"],
                            'leadpop_version_seq'=>   $trialDefaults["leadpop_version_seq"],
                            'privacy'=> '',
                            'terms'=> '',
                            'disclosures'=>  '',
                            'licensing'=> '',
                            'about'=>   '',
                            'contact'=> '',
                            'privacy_active' => 'n',
                            'terms_active'=> 'n',
                            'disclosures_active'=>  'n',
                            'licensing_active'=> 'n',
                            'about_active'=> 'n',
                            'contact_active'=>  'n',
                            'privacy_type'=> 'm',
                            'terms_type'=>   'm',
                            'disclosures_type'=> 'm',
                            'licensing_type' => 'm',
                            'about_type'=> 'm',
                            'contact_type'=>   'm',
                            'privacy_url'=> '',
                            'terms_url'=> '',
                            'disclosures_url'=>  '',
                            'licensing_url'=> '',
                            'about_url'=>   '',
                            'contact_url'=> '',
                            'privacy_text' => '',
                            'terms_text'=> '',
                            'disclosures_text'=> '',
                            'licensing_text'=> '',
                            'about_text'=> '',
                            'contact_text'=>  '',
                            'compliance_text'=> 'NMLS Consumer Look Up',
                            'compliance_is_linked'=>  'y',
                            'compliance_link'=> 'http://www.nmlsconsumeraccess.org',
                            'compliance_active' => 'y',
                            'license_number_active'=> 'y',
                            'license_number_is_linked'=> 'n',
                            'license_number_text'=> '',
                            'license_number_link'=> ''
                        );
                        $this->insert('bottom_links' ,$bottom_links);
                    }
                    else if ($vertical == "insurance") {
                        $bottom_links  = array(
                            'client_id'=> $client_id,
                            'leadpop_id'=>  $trialDefaults["leadpop_id"],
                            'leadpop_type_id'=>  $trialDefaults["leadpop_type_id"],
                            'leadpop_vertical_id'=>   $trialDefaults["leadpop_vertical_id"],
                            'leadpop_vertical_sub_id'=> $trialDefaults["leadpop_vertical_sub_id"],
                            'leadpop_template_id' => $trialDefaults['leadpop_template_id'],
                            'leadpop_version_id'=> $trialDefaults["leadpop_version_id"],
                            'leadpop_version_seq'=>   $trialDefaults["leadpop_version_seq"],
                            'privacy'=> '',
                            'terms'=> '',
                            'disclosures'=>  '',
                            'licensing'=> '',
                            'about'=>   '',
                            'contact'=> '',
                            'privacy_active' => 'n',
                            'terms_active'=> 'n',
                            'disclosures_active'=>  'n',
                            'licensing_active'=> 'n',
                            'about_active'=> 'n',
                            'contact_active'=>  'n',
                            'privacy_type'=> 'm',
                            'terms_type'=>   'm',
                            'disclosures_type'=> 'm',
                            'licensing_type' => 'm',
                            'about_type'=> 'm',
                            'contact_type'=>   'm',
                            'privacy_url'=> '',
                            'terms_url'=> '',
                            'disclosures_url'=>  '',
                            'licensing_url'=> '',
                            'about_url'=>   '',
                            'contact_url'=> '',
                            'privacy_text' => '',
                            'terms_text'=> '',
                            'disclosures_text'=> '',
                            'licensing_text'=> '',
                            'about_text'=> '',
                            'contact_text'=>  '',
                            'compliance_text'=> 'NMLS Consumer Look Up',
                            'compliance_is_linked'=>  'y',
                            'compliance_link'=> 'http://www.nmlsconsumeraccess.org',
                            'compliance_active' => 'y',
                            'license_number_active'=> 'y',
                            'license_number_is_linked'=> 'n',
                            'license_number_text'=> '',
                            'license_number_link'=> ''
                        );
                        $this->insert('bottom_links' ,$bottom_links);
                    }
                    else {
                        $bottom_links  = array(
                            'client_id'=> $client_id,
                            'leadpop_id'=>  $trialDefaults["leadpop_id"],
                            'leadpop_type_id'=>  $trialDefaults["leadpop_type_id"],
                            'leadpop_vertical_id'=>   $trialDefaults["leadpop_vertical_id"],
                            'leadpop_vertical_sub_id'=> $trialDefaults["leadpop_vertical_sub_id"],
                            'leadpop_template_id' => $trialDefaults['leadpop_template_id'],
                            'leadpop_version_id'=> $trialDefaults["leadpop_version_id"],
                            'leadpop_version_seq'=>   $trialDefaults["leadpop_version_seq"],
                            'privacy'=> '',
                            'terms'=> '',
                            'disclosures'=>  '',
                            'licensing'=> '',
                            'about'=>   '',
                            'contact'=> '',
                            'privacy_active' => 'n',
                            'terms_active'=> 'n',
                            'disclosures_active'=>  'n',
                            'licensing_active'=> 'n',
                            'about_active'=> 'n',
                            'contact_active'=>  'n',
                            'privacy_type'=> 'm',
                            'terms_type'=>   'm',
                            'disclosures_type'=> 'm',
                            'licensing_type' => 'm',
                            'about_type'=> 'm',
                            'contact_type'=>   'm',
                            'privacy_url'=> '',
                            'terms_url'=> '',
                            'disclosures_url'=>  '',
                            'licensing_url'=> '',
                            'about_url'=>   '',
                            'contact_url'=> '',
                            'privacy_text' => '',
                            'terms_text'=> '',
                            'disclosures_text'=> '',
                            'licensing_text'=> '',
                            'about_text'=> '',
                            'contact_text'=>  '',
                            'compliance_text'=> '',
                            'compliance_is_linked'=>  '',
                            'compliance_link'=> '',
                            'compliance_active' => '',
                            'license_number_active'=> '',
                            'license_number_is_linked'=> '',
                            'license_number_text'=> '',
                            'license_number_link'=> ''
                        );
                        $this->insert('bottom_links' ,$bottom_links);
                    }
                }

                $x1 = '<p style="text-align: center;">';
                $x1 .= '     <span style="font-family:arial,helvetica,sans-serif;">';
                $x1 .= '     <span style="font-size: 22px;">';
                $x1 .= '     <span style="color: rgb(51, 102, 255);">Thank You For Your Submission!</span><br />';
                $x1 .= '     <span style="color: rgb(51, 51, 51);">';
                $x1 .= '     <span style="font-size: 14px;">We have received your inquiry. An expert will follow up with you shortly.';
                $x1 .= '     </span>';
                $x1 .= '     </span>';
                $x1 .= '     </span>';
                $x1 .= '     </span>        ';
                $x1 .= '   </p>   ';
                $contact_options  = array(
                    'client_id'=> $client_id,
                    'leadpop_id'=>  $trialDefaults["leadpop_id"],
                    'leadpop_type_id'=>  $trialDefaults["leadpop_type_id"],
                    'leadpop_vertical_id'=>   $trialDefaults["leadpop_vertical_id"],
                    'leadpop_vertical_sub_id'=> $trialDefaults["leadpop_vertical_sub_id"],
                    'leadpop_template_id' => $trialDefaults['leadpop_template_id'],
                    'leadpop_version_id'=> $trialDefaults["leadpop_version_id"],
                    'leadpop_version_seq'=>   $trialDefaults["leadpop_version_seq"],
                    'companyname'=> addslashes($client ['company_name']),
                    'phonenumber'=> 'Call Today! ' . $client ['phone_number'],
                    'email'=>  $client ['contact_email'],
                    'companyname_active'=> 'n',
                    'phonenumber_active'=>   'y',
                    'email_active'=> 'n'
                );
                $this->insert('contact_options' ,$contact_options);


                //add review bar
                $trustpilot_reviewbar  = array(
                    'client_id'=> $client_id,
                    'leadpop_id'=>  $trialDefaults["leadpop_id"],
                    'leadpop_type_id'=>  $trialDefaults["leadpop_type_id"],
                    'leadpop_vertical_id'=>   $trialDefaults["leadpop_vertical_id"],
                    'leadpop_vertical_sub_id'=> $trialDefaults["leadpop_vertical_sub_id"],
                    'leadpop_template_id' => $trialDefaults['leadpop_template_id'],
                    'leadpop_version_id'=> $trialDefaults["leadpop_version_id"],
                    'leadpop_version_seq'=>   $trialDefaults["leadpop_version_seq"],
                    'bar_active'=> 'n',
                    'bar_text'=> 'What Our Customers Say:',
                    'bar_score'=>  '',
                    'bar_reviews'=> ''
                );
                $this->insert('trustpilot_reviewbar' ,$trustpilot_reviewbar);

                $autotext = $this->getAutoResponderText ( $trialDefaults["leadpop_vertical_id"], $trialDefaults["leadpop_vertical_sub_id"] , $trialDefaults["leadpop_id"]);
                if ($autotext == "not found") {
                    $thehtml =  "";
                    $thesubject = "";
                }
                else {
                    $thehtml =  $autotext[0]["html"];
                    $thesubject = $autotext[0]["subject_line"];
                }
                $autoresponder_options  = array(
                    'client_id'=> $client_id,
                    'leadpop_id'=>  $trialDefaults["leadpop_id"],
                    'leadpop_type_id'=>  $trialDefaults["leadpop_type_id"],
                    'leadpop_vertical_id'=>   $trialDefaults["leadpop_vertical_id"],
                    'leadpop_vertical_sub_id'=> $trialDefaults["leadpop_vertical_sub_id"],
                    'leadpop_template_id' => $trialDefaults['leadpop_template_id'],
                    'leadpop_version_id'=> $trialDefaults["leadpop_version_id"],
                    'leadpop_version_seq'=>   $trialDefaults["leadpop_version_seq"],
                    'html'=> addslashes($thehtml),
                    'thetext'=> '',
                    'html_active'=>  'y',
                    'text_active'=> 'n',
                    'subject_line'=>  addslashes($thesubject)
                );
                $this->insert('autoresponder_options' ,$autoresponder_options);

                try {
                    $this->db->query ($s);
                }
                catch ( PDOException $e) {
                    print ("Error!: " . $e->getMessage() . "<br/>") ;
                    print($s);
                    die();
                }


                $title_tag =  " FREE " . $trialDefaults["display_name"] . " | " . addslashes ( ucwords($client ['company_name']) );
                //FREE Home Purchase Qualifier | Sentinel Mortgage Company
                $seo_options  = array(
                    'client_id'=> $client_id,
                    'leadpop_id'=>  $trialDefaults["leadpop_id"],
                    'leadpop_type_id'=>  $trialDefaults["leadpop_type_id"],
                    'leadpop_vertical_id'=>   $trialDefaults["leadpop_vertical_id"],
                    'leadpop_vertical_sub_id'=> $trialDefaults["leadpop_vertical_sub_id"],
                    'leadpop_template_id' => $trialDefaults['leadpop_template_id'],
                    'leadpop_version_id'=> $trialDefaults["leadpop_version_id"],
                    'leadpop_version_seq'=>   $trialDefaults["leadpop_version_seq"],
                    'titletag'=>  addslashes($title_tag),
                    'description'=> '',
                    'metatags'=>  '',
                    'titletag_active'=> 'y',
                    'description_active'=> 'n',
                    'metatags_active' => 'n'
                );
                $this->insert('seo_options' ,$seo_options);

                //$verticalName , $subverticalName removed because we are not using placeholder right now @mzac90

                $submissionText = $this->getSubmissionText($trialDefaults["leadpop_id"],$trialDefaults["leadpop_vertical_id"],$trialDefaults["leadpop_vertical_sub_id"]);
                $submissionText = str_replace("##clientlogo##",$this->logosrc,$submissionText);
                $submissionText = str_replace("##clientphonenumber##",$freeTrialBuilderAnswers['phonenumber'],$submissionText);

                $submission_options  = array(
                    'client_id'=> $client_id,
                    'leadpop_id'=>  $trialDefaults["leadpop_id"],
                    'leadpop_type_id'=>  $trialDefaults["leadpop_type_id"],
                    'leadpop_vertical_id'=>   $trialDefaults["leadpop_vertical_id"],
                    'leadpop_vertical_sub_id'=> $trialDefaults["leadpop_vertical_sub_id"],
                    'leadpop_template_id' => $trialDefaults['leadpop_template_id'],
                    'leadpop_version_id'=> $trialDefaults["leadpop_version_id"],
                    'leadpop_version_seq'=>   $trialDefaults["leadpop_version_seq"],
                    'thankyou'=>  addslashes($submissionText),
                    'information'=> '',
                    'thirdparty'=>  '',
                    'thankyou_active'=> 'y',
                    'information_active'=> 'n',
                    'thirdparty_active' => 'n'
                );
                $this->insert('submission_options' ,$submission_options);
            }
        }
        $this->addPlaceholder($trialDefaults, $this->logosrc, $this->imgsrc, $client);
        /*
                                        * old leadpops_templates_placeholders_info functionality remove from @mzac90
                                        */


        if ($generatecolors != false && $useUploadedLogo != false) { // not uploaded logo or have previous funnel to use

            for($t = 0; $t < count($finalTrialColors); $t++) {
                if ($t == 0 ) {
                    $s = 'y';
                } else {
                    $s = 'n';
                }
                $this->db->query($s);
                $leadpop_background_swatches  = array(
                    'client_id'=> $client_id,
                    'leadpop_vertical_id'=>$trialDefaults["leadpop_vertical_id"],
                    'leadpop_vertical_sub_id'=>$trialDefaults["leadpop_vertical_sub_id"],
                    'leadpop_type_id'=>$this->leadpoptype,
                    'leadpop_template_id'=>$trialDefaults['leadpop_template_id'],
                    'leadpop_id' => $trialDefaults["leadpop_id"],
                    'leadpop_version_id'=> $trialDefaults["leadpop_version_id"],
                    'leadpop_version_seq'=>  $trialDefaults["leadpop_version_seq"],
                    'swatch'=> $finalTrialColors[$t]["swatch"],
                    'is_primary'=> $s,
                    'active' => 'y'
                );
                $this->insert('leadpop_background_swatches' ,$leadpop_background_swatches);
            }
            $leadpop_background_color  = array(
                'client_id'=> $client_id,
                'leadpop_vertical_id' => $trialDefaults["leadpop_vertical_id"],
                'leadpop_vertical_sub_id' => $trialDefaults["leadpop_vertical_sub_id"],
                'leadpop_type_id' => $trialDefaults["leadpop_type_id"],
                'leadpop_template_id'=>$trialDefaults['leadpop_template_id'],
                'leadpop_id' => $trialDefaults["leadpop_id"],
                'leadpop_version_id' => $trialDefaults["leadpop_version_id"],
                'leadpop_version_seq' =>  $trialDefaults["leadpop_version_seq"],
                'background_color' =>addslashes($background_css),
                'active' => 'y',
                'default_changed' => $default_background_changed
            );
            $this->insert('leadpop_background_color' ,$leadpop_background_color);
        }
        $s = "update add_client_funnels  set has_run = 'y' ";
        $this->db->query($s);

        print("addNonEnterpriseVerticalSubverticalVersionToExistingClient - added " . $client_id);
    }
    /* end  non enterprise subvertical version to existing client function */

    /* start new enterprise function */
    function addNewClientGenericEnterprise($vertical, $subvertical,$version, $emailaddress, $firstname, $lastname, $company,$phone) {

        $logo_name_mobile = "home_refinance_mobile.png";
        $logo_name = "home_refinance.png";
        $image_name = "Refinance.png";
        $logo = ""; // a blank logo value indicate to use the default logo

        /* check if email exists in system */
        $dt = date('Y-m-d H:i:s');

        $s = "select count(*) as cnt  from clients where contact_email = '".trim($emailaddress)."' ";
        $existingEmail = $this->db->fetchOne($s);
        $duplicateEmail = false;
        if($existingEmail != 0) { // new client
            $random = $this->generateRandomString() . "-";
            $duplicateEmail = true;   // email andrew/charles & have them get another client contact email address
            $emailaddress = $random . $emailaddress;
        }

        /* insert into clients table */

        $password = $this->generateRandomString("8");
        $encryptedpassword = $this->encrypt($password);
        $client_insert = array(
            'first_name' => addslashes($firstname),
            'last_name' => addslashes($lastname),
            'company_name' => addslashes($company),
            'phone_number' => $phone,
            'fax_number'  => '',
            'address1' => '',
            'address2' =>'',
            'city' => '',
            'state' =>'',
            'zip'=> '',
            'cell_number' => '',
            'join_dat' => $dt,
            'contact_email' => $emailaddress,
            'password' => $encryptedpassword,
            'active' => 1
        );
        $client_id =  $this->insert('clients' ,$client_insert);

        $client_vertical_packages_permissions = array(
            'client_id' => $client_id,
            'clone' => 'n',
            'thedate' => $dt
        );
        $this->insert('client_vertical_packages_permissions' ,$client_vertical_packages_permissions);

        /* insert into active order table */
        $has_one_active_order = array(
            'client_id' => $client_id,
            'hasorder' => 'y',
        );
        $this->insert('has_one_active_order' ,$has_one_active_order);

        $thedate = date ( 'Y-m-d H:i:s' );
        $sales_clients = array(
            'client_id' => $client_id,
            'start_date' => $thedate,
            'end_date' => $thedate ,
            'active' => 'y'
        );
        $this->insert('sales_clients' ,$sales_clients);
        switch ($vertical) {
            case "3":
                $emmaAccount = '1758432';
                $emma_account_type = "mortgage";
                break;
            case "1":
                $emmaAccount =  '1760824';
                $emma_account_type = "insurance";
                break;
            case "5":
                $emmaAccount = '1758435';
                $emma_account_type = "realestate";
                break;
            default :
                $emmaAccount = '999999';
        }
        $emma_account_name = $company;
        /* values to insert into client_emma_cron to create accounts */
        //Todo ifs intergration pending
        require_once('/var/www/vhosts/launch.leadpops.com/isdk/src/isdk.php');
        require_once('/var/www/library/Zend/Mail.php');

        $app = new iSDK();
        $app->cfgCon("leadpops");

        $returnFields = array('Id');
        $query = array('Email' => $emailaddress);
        $contacts = $app->dsQuery("Contact",10,0,$query,$returnFields);
        if (count($contacts) > 0) {
            ## $conDat = array('_AdminLink0' => 'https://myleads.leadpops.com/login/is_andrew?xxxzzaqlk=' . $client_id,
            $conDat = array('_AdminLink0' => 'https://myleads.leadpops.com/lp/login/is_andrew?leadpopsspopdael=' . $client_id,
                '_CompanyName' => $company,
                '_AdminUserName' => $emailaddress,
                '_AdminPassword' =>  $password  );
            $conID = $app->updateCon($contacts[0]["Id"], $conDat);
            $ContactGroupId = "505";
            $Integration = 'le234'; // leadpops subdomain in use
            $callName = 'Welcome Campaign - Funnels'; // api callname

            $gr = $app->grpAssign($conID, $ContactGroupId);
            $goal = $app->achieveGoal($Integration, $callName, $conID);

        }
        else {
            //something
        }
        /* create client leadpops */
        $s = "select * from enterprise_funnels where leadpop_vertical_id = " . $vertical . " and leadpop_vertical_sub_id = " . $subvertical . " and leadpop_version_id = " . $version . " limit 1 ";
        $trialDefaults = $this->db->fetchRow($s);
        $this->insertDefaultEnterpriseAutoResponders ($client_id,$trialDefaults, $emailaddress,$phone);

        //$template_info removed because we are not using placeholder right now @mzac90

        $s = "select * from leadpops_verticals where id = " . $trialDefaults["leadpop_vertical_id"];
        $vertres = $this->db->fetchRow($s);
        $verticalName = $vertres ['lead_pop_vertical'];
        /*
        * Add default vertical name in leadpops_folders table
        * */
        $folder_id  = $this->addFolder($verticalName,$client_id);

        $lead_line = '<span style="font-family: ' . $trialDefaults["main_message_font"] . '; font-size: ' . $trialDefaults["main_message_font_size"] . '; color: ' . ($this->globallogo_color == "" ? $trialDefaults["mainmessage_color"] : $this->globallogo_color) . '">' . $trialDefaults["main_message"] . '</span>';
        $second_line = '<span style="font-family: ' . $trialDefaults["description_font"] . '; font-size: ' . $trialDefaults["description_font_size"] . '; color: ' . $trialDefaults["description_color"] . '">' . $trialDefaults["description"] . '</span>';

        if($trialDefaults["conditional_logic"]==null || $trialDefaults["conditional_logic"]=="null"){
            $trialDefaults["conditional_logic"] = "{}";
        }

        $now = new DateTime();
        $clients_leadpops  = array(
            'client_id'=> $client_id,
            'question_sequence' =>  addslashes($trialDefaults["question_sequence"]),
            'funnel_questions' => addslashes($trialDefaults["funnel_questions"]),
            'conditional_logic' =>  $trialDefaults["conditional_logic"],
            'lead_line' =>  addslashes($lead_line),
            'second_line_more' =>  addslashes($second_line),
            'funnel_name' => $trialDefaults["funnel_name"],
            'leadpop_folder_id' => $folder_id,
            'leadpop_id'=>  $trialDefaults["leadpop_id"],
            'leadpop_version_id'=> $trialDefaults["leadpop_version_id"],
            'leadpop_active'=>  '1',
            'access_code'=> '',
            'leadpop_version_seq' =>  $trialDefaults["leadpop_version_seq"],
            'static_thankyou_active' => 'y',
            'static_thankyou_slug' => 'thank-you.html',
            'date_added'=> $now->format("Y-m-d H:i:s")
        );
        $client_leadpop_id = $this->insert('clients_leadpops' ,$clients_leadpops);
        $this->assignTagToFunnel($client_leadpop_id,$trialDefaults,$client_id);

        $clients_leadpops_content  = array(
            'client_id'=> $client_id,
            'leadpop_id'=>  $trialDefaults["leadpop_id"],
            'leadpop_version_id'=> $trialDefaults["leadpop_version_id"],
            'leadpop_active'=>  '1',
            'access_code'=> '',
            'leadpop_version_seq' => $trialDefaults["leadpop_version_seq"],
            'section1'=> '<h4>section one</h4>',
            'section2'=> '<h4>section two</h4>',
            'section3'=> '<h4>section three</h4>',
            'section4'=> '<h4>section four</h4>',
            'section5'=> '<h4>section five</h4>',
            'section6'=> '<h4>section six</h4>',
            'section7'=> '<h4>section seven</h4>',
            'section8'=> '<h4>section eight</h4>',
            'section9'=> '<h4>section nine</h4>',
            'section10'=> '<h4>section ten</h4>',
            'template'=> 1
        );
        $this->insert('clients_leadpops_content' ,$clients_leadpops_content);

        $this->checkIfNeedMultipleStepInsert ( $trialDefaults["leadpop_version_id"], $client_id );

        // look up domain name
        $s = "select * from clients where client_id = " . $client_id . " limit 1 ";
        $client = $this->db->fetchRow($s);
        $subdomain = $client ['company_name'];
        $subdomain = preg_replace ( '/[^a-zA-Z]/', '', $subdomain ). "-" .$this->generateRandomString(8);

        $s = "select domain from top_level_domains where primary_domain = 'y' limit 1 ";
        $topdomain = $this->db->fetchOne ( $s );
        if ($this->leadpoptype == $this->thissub_domain) {
            $s = "select  count(*) from clients_funnels_domains where  ";
            $s .= " subdomain_name = '" . $subdomain . "' ";
            $s .= " and top_level_domain = '" . $topdomain . "' ";
            $foundsubdomain = $this->db->fetchOne ( $s );

            if ($foundsubdomain > 0) {
                $s = "select domain from top_level_domains where primary_domain != 'y' ";
                $nonprimary = $this->db->fetchAll ( $s );
                $foundone = false;
                while ( $foundone == false ) {
                    for($k = 0; $k < count ( $nonprimary ); $k ++) {
                        $s = "select  count(*) from clients_funnels_domains where  ";
                        $s .= " subdomain_name = '" . $subdomain . "' ";
                        $s .= " and top_level_domain = '" . $nonprimary [$k] ['domain'] . "' ";
                        $foundsubdomain = $this->db->fetchOne ( $s );
                        if ($foundsubdomain == 0) {
                            $clients_subdomains  = array(
                                'client_id'=> $client_id,
                                'subdomain_name'=> $subdomain,
                                'top_level_domain'=>  $nonprimary [$k] ['domain'],
                                'leadpop_vertical_id'=>  $trialDefaults["leadpop_vertical_id"],
                                'leadpop_vertical_sub_id'=> $trialDefaults["leadpop_vertical_sub_id"],
                                'leadpop_type_id' => $this->leadpoptype,
                                'leadpop_template_id'=> $trialDefaults['leadpop_template_id'],
                                'leadpop_id'=>  $trialDefaults["leadpop_id"],
                                'leadpop_version_id'=> $trialDefaults["leadpop_version_id"],
                                'leadpop_version_seq' => $trialDefaults["leadpop_version_seq"],
                            );
                            $this->insert('clients_funnels_domains' ,$clients_subdomains);

                            /* emma insert */
                            if ($emmaAccount != '999999') {
                                $s = "  select * from client_emma_group  ";
                                $s .= " where leadpop_vertical_id = " . $trialDefaults["leadpop_vertical_id"];
                                $s .= " and leadpop_subvertical_id = " .  $trialDefaults["leadpop_vertical_sub_id"];
                                $s .= " and client_id = " .$client_id . "";
                                $emmaExists =  $this->db->fetchRow($s);
                                if ($emmaExists) {
                                    $client_emma_group  = array(
                                        'client_id'=> $client_id,
                                        'domain_name'=>    strtolower($subdomain . "." . $nonprimary [$k] ['domain']),
                                        'member_account_id'=> $emmaExists["member_account_id"],
                                        'member_group_id'=>   $emmaExists["member_group_id"],
                                        'group_name'=> $emmaExists["group_name"],
                                        'total_contacts' => '0',
                                        'leadpop_vertical_id' => $trialDefaults["leadpop_vertical_id"],
                                        'leadpop_subvertical_id'=> $trialDefaults["leadpop_vertical_sub_id"],
                                        'active'=> 'y'
                                    );
                                    $this->insert('client_emma_group' ,$client_emma_group);
                                }
                                else{
                                    //Taking basic information for emma from one of existing entry
                                    $sql = "SELECT id, emma_default_group, account_name, master_account_ids FROM client_emma_cron WHERE ";
                                    $sql .= " client_id= ".$client_id." and leadpop_vertical_id = ".$trialDefaults["leadpop_vertical_id"]."
                                    and leadpop_subvertical_id = ".$trialDefaults["leadpop_vertical_sub_id"]."";
                                    $ex_emma_cron = $this->db->fetchRow( $sql );

                                    if($ex_emma_cron) {
                                        $EmmaAccountName = $ex_emma_cron['account_name'];
                                        $master_account_ids = $ex_emma_cron['master_account_ids'];
                                        $emma_default_group = $ex_emma_cron['emma_default_group'];

                                        //Check the entry in client_emma_account table
                                        $emma_account = "SELECT * FROM client_emma_account WHERE client_id= " . $client_id . "";
                                        $emma_account_res = $this->db->fetchRow($emma_account);
                                        if (empty($emma_account_res)) {
                                            /* emma insert */
                                            $client_emma_cron = array(
                                                'client_id'=> $client_id,
                                                'emma_default_group'=>  $emma_default_group,
                                                'account_type'=> $emma_account_type,
                                                'domain_name'=>   strtolower($subdomain . "." . $nonprimary [$k] ['domain']),
                                                'account_name'=> $EmmaAccountName,
                                                'master_account_ids' => addslashes($master_account_ids),
                                                'has_run'=> 'n',
                                                'leadpop_vertical_id'=>   $trialDefaults["leadpop_vertical_id"],
                                                'leadpop_subvertical_id'=> $trialDefaults["leadpop_vertical_sub_id"]
                                            );
                                            $this->insert('client_emma_cron' ,$client_emma_cron);
                                        } else {
                                            /*if already existing the entry then insert entry in the client_emma_group table*/
                                            $client_emma_group  = array(
                                                'client_id'=> $client_id,
                                                'domain_name'=>   strtolower($subdomain . "." . $nonprimary [$k] ['domain']),
                                                'member_account_id'=> $emmaExists["member_account_id"],
                                                'member_group_id'=>   $emmaExists["member_group_id"],
                                                'group_name'=> $emmaExists["group_name"],
                                                'total_contacts' => '0',
                                                'leadpop_vertical_id' => $trialDefaults["leadpop_vertical_id"],
                                                'leadpop_subvertical_id'=> $trialDefaults["leadpop_vertical_sub_id"],
                                                'active'=> 'y'
                                            );
                                            $this->insert('client_emma_group' ,$client_emma_group);
                                        }
                                    }

                                }
                            }
                            /* emma insert */

                            //mobileclients  functionality removed from @mzac90
                            $googleDomain = $subdomain . "." . $nonprimary [$k] ['domain'];
                            $this->insertPurchasedGoogle ( $client_id, $googleDomain );

                            $bottom_links  = array(
                                'client_id'=> $client_id,
                                'leadpop_id'=>  $trialDefaults["leadpop_id"],
                                'leadpop_type_id'=>  $this->leadpoptype,
                                'leadpop_vertical_id'=>   $trialDefaults["leadpop_vertical_id"],
                                'leadpop_vertical_sub_id'=> $trialDefaults["leadpop_vertical_sub_id"],
                                'leadpop_template_id' => $trialDefaults['leadpop_template_id'],
                                'leadpop_version_id'=> $trialDefaults["leadpop_version_id"],
                                'leadpop_version_seq'=>   $trialDefaults["leadpop_version_seq"],
                                'privacy'=> '',
                                'terms'=> '',
                                'disclosures'=>  '',
                                'licensing'=> '',
                                'about'=>   '',
                                'contact'=> '',
                                'privacy_active' => 'n',
                                'terms_active'=> 'n',
                                'disclosures_active'=>  'n',
                                'licensing_active'=> 'n',
                                'about_active'=> 'n',
                                'contact_active'=>  'y',
                                'privacy_type'=> 'm',
                                'terms_type'=>   'm',
                                'disclosures_type'=> 'm',
                                'licensing_type' => 'm',
                                'about_type'=> 'm',
                                'contact_type'=>   'm',
                                'privacy_url'=> '',
                                'terms_url'=> '',
                                'disclosures_url'=>  '',
                                'licensing_url'=> '',
                                'about_url'=>   '',
                                'contact_url'=> '',
                                'privacy_text' => '',
                                'terms_text'=> '',
                                'disclosures_text'=> '',
                                'licensing_text'=> '',
                                'about_text'=> '',
                                'contact_text'=>  '',
                                'compliance_text'=> '',
                                'compliance_is_linked'=>'',
                                'compliance_link'=>'',
                                'compliance_active' =>'',
                                'license_number_active'=>'',
                                'license_number_is_linked'=>'',
                                'license_number_text'=>'',
                                'license_number_link'=> ''
                            );
                            $this->insert('bottom_links' ,$bottom_links);

                            $contact_options  = array(
                                'client_id'=> $client_id,
                                'leadpop_id'=>  $trialDefaults["leadpop_id"],
                                'leadpop_type_id'=>  $this->leadpoptype,
                                'leadpop_vertical_id'=>   $trialDefaults["leadpop_vertical_id"],
                                'leadpop_vertical_sub_id'=> $trialDefaults["leadpop_vertical_sub_id"],
                                'leadpop_template_id' => $trialDefaults['leadpop_template_id'],
                                'leadpop_version_id'=> $trialDefaults["leadpop_version_id"],
                                'leadpop_version_seq'=>   $trialDefaults["leadpop_version_seq"],
                                'companyname'=> addslashes($client ['company_name']),
                                'phonenumber'=> 'Call Today! ' . $client ['phone_number'],
                                'email'=>  $client ['contact_email'],
                                'companyname_active'=> 'n',
                                'phonenumber_active'=>   'y',
                                'email_active'=> 'n'
                            );
                            $this->insert('contact_options' ,$contact_options);

                            //add review bar
                            $trustpilot_reviewbar  = array(
                                'client_id'=> $client_id,
                                'leadpop_id'=>  $trialDefaults["leadpop_id"],
                                'leadpop_type_id'=>  $this->leadpoptype,
                                'leadpop_vertical_id'=>   $trialDefaults["leadpop_vertical_id"],
                                'leadpop_vertical_sub_id'=> $trialDefaults["leadpop_vertical_sub_id"],
                                'leadpop_template_id' => $trialDefaults['leadpop_template_id'],
                                'leadpop_version_id'=> $trialDefaults["leadpop_version_id"],
                                'leadpop_version_seq'=>   $trialDefaults["leadpop_version_seq"],
                                'bar_active'=> 'n',
                                'bar_text'=> 'What Our Customers Say:',
                                'bar_score'=>  '',
                                'bar_reviews'=> ''
                            );
                            $this->insert('trustpilot_reviewbar' ,$trustpilot_reviewbar);

                            $autotext = $this->getAutoResponderText ( $trialDefaults["leadpop_vertical_id"], $trialDefaults["leadpop_vertical_sub_id"] , $trialDefaults["leadpop_id"]);
                            if ($autotext == "not found") {
                                $thehtml =  "";
                                $thesubject = "";
                            }
                            else {
                                $thehtml =  $autotext[0]["html"];
                                $thesubject = $autotext[0]["subject_line"];
                            }
                            $autoresponder_options  = array(
                                'client_id'=> $client_id,
                                'leadpop_id'=>  $trialDefaults["leadpop_id"],
                                'leadpop_type_id'=>  $this->leadpoptype,
                                'leadpop_vertical_id'=>   $trialDefaults["leadpop_vertical_id"],
                                'leadpop_vertical_sub_id'=> $trialDefaults["leadpop_vertical_sub_id"],
                                'leadpop_template_id' => $trialDefaults['leadpop_template_id'],
                                'leadpop_version_id'=> $trialDefaults["leadpop_version_id"],
                                'leadpop_version_seq'=>   $trialDefaults["leadpop_version_seq"],
                                'html'=> addslashes($thehtml),
                                'thetext'=> '',
                                'html_active'=>  'y',
                                'text_active'=> 'n',
                                'subject_line'=>  addslashes($thesubject)
                            );
                            $this->insert('autoresponder_options' ,$autoresponder_options);

                            $title_tag =  " FREE " . $trialDefaults["display_name"] . " | " . addslashes ( ucwords($client['company_name']) );
                            $seo_options  = array(
                                'client_id'=> $client_id,
                                'leadpop_id'=>  $trialDefaults["leadpop_id"],
                                'leadpop_type_id'=>  $this->leadpoptype,
                                'leadpop_vertical_id'=>   $trialDefaults["leadpop_vertical_id"],
                                'leadpop_vertical_sub_id'=> $trialDefaults["leadpop_vertical_sub_id"],
                                'leadpop_template_id' => $trialDefaults['leadpop_template_id'],
                                'leadpop_version_id'=> $trialDefaults["leadpop_version_id"],
                                'leadpop_version_seq'=>   $trialDefaults["leadpop_version_seq"],
                                'titletag'=>  addslashes($title_tag),
                                'description'=> '',
                                'metatags'=>  '',
                                'titletag_active'=> 'y',
                                'description_active'=> 'n',
                                'metatags_active' => 'n'
                            );
                            $this->insert('seo_options' ,$seo_options);

                            $s = "select * from leadpops_verticals where id = " . $trialDefaults[0]["leadpop_vertical_id"];
                            $vertres = $this->db->fetchRow ( $s );
                            $verticalName = $vertres ['lead_pop_vertical'];
                            //  	funnel_type 	subvertical_name 	leadpop_vertical_id 	leadpop_vertical_sub_id 	leadpop_type_id 	leadpop_template_id 	leadpop_id 	leadpop_version_id 	leadpop_version_seq

                            if (isset ($trialDefaults["leadpop_vertical_sub_id"] ) && $trialDefaults["leadpop_vertical_sub_id"] != "") {
                                $s = "select * from leadpops_verticals_sub where leadpop_vertical_id  = " . $trialDefaults["leadpop_vertical_id"];
                                $s .= " and id = " . $trialDefaults["leadpop_vertical_sub_id"];
                                $subvertres = $this->db->fetchRow ( $s );
                                $subverticalName = $subvertres ['lead_pop_vertical_sub'];
                            } else {
                                $subverticalName = "";
                            }

                            $logosrc = "";
                            $imgsrc = "";
                            $uploadedLogo = $logo;
                            if ($subverticalName == "") {
                                $logosrc = $this->getHttpServer () . '/images/' . strtolower(str_replace(" ","",$verticalName)) . '/' . $logo_name;
                            } else {
                                $logosrc = $this->getHttpServer () . '/images/' . strtolower(str_replace(" ","",$verticalName)) . '/' . strtolower(str_replace(" ","",$subverticalName)). '_logos/' .$logo_name;
                            }
                            $this->insertDefaultClientUploadLogo($logosrc,$trialDefaults,$client_id);

                            $imgsrc =$this->insertClientDefaultEnterpriseImage($trialDefaults,$image_name,$client_id);

                            $nine = "999999";
                            $submissionText = $this->getSubmissionText($trialDefaults["leadpop_id"],$trialDefaults["leadpop_vertical_id"],$trialDefaults["leadpop_vertical_sub_id"],$nine);
                            $submissionText = str_replace("##clientlogo##",$logosrc,$submissionText);
                            $submissionText = str_replace("##clientphonenumber##",$phone,$submissionText);
                            $submission_options  = array(
                                'client_id'=> $client_id,
                                'leadpop_id'=>  $trialDefaults["leadpop_id"],
                                'leadpop_type_id'=>  $this->leadpoptype,
                                'leadpop_vertical_id'=>   $trialDefaults["leadpop_vertical_id"],
                                'leadpop_vertical_sub_id'=> $trialDefaults["leadpop_vertical_sub_id"],
                                'leadpop_template_id' => $trialDefaults['leadpop_template_id'],
                                'leadpop_version_id'=> $trialDefaults["leadpop_version_id"],
                                'leadpop_version_seq'=>   $trialDefaults["leadpop_version_seq"],
                                'thankyou'=>  addslashes($submissionText),
                                'information'=> '',
                                'thirdparty'=>  '',
                                'thankyou_active'=> 'y',
                                'information_active'=> 'n',
                                'thirdparty_active' => 'n'
                            );
                            $this->insert('submission_options' ,$submission_options);

                            $foundone = true;
                            break 2;
                        }
                    }
                    $subdomain = $subdomain . $this->getRandomCharacter ();
                }
            }

            else {
                $clients_subdomains  = array(
                    'client_id'=> $client_id,
                    'subdomain_name'=> $subdomain,
                    'top_level_domain'=>  $topdomain,
                    'leadpop_vertical_id'=>  $trialDefaults["leadpop_vertical_id"],
                    'leadpop_vertical_sub_id'=> $trialDefaults["leadpop_vertical_sub_id"],
                    'leadpop_type_id' => $this->leadpoptype,
                    'leadpop_template_id'=> $trialDefaults['leadpop_template_id'],
                    'leadpop_id'=>  $trialDefaults["leadpop_id"],
                    'leadpop_version_id'=> $trialDefaults["leadpop_version_id"],
                    'leadpop_version_seq' => $trialDefaults["leadpop_version_seq"],
                );

                $this->insert('clients_funnels_domains' ,$clients_subdomains);

                /* emma insert */
                if ($emmaAccount != '999999') {
                    $s = "  select * from client_emma_group  ";
                    $s .= " where leadpop_vertical_id = " . $trialDefaults["leadpop_vertical_id"];
                    $s .= " and leadpop_subvertical_id = " .  $trialDefaults["leadpop_vertical_sub_id"];
                    $s .= " and client_id = " .$client_id . "";
                    $emmaExists =  $this->db->fetchRow($s);
                    if ($emmaExists) {
                        $client_emma_group  = array(
                            'client_id'=> $client_id,
                            'domain_name'=>   strtolower($subdomain . "." . $topdomain),
                            'member_account_id'=> $emmaExists["member_account_id"],
                            'member_group_id'=>   $emmaExists["member_group_id"],
                            'group_name'=> $emmaExists["group_name"],
                            'total_contacts' => '0',
                            'leadpop_vertical_id' => $trialDefaults["leadpop_vertical_id"],
                            'leadpop_subvertical_id'=> $trialDefaults["leadpop_vertical_sub_id"],
                            'active'=> 'y'
                        );
                        $this->insert('client_emma_group' ,$client_emma_group);
                    }
                    else{
                        //Taking basic information for emma from one of existing entry
                        $sql = "SELECT id, emma_default_group, account_name, master_account_ids FROM client_emma_cron WHERE ";
                        $sql .= " client_id= ".$client_id." and leadpop_vertical_id = ".$trialDefaults["leadpop_vertical_id"]."
                                    and leadpop_subvertical_id = ".$trialDefaults["leadpop_vertical_sub_id"]."";
                        $ex_emma_cron = $this->db->fetchRow( $sql );

                        if($ex_emma_cron) {
                            $EmmaAccountName = $ex_emma_cron['account_name'];
                            $master_account_ids = $ex_emma_cron['master_account_ids'];
                            $emma_default_group = $ex_emma_cron['emma_default_group'];

                            //Check the entry in client_emma_account table
                            $emma_account = "SELECT * FROM client_emma_account WHERE client_id= " . $client_id . "";
                            $emma_account_res = $this->db->fetchRow($emma_account);
                            if (empty($emma_account_res)) {
                                /* emma insert */
                                $client_emma_cron = array(
                                    'client_id'=> $client_id,
                                    'emma_default_group'=>  $emma_default_group,
                                    'account_type'=> $emma_account_type,
                                    'domain_name'=>   strtolower($subdomain . "." . $topdomain),
                                    'account_name'=> $EmmaAccountName,
                                    'master_account_ids' => addslashes($master_account_ids),
                                    'has_run'=> 'n',
                                    'leadpop_vertical_id'=>   $trialDefaults["leadpop_vertical_id"],
                                    'leadpop_subvertical_id'=> $trialDefaults["leadpop_vertical_sub_id"]
                                );
                                $this->insert('client_emma_cron' ,$client_emma_cron);
                            } else {
                                /*if already existing the entry then insert entry in the client_emma_group table*/
                                $client_emma_group  = array(
                                    'client_id'=> $client_id,
                                    'domain_name'=>  strtolower($subdomain . "." . $topdomain),
                                    'member_account_id'=> $emmaExists["member_account_id"],
                                    'member_group_id'=>   $emmaExists["member_group_id"],
                                    'group_name'=> $emmaExists["group_name"],
                                    'total_contacts' => '0',
                                    'leadpop_vertical_id' => $trialDefaults["leadpop_vertical_id"],
                                    'leadpop_subvertical_id'=> $trialDefaults["leadpop_vertical_sub_id"],
                                    'active'=> 'y'
                                );
                                $this->insert('client_emma_group' ,$client_emma_group);
                            }
                        }

                    }
                }
                /* emma insert */
                //mobileclients  functionality removed from @mzac90
                $googleDomain = $subdomain . "." . $topdomain;
                $this->insertPurchasedGoogle ( $client_id, $googleDomain );
                $bottom_links  = array(
                    'client_id'=> $client_id,
                    'leadpop_id'=>  $trialDefaults["leadpop_id"],
                    'leadpop_type_id'=>  $this->leadpoptype,
                    'leadpop_vertical_id'=>   $trialDefaults["leadpop_vertical_id"],
                    'leadpop_vertical_sub_id'=> $trialDefaults["leadpop_vertical_sub_id"],
                    'leadpop_template_id' => $trialDefaults['leadpop_template_id'],
                    'leadpop_version_id'=> $trialDefaults["leadpop_version_id"],
                    'leadpop_version_seq'=>   $trialDefaults["leadpop_version_seq"],
                    'privacy'=> '',
                    'terms'=> '',
                    'disclosures'=>  '',
                    'licensing'=> '',
                    'about'=>   '',
                    'contact'=> '',
                    'privacy_active' => 'n',
                    'terms_active'=> 'n',
                    'disclosures_active'=>  'n',
                    'licensing_active'=> 'n',
                    'about_active'=> 'n',
                    'contact_active'=>  'y',
                    'privacy_type'=> 'm',
                    'terms_type'=>   'm',
                    'disclosures_type'=> 'm',
                    'licensing_type' => 'm',
                    'about_type'=> 'm',
                    'contact_type'=>   'm',
                    'privacy_url'=> '',
                    'terms_url'=> '',
                    'disclosures_url'=>  '',
                    'licensing_url'=> '',
                    'about_url'=>   '',
                    'contact_url'=> '',
                    'privacy_text' => '',
                    'terms_text'=> '',
                    'disclosures_text'=> '',
                    'licensing_text'=> '',
                    'about_text'=> '',
                    'contact_text'=>  '',
                    'compliance_text'=> '',
                    'compliance_is_linked'=>'',
                    'compliance_link'=>'',
                    'compliance_active' =>'',
                    'license_number_active'=>'',
                    'license_number_is_linked'=>'',
                    'license_number_text'=>'',
                    'license_number_link'=> ''
                );
                $this->insert('bottom_links' ,$bottom_links);
                $contact_options  = array(
                    'client_id'=> $client_id,
                    'leadpop_id'=>  $trialDefaults["leadpop_id"],
                    'leadpop_type_id'=>  $this->leadpoptype,
                    'leadpop_vertical_id'=>   $trialDefaults["leadpop_vertical_id"],
                    'leadpop_vertical_sub_id'=> $trialDefaults["leadpop_vertical_sub_id"],
                    'leadpop_template_id' => $trialDefaults['leadpop_template_id'],
                    'leadpop_version_id'=> $trialDefaults["leadpop_version_id"],
                    'leadpop_version_seq'=>   $trialDefaults["leadpop_version_seq"],
                    'companyname'=> addslashes($client ['company_name']),
                    'phonenumber'=> 'Call Today! ' . $client ['phone_number'],
                    'email'=>  $client ['contact_email'],
                    'companyname_active'=> 'n',
                    'phonenumber_active'=>   'y',
                    'email_active'=> 'n'
                );
                $this->insert('contact_options' ,$contact_options);

                //add review bar
                $trustpilot_reviewbar  = array(
                    'client_id'=> $client_id,
                    'leadpop_id'=>  $trialDefaults["leadpop_id"],
                    'leadpop_type_id'=>  $this->leadpoptype,
                    'leadpop_vertical_id'=>   $trialDefaults["leadpop_vertical_id"],
                    'leadpop_vertical_sub_id'=> $trialDefaults["leadpop_vertical_sub_id"],
                    'leadpop_template_id' => $trialDefaults['leadpop_template_id'],
                    'leadpop_version_id'=> $trialDefaults["leadpop_version_id"],
                    'leadpop_version_seq'=>   $trialDefaults["leadpop_version_seq"],
                    'bar_active'=> 'n',
                    'bar_text'=> 'What Our Customers Say:',
                    'bar_score'=>  '',
                    'bar_reviews'=> ''
                );
                $this->insert('trustpilot_reviewbar' ,$trustpilot_reviewbar);

                $autotext = $this->getAutoResponderText ( $trialDefaults["leadpop_vertical_id"], $trialDefaults["leadpop_vertical_sub_id"] , $trialDefaults["leadpop_id"]);
                if ($autotext == "not found") {
                    $thehtml =  "";
                    $thesubject = "";
                }
                else {
                    $thehtml =  $autotext[0]["html"];
                    $thesubject = $autotext[0]["subject_line"];
                }
                $autoresponder_options  = array(
                    'client_id'=> $client_id,
                    'leadpop_id'=>  $trialDefaults["leadpop_id"],
                    'leadpop_type_id'=>  $this->leadpoptype,
                    'leadpop_vertical_id'=>   $trialDefaults["leadpop_vertical_id"],
                    'leadpop_vertical_sub_id'=> $trialDefaults["leadpop_vertical_sub_id"],
                    'leadpop_template_id' => $trialDefaults['leadpop_template_id'],
                    'leadpop_version_id'=> $trialDefaults["leadpop_version_id"],
                    'leadpop_version_seq'=>   $trialDefaults["leadpop_version_seq"],
                    'html'=> addslashes($thehtml),
                    'thetext'=> '',
                    'html_active'=>  'y',
                    'text_active'=> 'n',
                    'subject_line'=>  addslashes($thesubject)
                );
                $this->insert('autoresponder_options' ,$autoresponder_options);

                try {
                    $this->db->query ($s);
                }
                catch ( PDOException $e) {
                    print ("Error!: " . $e->getMessage() . "<br/>") ;
                    print($s);
                    die();
                }

                $title_tag =  " FREE " . $trialDefaults["display_name"] . " | " . addslashes ( ucwords($client['company_name']) );
                //FREE Home Purchase Qualifier | Sentinel Mortgage Company
                $seo_options  = array(
                    'client_id'=> $client_id,
                    'leadpop_id'=>  $trialDefaults["leadpop_id"],
                    'leadpop_type_id'=>  $this->leadpoptype,
                    'leadpop_vertical_id'=>   $trialDefaults["leadpop_vertical_id"],
                    'leadpop_vertical_sub_id'=> $trialDefaults["leadpop_vertical_sub_id"],
                    'leadpop_template_id' => $trialDefaults['leadpop_template_id'],
                    'leadpop_version_id'=> $trialDefaults["leadpop_version_id"],
                    'leadpop_version_seq'=>   $trialDefaults["leadpop_version_seq"],
                    'titletag'=>  addslashes($title_tag),
                    'description'=> '',
                    'metatags'=>  '',
                    'titletag_active'=> 'y',
                    'description_active'=> 'n',
                    'metatags_active' => 'n'
                );
                $this->insert('seo_options' ,$seo_options);

                $s = "select * from leadpops_verticals where id = " . $trialDefaults[0]["leadpop_vertical_id"];
                $vertres = $this->db->fetchRow ( $s );
                $verticalName = $vertres ['lead_pop_vertical'];

                if (isset ($trialDefaults["leadpop_vertical_sub_id"] ) && $trialDefaults["leadpop_vertical_sub_id"] != "") {
                    $s = "select * from leadpops_verticals_sub where leadpop_vertical_id  = " . $trialDefaults["leadpop_vertical_id"];
                    $s .= " and id = " . $trialDefaults["leadpop_vertical_sub_id"];
                    $subvertres = $this->db->fetchRow ( $s );
                    $subverticalName = $subvertres ['lead_pop_vertical_sub'];
                } else {
                    $subverticalName = "";
                }

                $logosrc = "";
                $imgsrc = "";
                $uploadedLogo = $logo;

                if ($subverticalName == "") {
                    $logosrc = $this->getHttpServer () . '/images/' . strtolower(str_replace(" ","",$verticalName)) . '/' . $logo_name;
                } else {
                    $logosrc = $this->getHttpServer () . '/images/' . strtolower(str_replace(" ","",$verticalName)) . '/' . strtolower(str_replace(" ","",$subverticalName)). '_logos/' . $logo_name;
                }
                $this->insertDefaultClientUploadLogo($logosrc,$trialDefaults,$client_id);
                $imgsrc = $this->insertClientDefaultEnterpriseImage($trialDefaults,$image_name,$client_id);

                $nine = "999999";
                $submissionText = $this->getSubmissionText($trialDefaults["leadpop_id"],$trialDefaults["leadpop_vertical_id"],$trialDefaults["leadpop_vertical_sub_id"],$nine);
                $submissionText = str_replace("##clientlogo##",$logosrc,$submissionText);
                $submissionText = str_replace("##clientphonenumber##",$phone,$submissionText);
                $submission_options  = array(
                    'client_id'=> $client_id,
                    'leadpop_id'=>  $trialDefaults["leadpop_id"],
                    'leadpop_type_id'=> $this->leadpoptype,
                    'leadpop_vertical_id'=>   $trialDefaults["leadpop_vertical_id"],
                    'leadpop_vertical_sub_id'=> $trialDefaults["leadpop_vertical_sub_id"],
                    'leadpop_template_id' => $trialDefaults['leadpop_template_id'],
                    'leadpop_version_id'=> $trialDefaults["leadpop_version_id"],
                    'leadpop_version_seq'=>   $trialDefaults["leadpop_version_seq"],
                    'thankyou'=>  addslashes($submissionText),
                    'information'=> '',
                    'thirdparty'=>  '',
                    'thankyou_active'=> 'y',
                    'information_active'=> 'n',
                    'thirdparty_active' => 'n'
                );
                $this->insert('submission_options' ,$submission_options);
            }
        }

        $this->addPlaceholder($trialDefaults, $logosrc, $imgsrc, $client);
        /*
                                 * old leadpops_templates_placeholders_info functionality remove from @mzac90
                                 */

        $s = "update add_client_funnels  set has_run = 'y' ";
        $this->db->query($s);
    }
    /* end new enterprise function */

    /* connect to local leadpops */
    function findIt($string, $sub_strings)
    {
        foreach ($sub_strings as $substr) {
            if (strpos($string, $substr) !== FALSE) {
                return TRUE; // at least one of the needle strings are substring of heystack, $string
            }
        }

        return FALSE; // no sub_strings is substring of $string.
    }

    function isValidEmail($email)
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }

    function insertDefaultEnterpriseAutoResponders($client_id, $trialDefaults, $email, $phone)
    {

        // insert primary client
        $lp_auto_recipients  = array(
            'client_id'=> $client_id,
            'leadpop_id'=>  $trialDefaults["leadpop_id"],
            'leadpop_type_id'=>   $trialDefaults["leadpop_type_id"],
            'leadpop_vertical_id'=>   $trialDefaults["leadpop_vertical_id"],
            'leadpop_vertical_sub_id'=> $trialDefaults["leadpop_vertical_sub_id"],
            'leadpop_template_id' => $trialDefaults['leadpop_template_id'],
            'leadpop_version_id'=> $trialDefaults["leadpop_version_id"],
            'leadpop_version_seq'=>   $trialDefaults["leadpop_version_seq"],
            'email_address'=> $email,
            'is_primary'=> 'y'
        );
        $lastId =  $this->insert('lp_auto_recipients' ,$lp_auto_recipients);
        $lp_auto_text_recipients  = array(
            'client_id'=> $client_id,
            'lp_auto_recipients_id' => $lastId,
            'leadpop_id'=>  $trialDefaults["leadpop_id"],
            'leadpop_type_id'=>   $trialDefaults["leadpop_type_id"],
            'leadpop_vertical_id'=>   $trialDefaults["leadpop_vertical_id"],
            'leadpop_vertical_sub_id'=> $trialDefaults["leadpop_vertical_sub_id"],
            'leadpop_template_id' => $trialDefaults['leadpop_template_id'],
            'leadpop_version_id'=> $trialDefaults["leadpop_version_id"],
            'leadpop_version_seq'=>   $trialDefaults["leadpop_version_seq"],
            'phone_number'=> $phone,
            'carrier'=> 'none',
            'is_primary' =>'y'
        );
        $this->insert('lp_auto_text_recipients' ,$lp_auto_text_recipients);

    }

    function insertDefaultAutoResponders($client_id, $trialDefaults, $emailaddress, $phonenumber)
    {
        // insert primary client
        $lp_auto_recipients  = array(
            'client_id'=> $client_id,
            'leadpop_id'=>  $trialDefaults["leadpop_id"],
            'leadpop_type_id'=>   $trialDefaults["leadpop_type_id"],
            'leadpop_vertical_id'=>   $trialDefaults["leadpop_vertical_id"],
            'leadpop_vertical_sub_id'=> $trialDefaults["leadpop_vertical_sub_id"],
            'leadpop_template_id' => $trialDefaults['leadpop_template_id'],
            'leadpop_version_id'=> $trialDefaults["leadpop_version_id"],
            'leadpop_version_seq'=>   $trialDefaults["leadpop_version_seq"],
            'email_address'=> $emailaddress,
            'is_primary'=> 'y'
        );
        $lastId =  $this->insert('lp_auto_recipients' ,$lp_auto_recipients);
        $lp_auto_text_recipients  = array(
            'client_id'=> $client_id,
            'lp_auto_recipients_id' => $lastId,
            'leadpop_id'=>  $trialDefaults["leadpop_id"],
            'leadpop_type_id'=>   $trialDefaults["leadpop_type_id"],
            'leadpop_vertical_id'=>   $trialDefaults["leadpop_vertical_id"],
            'leadpop_vertical_sub_id'=> $trialDefaults["leadpop_vertical_sub_id"],
            'leadpop_template_id' => $trialDefaults['leadpop_template_id'],
            'leadpop_version_id'=> $trialDefaults["leadpop_version_id"],
            'leadpop_version_seq'=>   $trialDefaults["leadpop_version_seq"],
            'phone_number'=> $phonenumber,
            'carrier'=> 'none',
            'is_primary' =>'y'
        );
        $this->insert('lp_auto_text_recipients' ,$lp_auto_text_recipients);

    }

    function insertClientDefaultEnterpriseImage($trialDefaults, $image_name, $client_id)
    {

        $use_default = 'n';
        $use_me = 'y';

        $imagename = strtolower($client_id . "_" . $trialDefaults["leadpop_id"] . "_1_" . $trialDefaults["leadpop_vertical_id"] . "_" . $trialDefaults["leadpop_vertical_sub_id"] . "_" . $trialDefaults['leadpop_template_id'] . "_" . $trialDefaults["leadpop_version_id"] . "_" . $trialDefaults["leadpop_version_seq"] . "_" . $image_name);
        $cmd = '/bin/cp  /var/www/vhosts/launch-mortgage.leadpops.com/trial/classicimages/' . $image_name . '  /var/www/vhosts/itclix.com/images/clients/' . substr($client_id, 0, 1) . '/' . $client_id . '/pics/' . $imagename;
        exec($cmd);
        //$ssh->exec($cmd);
        $cmd = '/bin/cp  /var/www/vhosts/launch-mortgage.leadpops.com/trial/classicimages/' . $image_name . '  /var/www/vhosts/myleads.leadpops.com/images/clients/' . substr($client_id, 0, 1) . '/' . $client_id . '/pics/' . $imagename;
        //$ssh->exec($cmd);
        exec($cmd);
        $leadpop_images  = array(
            'client_id'=> $client_id,
            'leadpop_id'=>  $trialDefaults["leadpop_id"],
            'leadpop_type_id'=>   1,
            'leadpop_vertical_id'=>   $trialDefaults["leadpop_vertical_id"],
            'leadpop_vertical_sub_id'=> $trialDefaults["leadpop_vertical_sub_id"],
            'leadpop_template_id' => $trialDefaults['leadpop_template_id'],
            'leadpop_version_id'=> $trialDefaults["leadpop_version_id"],
            'leadpop_version_seq'=>   $trialDefaults["leadpop_version_seq"],
            'use_default'=> $use_default,
            'image_src'=> $imagename,
            'use_me' =>$use_me,
            'numpics' => 1
        );
        $this->insert('leadpop_images' ,$leadpop_images);
        $img = $this->getHttpServer() . '/images/clients/' . substr($client_id, 0, 1) . '/' . $client_id . '/pics/' . $imagename;
        return $img;
    }

    function insertClientNotDefaultImage($trialDefaults, $client_id, $origleadpop_id, $origleadpop_type_id, $origvertical_id, $origsubvertical_id,
                                         $origleadpop_template_id, $origleadpop_version_id, $origleadpop_version_seq)
    {

        $section = substr($client_id,0,1);

        $s = "select image_src from  leadpop_images where client_id = " . $client_id;
        $s .= " and leadpop_id = " . $origleadpop_id;
        $s .= " and leadpop_type_id = " . $origleadpop_type_id;
        $s .= " and leadpop_vertical_id = " . $origvertical_id;
        $s .= " and leadpop_vertical_sub_id = " . $origsubvertical_id;
        $s .= " and leadpop_template_id = " . $origleadpop_template_id;
        $s .= " and leadpop_version_id = " . $origleadpop_version_id;
        $s .= " and leadpop_version_seq = " . $origleadpop_version_seq;
        $s .= " and use_default = 'n' and use_me = 'y' limit 1 ";

        $res = $this->db->fetchRow($s);
        if ($res) { // using an uploaded image
            $image = end(explode("_", $res['image_src']));
            $imagename = strtolower($client_id . "_" . $trialDefaults["leadpop_id"] . "_1_" . $trialDefaults["leadpop_vertical_id"] . "_" . $trialDefaults["leadpop_vertical_sub_id"] . "_" . $trialDefaults['leadpop_template_id'] . "_" . $trialDefaults["leadpop_version_id"] . "_" . $trialDefaults["leadpop_version_seq"] . "_" . $image);
            $leadpop_images  = array(
                'client_id'=> $client_id,
                'leadpop_id'=>  $trialDefaults["leadpop_id"],
                'leadpop_type_id'=>   1,
                'leadpop_vertical_id'=>   $trialDefaults["leadpop_vertical_id"],
                'leadpop_vertical_sub_id'=> $trialDefaults["leadpop_vertical_sub_id"],
                'leadpop_template_id' => $trialDefaults['leadpop_template_id'],
                'leadpop_version_id'=> $trialDefaults["leadpop_version_id"],
                'leadpop_version_seq'=>   $trialDefaults["leadpop_version_seq"],
                'use_default'=> 'n',
                'image_src'=> $imagename,
                'use_me' => 'y',
                'numpics' => 1
            );
            $this->insert('leadpop_images' ,$leadpop_images);
            $this->file_list[] = array(
                'server_file' =>   $this->getRackspaceUrl ('image_path','clients-assets').$section . '/' . $client_id. '/pics/'.$res['image_src'],
                'container' => 'clients',
                'rackspace_path' => 'images1/'.$section. '/' . $client_id . '/pics/' . $imagename
            );

        } else {
            $imagename = strtolower($client_id . "_" . $trialDefaults["leadpop_id"] . "_1_" . $trialDefaults["leadpop_vertical_id"] . "_" . $trialDefaults["leadpop_vertical_sub_id"] . "_" . $trialDefaults['leadpop_template_id'] . "_" . $trialDefaults["leadpop_version_id"] . "_" . $trialDefaults["leadpop_version_seq"] . "_" . $trialDefaults['image_name']);
            $leadpop_images  = array(
                'client_id'=> $client_id,
                'leadpop_id'=>  $trialDefaults["leadpop_id"],
                'leadpop_type_id'=>   1,
                'leadpop_vertical_id'=>   $trialDefaults["leadpop_vertical_id"],
                'leadpop_vertical_sub_id'=> $trialDefaults["leadpop_vertical_sub_id"],
                'leadpop_template_id' => $trialDefaults['leadpop_template_id'],
                'leadpop_version_id'=> $trialDefaults["leadpop_version_id"],
                'leadpop_version_seq'=>   $trialDefaults["leadpop_version_seq"],
                'use_default'=> 'y',
                'image_src'=> $imagename,
                'use_me' =>'n',
                'numpics' => 1
            );
            $this->insert('leadpop_images' ,$leadpop_images);
            $this->file_list[] = array(
                'server_file' =>    $this->getRackspaceUrl ('image_path', 'default-assets') . 'stockimages/classicimages/'.$trialDefaults['image_name'],
                'container' => 'clients',
                'rackspace_path' => 'images1/'.$section. '/' . $client_id . '/pics/' . $imagename
            );
        }

        $img = $this->getRackspaceUrl ('image_path','clients-assets').$section . '/' . $client_id. '/pics/'. $imagename;
        return $img;
    }

    function insertClientDefaultImage($trialDefaults, $client_id)
    {

        $use_default = 'n';
        $use_me = 'y';
        $imagename =  $trialDefaults['image_name'];
        //don't need to copy default image therefore, remove the code from @mzac90
        $leadpop_images  = array(
            'client_id'=> $client_id,
            'leadpop_id'=>  $trialDefaults["leadpop_id"],
            'leadpop_type_id'=>   1,
            'leadpop_vertical_id'=>   $trialDefaults["leadpop_vertical_id"],
            'leadpop_vertical_sub_id'=> $trialDefaults["leadpop_vertical_sub_id"],
            'leadpop_template_id' => $trialDefaults['leadpop_template_id'],
            'leadpop_version_id'=> $trialDefaults["leadpop_version_id"],
            'leadpop_version_seq'=>   $trialDefaults["leadpop_version_seq"],
            'use_default'=> $use_default,
            'image_src'=> $imagename,
            'use_me' => $use_me,
            'numpics' => 1
        );
        $this->insert('leadpop_images' ,$leadpop_images);
        $img =  $this->getRackspaceUrl ('image_path', 'default-assets') . 'stockimages/classicimages/' .$imagename ;
        return $img;
    }

    function insertDefaultClientUploadLogo($logosrc, $trialDefaults, $client_id){
        $numpics = 0;
        $usedefault = 'y';

        /*
        $s = "insert into leadpop_logos (id,client_id,leadpop_id,leadpop_type_id,";
        $s .= "leadpop_vertical_id,leadpop_vertical_sub_id,leadpop_template_id,";
        $s .= "leadpop_version_id,leadpop_version_seq,use_default,";
        $s .= "logo_src,use_me,numpics) values (null,";
        $s .= $client_id . "," . $trialDefaults["leadpop_id"] . ",1," . $trialDefaults["leadpop_vertical_id"] . "," . $trialDefaults["leadpop_vertical_sub_id"] . ",";
        $s .= $trialDefaults['leadpop_template_id'] . "," . $trialDefaults["leadpop_version_id"] . "," . $trialDefaults["leadpop_version_seq"] . ",";
        $s .= "'" . $usedefault . "','" . $logosrc . "','n'," . $numpics . ") ";
        $this->db->query($s);
        */

        $leadpop_logos  = array(
            'client_id'=> $client_id,
            'leadpop_id'=>  $trialDefaults["leadpop_id"],
            'leadpop_type_id'=>   1,
            'leadpop_vertical_id'=>   $trialDefaults["leadpop_vertical_id"],
            'leadpop_vertical_sub_id'=> $trialDefaults["leadpop_vertical_sub_id"],
            'leadpop_template_id' => $trialDefaults['leadpop_template_id'],
            'leadpop_version_id'=> $trialDefaults["leadpop_version_id"],
            'leadpop_version_seq'=>   $trialDefaults["leadpop_version_seq"],
            'use_default'=> $usedefault,
            'logo_src'=> $logosrc,
            'use_me' => 'n',
            'numpics' => $numpics
        );
        $this->insert('leadpop_logos' ,$leadpop_logos);

        $current_logo  = array(
            'client_id'=> $client_id,
            'leadpop_id'=>  $trialDefaults["leadpop_id"],
            'leadpop_type_id'=>   1,
            'leadpop_vertical_id'=>   $trialDefaults["leadpop_vertical_id"],
            'leadpop_vertical_sub_id'=> $trialDefaults["leadpop_vertical_sub_id"],
            'leadpop_template_id' => $trialDefaults['leadpop_template_id'],
            'leadpop_version_id'=> $trialDefaults["leadpop_version_id"],
            'leadpop_version_seq'=>   $trialDefaults["leadpop_version_seq"],
            'logo_src'=> $logosrc
        );
        $this->insert('current_logo' ,$current_logo);
    }

    function newinsertClientUploadLogo($logoname, $trialDefaults, $client_id)
    {

        $numpics = 1;
        $usedefault = 'n';
        $section =  substr($client_id, 0, 1);
        $leadpop_logos  = array(
            'client_id'=> $client_id,
            'leadpop_id'=>  $trialDefaults["leadpop_id"],
            'leadpop_type_id'=>   1,
            'leadpop_vertical_id'=>   $trialDefaults["leadpop_vertical_id"],
            'leadpop_vertical_sub_id'=> $trialDefaults["leadpop_vertical_sub_id"],
            'leadpop_template_id' => $trialDefaults['leadpop_template_id'],
            'leadpop_version_id'=> $trialDefaults["leadpop_version_id"],
            'leadpop_version_seq'=>   $trialDefaults["leadpop_version_seq"],
            'use_default'=> $usedefault,
            'logo_src'=> $logoname,
            'use_me' => 'y',
            'numpics' => $numpics
        );
        $this->insert('leadpop_logos' ,$leadpop_logos);
        $current_logo  = array(
            'client_id'=> $client_id,
            'leadpop_id'=>  $trialDefaults["leadpop_id"],
            'leadpop_type_id'=>   1,
            'leadpop_vertical_id'=>   $trialDefaults["leadpop_vertical_id"],
            'leadpop_vertical_sub_id'=> $trialDefaults["leadpop_vertical_sub_id"],
            'leadpop_template_id' => $trialDefaults['leadpop_template_id'],
            'leadpop_version_id'=> $trialDefaults["leadpop_version_id"],
            'leadpop_version_seq'=>   $trialDefaults["leadpop_version_seq"],
            'logo_src'=> $logoname
        );
        $this->insert('current_logo' ,$current_logo);
        $logosrc = $this->getRackspaceUrl ('image_path','clients-assets').$section . '/' . $client_id. '/logos/'.$logoname;
        return $logosrc;
    }

    function insertClientUploadLogo($uploadedLogo, $trialDefaults, $client_id)
    {
        $numpics = 1;
        $usedefault = 'n';

        $logoname = strtolower($client_id . "_" . $trialDefaults["leadpop_id"] . "_1_" . $trialDefaults["leadpop_vertical_id"] . "_" . $trialDefaults["leadpop_vertical_sub_id"] . "_" . $trialDefaults['leadpop_template_id'] . "_" . $trialDefaults["leadpop_version_id"] . "_" . $trialDefaults["leadpop_version_seq"] . "_" . $uploadedLogo);
        $leadpop_logos  = array(
            'client_id'=> $client_id,
            'leadpop_id'=>  $trialDefaults["leadpop_id"],
            'leadpop_type_id'=>   1,
            'leadpop_vertical_id'=>   $trialDefaults["leadpop_vertical_id"],
            'leadpop_vertical_sub_id'=> $trialDefaults["leadpop_vertical_sub_id"],
            'leadpop_template_id' => $trialDefaults['leadpop_template_id'],
            'leadpop_version_id'=> $trialDefaults["leadpop_version_id"],
            'leadpop_version_seq'=>   $trialDefaults["leadpop_version_seq"],
            'use_default'=> $usedefault,
            'logo_src'=> $logoname,
            'use_me' => 'y',
            'numpics' => $numpics
        );
        $this->insert('leadpop_logos' ,$leadpop_logos);

        $current_logo  = array(
            'client_id'=> $client_id,
            'leadpop_id'=>  $trialDefaults["leadpop_id"],
            'leadpop_type_id'=>   1,
            'leadpop_vertical_id'=>   $trialDefaults["leadpop_vertical_id"],
            'leadpop_vertical_sub_id'=> $trialDefaults["leadpop_vertical_sub_id"],
            'leadpop_template_id' => $trialDefaults['leadpop_template_id'],
            'leadpop_version_id'=> $trialDefaults["leadpop_version_id"],
            'leadpop_version_seq'=>   $trialDefaults["leadpop_version_seq"],
            'logo_src'=> $logoname
        );
        $this->insert('current_logo' ,$current_logo);
    }

    function getAutoResponderText($vertical_id, $subvertical_id, $leadpop_id)
    {

        $s = "select html,subject_line from autoresponder_defaults where  ";
        $s .= " leadpop_id = " . $leadpop_id;
        $s .= " and leadpop_vertical_id = " . $vertical_id;
        $s .= " and leadpop_vertical_sub_id = " . $subvertical_id . " limit 1 ";
        $res = $this->db->fetchAll($s);
        if ($res) {
            return $res;
        } else {
            return "not found";
        }
    }

    function getSubmissionText($leadpop_id, $vertical_id, $subvertical_id, $niners = "888888")
    {

        if ($niners == "999999") {
            $s = "select html from thankyou_defaults where  ";
            $s .= " leadpop_id = 999999 limit 1";
            $res = $this->db->fetchRow($s);
        } else {
            $s = "select html from thankyou_defaults where  ";
            $s .= " leadpop_id = " . $leadpop_id;
            $s .= " and leadpop_vertical_id = " . $vertical_id;
            $s .= " and leadpop_vertical_sub_id = " . $subvertical_id . " limit 1 ";
            $res = $this->db->fetchRow($s);
        }
        return $res["html"];
    }

    function insertPurchasedGoogle($client_id, $googleDomain)
    {

        // package id does not now affect google analytics so put 2 for all
        $dt = date('Y-m-d H:i:s');
        $purchased_google_analytics  = array(
            'client_id'=> $client_id,
            'purchased'=>  'y',
            'google_key'=>   '',
            'thedate'=>  $dt,
            'domain'=> $googleDomain,
            'active' =>  'n',
            'package_id'=> 2
        );
        $this->insert('purchased_google_analytics' ,$purchased_google_analytics);
    }

    function getRandomCharacter()
    {
        $chars = "abcdefghijkmnopqrstuvwxyz";
        srand(( double )microtime() * 1000000);
        $i = 0;
        $char = '';
        while ($i <= 1) {
            $num = rand() % 33;
            $tmp = substr($chars, $num, 1);
            $char = $char . $tmp;
            $i++;
        }
        return $char;
    }

    function encrypt($string)
    {
        $key = "petebird";
        $string = base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, md5($key), $string, MCRYPT_MODE_CBC, md5(md5($key))));
        return $string;
    }

    function decrypt($string)
    {
        $key = "petebird";
        $string = rtrim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, md5($key), base64_decode($string), MCRYPT_MODE_CBC, md5(md5($key))), "\0");
        return $string;
    }

    function generateRandomString($length = 5)
    {
        return substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, $length);
    }

    function checkIfNeedMultipleStepInsert($leadpop_description_id, $client_id)
    {
        $s = "select * from leadpop_multiple where leadpop_description_id = " . $leadpop_description_id . " limit 1 ";
        $res = $this->db->fetchRow($s);
        if ($res) {
            $array = array(
                'client_id'=> $client_id,
                'leadpop_description_id'=>$res['leadpop_description_id'],
                'leadpop_id'=>$res['leadpop_id'],
                'leadpop_template_id'=> $res['leadpop_template_id'],
                'stepone'=>$res['stepone'],
                'steptwo'=> $res['steptwo'],
                'stepthree'=> $res['stepthree'],
                'stepfour'=>$res['stepfour'],
                'stepfiv'=>$res['stepfive']
            );
            $this->insert('leadpop_multiple_step' ,$array);
        }
    }

    function getMobileImageDimensions($w, $h)
    {
        if ($w <= 320 && $h <= 71) {
            return $w . "~" . $h;
        } else { // must resize
            $ratio = ($w / $h);
            //die($ratio);
            // 1309/718
            do {
                $w -= $ratio;
                $h -= 1;
            } while ($w > 320 || $h > 71);
            return $w . "~" . $h;
        }
    }

    function resizeImage($CurWidth, $CurHeight, $DestFolder, $SrcImage, $Quality, $ImageType, $resize, $TempSrc)
    {

        if ($CurWidth <= 0 || $CurHeight <= 0) {
            return false;
        }

        if ($resize) {
//			320 X 70

            $dimensions = explode("~",$this-> getMobileImageDimensions($CurWidth, $CurHeight));
            $NewWidth = $dimensions[0];
            $NewHeight = $dimensions[1];
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
            try {
                imagecopyresampled($NewCanves, $SrcImage, 0, 0, 0, 0, $NewWidth, $NewHeight, $CurWidth, $CurHeight);
            } catch (Exception $e) {
                die(' imagecopyresampled : ' . $e->getMessage());
            }
            try {
                imagepng($NewCanves, $DestFolder);
            } catch (Exception $e) {
                die(' imagepng: ' . $e->getMessage());
            }

        } else {
            $cmd = '/bin/cp  ' . $TempSrc . '  ' . $DestFolder;
            exec($cmd);
        }

    }

    function colorizeBasedOnAplhaChannnel($file, $targetR, $targetG, $targetB, $targetName)
    {

        if (file_exists($targetName)) {
            unlink($targetName);
        }

        $im_src = imagecreatefrompng($file);
        $width = imagesx($im_src);
        $height = imagesy($im_src);

        $im_dst = imagecreatefrompng($file);

        imagealphablending($im_dst, false);
        imagesavealpha($im_dst, true);
        imagealphablending($im_src, false);
        imagesavealpha($im_src, true);
        imagefilledrectangle($im_dst, 0, 0, $width, $height, '0xFFFFFF');

        for ($x = 0; $x < $width; $x++) {
            for ($y = 0; $y < $height; $y++) {

                $alpha = (imagecolorat($im_src, $x, $y) >> 24 & 0xFF);
                $col = imagecolorallocatealpha($im_dst,
                    $targetR - (int)(1.0 / 255.0 * $alpha * (double)$targetR),
                    $targetG - (int)(1.0 / 255.0 * $alpha * (double)$targetG),
                    $targetB - (int)(1.0 / 255.0 * $alpha * (double)$targetB),
                    $alpha
                );
                if (false === $col) {
                    die('sorry, out of colors...');
                }
                imagesetpixel($im_dst, $x, $y, $col);
            }

        }
        imagepng($im_dst, $targetName);
        imagedestroy($im_dst);
    }

    function getRackspaceUrl($key, $cdn_type="default-assets"){
        if($cdn_type=="default-assets"){
            $s =  "select $key from current_container_image_path where cdn_type = '".$cdn_type."' limit 1 ";
        }else{
            $s =  "select $key from current_container_image_path where cdn_type = '".$cdn_type."' and signup_active = 1 limit 1 ";
        }
        $url = $this->db->fetchRow($s);
        return $url[$key];
    }

    function hex2rgb($hex)
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

    function addPlaceholder($trialDefaults, $logosrc, $imgsrc, $client)
    {
        $keepJson = array("front_image", "logo_src", "my_company_name", "my_company_phone", "my_company_email", "font_family", "font_family_desc", "logo_color", "colored_dot", "favicon_dst", "companyname_label", "mvp_dot", "mvp_check", "metatag_option", "titletag_option", "description_option");
        $jsonArr = array();

        $s = "SELECT * FROM current_container_image_path WHERE cdn_type = 'default-assets'";
        $defaultCdn = $this->db->fetchRow($s);
        $cdn = $defaultCdn['image_path'] . 'stockimages/classicimages/';
        //$template_info removed because we are not using placeholder right now @mzac90

        $lead_line = '<span style="font-family: ' . $trialDefaults["main_message_font"] . '; font-size: ' . $trialDefaults["main_message_font_size"] . '; color: ' . ($this->globallogo_color == "" ? $trialDefaults["mainmessage_color"] : $this->globallogo_color) . '">' . $trialDefaults["main_message"] . '</span>';
        $second_line = '<span style="font-family: ' . $trialDefaults["description_font"] . '; font-size: ' . $trialDefaults["description_font_size"] . '; color: ' . $trialDefaults["description_color"] . '">' . $trialDefaults["description"] . '</span>';

        #$jsonArr['my_company_name'] = "";
        #$jsonArr['my_company_phone'] = "";
        #$jsonArr['my_company_email'] = "";
        #$jsonArr['companyname_label'] = "";

        $jsonArr['front_image'] = $cdn . $trialDefaults["image_name"];
        $jsonArr['logo_src'] = str_replace(" ", "", $logosrc);
        $jsonArr['logo_color'] = $this->getLogoColor();
        $jsonArr['colored_dot'] = $this->getDot();
        $jsonArr['favicon_dst'] = $this->getFavicon();
        $jsonArr['mvp_dot'] = $this->getRing();
        $jsonArr['mvp_check'] = $this->getCheck();
        $jsonArr['my_company_name'] = ucwords(strtolower($client['company_name']));
        $jsonArr['my_company_phone'] = "Call Today! " . str_replace(")-", ") ", $client['phone_number']);
        $jsonArr['my_company_email'] = $client['contact_email'];
        $jsonArr['font_family'] = $trialDefaults["main_message_font"];
        $jsonArr['font_family_desc'] = $trialDefaults["description_font"];
        $jsonArr['version_number'] = $trialDefaults["leadpop_version_id"];
        $jsonArr['the_vertical'] = ucfirst($trialDefaults["vertical_name"]);
        $jsonArr['subvertical_name'] = ucfirst($trialDefaults["subvertical_name"]);
        $jsonArr['titletag_option'] = " FREE " . $trialDefaults["display_name"] . " | " . addslashes(ucwords($client ['company_name']));
        $jsonArr['description_option'] = "";
        $jsonArr['metatag_option'] = "";

        //add in the current rackspace cdn
        $jsonArr["cdn"] = $this->getRackspaceUrl('image_path', 'clients-assets');
        $json = json_encode($jsonArr);

        $s = "UPDATE clients_leadpops SET ";
        $s .= "funnel_variables = '" . addslashes($json) . "', lead_line =  '" . addslashes($lead_line) . "', ";
        $s .= "second_line_more = '" . addslashes($second_line) . "' ";
        $s .= " where client_id = " . $client["client_id"];
        $s .= " and leadpop_id = " . $trialDefaults["leadpop_id"];
        $s .= " and leadpop_version_id = " . $trialDefaults["leadpop_version_id"];
        $s .= " and leadpop_version_seq = " . $trialDefaults["leadpop_version_seq"];
        $this->db->query($s);

    }

    function setClientDefaultFaviconColor($trialDefaults)
    {
        $filename = "default-" . $trialDefaults["leadpop_vertical_id"] . "-" . $trialDefaults["leadpop_vertical_sub_id"] . "-" . $trialDefaults["leadpop_version_id"];
        $this->setFavicon($this->getRackspaceUrl('image_path') . "images/" . $filename . '-favicon-circle.png');
        $this->setDot($this->getRackspaceUrl('image_path') . 'images/' . $filename . '-dot_img.png');
        $this->setRing($this->getRackspaceUrl('image_path') . 'images/' . $filename . '-ring.png');
        $this->setCheck($this->getRackspaceUrl('image_path') . 'images/' . $filename . '-mvp-check.png');
    }

    //get all tag list
    function getTag($t,$client_id){
        $sql = "SELECT
            *
        FROM
            leadpops_tags
        WHERE
            tag_name = '".$t."'
            AND client_id  = '".$client_id."'";
        //Pause Logic to verify SQL
        return $this->db->fetchRow($sql);
        }

    //get all folder list
    function getFolder($folder_name,$client_id){
        $sql = "SELECT * FROM leadpops_client_folders WHERE folder_name = '".$folder_name."' AND client_id  = '".$client_id."'";
        return $this->db->fetchRow($sql);
    }

    //get tag mapping list against client_id , client_leadpop_id and tag_id
    function checkTagMaping($client_leadpop_id,$tag_id,$client_id){
        $sql = "SELECT
            *
        FROM
            leadpops_client_tags
        WHERE
            client_leadpop_id = '".$client_leadpop_id."'
            AND  leadpop_tag_id  = '".$tag_id."'
            AND client_id  = '".$client_id."'";
        return $this->db->fetchRow($sql);
    }

    //add sub vertical name or group name for tag in leadpops_tags table f exist otherwise get the tag id against sub vertical name or group name
    function assignTagToFunnel($client_leadpop_id,$trialDefaults,$client_id){
        $tag_name = $trialDefaults["tag"];
        $all_tag = explode(',',$tag_name);
        if($all_tag) {
            foreach ($all_tag as $v) {
                $rs = $this->getTag($v,$client_id);
                if(empty($rs)) {
                    $tag = array(
                        'client_id' => $client_id,
                        'tag_name' => $v,
                        'is_default' => 1
                    );
                    $tag_id = $this->db->insert('leadpops_tags', $tag);
                }else{
                    $rec = $rs;
                    $tag_id = $rec['id'];
                }
                $chk_tag = $this->checkTagMaping($client_leadpop_id,$tag_id,$client_id);
                if(empty($chk_tag)) {
                    $data = array(
                        'client_id' => $client_id,
                        'client_leadpop_id' => $client_leadpop_id,
                        'leadpop_tag_id' => $tag_id,
                        'leadpop_id' => $trialDefaults["leadpop_id"],
                        'client_tag_name' => $v,
                        'active' => 1
                    );
                    $this->db->insert('leadpops_client_tags', $data);
                }
            }
        }
    }
    //add vertical name for folder in leadpops_client_folders table if exist otherwise get the folder id against vertical name
    function addFolder($folder_name,$client_id){
        $s = $this->getFolder($folder_name,$client_id);
        if(empty($s)) {
            $data = array(
                'client_id' => $client_id,
                'folder_name' => ucfirst($folder_name),
                'is_default' => 1
            );
           $id =  $this->db->insert('leadpops_client_folders', $data);
            return $id;
        }else{
            $rec =  $s;
            return $rec['id'];
        }
    }

    function downloadRackspaceImage($image)
    {
        $info = parse_url($image);
        $file_name = str_replace("/~", "/", env('RACKSPACE_TMP_DIR', '') . "/" . str_replace("/", "~", $info['path']));
        if (file_exists($file_name)) {
            $local_file = $file_name;
        } else {
            /** @var \App\Services\RackspaceUploader $rackspace */
            $rackspace = \App::make('App\Services\RackspaceUploader');
            $local_file = $rackspace->getFile(substr($info['path'], 1), $this->registry->leadpops->clientInfo['rackspace_container'], 1);
        }
        return $local_file;
    }

    /**
     * create funnel
     */
    function createFunnel(){

        $s = "select * from add_client_funnels  where has_run = 'n' limit 1";
        $run = $this->db->fetchRow($s);

        $enterprise_verticals = array(7,3,2,6);
        $enterprise_subverticals = array(14,33,35,39,72,20,40,42,65,66,71,31);
        $enterprise_versions =      array(18,41,43,44,78,27,46,48,64,65,77,39);

        $nonenterprise_verticals = array(1,2,3,5,6,8);
        $nonenterprise_subverticals = array(1,2,3,4,5,6,7,8,10,11,15,44,45,46,47,48,
            49,50,51,52,53,54,55,56,57,58,59,12,13,17,60,61,62,63,64,67,68,69,18,30,70,73,
            74,75,76,77,78,79,80,81,82,83,84,85,86,87,88,89,90,91,92,93,94,95,96,97,98,99,
            100,101,102,103,104,105,106,107,108,109,110,111,112,113,114,115,116,117,118,119);
        $nonenterprise_versions = array(2,3,4,5,6,7,8,9,11,13,14,15,16,20,22,23,38,50,51,52,53,54,55,56,57,58,59,60,61,62,
            63,66,67,68,69,70,71,72,73,74,75,76,79,80,81,82,83,84,85,86,87,88,89,90,91,92,93,94,95,96,97,98,99,
            100,101,102,103,104,105,106,107,108,109,110,111,112,113,114,115,116,117,118,119,120,121,122,123,124,125);

        if ($run) {
            /*
            if (in_array($run["vertical_id"],$enterprise_verticals) && in_array($run["subvertical_id"],$enterprise_subverticals) && in_array($run["version_id"],$enterprise_versions)) { // wanting to add a genericic enter prise page to a client
                if ($run["client_id"] != "") {
                     # enterprise veritcal and subvertical are entered  and it is for a current client
                     # vertical, subvertical,version are present  and also client id it not blank
                    $this->addExistingClientGenericEnterprise($run["vertical_id"], $run["subvertical_id"], $run["version_id"],$run["client_id"]);
                }
                else if ($run["email"] != "" && $run["firstname"] != "" && $run["lastname"] != "" && $run["company"] != "" && $run["phone"] != "" && $run["client_id"] == "") {
                    #  new enterprise page  for new client
                    $this->addNewClientGenericEnterprise($run["vertical_id"], $run["subvertical_id"],$run["version_id"], $run["email"],$run["firstname"],$run["lastname"],$run["company"],$run["phone"]);
                }
                else {
                    die("not enough information");
                }
            }
            else
            */


            // trying to add whole non-enterprise vertical to existing client. ==> Has vertical id in input but not subvertical & version
            if (in_array($run["vertical_id"],$nonenterprise_verticals) && !in_array($run["subvertical_id"],$nonenterprise_subverticals) && !in_array($run["version_id"],$nonenterprise_versions) ) {
                $this->addNonEnterpriseVerticalToExistingClient(
                    $run["vertical_id"],
                    $run["subvertical_id"],
                    $run["version_id"],
                    $run["client_id"],
                    $run["logo"],
                    $run["mobilelogo"],
                    $run["origvertical_id"],
                    $run["origsubvertical_id"],
                    $run["origversion_id"],
                    $run["origleadpop_type_id"],
                    $run["origleadpop_template_id"],
                    $run["origleadpop_id"],
                    $run["origleadpop_version_id"],
                    $run["origleadpop_version_seq"]
                );
            }
            // if vertical & subvertical exist but version id is not then skip funnal creation
            else  if (in_array($run["vertical_id"],$nonenterprise_verticals) && in_array($run["subvertical_id"],$nonenterprise_subverticals) && !in_array($run["version_id"],$nonenterprise_versions) ) {
                die("dogs not allowed");
            }
            // To add Specific funnel in existing client
            else  if (in_array($run["vertical_id"],$nonenterprise_verticals) && in_array($run["subvertical_id"],$nonenterprise_subverticals) && in_array($run["version_id"],$nonenterprise_versions) ) {
                $this->addNonEnterpriseVerticalSubverticalVersionToExistingClient(
                    $run["vertical_id"],
                    $run["subvertical_id"],
                    $run["version_id"],
                    $run["client_id"],
                    $run["logo"],
                    $run["mobilelogo"],
                    $run["origvertical_id"],
                    $run["origsubvertical_id"],
                    $run["origversion_id"],
                    $run["origleadpop_type_id"],
                    $run["origleadpop_template_id"],
                    $run["origleadpop_id"],
                    $run["origleadpop_version_id"],
                    $run["origleadpop_version_seq"]
                );
            }
            else {
                die("not enough information");
            }
        }

    }

    function insert($table, array $data)
    {

        $q = "INSERT into  `" . $table . "` ";
        $k = '';
        $v = '';
        foreach ($data as $key => $val) {
            $k .= "`$key`,";
            $v .= "'" . $val . "',";
        }
        $q .= "(" . rtrim($k, ', ') . ") VALUES (" . rtrim($v, ', ') . ");";
        $this->db->query($q);
        echo $table.": ".$this->db->lastInsertId()."\r\n";
        return $this->db->lastInsertId();
    }
}
