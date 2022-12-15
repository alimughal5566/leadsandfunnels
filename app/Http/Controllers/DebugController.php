<?php
namespace App\Http\Controllers;

use App\Constants\Layout_Partials;
use App\Constants\LP_Constants;
use App\Repositories\CustomizeRepository;
use App\Repositories\LpAdminRepository;
use App\Services\DataRegistry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use LP_Helper;
use Session;

class DebugController extends BaseController {

    private $Default_Model_Customize;
    private $lpAdmin;

    public function __construct(LpAdminRepository $lpAdmin, CustomizeRepository $customtizeRepo){
        $this->middleware(function($request, $next) use ($lpAdmin, $customtizeRepo) {
            $this->Default_Model_Customize = $customtizeRepo;
            $this->lpAdmin = $lpAdmin;
            $this->registry = DataRegistry::getInstance();
            $this->registry->_initProperties(Session::get('leadpops'));
            $this->init($lpAdmin);
            if($request->ajax()) $this->check_ajax_session(); else $this->check_session();
            return $next($request);
        });
    }

    function funnels() {
        $registry = DataRegistry::getInstance();
        $data = LP_Helper::getInstance()->getFunnels();
        $i = 0;

        #$columns = array('question_sequence', 'domain_id', 'funnel_name', 'domain_name', 'fs_display_label', 'stats_redis_key', 'client_leadpop_id', 'leadpop_id', 'leadpop_vertical_id', 'leadpop_vertical_sub_id', 'group_id', 'leadpop_template_id', 'leadpop_version_id', 'leadpop_version_seq', 'leadpop_type_id', 'total_visits', 'total_leads', 'hash');
        $columns = array('question_sequence', 'funnel_market', 'domain_id', 'funnel_name', 'domain_name', 'stats_redis_key', 'lead_content', 'client_leadpop_id', 'leadpop_id', 'leadpop_folder_id', 'funnel_tags', 'leadpop_vertical_id', 'leadpop_vertical_sub_id', 'group_id', 'leadpop_template_id', 'leadpop_version_id', 'leadpop_version_seq', 'total_visits', 'total_leads');
        if($data){
            $client_id = 0;

            $list = array();
            foreach($data as $verticals){
                foreach($verticals as $groups){
                    foreach($groups as $subv){
                        foreach($subv as $funnel){
                            $list[$funnel['funnel_market']][] = $funnel;
                        }
                    }
                }
            }

            if($registry->leadpops->clientInfo['is_mm'] == 1){
                $client_type = "Movement";
            }
            else if($registry->leadpops->clientInfo['is_fairway'] == 1){
                $client_type = "Fairway";
            }
            else if($registry->leadpops->clientInfo['is_aime'] == 1){
                $client_type = "AIME";
            }
            else if($registry->leadpops->clientInfo['is_thrive'] == 1){
                $client_type = "THRIVE";
            }
            else {
                if($registry->leadpops->clientInfo['client_type'] == 1){
                    $client_type = "Insurance";
                }
                else if($registry->leadpops->clientInfo['client_type'] == 5){
                    $client_type = "Real Estate";
                }
                else {
                    $client_type = "Default Mortgage";
                }
            }

            $html = array();
            $html[] = '<style>td, th{ font-family: Arial; font-size: 12px } a{ color: #000; text-decoration: none; text-transform: lowercase; } a:hover{ text-decoration: underline; }</style>';
            $html[] = '<table style="border-collapse:collapse" width="2500" cellspacing="0" cellpadding="3" border="1">';
            $html[] = '<tr>';
            $html[] = '<th colspan="6" style="background-color: #2f2e2e; color:#fff; text-align: left; font-size: 20px; padding: 10px 5px; border-right: 1px solid #2f2e2e">CLIENT ID</th>';
            $html[] = '<th colspan="'.(count($columns) - 5).'" style="background-color: #2f2e2e; color:#fff; text-align: left; font-size: 20px; padding: 10px 5px">Client Type: '.$client_type.'</th>';
            $html[] = '</tr>';



            $total_leads = array();
            $total_visits = array();
            $cmarket = "";
            $funnel_tags = LP_Helper::getInstance()->getAllFunnelTags();
            foreach($list as $market=>$funnel_type){
                foreach($funnel_type as $f=>$funnel){
                    if($cmarket != $market){
                        $cmarket = $market;
                        $html[] = '<tr><td colspan="'.(count($columns) + 1).'" style="background-color: #bbbbbb; text-align: left; font-size: 21px;">'.($cmarket == "w" ? " Website Funnels " : " Stock Funnels ").'</td></tr>';

                        $html[] = '<tr style="background-color: #d5d0d0"><th>Sr.</th>';
                        foreach($columns as $column){
                            if($column == "question_sequence"){
                                $html[] = '<th>JSON</th>';
                            } else {
                                $html[] = '<th style="text-align: left">'.$column.'</th>';
                            }
                        }
                        $html[] = '</tr>';
                    }

                    $funnel['stats_redis_key'] = $funnel['client_id']."-".$funnel['client_leadpop_id']."-".$funnel['domain_id'];
                    $funnel['lead_content'] = "lead-content-".$funnel['client_id']."-".$funnel['leadpop_id']."-".$funnel['leadpop_version_seq'];
                    $funnel['json'] = ($funnel['question_sequence'] != "" ? "yes" : "no");

                    $i++;
                    $client_id = $funnel['client_id'];

                    if(empty($_GET) || (isset($_GET) && in_array(key($_GET), $columns) && $_GET[key($_GET)] == $funnel[key($_GET)]) ){

                        ##echo "$i. ".$funnel['domain_name']." ------------- <small>".$funnel['fs_display_label']."</small><br />";
                        $html[] = "<tr style='background-color: ".($f%2 != 0 ? "#eeeeee" : "#ffffff").";'>";
                        $html[] = '<td>'.$i.'. </td>';
                        foreach($columns as $column){
                            if($column == "total_leads") $total_leads[] = ($funnel[$column] > 0 ? $funnel[$column] : 0);
                            if($column == "total_visits") $total_visits[] = ($funnel[$column] > 0 ? $funnel[$column] : 0);

                            if($column == "domain_name") $html[] = '<td><a href="https://'.$funnel[$column].'" target="_blank">'.$funnel[$column].'</a></td>';
                            else if($column == "hash" || $column == "domain_id") $html[] = '<td><a href="'.route('deubg_funnels_info', ['hash' => $funnel["hash"]]).'">'.$funnel[$column].'</a></td>';
                            else if($column == "leadpop_vertical_id") $html[] = '<td title="'.$funnel["vertical_label"].'">'.$funnel[$column].'</td>';
                            else if($column == "leadpop_vertical_sub_id") $html[] = '<td title="'.$funnel["lead_pop_vertical_sub"].'">'.$funnel[$column].'</td>';
                            else if($column == "group_id") $html[] = '<td title="'.$funnel["group_name"].'">'.$funnel[$column].'</td>';
                            else if($column == "question_sequence") $html[] = '<td style="text-align: center">'.($funnel['question_sequence'] != "" ? "✔" : "").'</td>';
                            else if($column == "funnel_market") $html[] = '<td style="text-align: center">'.$funnel['funnel_market'].'</td>';
                            //else if($column == "stats_redis_key") $html[] = '<td style="text-align: left"><a href="https://'.$funnel["domain_name"].'/redis-test.php?key='.$funnel['stats_redis_key'].'" target="_blank">'.$funnel['stats_redis_key'].'</a></td>';
                            else if($column == "stats_redis_key") $html[] = '<td style="text-align: left"><a href="'.url('/').'/lpscripts/kdbinfo.php?key='.$funnel['stats_redis_key'].'" target="_blank">'.$funnel['stats_redis_key'].'</a></td>';
                            else if($column == "lead_content") $html[] = '<td style="text-align: left"><a href="'.url('/').'/lpscripts/kdbinfo.php?key='.$funnel['lead_content'].'" target="_blank">'.$funnel['lead_content'].'</a></td>';
                            else if($column == "funnel_tags") {
                                if(isset($funnel_tags[$funnel['client_leadpop_id']])){
                                    $html[] = '<td style="text-align: left; width: 150px;">'.@$funnel_tags[$funnel['client_leadpop_id']]['tags']." ".@$funnel_tags[$funnel['client_leadpop_id']]['tag_ids'].'</a></td>';
                                } else{
                                    $html[] = '<td style="text-align: left">&nbsp;</td>';
                                }
                            }
                            else $html[] = '<td>'.$funnel[$column].'</td>';
                        }
                        $html[] = "</tr>";

                    }

                }
            }
            $html[] = '<tr><td colspan="'.(count($columns) + 1).'" style="background-color: #bbbbbb; text-align: left; font-size: 21px;">Total Leads: '.array_sum($total_leads).'</td></tr>';
            $html[] = '<tr><td colspan="'.(count($columns) + 1).'" style="background-color: #bbbbbb; text-align: left; font-size: 21px;">Total Visits: '.array_sum($total_visits).'</td></tr>';
            $html[] = '</table>';

            echo str_replace("CLIENT ID", "CLIENT ID - ".$client_id." (".$registry->leadpops->clientInfo['first_name']." ".$registry->leadpops->clientInfo['last_name'].")", implode("\n", $html));
        }
    }

    function funnelsInfo($hash){
        $data = LP_Helper::getInstance()->getFunnels();
        $funnels = array();
        foreach($data as $verticals){
            foreach($verticals as $groups){
                foreach($groups as $subv){
                    foreach($subv as $funnel){
                        $funnels[$funnel['hash']] = $funnel;
                    }
                }
            }
        }

        $info = $funnels[$hash];

        $funnel_questions = $info['funnel_questions'];
        unset($info['funnel_questions']);

        $funnel_variables = $info['funnel_variables'];
        unset($info['funnel_variables']);

        $sticky_attributes = $info['sticky_attributes'];
        unset($info['sticky_attributes']);

        dd($info, json_decode($funnel_variables), json_decode($funnel_questions));
    }

    function testCode(){
        rackspace_copy_file_as_with_gearman("http://50063ec2eb079cca84f0-70ed9ef0a7cb9a261e5f68675144a60b.r47.cf2.rackcdn.com/images1/8/8636/logos/8636_170_1_3_79_85_85_1__global__1mbsn754.png", "8/8636/logos/8636_166_1_3_77_83_83_1__global__1mbsn754.png", "devclients", "8636", "3~77~166~1");
        dd(1);
    }

    function stats_test(){
        $keydb = 'a:50:{s:10:"2021-03-24";s:23:"0-0-0-2-2-2-0-0-0-2-2-2";s:10:"2021-04-01";s:17:"0---64---0---10--";s:10:"2021-04-02";s:16:"0---65---0---9--";s:10:"2021-04-03";s:17:"0---70---0---10--";s:10:"2021-04-04";s:16:"0---46---0---8--";s:10:"2021-04-05";s:17:"0---69---0---10--";s:10:"2021-04-06";s:16:"0---36---0---5--";s:10:"2021-04-07";s:16:"0---27---0---5--";s:10:"2021-04-08";s:16:"0---51---0---9--";s:10:"2021-04-09";s:16:"0---57---0---8--";s:10:"2021-04-10";s:16:"0---25---0---3--";s:10:"2021-04-11";s:16:"0---46---0---7--";s:10:"2021-04-12";s:16:"0---49---0---8--";s:10:"2021-04-13";s:16:"0---57---0---8--";s:10:"2021-04-14";s:16:"0---45---0---7--";s:10:"2021-04-15";s:16:"0---36---0---6--";s:10:"2021-04-16";s:16:"0---64---0---9--";s:10:"2021-04-17";s:16:"0---42---0---8--";s:10:"2021-04-18";s:16:"0---49---0---7--";s:10:"2021-04-19";s:16:"0---25---0---3--";s:10:"2021-04-20";s:17:"0---67---0---10--";s:10:"2021-04-21";s:16:"0---14---0---2--";s:10:"2021-04-22";s:16:"0---33---0---4--";s:10:"2021-04-23";s:17:"0---65---0---10--";s:10:"2021-04-24";s:16:"0---14---0---2--";s:10:"2021-04-25";s:16:"0---40---0---6--";s:10:"2021-04-26";s:16:"0---51---0---8--";s:10:"2021-04-27";s:16:"0---22---0---3--";s:10:"2021-04-28";s:16:"0---22---0---4--";s:10:"2021-04-29";s:16:"0---63---0---9--";s:10:"2021-04-30";s:16:"0---16---0---3--";s:10:"2021-05-01";s:16:"0---23---0---5--";s:10:"2021-05-02";s:16:"0---30---0---5--";s:10:"2021-05-03";s:16:"0---18---0---2--";s:10:"2021-05-04";s:16:"0---45---0---8--";s:10:"2021-05-05";s:16:"0---44---0---6--";s:10:"2021-05-06";s:16:"0---47---0---7--";s:10:"2021-05-07";s:16:"0---13---0---2--";s:10:"2021-05-08";s:16:"0---32---0---5--";s:10:"2021-05-09";s:16:"0---46---0---7--";s:10:"2021-05-10";s:16:"0---17---0---3--";s:10:"2021-05-11";s:16:"0---52---0---9--";s:10:"2021-05-12";s:16:"0---63---0---9--";s:10:"2021-05-13";s:24:"0-0-0-21-2-2-0-0-0-3-0-0";s:10:"2021-05-14";s:16:"0---13---0---2--";s:10:"2021-05-15";s:16:"0---43---0---6--";s:10:"2021-05-16";s:16:"0---60---0---9--";s:10:"2021-05-17";s:16:"0---49---0---8--";s:10:"2021-05-18";s:24:"0-0-0-26-1-3-0-0-0-3-0-0";s:8:"defaults";s:26:"301-302-135-642-1974-15.30";}';
        $data = unserialize($keydb);
        ksort($data);

        $vi = "";
        ### 16 - 22 ===> 18

        // NO USER INPUT (DONE) 16,17,18
        ## $vi = \Stats_Helper::getInstance()->calculateMontlyVisitsNumber("test-key", "", "", $data);

        // BOTH WITHIN WEEK (DONE) 16,17
        ## $vi = \Stats_Helper::getInstance()->calculateMontlyVisitsNumber("test-key", "2021/05/16","2021/05/18", $data);

        // SAME DATE (DONE) 17
        ## $vi = \Stats_Helper::getInstance()->calculateMontlyVisitsNumber("test-key", "2021/05/17","2021/05/17", $data);

        // BOTH WITHIN WEEK (DONE) 17,18
        ### $vi = \Stats_Helper::getInstance()->calculateMontlyVisitsNumber("test-key", "2021/05/17","2021/05/18", $data);

        // START OLDER  + END MIDDLE OF WEEK (DONE) 16,17
        $vi = \Stats_Helper::getInstance()->calculateMontlyVisitsNumber("test-key", "2021/04/05","2021/05/16", $data);

        // START OLDER + END FUTURE (DONE) 16,17,18,19,20,21,22
        ## $vi = \Stats_Helper::getInstance()->calculateMontlyVisitsNumber("test-key", "2021/04/16","2021/06/20", $data);

        // BOTH OLDER (DONE) - NONE
        ### $vi = \Stats_Helper::getInstance()->calculateMontlyVisitsNumber("test-key", "2021/04/05","2021/05/02", $data);


        dd($vi);
    }

}
