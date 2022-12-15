<?php

namespace App\Http\Controllers;

use App\Constants\FunnelVariables;
use App\Constants\Layout_Partials;
use App\Constants\LP_Constants;
use App\Repositories\CustomizeRepository;
use App\Repositories\LeadpopsRepository;
use App\Repositories\LpAccountRepository;
use App\Repositories\LpAdminRepository;
use App\Services\DataRegistry;
use Illuminate\Http\Request;
use LP_Helper;
use Session;

class TagController extends BaseController {


    /**
     * Create a new controller instance.
     *
     * @return void
     */
    protected $session;
    private $Default_Model_Customize;
    public function __construct(LpAdminRepository $lpAdmin, CustomizeRepository $customtizeRepo){
        $this->middleware(function($request, $next) use ($lpAdmin,$customtizeRepo) {
            $this->Default_Model_Customize = $customtizeRepo;
            $this->registry = DataRegistry::getInstance();
            $this->registry->_initProperties(\Session::get('leadpops'));
            $this->init($lpAdmin);
            if($request->ajax()) $this->check_ajax_session(); else $this->check_session(1);
            $this->session=LP_Helper::getInstance()->getSession();
            return $next($request);
        });
    }

    /**
     * load tag and folder blade
     */
    function index(){
        LP_Helper::getInstance()->getCurrentHashData();
        if(LP_Helper::getInstance()->getCurrentHash()){
            $funnel_data = LP_Helper::getInstance()->getFunnelData();
            $this->active_menu = LP_Constants::TAG;
            $this->data->funnelData['hash'] = $funnel_data['funnel']['hash'];
            $this->data->funnelData['funnel_name'] = $funnel_data['funnel']['funnel_name'];
            $this->data->funnelData['leadpop_folder_id'] = $funnel_data['funnel']['leadpop_folder_id'];
            $rec = funnel_tag_list($funnel_data['client_leadpop_id']);
            $arr = array();
            foreach($rec as $vl){
             $arr[] = $vl->leadpop_tag_id;
            }
            $this->data->funnelData['funnelTag'] = json_encode($arr);
            $this->data->lpkeys = $this->getLeadpopKey($funnel_data);
            $this->data->clickedkey = @$this->registry->leadpops->clickedkey;
            $this->popup = 'folder-popup';
            return $this->response();
        }else{
            return $this->_redirect();
        }
    }

    /**
     * save folder client wise
     * @param Request $request
     */
    function addfolder(Request $request){
        if( $this->registry->leadpops->client_id) {
            LP_Helper::getInstance()->getCurrentHashData($request->input('hash'));
            if (LP_Helper::getInstance()->getCurrentHash()) {
                $folder_name = str_replace('\\', '',$request->input('folder_name'));
                $table = 'leadpops_client_folders';
                $arr = array(
                    'folder_name' => htmlentities($folder_name,ENT_QUOTES),
                    'client_id' => $this->registry->leadpops->client_id,
                    'is_default' => $request->input('is_default')
                );
                if(getenv('APP_THEME') == 'theme_admin3'){
                    if($request->has('folder_ids') and $request->input('folder_ids') != null){
                        foreach ($request->input('folder_ids') as $k => $v) {
                            $this->db->update('leadpops_client_folders', array('order' => $k), "id = " . $v);
                        }
                    }
                    if($request->has('order') and $request->input('order') != null and $request->input('id') == 0) {
                        $new_arr = array(
                            'order' => $request->input('order')
                        );
                        $arr = array_merge($arr,$new_arr);
                    }
                }
                if ($request->input('id')) {
                    $this->db->update($table, $arr, "id = " . $request->input('id'));
                    $status = 'updated';
                } else {
                    $this->db->insert($table, $arr);
                    $status = 'added';
                }
                update_clients_leadpops_last_eidt();
                $res = folder_list();
                $hasWebsite = count(dashboardEmptyFolderSkip('w'));

                echo json_encode(array('response' => $status, 'html' => json_encode($res),'hasWebsite' => $hasWebsite));
            }else{
                echo json_encode(array('response' => 'error'));
            }

        }else{
            echo json_encode(array('response' => 'logout'));
        }
    }

    /**
     * save tags client wise
     * @param Request $request
     */
    function addtag(Request $request){
        if( $this->registry->leadpops->client_id) {
            LP_Helper::getInstance()->getCurrentHashData($request->input('hash'));
            if (LP_Helper::getInstance()->getCurrentHash()) {
                $tag_name = str_replace('\\', '',$request->input('tag_name'));
                $table = 'leadpops_tags';
                $arr = array(
                    'tag_name' => htmlentities($tag_name,ENT_QUOTES),
                    'client_id' => $this->registry->leadpops->client_id,
                    'is_default' => $request->input('is_default')
                );
                if ($request->input('id')) {
                    $this->db->update($table, $arr, "id = " . $request->input('id'));
                    $status = 'updated';
                } else {
                    $this->db->insert($table, $arr);
                    $status = 'added';
                }
                update_clients_leadpops_last_eidt();
                $res = tag_list();
                echo json_encode(array('response' => $status, 'html' => json_encode($res)));
            }else{
                echo json_encode(array('response' => 'error'));
            }
        }else{
            echo json_encode(array('response' => 'logout'));
        }
    }

    /**
     * save folder sorting
     * @param Request $request
     */
    function savesorting(Request $request){
        $res = array();
        if ($this->registry->leadpops->client_id) {
        LP_Helper::getInstance()->getCurrentHashData($request->input('hash'));
        if (LP_Helper::getInstance()->getCurrentHash()) {
                $funnel_data = LP_Helper::getInstance()->getFunnelData();
                $id = $funnel_data['client_leadpop_id'];
                if ($request->input('folder_ids')) {
                    foreach ($request->input('folder_ids') as $k => $v) {
                        $this->db->update('leadpops_client_folders', array('order' => $k), "id = " . $v);
                    }
                    $res = folder_list();
                    $status = 'updated';
                } else {
                    $status = 'updated';
                }
                update_clients_leadpops_last_eidt($id);
                echo json_encode(array('response' => $status, 'html' => json_encode($res)));
                }
                else{
                    echo json_encode(array('response' => 'error'));
                }
            } else {
            echo json_encode(array('response' => 'logout'));
        }
    }

    /**
     * save funnel when change the tag , folder and funnel name
     * @param Request $request
     * @throws \Exception
     */
    function savefunneltag(Request $request){
        if( $this->registry->leadpops->client_id) {
            $data = [];
            LP_Helper::getInstance()->getCurrentHashData($request->input('hash'));
            if (LP_Helper::getInstance()->getCurrentHash()) {
                $funnel_data = LP_Helper::getInstance()->getFunnelData();
                $old_funnel_name = htmlentities(str_replace('\\', '',$request->input('old_funnel_name')),ENT_QUOTES);
                $funnel_name = htmlentities(str_replace('\\', '',$request->input('funnel_name')),ENT_QUOTES);
                if ($funnel_name) {
                    if (strtolower($funnel_name) != strtolower($old_funnel_name)) {
                        $rs = checkFunnelName($funnel_data['client_leadpop_id'], $funnel_name);
                        if($rs){
                            return $this->warningResponse("That name is already being used by another Funnel in your Admin. Try something else.");
                        }else{
                            $data = $this->saveRecord($request,$funnel_data);
                        }
                    }else{
                        $data = $this->saveRecord($request,$funnel_data);
                    }

                    $selectedTags = collect(getFunnelSelectedTags($this->registry->leadpops->client_id, $funnel_data['client_leadpop_id']));
                    $data["_tags"] = $selectedTags->pluck("leadpop_tag_id");

                    update_clients_leadpops_last_eidt();
                }else{
                    return $this->errorResponse('Please enter your funnel name.');
                }
            }else{
                return $this->errorResponse('Something went wrong. Please try again.');
            }
            return $this->successResponse('The changes have been made.', $data);
        }
    }

    /**
     * tag and folder remove
     * @param Request $request
     * @throws \Exception
     */
    function delete(Request $request){
        if( $this->registry->leadpops->client_id) {
            LP_Helper::getInstance()->getCurrentHashData($request->input('hash'));
            if (LP_Helper::getInstance()->getCurrentHash()) {
                if ($request->input('table') == 'folder') {
                    $tb = 'leadpops_client_folders';
                } else {
                    $tb = 'leadpops_tags';
                }
                $s = "DELETE FROM $tb WHERE id =" . $request->input('id');
                $this->db->query($s);
                $r = $request->input('table').'_list';
                if ($request->input('table') == 'folder') {
                    $res = folder_list();
                } else {
                    $res = tag_list();
                }
                update_clients_leadpops_last_eidt();
                echo json_encode(array('response' => 'deleted', 'html' => json_encode($res)));
            }else{
                echo json_encode(array('response' => 'error'));
            }
        }else{
            echo json_encode(array('response' => 'logout'));
        }
    }

    /**
     * save folder and funnel name
     * @param $request
     * @param $funnel_data
     * @throws \Exception
     */
    function saveRecord($request, $funnel_data)
    {
        $funnel_name = str_replace('\\', '', $request->input('funnel_name'));
        $tags = $request->input('tag_list');
        $leadpop_folder_id = $request->input('folder_list');
        if ($leadpop_folder_id != 0) {
            $this->db->update('clients_leadpops',
                array('leadpop_folder_id' => $leadpop_folder_id,
                    'funnel_name' => htmlentities($funnel_name, ENT_QUOTES, "UTF-8")),
                'client_id = ' . $this->registry->leadpops->client_id . '
                           AND id = ' . $funnel_data['client_leadpop_id']);
        }
        $s = "DELETE FROM leadpops_client_tags WHERE client_id = " . $this->registry->leadpops->client_id . "
                    AND client_leadpop_id = " . $funnel_data['client_leadpop_id'];
        $this->db->query($s);

        $addedTags = [];
        if ($tags) {
            foreach ($tags as $k => $v) {
                if (strpos($v, 'new_') !== false) {
                    $tag = str_replace('new_', '', $v);
                    $v = customTagSave($tag);
                    $addedTags[$v] = $tag;
                }
                $this->db->insert('leadpops_client_tags', array('leadpop_tag_id' => $v,
                    'client_id' => $this->registry->leadpops->client_id,
                    'client_leadpop_id' => $funnel_data['client_leadpop_id']));
            }
        }
        update_clients_leadpops_last_eidt();
        return ["_new_tags"=>$addedTags];
    }
}
