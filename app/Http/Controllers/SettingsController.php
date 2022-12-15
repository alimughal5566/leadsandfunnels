<?php

namespace App\Http\Controllers;

use App\Constants\Layout_Partials;

use App\Constants\LP_Constants;
use App\Models\ClientFunnelSticky;
use App\Repositories\CustomizeRepository;
use App\Repositories\GlobalRepository;
use App\Repositories\LeadpopsRepository;
use App\Repositories\LpAdminRepository;
use App\Repositories\PixelRepository;
use App\Services\DataRegistry;
use App\Services\gm_process\MyLeadsEvents;
use App\Services\gm_process\ReportSqlHelper;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use LP_Helper;
use Session;
use View_Helper;

class SettingsController extends BaseController {

    private $Default_Model_Customize;
    private $Default_Model_Leadpops;
    private $Default_Model_Pixel;
    private $Default_Model_Global;
    public  $sb_third_party_ssl_flag=0;
    public $new_sticky_bar_url = '';
    public  $sb_third_party_html;
    protected static $leadpopDomainTypeId = 0;
    protected static $leadpopSubDomainTypeId = 0;
    private $_videolink="http://www.youtube.com/embed/W7qWa52k-nE";

    public function __construct(LpAdminRepository $lpAdmin, CustomizeRepository $customtizeRepo, LeadpopsRepository $leadpopsRepo, PixelRepository $pixelRepo, GlobalRepository $globalRepo){
        $this->middleware(function($request, $next) use ($lpAdmin, $customtizeRepo, $leadpopsRepo, $pixelRepo, $globalRepo) {
            self::$leadpopDomainTypeId = config('leadpops.leadpopDomainTypeId');
            self::$leadpopSubDomainTypeId = config('leadpops.leadpopSubDomainTypeId');

            $this->Default_Model_Customize = $customtizeRepo;
            $this->Default_Model_Leadpops = $leadpopsRepo;
            $this->Default_Model_Pixel = $pixelRepo;
            $this->Default_Model_Global = $globalRepo;
            $this->registry = DataRegistry::getInstance();
            $this->registry->_initProperties(Session::get('leadpops'));
            $this->init($lpAdmin);
            if($request->ajax()) $this->check_ajax_session(); else $this->check_session();
            return $next($request);
        });
    }

    private function setCommonDataForView($hash_data,$session){
        $customize = $this->Default_Model_Customize;
        $this->data->customVertical_id = $hash_data["funnel"]["leadpop_vertical_id"];
        $this->data->customSubvertical_id = $hash_data["funnel"]["leadpop_vertical_sub_id"];
        $this->data->customVertical = $hash_data["funnel"]["lead_pop_vertical"];
        $this->data->customSubvertical = $hash_data["funnel"]["lead_pop_vertical_sub"];
        $this->data->customLeadpopid = $hash_data["funnel"]["leadpop_id"];
        $this->data->customLeadpopVersionseq = $hash_data["funnel"]["leadpop_version_seq"];
        if(isset($session->popdescription))
            $this->data->popdescription = $session->popdescription;
        $this->data->lpkeys = $this->getLeadpopKey($hash_data);
        $this->data->client_id = $hash_data["funnel"]["client_id"];
        $this->data->workingLeadpop = $hash_data["funnel"]["domain_name"];
        $key = $hash_data["funnel"]["lead_pop_vertical"]."~".$hash_data["funnel"]["lead_pop_vertical_sub"]."~".$hash_data["funnel"]["leadpop_id"]."~".$hash_data["funnel"]["leadpop_version_seq"]."~".$hash_data["funnel"]["client_id"];
        $this->data->clickedkey = $this->data->lpkeys;
        if(isset($session->clickedkey))
            $this->data->clickedkey = $session->clickedkey;
        $this->data->clientName = ucfirst($session->clientInfo->first_name)." ".ucfirst($session->clientInfo->last_name);
        $this->data->groupname = $hash_data['funnel']['group_name'];
        $this->data->unlimitedDomains = $customize->checkUnlimitedDomains($hash_data["funnel"]["client_id"],$hash_data["funnel"]["leadpop_id"],$hash_data["funnel"]["leadpop_version_seq"]);
        $this->data->currenturl = LP_Helper::getInstance()->getCurrentUrl();
        $this->data->currenturlstatus = $customize->getLeadpopStatusV2($hash_data);
        $this->data->cloneLeadpop = $session->cloneLeadpop;
        $this->data->vertical_id = $hash_data["funnel"]["leadpop_vertical_id"];
        $this->data->subvertical_id = $hash_data["funnel"]["leadpop_vertical_sub_id"];
        $this->data->currenthash = $hash_data["current_hash"];
        // switch menu varible
        $enterprise = array(7); // this array determins if you switch the menu to exclude items because enterprise page.
        if (in_array($this->data->vertical_id,$enterprise)) {
            $this->data->switchmenu = 'y';
        }else{
            $this->data->switchmenu = 'n';
        }
        $this->data->currenthash = $hash_data["current_hash"];
        return;
    }


    public function domainAction() {
        LP_Helper::getInstance()->getCurrentHashData();
        if(LP_Helper::getInstance()->getCurrentHash()){
            $funnelData = LP_Helper::getInstance()->getFunnelData();
            $session = LP_Helper::getInstance()->getSession();

            $customize = $this->Default_Model_Customize;;
            $this->data->current_hash = LP_Helper::getInstance()->getCurrentHash();
            $this->data->leadpop_id = $funnelData['funnel']['leadpop_id'];
            $this->data->customVertical_id = $funnelData['funnel']['leadpop_vertical_id'];
            $this->data->customSubvertical_id = $funnelData['funnel']['leadpop_vertical_sub_id'];
            $this->data->customVertical = $funnelData['funnel']['lead_pop_vertical'];
            $this->data->customSubvertical = $funnelData['funnel']['lead_pop_vertical_sub'];
            $this->data->customLeadpopid = $funnelData['funnel']['leadpop_id'];
            $this->data->customLeadpopVersionseq = $funnelData['funnel']['leadpop_version_seq'];
            $this->data->popdescription = $this->lp_admin_model->getLeadPopTitle($funnelData['funnel']['leadpop_vertical_id'], $funnelData['funnel']['leadpop_vertical_sub_id'], $funnelData['funnel']['leadpop_version_id'], $funnelData['funnel']['leadpop_version_seq']);
            $this->data->unlimitedDomains =  $customize->checkUnlimitedDomains($funnelData['funnel']['client_id'], $funnelData['funnel']['leadpop_id'], $funnelData['funnel']['leadpop_version_seq']);

            list($this->data->descr,$this->data->dtype,$this->data->toplevel,$this->data->domainname,$this->data->domain_id)  = explode("~", $this->lp_admin_model->getDomainDescription($funnelData['funnel']));
            if($this->data->unlimitedDomains) {
                $this->data->domains = $customize->getDomainList($this->client_id,$this->data->customLeadpopid,$this->data->customLeadpopVersionseq);
            }
            else {
                $this->data->domains[0] = "";
            }
            /*var_dump($this->data);
			echo "</pre>";
			exit;*/

            $pops = $this->Default_Model_Leadpops;
            $this->data->client_id = $this->client_id;
            $this->data->client_secure_clix_enable = View_Helper::getInstance()->getSecureClixStatus($this->client_id);
            $this->data->workingLeadpop = $this->lp_admin_model->getWorkingLeadpopDescription($funnelData['funnel']);
            $key = $this->data->customVertical."~".$this->data->customSubvertical."~".$this->data->leadpop_id."~".$this->data->customLeadpopVersionseq."~".$this->data->client_id;
            $this->data->clickedkey = $key;
            $this->data->clientName = View_Helper::getInstance()->getClientName($this->client_id);
            $this->data->groupname = $funnelData['funnel']['group_name'];
            $this->data->currenturl  =  $this->lp_admin_model->getLeadpopUrl($funnelData['funnel']);
            $this->data->currenturlstatus  =   $this->lp_admin_model->getLeadpopStatus($funnelData['funnel']);
            $this->data->cloneLeadpop = $this->lp_admin_model->getPackagePermissions($this->client_id, 'clone');
            $this->data->vertical_id = $funnelData['funnel']['leadpop_vertical_id'];

            // switch menu varible - start
            $enterprise = array(7); // this array determins if you switch the menu to exclude items because enterprise page.
            if (in_array($this->data->vertical_id,$enterprise)) {
                $this->data->switchmenu = 'y';
            }
            else {
                $this->data->switchmenu = 'n';
            }
            // switch menu varible - end

            $this->data->subvertical_id = $funnelData['funnel']['leadpop_vertical_sub_id'];
            $this->data->funnelData = $funnelData;

            $this->active_menu = LP_Constants::DOMAIN;
            return $this->response();
        }
    }

    public function savechecksubdomainavailableAction() {
        $client_id = $_POST['client_id'];
        $s         = "select * from clients where client_id = " . $client_id;
        $client    = $this->db->fetchRow( $s );

        $version_seq = $_POST['version_seq'];
        $leadpop_id  = $_POST['leadpop_id'];

        $subdomain = $_POST['subdomain'];
        $topdomain = $_POST['topdomain'];

        $thedomain_id = $_POST['thedomain_id'];
        $domaintype   = $_POST['domaintype'];

        $s     = "select * from leadpops where id = " . $leadpop_id;
        $lpres = $this->db->fetchRow( $s );

        $is_valid_subdomain = false;
        $s = "SELECT client_id, leadpop_id, leadpop_version_id, leadpop_version_seq  FROM clients_funnels_domains where LOWER(subdomain_name) = '" . strtolower($subdomain) . "' AND top_level_domain = '" . strtolower($topdomain) . "' AND leadpop_type_id=". self::$leadpopSubDomainTypeId;
        $rows = $this->db->fetchAll($s);
        $response = null;

        if(count($rows) == 0){
            $is_valid_subdomain = true;
        }
        else{
            $client_ids = array();
            $leadpop_ids = array();
            $leadpop_version_ids = array();
            $leadpop_version_seq = array();
            for ($r=0; $r < count($rows); $r++) {
                array_push($client_ids, $rows[$r]['client_id']);
                array_push($leadpop_ids, $rows[$r]['leadpop_id']);
                array_push($leadpop_version_ids, $rows[$r]['leadpop_version_id']);
                array_push($leadpop_version_seq, $rows[$r]['leadpop_version_seq']);
            }

            if(!empty($client_ids)){
                $s = "SELECT count(*) as cnt from clients_leadpops WHERE client_id IN (".implode(array_unique($client_ids)).")
                AND leadpop_id IN (".implode(array_unique($leadpop_ids)).")
                AND leadpop_version_id IN (".implode(array_unique($leadpop_version_ids)).")
                AND leadpop_version_seq IN (".implode(array_unique($leadpop_version_seq)).")
                AND leadpop_active = 1";
                $cnt = $this->db->fetchOne( $s );
                if($cnt == 0) {
                    $is_valid_subdomain = true;
                } else {
                    $is_valid_subdomain = false;
                }
            } else {
                $is_valid_subdomain = true;
            }
        }

        /*
        $s = "select count(*) as cnt from Clients_subdomains as a, clients_leadpops as b
        where LOWER(a.subdomain_name) = '" . strtolower($subdomain) . "'
        and a.top_level_domain = '".$topdomain."'
        AND b.client_id = a.client_id
        AND b.leadpop_id = a.leadpop_id
        AND b.leadpop_version_id = a.leadpop_version_id
        AND b.leadpop_version_seq = a.leadpop_version_seq
        AND b.leadpop_active = 1";
        $cnt = $this->db->fetchOne( $s );
        if ( $cnt == 0 ) {
        */

        if($is_valid_subdomain) {
            // Update Domain URL in  Client Integration Table from old to new one (New code)
            $select     = "SELECT * FROM clients_funnels_domains WHERE clients_domain_id = ".$_POST["thedomain_id"] . " AND leadpop_type_id=" . self::$leadpopSubDomainTypeId;
            $old_domain = $this->db->fetchAll($select);
            if ( @$old_domain ) {
                $old_domain  = $old_domain[0];
                $old_domain  = $old_domain["subdomain_name"] . '.' . $old_domain["top_level_domain"];
                $update_data = array(
                    'url'                     => ( $subdomain . '.' . $topdomain ),
                    'leadpop_id'              => $leadpop_id,
                    'leadpop_vertical_id'     => $lpres['leadpop_vertical_id'],
                    'leadpop_vertical_sub_id' => $lpres['leadpop_vertical_sub_id'],
                    'leadpop_template_id'     => $lpres['leadpop_template_id'],
                    'leadpop_version_id'      => $lpres['leadpop_version_id'],
                    'leadpop_version_seq'     => $version_seq
                );
                $this->db->update( 'client_integrations', $update_data, "url LIKE '$old_domain'" );
            }


            $originalsubdomain = "";
            if ( $domaintype == self::$leadpopSubDomainTypeId ) { // sub-domain to sub-domain case
                $newsubdomain                   = $subdomain . "." . $topdomain;
                $this->registry->leadpops->currenturl = $newsubdomain;
                // get existing subdomain and top domain
                $s = "select subdomain_name,top_level_domain ";
                $s .= " from clients_funnels_domains";
                $s .= " where  clients_domain_id = " . $thedomain_id;
                $s .= " and leadpop_vertical_id = " . $lpres['leadpop_vertical_id'];
                $s .= " and leadpop_vertical_sub_id = " . $lpres['leadpop_vertical_sub_id'];
                $s .= " and leadpop_type_id = " . $lpres['leadpop_type_id'];
                $s .= " and leadpop_template_id = " . $lpres['leadpop_template_id'];
                $s .= " and leadpop_version_id = " . $lpres['leadpop_version_id'];
                $s .= " and leadpop_version_seq = " . $version_seq;
                $aoriginalsub      = $this->db->fetchRow( $s );
                $originalsubdomain = $aoriginalsub['subdomain_name'] . "." . $aoriginalsub['top_level_domain'];

                $old_domain_id = $thedomain_id;
                $old_funnel_url = $originalsubdomain;

                $this->Default_Model_Customize->updateFunnelIntegrations([
                    "url"=> $newsubdomain
                ], [
                    'client_id' => $client_id,
                    "leadpop_id" => $leadpop_id,
                    'leadpop_vertical_id' => $lpres['leadpop_vertical_id'],
                    'leadpop_vertical_sub_id' => $lpres['leadpop_vertical_sub_id'],
                    'leadpop_template_id' => $lpres['leadpop_template_id'],
                    'leadpop_version_id' => $lpres['leadpop_version_id'],
                    'leadpop_version_seq'=> $version_seq
                ]);

                # as all of our domains are on ssl now we need this if block.
//                if ( $topdomain == 'secure-clix.com' || $topdomain == 'popmortgage.com' ) {
//                    $s = "insert into force_ssl (id,url) values (null, '" . $newsubdomain . "' )";
//                    $this->db->query( $s );
//                }

                $s                = "select thankyou from submission_options ";
                $s                .= " where client_id = " . $client_id;
                $s                .= " and leadpop_version_id = " . $lpres['leadpop_version_id'];
                $s                .= " and leadpop_version_seq = " . $version_seq;
                $athankyou        = $this->db->fetchRow( $s );
                $originalthankyou = $athankyou['thankyou'];

                $newthankyou = str_replace( $originalsubdomain, $newsubdomain, $originalthankyou );

                // Update URL in TYP Information
                $s = "update submission_options set thankyou = '" . addslashes( $newthankyou ) . "' ";
                $s .= " where client_id = " . $client_id;
                $s .= " and leadpop_version_id = " . $lpres['leadpop_version_id'];
                $s .= " and leadpop_version_seq = " . $version_seq;
                $this->db->query( $s );

                // Update Domain Information
                $s = "update clients_funnels_domains  set subdomain_name = '" . $subdomain . "', ";
                $s .= " top_level_domain = '" . $topdomain . "' ";
                $s .= " where clients_domain_id = " . $thedomain_id;
                $s .= " and leadpop_vertical_id = " . $lpres['leadpop_vertical_id'];
                $s .= " and leadpop_vertical_sub_id = " . $lpres['leadpop_vertical_sub_id'];
                $s .= " and leadpop_type_id = " . $lpres['leadpop_type_id'];
                $s .= " and leadpop_template_id = " . $lpres['leadpop_template_id'];
                $s .= " and leadpop_version_id = " . $lpres['leadpop_version_id'];
                $s .= " and leadpop_version_seq = " . $version_seq;
                $this->db->query( $s );

                // Update domain_name in client_emma_group
                $s          = "select * from  client_emma_group where domain_name = '" . $originalsubdomain . "' limit 1 ";
                $emmaExists = $this->db->fetchAll( $s );
                if ( $emmaExists ) {
                    $s = "update client_emma_group set domain_name = '" . $newsubdomain . "' where domain_name = '" . $originalsubdomain . "' limit 1 ";
                    $this->db->query( $s );
                }

                $length    = 15;
                $randchars = $this->generateRandomString( $length );

                /* update google analytics and chimp tables */
                $s = "update  purchased_google_analytics set domain = '" . $newsubdomain . "' ";
                $s .= " where domain = '" . $originalsubdomain . "' ";
                $s .= " and client_id = " . $client_id;
                $this->db->query( $s );
                /* update google analytics and chimp tables */

                unset( $this->registry->leadpops->customLeadpopid );
                $this->registry->leadpops->customLeadpopid = $leadpop_id;

                unset( $this->registry->leadpops->leadpopType );
                $this->registry->leadpops->leadpopType = 1;

                $verticalname    = $this->getVerticalName( $lpres['leadpop_vertical_id'] );
                $subverticalname = $this->getSubVerticalName( $lpres['leadpop_vertical_id'], $lpres['leadpop_vertical_sub_id'] );
                $this->setworkinglink( $leadpop_id, $verticalname, $subverticalname, $version_seq );

                $s = "select id from clients_leadpops ";
                $s .= " where client_id = " . $client_id;
                $s .= " and leadpop_version_id =  " . $lpres['leadpop_version_id'];
                $s .= " and leadpop_version_seq =  " . $version_seq;
                $leadpop_client_id = $this->db->fetchOne($s);

                $response = $this->successResponse(null, [
                    "domain_id" => $thedomain_id,
                    "leadpop_id" => $leadpop_id,
                    "domain_type" => self::$leadpopSubDomainTypeId
                ]);
//                print "ok~1~" . $thedomain_id . "~" . $leadpop_id;
            }
            else if ( $domaintype == self::$leadpopDomainTypeId ) { // switching from a domain to a sub-domain so delete the domain and insert the sub-domain

                /**  @since 2.1.0 - CR-Funnel-Builder:  ad_builder table is not required anymore **/
                /*
                $s = "update ad_builder set leadpop_type_id =  " . self::$leadpopSubDomainTypeId;
                $s .= " where leadpop_type_id = " . self::$leadpopDomainTypeId;
                $s .= " and client_id = " . $client_id;
                $s .= " and vertical_id = " . $lpres['leadpop_vertical_id'];
                $s .= " and subvertical_id = " . $lpres['leadpop_vertical_sub_id'];
                $s .= " and leadpop_template_id = " . $lpres['leadpop_template_id'];
                $s .= " and leadpop_version_id = " . $lpres['leadpop_version_id'];
                $s .= " and leadpop_version_seq = " . $version_seq;
                $this->db->query( $s );
                */

                $newsubdomain = $subdomain . "." . $topdomain;

                /* need to change the leadpop_id in the lead_summary and lead_content tables 12/12/2012 */
                $s            = "select id from leadpops ";
                $s            .= " where leadpop_vertical_id = " . $lpres['leadpop_vertical_id'];
                $s            .= " and leadpop_vertical_sub_id = " . $lpres['leadpop_vertical_sub_id'];
                $s            .= " and leadpop_type_id = " . self::$leadpopSubDomainTypeId;
                $s            .= " and leadpop_template_id = " . $lpres['leadpop_template_id'];
                $s            .= " and leadpop_version_id = " . $lpres['leadpop_version_id'];
                $newLeadpopId = $this->db->fetchOne( $s );

                // Client Integration
                $this->Default_Model_Customize->updateFunnelIntegrations([
                    "url"=> $newsubdomain,
                    "leadpop_id" => $newLeadpopId
                ], [
                    'client_id' => $client_id,
                    "leadpop_id" => $leadpop_id,
                    'leadpop_vertical_id' => $lpres['leadpop_vertical_id'],
                    'leadpop_vertical_sub_id' => $lpres['leadpop_vertical_sub_id'],
                    'leadpop_template_id' => $lpres['leadpop_template_id'],
                    'leadpop_version_id' => $lpres['leadpop_version_id'],
                    'leadpop_version_seq'=> $version_seq
                ]);

                $s = "update lead_summary set  leadpop_id = " . $newLeadpopId;
                $s .= " where client_id  = " . $client_id;
                $s .= " and leadpop_vertical_id = " . $lpres['leadpop_vertical_id'];
                $s .= " and leadpop_vertical_sub_id = " . $lpres['leadpop_vertical_sub_id'];
                $s .= " and leadpop_template_id = " . $lpres['leadpop_template_id'];
                $s .= " and leadpop_id = " . $leadpop_id;
                $s .= " and leadpop_version_id = " . $lpres['leadpop_version_id'];
                $this->db->query( $s );

                $s = "update lead_content set  leadpop_id = " . $newLeadpopId;
                $s .= " where client_id  = " . $client_id;
                $s .= " and leadpop_version_id = " . $lpres['leadpop_version_id'];
                $s .= " and leadpop_version_seq = " . $version_seq;
                $this->db->query( $s );

                /* we have the original leadpop_id nd the newleadpopid, so change the values in the leadpop_background_color table */
                /* switch leadpop_id and leadpop_type_id for leadpop_background_color */
                $s = "update leadpop_background_color set leadpop_id = " . $newLeadpopId;
                $s .= " ,leadpop_type_id = " . self::$leadpopSubDomainTypeId;
                $s .= " where leadpop_type_id = " . self::$leadpopDomainTypeId;
                $s .= " and client_id = " . $client_id;
                $s .= " and leadpop_version_id = " . $lpres['leadpop_version_id'];
                $s .= " and leadpop_version_seq = " . $version_seq;
                $this->db->query( $s );

                /* switch leadpop_id and leadpop_type_id for leadpop_background_swatches */
                $s = "update leadpop_background_swatches set leadpop_id = " . $newLeadpopId;
                $s .= " ,leadpop_type_id = " . self::$leadpopDomainTypeId;
                $s .= " WHERE client_id = " . $client_id;
                $s .= " and leadpop_version_id = " . $lpres['leadpop_version_id'];
                $s .= " and leadpop_version_seq = " . $version_seq;
                $this->db->query($s);

                /* switch leadpop_id and leadpop_type_id for leadpop_background_color */
                /* need to change the leadpop_id in the leadpops_summary and leadpop_content tables 12/12/2012 */

                $s = "select clients_domain_id as id, domain_name from clients_funnels_domains";
                $s .= " where client_id  = " . $client_id;
                $s .= " and leadpop_version_id = " . $lpres['leadpop_version_id'];
                $s .= " and leadpop_version_seq = " . $version_seq . " ORDER BY id DESC limit 1 ";
                $old_domain_info = $this->db->fetchRow( $s );
                $old_domain_id = $previousDomainId = $old_domain_info['id'];
                $old_funnel_url = $originaldomain = $old_domain_info['domain_name'];

                // get previous domain name & set up new submission options
                $s                = "select thankyou from  submission_options ";
                $s                .= " where leadpop_type_id = " . self::$leadpopDomainTypeId;
                $s                .= " and client_id = " . $client_id;
                $s                .= " and leadpop_version_id = " . $lpres['leadpop_version_id'];
                $s                .= " and leadpop_version_seq = " . $version_seq;
                $athankyou        = $this->db->fetchRow( $s );
                $originalthankyou = $athankyou['thankyou'];

                $newthankyou = str_replace( $originaldomain, $newsubdomain, $originalthankyou );


                $line_item_key = $lpres['leadpop_vertical_id'] . "-";
                $line_item_key .= $lpres['leadpop_vertical_sub_id'] . "-";
                $line_item_key .= $lpres['leadpop_version_id'] . "-";
                $line_item_key .= $lpres['leadpop_type_id'] . "-";
                $line_item_key .= $version_seq;

                /*
                $s              = "select invoice_number from unlimited_domains ";
                $s              .= " where line_item_keys = '" . $line_item_key . "' ";
                $s              .= " and client_id = " . $client_id . " limit 1 ";
                $invoice_number = $this->db->fetchOne( $s );

                $s = "delete from unlimited_domains where client_id = " . $client_id;
                $s .= " and line_item_keys = '" . $line_item_key . "' ";
                $this->db->query( $s );
                */

                /* need to select domain name for google analytics */
                $s              = "  select domain_name from clients_funnels_domains";
                $s              .= " where client_id  = " . $client_id;
                $s              .= " and leadpop_version_id = " . $lpres['leadpop_version_id'];
                $s              .= " and leadpop_version_seq = " . $version_seq;
                $googlePrevName = $this->db->fetchOne( $s );
                /* need to select domain name for google analytics */

                $s = " delete from purchased_google_analytics where domain = '" . $googlePrevName . "' ";
                $s .= " and client_id = " . $client_id;
                $this->db->query( $s );

                $googleDomain = 'temporary';
                $this->insertPurchasedGoogle( $client_id, $googleDomain );

                $s = "select * from leadpops where leadpop_type_id = " . self::$leadpopSubDomainTypeId;
                $s .= " and leadpop_vertical_id = " . $lpres['leadpop_vertical_id'];
                $s .= " and leadpop_vertical_sub_id = " . $lpres['leadpop_vertical_sub_id'];
                $s .= " and leadpop_template_id = " . $lpres['leadpop_template_id'];
                $s .= " and leadpop_version_id = " . $lpres['leadpop_version_id'];
                $newlp = $this->db->fetchRow($s);

                if(env('CLIENTS_SUBDOMAIN_ENABLE', 0) == 1) {    // to enable old subdomain table
                    $s = "  delete from clients_funnels_domains";
                    $s .= " where client_id  = " . $client_id;
                    $s .= " and leadpop_version_id = " . $lpres['leadpop_version_id'];
                    $s .= " and leadpop_version_seq = " . $version_seq;
                    $this->db->query($s);

                    $s = " insert into clients_funnels_domains (id,client_id,subdomain_name,top_level_domain,";
                    $s .= "leadpop_vertical_id,leadpop_vertical_sub_id,leadpop_type_id,";
                    $s .= "leadpop_template_id, leadpop_id,leadpop_version_id,leadpop_version_seq) values (null,";
                    $s .= $client_id . ",'" . $subdomain . "','" . $topdomain . "'," . $newlp['leadpop_vertical_id'] . ",";
                    $s .= $newlp['leadpop_vertical_sub_id'] . "," . $newlp['leadpop_type_id'] . "," . $newlp['leadpop_template_id'] . ",";
                    $s .= $newlp['id'] . "," . $newlp['leadpop_version_id'] . "," . $version_seq . ")";
                    $this->db->query($s);
                    $thedomain_id = $this->db->lastInsertId();
                }
                else{
                    // Update Domain Information
                    $s = "update clients_funnels_domains  set subdomain_name = '" . $subdomain . "', ";
                    $s .= " top_level_domain = '" . $topdomain . "', ";
                    $s .= " domain_name = '', leadpop_id = ".$newlp['id'].", leadpop_type_id = ".$newlp['leadpop_type_id'];
                    $s .= " where client_id = ".$client_id;
                    $s .= " and leadpop_version_id = " . $lpres['leadpop_version_id'];
                    $s .= " and leadpop_version_seq = " . $version_seq;
                    $this->db->query( $s );
                }

                # NOT IN USE: mobileclients
                /*
                $s               = "select lower(nonmobiledomain) as nmd from mobileclients ";
                $s               .= " where client_id  = " . $client_id;
                $s               .= " and leadpop_vertical_id = " . $lpres['leadpop_vertical_id'];
                $s               .= " and leadpop_vertical_sub_id = " . $lpres['leadpop_vertical_sub_id'];
                $s               .= " and leadpop_type_id = " . $lpres['leadpop_type_id'];
                $s               .= " and leadpop_template_id = " . $lpres['leadpop_template_id'];
                $s               .= " and leadpop_id = " . $leadpop_id;
                $s               .= " and leadpop_version_id = " . $lpres['leadpop_version_id'];
                $s               .= " and leadpop_version_seq = " . $version_seq . " limit 1 ";
                $nonmobiledomain = $this->db->fetchAll( $s );
                if ( $nonmobiledomain ) {

                }

                $s = "delete from mobileclients ";
                $s .= " where client_id  = " . $client_id;
                $s .= " and leadpop_vertical_id = " . $lpres['leadpop_vertical_id'];
                $s .= " and leadpop_vertical_sub_id = " . $lpres['leadpop_vertical_sub_id'];
                $s .= " and leadpop_type_id = " . $lpres['leadpop_type_id'];
                $s .= " and leadpop_template_id = " . $lpres['leadpop_template_id'];
                $s .= " and leadpop_id = " . $leadpop_id;
                $s .= " and leadpop_version_id = " . $lpres['leadpop_version_id'];
                $s .= " and leadpop_version_seq = " . $version_seq;
                $this->db->query( $s );
                */


                /* I DON'T GET WHY we need to add temporary row in domains when moving from domains to subdomains (JAZ) - REMOVING THIS LOGIC but keeping code for reference, TODO: clean-up */
                /*
                $s = "insert into clients_funnels_domains (id,client_id,domain_name,leadpop_vertical_id,";
                $s .= "leadpop_vertical_sub_id,leadpop_type_id,leadpop_template_id,";
                $s .= "leadpop_id,leadpop_version_id,leadpop_version_seq) values (null,";
                $s .= $client_id . ",'temporary'," . $lpres['leadpop_vertical_id'] . ",";
                $s .= $lpres['leadpop_vertical_sub_id'] . "," . $lpres['leadpop_type_id'] . ",";
                $s .= $lpres['leadpop_template_id'] . "," . $leadpop_id . "," . $lpres['leadpop_version_id'] . ",";
                $s .= $version_seq . ")";
                $this->db->query( $s );
                $newdomain_id = $this->db->lastInsertId();

                $s = "insert into unlimited_domains (id,client_id,invoice_number,line_item_keys,domain_id) values (null,";
                $s .= $client_id . ",'" . $invoice_number . "','" . $line_item_key . "',";
                $s .= $newdomain_id . ")";
                $this->db->query( $s );
                */

                // Updating funnel pixels
                $this->Default_Model_Pixel->updatePixel([
                    "domain_id"=> $thedomain_id,
                    "leadpops_id" => $newlp['id']
                ], [
                        "client_id" => $client_id,
                        "domain_id"=> $previousDomainId,
                        "leadpops_id" => $leadpop_id
                    ]
                );

                // Updating client_emma_group
                $s          = "select * from  client_emma_group where domain_name = '" . $originaldomain . "' limit 1 ";
                $emmaExists = $this->db->fetchAll( $s );
                if ( $emmaExists ) {
                    $s = "update client_emma_group set domain_name = '" . $subdomain . "." . $topdomain . "' where domain_name = '" . $originaldomain . "' limit 1 ";
                    $this->db->query( $s );
                }

                ## NOT REQUIRD ANYMORE
                /* new mobileclients code */
                /*
                $s            = "select id from mobileclients where ";
                $s            .= " leadpop_vertical_id = " . $lpres['leadpop_vertical_id'];
                $s            .= " and client_id = " . $client_id;
                $s            .= " and leadpop_vertical_sub_id = " . $lpres['leadpop_vertical_sub_id'];
                $s            .= " and leadpop_type_id = " . $lpres['leadpop_type_id'];
                $s            .= " and leadpop_template_id = " . $lpres['leadpop_template_id'];
                $s            .= " and leadpop_version_id = " . $lpres['leadpop_version_id'];
                $s            .= " and leadpop_version_seq = " . $version_seq;
                $mobileExists = $this->db->fetchOne( $s );
                if ( $mobileExists ) {
                    $s = "update mobileclients set nonmobiledomain = '" . $subdomain . "." . $topdomain . "', ";
                    $s .= " leadpop_type_id = " . $newlp['leadpop_type_id'];
                    $s .= " where ";
                    $s .= " leadpop_vertical_id = " . $lpres['leadpop_vertical_id'];
                    $s .= " and leadpop_vertical_sub_id = " . $lpres['leadpop_vertical_sub_id'];
                    $s .= " and leadpop_type_id = " . $lpres['leadpop_type_id'];
                    $s .= " and leadpop_template_id = " . $lpres['leadpop_template_id'];
                    $s .= " and leadpop_version_id = " . $lpres['leadpop_version_id'];
                    $s .= " and leadpop_version_seq = " . $version_seq;
                    $s .= " and id = " . $mobileExists;
                    $this->db->query( $s );

                    $cmpdomain = strtolower( $originaldomain );

                } else {
                    $length    = 15;
                    $randchars = $this->generateRandomString( $length );
                    $s         = "select count(*) as cnt from mobileclients where nonmobiledomain = '" . $subdomain . "." . $topdomain . "' ";
                    $hasmobile = $this->db->fetchOne( $s );
                    if ( $hasmobile == 0 ) {
                        $s = "INSERT INTO mobileclients (nonmobiledomain, mobiledomain, client_id, id, leadpop_id, ";
                        $s .= "leadpop_vertical_id,leadpop_vertical_sub_id, leadpop_type_id, leadpop_template_id,";
                        $s .= "leadpop_version_id, leadpop_version_seq, ";
                        $s .= "iszillow, zillow_api, active, group_design, phone, company,client_or_domain_logo_image) VALUES (";
                        $s .= "'" . $subdomain . "." . $topdomain . "','" . $randchars . ".itclixmobile.com',";
                        $s .= $client_id . ",null," . $newlp['id'] . "," . $newlp['leadpop_vertical_id'] . "," . $newlp['leadpop_vertical_sub_id'] . ",1," . $newlp['leadpop_template_id'];
                        $s .= "," . $newlp['leadpop_version_id'] . "," . $version_seq . ",'n','n','y','y','" . preg_replace( '/[^0-9]/', '', $client ['phone_number'] ) . "', '" . addslashes( $client ['company_name'] ) . "','c') ";
                        $this->db->query( $s );
                    }

                }
                */
                /* new mobileclients code */


                /* insert google analytics and chimp tables */
                $googleDomain = $subdomain . "." . $topdomain;
                $this->insertPurchasedGoogle( $client_id, $googleDomain );
                /* insert google analytics and chimp tables */

                $s = "update clients_leadpops set leadpop_id = " . $newlp['id'];
                $s .= " where client_id = " . $client_id;
                $s .= " and leadpop_version_id =  " . $lpres['leadpop_version_id'];
                $s .= " and leadpop_version_seq =  " . $version_seq;
                $this->db->query( $s );

                /* Get id from clients_leadpops to update in lead_stats */
                $s = "select id from clients_leadpops ";
                $s .= " where client_id = " . $client_id;
                $s .= " and leadpop_version_id =  " . $newlp['leadpop_version_id'];
                $s .= " and leadpop_version_seq =  " . $version_seq;
                $leadpop_client_id = $this->db->fetchOne($s);

                $s = "UPDATE lead_stats SET leadpop_id = ".$newlp['id'].", leadpop_version_seq = ".$version_seq.", domain_id = ".$thedomain_id.", leadpop_client_id = ".$leadpop_client_id;
                $s .= " WHERE client_id  = " . $client_id;
                $s .= " and leadpop_id = " . $leadpop_id;
                $s .= " and domain_id = " . $previousDomainId;
                $s .= " and leadpop_vertical_id = " . $lpres['leadpop_vertical_id'];
                $s .= " and leadpop_vertical_sub_id = " . $lpres['leadpop_vertical_sub_id'];
                $s .= " and leadpop_template_id = " . $lpres['leadpop_template_id'];
                $s .= " and leadpop_version_id = " . $lpres['leadpop_version_id'];
                $this->db->query($s);

                $this->registry->leadpops->customLeadpopid = $newlp['id'];

                unset( $this->registry->leadpops->leadpopType );
                $this->registry->leadpops->leadpopType = 1;

                $verticalname    = $this->getVerticalName( $newlp['leadpop_vertical_id'] );
                $subverticalname = $this->getSubVerticalName( $newlp['leadpop_vertical_id'], $newlp['leadpop_vertical_sub_id'] );
                $this->setworkinglink( $newlp['id'], $verticalname, $subverticalname, $version_seq );


                /* need to change leadpop id and leadpop type for chimp */
                $s = "update chimp set leadpop_id = " . $newlp['id'];
                $s .= " ,leadpop_type_id = " . self::$leadpopSubDomainTypeId;
                $s .= " where leadpop_type_id = " . self::$leadpopDomainTypeId;
                $s .= " and client_id = " . $client_id;
                $s .= " and leadpop_vertical_id = " . $newlp['leadpop_vertical_id'];
                $s .= " and leadpop_vertical_sub_id = " . $newlp['leadpop_vertical_sub_id'];
                $s .= " and leadpop_template_id = " . $newlp['leadpop_template_id'];
                $s .= " and leadpop_version_id = " . $newlp['leadpop_version_id'];
                $s .= " and leadpop_version_seq = " . $version_seq;
                @$this->db->query( $s );
                /* need to change leadpop id and leadpop type for chimp */

                /* need to change leadpop id and leadpop type */
                $s = "update  leadpop_images set leadpop_id = " . $newlp['id'];
                $s .= " ,leadpop_type_id = " . self::$leadpopSubDomainTypeId;
                $s .= " where leadpop_type_id = " . self::$leadpopDomainTypeId;
                $s .= " and client_id = " . $client_id;
                $s .= " and leadpop_vertical_id = " . $newlp['leadpop_vertical_id'];
                $s .= " and leadpop_vertical_sub_id = " . $newlp['leadpop_vertical_sub_id'];
                $s .= " and leadpop_template_id = " . $newlp['leadpop_template_id'];
                $s .= " and leadpop_version_id = " . $newlp['leadpop_version_id'];
                $s .= " and leadpop_version_seq = " . $version_seq;
                $this->db->query( $s );

                $s = "update  leadpop_logos set leadpop_id = " . $newlp['id'];
                $s .= " ,leadpop_type_id = " . self::$leadpopSubDomainTypeId;
                $s .= " where leadpop_type_id = " . self::$leadpopDomainTypeId;
                $s .= " and client_id = " . $client_id;
                $s .= " and leadpop_vertical_id = " . $newlp['leadpop_vertical_id'];
                $s .= " and leadpop_vertical_sub_id = " . $newlp['leadpop_vertical_sub_id'];
                $s .= " and leadpop_template_id = " . $newlp['leadpop_template_id'];
                $s .= " and leadpop_version_id = " . $newlp['leadpop_version_id'];
                $s .= " and leadpop_version_seq = " . $version_seq;
                $this->db->query( $s );

                /* we have the original leadpop_id nd the newleadpopid, so change the values in the leadpop_background_color table */
                /* switch leadpop_id and leadpop_type_id for leadpop_background_color */
                $s = "update leadpop_background_color set leadpop_id = " . $newlp['id'];
                $s .= " ,leadpop_type_id = " . self::$leadpopSubDomainTypeId;
                $s .= " where leadpop_type_id = " . self::$leadpopDomainTypeId;
                $s .= " and client_id = " . $client_id;
                $s .= " and leadpop_version_id = " . $newlp['leadpop_version_id'];
                $s .= " and leadpop_version_seq = " . $version_seq;
                $this->db->query( $s );
                /* we have the original leadpop_id nd the newleadpopid, so change the values in the leadpop_background_color table */
                /* switch leadpop_id and leadpop_type_id for leadpop_background_color */


                /* switch leadpop_id and leadpop_type_id for leadpop_background_swatches */
                $s = "update leadpop_background_swatches set leadpop_id = " . $newlp['id'];
                $s .= " ,leadpop_type_id = " . self::$leadpopDomainTypeId;
                $s .= " where client_id = " . $client_id;
                $s .= " and leadpop_version_id = " . $newlp['leadpop_version_id'];
                $s .= " and leadpop_version_seq = " . $version_seq;
                $this->db->query($s);


                $s = "update  seo_options set leadpop_id = " . $newlp['id'];
                $s .= " ,leadpop_type_id = " . self::$leadpopSubDomainTypeId;
                $s .= " where leadpop_type_id = " . self::$leadpopDomainTypeId;
                $s .= " and client_id = " . $client_id;
                $s .= " and leadpop_vertical_id = " . $newlp['leadpop_vertical_id'];
                $s .= " and leadpop_vertical_sub_id = " . $newlp['leadpop_vertical_sub_id'];
                $s .= " and leadpop_template_id = " . $newlp['leadpop_template_id'];
                $s .= " and leadpop_version_id = " . $newlp['leadpop_version_id'];
                $s .= " and leadpop_version_seq = " . $version_seq;
                $this->db->query( $s );

                $s = "update  autoresponder_options set leadpop_id = " . $newlp['id'];
                $s .= " ,leadpop_type_id = " . self::$leadpopSubDomainTypeId;
                $s .= " where leadpop_type_id = " . self::$leadpopDomainTypeId;
                $s .= " and client_id = " . $client_id;
                $s .= " and leadpop_version_id = " . $newlp['leadpop_version_id'];
                $s .= " and leadpop_version_seq = " . $version_seq;
                $this->db->query( $s );

                $s = "update  bottom_links set leadpop_id = " . $newlp['id'];
                $s .= " ,leadpop_type_id = " . self::$leadpopSubDomainTypeId;
                $s .= " where leadpop_type_id = " . self::$leadpopDomainTypeId;
                $s .= " and client_id = " . $client_id;
                $s .= " and leadpop_version_id = " . $newlp['leadpop_version_id'];
                $s .= " and leadpop_version_seq = " . $version_seq;
                $this->db->query( $s );

                $s = "update  submission_options set leadpop_id = " . $newlp['id'];
                $s .= " ,leadpop_type_id = " . self::$leadpopSubDomainTypeId;
                $s .= " ,thankyou = '" . addslashes( $newthankyou ) . "' ";
                $s .= " where leadpop_type_id = " . self::$leadpopDomainTypeId;
                $s .= " and client_id = " . $client_id;
                $s .= " and leadpop_version_id = " . $newlp['leadpop_version_id'];
                $s .= " and leadpop_version_seq = " . $version_seq;
                $this->db->query( $s );

                $s = "update  contact_options set leadpop_id = " . $newlp['id'];
                $s .= " ,leadpop_type_id = " . self::$leadpopSubDomainTypeId;
                $s .= " where leadpop_type_id = " . self::$leadpopDomainTypeId;
                $s .= " and client_id = " . $client_id;
                $s .= " and leadpop_vertical_id = " . $newlp['leadpop_vertical_id'];
                $s .= " and leadpop_vertical_sub_id = " . $newlp['leadpop_vertical_sub_id'];
                $s .= " and leadpop_template_id = " . $newlp['leadpop_template_id'];
                $s .= " and leadpop_version_id = " . $newlp['leadpop_version_id'];
                $s .= " and leadpop_version_seq = " . $version_seq;
                $this->db->query( $s );

                $s = "update lp_auto_recipients set leadpop_id = " . $newlp['id'];
                $s .= " ,leadpop_type_id = " . self::$leadpopSubDomainTypeId;
                $s .= " where leadpop_type_id = " . self::$leadpopDomainTypeId;
                $s .= " and client_id = " . $client_id;
                $s .= " and leadpop_vertical_id = " . $newlp['leadpop_vertical_id'];
                $s .= " and leadpop_vertical_sub_id = " . $newlp['leadpop_vertical_sub_id'];
                $s .= " and leadpop_template_id = " . $newlp['leadpop_template_id'];
                $s .= " and leadpop_version_id = " . $newlp['leadpop_version_id'];
                $s .= " and leadpop_version_seq = " . $version_seq;
                $this->db->query( $s );

                $s            = "select id from lp_auto_recipients where ";
                $s            .= " leadpop_id = " . $newlp['id'];
                $s            .= " and leadpop_type_id = " . self::$leadpopSubDomainTypeId;
                $s            .= " and client_id = " . $client_id;
                $s            .= " and leadpop_vertical_id = " . $newlp['leadpop_vertical_id'];
                $s            .= " and leadpop_vertical_sub_id = " . $newlp['leadpop_vertical_sub_id'];
                $s            .= " and leadpop_template_id = " . $newlp['leadpop_template_id'];
                $s            .= " and leadpop_version_id = " . $newlp['leadpop_version_id'];
                $s            .= " and leadpop_version_seq = " . $version_seq;
                $lp_auto_rows = $this->db->fetchAll( $s );

                for ( $v = 0; $v < count( $lp_auto_rows ); $v ++ ) {
                    $s = "update lp_auto_text_recipients  set leadpop_id = " . $newlp['id'];
                    $s .= " ,leadpop_type_id = " . self::$leadpopSubDomainTypeId;
                    $s .= " where lp_auto_recipients_id = " . $lp_auto_rows[ $v ]['id'];
                    $this->db->query( $s );
                }

                $s          = "  select count(*) as cnt ";
                $s          .= " from leadpop_multiple_step ";
                $s          .= " where client_id = " . $client_id;
                $s          .= " and leadpop_description_id = " . $lpres['leadpop_version_id'];
                $s          .= " and leadpop_id = " . $lpres['id'];
                $s          .= " and leadpop_template_id = " . $lpres['leadpop_template_id'];
                $multicount = $this->db->fetchOne( $s );

                if ( $multicount > 0 ) {
                    $s = "update leadpop_multiple_step ";
                    $s .= " set leadpop_description_id = " . $newlp['leadpop_version_id'];
                    $s .= " ,leadpop_id = " . $newlp['id'];
                    $s .= " ,leadpop_template_id = " . $newlp['leadpop_template_id'];
                    $s .= " where client_id = " . $client_id;
                    $s .= " and leadpop_description_id = " . $lpres['leadpop_version_id'];
                    $s .= " and leadpop_id = " . $lpres['id'];
                    $s .= " and leadpop_template_id = " . $lpres['leadpop_template_id'];
                    $this->db->query( $s );
                }


                if(getenv('APP_ENV') != config('app.env_local')) {
                    //Changing lead_content key in keydb because leadpop_id is updated
                    \MyLeads_Helper::getInstance()->changeRedisKey($client_id, $lpres['id'], $version_seq, $newlp['id']);
                }

                $response = $this->successResponse(null, [
                    "domain_id" => $thedomain_id,
                    "leadpop_id" => $newlp['id'],
                    "domain_type" => self::$leadpopSubDomainTypeId
                ]);
//                print "ok~1~" . $thedomain_id . "~" . $newlp['id'];
            }
            /*
                        *Disable as per sir @sal
                        */
            //$this->updateClientWebsite($client_id, $old_domain, ($subdomain . '.' . $topdomain), $leadpop_client_id);
            $this->updateFunnelTimestamp(array("client_id"=>$client_id, "client_leadpop_id"=>$leadpop_client_id));

            /**
             * SB - Cloned
             */
            if($originalsubdomain){
                $s = "select * from  client_funnel_sticky where sticky_funnel_url = '" . $originalsubdomain . "' limit 1 ";
                $exists = $this->db->fetchRow( $s );
                if ( $exists ) {
                    $s = "update client_funnel_sticky set sticky_funnel_url = '" . $newsubdomain . "' where sticky_funnel_url = '" . $originalsubdomain . "' limit 1 ";
                    $this->db->query( $s );
                    /* update clients_leadpops table's col last edit*/
                    /* if LP_Helper::getInstance()->getFunnelData() not work then send id in parameter */
                    update_clients_leadpops_last_eidt($exists['clients_leadpops_id']);
                }

            }




            if($response != null) {
                return $response;
            } else {
                return $this->errorResponse();
            }

        }
        else {
            return $this->errorResponse('That sub-domain is already in use. Please try something else.', [
                "taken" => true
            ]);
//            print "taken~0~0";
        }

    }

    private function getVerticalName($leadpop_vertical_id) {
        $s = "select lead_pop_vertical from leadpops_verticals where id = " . $leadpop_vertical_id;
        $verticalName = $this->db->fetchOne($s);
        return $verticalName;
    }

    private function getSubVerticalName($leadpop_vertical_id,$leadpop_subvertical_id) {
        $s = "select lead_pop_vertical_sub from leadpops_verticals_sub where id = " . $leadpop_subvertical_id;
        $s .= " and leadpop_vertical_id = " . $leadpop_vertical_id;
        $subverticalName = $this->db->fetchOne($s);
        return $subverticalName;
    }

    private function setworkinglink($leadpop_id,$verticalname,$subverticalname,$leadpop_version_seq) {
        $key = $verticalname."~".$subverticalname."~".$leadpop_id."~".$leadpop_version_seq."~".$this->client_id;
        $this->registry->leadpops->clickedkey = $key;
        $this->registry->leadpops->customVertical = $verticalname;
        $s = "select id from leadpops_verticals where lead_pop_vertical = '".$this->registry->leadpops->customVertical."' ";
        $this->registry->leadpops->customVertical_id = $this->db->fetchOne($s);
        $this->registry->leadpops->customSubvertical = $subverticalname;
        $s = "select id from leadpops_verticals_sub where leadpop_vertical_id = ".$this->registry->leadpops->customVertical_id;
        $s .= " and lead_pop_vertical_sub = '".$this->registry->leadpops->customSubvertical."' ";
        $this->registry->leadpops->customSubvertical_id = $this->db->fetchOne($s);
        $this->registry->leadpops->customLeadpopid = $leadpop_id;
        $this->registry->leadpops->customLeadpopVersionseq = $leadpop_version_seq;
        $this->registry->leadpops->popdescription = $this->getSelectedPopDescr($this->registry->leadpops->customVertical,$this->registry->leadpops->customSubvertical,$this->registry->leadpops->customLeadpopid,$this->registry->leadpops->customLeadpopVersionseq);
        /* save initial for reset in home page main  */
        $customize = $this->Default_Model_Customize;
        /* check for unlimited domains */
        $this->registry->leadpops->unlimitedDomains = $customize->checkUnlimitedDomains($this->client_id,$this->registry->leadpops->customLeadpopid,$this->registry->leadpops->customLeadpopVersionseq);

        $s = "select * from leadpops where id = " . $leadpop_id;

        $leadpop = $this->db->fetchRow($s);
        $leadpop_template_id = $leadpop['leadpop_template_id'];
        $leadpop_version_id = $leadpop['leadpop_version_id'];
        $leadpop_type_id  = $leadpop['leadpop_type_id'];

        if($leadpop['leadpop_type_id'] == '1') { // sub-domain
            $s = "select clients_domain_id as id ,subdomain_name,top_level_domain from clients_funnels_domains";
            $s .= " where client_id = " . $this->client_id;
            $s .= " and leadpop_version_id = " . $leadpop['leadpop_version_id'];
            $s .= " and leadpop_version_seq = " . $leadpop_version_seq;
            $s .= " and leadpop_type_id = " . self::$leadpopSubDomainTypeId;

            $tempdomain = $this->db->fetchRow($s);

            $s = "select leadpop_active from clients_leadpops where ";
            $s .= " client_id =  " . $this->client_id;
            $s .= " and leadpop_version_id =  " . $leadpop['leadpop_version_id'];
            $s .= " and leadpop_version_seq = " . $leadpop_version_seq;

            $lpactive = $this->db->fetchOne($s);

            if($lpactive == '1' ) {
                $status = 'active';
            }
            else  if($lpactive == '0' ) {
                $status = 'inactive';
            }

            $typedescr = ' Sub-Domain ';
            $domainname = $tempdomain['subdomain_name'];
            $topname = $tempdomain['top_level_domain'];
            $id = $tempdomain['id'];
            $type = '1';
        }
        else if ($leadpop['leadpop_type_id'] == '2') { // domain
            $s = "select clients_domain_id as id ,domain_name from clients_funnels_domains";
            $s .= " where client_id = " . $this->client_id;
            $s .= " and leadpop_version_id = " . $leadpop['leadpop_version_id'];
            $s .= " and leadpop_version_seq = " . $leadpop_version_seq;
            $s .= " and leadpop_type_id = " . self::$leadpopDomainTypeId . " limit 1 ";

            $typedescr = ' Domain ';
            $tempdomain = $this->db->fetchRow($s);

            $s = "select leadpop_active from clients_leadpops where ";
            $s .= " client_id =  " . $this->client_id;
            $s .= " and leadpop_version_id =  " . $leadpop['leadpop_version_id'];
            $s .= " and leadpop_version_seq = " . $leadpop_version_seq;
            $lpactive = $this->db->fetchOne($s);
            if($lpactive == '1' ) {
                $status = 'active';
            }
            else  if($lpactive == '0' ) {
                $status = 'inactive';
            }

            $domainname = $tempdomain['domain_name'];
            $id = $tempdomain['id'];
            $topname = "notop";
            $type = '2';
        }
        //          <span class="topdog">leadPop:</span> Auto-8-1 <span class="topdog">Type: </span> Sub-Domain  <span class="topdog">Category: </span> Insurance/Auto <span class="topdog"> Status: </span> Active
        if($topname == "notop") {
            if($status == 'active') {
                $ret = "<span style='color: #a2a1a1'>&nbsp;&nbsp;&nbsp;leadPop:</span>  <a class='bluetexthead' href='http://".$domainname."' target='_blank'>".$domainname."</a>";
            }
            else {
                $ret = "<span style='color: #a2a1a1'>&nbsp;&nbsp;&nbsp;leadPop:</span>  <a  class='bluetexthead' href='#'>".$domainname." (inactive)</a>";
            }
        }
        else {
            if($status == 'active') {
                $ret = "<span style='color: #a2a1a1'>&nbsp;&nbsp;&nbsp;leadPop:</span>  <a  class='bluetexthead' href='http://".$domainname.".".$topname."' target='_blank'>".$domainname.".".$topname."</a>";
            }
            else {
                $ret = "<span style='color: #a2a1a1'>&nbsp;&nbsp;&nbsp;leadPop:</span>  <a  class='bluetexthead' href='#'>".$domainname.".".$topname." (inactive)</a>";
            }
        }
        $this->registry->leadpops->workingLeadpop = $ret;
    }

    private function generateRandomString($length = 10) {
        return substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, $length);
    }

    private function updateClientWebsite($client_id, $old_url, $new_url, $client_leadpop_id){
        $url = WEBSITE_LAUNCHER;
        $fields = array(
            "route"=>"update_url",
            "url"=>$old_url,
            "new_url"=>$new_url,
            "client_id"=>$client_id,
            "client_leadpop_id"=>$client_leadpop_id
        );

        $post_field = [];
        foreach ($fields as $key=>$field){
            $post_field[] = "$key=$field";
        }
        $post_field = implode('&',$post_field);

        if(env('APP_ENV') === config('app.env_production')) {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $post_field);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 3);
            curl_setopt($ch, CURLOPT_TIMEOUT, 20);
            $output = curl_exec($ch);
            curl_close($ch);
        }
    }

    private function updateFunnelTimestamp($args){
        $now = new DateTime();

        $client_leadpop_id = "";
        $client_id = "";
        if(!array_key_exists('client_leadpop_id', $args)){
            $s = "SELECT clients_leadpops.id FROM clients_leadpops INNER JOIN leadpops ON leadpops.id = clients_leadpops.leadpop_id";
            $s .= " WHERE client_id = " . $args['client_id'];
            $s .= " AND clients_leadpops.leadpop_id = " . $args['leadpop_id'];
            $s .= " AND leadpops.leadpop_vertical_id = " . $args['vertical_id'];
            $s .= " AND leadpops.leadpop_vertical_sub_id = " . $args['subvertical_id'];
            $s .= " AND leadpops.id = " . $args['leadpop_id'];
            if(array_key_exists('leadpop_template_id', $args)) $s .= " AND leadpop_template_id = " . $args['leadpop_template_id'];
            if(array_key_exists('leadpop_version_id', $args)) $s .= " AND leadpops.leadpop_version_id = " . $args['leadpop_version_id'];
            if(array_key_exists('version_seq', $args)) $s .= " and leadpop_version_seq = " . $args['version_seq'];
            if(array_key_exists('leadpop_type_id', $args)) $s .= " and leadpop_type_id = " . $args['leadpop_type_id'];
            $clientLeadpopInfo = $this->db->fetchRow($s);

            $client_id = $args['client_id'];
            $client_leadpop_id = $clientLeadpopInfo['id'];
        } else {
            $client_id = $args['client_id'];
            $client_leadpop_id = $args['client_leadpop_id'];
        }


        if($client_leadpop_id){
            $s = "UPDATE clients_leadpops SET date_updated = '" . $now->format("Y-m-d H:i:s") . "'
                  , last_edit = '" . $now->format("Y-m-d H:i:s") . "'";
            $s .= " WHERE client_id = " . $client_id;
            $s .= " AND id = " . $client_leadpop_id;
            $this->db->query($s);
        }
    }

    private function insertPurchasedGoogle($client_id,$googleDomain) {
        // package id does not now affect google analytics so put 2 for all
        $dt = date('Y-m-d H:i:s');
        $s = "insert into purchased_google_analytics (client_id,purchased,google_key,";
        $s .= "thedate,domain,active,package_id) values (".$client_id.",'y','','".$dt."','".$googleDomain."',";
        $s .= "'n',2)";
        $this->db->query($s);
    }

    private function getSelectedPopDescr($vertical,$subvertical,$leadpopid,$versionseq){
        $s = "select id from leadpops_verticals where lead_pop_vertical = '".$vertical."' ";
        $vertical_id = $this->db->fetchOne($s);
        $s = "select id from leadpops_verticals_sub where leadpop_vertical_id = '".$vertical_id."' ";
        $s .= " and lead_pop_vertical_sub = '".$subvertical."' ";
        $subvertical_id = $this->db->fetchOne($s);
        $s = "select leadpop_version_id from leadpops where id = " . $leadpopid;
        $leadpop_version_id = $this->db->fetchOne($s);
        $s = "select leadpop_title from leadpops_descriptions where leadpop_vertical_id = " . $vertical_id;
        $s .= " and leadpop_vertical_sub_id = " . $subvertical_id;
        $s .= " and id = " . $leadpop_version_id;
        $leadpop_title = $this->db->fetchOne($s);
        $leadpop_title = $leadpop_title . "-" . $versionseq;
        return $leadpop_title;
    }

    public function savecheckdomainavailableAction()  {
        $client_id = $_POST['client_id'];

        $s = "select * from clients where client_id = " . $client_id;
        $client = $this->db->fetchRow ( $s );

        $version_seq = $_POST['version_seq'];
        $leadpop_id = $_POST['leadpop_id'];
        $thedomain = $_POST['thedomain'];
        $thedomain_id = $_POST['thedomain_id']; // id of the old subdomain or domain
        $domaintype = $_POST['domaintype']; // type of the new domain
        $hasunlimited = $_POST['hasunlimited'];
        $beforedomainname = $_POST['beforedomainname'];

        $s = "select * from leadpops  where id = " .  $leadpop_id;
        $lpres = $this->db->fetchRow($s);

        $s = "select count(*) as cnt from clients_funnels_domains where domain_name = '".$thedomain."' AND leadpop_type_id=" . self::$leadpopDomainTypeId;
        $cnt = $this->db->fetchOne($s);

        $response = null;
        $success_message = 'Domain ' . $thedomain . ' has been saved.';

        if($cnt == 0) { // domain name not found
            if($domaintype == self::$leadpopDomainTypeId && $hasunlimited == true) { // has unlimited so do an insert of the new domain name
                $old_domain_id = $thedomain_id;
                $s = "select thankyou from submission_options ";
                $s .= " where leadpop_type_id = " . self::$leadpopDomainTypeId;
                $s .= " and client_id = " . $client_id;
                $s .= " and leadpop_version_id = " . $lpres['leadpop_version_id'];
                $s .= " and leadpop_version_seq = " . $version_seq . " limit 1 ";
                $asubmission = $this->db->fetchRow($s);
                $originalthankyou = $asubmission['thankyou'];

                $s = "select domain_name from clients_funnels_domains " ;
                $s .= " where clients_domain_id = " . $thedomain_id;
                $s .= " and leadpop_version_id = " . $lpres['leadpop_version_id'];
                $s .= " and leadpop_version_seq = " . $version_seq . " limit 1 ";
                $adomain = $this->db->fetchRow($s);
                $originaldomain =  $adomain['domain_name'];
                $newthankyou = str_replace($originaldomain,$thedomain,$originalthankyou);

                $s = "update  submission_options set thankyou = '".addslashes($newthankyou)."' ";
                $s .= " where leadpop_type_id = " . self::$leadpopDomainTypeId;
                $s .= " and client_id = " . $client_id;
                $s .= " and leadpop_version_id = " . $lpres['leadpop_version_id'];
                $s .= " and leadpop_version_seq = " . $version_seq;
                $this->db->query($s);

                $line_item_keys = $lpres['leadpop_vertical_id']."-";
                $line_item_keys .= $lpres['leadpop_vertical_sub_id']."-";
                $line_item_keys .= $lpres['leadpop_version_id']."-";
                $line_item_keys .= self::$leadpopDomainTypeId."-";
                $line_item_keys .= $version_seq;

                /*
                $s = "select * from unlimited_domains where line_item_keys = '".$line_item_keys."' ";
                $s .= " and client_id = " . $client_id . ' limit 1 ';
                $unlimitedDomainsRow = $this->db->fetchAll($s);
                */

                $s = " select clients_domain_id as id, domain_name, leadpop_version_id, leadpop_version_seq, leadpop_vertical_sub_id, leadpop_id from clients_funnels_domains where clients_domain_id = " . $thedomain_id . " AND leadpop_type_id=" . self::$leadpopDomainTypeId;
                $currentDomainName = $this->db->fetchRow($s);
                $old_wp_url = $currentDomainName;
                $new_wp_url = $thedomain;

                if(($currentDomainName['domain_name'] == $beforedomainname) || ($beforedomainname == 'temporary')) {
                    $s = "update clients_funnels_domains set domain_name = '".$thedomain."' ";
                    $s .= " where clients_domain_id = " . $currentDomainName['id'];
                    $s .= " AND leadpop_type_id = " . self::$leadpopDomainTypeId;
                    $this->db->query($s);
                    $new_domain_id = $thedomain_id;

                    // Client Integration
                    $this->Default_Model_Customize->updateFunnelIntegrations([
                        "url"=> $thedomain
                    ], [
                        'client_id' => $client_id,
                        'leadpop_id' => $currentDomainName['leadpop_id'],
                        'leadpop_vertical_id' => $lpres['leadpop_vertical_id'],
                        'leadpop_vertical_sub_id' => $lpres['leadpop_vertical_sub_id'],
                        'leadpop_template_id' => $lpres['leadpop_template_id'],
                        'leadpop_version_id' => $lpres['leadpop_version_id'],
                        'leadpop_version_seq' => $version_seq
                    ]);
                    /* add chg domain name in clients_emma_group  4/7/2016
						 we only update change in domain names. this is for cleints who
						 sign up for the free-trial. to put in previous clients into emma we need
						 to find another way. aaaaaaaaaaaaaaaa
					*/
                    $s = "select * from  client_emma_group where domain_name = '" . $currentDomainName['domain_name'] . "' limit 1 ";
                    $emmaExists =  $this->db->fetchAll($s);
                    if ($emmaExists) {
                        $s = "update client_emma_group set domain_name = '".$thedomain."' where domain_name = '".$currentDomainName['domain_name']."' limit 1 ";
                        $this->db->query($s);
                    }

                    $s = "select * from clients_funnels_domains where clients_domain_id = " . $thedomain_id . " AND leadpop_type_id=" . self::$leadpopDomainTypeId;
                    $mdomain = $this->db->fetchRow($s);

                    /* update google analytics and chimp tables */
                    $s = "update  purchased_google_analytics set domain = '".$thedomain."' ";
                    $s .= " where domain = '".$beforedomainname."' ";
                    $s .= " and client_id = " . $client_id;
                    $this->db->query($s);
                    /* update google analytics and chimp tables */
                    $this->addtag($currentDomainName);
                }
                else {
                    // Client Integration
                    $this->Default_Model_Customize->updateFunnelIntegrations([
                        "url"=> $thedomain
                    ], [
                        'client_id' => $client_id,
                        'leadpop_id' => $currentDomainName['leadpop_id'],
                        'leadpop_vertical_id' => $lpres['leadpop_vertical_id'],
                        'leadpop_vertical_sub_id' => $lpres['leadpop_vertical_sub_id'],
                        'leadpop_template_id' => $lpres['leadpop_template_id'],
                        'leadpop_version_id' => $lpres['leadpop_version_id'],
                        'leadpop_version_seq' => $version_seq
                    ]);

                    $s = "insert into clients_funnels_domains (id,client_id,domain_name,leadpop_vertical_id,";
                    $s .= "leadpop_vertical_sub_id,leadpop_type_id,leadpop_template_id,";
                    $s .= "leadpop_id,leadpop_version_id,leadpop_version_seq) values (null,";
                    $s .= $client_id.",'".$thedomain."',".$lpres['leadpop_vertical_id'].",";
                    $s .= $lpres['leadpop_vertical_sub_id'].",".$lpres['leadpop_type_id'].",";
                    $s .= $lpres['leadpop_template_id'].",".$leadpop_id.",".$lpres['leadpop_version_id'].",";
                    $s .= $version_seq . ")";
                    $this->db->query($s);
                    $thedomain_id = $this->db->lastInsertId();
                    $new_domain_id = $thedomain_id;

                    // Updating funnel pixels
                    $this->Default_Model_Pixel->updatePixel([
                        "domain_id"=> $new_domain_id
                    ], [
                            "client_id" => $client_id,
                            "domain_id"=> $old_domain_id,
                            "leadpops_id" => $leadpop_id
                        ]
                    );

                    /* add chg domain name in clients_emma_group  4/7/2016
						 we only update change in domain names. this is for cleints who
						 sign up for the free-trial. to put in previous clients into emma we need
						 to find another way. bbbbbbbbbbbbbbbbbbbbbbb
					*/
                    $s = "select * from  client_emma_group  ";
                    $s .= "where leadpop_vertical_id = " . $lpres['leadpop_vertical_id'];
                    $s .= " and leadpop_subvertical_id = " . $lpres['leadpop_vertical_sub_id'];
                    $s .= " and domain_name = '" . $currentDomainName['domain_name'] . "' ";
                    $s .= " and client_id = " . $client_id . " limit 1 ";

                    $emmaExists =  $this->db->fetchAll($s);

                    if ($emmaExists) {

                        $s = "delete from  client_emma_group  ";
                        $s .= " where id = " .$emmaExists[0]["id"];
                        $this->db->query($s);

                        $s = "insert into client_emma_group  (id,client_id,domain_name,member_account_id,member_group_id,";
                        $s .= "group_name,total_contacts,leadpop_vertical_id,leadpop_subvertical_id,active) values (null,";
                        $s .= $client_id .",'" .$thedomain."',".$emmaExists[0]["member_account_id"].",".$emmaExists[0]["member_group_id"].",'";
                        $s .= $emmaExists[0]["group_name"]."',0,".$emmaExists[0]["leadpop_vertical_id"].",".$emmaExists[0]["leadpop_subvertical_id"].",'y')";
                        $this->db->query($s);
                    }



                    $s = "select * from clients_funnels_domains where clients_domain_id = " . $thedomain_id . " AND leadpop_type_id=" . self::$leadpopDomainTypeId;
                    $mdomain = $this->db->fetchRow($s);

                    /* new mobileclients code */

                    $length = 15;
                    $randchars = $this->generateRandomString($length);

                    /* insert google analytics and chimp tables */
                    $googleDomain = $thedomain;
                    $this->insertPurchasedGoogle($client_id,$googleDomain);
                    /* update google analytics and chimp tables */

                    /*
                    if(count($unlimitedDomainsRow) > 0) {
                        $s = "insert into unlimited_domains (id,client_id,invoice_number,line_item_keys,domain_id) values (null,";
                        $s .= $client_id.",'".$unlimitedDomainsRow[0]['invoice_number']."','".$unlimitedDomainsRow[0]['line_item_keys']."',";
                        $s .= $thedomain_id . ")";
                        $this->db->query($s);
                    }
                    else {
                        $s = "insert into unlimited_domains (id,client_id,invoice_number,line_item_keys,domain_id) values (null,";
                        $s .= $client_id.",'','".$line_item_keys."',";
                        $s .= $thedomain_id . ")";
                        $this->db->query($s);
                    }
                    */

                    $this->addtag($mdomain);
                }
                $this->registry->leadpops->customLeadpopid = $leadpop_id;
                $this->registry->leadpops->leadpopType = 2;

                $verticalname = $this->getVerticalName($lpres['leadpop_vertical_id']);
                $subverticalname = $this->getSubVerticalName($lpres['leadpop_vertical_id'],$lpres['leadpop_vertical_sub_id']);
                $this->setworkinglink($leadpop_id,$verticalname,$subverticalname,$version_seq);

                $s = "select id from clients_leadpops ";
                $s .= " where client_id = " . $client_id;
                $s .= " and leadpop_version_id =  " . $lpres['leadpop_version_id'];
                $s .= " and leadpop_version_seq =  " . $version_seq;
                $leadpop_client_id = $this->db->fetchOne($s);
                $response = $this->successResponse($success_message, [
                    "domain_id" => $thedomain_id,
                    "leadpop_id" => $leadpop_id,
                    "domain_type" => self::$leadpopDomainTypeId
                ]);
//                print "ok~2~".$thedomain_id."~".$leadpop_id;
            }

            else if($domaintype == self::$leadpopSubDomainTypeId) { // switching from a sub-domain to a domain  so delete sub domain and insert the domain
                // get 'keys' from sub-domain row
                if($hasunlimited == true) {
                    $s = "select clients_domain_id AS id, subdomain_name, top_level_domain, leadpop_vertical_id, leadpop_vertical_sub_id, leadpop_type_id, leadpop_id, leadpop_template_id, ";
                    $s .= " leadpop_version_id, leadpop_version_seq from clients_funnels_domains "  ;
                    $s .= " where client_id  = " . $client_id;
                    $s .= " and leadpop_version_id = " . $lpres['leadpop_version_id'];
                    $s .= " and leadpop_version_seq = " . $version_seq;
                    $previousKeys = $this->db->fetchRow($s);
                    $originalsubdomain = $previousKeys['subdomain_name'].".".$previousKeys['top_level_domain'];
                    $old_domain_id = $previousKeys['id'];
                    $old_wp_url = $originalsubdomain;
                    $new_wp_url = $thedomain;

                    /* need to delete sub-domain google analytics */
                    $s = " delete from purchased_google_analytics where domain = '".$originalsubdomain."' ";
                    $s .= " and client_id = " . $client_id;
                    $this->db->query($s);

                    /* Get new leadpop_id according to leadpop_type_id */
                    $s = "select id from leadpops ";
                    $s .= " where leadpop_vertical_id = " . $lpres['leadpop_vertical_id'];
                    $s .= " and leadpop_vertical_sub_id = " . $lpres['leadpop_vertical_sub_id'];
                    $s .= " and leadpop_type_id = " . self::$leadpopDomainTypeId;
                    $s .= " and leadpop_template_id = " . $lpres['leadpop_template_id'];
                    $s .= " and leadpop_version_id = " . $lpres['leadpop_version_id'];
                    $newLeadpopId = $this->db->fetchOne($s);

                    // Client Integration
                    $this->Default_Model_Customize->updateFunnelIntegrations([
                        "url"=> $thedomain,
                        "leadpop_id" => $newLeadpopId
                    ], [
                        'client_id' => $client_id,
                        "leadpop_id" => $leadpop_id,
                        'leadpop_vertical_id' => $lpres['leadpop_vertical_id'],
                        'leadpop_vertical_sub_id' => $lpres['leadpop_vertical_sub_id'],
                        'leadpop_template_id' => $lpres['leadpop_template_id'],
                        'leadpop_version_id' => $lpres['leadpop_version_id'],
                        'leadpop_version_seq' => $version_seq
                    ]);

                    /* switch leadpop_id and leadpop_type_id for leadpop_background_color */
                    $s = "update leadpop_background_color set leadpop_id = " . $newLeadpopId;
                    $s .= " ,leadpop_type_id = " . self::$leadpopDomainTypeId;
                    $s .= " where leadpop_type_id = " . self::$leadpopSubDomainTypeId;
                    $s .= " and client_id = " . $client_id;
                    $s .= " and leadpop_version_id = " . $lpres['leadpop_version_id'];
                    $s .= " and leadpop_version_seq = " . $version_seq;
                    $this->db->query($s);

                    /* switch leadpop_id and leadpop_type_id for leadpop_background_swatches */
                    $s = "update leadpop_background_swatches set leadpop_id = " . $newLeadpopId;
                    $s .= " ,leadpop_type_id = " . self::$leadpopDomainTypeId;
                    $s .= " where client_id = " . $client_id;
                    $s .= " and leadpop_version_id = " . $lpres['leadpop_version_id'];
                    $s .= " and leadpop_version_seq = " . $version_seq;
                    $this->db->query($s);

                    /* need to change the leadpop_id in the lead_summary and lead_content tables 12/12/2012 */
                    $s = "update lead_summary set  leadpop_id = " . $newLeadpopId;
                    $s .= " where client_id  = " . $client_id;
                    $s .= " and leadpop_vertical_id = " . $lpres['leadpop_vertical_id'];
                    $s .= " and leadpop_vertical_sub_id = " . $lpres['leadpop_vertical_sub_id'];
                    $s .= " and leadpop_template_id = " . $lpres['leadpop_template_id'];
                    $s .= " and leadpop_id = " . $leadpop_id;
                    $s .= " and leadpop_version_id = " . $lpres['leadpop_version_id'];
                    $this->db->query($s);

                    /* need to change the leadpop_id in the leadpop_background_color   tables 2/14/2016  */
                    $s = "update lead_content set  leadpop_id = " . $newLeadpopId;
                    $s .= " where client_id  = " . $client_id;
                    $s .= " and leadpop_version_id = " . $lpres['leadpop_version_id'];
                    $s .= " and leadpop_version_seq = " . $version_seq;
                    $this->db->query($s);

                    // get new thank you submission_options
                    $s = "select thankyou from submission_options ";
                    $s .= " where leadpop_type_id = " . self::$leadpopSubDomainTypeId;
                    $s .= " and client_id = " . $client_id;
                    $s .= " and leadpop_version_id = " . $lpres['leadpop_version_id'];
                    $s .= " and leadpop_version_seq = " . $version_seq . " limit 1 ";
                    $asubmission = $this->db->fetchRow($s);
                    $originalthankyou = $asubmission['thankyou'];
                    $newthankyou = str_replace($originalsubdomain,$thedomain,$originalthankyou);

                    $line_item_keys = $previousKeys['leadpop_vertical_id']."-";
                    $line_item_keys .= $previousKeys['leadpop_vertical_sub_id']."-";
                    $line_item_keys .= $previousKeys['leadpop_version_id']."-";
                    $line_item_keys .= self::$leadpopDomainTypeId."-";
                    $line_item_keys .= $version_seq;

                    /*
                    $s = "select * from unlimited_domains where line_item_keys = '".$line_item_keys."' ";
                    $s .= " and client_id = " . $client_id . ' limit 1 ';
                    $unlimitedDomainsRow = $this->db->fetchAll($s);
                    */


                    $s = "select * from leadpops where leadpop_type_id = " . self::$leadpopDomainTypeId;
                    $s .= " and leadpop_vertical_id = " . $lpres['leadpop_vertical_id'];
                    $s .= " and leadpop_vertical_sub_id = " . $lpres['leadpop_vertical_sub_id'];
                    $s .= " and leadpop_template_id = " . $lpres['leadpop_template_id'];
                    $s .= " and leadpop_version_id = " . $lpres['leadpop_version_id'];
                    $newlp  = $this->db->fetchRow($s);

                    // check to see if only domain is temporary if so update domain_name, else insert new domain name
                    $s = "select clients_domain_id AS id, domain_name, leadpop_vertical_sub_id, leadpop_type_id, leadpop_id, leadpop_template_id, leadpop_version_id, leadpop_version_seq from clients_funnels_domains";
                    $s .= " where client_id  = " . $client_id;
                    $s .= " and leadpop_vertical_id = " . $lpres['leadpop_vertical_id'];
                    $s .= " and leadpop_vertical_sub_id = " . $lpres['leadpop_vertical_sub_id'];
                    $s .= " and leadpop_template_id = " . $lpres['leadpop_template_id'];
                    $s .= " and leadpop_id = " . $newlp['id'];
                    $s .= " and leadpop_version_id = " . $lpres['leadpop_version_id'];
                    $s .= " and leadpop_version_seq = " . $version_seq;
                    $s .= " and leadpop_type_id = " . self::$leadpopDomainTypeId;
                    $temporaryDomainName = $this->db->fetchRow($s);

                    //if temporary domain exist then Update else Insert entry for domain
                    if(!empty($temporaryDomainName) and $temporaryDomainName['domain_name'] == 'temporary'){
                        $s = "update clients_funnels_domains set domain_name = '".$thedomain."' ";
                        $s .= " where clients_domain_id = " . $temporaryDomainName['id'];
                        $this->db->query($s);
                        $thedomain_id = $temporaryDomainName['id'];
                        $new_domain_id = $thedomain_id;

                        /* add chg domain name in clients_emma_group  4/7/2016
                             we only update change in domain names. this is for cleints who
                             sign up for the free-trial. to put in previous clients into emma we need
                             to find another way. aaaaaaaaaaaaaaaa
                        */
                        $s = "select * from  client_emma_group where domain_name = '" . $originalsubdomain . "' limit 1 ";
                        $emmaExists =  $this->db->fetchAll($s);
                        if ($emmaExists) {
                            $s = "update client_emma_group set domain_name = '".$thedomain."' where domain_name = '".$originalsubdomain."' limit 1 ";
                            $this->db->query($s);
                        }

                        /* update google analytics and chimp tables */
                        $s = "update  purchased_google_analytics set domain = '".$thedomain."' ";
                        $s .= " where domain = '".$temporaryDomainName['domain_name']."' ";
                        $s .= " and client_id = " . $client_id;
                        $this->db->query($s);
                        /* update google analytics and chimp tables */

                        $length = 15;
                        $randchars = $this->generateRandomString($length);
                        $this->addtag($temporaryDomainName);
                        $mdomain = $temporaryDomainName;

                    }
                    else {
                        // We don't need to delete & insert again now as table is common now for domain & subdomain so just update row
                        if(env('CLIENTS_SUBDOMAIN_ENABLE', 0) == 1){    // to enable old subdomain table
                            $s = " insert into clients_funnels_domains (id,client_id,domain_name,";
                            $s .= "leadpop_vertical_id,leadpop_vertical_sub_id,leadpop_type_id,";
                            $s .= "leadpop_template_id, leadpop_id,leadpop_version_id,leadpop_version_seq) values (null,";
                            $s .= $client_id . ",'" . $thedomain."',".$newlp['leadpop_vertical_id'].",";
                            $s .= $newlp['leadpop_vertical_sub_id'].",".$newlp['leadpop_type_id'].",".$newlp['leadpop_template_id'].",";
                            $s .= $newlp['id'].",".$newlp['leadpop_version_id'].",".$version_seq.")";
                            $this->db->query($s);
                            $thedomain_id = $this->db->lastInsertId();
                            $new_domain_id = $thedomain_id;

                            $s = "select clients_domain_id AS id, domain_name, leadpop_vertical_sub_id, leadpop_type_id, leadpop_id, leadpop_template_id, leadpop_version_id, leadpop_version_seq from clients_funnels_domains where id = " . $thedomain_id;
                            $mdomain = $this->db->fetchRow($s);
                            $this->addtag($mdomain);
                        }
                        else{
                            $s = "update clients_funnels_domains set domain_name = '".$thedomain."', leadpop_type_id = ".$newlp['leadpop_type_id'].", leadpop_id = ".$newlp['id'];
                            $s .= " , subdomain_name='', top_level_domain=''";
                            $s .= " WHERE client_id = ".$client_id;
                            $s .= " AND leadpop_type_id = ".self::$leadpopSubDomainTypeId;
                            $s .= " AND leadpop_version_id = ".$newlp['leadpop_version_id'];
                            $s .= " AND leadpop_version_seq = ".$version_seq;
                            $s .= " AND clients_domain_id = ".$thedomain_id;
                            $this->db->query($s);
                            $new_domain_id = $thedomain_id;
                        }

                        $s = "  select * from  client_emma_group  ";
                        $s .= " where leadpop_vertical_id = " . $newlp['leadpop_vertical_id'];
                        $s .= " and leadpop_subvertical_id = " . $newlp['leadpop_vertical_sub_id'];
                        $s .= " and domain_name = '".$originalsubdomain."' ";
                        $s .= " and client_id = " . $client_id . " limit 1 ";

                        $emmaExists =  $this->db->fetchAll($s);
                        if ($emmaExists) {
                            $s = "delete from  client_emma_group  ";
                            $s .= " where id = " .$emmaExists[0]["id"];
                            $this->db->query($s);

                            $s = "insert into client_emma_group  (id,client_id,domain_name,member_account_id,member_group_id,";
                            $s .= "group_name,total_contacts,leadpop_vertical_id,leadpop_subvertical_id,active) values (null,";
                            $s .= $client_id .",'" .$thedomain."',".$emmaExists[0]["member_account_id"].",".$emmaExists[0]["member_group_id"].",'";
                            $s .= $emmaExists[0]["group_name"]."',0,".$emmaExists[0]["leadpop_vertical_id"].",".$emmaExists[0]["leadpop_subvertical_id"].",'y')";
                            $this->db->query($s);
                        }

                        /* google analytics */
                        $googleDomain = $thedomain;
                        $this->insertPurchasedGoogle($client_id,$googleDomain);
                        /* google analytics */

                        /*
                        if(is_array($unlimitedDomainsRow) && count($unlimitedDomainsRow) > 0) {
                            $s = "insert into unlimited_domains (id,client_id,invoice_number,line_item_keys,domain_id) values (null,";
                            $s .= $client_id.",'".$unlimitedDomainsRow[0]['invoice_number']."','".$unlimitedDomainsRow[0]['line_item_keys']."',";
                            $s .= $thedomain_id . ")";
                            $this->db->query($s);
                        }
                        else {
                            $s = "insert into unlimited_domains (id,client_id,invoice_number,line_item_keys,domain_id) values (null,";
                            $s .= $client_id.",'','".$line_item_keys."',";
                            $s .= $thedomain_id . ")";
                            $this->db->query($s);
                        }
                        */
                    }

                    if(env('CLIENTS_SUBDOMAIN_ENABLE', 0) == 1) {    // to enable old subdomain table
                        // Updating funnel pixels on changing domain_id
                        $this->Default_Model_Pixel->updatePixel([
                            "domain_id" => $new_domain_id,
                            "leadpops_id" => $newlp['id']
                        ], [
                                "client_id" => $client_id,
                                "domain_id" => $_POST['thedomain_id'],
                                "leadpops_id" => $leadpop_id
                            ]
                        );

                        $s = "delete from clients_funnels_domains ";
                        $s .= " where client_id  = " . $client_id;
                        $s .= " and leadpop_vertical_id = " . $lpres['leadpop_vertical_id'];
                        $s .= " and leadpop_vertical_sub_id = " . $lpres['leadpop_vertical_sub_id'];
                        $s .= " and leadpop_type_id = " . $lpres['leadpop_type_id'];
                        $s .= " and leadpop_template_id = " . $lpres['leadpop_template_id'];
                        $s .= " and leadpop_id = " . $leadpop_id;
                        $s .= " and leadpop_version_id = " . $lpres['leadpop_version_id'];
                        $s .= " and leadpop_version_seq = " . $version_seq;
                        $this->db->query($s);
                    }
                    else{
                        $this->Default_Model_Pixel->updatePixel([
                            "leadpops_id" => $newlp['id']
                        ], [
                                "client_id" => $client_id,
                                "domain_id" => $_POST['thedomain_id'],
                                "leadpops_id" => $leadpop_id
                            ]
                        );
                    }

                    $s = "update clients_leadpops set leadpop_id = ".$newlp['id'];
                    $s .= " where client_id = " . $client_id;
                    $s .= " and leadpop_version_id =  " . $newlp['leadpop_version_id'];
                    $s .= " and leadpop_version_seq =  " . $version_seq;
                    $this->db->query($s);

                    /* Get id from clients_leadpops to update in lead_stats */
                    $s = "select id from clients_leadpops ";
                    $s .= " where client_id = " . $client_id;
                    $s .= " and leadpop_version_id =  " . $newlp['leadpop_version_id'];
                    $s .= " and leadpop_version_seq =  " . $version_seq;
                    $leadpop_client_id = $this->db->fetchOne($s);

                    if(env('CLIENTS_SUBDOMAIN_ENABLE', 0) == 1) {
                        $s = "UPDATE lead_stats SET leadpop_id = " . $newlp['id'] . ", leadpop_version_seq = " . $version_seq . ", domain_id = " . $thedomain_id . ", leadpop_client_id = " . $leadpop_client_id;
                    }
                    else{
                        $s = "UPDATE lead_stats SET leadpop_id = " . $newlp['id'] ;
                    }

                    $s .= " WHERE client_id  = " . $client_id;
                    $s .= " and leadpop_id = " . $leadpop_id;
                    $s .= " and domain_id = " . $previousKeys['id'];
                    $s .= " and leadpop_vertical_id = " . $lpres['leadpop_vertical_id'];
                    $s .= " and leadpop_vertical_sub_id = " . $lpres['leadpop_vertical_sub_id'];
                    $s .= " and leadpop_template_id = " . $lpres['leadpop_template_id'];
                    $s .= " and leadpop_version_id = " . $lpres['leadpop_version_id'];
                    $this->db->query($s);

                    $this->registry->leadpops->customLeadpopid = $newlp['id'];
                    $this->registry->leadpops->leadpopType = 2;

                    $verticalname = $this->getVerticalName($newlp['leadpop_vertical_id']);
                    $subverticalname = $this->getSubVerticalName($newlp['leadpop_vertical_id'],$newlp['leadpop_vertical_sub_id']);
                    $this->setworkinglink($newlp['id'],$verticalname,$subverticalname,$version_seq);

                    /* need to change leadpop id and leadpop type for chimp */
                    $s = "update chimp set leadpop_id = " . $newlp['id'];
                    $s .= " ,leadpop_type_id = " . self::$leadpopDomainTypeId;
                    $s .= " where leadpop_type_id = " . self::$leadpopSubDomainTypeId;
                    $s .= " and client_id = " . $client_id;
                    $s .= " and leadpop_vertical_id = " . $newlp['leadpop_vertical_id'];
                    $s .= " and leadpop_vertical_sub_id = " . $newlp['leadpop_vertical_sub_id'];
                    $s .= " and leadpop_template_id = " . $newlp['leadpop_template_id'];
                    $s .= " and leadpop_version_id = " . $newlp['leadpop_version_id'];
                    $s .= " and leadpop_version_seq = " . $version_seq;
                    @$this->db->query($s);
                    /* need to change leadpop id and leadpop type for chimp */

                    /* need to change leadpop id and leadpop type */
                    $s = "update  leadpop_images set leadpop_id = " . $newlp['id'];
                    $s .= " ,leadpop_type_id = " . self::$leadpopDomainTypeId;
                    $s .= " where leadpop_type_id = " . self::$leadpopSubDomainTypeId;
                    $s .= " and client_id = " . $client_id;
                    $s .= " and leadpop_vertical_id = " . $newlp['leadpop_vertical_id'];
                    $s .= " and leadpop_vertical_sub_id = " . $newlp['leadpop_vertical_sub_id'];
                    $s .= " and leadpop_template_id = " . $newlp['leadpop_template_id'];
                    $s .= " and leadpop_version_id = " . $newlp['leadpop_version_id'];
                    $s .= " and leadpop_version_seq = " . $version_seq;
                    $this->db->query($s);

                    $s = "update  leadpop_logos set leadpop_id = " . $newlp['id'];
                    $s .= " ,leadpop_type_id = " . self::$leadpopDomainTypeId;
                    $s .= " where leadpop_type_id = " . self::$leadpopSubDomainTypeId;
                    $s .= " and client_id = " . $client_id;
                    $s .= " and leadpop_vertical_id = " . $newlp['leadpop_vertical_id'];
                    $s .= " and leadpop_vertical_sub_id = " . $newlp['leadpop_vertical_sub_id'];
                    $s .= " and leadpop_template_id = " . $newlp['leadpop_template_id'];
                    $s .= " and leadpop_version_id = " . $newlp['leadpop_version_id'];
                    $s .= " and leadpop_version_seq = " . $version_seq;
                    $this->db->query($s);

                    $s = "update  seo_options set leadpop_id = " . $newlp['id'];
                    $s .= " ,leadpop_type_id = " . self::$leadpopDomainTypeId;
                    $s .= " where leadpop_type_id = " . self::$leadpopSubDomainTypeId;
                    $s .= " and client_id = " . $client_id;
                    $s .= " and leadpop_vertical_id = " . $newlp['leadpop_vertical_id'];
                    $s .= " and leadpop_vertical_sub_id = " . $newlp['leadpop_vertical_sub_id'];
                    $s .= " and leadpop_template_id = " . $newlp['leadpop_template_id'];
                    $s .= " and leadpop_version_id = " . $newlp['leadpop_version_id'];
                    $s .= " and leadpop_version_seq = " . $version_seq;
                    $this->db->query($s);

                    $s = "update  autoresponder_options set leadpop_id = " . $newlp['id'];
                    $s .= " ,leadpop_type_id = " . self::$leadpopDomainTypeId;
                    $s .= " where leadpop_type_id = " . self::$leadpopSubDomainTypeId;
                    $s .= " and client_id = " . $client_id;
                    $s .= " and leadpop_version_id = " . $newlp['leadpop_version_id'];
                    $s .= " and leadpop_version_seq = " . $version_seq;
                    $this->db->query($s);

                    /* switch leadpop_id and leadpop_type_id for leadpop_background_color */
                    $s = "update leadpop_background_color set leadpop_id = " . $newlp['id'];
                    $s .= " ,leadpop_type_id = " . self::$leadpopDomainTypeId;
                    $s .= " where leadpop_type_id = " . self::$leadpopSubDomainTypeId;
                    $s .= " and client_id = " . $client_id;
                    $s .= " and leadpop_version_id = " . $newlp['leadpop_version_id'];
                    $s .= " and leadpop_version_seq = " . $version_seq;
                    $this->db->query($s);


                    /* switch leadpop_id and leadpop_type_id for leadpop_background_swatches */
                    $s = "update leadpop_background_swatches set leadpop_id = " . $newlp['id'];
                    $s .= " ,leadpop_type_id = " . self::$leadpopDomainTypeId;
                    $s .= " where client_id = " . $client_id;
                    $s .= " and leadpop_version_id = " . $newlp['leadpop_version_id'];
                    $s .= " and leadpop_version_seq = " . $version_seq;
                    $this->db->query($s);

                    /* 2/26/2016 code to copy favicon and colored dot to support the new domain */
                    /* code to copy favicon and colored dot to support the new domain */
                    $oldfilename = strtolower($client_id."_".$leadpop_id."_".$lpres['leadpop_type_id']."_".$lpres['leadpop_vertical_id']."_".$lpres['leadpop_vertical_sub_id']."_".$lpres['leadpop_template_id']."_".$lpres['leadpop_version_id']."_".$version_seq);
                    $newfilename = strtolower($client_id."_".$newlp['id']."_".$newlp['leadpop_type_id']."_".$newlp['leadpop_vertical_id']."_".$newlp['leadpop_vertical_sub_id']."_".$newlp['leadpop_template_id']."_".$newlp['leadpop_version_id']."_".$version_seq);
                    $favicon_dst_src = $_SERVER['DOCUMENT_ROOT'].'/images/clients/'. substr($client_id,0,1) . '/' . $client_id.'/logos/'.$oldfilename.'_favicon-circle.png';
                    if (file_exists($favicon_dst_src) ) { // already using non-default favicon so
                        $newfavicon_dst_src = $_SERVER['DOCUMENT_ROOT'].'/images/clients/'. substr($client_id,0,1) . '/' . $client_id.'/logos/'.$newfilename.'_favicon-circle.png';
                        $cmd = '/bin/cp  ' . $favicon_dst_src . '  ' . $newfavicon_dst_src;
                        exec($cmd);
                    }

                    $colored_dot_src = $_SERVER['DOCUMENT_ROOT'].'/images/clients/'. substr($client_id,0,1) . '/' . $client_id.'/logos/'.$oldfilename.'_dot_img.png';
                    if (file_exists($colored_dot_src) ) { // already using non-default favicon so
                        $newcolored_dot_src = $_SERVER['DOCUMENT_ROOT'].'/images/clients/'. substr($client_id,0,1) . '/' . $client_id.'/logos/'.$newfilename.'_dot_img.png';
                        $cmd = '/bin/cp  ' . $colored_dot_src . '  ' . $newcolored_dot_src;
                        exec($cmd);
                    }

                    $s = "update  bottom_links set leadpop_id = " . $newlp['id'];
                    $s .= " ,leadpop_type_id = " . self::$leadpopDomainTypeId;
                    $s .= " where leadpop_type_id = " . self::$leadpopSubDomainTypeId;
                    $s .= " and client_id = " . $client_id;
                    $s .= " and leadpop_vertical_id = " . $newlp['leadpop_vertical_id'];
                    $s .= " and leadpop_vertical_sub_id = " . $newlp['leadpop_vertical_sub_id'];
                    $s .= " and leadpop_template_id = " . $newlp['leadpop_template_id'];
                    $s .= " and leadpop_version_id = " . $newlp['leadpop_version_id'];
                    $s .= " and leadpop_version_seq = " . $version_seq;
                    $this->db->query($s);

                    $s = "update  submission_options set leadpop_id = " . $newlp['id'];
                    $s .= " ,leadpop_type_id = " . self::$leadpopDomainTypeId;
                    $s .= ", thankyou = '".addslashes($newthankyou)."' ";
                    $s .= " where leadpop_type_id = " . self::$leadpopSubDomainTypeId;
                    $s .= " and client_id = " . $client_id;
                    $s .= " and leadpop_version_id = " . $newlp['leadpop_version_id'];
                    $s .= " and leadpop_version_seq = " . $version_seq;
                    $this->db->query($s);

                    $s = "update  contact_options set leadpop_id = " . $newlp['id'];
                    $s .= " ,leadpop_type_id = " . self::$leadpopDomainTypeId;
                    $s .= " where leadpop_type_id = " . self::$leadpopSubDomainTypeId;
                    $s .= " and client_id = " . $client_id;
                    $s .= " and leadpop_vertical_id = " . $newlp['leadpop_vertical_id'];
                    $s .= " and leadpop_vertical_sub_id = " . $newlp['leadpop_vertical_sub_id'];
                    $s .= " and leadpop_template_id = " . $newlp['leadpop_template_id'];
                    $s .= " and leadpop_version_id = " . $newlp['leadpop_version_id'];
                    $s .= " and leadpop_version_seq = " . $version_seq;
                    $this->db->query($s);
                    // fart
                    $s = "update lp_auto_recipients set leadpop_id = " . $newlp['id'];
                    $s .= " ,leadpop_type_id = " . self::$leadpopDomainTypeId;
                    $s .= " where leadpop_type_id = " . self::$leadpopSubDomainTypeId;
                    $s .= " and client_id = " . $client_id;
                    $s .= " and leadpop_vertical_id = " . $newlp['leadpop_vertical_id'];
                    $s .= " and leadpop_vertical_sub_id = " . $newlp['leadpop_vertical_sub_id'];
                    $s .= " and leadpop_template_id = " . $newlp['leadpop_template_id'];
                    $s .= " and leadpop_version_id = " . $newlp['leadpop_version_id'];
                    $s .= " and leadpop_version_seq = " . $version_seq;
                    $this->db->query($s);

                    $s = "select id from lp_auto_recipients where ";
                    $s .= " leadpop_id = " . $newlp['id'];
                    $s .= " and leadpop_type_id = " . self::$leadpopDomainTypeId;
                    $s .= " and client_id = " . $client_id;
                    $s .= " and leadpop_vertical_id = " . $newlp['leadpop_vertical_id'];
                    $s .= " and leadpop_vertical_sub_id = " . $newlp['leadpop_vertical_sub_id'];
                    $s .= " and leadpop_template_id = " . $newlp['leadpop_template_id'];
                    $s .= " and leadpop_version_id = " . $newlp['leadpop_version_id'];
                    $s .= " and leadpop_version_seq = " . $version_seq;
                    $lp_auto_rows = $this->db->fetchAll($s);

                    for($xv = 0; $xv < count($lp_auto_rows); $xv++) {
                        $s = "update lp_auto_text_recipients  set leadpop_id = " . $newlp['id'];
                        $s .= " ,leadpop_type_id = " . self::$leadpopDomainTypeId;
                        $s .= " where lp_auto_recipients_id = " .  $lp_auto_rows[$xv]['id'];
                        $this->db->query($s);
                    }

                    /**
                     * leadpop_multiple_step is not in use any more
                     */
                    /*
                    $s = "  select count(*) as cnt ";
                    $s .= " from leadpop_multiple_step ";
                    $s .= " where client_id = " . $client_id;
                    $s .= " and leadpop_description_id = " . $lpres['leadpop_version_id'];
                    $s .= " and leadpop_id = " . $lpres['id'];
                    $s .= " and leadpop_template_id = " . $lpres['leadpop_template_id'];
                    $multicount = $this->db->fetchOne($s);

                    if($multicount > 0) {
                        $s = "update leadpop_multiple_step ";
                        $s .= " set leadpop_description_id = " . $newlp['leadpop_version_id'];
                        $s .= " ,leadpop_id = " . $newlp['id'];
                        $s .= " ,leadpop_template_id = " . $newlp['leadpop_template_id'];
                        $s .= " where client_id = " . $client_id;
                        $s .= " and leadpop_description_id = " . $lpres['leadpop_version_id'];
                        $s .= " and leadpop_id = " . $lpres['id'];
                        $s .= " and leadpop_template_id = " . $lpres['leadpop_template_id'];
                        $this->db->query($s);
                    }
                    */

                    /* need to change leadpop id and leadpop type */
                    if(getenv('APP_ENV') != config('app.env_local')) {
                        //Changing lead_content key in keydb because leadpop_id is updated
                        \MyLeads_Helper::getInstance()->changeRedisKey($client_id, $lpres['id'], $version_seq, $newlp['id']);
                    }

                    $response = $this->successResponse($success_message, [
                        "domain_id" => $thedomain_id,
                        "leadpop_id" => $newlp['id'],
                        "domain_type" => self::$leadpopDomainTypeId
                    ]);
//                    print "ok~2~".$thedomain_id."~".$newlp['id'];
                }
            }

            /*
            *Disable as per sir @sal
            */
            //$this->updateClientWebsite($client_id, $old_wp_url, $new_wp_url, $leadpop_client_id);
            $this->updateFunnelTimestamp(array("client_id"=>$client_id, "client_leadpop_id"=>$leadpop_client_id));



            if($response != null) {
                return $response;
            } else {
                return $this->errorResponse();
            }
        }
        else {
            return $this->errorResponse('Domain ' . $thedomain . ' is not available.', [
                "taken" => true
            ]);
//            print "taken~0~0";
        }

    }

    public function deletethisdomainAction()  {
        $domainToDelete = $_POST['deleteThisDomain'];
        if(getenv('APP_ENV') == config('app.env_staging')) {
            $toplevel = 'dev-funnels.com';
        } else {
            $toplevel = 'secure-clix.com';
        }

        return $this->changeToDefaultSubdomain($this->client_id,$domainToDelete,$toplevel);
    }
    private function changeToDefaultSubdomain($client_id,$domain_id,$toplevel) {
        $s = "select * from clients where client_id = " . $client_id;
        $client = $this->db->fetchRow( $s );

        $s = "SELECT clients_domain_id as id, client_id, domain_name, leadpop_id, leadpop_type_id, leadpop_version_id, leadpop_version_seq, leadpop_vertical_id, leadpop_vertical_sub_id FROM clients_funnels_domains WHERE clients_domain_id = '".$domain_id."' AND leadpop_type_id=" . self::$leadpopDomainTypeId;
        $domaindata = $this->db->fetchRow($s);

        $client_id = $domaindata['client_id'];
        $originaldomain = $domaindata['domain_name'];

        $leadpop_id = $domaindata['leadpop_id']; // old
        $version_seq = $domaindata['leadpop_version_seq'];

        $s     = "select * from leadpops where id = " . $leadpop_id;
        $lpres = $this->db->fetchRow( $s ); //leadpop result

        //check if multi domain add against to same vertical,sub_vertical,version_id and version_seq
        //start
        $domainsQuery = \DB::table("clients_funnels_domains")
            ->where("client_id", $client_id)
            ->where("leadpop_id", $leadpop_id)
            ->where("leadpop_vertical_id", $lpres['leadpop_vertical_id'])
            ->where("leadpop_vertical_sub_id", $lpres['leadpop_vertical_sub_id'])
            ->where("leadpop_type_id", self::$leadpopDomainTypeId)
            ->where("leadpop_template_id", $lpres['leadpop_template_id'])
            ->where("leadpop_version_id", $lpres['leadpop_version_id'])
            ->where("leadpop_version_seq", $version_seq);

        $rows_count =$domainsQuery->count();
        if($rows_count > 1){
            $query = "DELETE FROM clients_funnels_domains ".
                " WHERE clients_domain_id = '$domain_id'" .
                " AND client_id  = " . $client_id .
                " AND leadpop_type_id  = " . self::$leadpopDomainTypeId;
            $this->db->query( $query );

            $currentDomain = $domainsQuery->select("clients_domain_id as id", "domain_name")
                ->orderBy('id', 'desc')
                ->first();

            // Updating client integrations
            $this->Default_Model_Customize->updateFunnelIntegrations([
                "url"=> $currentDomain->domain_name
            ],[
                'client_id' => $client_id,
                "leadpop_id" => $leadpop_id,
                'leadpop_vertical_id' => $lpres['leadpop_vertical_id'],
                'leadpop_vertical_sub_id' => $lpres['leadpop_vertical_sub_id']  ,
                'leadpop_template_id' => $lpres['leadpop_template_id'],
                'leadpop_version_id' => $lpres['leadpop_version_id'],
                'leadpop_version_seq' => $version_seq
            ]);

            // Updating funnel pixels
            $this->Default_Model_Pixel->updatePixel([
                "domain_id" => $currentDomain->id
            ], [
                    "client_id" => $client_id,
                    "domain_id" => $domain_id,
                    "leadpops_id" => $leadpop_id
                ]
            );

            return $this->successResponse('Domain ' . $originaldomain . ' has been deleted.', [
                "current_domain" => $currentDomain->domain_name,
                "deleted_domain" => $originaldomain,
                "domain_id" => $currentDomain->id,
                "action" => "delete"
            ]);
//            print "delete~2~".$currentDomain->domain_name."~".$originaldomain."~".$currentDomain->id;
        }
        //end
        else {

            $s = "select funnel_url_prefix from trial_launch_defaults ";
            $s .= " where leadpop_vertical_id = " . $domaindata['leadpop_vertical_id'];
            $s .= " and leadpop_vertical_sub_id = " . $domaindata['leadpop_vertical_sub_id'];
            $funnel_prefix = $this->db->fetchOne($s);

            $subdomain = $funnel_prefix . "-" . $client_id . "-" . $version_seq; //va-refi-4049-1
            $topdomain = $toplevel;

            $domaintype = $domaindata['leadpop_type_id'];

            $s = "select count(*) as cnt from clients_funnels_domains where subdomain_name = '" . $subdomain . "' AND leadpop_type_id=" . self::$leadpopSubDomainTypeId;
            $s .= " and top_level_domain = '" . $topdomain . "' ";
            $cnt = $this->db->fetchOne($s);

            if ($cnt == 0) {
                $response = null;
                $select = "SELECT * FROM clients_funnels_domains WHERE clients_domain_id = " . $domaindata["id"] . " AND leadpop_type_id=" . self::$leadpopDomainTypeId;
                $old_domain = $this->db->fetchAll($select);

                if ($domaintype == self::$leadpopDomainTypeId) {

                    $newsubdomain = $subdomain . "." . $topdomain;

                    /* need to change the leadpop_id in the lead_summary and lead_content tables 12/12/2012 */
                    $s = "select id from leadpops ";
                    $s .= " where leadpop_vertical_id = " . $lpres['leadpop_vertical_id'];
                    $s .= " and leadpop_vertical_sub_id = " . $lpres['leadpop_vertical_sub_id'];
                    $s .= " and leadpop_type_id = " . self::$leadpopSubDomainTypeId;
                    $s .= " and leadpop_template_id = " . $lpres['leadpop_template_id'];
                    $s .= " and leadpop_version_id = " . $lpres['leadpop_version_id'];
                    $newLeadpopId = $this->db->fetchOne($s);

                    // Updating leadpop ID and funnel URL
                    $this->Default_Model_Customize->updateFunnelIntegrations([
                        "url"=> ($subdomain . "." . $topdomain),
                        "leadpop_id" => $newLeadpopId
                    ],[
                        'client_id' => $client_id,
                        "leadpop_id" => $leadpop_id,
                        'leadpop_vertical_id' => $lpres['leadpop_vertical_id'],
                        'leadpop_vertical_sub_id' => $lpres['leadpop_vertical_sub_id']  ,
                        'leadpop_template_id' => $lpres['leadpop_template_id'],
                        'leadpop_version_id' => $lpres['leadpop_version_id'],
                        'leadpop_version_seq' => $version_seq
                    ]);

                    $s = "update lead_summary set  leadpop_id = " . $newLeadpopId;
                    $s .= " where client_id  = " . $client_id;
                    $s .= " and leadpop_vertical_id = " . $lpres['leadpop_vertical_id'];
                    $s .= " and leadpop_vertical_sub_id = " . $lpres['leadpop_vertical_sub_id'];
                    $s .= " and leadpop_template_id = " . $lpres['leadpop_template_id'];
                    $s .= " and leadpop_id = " . $leadpop_id;
                    $s .= " and leadpop_version_id = " . $lpres['leadpop_version_id'];
                    $this->db->query($s);
                    // done
                    $s = "update lead_content set  leadpop_id = " . $newLeadpopId;
                    $s .= " where client_id  = " . $client_id;
                    $s .= " and leadpop_version_id = " . $lpres['leadpop_version_id'];
                    $s .= " and leadpop_version_seq = " . $version_seq;
                    $this->db->query($s);
                    // done

                    /* we have the original leadpop_id nd the newleadpopid, so change the values in the leadpop_background_color table */
                    /* switch leadpop_id and leadpop_type_id for leadpop_background_color */
                    $s = "update leadpop_background_color set leadpop_id = " . $newLeadpopId;
                    $s .= " ,leadpop_type_id = " . self::$leadpopSubDomainTypeId;
                    $s .= " where leadpop_type_id = " . self::$leadpopDomainTypeId;
                    $s .= " and client_id = " . $client_id;
                    $s .= " and leadpop_version_id = " . $lpres['leadpop_version_id'];
                    $s .= " and leadpop_version_seq = " . $version_seq;
                    $this->db->query($s);
                    // done
                    /* we have the original leadpop_id nd the newleadpopid, so change the values in the leadpop_background_color table */
                    /* switch leadpop_id and leadpop_type_id for leadpop_background_color */

                    /* switch leadpop_id and leadpop_type_id for leadpop_background_color */
                    /* need to change the leadpop_id in the leadpops_summary and leadpop_content tables 12/12/2012 */

                    $s = "select clients_domain_id as id, domain_name from clients_funnels_domains";
                    $s .= " where client_id  = " . $client_id;
                    $s .= " and leadpop_version_id = " . $lpres['leadpop_version_id'];
                    $s .= " and leadpop_version_seq = " . $version_seq . " limit 1 ";
                    $old_domains = $this->db->fetchRow($s);
                    $previousDomainId = $old_domains['id'];
                    $originaldomain = $old_domains['domain_name'];

                    $s = "select thankyou from  submission_options ";
                    $s .= " where leadpop_type_id = " . self::$leadpopDomainTypeId;
                    $s .= " and client_id = " . $client_id;
                    $s .= " and leadpop_version_id = " . $lpres['leadpop_version_id'];
                    $s .= " and leadpop_version_seq = " . $version_seq;
                    $athankyou = $this->db->fetchRow($s);
                    $originalthankyou = $athankyou['thankyou'];

                    $newthankyou = str_replace($originaldomain, $newsubdomain, $originalthankyou);

                    $line_item_key = $lpres['leadpop_vertical_id'] . "-";
                    $line_item_key .= $lpres['leadpop_vertical_sub_id'] . "-";
                    $line_item_key .= $lpres['leadpop_version_id'] . "-";
                    $line_item_key .= $lpres['leadpop_type_id'] . "-";
                    $line_item_key .= $version_seq;

                    /*
                    $s = "select invoice_number from unlimited_domains ";
                    $s .= " where line_item_keys = '" . $line_item_key . "' ";
                    $s .= " and client_id = " . $client_id . " limit 1 ";
                    $invoice_number = $this->db->fetchOne($s);

                    $s = "delete from unlimited_domains where client_id = " . $client_id;
                    $s .= " and line_item_keys = '" . $line_item_key . "' ";
                    $this->db->query($s);
                    */

                    $s = " delete from purchased_google_analytics where domain = '" . $originaldomain . "' ";
                    $s .= " and client_id = " . $client_id;
                    $this->db->query($s);
                    // done

                    $googleDomain = 'temporary';

                    $this->insertPurchasedGoogle($client_id, $googleDomain);

                    $s = "  delete from clients_funnels_domains";
                    $s .= " where client_id  = " . $client_id;
                    $s .= " and leadpop_vertical_id = " . $lpres['leadpop_vertical_id'];
                    $s .= " and leadpop_vertical_sub_id = " . $lpres['leadpop_vertical_sub_id'];
                    $s .= " and leadpop_type_id = " . $lpres['leadpop_type_id'];
                    $s .= " and leadpop_template_id = " . $lpres['leadpop_template_id'];
                    $s .= " and leadpop_id = " . $leadpop_id;
                    $s .= " and leadpop_version_id = " . $lpres['leadpop_version_id'];
                    $s .= " and leadpop_version_seq = " . $version_seq;
                    $this->db->query($s);

                    // NOT IN USE ANY MORE
                    /*
                    $s = "select lower(nonmobiledomain) as nmd from mobileclients ";
                    $s .= " where client_id  = " . $client_id;
                    $s .= " and leadpop_vertical_id = " . $lpres['leadpop_vertical_id'];
                    $s .= " and leadpop_vertical_sub_id = " . $lpres['leadpop_vertical_sub_id'];
                    $s .= " and leadpop_type_id = " . $lpres['leadpop_type_id'];
                    $s .= " and leadpop_template_id = " . $lpres['leadpop_template_id'];
                    $s .= " and leadpop_id = " . $leadpop_id;
                    $s .= " and leadpop_version_id = " . $lpres['leadpop_version_id'];
                    $s .= " and leadpop_version_seq = " . $version_seq . " limit 1 ";
                    $nonmobiledomain = $this->db->fetchAll($s);
                    if ($nonmobiledomain) {

                    }

                    $s = "delete from mobileclients ";
                    $s .= " where client_id  = " . $client_id;
                    $s .= " and leadpop_vertical_id = " . $lpres['leadpop_vertical_id'];
                    $s .= " and leadpop_vertical_sub_id = " . $lpres['leadpop_vertical_sub_id'];
                    $s .= " and leadpop_type_id = " . $lpres['leadpop_type_id'];
                    $s .= " and leadpop_template_id = " . $lpres['leadpop_template_id'];
                    $s .= " and leadpop_id = " . $leadpop_id;
                    $s .= " and leadpop_version_id = " . $lpres['leadpop_version_id'];
                    $s .= " and leadpop_version_seq = " . $version_seq;
                    $this->db->query($s);

                    $s = "insert into clients_funnels_domains (id,client_id,domain_name,leadpop_vertical_id,";
                    $s .= "leadpop_vertical_sub_id,leadpop_type_id,leadpop_template_id,";
                    $s .= "leadpop_id,leadpop_version_id,leadpop_version_seq) values (null,";
                    $s .= $client_id . ",'temporary'," . $lpres['leadpop_vertical_id'] . ",";
                    $s .= $lpres['leadpop_vertical_sub_id'] . "," . $lpres['leadpop_type_id'] . ",";
                    $s .= $lpres['leadpop_template_id'] . "," . $leadpop_id . "," . $lpres['leadpop_version_id'] . ",";
                    $s .= $version_seq . ")";
                    $this->db->query($s);
                    $newdomain_id = $this->db->lastInsertId();

                    $s = "insert into unlimited_domains (id,client_id,invoice_number,line_item_keys,domain_id) values (null,";
                    $s .= $client_id . ",'" . $invoice_number . "','" . $line_item_key . "',";
                    $s .= $newdomain_id . ")";
                    $this->db->query($s);

                    */

                    $s = "select * from leadpops where leadpop_type_id = " . self::$leadpopSubDomainTypeId;
                    $s .= " and leadpop_vertical_id = " . $lpres['leadpop_vertical_id'];
                    $s .= " and leadpop_vertical_sub_id = " . $lpres['leadpop_vertical_sub_id'];
                    $s .= " and leadpop_template_id = " . $lpres['leadpop_template_id'];
                    $s .= " and leadpop_version_id = " . $lpres['leadpop_version_id'];
                    $newlp = $this->db->fetchRow($s);


                    $s = " insert into clients_funnels_domains (id,client_id,subdomain_name,top_level_domain,";
                    $s .= "leadpop_vertical_id,leadpop_vertical_sub_id,leadpop_type_id,";
                    $s .= "leadpop_template_id, leadpop_id,leadpop_version_id,leadpop_version_seq) values (null,";
                    $s .= $client_id . ",'" . $subdomain . "','" . $topdomain . "'," . $newlp['leadpop_vertical_id'] . ",";
                    $s .= $newlp['leadpop_vertical_sub_id'] . "," . $newlp['leadpop_type_id'] . "," . $newlp['leadpop_template_id'] . ",";
                    $s .= $newlp['id'] . "," . $newlp['leadpop_version_id'] . "," . $version_seq . ")";
                    $this->db->query($s);
                    $thedomain_id = $this->db->lastInsertId();

                    // Updating funnel pixels
                    $this->Default_Model_Pixel->updatePixel([
                        "domain_id"=> $thedomain_id,
                        "leadpops_id" => $newlp['id']
                    ], [
                            "client_id" => $client_id,
                            "domain_id"=> $previousDomainId,
                            "leadpops_id" => $leadpop_id
                        ]
                    );

                    /* add chg domain name in clients_emma_group  4/7/2016
                         we only update change in domain names. this is for cleints who
                         sign up for the free-trial. to put in previous clients into emma we need
                         to find another way. aaaaaaaaaaaaaaaa
                    */
                    $s = "select * from  client_emma_group where domain_name = '" . $originaldomain . "' limit 1 ";
                    $emmaExists = $this->db->fetchAll($s);
                    if ($emmaExists) {
                        $s = "update client_emma_group set domain_name = '" . $subdomain . "." . $topdomain . "' where domain_name = '" . $originaldomain . "' limit 1 ";
                        $this->db->query($s);
                    }

                    /* CODE NOT IN USE */
                    /*
                    $s = "select id from mobileclients where ";
                    $s .= " leadpop_vertical_id = " . $lpres['leadpop_vertical_id'];
                    $s .= " and client_id = " . $client_id;
                    $s .= " and leadpop_vertical_sub_id = " . $lpres['leadpop_vertical_sub_id'];
                    $s .= " and leadpop_type_id = " . $lpres['leadpop_type_id'];
                    $s .= " and leadpop_template_id = " . $lpres['leadpop_template_id'];
                    $s .= " and leadpop_version_id = " . $lpres['leadpop_version_id'];
                    $s .= " and leadpop_version_seq = " . $version_seq;
                    $mobileExists = $this->db->fetchOne($s);
                    if ($mobileExists) {
                        $s = "update mobileclients set nonmobiledomain = '" . $subdomain . "." . $topdomain . "', ";
                        $s .= " leadpop_type_id = " . $newlp['leadpop_type_id'];
                        $s .= " where ";
                        $s .= " leadpop_vertical_id = " . $lpres['leadpop_vertical_id'];
                        $s .= " and leadpop_vertical_sub_id = " . $lpres['leadpop_vertical_sub_id'];
                        $s .= " and leadpop_type_id = " . $lpres['leadpop_type_id'];
                        $s .= " and leadpop_template_id = " . $lpres['leadpop_template_id'];
                        $s .= " and leadpop_version_id = " . $lpres['leadpop_version_id'];
                        $s .= " and leadpop_version_seq = " . $version_seq;
                        $s .= " and id = " . $mobileExists;
                        $this->db->query($s);

                        $cmpdomain = strtolower($originaldomain);
                    } else {
                        $length = 15;
                        $randchars = $this->generateRandomString($length);
                        $s = "select count(*) as cnt from mobileclients where nonmobiledomain = '" . $subdomain . "." . $topdomain . "' ";
                        $hasmobile = $this->db->fetchOne($s);
                        if ($hasmobile == 0) {
                            $s = "INSERT INTO mobileclients (nonmobiledomain, mobiledomain, client_id, id, leadpop_id, ";
                            $s .= "leadpop_vertical_id,leadpop_vertical_sub_id, leadpop_type_id, leadpop_template_id,";
                            $s .= "leadpop_version_id, leadpop_version_seq, ";
                            $s .= "iszillow, zillow_api, active, group_design, phone, company,client_or_domain_logo_image) VALUES (";
                            $s .= "'" . $subdomain . "." . $topdomain . "','" . $randchars . ".itclixmobile.com',";
                            $s .= $client_id . ",null," . $newlp['id'] . "," . $newlp['leadpop_vertical_id'] . "," . $newlp['leadpop_vertical_sub_id'] . ",1," . $newlp['leadpop_template_id'];
                            $s .= "," . $newlp['leadpop_version_id'] . "," . $version_seq . ",'n','n','y','y','" . preg_replace('/[^0-9]/', '', $client ['phone_number']) . "', '" . addslashes($client ['company_name']) . "','c') ";
                            $this->db->query($s);
                        }

                    }
                    */


                    /* insert google analytics and chimp tables */
                    $googleDomain = $subdomain . "." . $topdomain;
                    $this->insertPurchasedGoogle($client_id, $googleDomain);
                    /* insert google analytics and chimp tables */

                    $s = "update clients_leadpops set leadpop_id = " . $newlp['id'];
                    $s .= " where client_id = " . $client_id;
                    $s .= " and leadpop_version_id =  " . $lpres['leadpop_version_id'];
                    $s .= " and leadpop_version_seq =  " . $version_seq;
                    $this->db->query($s);


                    /* Get id from clients_leadpops to update in lead_stats */
                    $s = "select id, lynxly_hash from clients_leadpops ";
                    $s .= " where client_id = " . $client_id;
                    $s .= " and leadpop_version_id =  " . $newlp['leadpop_version_id'];
                    $s .= " and leadpop_version_seq =  " . $version_seq;
                    $leadpop_client_id = $this->db->fetchRow($s);

                    $s = "UPDATE lead_stats SET leadpop_id = " . $newlp['id'] . ", leadpop_version_seq = " . $version_seq . ", domain_id = " . $thedomain_id . ", leadpop_client_id = " . $leadpop_client_id['id'];
                    $s .= " WHERE client_id  = " . $client_id;
                    $s .= " and leadpop_id = " . $leadpop_id;
                    $s .= " and domain_id = " . $previousDomainId;
                    $s .= " and leadpop_vertical_id = " . $lpres['leadpop_vertical_id'];
                    $s .= " and leadpop_vertical_sub_id = " . $lpres['leadpop_vertical_sub_id'];
                    $s .= " and leadpop_template_id = " . $lpres['leadpop_template_id'];
                    $s .= " and leadpop_version_id = " . $lpres['leadpop_version_id'];
                    $this->db->query($s);

                    $this->registry->leadpops->customLeadpopid = $newlp['id'];

                    unset($this->registry->leadpops->leadpopType);
                    $this->registry->leadpops->leadpopType = 1;

                    $verticalname = $this->getVerticalName($newlp['leadpop_vertical_id']);
                    $subverticalname = $this->getSubVerticalName($newlp['leadpop_vertical_id'], $newlp['leadpop_vertical_sub_id']);
                    $this->setworkinglink($newlp['id'], $verticalname, $subverticalname, $version_seq);


                    /* need to change leadpop id and leadpop type for chimp */
                    $s = "update chimp set leadpop_id = " . $newlp['id'];
                    $s .= " ,leadpop_type_id = " . self::$leadpopSubDomainTypeId;
                    $s .= " where leadpop_type_id = " . self::$leadpopDomainTypeId;
                    $s .= " and client_id = " . $client_id;
                    $s .= " and leadpop_vertical_id = " . $newlp['leadpop_vertical_id'];
                    $s .= " and leadpop_vertical_sub_id = " . $newlp['leadpop_vertical_sub_id'];
                    $s .= " and leadpop_template_id = " . $newlp['leadpop_template_id'];
                    $s .= " and leadpop_version_id = " . $newlp['leadpop_version_id'];
                    $s .= " and leadpop_version_seq = " . $version_seq;
                    @$this->db->query($s);
                    /* need to change leadpop id and leadpop type for chimp */

                    /* need to change leadpop id and leadpop type */
                    $s = "update  leadpop_images set leadpop_id = " . $newlp['id'];
                    $s .= " ,leadpop_type_id = " . self::$leadpopSubDomainTypeId;
                    $s .= " where leadpop_type_id = " . self::$leadpopDomainTypeId;
                    $s .= " and client_id = " . $client_id;
                    $s .= " and leadpop_vertical_id = " . $newlp['leadpop_vertical_id'];
                    $s .= " and leadpop_vertical_sub_id = " . $newlp['leadpop_vertical_sub_id'];
                    $s .= " and leadpop_template_id = " . $newlp['leadpop_template_id'];
                    $s .= " and leadpop_version_id = " . $newlp['leadpop_version_id'];
                    $s .= " and leadpop_version_seq = " . $version_seq;
                    $this->db->query($s);

                    $s = "update  leadpop_logos set leadpop_id = " . $newlp['id'];
                    $s .= " ,leadpop_type_id = " . self::$leadpopSubDomainTypeId;
                    $s .= " where leadpop_type_id = " . self::$leadpopDomainTypeId;
                    $s .= " and client_id = " . $client_id;
                    $s .= " and leadpop_vertical_id = " . $newlp['leadpop_vertical_id'];
                    $s .= " and leadpop_vertical_sub_id = " . $newlp['leadpop_vertical_sub_id'];
                    $s .= " and leadpop_template_id = " . $newlp['leadpop_template_id'];
                    $s .= " and leadpop_version_id = " . $newlp['leadpop_version_id'];
                    $s .= " and leadpop_version_seq = " . $version_seq;
                    $this->db->query($s);

                    /* we have the original leadpop_id nd the newleadpopid, so change the values in the leadpop_background_color table */
                    /* switch leadpop_id and leadpop_type_id for leadpop_background_color */
                    $s = "update leadpop_background_color set leadpop_id = " . $newlp['id'];
                    $s .= " ,leadpop_type_id = " . self::$leadpopSubDomainTypeId;
                    $s .= " where leadpop_type_id = " . self::$leadpopDomainTypeId;
                    $s .= " and client_id = " . $client_id;
                    $s .= " and leadpop_version_id = " . $newlp['leadpop_version_id'];
                    $s .= " and leadpop_version_seq = " . $version_seq;
                    $this->db->query($s);
                    /* we have the original leadpop_id nd the newleadpopid, so change the values in the leadpop_background_color table */
                    /* switch leadpop_id and leadpop_type_id for leadpop_background_color */

                    $s = "update  seo_options set leadpop_id = " . $newlp['id'];
                    $s .= " ,leadpop_type_id = " . self::$leadpopSubDomainTypeId;
                    $s .= " where leadpop_type_id = " . self::$leadpopDomainTypeId;
                    $s .= " and client_id = " . $client_id;
                    $s .= " and leadpop_vertical_id = " . $newlp['leadpop_vertical_id'];
                    $s .= " and leadpop_vertical_sub_id = " . $newlp['leadpop_vertical_sub_id'];
                    $s .= " and leadpop_template_id = " . $newlp['leadpop_template_id'];
                    $s .= " and leadpop_version_id = " . $newlp['leadpop_version_id'];
                    $s .= " and leadpop_version_seq = " . $version_seq;
                    $this->db->query($s);

                    $s = "update  autoresponder_options set leadpop_id = " . $newlp['id'];
                    $s .= " ,leadpop_type_id = " . self::$leadpopSubDomainTypeId;
                    $s .= " where leadpop_type_id = " . self::$leadpopDomainTypeId;
                    $s .= " and client_id = " . $client_id;
                    $s .= " and leadpop_version_id = " . $newlp['leadpop_version_id'];
                    $s .= " and leadpop_version_seq = " . $version_seq;
                    $this->db->query($s);

                    $s = "update  bottom_links set leadpop_id = " . $newlp['id'];
                    $s .= " ,leadpop_type_id = " . self::$leadpopSubDomainTypeId;
                    $s .= " where leadpop_type_id = " . self::$leadpopDomainTypeId;
                    $s .= " and client_id = " . $client_id;
                    $s .= " and leadpop_vertical_id = " . $newlp['leadpop_vertical_id'];
                    $s .= " and leadpop_vertical_sub_id = " . $newlp['leadpop_vertical_sub_id'];
                    $s .= " and leadpop_template_id = " . $newlp['leadpop_template_id'];
                    $s .= " and leadpop_version_id = " . $newlp['leadpop_version_id'];
                    $s .= " and leadpop_version_seq = " . $version_seq;
                    $this->db->query($s);

                    $s = "update  submission_options set leadpop_id = " . $newlp['id'];
                    $s .= " ,leadpop_type_id = " . self::$leadpopSubDomainTypeId;
                    $s .= " ,thankyou = '" . addslashes($newthankyou) . "' ";
                    $s .= " where leadpop_type_id = " . self::$leadpopDomainTypeId;
                    $s .= " and client_id = " . $client_id;
                    $s .= " and leadpop_version_id = " . $newlp['leadpop_version_id'];
                    $s .= " and leadpop_version_seq = " . $version_seq;
                    $this->db->query($s);

                    $s = "update  contact_options set leadpop_id = " . $newlp['id'];
                    $s .= " ,leadpop_type_id = " . self::$leadpopSubDomainTypeId;
                    $s .= " where leadpop_type_id = " . self::$leadpopDomainTypeId;
                    $s .= " and client_id = " . $client_id;
                    $s .= " and leadpop_vertical_id = " . $newlp['leadpop_vertical_id'];
                    $s .= " and leadpop_vertical_sub_id = " . $newlp['leadpop_vertical_sub_id'];
                    $s .= " and leadpop_template_id = " . $newlp['leadpop_template_id'];
                    $s .= " and leadpop_version_id = " . $newlp['leadpop_version_id'];
                    $s .= " and leadpop_version_seq = " . $version_seq;
                    $this->db->query($s);

                    $s = "update lp_auto_recipients set leadpop_id = " . $newlp['id'];
                    $s .= " ,leadpop_type_id = " . self::$leadpopSubDomainTypeId;
                    $s .= " where leadpop_type_id = " . self::$leadpopDomainTypeId;
                    $s .= " and client_id = " . $client_id;
                    $s .= " and leadpop_vertical_id = " . $newlp['leadpop_vertical_id'];
                    $s .= " and leadpop_vertical_sub_id = " . $newlp['leadpop_vertical_sub_id'];
                    $s .= " and leadpop_template_id = " . $newlp['leadpop_template_id'];
                    $s .= " and leadpop_version_id = " . $newlp['leadpop_version_id'];
                    $s .= " and leadpop_version_seq = " . $version_seq;
                    $this->db->query($s);

                    $s = "select id from lp_auto_recipients where ";
                    $s .= " leadpop_id = " . $newlp['id'];
                    $s .= " and leadpop_type_id = " . self::$leadpopSubDomainTypeId;
                    $s .= " and client_id = " . $client_id;
                    $s .= " and leadpop_vertical_id = " . $newlp['leadpop_vertical_id'];
                    $s .= " and leadpop_vertical_sub_id = " . $newlp['leadpop_vertical_sub_id'];
                    $s .= " and leadpop_template_id = " . $newlp['leadpop_template_id'];
                    $s .= " and leadpop_version_id = " . $newlp['leadpop_version_id'];
                    $s .= " and leadpop_version_seq = " . $version_seq;
                    $lp_auto_rows = $this->db->fetchAll($s);

                    for ($v = 0; $v < count($lp_auto_rows); $v++) {
                        $s = "update lp_auto_text_recipients  set leadpop_id = " . $newlp['id'];
                        $s .= " ,leadpop_type_id = " . self::$leadpopSubDomainTypeId;
                        $s .= " where lp_auto_recipients_id = " . $lp_auto_rows[$v]['id'];
                        $this->db->query($s);
                    }

                    $s = "  select count(*) as cnt ";
                    $s .= " from leadpop_multiple_step ";
                    $s .= " where client_id = " . $client_id;
                    $s .= " and leadpop_description_id = " . $lpres['leadpop_version_id'];
                    $s .= " and leadpop_id = " . $lpres['id'];
                    $s .= " and leadpop_template_id = " . $lpres['leadpop_template_id'];
                    $multicount = $this->db->fetchOne($s);

                    if ($multicount > 0) {
                        $s = "update leadpop_multiple_step ";
                        $s .= " set leadpop_description_id = " . $newlp['leadpop_version_id'];
                        $s .= " ,leadpop_id = " . $newlp['id'];
                        $s .= " ,leadpop_template_id = " . $newlp['leadpop_template_id'];
                        $s .= " where client_id = " . $client_id;
                        $s .= " and leadpop_description_id = " . $lpres['leadpop_version_id'];
                        $s .= " and leadpop_id = " . $lpres['id'];
                        $s .= " and leadpop_template_id = " . $lpres['leadpop_template_id'];
                        $this->db->query($s);
                    }
                    /*  lp_auto_text_recipients -> change leadpop_id and leadpop_type_id
                        leadpop_multiple_step -> change leadpop_id
                        lp_auto_recipients
                    need to change leadpop id and leadpop type */
//                    print "ok~1~" . $thedomain_id . "~" . $newlp['id'] . "~" . $subdomain . "~" . $topdomain . "~" . $originaldomain.'~'.$leadpop_client_id['lynxly_hash'];

                    $response = $this->successResponse('Domain ' . $originaldomain . ' has been deleted.', [
                        "domain_id" => $thedomain_id,
                        "domain_type" => self::$leadpopSubDomainTypeId,
                        "leadpop_id" => $newlp['id'],
                        "subdomain" => $subdomain,
                        "top_level_domain" => $topdomain,
                        "deleted_domain" => $originaldomain,
                        "lynxly_hash" => $leadpop_client_id['lynxly_hash']
                    ]);
                }
                /*
                            *Disable as per sir @sal
                            */
                //$this->updateClientWebsite($client_id, $originaldomain, ($subdomain . '.' . $topdomain), $leadpop_client_id);

                /**
                 * SB - Cloned
                 */
                $s = "select * from  client_funnel_sticky where sticky_funnel_url = '" . $originaldomain . "' limit 1 ";
                $exists = $this->db->fetchAll($s);
                if ($exists) {
                    $s = "update client_funnel_sticky set sticky_funnel_url = '" . $newsubdomain . "' where sticky_funnel_url = '" . $originaldomain . "' limit 1 ";
                    $this->db->query($s);
                }

                if($response == null) {
                    return $this->errorResponse();
                } else {
                    return $response;
                }
            } else {
                return $this->errorResponse('That sub-domain is already in use. Please try something else.', [
                    "taken" => true
                ]);
//                print "taken~0~0";
            }
        }
    }
    public function pixelsAction(){
        LP_Helper::getInstance()->getCurrentHashData();
        if(LP_Helper::getInstance()->getCurrentHash()){
            $funnelData = LP_Helper::getInstance()->getFunnelData();
            $this->data->client_id = $this->client_id;
            $this->data->current_hash = LP_Helper::getInstance()->getCurrentHash();
            $this->data->lpkeys = $this->getLeadpopKey($funnelData);
            $pixel = $this->Default_Model_Pixel;
            $this->data->pixels = $pixel->getPixels([
                'client_id'=>$this->client_id,
                'leadpops_id'=>$funnelData['funnel']['leadpop_id'],
                'client_leadpops_id'=>$funnelData['client_leadpop_id'],
                'domain_id'=>$funnelData['funnel']['domain_id'],
            ]);
            $this->active_menu = LP_Constants::PIXEL;
            return $this->response();
        }
    }
    public function savepixelinfoAction() {
        unset($_POST['_token']);
        $post = $_POST;

        if(!empty($post)) {
            $current_hash = $post['current_hash'];
            unset( $post['current_hash'] );
            $action = $post['action'];
            unset( $post['action'] );
            $id = $post['id'];
            unset( $post['id'] );

            unset($post['saved_pixel_code']);
            unset($post['saved_pixel_type']);
            unset($post['saved_pixel_placement']);

            $error = array();
            $required_fields = array( 'pixel_code' => "Tracking ID" );
            foreach ( $required_fields as $key => $label ) {
                if ( $_POST[ $key ] == "" ) {
                    $error[] = $label . " field is required.";
                }
            }

            if ( ! empty( $error ) ) {
                Session::flash('error', $error);
            } else {
                if($post['pixel_type'] == LP_Constants::FACEBOOK_PIXELS && $post['pixel_placement'] == LP_Constants::PIXEL_PLACEMENT_BODY){
                    $post['pixel_action'] = "";
                    $post['pixel_other'] = "";
                }
                else if($post['pixel_type'] == LP_Constants::FACEBOOK_PIXELS && $post['pixel_placement'] == LP_Constants::PIXEL_PLACEMENT_TYP){
                    $post['pixel_action'] = LP_Constants::PIXEL_ACTION_LEAD;
                    $post['pixel_other'] = "";
                }

                if($action == 'global.add') {
                    $lpkey_pixels = $post['lpkey_pixels'];
                    unset( $post['lpkey_pixels'] );
                    $domains_include = $post['domains_include'];
                    unset( $post['domains_include'] );
                    $domains_ids = explode(",", $post['domains_ids']);
                    unset( $post['domains_ids'] );
                    $date = new DateTime();
                    $ts = $date->getTimestamp();

                    LP_Helper::getInstance()->_fetch_all_funnels();
                    foreach(LP_Helper::getInstance()->getFunnels() as $vertical=>$vfunnels){
                        if($vfunnels){
                            foreach($vfunnels as $group=>$gfunnels){
                                if($gfunnels){
                                    foreach($gfunnels as $subvertical=>$svfunnels){
                                        if($svfunnels){
                                            $groupPost = $post;
                                            if($groupPost["pixel_placement"] != 4){
                                                $groupPost["pixel_placement"] 	= $groupPost["pixel_position"];
                                            }
                                            unset($groupPost["pixel_position"]);

                                            foreach($svfunnels as $client_leadpops_id=>$funnelData){
                                                // if no domain selected consider it as ALL and avoid include/exclude filter
                                                // - OR - if any of domain is selected then and include filter is selected
                                                // - OR - if any of domain is selected amdthen and exlude filter is selected
                                                if(empty($domains_ids) || (in_array($funnelData['domain_id'], $domains_ids) && $domains_include == 1) || (!in_array($funnelData['domain_id'], $domains_ids) && $domains_include == 0)){
                                                    $groupPost['client_leadpops_id'] = $funnelData['client_leadpop_id'];
                                                    $groupPost['leadpops_id']        = $funnelData['leadpop_id'];
                                                    $groupPost['domain_id']          = $funnelData['domain_id'];
                                                    $groupPost['group_identifier']   = $funnelData['client_id'].$ts;
                                                    $pixel = $this->Default_Model_Pixel;
                                                    $pixel->addPixel( $groupPost );
                                                    $this->updateFunnelTimestamp(array("client_id"=>$funnelData["client_id"], "client_leadpop_id"=>$funnelData['client_leadpop_id']));
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                    echo json_encode(array("status"=>"success", "action"=>"added", "message"=>"Pixel Code has been saved.", "html"=>$this->globalPixelAjax()));
                    exit;
                }
                else if($action == 'global.update') {
                    $domains_include = $post['domains_include'];
                    unset( $post['domains_include'] );
                    $domains_ids = explode(",", $post['domains_ids']);
                    unset( $post['domains_ids'] );
                    $date = new DateTime();
                    $ts = $date->getTimestamp();

                    $pixel = $this->Default_Model_Pixel;
                    $pixel->removePixel( $this->client_id, $id, implode(",", $domains_ids) );

                    LP_Helper::getInstance()->_fetch_all_funnels();
                    foreach(LP_Helper::getInstance()->getFunnels() as $vertical=>$vfunnels){
                        if($vfunnels){
                            foreach($vfunnels as $group=>$gfunnels){
                                if($gfunnels){
                                    foreach($gfunnels as $subvertical=>$svfunnels){
                                        if($svfunnels){
                                            $groupPost = $post;

                                            if($groupPost["pixel_placement"] != 4){
                                                $groupPost["pixel_placement"] 	= $groupPost["pixel_position"];
                                            }
                                            unset($groupPost["pixel_position"]);

                                            foreach($svfunnels as $client_leadpops_id=>$funnelData){
                                                if(empty($domains_ids) || (in_array($funnelData['domain_id'], $domains_ids) && $domains_include == 1) || (!in_array($funnelData['domain_id'], $domains_ids) && $domains_include == 0)){
                                                    $groupPost['client_leadpops_id'] = $funnelData['client_leadpop_id'];
                                                    $groupPost['leadpops_id']        = $funnelData['leadpop_id'];
                                                    $groupPost['domain_id']          = $funnelData['domain_id'];
                                                    $groupPost['group_identifier']   = $funnelData['client_id'].$ts;

                                                    $pixel->addUpdatePixel( $groupPost, $id );
                                                    $this->updateFunnelTimestamp(array("client_id"=>$funnelData["client_id"], "client_leadpop_id"=>$funnelData['client_leadpop_id']));
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                    echo json_encode(array("status"=>"success", "action"=>"updated", "message"=>"Pixel Code has been updated.", "html"=>$this->globalPixelAjax()));
                    exit;
                }
                else{
                    LP_Helper::getInstance()->getCurrentHashData( $current_hash );
                    $funnelData                 = LP_Helper::getInstance()->getFunnelData();
                    $post['client_leadpops_id'] = $funnelData['client_leadpop_id'];
                    $post['leadpops_id']        = $funnelData['funnel']['leadpop_id'];
                    $post['domain_id']          = $funnelData['funnel']['domain_id'];
                    if($post['pixel_type'] == LP_Constants::FACEBOOK_PIXELS and $post["pixel_placement"] == LP_Constants::PIXEL_PLACEMENT_BODY){
                        $post["pixel_placement"] 	= 1;
                    }else if($post["pixel_placement"] != LP_Constants::PIXEL_PLACEMENT_TYP){
                        $post["pixel_placement"] 	= $post["pixel_position"];
                    }

                    if(isset($post["tracking_options"]) && $post["tracking_options"] == LP_Constants::PIXEL_PAGE_PLUS_QUESTION){
                        $post["fb_questions_flag"] 	= 1;
                        $json = array();
                        if(!empty($post['zip_code'])){
                            $ar = explode(',', $post['zip_code']);
                            foreach($ar as $vl){
                                if($vl){
                                    $zip = preg_replace("/\r|\n/", "", $vl);
                                    $json['enteryourzipcode'][] = $zip;
                                }
                            }
                        }
                        if(isset($post['answer'])){
                            foreach ($post['answer'] as $k => $v) {
                                if ($v) {
                                    list($a, $b) = explode('|', $v);
                                    $json[$a][] = $b;
                                }
                            }
                        }
                        $post['fb_questions_json']  = json_encode($json,true);
                    }else{
                        $post["fb_questions_flag"] 	= 0;
                        $post['fb_questions_json']  = '';
                    }
                    unset($post["pixel_position"]);
                    unset($post["tracking_options"]);
                    unset($post["answer"]);
                    unset($post["zip_code"]);
                    $pixel = $this->Default_Model_Pixel;
                    $data = ["action" => $action];
                    if ( $action == "add" ) {
                        $data['id'] = $pixel->addPixel( $post );
                        $msg = 'Pixel code has been added.';
                    } else if ( $action == "update" ) {
                        $pixel->updatePixel( $post, array( 'id' => $id ) );
                        $msg = 'Pixel code has been updated.';
                    }

                    $this->updateFunnelTimestamp(array("client_id"=>$funnelData["client_id"], "client_leadpop_id"=>$funnelData['client_leadpop_id']));
                    return $this->successResponse($msg, $data);
//                    Session::flash('success', $msg);
                }
            }
            return $this->lp_redirect('/popadmin/pixels/'.$current_hash);
        }else{
            return $this->lp_redirect();
        }
    }
    private function globalPixelAjax(){
        $html = '<div class="domain-edit"><h3>Code Name</h3><h3>Options</h3></div>';
        $global_obj = $this->Default_Model_Global;
        $globalPixels = $global_obj->getGlobalPixels($this->registry->leadpops->client_id);
        if(@$globalPixels) {
            foreach(@$globalPixels as $pixel){
                $dataAttr = array();
                foreach($pixel as $c=>$v) {
                    if(in_array($c, ['client_id','leadpops_id','client_leadpops_id','domain_id']))
                        continue;
                    $dataAttr[] = 'data-'.$c."='$v'";
                }
                $dataAttr[] = 'data-pixel_type_label="'.LP_Constants::getPixelType($pixel['pixel_type']).'"';
                $dataAttr[] = 'data-pixel_placement_label="'.LP_Constants::getPixelPlace($pixel['pixel_placement']).'"';
                $dataAttr[] = 'data-pixel_action_label="'.LP_Constants::getPixelAction($pixel['pixel_action']).'"';
                $html .= '<div class="domain-edit pixel_'.$pixel['id'].'">'.$pixel['pixel_name'].' <a href="#" class="action-btn btn-delete-GlobalPixel" '.implode(" ",$dataAttr).' ><i class="fa fa-remove"></i>DELETE</a><a href="#" class="action-btn btn-edit-GlobalPixel" '.implode(" ",$dataAttr).'><i class="glyphicon glyphicon-pencil"></i>EDIT</a></div>';
            }
        }

        return $html;
    }
    public function deletepixelinfoAction() {
        if(!empty($_POST) && array_key_exists('id', $_POST) && $_POST['id']!="") {
            $pixel = $this->Default_Model_Pixel;
            $pixel->deletePixels($_POST['id'], $_POST['client_id']);
            return $this->successResponse("Code has been deleted.");
        }
        else if(!empty($_POST) && array_key_exists('group_identifier', $_POST) && $_POST['group_identifier']!="") {
            $pixel = $this->Default_Model_Pixel;
            $pixel->deletePixels($_POST['group_identifier'], $_POST['client_id'], true);
            return $this->successResponse("Code has been deleted.");
//            echo json_encode(['status'=>'success']);
        }
        else {
            return $this->errorResponse("Unable to delete code.");
//            echo json_encode(['status'=>'error']);
        }
    }
    function integrationAction() {
        LP_Helper::getInstance()->getCurrentHashData();
        if(LP_Helper::getInstance()->getCurrentHash()){
            $hash_data = LP_Helper::getInstance()->getFunnelData();
            $session=LP_Helper::getInstance()->getSession();
            $this->setCommonDataForView($hash_data,$session);
            $global_obj = $this->Default_Model_Global;
            $customize = $this->Default_Model_Customize;
            $this->data->clientToken = $global_obj->getClientToken($this->registry->leadpops->client_id);
            $this->data->LeadpopAccessToken = $global_obj->getLeadpopAccessToken($this->registry->leadpops->client_id);
            $this->data->subscriptions = $customize->getClientSubscriptions($this->registry->leadpops->client_id);
            $this->data->integrations = $customize->getClientIntegrations($this->registry->leadpops->client_id);
            $this->data->zapLpIntegrations = $customize->checkZapierAndLeadPopsIntegrations($this->registry->leadpops->client_id);
            $this->data->activeFunnelClientIntegrations = $customize->activeFunnelClientIntegrations($this->registry->leadpops->client_id,$hash_data['funnel']['leadpop_id'], $hash_data['funnel']['leadpop_vertical_id'], $hash_data['funnel']['leadpop_vertical_sub_id'], $hash_data['funnel']['leadpop_template_id'], $hash_data['funnel']['leadpop_version_id'], $hash_data['funnel']['leadpop_version_seq']);
            $this->active_menu = LP_Constants::INTEGRATION;

            //for auto complete search feature in funnel selector
            $all_funnels = array();
            LP_Helper::getInstance()->_fetch_all_funnels();
            foreach (LP_Helper::getInstance()->getFunnels() as $vertical_id => $groups) {
                foreach ( $groups as $group_id => $group_item ) {
                    foreach ( $group_item as $sub_verticals ) {
                        foreach ( $sub_verticals as $funnel ) {
                            $all_funnels[] = array("label"=>strtolower($funnel['domain_name']." -- ".$funnel['fs_display_label']), "domain_id"=>$funnel['domain_id'], "display"=>$funnel['fs_display_label']);
                            //$all_funnels[] = strtolower($funnel['domain_name']). " (".$funnel['fs_display_label'].")";
                        }
                    }
                }
            }

            array_push($this->assets_css, LP_BASE_URL.config('view.theme_assets')."/external/jquery-ui.min.css");
            array_push($this->assets_js, LP_BASE_URL.config('view.theme_assets')."/external/jquery-ui.min.js");
            array_push($this->assets_js, LP_BASE_URL.config('view.theme_assets')."/external/jquery.base64.min.js");

            $this->inline_js = "var funnels = ".json_encode($all_funnels).";\n";
            $this->inline_js .= '$( "#search" ).autocomplete({
		        minLength: 0,
		        source: funnels,
		        focus: function( event, ui ) {
		            var label = item.label.split(" -- ");
				    $( "#search" ).val( label[0] );
				    return false;
			    },
		        select: function( event, ui ) {
	                $(".domain_"+ui.item.domain_id).prop("checked", true)
	                $( "#search" ).val("");

	                var _target = $(".gfunnel"+ui.item.domain_id).parents(".mCustomScrollbar");
				    if (_target.length) {
				        var offset = 10;
					    var elTop = $(".gfunnel"+ui.item.domain_id).offset().top - $(".gfunnel"+ui.item.domain_id).parents(".mCSB_container").offset().top;
					    var scrollNum = elTop - offset;
				        _target.mCustomScrollbar("scrollTo", scrollNum);
				    }

				    var _wtarget = $(".wfunnel"+ui.item.domain_id).parents(".mCustomScrollbar");
				    if (_target.length) {
				        var offset = 10;
					    var elTop = $(".wfunnel"+ui.item.domain_id).offset().top - $(".wfunnel"+ui.item.domain_id).parents(".mCSB_container").offset().top;
					    var scrollNum = elTop - offset;
				        _wtarget.mCustomScrollbar("scrollTo", scrollNum);
				    }

				    return false;
			    }
	        }).autocomplete( "instance" )._renderItem = function( ul, item ) {
	            var label = item.label.split(" -- ");
			    return $( "<li>" ).append( "<div>" + label[0] + " (<strong>"+item.display+"</strong>)"+ "</div>" ).appendTo( ul );
		    };';

            return $this->response();
        }

    }
    public function createauthkeyAction() {
        if($_POST){
            $cur_hash=$_POST["current_hash"];
            LP_Helper::getInstance()->getCurrentHashData($cur_hash);
            $funneldata = LP_Helper::getInstance()->getFunnelData();
            $customize = $this->Default_Model_Customize;
            /* update clients_leadpops table's col last edit*/
            /* if LP_Helper::getInstance()->getFunnelData() not work then send id in parameter */
            update_clients_leadpops_last_eidt($funneldata['client_leadpop_id']);

            if($_POST["type"] == "zapier") {
                $url = AUTH_TOKEN_ZAPIER . $this->registry->leadpops->client_id;
                #$url = "http://zapier.leadpops.com/api/v1/create-token/" . $this->registry->leadpops->client_id;
                #$url = "http://zapier.local/api/v1/create-token/".$this->client_id;
                $curl = curl_init();
                curl_setopt_array( $curl, array(
                    CURLOPT_URL            => $url,
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING       => "",
                    CURLOPT_MAXREDIRS      => 10,
                    CURLOPT_TIMEOUT        => 30,
                    CURLOPT_CUSTOMREQUEST  => "GET",
                ) );

                $response = curl_exec( $curl );
                $err      = curl_error( $curl );
                curl_close( $curl );
                if ( $err ) {
                    echo json_encode( array( "status" => "error", "error" => "cURL Error #:" . $err ) );
                    exit;
                } else {
                    $resp = json_decode( $response, 1 );
                    if ( $resp['code'] == 200 ) {
                        $customize->createClientKey( $this->registry->leadpops->client_id, $resp['token'] );
//                        This method is not required now
//                        $this->zapierfunnelsAction();
                        echo json_encode( array( "status" => "success", "key" => $resp['token'] ) );
                        exit;
                    } else {
                        /* error message */
                        echo json_encode( array( "status" => "error", "error" => 'Zapier integration generation failed. Please try again.' ) );
                        exit;
                    }
                }
            }

            else if($_POST["type"] == "leadpops_auth") {
                $url = AUTH_TOKEN_LPAPI . $this->registry->leadpops->client_id;
                #$url = "http://api.leadpops.com/api/v1/token/create/" . $this->registry->leadpops->client_id;
                #$url = "http://leads_api.dev/api/v1/token/create/".$this->client_id;
                $curl = curl_init();
                curl_setopt_array( $curl, array(
                    CURLOPT_URL            => $url,
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING       => "",
                    CURLOPT_MAXREDIRS      => 10,
                    CURLOPT_TIMEOUT        => 30,
                    CURLOPT_CUSTOMREQUEST  => "GET",
                ) );

                $response = curl_exec( $curl );
                $err      = curl_error( $curl );
                curl_close( $curl );
                if ( $err ) {
                    echo json_encode( array( "status" => "error", "error" => "cURL Error #:" . $err ) );
                    exit;
                } else {
                    $resp = json_decode( $response, 1 );
                    if ( $resp['code'] == 200 ) {
                        $customize->createLeadPopsAccessKey( $this->registry->leadpops->client_id, $resp['data']['access_token'] );
                        echo json_encode( array( "status" => "success", "key" => $resp['data']['access_token'] ) );
                        exit;
                    } else {
                        /* error message */
                        echo json_encode( array( "status" => "error", "error" => 'API key generation failed. Please try again.' ) );
                        exit;
                    }
                }
            }
        }
    }
    public function zapierfunnelsAction(){
        $dQuery = 'DELETE FROM client_integrations WHERE client_id = '.$this->registry->leadpops->client_id." AND LOWER(`name`) = 'zapier'";
        $this->db->query($dQuery);

        LP_Helper::getInstance()->_fetch_all_funnels();
        $funnels = LP_Helper::getInstance()->getFunnels();
        $info = array();
        foreach($funnels as $vertical_id=>$v_funnels){
            foreach($v_funnels as $vs_funnels){
                foreach($vs_funnels as $v_sub_id=>$funnel_info){
                    foreach($funnel_info as $client_leadpop_id=>$funnel){
                        array_push($info, array(
                            'url' => $funnel['domain_name'],
                            'leadpop_id' => $funnel['leadpop_id'],
                            'leadpop_vertical_id' => $funnel['leadpop_vertical_id'],
                            'leadpop_vertical_sub_id' => $funnel['leadpop_vertical_sub_id'],
                            'leadpop_template_id' => $funnel['leadpop_template_id'],
                            'leadpop_version_id' => $funnel['leadpop_version_id'],
                            'leadpop_version_seq' => $funnel['leadpop_version_seq']
                        ));
                    }
                }
            }
        }

        $sql = array();
        foreach( $info as $row ) {
            $sql[] = '('.$this->registry->leadpops->client_id.', "zapier", "'.$row['url'].'", '.$row['leadpop_id'].', '.$row['leadpop_vertical_id'].', '.$row['leadpop_vertical_sub_id'].', '.$row['leadpop_template_id'].', '.$row['leadpop_version_id'].', '.$row['leadpop_version_seq'].')';
        }
        $query = 'INSERT INTO client_integrations (client_id, `name`, url, leadpop_id, leadpop_vertical_id, leadpop_vertical_sub_id, leadpop_template_id, leadpop_version_id, leadpop_version_seq) VALUES '.implode(',', $sql);
        $this->db->query($query);
    }
    public function savezapierfunnelsAction(){
        if(!empty($_POST) && $_POST['funnels']!="") {
            $cur_hash=$_POST["current_hash"];
            LP_Helper::getInstance()->getCurrentHashData($cur_hash);
            $funneldata = LP_Helper::getInstance()->getFunnelData();

            $existing_funnels = explode(",", $_POST['existing_funnels']);
            $integration_funnels = explode(",", $_POST['funnels']);

            $new_integrations = array_diff($integration_funnels, $existing_funnels);
            $remove_integrations = array_diff($existing_funnels, $integration_funnels);

            //debug($new_integrations,'',0);
            //debug($remove_integrations,'',1);

            if($new_integrations){
                foreach($new_integrations as $funnel){
                    if($funnel != ""){
                        list($leadpop_id, $leadpop_vertical_id, $leadpop_vertical_sub_id, $leadpop_template_id, $leadpop_version_id, $leadpop_version_seq, $domain_name) = explode("~", $funnel);

                        $s = "INSERT INTO `client_integrations` (`client_id`,`name`,`url`,`leadpop_id`,`leadpop_vertical_id`,`leadpop_vertical_sub_id`,`leadpop_template_id`,`leadpop_version_id`,`leadpop_version_seq`,`test_mode`,`debug_mode`,`extra_info`,`active`,`token_url`,`leadsource`) ";
                        $s .= "VALUES ( ".$this->client_id.", 'zapier', '$domain_name', $leadpop_id, $leadpop_vertical_id, $leadpop_vertical_sub_id, $leadpop_template_id, $leadpop_version_id, $leadpop_version_seq,'0','0','','y','',NULL);";
                        $this->db->query ($s);
                        $s = "UPDATE clients_leadpops SET  last_edit = '" . date("Y-m-d H:i:s") . "'";
                        $s .= " WHERE client_id = " . $this->client_id;
                        $s .= " AND leadpop_version_id  = " . $leadpop_version_id;
                        $s .= " AND leadpop_version_seq  = " . $leadpop_version_seq;
                        $this->db->query ($s);

                    }
                }
            }

            if($remove_integrations){
                foreach($remove_integrations as $rfunnel){
                    if($rfunnel != ""){
                        list($leadpop_id, $leadpop_vertical_id, $leadpop_vertical_sub_id, $leadpop_template_id, $leadpop_version_id, $leadpop_version_seq, $domain_name) = explode("~", $rfunnel);

                        $s = "DELETE FROM `client_integrations` WHERE `client_id` = ".$this->client_id." AND `leadpop_id` = $leadpop_id AND `leadpop_vertical_id`=$leadpop_vertical_id ";
                        $s .= " AND `leadpop_vertical_sub_id` = $leadpop_vertical_sub_id AND `leadpop_template_id` = $leadpop_template_id AND `leadpop_version_id` = $leadpop_version_id AND `leadpop_version_seq` = $leadpop_version_seq;";
                        $this->db->query ($s);
                        $s = "UPDATE clients_leadpops SET  last_edit = '" . date("Y-m-d H:i:s") . "'";
                        $s .= " WHERE client_id = " . $this->client_id;
                        $s .= " AND leadpop_version_id  = " . $leadpop_version_id;
                        $s .= " AND leadpop_version_seq  = " . $leadpop_version_seq;
                        $this->db->query ($s);
                    }
                }
            }

            /* update clients_leadpops table's col last edit*/
            update_clients_leadpops_last_eidt($funneldata['client_leadpop_id']);

            return $this->successResponse("Zapier selected funnel has been saved.", [
                "funnels" => $_POST['funnels']
            ]);
//            echo json_encode(['status'=>'success', 'response'=>$_POST['funnels']]);
        }else{
            return $this->errorResponse();
//            echo json_encode(['status'=>'error', 'response'=>'Unable to save Funnels']);
        }
    }
    public function totalexpertAction(Request $request) {
        $session=LP_Helper::getInstance()->getSession();

        #$sess = session_id();
        $sess = session()->getId();
        $dt = date("Y-m-d H:i:s");
        $code = $request->get('code');
        $state = $request->get('state');
        $error = $request->get('error');



        if (isset($error) && ($error == "access_denied")) {

            Session::put('totalExpertError', "username/password incorrect");

            if(Session::get('totalExpertHash') == "global-settings") $this->lp_redirect('/global?id=integration');
            else $this->lp_redirect('/popadmin/integration/' . Session::get('totalExpertHash'));
            exit;
        }

        if($sess != $state) {
            Session::put('totalExpertError', "session mismatch");

            if(Session::get('totalExpertHash') == "global-settings") $this->lp_redirect('/global?id=integration');
            else $this->lp_redirect('/popadmin/integration/' . Session::get('totalExpertHash'));
            exit;
        }

        $total_expert_client_id = "leadpops";
        $total_expert_secret = "EUpRDKj9HNxZ6OKjMDt04Sz2J3jFJiznepXfikCLamjaiuxl2ATtvCcH1ihPSKs8";
        $api = "https://public.totalexpert.net/v1/";
        /*if(isset($_COOKIE['sso_te']) && $_COOKIE['sso_te'] == 1){
            $api = "https://totalexpert.net/";
        }*/
        $granttype = '{"grant_type": "authorization_code"}';
        $auth = base64_encode($total_expert_client_id.":".$total_expert_secret);

        $s = "select * from totalexpert where client_id = " . $session->clientInfo->client_id;

        $exists = $this->db->fetchAll($s);

        if(!$exists) {
            $s = "insert into totalexpert (id,client_id,basic_auth,";
            $s .= "authorization_code,access_token,api,grant_type,active,created_at,updated_at) values (null,";
            $s .= $session->clientInfo->client_id . ",'". $auth . "',";
            $s .= "'".$code."','','".$api."','".$granttype."',1,'".$dt."','".$dt."')";
            if($this->db->query($s)) {
                $this->Default_Model_Customize->insertClientIntegrations(config('integrations.iapp.TOTAL_EXPERT')['sysname'], $session->clientInfo->client_id);
            }
        }
        else {
            $s = "update totalexpert set authorization_code = '".$code."',";
            $s .= "access_token = '',updated_at = '".$dt."' ";
            $s .= "where client_id = " . $session->clientInfo->client_id;
            $this->db->query($s);
        }

        // then get access_token
        $tokenurl = "https://public.totalexpert.net/v1/token";
        /*if(isset($_COOKIE['sso_te']) && $_COOKIE['sso_te'] == 1){
            $tokenurl = "https://totalexpert.net/";
        }*/
        $data = array("grant_type" =>"authorization_code", "code" => $code);
        $jsondata = json_encode($data);

        $tokenapi = curl_init($tokenurl);
        curl_setopt($tokenapi, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
                'Authorization: Basic ' . $auth)
        );
        curl_setopt($tokenapi, CURLOPT_POSTFIELDS, $jsondata);
        curl_setopt($tokenapi, CURLOPT_POST, 1);
        curl_setopt($tokenapi, CURLOPT_RETURNTRANSFER, true);

        $result = curl_exec($tokenapi);

        @$tokenObj = json_decode($result);
        @$token = $tokenObj->access_token;
        @$refreshToken = $tokenObj->refresh_token;
        @$expires_in = $tokenObj->expires_in;

        if (is_string($token)) {
            $s = "update totalexpert set access_token = '".$token."',";
            $s .= "refresh_token = '".$refreshToken."', ";
            $s .= "expires_in = '".$expires_in."' ";
            $s .= "where client_id = " . $session->clientInfo->client_id;
            $this->db->query($s);
        }
        else {
            $err = @$tokenObj->error_description != "" ? @$tokenObj->error_description : "no token";
            Session::put('totalExpertError', $err);

            if(Session::get('totalExpertHash') == "global-settings") return $this->lp_redirect('/global?id=integration');
            else return $this->lp_redirect('/popadmin/integration/' . Session::get('totalExpertHash'));
            exit;
        }
        Session::put('totalExpertError', "");

        if(Session::get('totalExpertHash') == "global-settings") return $this->lp_redirect('/global?id=integration');
        else return $this->lp_redirect('/popadmin/integration/' . Session::get('totalExpertHash'));
        exit;
    }
    public function hub(LeadpopsRepository $pops) {
        $this->header_partial ="";
        $mark_hub_data=$pops->getMarketingHubData();
        $this->data->result=$mark_hub_data;
        $this->data->client_id = $this->client_id;
        $this->data->clientName = \View_Helper::getInstance()->getClientName($this->client_id);
        $this->data->workingLeadpop = @$this->registry->leadpops->workingLeadpop;
        $this->data->clickedkey = @$this->registry->leadpops->clickedkey;
        return  $this->response();
    }
    public function hubdetailAction(Request $request){
        $this->header_partial ="";
        $categories = array("realestate","ppc","seo","socialmedia","fasttracktosuccess");
        $this->data->category = $request->get('category');
        if(!isset($this->data->category) || !in_array($this->data->category,$categories)) {
            return $this->_redirect(LP_PATH."/popadmin/hub");
        }

        $pops = $this->Default_Model_Leadpops;
        $mark_hub_data=$pops->getMarketingHubChildData($this->data->category);
        $this->data->title=$mark_hub_data["title"];
        $this->data->result=$mark_hub_data["data"];
        $this->data->client_id = $this->client_id;
        $this->data->clientName = View_Helper::getInstance()->getClientName($this->client_id);
        return  $this->response();
    }

    /**
     * Checks if domain is already registered with a sticky bar and return error
     * if it is, otherwise return success
     *
     * @param Request $request
     * @return void
     */
    public function checkStickyDomainAvailable(Request $request){

        // Sanitize inputs
        $url = trim($request->input('domain'));
        $stickyId = trim($request->input('id'));
        $specificPagesStr = trim($request->input('pages'));
        $isOnWholeWebsite = trim($request->input('all_pages_flag')) == 'true';

        // It removes protocol from given url
        $removeProtocol = function($url){
            $url = preg_replace('/^(?:http)?s?(?:\:\/\/)(?:www\.)?/im', '', $url);
            return trim($url, '/');
        };

        // Converts and sanitize path string to an array
        $convertPathStrToArray = function($pathsStr){
            if(!$pathsStr){
                return [];
            }

            $sanitizedPaths = [];
            $paths = explode('~', $pathsStr);

            foreach($paths as $path){
                if($path){
                    $path = trim($path, '/');
                    $sanitizedPaths[] = "/$path";
                }
            }

            return $sanitizedPaths;
        };

        // We extract domain from given url
        $urlWithoutProtocol = $removeProtocol($url);
        $domain = preg_replace('/^([^\/]+).*/', '$1', $urlWithoutProtocol);

        // Convert given paths string to array
        $specificPagesPaths = $convertPathStrToArray($specificPagesStr);

        // Make a list of pages to be used next in search
        $specificPages = array_map(function ($path) use ($domain) {
            return $domain . $path;
        }, $specificPagesPaths);

        // Building query and fetching existing sticky for given domain
        $existingStickysQuery = ClientFunnelSticky::where('sticky_url', 'like', "%$domain%")->where('sticky_status', '1');

        if($stickyId){
            $existingStickysQuery = $existingStickysQuery->where('id', '<>', $stickyId);
        }

        $existingStickysForDomain = $existingStickysQuery->get();

        // If exists, lets iterate over them and check if domain is already registered
        foreach($existingStickysForDomain as $sticky){

            // Sanitize existing sticky url
            $stickyUrl = trim($sticky->sticky_url);
            $stickyUrl = $removeProtocol($stickyUrl);
            $stickyDomain = preg_replace('/^([^\/]+).*/', '$1', $stickyUrl);

            // Sanitize and convert path string to array
            $stickyPathStr = trim($sticky->sticky_url_pathname ?? '');
            $stickyPaths = $convertPathStrToArray($stickyPathStr);

            // Flag to know if we found and existing sticky bar registered with domain
            $foundExistingSticky = false;
            // Used to send stikcy id
            $isSameClient = $this->client_id == $sticky->client_id;

            $message = 'There is already a Sticky Bar associated with one or more pages on this website. Please enter another URL.';

            // check for subdomain

            if($stickyDomain != $domain){
                continue;
            }

            // If current and existing are both on whole websites, we fail
            if($isOnWholeWebsite && $sticky->sticky_website_flag){
                $message = 'There is already a Sticky Bar associated with this website. Please enter another URL.';
                $foundExistingSticky = true;
            } else if ($isOnWholeWebsite){
                // If current sticky is on whole website, and existing stickys on specific pages
                // then existing must not be activated on any page, or we fail
                if(!empty($stickyPaths)){
                    $foundExistingSticky = true;
                }
            } else if ($sticky->sticky_website_flag){
                // If existing sticky is on whole website, and current sticky is on specific pages
                // then current must not be activated on any page, or we fail
                if(!empty($specificPagesPaths)){
                    $foundExistingSticky = true;
                }
            } else {
                // If both are on specific pages, then they must be on different
                // pages, oe else we fail
                foreach($stickyPaths as $path){
                    if(in_array($stickyDomain . $path, $specificPages)){
                        $foundExistingSticky = true;
                        break;
                    }
                }
            }

            if($isSameClient){
                $message = "There is already a Sticky Bar associated with this website for this funnel {$sticky->sticky_funnel_url}. Would you like to open that sticky bar?";
            }

            if($foundExistingSticky){

                // We are here it means, we failed, so lets deactivate current sticky
                $currentSticky = ClientFunnelSticky::where('id', $stickyId)->first();
                if($currentSticky){
                    $currentSticky->sticky_status = 0;
                    $currentSticky->pending_flag = 0;
                    $currentSticky->save();
                }

                // We return error accordingly
                return json_encode([
                    'status' => 'error',
                    'message' => $message,
                    'status_flag' => 0,
                    'id' => $isSameClient ? $sticky->id : 0
                ]);
            }
        }

        // We are here, it means, no existing sticky is found for given domain
        // we return with success
        return json_encode(['status'=>'success' ,'status_flag' => 1]);
    }


    public function updatestickycodetype(){
        if(!empty($_POST)) {
//            echo '<pre>';
//            print_r($_POST);
//            die;

            $table_data = array(
                'script_type' => $_POST['value'],
            );
            $msg = 'Sticky Bar has been updated.';
            $this->db->update('client_funnel_sticky', $table_data, 'client_id = '.$this->client_id.' and clients_leadpops_id='.$_POST['client_leadpops_id']);
            /* update clients_leadpops table's col last edit*/
            update_clients_leadpops_last_eidt($_POST['client_leadpops_id']);
            echo json_encode(['status'=>'success', 'message' => $msg]);
        }else{
            echo json_encode(['status'=>'error', 'Your request was not processed. Please try again.']);
        }
    }

    public function savestickybar(Request $request){
        if(!empty($request)) {
            $pages = '';
            $request->request->remove('bar_title_visible');
            $website_flag = 1;
            if(is_array($request->input('pages'))){
                $pages = $request->input('pages');
                if($pages[0]=='/'){ // Home checked
                    $pages = implode('~' , $pages);
                }else{
                    $pages = implode('~' , $pages);
                }
            }
            if(empty($request->input('pages_flag'))){
                $website_flag = 0;
            }

            $flag =  $request->input('insert_flag');
            $hash = substr(md5(openssl_random_pseudo_bytes(20)),-24);

            if($request->input('sticky_status') == 1 && $website_flag){

            }

            $stickyUrl = rtrim($request->input('cta_url'), '/');

            $table_data = array(
                'client_id' => $this->client_id,
                'clients_leadpops_id' => $request->input('client_leadpops_id'),
                'sticky_cta' => $request->input('bar_title'),
                'sticky_button' => $request->input('cta_title'),
                'show_cta' => $request->input('cta_icon'),
                'sticky_size' => $request->input('size'),
                'sticky_url' => $stickyUrl,
                'sticky_status' => $request->input('sticky_status'),
                'pending_flag' => $request->input('pending_flag'),
                'sticky_location' => $request->input('pin_flag'),
                'script_type' => $request->input('sticky_script_type'),
                'zindex' => $request->input('zindex'),
                'zindex_type' => $request->input('zindex_type'),
                'sticky_updated' => 1,
                'sticky_url_pathname' => $pages,
                'sticky_website_flag' => $website_flag,
                'sticky_funnel_url' => strtolower($request->input('sticky_bar_url')),
                'sticky_attributes' => 'a#linkanimation {
										   display: inline-block;
										   border-radius: 3px;
										   color: #ffffff;
                                           background-color: #f86e12;
                                           font-weight: 300;
										   padding: 4px 15px;
										  -webkit-animation: btnWiggle 5s infinite;
										   -moz-animation: btnWiggle 5s infinite;
										   -o-animation: btnWiggle 5s infinite;
										   animation: btnWiggle 5s infinite;
										}
										@-webkit-keyframes btnWiggle {
										    2% {
										        -webkit-transform: translateX(3px) rotate(2deg);
										        transform: translateX(3px) rotate(2deg);
										    }
										    4% {
										        -webkit-transform: translateX(-3px) rotate(-2deg);
										        transform: translateX(-3px) rotate(-2deg);
										    }
										    6% {
										        -webkit-transform: translateX(3px) rotate(2deg);
										        transform: translateX(3px) rotate(2deg);
										    }
										    8% {
										        -webkit-transform: translateX(-3px) rotate(-2deg);
										        transform: translateX(-3px) rotate(-2deg);
										    }
										    10% {
										        -webkit-transform: translateX(2px) rotate(1deg);
										        transform: translateX(2px) rotate(1deg);
										    }
										    12% {
										        -webkit-transform: translateX(-2px) rotate(-1deg);
										        transform: translateX(-2px) rotate(-1deg);
										    }
										    14% {
										        -webkit-transform: translateX(2px) rotate(1deg);
										        transform: translateX(2px) rotate(1deg);
										    }
										    16% {
										        -webkit-transform: translateX(-2px) rotate(-1deg);
										        transform: translateX(-2px) rotate(-1deg);
										    }
										    18% {
										        -webkit-transform: translateX(1px) rotate(0);
										        transform: translateX(1px) rotate(0);
										    }
										    20% {
										        -webkit-transform: translateX(-1px) rotate(0);
										        transform: translateX(-1px) rotate(0);
										    }
										}
										@-o-keyframes btnWiggle {
										    2% {
										        -webkit-transform: translateX(3px) rotate(2deg);
										        transform: translateX(3px) rotate(2deg);
										    }
										    4% {
										        -webkit-transform: translateX(-3px) rotate(-2deg);
										        transform: translateX(-3px) rotate(-2deg);
										    }
										    6% {
										        -webkit-transform: translateX(3px) rotate(2deg);
										        transform: translateX(3px) rotate(2deg);
										    }
										    8% {
										        -webkit-transform: translateX(-3px) rotate(-2deg);
										        transform: translateX(-3px) rotate(-2deg);
										    }
										    10% {
										        -webkit-transform: translateX(2px) rotate(1deg);
										        transform: translateX(2px) rotate(1deg);
										    }
										    12% {
										        -webkit-transform: translateX(-2px) rotate(-1deg);
										        transform: translateX(-2px) rotate(-1deg);
										    }
										    14% {
										        -webkit-transform: translateX(2px) rotate(1deg);
										        transform: translateX(2px) rotate(1deg);
										    }
										    16% {
										        -webkit-transform: translateX(-2px) rotate(-1deg);
										        transform: translateX(-2px) rotate(-1deg);
										    }
										    18% {
										        -webkit-transform: translateX(1px) rotate(0);
										        transform: translateX(1px) rotate(0);
										    }
										    20% {
										        -webkit-transform: translateX(-1px) rotate(0);
										        transform: translateX(-1px) rotate(0);
										    }
										}
										@keyframes btnWiggle {
										    2% {
										        -webkit-transform: translateX(3px) rotate(2deg);
										        transform: translateX(3px) rotate(2deg);
										    }
										    4% {
										        -webkit-transform: translateX(-3px) rotate(-2deg);
										        transform: translateX(-3px) rotate(-2deg);
										    }
										    6% {
										        -webkit-transform: translateX(3px) rotate(2deg);
										        transform: translateX(3px) rotate(2deg);
										    }
										    8% {
										        -webkit-transform: translateX(-3px) rotate(-2deg);
										        transform: translateX(-3px) rotate(-2deg);
										    }
										    10% {
										        -webkit-transform: translateX(2px) rotate(1deg);
										        transform: translateX(2px) rotate(1deg);
										    }
										    12% {
										        -webkit-transform: translateX(-2px) rotate(-1deg);
										        transform: translateX(-2px) rotate(-1deg);
										    }
										    14% {
										        -webkit-transform: translateX(2px) rotate(1deg);
										        transform: translateX(2px) rotate(1deg);
										    }
										    16% {
										        -webkit-transform: translateX(-2px) rotate(-1deg);
										        transform: translateX(-2px) rotate(-1deg);
										    }
										    18% {
										        -webkit-transform: translateX(1px) rotate(0);
										        transform: translateX(1px) rotate(0);
										    }
										    20% {
										        -webkit-transform: translateX(-1px) rotate(0);
										        transform: translateX(-1px) rotate(0);
										    }
										}'
            );
            if(!empty($request->input('cta_phone_number_checker')) && $request->input('cta_phone_number_checker') == 'on'){
                $table_data['stickybar_number_flag'] = 1;
                $table_data['stickybar_number'] = $request->input('cta_title_phone_number');
            }else{
                $table_data['stickybar_number_flag'] = 0;
            }

            $lastInsertId = '';
            if(empty($flag)){
                $msg = 'Sticky Bar has been saved.';
                $table_data['sticky_js_file'] = $hash;
                $lastInsertId = $this->db->insert('client_funnel_sticky', $table_data);
            }else{
                $hash = $flag;
                $file_name = $flag;
                $msg = 'Sticky Bar has been updated.';
                $table_data['sticky_js_file'] = $file_name;
                $this->db->update('client_funnel_sticky', $table_data, 'client_id = '.$this->client_id.' and clients_leadpops_id='.$request->input('client_leadpops_id'));
            }
            $table_sticky_data['sticky_status'] = 0;
            if($request->input('duplicate_url') && $website_flag){
                $qry = "update client_funnel_sticky set sticky_status = 0 where  sticky_url ='". $stickyUrl ."' and sticky_funnel_url != '".strtolower($request->input('sticky_bar_url')."'");
                $this->db->query ($qry);
            }

            /* MOVEMENT GEARMAN INTEGATION CODE - START */
            $client = $this->db->fetchRow( ReportSqlHelper::Instance()->getClientInfo($this->client_id) );
            if(@$_COOKIE['gearman_debug'] == 1){
                echo "<pre>".print_r(ReportSqlHelper::Instance()->funnels($this->client_id),1)."</pre>";
                echo "<pre>".print_r($client,1)."</pre>";
            }
            $exe_gearman = 0;
            if(isset($client['gearman_enable']) and $client['gearman_enable'] == 1){
                $exe_gearman = 1;
            }
            /* INTEGATION CODE STARTS FROM HERE - END */
            /* update clients_leadpops table's col last edit*/
            update_clients_leadpops_last_eidt($request->input('client_leadpops_id'));

            echo json_encode(['status'=>'success', 'message' => $msg , 'id' => $lastInsertId, 'hash' => $hash, 'gearIt'=>$exe_gearman, 'sticky' => $table_data]);
        }else{
            echo json_encode(['status'=>'error', 'Your request was not processed. Please try again.']);
        }
    }

    public function captureScreenshot(Request $request){

        $url = $request->input('url');

        $url = trim($url);

        $hash = md5($url);

        MyLeadsEvents::getInstance()->createScreenshot(['url' => $url]);

        return json_encode(['success' => true, 'hash' => $hash]);
    }

    public function totalexpertoauthAction() {
        $client_id=$_POST["client_id"];
        $status=$_POST["status"];
        $customize = $this->Default_Model_Customize;
        $customize->updateTotalExpert($client_id,$status);
        print("1");
    }
    public function totalexpertdeleteAction() {
        $client_id=$_POST["client_id"];
        $customize = $this->Default_Model_Customize;
        if($customize->deleteTotalExpert($client_id)) {
            $customize->deleteClientIntegrations(config('integrations.iapp.TOTAL_EXPERT')['sysname'], $this->registry->leadpops->client_id);
        }
        print("1");
    }
    public function homebotdeleteAction() {
        $client_id=$_POST["client_id"];
        $customize = $this->Default_Model_Customize;

        if($customize->deleteHomebot($client_id)) {
            $customize->deleteClientIntegrations(config('integrations.iapp.HOMEBOT')['sysname'], $this->registry->leadpops->client_id);
        }
        print("1");
    }

    /* sticky bar verison 2 start */
    /* Saif */
    public function checkfunneldomainv2(){
        $current_domain = trim($_POST['domain']);
        $clause = '';

        if(!empty($_POST['id']))$clause = "and NOT id='".$_POST['id']."'";
        $status = 1;
        $rs = $this->db->fetchRow("select * from `client_funnel_sticky` where sticky_status = '".$status."' and sticky_url = '".$current_domain."'".$clause);
        if($rs){
            echo json_encode(['status'=>'error', 'funnel_url' => $rs['sticky_url'] ]);
        }else{
            echo json_encode(['status'=>'success']);
        }
        die;
    }
    public function updatestickybarstatusv2(){
        if(!empty($_POST)) {
            $status = $_POST['value'];
            $msg = 'Sticky Bar has been Inactivated.';
            $class = 'danger';
            if($status != 0){
                $msg = 'Sticky Bar has been Activated.';
                $class = '';
            }
            $table_data = array(
                'sticky_status' => $status,
            );
            $this->db->update('client_funnel_sticky', $table_data, 'client_id = '.$this->client_id.' and clients_leadpops_id='.$_POST['client_leadpops_id']);
            /* update clients_leadpops table's col last edit*/
            update_clients_leadpops_last_eidt();
            echo json_encode(['status'=>'success', 'message' => $msg , 'class' => $class]);
        }else{
            echo json_encode(['status'=>'error', 'Unable to update Sticky Bar.']);
        }
    }
    public function updatestickycodetypev2(){
        if(!empty($_POST)) {
            $table_data = array(
                'script_type' => $_POST['script_type'],
            );
            $msg = 'Sticky Bar has been updated.';
            $this->db->update('client_funnel_sticky', $table_data, 'client_id = '.$this->client_id.' and clients_leadpops_id='.$_POST['clients_leadpops_id']);
            /* update clients_leadpops table's col last edit*/
            update_clients_leadpops_last_eidt();
            echo json_encode(['status'=>'success', 'message' => $msg]);
        }else{
            echo json_encode(['status'=>'error', 'Your request was not processed. Please try again.']);
        }
    }
    public function get_hash($length){
        $random_key = rand();
        $hash=preg_replace("/[^A-Za-z0-9 ]/", '', lp_encrypt($random_key));
        while(strlen($hash) < $length){
            $hash=preg_replace("/[^A-Za-z0-9 ]/", '',lp_encrypt($random_key));
        }
        $hash = substr($hash,0,$length);
        return $hash;
    }
    public function thirdpartywebsitemapping(Request $request, $hash_flag){

        if(!empty($request)) {
            $url_string =  $request->input('sticky_url');
            $third_party_website = array(
                'client_id' => $this->client_id,
                'clients_leadpops_id' => $request->input('clients_leadpops_id'),
                'sticky_url' => $request->input('sticky_url'),
                'third_party_url_tooltip'=> $url_string
            );
            if($hash_flag == 'true'){
                $max_tries = 15;
                do{
                    $hash = $this->get_hash(8);
                    $is_present = $this->db->fetchRow("select * from `client_funnel_sticky_3rd_party_website` WHERE `hash` = '$hash'");
                    $max_tries--;
                }while($is_present != false && $max_tries > 0);
                $third_party_website['hash'] = $hash;
                $third_party_website['third_party_url'] = $hash."~".$request->input('sticky_url')."";
            }
        }
        return $third_party_website;

    }
    function stickyimage(Request $request){
        LP_Helper::getInstance()->getCurrentHashData($_POST["hash"]);
        $rackspace = \App::make('App\Services\RackspaceUploader');
        if(LP_Helper::getInstance()->getCurrentHash()){
            $funnel_data = LP_Helper::getInstance()->getFunnelData();
            $session = LP_Helper::getInstance()->getSession();
            if (!empty($funnel_data)) {
                $vertical_id = $funnel_data["leadpop_vertical_id"];
                $subvertical_id = $funnel_data["leadpop_vertical_sub_id"];
                $leadpop_id = $funnel_data["leadpop_id"];
                $version_seq = $funnel_data["leadpop_version_seq"];
                $leadpop_template_id = $funnel_data["leadpop_template_id"];
                $leadpop_version_id = $funnel_data["leadpop_version_id"];
                $leadpop_type_id = $funnel_data["leadpop_type_id"];
            } else {
                // todo
            }
            $client_id  = $funnel_data['funnel']['client_id'];
            $time = time();
            $filename = strtolower($client_id . "_" . $leadpop_id . "_" . $leadpop_type_id . "_" . $vertical_id . "_" . $subvertical_id . "_" . $leadpop_template_id . "_" . $leadpop_version_id . "_" . $version_seq . "_" . $time);
            $section = substr($client_id, 0, 1);
            //Get container for a specific funnel
            $container = $this->registry->leadpops->clientInfo['rackspace_container'];
            if($request->input('logo_image_added_flag') == 1){
                $data = $request->input('logo_image_base_code');
                $pos  = strpos($data, ';');
                $type = explode(':', substr($data, 0, $pos))[1];
                $type = str_replace('image/','.',$type);
                $rackspace_path = 'images1/'. $section . '/' . $client_id . '/stickybar/' . $filename.$type;
                if($request->input('logo_image_removed_flag') == 1){
                    $file_path = str_replace("https://images.lp-images1.com/","", $request->input('logo_image_path')) ;
                    $rackspace->deleteTo( $container , $file_path);
                    $file = public_path().'/files/'.$filename.$type;
                    file_put_contents($file, file_get_contents($request->input('logo_image_base_code')));
                    $data = fopen($file, 'r+');
                    $cdn = $rackspace->uploadTo($container, $data, $rackspace_path);
                    unlink($file);
                    $temp_obj['logo_image_path'] = $cdn['image_url'];
                }else{
                    $file = public_path().'/files/'.$filename.$type;
                    file_put_contents($file, file_get_contents($request->input('logo_image_base_code')));
                    $data = fopen($file, 'r+');
                    $cdn = $rackspace->uploadTo($container, $data, $rackspace_path);
                    unlink($file);
                    $temp_obj['logo_image_path'] = $cdn['image_url'];
                }
            }else if($request->input('logo_image_removed_flag') == 1){
                $file_path = str_replace("https://images.lp-images1.com/","", $request->input('logo_image_path')) ;
                $rackspace->deleteTo( $container , $file_path);
                $temp_obj['logo_image_path'] =  "";
            }else {
                $temp_obj['logo_image_path']= $request->input('logo_image_path');
            }

            if($request->input('background_image_added_flag') == 1){
                $data = $request->input('background_image_base_code');
                $pos  = strpos($data, ';');
                $type = explode(':', substr($data, 0, $pos))[1];
                $type = str_replace('image/','.',$type);
                $rackspace_path = 'images1/'. $section . '/' . $client_id . '/stickybar/' . $filename.$type;
                if($request->input('background_image_removed_flag') == 1){
                    $file_path = str_replace("https://images.lp-images1.com/","", $request->input('background_image_path')) ;
                    $rackspace->deleteTo( $container , $file_path);
                    $file = public_path().'/files/'.$filename.$type;
                    file_put_contents($file, file_get_contents($request->input('background_image_base_code')));
                    $data = fopen($file, 'r+');
                    $cdn = $rackspace->uploadTo($container, $data, $rackspace_path);
                    unlink($file);
                    $temp_obj['background_image_path'] = $cdn['image_url'];
                }else{
                    $file = public_path().'/files/'.$filename.$type;
                    file_put_contents($file, file_get_contents($request->input('background_image_base_code')));
                    $data = fopen($file, 'r+');
                    $cdn = $rackspace->uploadTo($container, $data, $rackspace_path);
                    unlink($file);
                    $temp_obj['background_image_path'] = $cdn['image_url'];
                }
            }else if($request->input('background_image_removed_flag') == 1){
                $file_path = str_replace("https://images.lp-images1.com/","", $request->input('background_image_path')) ;
                $rackspace->deleteTo( $container , $file_path);
            }else{
                $temp_obj['background_image_path'] = $request->input('background_image_path');
            }

            return $temp_obj;

        }else{
            // LP-TODO 404 REDIRECT
        }
        // Allowed extentions.
    }
    public function savethirdpartyslug(){
        $global_results =  $this->db->fetchall("select * from client_funnel_sticky_3rd_party_website where hash = '{$_POST["slug"]}'");

        if(empty($global_results)){
            $data = array(  'hash' => $_POST["slug"],
                'third_party_url' => $_POST["slug"]."~".$_POST["url"]);
            $where = "hash = '".$_POST["hash"]."'";
            $this->db->update('client_funnel_sticky_3rd_party_website',$data, $where);

            /* update clients_leadpops table's col last edit*/
            update_clients_leadpops_last_eidt();

            echo json_encode(['status'=>'success', 'response'=>'Slug name has been updated.', 'data'=> $_POST["slug"]]);
            die;
        }else{
            echo json_encode(['status'=>'error', 'response'=>'This slug is already in use. Please try something else.']);
            die;
        }
    }
    public function curl_request($url)
    {
        $ch = curl_init();
        $this->sb_third_party_ssl_flag = 0;
        // set URL and other appropriate options
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_TIMEOUT, 3000);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        // grab URL and pass it to the browser
        $this->sb_third_party_html = curl_exec($ch);
        $curl_info = curl_getinfo($ch);
        if(empty($this->sb_third_party_html) || $this->sb_third_party_html == ' ' ){
            $this->is_ssl($curl_info['redirect_url']);
        }
        if (curl_errno($ch)) {
            // error no 6 = no domain
            // error no 301 and 302
            $result = curl_errno($ch);
            if($result['http_code'] == 302){
                // change sticky url
                $_POST["sticky_url"] = $result['redirect_url'];
                // flag update
                $this->sb_third_party_ssl_flag  = 1;
            }else{
                echo json_encode(['status'=>'error','message'=>'Please enter a valid URL.']);
                die;
            }
        } else{
            // cURL executed successfully
            $result = curl_getinfo($ch);
            $url = explode(":", $result['url']) ;
            if($url[0] == "https"){
                // update flag 1
                $this->sb_third_party_ssl_flag = 1;
            }else{
                // update flag 0
                $this->sb_third_party_ssl_flag = 0;
            }
        }
        $this->new_sticky_bar_url = $result['url'];
        // close cURL resource, and free up system resources
        curl_close($ch);

    }
    public function is_iframe_support (Request $request){
        $url = $request->input('domain');
        $ch = curl_init();
        $msg = "This website not support such kind of functionality";
        // set URL and other appropriate options
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_TIMEOUT, 3000);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        // grab URL and pass it to the browser
        $sb_third_party_html = curl_exec($ch);
        $curl_info = curl_getinfo($ch);
        if(empty($sb_third_party_html) || $sb_third_party_html == ' ' ) {
            $url = $curl_info['redirect_url'];
        }
        if($curl_info['http_code'] == 301) {
            $url = $curl_info['redirect_url'];
        }
        if($curl_info['http_code'] == 0) {
            $msg = "This website not exist.";
            echo json_encode(['status'=>'error', 'message' => $msg]);
            die;
        }
        // close cURL resource, and free up system resources
        curl_close($ch);
        $url_headers = get_headers($url);
        foreach ($url_headers as $key => $value) {
            $x_frame_options_deny = strpos(strtolower($url_headers[$key]), strtolower('X-Frame-Options: DENY'));
            $x_frame_options_sameorigin = strpos(strtolower($url_headers[$key]), strtolower('X-Frame-Options: SAMEORIGIN'));
            $x_frame_options_allow_from = strpos(strtolower($url_headers[$key]), strtolower('X-Frame-Options: ALLOW-FROM'));
            if ($x_frame_options_deny !== false || $x_frame_options_sameorigin !== false || $x_frame_options_allow_from !== false) {
                echo json_encode(['status'=>'error', 'message' => $msg]);
                die;
            }
        }
        echo json_encode(['status'=>'success', 'message' => $msg]);
    }
    public function is_ssl($url){
        $this->curl_request($url);
        // for meta info

        $require_data = array("og:type", "og:locale", "description", "og:image","og:title", "og:description", "og:url", "og:site_name", "og:locale", "fb:app_id","twitter:image","og:type","og:site_name","og:image:width", " twitter:card", "twitter:description", "twitter:title","title","og:image:height","og:image:url","og:url");
        preg_match_all('/<[\s]*meta[\s]*(name|property)="?' . '([^>"]*)"?[\s]*' . 'content="?([^>"]*)"?[\s]*[\/]?[\s]*>/si', $this->sb_third_party_html, $matchs);
        $thrid_party_website_array = [];
        $attr_array = $matchs[0];
        foreach($attr_array as $i => $val){
            if(in_array($matchs[2][$i], $require_data)){
                $thrid_party_website_array[] = array(
                    $matchs[1][$i] =>  $matchs[2][$i],
                    'content' => $matchs[3][$i]
                );
            }
        }

        //  for title

        preg_match("/<title>(.*)<\/title>/i", $this->sb_third_party_html, $matches);
        if(isset($matches[1])){
            $thrid_party_website_array[] = array(
                "title" => $matches[1]
            );
        }


        // for favicon

        preg_match('/<\s*link[^>]+?rel\s*=\s*[\'\"]\s*(shortcut|icon)\s*(shortcut|icon)?\s*[\'\"][^>]*?>/im', $this->sb_third_party_html, $favicon);
        if(isset($favicon[0])){
            $thrid_party_website_array[] = array(
                "favicon" =>  $favicon[0]
            );
        }

        $arr = array(
            "flag"=>$this->sb_third_party_ssl_flag,
            "thrid_party_website_array" => $thrid_party_website_array
        );
        return $arr;
    }
    public function savestickybarv2(Request $request){
        $this->new_sticky_bar_url = '';
        $insert = 'true';
        $thrid_party_website_array='';

        if(!empty($request)) {

            if($request->input('third_party_website_flag') == 1){
                $third_party_url_edit = $request->input('third_party_url_edit');

                if(!empty($third_party_url_edit)){
                    $meta_tag_arr = $this->is_ssl($request->input("sticky_url"));
                    if ($this->new_sticky_bar_url != ''){
                        $request->merge(['sticky_url' , $this->new_sticky_bar_url]);
                    }
                    $data = array(  'sticky_url' => $request->input('sticky_url'),
                        'third_party_url_tooltip' => $request->input('sticky_url'),
                        'third_party_url' => $request->input('edit_url_hash')."~".$request->input("sticky_url"),
                        'is_ssl'=> $meta_tag_arr["flag"],
                        'third_party_website_SEO_info'=>json_encode($meta_tag_arr["thrid_party_website_array"])
                    );
                    $where = "third_party_url = '".$request->input("third_party_url_edit")."'";
                    $this->db->update('client_funnel_sticky_3rd_party_website',$data, $where);
                    $insert = 'false';
                }

            }

            $website_flag = 1;

            if($request->input('sticky_website_flag') == '/'){
                $website_flag = 0;
            }

            $flag =  $request->input('insert_flag');
            $hash = substr(md5(openssl_random_pseudo_bytes(20)),-24);

            if($request->input('sticky_status')==1 && $website_flag){

                /**
                 * Disabled as per bob's email with Subject: Re: leadPops issues @ Date: Fri, Sep 21, 2018
                 */
//                $s = "UPDATE `client_funnel_sticky` SET sticky_status = 0 WHERE sticky_url = '".$_POST['cta_url']."' AND sticky_status = 1";
//                $this->db->query ($s);

            }

            $table_data = array(
                'client_id' => $this->client_id,
                'clients_leadpops_id' => (int)$request->input('clients_leadpops_id'),
                'sticky_cta' => $request->input('sticky_cta'),
                'sticky_button' => $request->input('sticky_button'),
                'show_cta' => $request->input('show_cta'),
                'sticky_size' => $request->input('sticky_size'),
                'sticky_status' => $request->input('sticky_status'),
                'pending_flag' => $request->input('pending_flag'),
                'sticky_location' => $request->input('sticky_location'),
                'hide_animation' => $request->input('hide_animation'),
                'script_type' => $request->input('script_type'),
                'zindex' => $request->input('zindex'),
                'zindex_type' => $request->input('zindex_type'),
                'sticky_updated' => 1,
                'sticky_url_pathname' => $request->input('sticky_url_pathname'),
                'third_party_website_flag' => $request->input('third_party_website_flag'),
                'sticky_website_flag' => $website_flag,
                'sticky_funnel_url' => strtolower($request->input('sticky_funnel_url')),
                'sticky_attributes' => ''
            );

            $stickybar_number_flag =  $request->input('stickybar_number_flag');

            if(!empty($stickybar_number_flag)){
                $table_data['stickybar_number_flag'] = 1;
                $table_data['stickybar_number'] = $request->input('stickybar_number');
            }else{
                $table_data['stickybar_number_flag'] = 0;
                $table_data['stickybar_number'] = $request->input('stickybar_number');
            }

            $temp_data_obj = $table_data;

            /* Sticky Bar CTA text*/

            $temp_data_obj['cta_color'] = $request->input('cta_color');
            $temp_data_obj['cta_background_color'] = $request->input('cta_background_color');
            $temp_data_obj['cta_text_html'] = $request->input('cta_text_html');
            $temp_data_obj['cta_text_font_family'] = $request->input('cta_text_font_family');
            $temp_data_obj['cta_box_shadow'] = $request->input('cta_box_shadow');

            /* Sticky Bar CTA Button text */

            $temp_data_obj['cta_btn_color'] = $request->input('cta_btn_color');
            $temp_data_obj['cta_btn_background_color'] = $request->input('cta_btn_background_color');
            $temp_data_obj['cta_btn_text_html'] = $request->input('cta_btn_text_html');
            $temp_data_obj['cta_btn_text_font_family'] = $request->input('cta_btn_text_font_family');
            $temp_data_obj['cta_btn_animation'] = $request->input('cta_btn_animation');
            $temp_data_obj['cta_btn_vertical_padding'] = $request->input('cta_btn_vertical_padding');
            $temp_data_obj['cta_btn_horizontal_padding'] = $request->input('cta_btn_horizontal_padding');

            /* Sticky Bar flags */

            $temp_data_obj['sticky_bar_v2'] = 'true';
            $temp_data_obj['stickybar_btn_flag'] = $request->input('stickybar_btn_flag');
            $temp_data_obj['full_page_sticky_bar_flag'] = $request->input('full_page_sticky_bar_flag');

            /* Sticky bar other options */

            $temp_data_obj['advance_sticky_location'] = $request->input('advance_sticky_location');
            $temp_data_obj['when_to_display'] = $request->input('when_to_display');
            $temp_data_obj['when_to_hide'] = $request->input('when_to_hide');
            $temp_data_obj['stickybar_cta_btn_other_url'] = $request->input('stickybar_cta_btn_other_url');
            $temp_data_obj['domain_name'] = $request->input('domain_name');
            $temp_data_obj['sticky_bar_pixel'] = $request->input('sticky_bar_pixel');
            $temp_data_obj['hash'] = $request->input('hash');

            /* Sticky Bar Images  */

            $temp_data_obj['logo_image_width'] = $request->input('logo_image_width');
            $temp_data_obj['logo_image_size'] = $request->input('logo_image_size');
            $temp_data_obj['logo_image_height'] = $request->input('logo_image_height');
            $temp_data_obj['logo_image_width'] = $request->input("hash");
            $temp_data_obj['logo_spacing'] = $request->input('logo_spacing');
            $temp_data_obj['logo_image_replacement'] = $request->input('logo_image_replacement');

            $temp_data_obj['background_image_opacity'] = $request->input('background_image_opacity');
            $temp_data_obj['background_image_size'] = $request->input('background_image_size');
            $temp_data_obj['background_image_color_overlay'] = $request->input('background_image_color_overlay');

            if(empty($flag)){

                /* Sticky Bar Insert case */

                if($table_data['third_party_website_flag'] == 0){
                    $table_data['sticky_url'] = $request->input('sticky_url');
                    $temp_data_obj['sticky_url'] = $request->input('sticky_url');
                }

                $msg = 'Sticky Bar has been saved.';
                $table_data['sticky_js_file'] = $hash;
                $temp_data_obj['sticky_js_file'] = $hash;

                if($table_data['third_party_website_flag'] == 1) {
                    $temp_data_obj['last_selection_of_website'] = 'third_party';
                    $temp_data_obj['parent_data'] = 'empty';
                }else{
                    $temp_data_obj['last_selection_of_website'] = 'own_side';
                    $temp_data_obj['parent_data'] = 'fill';
                }

                $data_obj = json_encode($temp_data_obj ,JSON_HEX_TAG | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_HEX_APOS);

                $table_data['sticky_data'] = $data_obj;
                $this->db->insert('client_funnel_sticky', $table_data);

                $sticky_id = $this->db->lastInsertId();
                $table_data['sticky_id'] = $sticky_id;

                if($table_data['third_party_website_flag'] == 1) {
                    $third_party_website = $this->thirdpartywebsitemapping($request,'true');
                    $third_party_website['client_funnel_sticky_id'] = $sticky_id;
                    $third_party_website['sticky_bar_style'] = $data_obj;
                    $meta_tag_arr = $this->is_ssl($request->input("sticky_url"));
                    if ($this->new_sticky_bar_url != ''){
                        $request->merge(['sticky_url' , $this->new_sticky_bar_url]);
                    }
                    $third_party_website['is_ssl'] = $meta_tag_arr["flag"];
                    $third_party_website['third_party_website_SEO_info'] = json_encode($meta_tag_arr["thrid_party_website_array"]);
                    $this->db->insert('client_funnel_sticky_3rd_party_website', $third_party_website);
                    $thrid_party_website_id = $this->db->lastInsertId();
                    $thrid_party_website_array = [
                        'client_id' => $request->input('client_id'),
                        'clients_leadpops_id' => $request->input('clients_leadpops_id'),
                        'sticky_url' => $request->input('sticky_url'),
                        'client_funnel_sticky_id' => $sticky_id,
                        'hash' => $third_party_website['hash'],
                        'clicks' => '0',
                        'sticky_bar_style' => $data_obj,
                        'third_party_url' => $third_party_website['hash']."~".$request->input('sticky_url'),
                        'created_date' => strtotime(time()),
                        'created_date_format' => date('m/d/y',time()),
                        'id' => $thrid_party_website_id,
                        'third_party_url_tooltip' => $third_party_website['third_party_url_tooltip']
                    ];
                    $thrid_party_website_array[$sticky_id] = [
                        0 => $thrid_party_website_array
                    ];
                }

            } else{

                /* Sticky Bar Update case */

                if($table_data['third_party_website_flag'] == 0){
                    $table_data['sticky_url'] = $request->input('sticky_url');
                    $temp_data_obj['sticky_url'] = $request->input('sticky_url');
                }

                $hash = $flag;
                $file_name = $flag;

                $msg = 'Sticky Bar has been updated.';

                $table_data['sticky_js_file'] = $file_name;
                $temp_data_obj['sticky_js_file'] = $file_name;;

                if($table_data['third_party_website_flag'] == 1) {
                    $temp_data_obj['last_selection_of_website'] = 'third_party';
                } else {
                    $temp_data_obj['last_selection_of_website'] = 'own_side';
                    $temp_data_obj['parent_data'] = 'fill';
                }

                /* Sticky Bar Images */

                $image_path = $this->stickyimage($request);

                $temp_data_obj['logo_image_path'] = $image_path['logo_image_path'];

                $temp_data_obj['background_image_path'] = $image_path['background_image_path'];

                $data_obj = json_encode($temp_data_obj,JSON_HEX_TAG | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_HEX_APOS);

                $table_data['sticky_data'] = $data_obj;

                if($table_data['third_party_website_flag'] == 1){
                    $sticky_id = $request->input('sticky_id');
                    $sticky_url = $request->input('sticky_url');
                    if($insert == 'true' && $request->input('url_flag') == "" ) {
                        $third_party_website = $this->thirdpartywebsitemapping($request, 'true');
                        $third_party_website['client_funnel_sticky_id'] = $sticky_id;
                        $third_party_website['sticky_bar_style'] = $data_obj;
                        $meta_tag_arr = $this->is_ssl($request->input("sticky_url"));
                        if ($this->new_sticky_bar_url != ''){
                            $request->merge(['sticky_url' , $this->new_sticky_bar_url]);
                        }
                        $third_party_website['is_ssl'] = $meta_tag_arr["flag"];
                        $third_party_website['third_party_website_SEO_info'] = json_encode($meta_tag_arr["thrid_party_website_array"]);
                        $this->db->insert('client_funnel_sticky_3rd_party_website', $third_party_website);
                    }else{
                        $data = array(
                            'sticky_bar_style' => $data_obj);
                        $where = "third_party_url = '".$request->input("third_party_url")."'";
                        $this->db->update('client_funnel_sticky_3rd_party_website',$data, $where);
                    }
                    if($request->input("another_cta_url") == 1){
                        $third_party_website = $this->thirdpartywebsitemapping($request, 'true');
                        $third_party_website['client_funnel_sticky_id'] = $sticky_id;
                        $third_party_website['sticky_bar_style'] = $data_obj;
                        $meta_tag_arr = $this->is_ssl($request->input("sticky_url"));
                        if ($this->new_sticky_bar_url != ''){
                            $request->merge(['sticky_url' , $this->new_sticky_bar_url]);
                        }
                        $third_party_website['is_ssl'] = $meta_tag_arr["flag"];
                        $third_party_website['third_party_website_SEO_info'] = json_encode($meta_tag_arr["thrid_party_website_array"]);
                        $this->db->insert('client_funnel_sticky_3rd_party_website', $third_party_website);
                    }

                    $data = array(
                        'third_party_website_flag' => '1');
                    $where = 'client_id = '.$this->client_id.' and clients_leadpops_id='.$request->input('clients_leadpops_id');
                    $this->db->update('client_funnel_sticky',$data, $where);
                }else{
                    $this->db->update('client_funnel_sticky', $table_data, 'client_id = '.$this->client_id.' and clients_leadpops_id='.$request->input('clients_leadpops_id'));
                }
                $sticky_id = $request->input('sticky_id');
            }

            $table_sticky_data['sticky_status'] = 0;
            $exe_gearman = 0;

            $results = 'select * from client_funnel_sticky_3rd_party_website where client_funnel_sticky_id ='.$sticky_id.' and active_flag = 1  ORDER BY created_date DESC';
            $results = $this->db->fetchall($results);
            $thrid_party_website_array = [];

            foreach($results as $result){
                $thrid_party_website_array[$result['client_funnel_sticky_id']][] = [
                    'id' =>  $result['id'],
                    'hash' => $result['hash'],
                    'sticky_url' => $result['sticky_url'],
                    'client_id' => $result['client_id'],
                    'clicks' => $result['clicks'],
                    'clients_leadpops_id' => $result['clients_leadpops_id'],
                    'sticky_bar_style' => $result['sticky_bar_style'],
                    'third_party_url' => $result['third_party_url'],
                    'third_party_url_tooltip' => $result['third_party_url_tooltip'],
                    'created_date' => strtotime($result['created_date']),
                    'created_date_format' => date('m/d/y',strtotime($result['created_date']))
                ];
            }

            $results = "select * from client_funnel_sticky where id={$sticky_id}";
            $data = $this->db->fetchRow($results);
            $sticky_data = json_decode($data["sticky_data"],true);
            $sticky_data['sticky_id'] = $sticky_id;
            $sticky_data['sticky_url'] = $data["sticky_url"];
            $sticky_data['third_party_website_flag'] = $data["third_party_website_flag"];
            $sticky_data['third_party_website'] = $thrid_party_website_array;
            $sticky_data = json_encode($sticky_data,JSON_HEX_TAG | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_HEX_APOS);

            /* update clients_leadpops table's col last edit*/
//            update_clients_leadpops_last_eidt($sticky_data['clients_leadpops_id']);

            echo json_encode(['section'=>'true','status'=>'success', 'message' => $msg , 'hash' => $hash, 'gearIt'=>$exe_gearman, 'sticky' => $sticky_data]);
        }else{
            echo json_encode(['section'=>'true','status'=>'error','message'=> 'Your request was not processed. Please try again.']);
        }
    }
    public function diactivethirdpartywebsite(){
        $this->db->update('client_funnel_sticky_3rd_party_website', 'active_flag = 0', 'id='.(int) $_POST['id']);

        /* update clients_leadpops table's col last edit*/
        update_clients_leadpops_last_eidt();

        $results = "select * from client_funnel_sticky_3rd_party_website where clients_leadpops_id ={$_POST['funnel_id']} and active_flag = 1 ";
        $results = $this->db->fetchall($results);
        if(empty($results)){
            $data = array(
                'third_party_website_flag' =>"0" );
            $where = "clients_leadpops_id = '".$_POST["funnel_id"]."'";
            update('client_funnel_sticky',$data, $where);
        }
    }

    public function adaAccessibility(Request $request)
    {
        LP_Helper::getInstance()->getCurrentHashData();
        if (LP_Helper::getInstance()->getCurrentHash()) {
            $hash_data = LP_Helper::getInstance()->getFunnelData();
            $session = LP_Helper::getInstance()->getSession();
            $this->setCommonDataForView($hash_data, $session);

            if ($request->isMethod('post') && isset($request->is_ada_accessibility)) {
                try {
                    $is_ada_accessibility = $request->input("is_ada_accessibility") == 1 ? 1 : 0;
                    $this->Default_Model_Customize->updateLeadLine("is_ada_accessibility", $is_ada_accessibility, $this->registry->leadpops->client_id, $hash_data["funnel"]["leadpop_id"], $hash_data["funnel"]["leadpop_version_seq"]);
                    $updatedStatus = $is_ada_accessibility ? "active" : "inactive";
                    /* update clients_leadpops table's col last edit*/
                    update_clients_leadpops_last_eidt();
                    return $this->successResponse("Your ADA accessibility settings are $updatedStatus.");
//                    Session::flash('success', "<strong>Success:</strong> Your ADA accessibility settings are $updatedStatus.");
                } catch (\Exeception $e) {
                    return $this->errorResponse("Saving ADA Accessibility.");
//                    Session::flash('error', '<strong>Error:</strong> Saving ADA Accessibility. ');
                }
//                return $this->lp_redirect('/popadmin/adaaccessibility/'.$hash_data["current_hash"]);
            }
            $this->data->ada_accessibility['is_ada_accessibility'] = $this->Default_Model_Customize->getLeadLine($this->registry->leadpops->client_id, $hash_data["funnel"]["leadpop_id"], $hash_data["funnel"]["leadpop_version_seq"], "is_ada_accessibility");

            $this->active_menu = LP_Constants::ADA_ACCESSIBILITY;

            return $this->response();
        }
    }

    /* sticky bar verison 2 end */
    //add tag when we are adding the new own domain

    function addtag($rec){
        $s = "SELECT c_lp.id as client_leadpop_id,lp_gp.group_name,lp_v.lead_pop_vertical,lp_vs.fs_display_label
             FROM  leadpops_verticals_sub lp_vs
             INNER JOIN leadpops_vertical_groups lp_gp ON lp_gp.id = lp_vs.group_id
             INNER JOIN leadpops_verticals lp_v ON lp_v.id = lp_vs.leadpop_vertical_id
             INNER JOIN clients_leadpops c_lp ON ( c_lp.leadpop_version_id = " . $rec['leadpop_version_id'] . "
             AND c_lp.leadpop_version_seq = " . $rec['leadpop_version_seq'] . "
             AND c_lp.client_id = " . $this->registry->leadpops->client_id . ")
             WHERE   lp_vs.id = ". $rec['leadpop_vertical_sub_id'];
        $r = $this->db->fetchRow($s);
        assign_tag_to_funnel($r['client_leadpop_id'],$rec['leadpop_id'],$r['group_name']);
        $t = strpos_arr($r['fs_display_label']);
        if($t != false){
            $t = $t;
        }else{
            $t = $r['fs_display_label'];
        }
        assign_tag_to_funnel($r['client_leadpop_id'],$rec['leadpop_id'],$t);
        $vertical_name = $r['lead_pop_vertical'].' Funnels';
        $folder_id =  assign_folder_to_funnel($vertical_name);
        $data = array(
            'leadpop_folder_id' => $folder_id
        );
        $where = ' id = '.$r['client_leadpop_id']." ";
        $this->db->update('clients_leadpops',$data,$where);

    }
    /*
     * New Code for Admin 3.0
     * */
    public function integrate($key){
        LP_Helper::getInstance()->getCurrentHashData();
        if(LP_Helper::getInstance()->getCurrentHash()){
            $global_obj = $this->Default_Model_Global;
            $this->data->LeadpopAccessToken = $global_obj->getLeadpopAccessToken($this->registry->leadpops->client_id);
            $customize = $this->Default_Model_Customize;
            $hash_data = LP_Helper::getInstance()->getFunnelData();
            $this->data->subscriptions = $customize->getClientSubscriptions($this->registry->leadpops->client_id);
            $this->data->integrations = $customize->getClientIntegrations($this->registry->leadpops->client_id);
            $this->data->clientToken = $global_obj->getClientToken($this->registry->leadpops->client_id);
            $this->data->isActiveClientIntegration = $customize->isActiveClientIntegration($this->registry->leadpops->client_id,$hash_data['funnel']['leadpop_id'], $hash_data['funnel']['leadpop_vertical_id'], $hash_data['funnel']['leadpop_vertical_sub_id'], $hash_data['funnel']['leadpop_template_id'], $hash_data['funnel']['leadpop_version_id'], $hash_data['funnel']['leadpop_version_seq'], $key);
            $this->data->client_id = $this->client_id;
            $this->data->currenthash = $hash_data["current_hash"];
            $this->data->key = $key;
            $this->active_menu = LP_Constants::INTEGRATION;
            return $this->response();
        }
    }
    /*
     * New Code Ends
     * */
}
