<?php

/**
 * Created by PhpStorm.
 * User: Jazib
 * Date: 05/11/2019
 * Time: 4:54 PM
 */
namespace App\Constants;
use App\Services\DataRegistry;
use LP_Helper;

class LP_Constants
{
	const NONE = 0;
	const VIEW = 1;
	const EDIT = 2;
	const ALERTS = 3;
    const MY_LEADS = 4;
    const CLONE_FUNNEL = 5;
    const STATUS = 6;
	const DELETE = 7;
	const CALL_TO_ACTION = 8;
	const AUTO_RESPONDER = 9;
	const SEO = 10;
	const CONTACT_INFO = 11;
	const THANK_YOU = 12;
	const THANK_YOU_EDIT = 13;
	const FOOTER = 14;
	const PRIVACY_POLICY = 15;
	const TERMS_OF_USE = 16;
	const DISCLOSURES = 17;
	const LICENSE_INFO = 18;
	const ABOUT_US = 19;
	const CONTACT_US = 20;
	const FEATURED_MEDIA = 21;
	const LOGO = 22;
	const BACKGROUND = 23;
	const DOMAIN = 24;
	const PIXEL = 25;
	const VERTICAL_ID_FOR_LANDING_PAGES = 7;    // Vertical for Landing Pages
	const INTEGRATION = 26;
    const STATS = 27;
    const STICKY = 28;
    const TAG = 29;
    const ADA_ACCESSIBILITY = 30;
    const SHARE_FUNNEL = 31;
    const ADVANCE_FOOTER = 32;
    const FUNNEL_BUILDER = 33;

    const TCPA_MESSAGE = 34;
    const SECURITY_MESSAGE = 35;
    const BRANDING = 36;

    const ENCRYPTION_SECRET = "leadpop_secret";
    const ENCRYPTION_IV = "leadpop_encription_iv";

    /**
    * STAT PERIOD
    */
    const STAT_LAST_7_DAYS = 1;
    const STAT_LAST_30_DAYS = 2;
    const STAT_CURRENT_MONTH = 3;
    const STAT_PREVIOUS_MONTH = 4;

	/**
	 * Client Products
	 */
	const PRODUCT_FUNNEL = 1;
	const PRODUCT_EMAILFIRE = 2;
	const PRODUCT_LANDING = 3;

	const URL_TO_SCHEDULE_LEADPOP_CALL = "https://leadpops.com/consult/";

	/**
	 * Pixels
	 */
	const PIXEL_PLACEMENT_HEAD = 1;
	const PIXEL_PLACEMENT_BODY = 2;
	const PIXEL_PLACEMENT_FOOTER = 3;
	const PIXEL_PLACEMENT_TYP = 4;

	const GOOGLE_ANALYTICS = 1;
	const FACEBOOK_PIXELS = 2;
	const GOOGLE_TAG_MANAGER = 3;
	const GOOGLE_CODE_CONVERSION_PIXEL = 4;
	const BING_PIXELS = 5;
	const GOOGLE_CODE_RETARGETING_PIXEL = 6;
	const INFORMA_PIXEL = 7;
    const FACEBOOK_DOMAIN_VERIFICAION = 10;
    const FACEBOOK_CONVERSION_API = 11;
	const PIXEL_ACTION_SEARCH = 1;
	const PIXEL_ACTION_LEAD = 2;
	const PIXEL_ACTION_COMPLETE_REGISTRATION = 3;

	//Tracking Options List
    const PIXEL_PAGE_VIEW = 1;
    const PIXEL_PAGE_PLUS_QUESTION = 3;

    // PLAN LEVEL CONSTANTS
    const PLAN_LEVEL_MARKETER = 'marketer';
    const PLAN_LEVEL_PRO_PER_MONTH = 'pro-monthly';
    const PLAN_LEVEL_PRO_PER_YEAR = 'pro-yearly';
    const ADD_BRANDING_WITH_PLAN_UPGRADE = "0";
    const ADD_BRANDING_ONLY = "1";

	public static function getInnerMenus(){
	    global $sb_arr;
		$funnel_data = LP_Helper::getInstance()->getFunnelData();

		$funnel = @$funnel_data['funnel'];

        $sticky_id = $sticky_status = $sticky_js_file = $sticky_funnel_url = $sticky_url = $sticky_button = $sticky_cta = $sticky_bar = "";
        $pending_flag = 0;
        $funnel_sticky_status = '';
        $sticky_script_type = 'a';
        $sticky_page_path = '/';
        $sticky_website_flag = 0;
        if(!empty($funnel['sticky_id'])){
            $sticky_bar = 'sticky-bar-inactive';
            if($funnel['sticky_status'] != 0){
                $sticky_bar = 'sticky-bar-active';
            }
            $sticky_id = $funnel['sticky_id'];
            $sticky_cta = $funnel['sticky_cta'];
            $sticky_button = $funnel['sticky_button'];
            $sticky_url = $funnel['sticky_url'];
            $sticky_funnel_url = $funnel['sticky_funnel_url'];
            $sticky_js_file = $funnel['sticky_js_file'];
            $sticky_status = $funnel['sticky_status'];
            $pending_flag = $funnel['pending_flag'];
            $show_cta = $funnel['show_cta'];
            $sticky_size = $funnel['sticky_size'];

            $sticky_updated = $funnel['sticky_updated'];
            $sticky_script_type = $funnel['sticky_script_type'];

            $sticky_zindex = $funnel['zindex'];
            $sticky_zindex_type = $funnel['zindex_type'];

            if($sticky_updated){
                if($sticky_status==0){
                    $funnel_sticky_status = '(Inactive)';
                }else if($pending_flag == 0){
                    $funnel_sticky_status = '(Pending Installation)';
                }else{
                    $funnel_sticky_status = '(Active)';
                }
            }

            $sticky_page_path = $funnel['sticky_url_pathname'];
            $sticky_website_flag = $funnel['sticky_website_flag'];
        }


		 /*echo "<pre>";
		 print_r($sb_arr);*/
		 //exit();
		$return = [
			LP_Constants::VIEW => [
				"html" => '<a target="_blank" href="'.LP_Helper::getInstance()->getFunnelUrl(@$funnel['domain_name']).'">View</a>',
				'class' => 'view'
			],
			LP_Constants::EDIT => [
				"html" => '<a class="" href="#"><span>Edit</span> <span class="caret"></span></a>
                            <ul class="drop-menu-down">
                                <li><a href="'.LP_BASE_URL.LP_PATH."/popadmin/domain/".$funnel['hash'].'">Domains</a></li>
                                <li class="sub-drop-down"><a href="#"><span>Design</span> <span class="caret-right"></span></a>
                                    <ul class="sub-drop-menu-down">
                                        <div class="sub-menu-wrapper">
                                            <li><a href="'.LP_BASE_URL.LP_PATH."/popadmin/logo/".$funnel['hash'].'">Logo</a></li>
                                            <li><a href="'.LP_BASE_URL.LP_PATH."/popadmin/background/".$funnel['hash'].'">Background</a></li>
                                            <li><a href="'.LP_BASE_URL.LP_PATH."/popadmin/featuredmedia/".$funnel['hash'].'">Featured Image</a></li>
                                        </div>
                                    </ul>
                                </li>
                                <li class="sub-drop-down"><a href="#"><span>Content</span> <span class="caret-right"></span></a>
                                    <ul class="sub-drop-menu-down">
                                        <div class="sub-menu-wrapper">
                                            <li><a href="'.LP_BASE_URL.LP_PATH.'/popadmin/calltoaction/'.$funnel['hash'].'">Call-to-Action</a></li>
                                            <li><a href="'.LP_BASE_URL.LP_PATH.'/popadmin/footeroption/'.$funnel['hash'].'">Footer <span style="font-weight: 700;font-size: 9px;font-style: italic;">(new feature inside!)</span></a></li>
                                            <li><a href="'.LP_BASE_URL.LP_PATH.'/popadmin/autoresponder/'.$funnel['hash'].'">Autoresponder</a></li>
                                            <li><a href="'.LP_BASE_URL.LP_PATH.'/popadmin/seo/'.$funnel['hash'].'">SEO</a></li>
                                            <li><a href="'.LP_BASE_URL.LP_PATH.'/popadmin/contact/'.$funnel['hash'].'">Contact Info</a></li>
                                            <li><a href="'.LP_BASE_URL.LP_PATH.'/popadmin/thankyou/'.$funnel['hash'].'">Thank You</a></li>
                                        </div>
                                    </ul>
                                </li>
                                <li><a href="'.LP_BASE_URL.LP_PATH."/popadmin/pixels/".$funnel['hash'].'">Pixels</a></li>
                                <li><a href="'.LP_BASE_URL.LP_PATH."/popadmin/integration/".$funnel['hash'].'">Integrations</a></li>
                                <li><a href="'.LP_BASE_URL.LP_PATH."/popadmin/adaaccessibility/".$funnel['hash'].'">ADA Accessibility</a></li>
                            </ul>',
				'class' => 'edit drop-menu'
			],
			LP_Constants::ALERTS => [
				"html" => '<a href="'.LP_BASE_URL.LP_PATH."/account/contacts/".$funnel['hash'].'">Lead Alerts</a>',
				'class' => 'alerts'
			],
            LP_Constants::STATS => [
                "html" => '<a href="#" class="statsInnerPopupCta" data-hash="'.$funnel['hash'].'">Stats</a>',
                'class' => 'stats'
            ],
			LP_Constants::MY_LEADS => [
				"html" => '<a href="'.LP_BASE_URL.LP_PATH."/myleads/index/".$funnel['hash'].'">My Leads</a>',
				'class' => 'my-leads'
			],
			LP_Constants::STATUS => [
				"html" => '<a href="#" data-status="'.$funnel['leadpop_active'].'" data-leadpop_version_seq="'.$funnel['leadpop_version_seq'].'" data-domain_id="'.$funnel['domain_id'].'" data-leadpop_id="'.$funnel['leadpop_id'].'" data-leadpop_version_id="'.$funnel['leadpop_version_id'].'" class="funnelStatusBtn funnelstatus_'.$funnel['domain_id'].'">Status</a>',
				'class' => 'status'
			],
			LP_Constants::CLONE_FUNNEL => [
				"html" => '<a href="#" data-ctalink="'.LP_BASE_URL.LP_PATH.'/index/clonefunnel/'.$funnel['hash'].'" class="cloneFunnelBtn">Clone</a>',
				'class' => 'clone'
			],
            LP_Constants::STICKY => [
                "html" => '<a id="sticky-bar-btn-menu" href="#" class="sticky-bar-menu-link"
                            data-field="'.$funnel['domain_name'].'"
                            data-id="'.$funnel['client_leadpop_id'].'"
                            data-element_id = "sticky-bar-btn-menu"
                            data-sticky_id = "'.$sticky_id.'"
                            data-sticky_cta = "'.$sticky_cta.'"
                            data-sticky_button = "'.$sticky_button.'"
                            data-sticky_url = "'.$sticky_url.'"
                            data-sticky_funnel_url = "'.$sticky_funnel_url.'"
                            data-sticky_js_file = "'.$sticky_js_file.'"
                            data-sticky_status = "'.$sticky_status.'"
                            data-sticky_show_cta = "'.$show_cta.'"
                            data-sticky_size = "'.$sticky_size.'"
                            data-pending_flag = "'.$pending_flag.'"
                            data-v_sticky_button = "'.str_replace('###','\'' , $funnel['v_sticky_button'] ).'"
                            data-v_sticky_cta = "'.str_replace('###','\'' , $funnel['v_sticky_cta'] ).'"
                            data-sticky_page_path = "'.$sticky_page_path.'"
                            data-sticky_website_flag = "'.$sticky_website_flag.'"
                            data-sticky_location = "'.$funnel['sticky_location'].'"
                            data-sticky_script_type = "'.$sticky_script_type.'"
                            data-sticky_zindex = "'.$sticky_zindex.'"
                            data-sticky_zindex_type = "'.$sticky_zindex_type.'"
                            >Sticky Bar</a>',
                'class' => 'sticky-icon'
            ],
			/*LP_Constants::DELETE => [
				"html" => '<a href="#"  data-ctalink="'.LP_BASE_URL.LP_PATH.'/index/deletefunnel/'.$funnel['hash'].'" class="deleteFunnelBtn">Delete</a>',
                'class' => 'delete'
			],*/
		];

		if(LP_Helper::getInstance()->getCloneFlag()!='y'){
		    ## unset($return[LP_Constants::CLONE_FUNNEL]);

			$return[LP_Constants::CLONE_FUNNEL] = [
				"html" => '<a href="#" class="cloneFunnelReqBtn">Clone</a>',
				'class' => 'clone'
			];

		    unset($return[LP_Constants::DELETE]);
        } else if($funnel['leadpop_version_seq'] == 1){
			unset($return[LP_Constants::DELETE]);
		}


        if($funnel['leadpop_vertical_id']==LP_Constants::VERTICAL_ID_FOR_LANDING_PAGES){
            unset($return[LP_Constants::CLONE_FUNNEL]);
            //<li><a href="'.LP_BASE_URL.LP_PATH.'/popadmin/contact/'.$funnel['hash'].'">Contact Info</a></li>
            $return[LP_Constants::EDIT] = [
                "html" => '<a class="" href="#"><span>Edit</span> <span class="caret"></span></a>
                            <ul class="drop-menu-down">
                                <li class="sub-drop-down"><a href="#"><span>Content</span> <span class="caret-right"></span></a>
                                    <ul class="sub-drop-menu-down">
                                        <div class="sub-menu-wrapper">
                                            <li><a href="'.LP_BASE_URL.LP_PATH.'/popadmin/seo/'.$funnel['hash'].'">SEO</a></li>
                                            <li><a href="'.LP_BASE_URL.LP_PATH.'/popadmin/thankyou/'.$funnel['hash'].'">Thank You</a></li>
                                            <li><a href="'.LP_BASE_URL.LP_PATH.'/popadmin/autoresponder/'.$funnel['hash'].'">Autoresponder</a></li>
                                        </div>
                                    </ul>
                                </li>
                                <li><a href="'.LP_BASE_URL.LP_PATH."/popadmin/pixels/".$funnel['hash'].'">Pixels</a></li>
                                <li><a href="'.LP_BASE_URL.LP_PATH."/popadmin/integration/".$funnel['hash'].'">Integrations</a></li>
                                <li><a href="'.LP_BASE_URL.LP_PATH."/popadmin/adaaccessibility/".$funnel['hash'].'">ADA Accessibility</a></li>
                            </ul>',
                'class' => 'edit drop-menu'
            ];
        }
		return $return;
	}

	public static function getInnerMenusV2(){
        $registry = DataRegistry::getInstance();
		$funnel_data = LP_Helper::getInstance()->getFunnelData();

		$funnel = @$funnel_data['funnel'];

        $sticky_id = $sticky_status = $sticky_js_file = $sticky_funnel_url = $sticky_url = $sticky_button = $sticky_cta = $sticky_bar = "";
        $pending_flag = 0;
        $funnel_sticky_status = '';
        $sticky_script_type = 'a';
        $sticky_page_path = '/';
        $sticky_website_flag = 0;
        if(!empty($funnel['sticky_id'])){
            $sticky_bar = 'sticky-bar-inactive';
            if($funnel['sticky_status'] != 0){
                $sticky_bar = 'sticky-bar-active';
            }
            $sticky_id = $funnel['sticky_id'];
            $sticky_cta = $funnel['sticky_cta'];
            $sticky_button = $funnel['sticky_button'];
            $sticky_url = $funnel['sticky_url'];
            $sticky_funnel_url = $funnel['sticky_funnel_url'];
            $sticky_js_file = $funnel['sticky_js_file'];
            $sticky_status = $funnel['sticky_status'];
            $pending_flag = $funnel['pending_flag'];
            $show_cta = $funnel['show_cta'];
            $sticky_size = $funnel['sticky_size'];

            $sticky_updated = $funnel['sticky_updated'];
            $sticky_script_type = $funnel['sticky_script_type'];

            $sticky_zindex = $funnel['zindex'];
            $sticky_zindex_type = $funnel['zindex_type'];

            if($sticky_updated){
                if($sticky_status==0){
                    $funnel_sticky_status = '(Inactive)';
                }else if($pending_flag == 0){
                    $funnel_sticky_status = '(Pending Installation)';
                }else{
                    $funnel_sticky_status = '(Active)';
                }
            }

            $sticky_page_path = $funnel['sticky_url_pathname'];
            $sticky_website_flag = $funnel['sticky_website_flag'];
        }


		 /*echo "<pre>";
		 print_r($funnel);
		 echo "</pre>";*/
		 //exit();
        $tag = '';
        if(isset($registry->leadpops->clientInfo['tag_folder'])
            and ($registry->leadpops->clientInfo['tag_folder'] == 1 OR @$_COOKIE['tag'] == 1)) {
            $tag = '<li><a href="' . LP_BASE_URL . LP_PATH . "/tag/" . $funnel['hash'] . '">Name & Tags</a></li>';
        }
        $subdomain = strtolower(preg_replace('/\s*[\-\ ]\s*/','-',($funnel['funnel_name'])?$funnel['funnel_name']:$funnel['subdomain_name']));
        $subdomain_name = LP_Helper::getInstance()->generateSubdDomain($subdomain);
        //if funnel type own domain then it will work in clone process
        if($funnel['leadpop_type_id'] == 2){
            $top_domain = 'secure-clix.com';
        }else{
            $top_domain = 'itclix.com';
        }
        $top_level_domain = ($funnel['top_level_domain'])?$funnel['top_level_domain']:$top_domain;
		$return = [
			LP_Constants::VIEW => [
				"html" => '<a target="_blank" href="'.LP_Helper::getInstance()->getFunnelUrl(@$funnel['domain_name']).'">View</a>',
				'class' => 'view'
			],
			LP_Constants::EDIT => [
                "html" => '<a class="" href="#"><span>Edit</span> <span class="caret"></span></a>
                            <ul class="drop-menu-down lp-version-2">
                                <li class="sub-drop-down"><span>Content</span>
                                    <ul class="sub-drop-menu-down">
                                        <div class="sub-menu-wrapper">
                                            <li><a href="'.LP_BASE_URL.LP_PATH.'/popadmin/calltoaction/'.$funnel['hash'].'">Call-to-Action</a></li>
                                            <li><a href="'.LP_BASE_URL.LP_PATH.'/popadmin/footeroption/'.$funnel['hash'].'">Footer</a></li>
                                            <li><a href="'.LP_BASE_URL.LP_PATH.'/popadmin/autoresponder/'.$funnel['hash'].'">Autoresponder</a></li>
                                            <li><a href="'.LP_BASE_URL.LP_PATH.'/popadmin/seo/'.$funnel['hash'].'">SEO</a></li>
                                            <li><a href="'.LP_BASE_URL.LP_PATH.'/popadmin/contact/'.$funnel['hash'].'">Contact Info</a></li>
                                            <li><a href="'.LP_BASE_URL.LP_PATH.'/popadmin/thankyou/'.$funnel['hash'].'">Thank You</a></li>
                                        </div>
                                    </ul>
                                </li>
                                <li class="sub-drop-down"><span>Design</span>
                                    <ul class="sub-drop-menu-down">
                                        <div class="sub-menu-wrapper">
                                            <li><a href="'.LP_BASE_URL.LP_PATH."/popadmin/logo/".$funnel['hash'].'">Logo</a></li>
                                            <li><a href="'.LP_BASE_URL.LP_PATH."/popadmin/background/".$funnel['hash'].'">Background</a></li>
                                            <li><a href="'.LP_BASE_URL.LP_PATH."/popadmin/featuredmedia/".$funnel['hash'].'">Featured Image</a></li>
                                        </div>
                                    </ul>
                                </li>

                                <li class="sub-drop-down"><span>Settings</span>
                                    <ul class="sub-drop-menu-down">
                                        <div class="sub-menu-wrapper">
                                            '.$tag.'
                                            <li><a href="'.LP_BASE_URL.LP_PATH."/popadmin/domain/".$funnel['hash'].'">Domains</a></li>
                                            <li><a href="'.LP_BASE_URL.LP_PATH."/popadmin/pixels/".$funnel['hash'].'">Pixels</a></li>
                                            <li><a href="'.LP_BASE_URL.LP_PATH."/popadmin/integration/".$funnel['hash'].'">Integrations</a></li>
                                            <li><a href="'.LP_BASE_URL.LP_PATH."/popadmin/adaaccessibility/".$funnel['hash'].'">ADA Accessibility</a></li>
                                        </div>
                                    </ul>
                                </li>
                                 <li class="sub-drop-down"><span>Promote</span>
                                <ul class="sub-drop-menu-down">
                                <div class="sub-menu-wrapper">
                                <div>
                                <a id="sticky-bar-btn-menu" href="#" class="sticky-bar-menu-link"
                            data-field="'.$funnel['domain_name'].'"
                            data-id="'.$funnel['client_leadpop_id'].'"
                            data-element_id = "sticky-bar-btn-menu"
                            data-sticky_id = "'.@$sticky_id.'"
                            data-sticky_cta = "'.@$sticky_cta.'"
                            data-sticky_button = "'.@$sticky_button.'"
                            data-sticky_url = "'.@$sticky_url.'"
                            data-sticky_funnel_url = "'.@$sticky_funnel_url.'"
                            data-sticky_js_file = "'.@$sticky_js_file.'"
                            data-sticky_status = "'.@$sticky_status.'"
                            data-sticky_show_cta = "'.@$show_cta.'"
                            data-sticky_size = "'.@$sticky_size.'"
                            data-pending_flag = "'.@$pending_flag.'"
                            data-v_sticky_button = "'.str_replace('###','\'' , $funnel['v_sticky_button'] ).'"
                            data-v_sticky_cta = "'.str_replace('###','\'' , $funnel['v_sticky_cta'] ).'"
                            data-sticky_page_path = "'.@$sticky_page_path.'"
                            data-sticky_website_flag = "'.@$sticky_website_flag.'"
                            data-sticky_location = "'.$funnel['sticky_location'].'"
                            data-sticky_script_type = "'.@$sticky_script_type.'"
                            data-sticky_zindex = "'.@$sticky_zindex.'"
                            data-sticky_zindex_type = "'.@$sticky_zindex_type.'"
                            >Sticky Bar <span class="funnel-sticky-status">'.@$funnel_sticky_status.'</span></div></a></div>
                                </li></ul>
                            </ul>',
                'class' => 'edit drop-menu'
            ],
			LP_Constants::ALERTS => [
				"html" => '<a href="'.LP_BASE_URL.LP_PATH."/account/contacts/".$funnel['hash'].'">Lead Alerts</a>',
				'class' => 'alerts'
			],
            LP_Constants::STATS => [
                "html" => '<a href="#" class="statsInnerPopupCta" data-hash="'.$funnel['hash'].'">Stats</a>',
                'class' => 'stats'
            ],
			LP_Constants::MY_LEADS => [
				"html" => '<a href="'.LP_BASE_URL.LP_PATH."/myleads/index/".$funnel['hash'].'">My Leads</a>',
				'class' => 'my-leads'
			],
			LP_Constants::STATUS => [
				"html" => '<a href="#" data-status="'.$funnel['leadpop_active'].'" data-leadpop_version_seq="'.$funnel['leadpop_version_seq'].'" data-domain_id="'.$funnel['domain_id'].'" data-leadpop_id="'.$funnel['leadpop_id'].'" data-leadpop_version_id="'.$funnel['leadpop_version_id'].'" class="funnelStatusBtn funnelstatus_'.$funnel['domain_id'].'">Status</a>',
				'class' => 'status'
			],
			LP_Constants::CLONE_FUNNEL => [
				"html" => '<a href="#" data-ctalink="'.LP_BASE_URL.LP_PATH.'/index/clonefunnel/'.$funnel['hash'].'" data-subdomain="'.$subdomain_name.'" data-top-domain="'.$top_level_domain.'"class="cloneFunnelSubdomainBtn">Clone</a>',
				'class' => 'clone'
			],
            LP_Constants::STICKY => [
                "html" => '<a id="sticky-bar-btn-menu" href="#" class="sticky-bar-menu-link"
                            data-field="'.@$funnel['domain_name'].'"
                            data-id="'.@$funnel['client_leadpop_id'].'"
                            data-element_id = "sticky-bar-btn-menu"
                            data-sticky_id = "'.@$sticky_id.'"
                            data-sticky_cta = "'.@$sticky_cta.'"
                            data-sticky_button = "'.@$sticky_button.'"
                            data-sticky_url = "'.@$sticky_url.'"
                            data-sticky_funnel_url = "'.@$sticky_funnel_url.'"
                            data-sticky_js_file = "'.@$sticky_js_file.'"
                            data-sticky_status = "'.@$sticky_status.'"
                            data-sticky_show_cta = "'.@$show_cta.'"
                            data-sticky_size = "'.@$sticky_size.'"
                            data-pending_flag = "'.@$pending_flag.'"
                            data-v_sticky_button = "'.str_replace('###','\'' , $funnel['v_sticky_button'] ).'"
                            data-v_sticky_cta = "'.str_replace('###','\'' , $funnel['v_sticky_cta'] ).'"
                            data-sticky_page_path = "'.@$sticky_page_path.'"
                            data-sticky_website_flag = "'.@$sticky_website_flag.'"
                            data-sticky_location = "'.@$funnel['sticky_location'].'"
                            data-sticky_script_type = "'.@$sticky_script_type.'"
                            data-sticky_zindex = "'.@$sticky_zindex.'"
                            data-sticky_zindex_type = "'.@$sticky_zindex_type.'"
                            >Sticky Bar</a>',
                'class' => 'sticky-icon'
            ],
			/*LP_Constants::DELETE => [
				"html" => '<a href="#"  data-ctalink="'.LP_BASE_URL.LP_PATH.'/index/deletefunnel/'.$funnel['hash'].'" class="deleteFunnelBtn">Delete</a>',
                'class' => 'delete'
			],*/
		];

		if(LP_Helper::getInstance()->getCloneFlag()!='y'){
		    ## unset($return[LP_Constants::CLONE_FUNNEL]);

			$return[LP_Constants::CLONE_FUNNEL] = [
				"html" => '<a href="#" class="cloneFunnelReqBtn">Clone</a>',
				'class' => 'clone'
			];

		    unset($return[LP_Constants::DELETE]);
        } else if($funnel['leadpop_version_seq'] == 1){
			unset($return[LP_Constants::DELETE]);
		}


        if($funnel['leadpop_vertical_id']==LP_Constants::VERTICAL_ID_FOR_LANDING_PAGES){
            unset($return[LP_Constants::CLONE_FUNNEL]);
            //<li><a href="'.LP_BASE_URL.LP_PATH.'/popadmin/contact/'.$funnel['hash'].'">Contact Info</a></li>
            $return[LP_Constants::EDIT] = [
                "html" => '<a class="" href="#"><span>Edit</span> <span class="caret"></span></a>
                            <ul class="drop-menu-down">
                                <li class="sub-drop-down"><a href="#"><span>Content</span> <span class="caret-right"></span></a>
                                    <ul class="sub-drop-menu-down">
                                        <div class="sub-menu-wrapper">
                                            <li><a href="'.LP_BASE_URL.LP_PATH.'/popadmin/seo/'.$funnel['hash'].'">SEO</a></li>
                                            <li><a href="'.LP_BASE_URL.LP_PATH.'/popadmin/thankyou/'.$funnel['hash'].'">Thank You</a></li>
                                            <li><a href="'.LP_BASE_URL.LP_PATH.'/popadmin/autoresponder/'.$funnel['hash'].'">Autoresponder</a></li>
                                        </div>
                                    </ul>
                                </li>
                                <li><a href="'.LP_BASE_URL.LP_PATH."/popadmin/pixels/".$funnel['hash'].'">Pixels</a></li>
                                <li><a href="'.LP_BASE_URL.LP_PATH."/popadmin/integration/".$funnel['hash'].'">Integrations</a></li>
                                <li><a href="'.LP_BASE_URL.LP_PATH."/popadmin/adaaccessibility/".$funnel['hash'].'">ADA Accessibility</a></li>
                            </ul>',
                'class' => 'edit drop-menu'
            ];
        }
		return $return;
	}

	public static function getBreadcrumText($menu=LP_Constants::NONE, $viewData = null){
		switch ($menu){
			case LP_Constants::ALERTS:
				return "Lead Alerts / Funnel";
				break;
			case LP_Constants::MY_LEADS:
				return "My Leads / Funnel";
				break;
			case LP_Constants::CALL_TO_ACTION:
				return "CTA Messaging / Funnel";
				break;
			case LP_Constants::AUTO_RESPONDER:
				return "Autoresponder / Funnel";
				break;
			case LP_Constants::SEO:
				return "SEO / Funnel";
				break;
			case LP_Constants::CONTACT_INFO:
				return "Contact Info / Funnel";
				break;
			case LP_Constants::THANK_YOU:
				return "Thank You Page / Funnel";
				break;
			case LP_Constants::THANK_YOU_EDIT:
				return "Thank You Page Edit / Funnel";
				break;
			case LP_Constants::FOOTER:
				return "Footer / Funnel";
				break;
			case LP_Constants::PRIVACY_POLICY:
				return self::getDynamicBreadcrumbText("Privacy Policy / Funnel", @$viewData->bottomlinks['privacy_text']);
				break;
			case LP_Constants::TERMS_OF_USE:
                return self::getDynamicBreadcrumbText("Terms Of Use / Funnel", @$viewData->bottomlinks['terms_text']);
				break;
			case LP_Constants::DISCLOSURES:
                return self::getDynamicBreadcrumbText("Disclosures / Funnel", @$viewData->bottomlinks['disclosures_text']);
				break;
			case LP_Constants::LICENSE_INFO:
                return self::getDynamicBreadcrumbText("Licensing Information / Funnel", @$viewData->bottomlinks['licensing_text']);
				break;
			case LP_Constants::ABOUT_US:
                return self::getDynamicBreadcrumbText("About Us / Funnel", @$viewData->bottomlinks['about_text']);
				break;
			case LP_Constants::CONTACT_US:
                return self::getDynamicBreadcrumbText("Contact Us / Funnel", @$viewData->bottomlinks['contact_text']);
				break;
			case LP_Constants::FEATURED_MEDIA:
				return "Featured Image / Funnel";
				break;
			case LP_Constants::LOGO:
				return "Logo / Funnel";
				break;
			case LP_Constants::BACKGROUND:
				return "Page Background / Funnel";
				break;
			case LP_Constants::DOMAIN:
				return "Domain / Funnel";
				break;
			case LP_Constants::PIXEL:
				return "Pixels / Funnel";
				break;
			case LP_Constants::INTEGRATION:
				return "Integrations / Funnel";
				break;
            case LP_Constants::ADA_ACCESSIBILITY:
                return "ADA Accessibility / Funnel";
                break;
            case LP_Constants::TAG:
                return "Name / Folder / Tags / Funnel";
                break;
            case LP_Constants::STATS:
                return "Statistics / Funnel";
                break;
            case LP_Constants::SHARE_FUNNEL:
                return "Share My Funnel / Funnel";
                break;
            case LP_Constants::ADVANCE_FOOTER:
                return "Extra Content / Funnel";
                break;
            case LP_Constants::FUNNEL_BUILDER:
                return "Questions  / Funnel";
                break;
            case LP_Constants::TCPA_MESSAGE:
                return "TCPA Language  / Funnel";
                break;

            case LP_Constants::SECURITY_MESSAGE:
                return "Security Message  / Funnel";
                break;
            case LP_Constants::BRANDING:
                return "leadPops Branding  / Funnel";
                break;
			default:
				return "Funnel";
				break;
		}
	}

    /**
     * Default breadcrumb text will be displayed if provided field Text if empty
     * @param $default_text
     * @param string $field_text
     * @return string
     */
    public static function getDynamicBreadcrumbText($default_text, $field_text = ""){
	    if(!empty($field_text)) {
	        $defaultData = explode("/", $default_text);
	        return $field_text . " /" . $defaultData[1];
        }
	    return $default_text;
    }

	public static function pixelPlacementsList(){
		return [
//			LP_Constants::PIXEL_PLACEMENT_HEAD => "Head",
			LP_Constants::PIXEL_PLACEMENT_BODY => "Funnel",
//			LP_Constants::PIXEL_PLACEMENT_FOOTER => "Footer",
			LP_Constants::PIXEL_PLACEMENT_TYP => "Thank You Page"
		];
	}

	public static function pixelPositionList(){
		return [
			LP_Constants::PIXEL_PLACEMENT_HEAD => "Head",
			LP_Constants::PIXEL_PLACEMENT_BODY => "Body",
			LP_Constants::PIXEL_PLACEMENT_FOOTER => "Footer",
		];
	}

	public static function getPixelPlace($id){
		if ($id == LP_Constants::PIXEL_PLACEMENT_HEAD || $id == LP_Constants::PIXEL_PLACEMENT_FOOTER) {
			$id = LP_Constants::PIXEL_PLACEMENT_BODY;
		}
		$choiceList = LP_Constants::pixelPlacementsList();
		if(array_key_exists($id, $choiceList)){
			return $choiceList[$id];
		}else{
			return null;
		}
	}

	public static function getPixelPosition($id){
		if ($id == LP_Constants::PIXEL_PLACEMENT_TYP) {
			$id = LP_Constants::PIXEL_PLACEMENT_HEAD;
		}
		$choiceList = LP_Constants::pixelPositionList();
		if(array_key_exists($id, $choiceList)){
			return $choiceList[$id];
		}else{
			return null;
		}
	}

	public static function pixelTypeList(){
		return [
			LP_Constants::BING_PIXELS => "Bing Pixel",
			LP_Constants::FACEBOOK_PIXELS => "Facebook Pixel",
            LP_Constants::FACEBOOK_DOMAIN_VERIFICAION => "Facebook Domain Verification",
            LP_Constants::FACEBOOK_CONVERSION_API => "Facebook Conversion API",
			LP_Constants::GOOGLE_ANALYTICS => "Google Analytics",
			LP_Constants::GOOGLE_TAG_MANAGER => "Google Tag Manager",
			LP_Constants::GOOGLE_CODE_CONVERSION_PIXEL => "Google Conversion Pixel",
			LP_Constants::GOOGLE_CODE_RETARGETING_PIXEL => "Google Re-targeting Pixel",
			LP_Constants::INFORMA_PIXEL => "Informa Pixel",
		];
	}

	public static function getPixelType($id){
		$choiceList = LP_Constants::pixelTypeList();
		if(array_key_exists($id, $choiceList)){
			return $choiceList[$id];
		}else{
			return null;
		}
	}

	public static function pixelActions(){
		return [
			LP_Constants::PIXEL_ACTION_SEARCH => "Search",
			LP_Constants::PIXEL_ACTION_LEAD => "Lead Conversion",
			LP_Constants::PIXEL_ACTION_COMPLETE_REGISTRATION => "Complete Registration"
		];
	}

	public static function getPixelAction($id){
		$choiceList = LP_Constants::pixelActions();
		if(array_key_exists($id, $choiceList)){
			return $choiceList[$id];
		}else{
			return null;
		}
	}

	//Muhammad Zulfiqar
    public static function pixelTrackingList($id = ''){

	    $rr = [
            LP_Constants::PIXEL_PAGE_VIEW => "Page View",
            LP_Constants::PIXEL_PAGE_PLUS_QUESTION => "Page View + Questions",
            LP_Constants::PIXEL_ACTION_LEAD => "Lead Conversion"
        ];

	    if($id){
            return $rr[$id];
        }else{
	        return $rr;
        }


    }
}
