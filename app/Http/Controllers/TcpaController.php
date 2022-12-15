<?php

namespace App\Http\Controllers;

use App\Constants\LP_Constants;
use App\Helpers\GlobalHelper;
use App\Helpers\Query;
use App\Models\TcpaMessage;
use App\Repositories\CustomizeRepository;
use App\Repositories\LpAdminRepository;
use App\Services\DataRegistry;
use Illuminate\Http\Request;
use LP_Helper;
use Session;

class TcpaController extends BaseController
{

    private $Default_Model_Customize;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    protected $session;
    protected $content_type = 1;

    public function __construct(LpAdminRepository $lpAdmin, CustomizeRepository $customtizeRepo)
    {
        $this->middleware(function ($request, $next) use ($lpAdmin, $customtizeRepo) {
            $this->Default_Model_Customize = $customtizeRepo;
            $this->registry = DataRegistry::getInstance();
            $this->registry->_initProperties(\Session::get('leadpops'));
            $this->init($lpAdmin);
            $this->check_session(1);
            $this->session = LP_Helper::getInstance()->getSession();
            return $next($request);
        });
    }


    protected function setCommonDataForView($hash_data, $session)
    {
        $this->data->lpkeys = $this->getLeadpopKey($hash_data);
        $this->data->client_id = $hash_data["funnel"]["client_id"];
        $this->data->funnel_url = $hash_data["funnel"]["domain_name"];
        $this->data->vertical_id = $hash_data["funnel"]["leadpop_vertical_id"];
        $this->data->subvertical_id = $hash_data["funnel"]["leadpop_vertical_sub_id"];
        $this->data->currenthash = $hash_data["current_hash"];
        $this->data->funnelData = $hash_data["funnel"];


        $customize = $this->Default_Model_Customize;
        $this->loadCtaSettings($hash_data);


        array_push($this->assets_css, LP_BASE_URL . config('view.theme_assets') . "/css/tcpa-messages.css");

        $this->data->clickedkey = $this->data->lpkeys;
        if (isset($session->clickedkey)) {
            $this->data->clickedkey = $session->clickedkey;
        }
    }

    /**
     * index
     */
    function index()
    {

        LP_Helper::getInstance()->getCurrentHashData();
        if (LP_Helper::getInstance()->getCurrentHash()) {
            $hash_data = LP_Helper::getInstance()->getFunnelData();
            $session = LP_Helper::getInstance()->getSession();
            $this->setCommonDataForView($hash_data, $session);
            $this->active_menu = LP_Constants::TCPA_MESSAGE;


            $client_id = $hash_data['client_id'];
            $leadpop_id = $hash_data['leadpop_id'];
            $leadpop_vertical_id = $hash_data['leadpop_vertical_id'];
            $leadpop_vertical_sub_id = $hash_data['leadpop_vertical_sub_id'];
            $leadpop_template_id = $hash_data['leadpop_template_id'];
            $leadpop_version_id = $hash_data['leadpop_version_id'];
            $leadpop_version_seq = $hash_data['leadpop_version_seq'];


            $clientDomain = \DB::table('clients_funnels_domains')
                ->where('client_id', $client_id)
                ->where('leadpop_id', $leadpop_id)
                ->where('leadpop_vertical_id', $leadpop_vertical_id)
                ->where('leadpop_vertical_sub_id', $leadpop_vertical_sub_id)
                ->where('leadpop_template_id', $leadpop_template_id)
                ->where('leadpop_version_id', $leadpop_version_id)
                ->where('leadpop_version_seq', $leadpop_version_seq)
                ->first();

            $clients_domain_id = $clientDomain->clients_domain_id;

            $tcpaMessages = TcpaMessage::where('client_id', $client_id)
                ->where('leadpop_version_id', $leadpop_version_id)
                ->where('leadpop_version_seq', $leadpop_version_seq)
                ->where('content_type', $this->content_type)
                ->where('domain_id', $clients_domain_id)
                ->get()->toArray();

            $this->data->tcpaMessages = $tcpaMessages ?? [];

            //  dd($tcpaMessages);

            return $this->response();
        } else {
            return $this->_redirect();
        }
    }

    function create()
    {
        LP_Helper::getInstance()->getCurrentHashData();
        if (LP_Helper::getInstance()->getCurrentHash()) {
            $hash_data = LP_Helper::getInstance()->getFunnelData();
            $session = LP_Helper::getInstance()->getSession();
            $this->setCommonDataForView($hash_data, $session);
            $this->active_menu = LP_Constants::TCPA_MESSAGE;
            //Load Question Preview
            $this->getQuestionPreviewData($hash_data, false);

            // Funnel Logo color
            $this->data->advancedfooteroptions = $this->Default_Model_Customize->getAdvancedFooteroptions($hash_data);
            return $this->response();
        } else {
            return $this->_redirect();
        }
    }


    function edit($hash, $id)
    {

        LP_Helper::getInstance()->getCurrentHashData($hash);
        if (LP_Helper::getInstance()->getCurrentHash()) {
            $hash_data = LP_Helper::getInstance()->getFunnelData();
            $session = LP_Helper::getInstance()->getSession();
            $this->setCommonDataForView($hash_data, $session);
            $this->active_menu = LP_Constants::TCPA_MESSAGE;
            $tcpaMessage = TcpaMessage::where('id', $id)->first()->toArray();
            $this->data->tcpaMessage = $tcpaMessage;

            //Load Question Preview
            $this->getQuestionPreviewData($hash_data, false);

            // Funnel Logo color
            $this->data->advancedfooteroptions = $this->Default_Model_Customize->getAdvancedFooteroptions($hash_data);
            return $this->response();
        } else {
            return $this->_redirect();
        }
    }


    public function createTcpaMessage(Request $request)
    {


        try {

            $global = false;
            $clientId = $request->input('client_id');
            $currentFunnelKey = LP_Helper::getInstance()->getFunnelKeyStringFromHash($_POST['current_hash']);
            $tcpa_title = $request->input('tcpa_title');
            $is_active = ($request->has('is_active') && $request->input('is_active') == 'on') ? 1 : 0;
            $lplist = collect([$currentFunnelKey]);
            if ($request->has('selected_funnels')) {
                $global = true;
                $lplist = explode(",", $_POST['selected_funnels']);
                $lplist = collect($lplist);
                // To ADD Source Funnel in Global QUE

                $lplist->prepend($currentFunnelKey);
                $lplist = $lplist->unique()->values()->all();
            }


            $lpListCollection = GlobalHelper::createLpCollectionFromLpList($lplist);
            $clientDomains = GlobalHelper::getClientDomains($lpListCollection, $clientId);
            $tcpaMessages = GlobalHelper::getTcpaMessages($lpListCollection, $clientId, $clientDomains, $this->content_type, $tcpa_title);
            $insertData = [];

            foreach ($lplist as $index => $lp) {
                $lpconstt = explode("~", $lp);

                $vertical_id = $lpconstt[0];
                $subvertical_id = $lpconstt[1];
                $leadpop_id = $lpconstt[2];
                $version_seq = $lpconstt[3];
                $lpres = $lpListCollection->where('leadpop_id', $leadpop_id)->first();
                $leadpop_type_id = $lpres['leadpop_type_id'];
                $leadpop_template_id = $lpres['leadpop_template_id'];
                $leadpop_version_id = $lpres['leadpop_version_id'];

                $clientDomain = $this->getClientDomain($clientDomains, $clientId,
                    $leadpop_id, $leadpop_type_id,
                    $vertical_id, $subvertical_id,
                    $leadpop_template_id, $leadpop_version_id, $version_seq);

                $alreadyExists = $tcpaMessages->where('domain_id', $clientDomain['clients_domain_id'])
                    ->where('leadpop_version_id', $leadpop_version_id)
                    ->where('tcpa_title', $tcpa_title)
                    ->where('leadpop_version_seq', $version_seq)->count();
                if ($alreadyExists) {
                    if ($global == false) {
                        return $this->errorResponse('Message is already exist.');
                    } else {
                        continue;
                    }
                }
                $insertData[] = [
                    'client_id' => $request->input('client_id'),
                    'is_active' => $is_active,
                    'is_required' => ($request->has('is_required') && $request->input('is_required') == 'on') ? 1 : 0,
                    'tcpa_title' => $request->input('tcpa_title'),
                    'domain_id' => $clientDomain['clients_domain_id'],
                    'tcpa_text' => $request->input('messageContent'),
                    'leadpop_version_id' => $leadpop_version_id,
                    'leadpop_version_seq' => $version_seq,
                ];
                // current is active, deactive remaining ones
                if ($is_active) {
                    TcpaMessage::where('domain_id', $clientDomain['clients_domain_id'])
                        ->where('client_id', $request->input('client_id'))
                        ->where('leadpop_version_id', $leadpop_version_id)
                        ->where('leadpop_version_seq', $version_seq)
                        ->update(['is_active' => 0]);
                }

            }

            TcpaMessage::insert($insertData);
            //  dd($lpListCollection, $clientDomains, $insertData);
            return $this->successResponse('TCPA message have been saved.',['url' => route('tcpaIndex',[$request->current_hash]) ]);


        } catch (\Exception $e) {
            //  return $this->errorResponse( 'Your request was not processed. Please try again.' );
            return $this->errorResponse($e->getMessage());
        }

    }


    public function editTcpaMessage(Request $request, $id)
    {
        try {
            $clientId = $request->input('client_id');
            $currentFunnelKey = LP_Helper::getInstance()->getFunnelKeyStringFromHash($_POST['current_hash']);
            // in case of single funnle
            $lplist = collect([$currentFunnelKey]);

            $tcpa_title = $request->input('tcpa_title');
            $is_active = ($request->has('is_active') && $request->input('is_active') == 'on') ? 1 : 0;
            $is_required = ($request->has('is_required') && $request->input('is_required') == 'on') ? 1 : 0;
            $tcpa_text = $request->input('messageContent');

            // global case
            if ($request->has('selected_funnels')) {
                $lplist = explode(",", $_POST['selected_funnels']);
                $lplist = collect($lplist);

                // To ADD Source Funnel in Global QUE
                $lplist->prepend($currentFunnelKey);
                $lplist = $lplist->unique()->values()->all();
            }

            // LpListCollection
            $lpListCollection = GlobalHelper::createLpCollectionFromLpList($lplist);
            $clientDomains = GlobalHelper::getClientDomains($lpListCollection, $clientId);
            $tcpaMessages = GlobalHelper::getTcpaMessages($lpListCollection, $clientId, $clientDomains, $this->content_type, $tcpa_title);
            $insertData = [];
            foreach ($lplist as $index => $lp) {
                $lpconstt = explode("~", $lp);

                $vertical_id = $lpconstt[0];
                $subvertical_id = $lpconstt[1];
                $leadpop_id = $lpconstt[2];
                $version_seq = $lpconstt[3];
                $lpres = $lpListCollection->where('leadpop_id', $leadpop_id)->first();

                $leadpop_type_id = $lpres['leadpop_type_id'];
                $leadpop_template_id = $lpres['leadpop_template_id'];
                $leadpop_version_id = $lpres['leadpop_version_id'];

                $clientDomain = $this->getClientDomain($clientDomains, $clientId,
                    $leadpop_id, $leadpop_type_id,
                    $vertical_id, $subvertical_id,
                    $leadpop_template_id, $leadpop_version_id, $version_seq);
                $domain_id = $clientDomain['clients_domain_id'];
                // in case of current funnel need to update tcpa_title
                if ($lp == $currentFunnelKey) {
                    $q = "UPDATE client_funnel_tcpa_security set " .
                        "is_active = '" . $is_active . "'," .
                        "is_required = '" . $is_required . "'," .
                        "tcpa_text = '" . addslashes($tcpa_text) . "'," .
                        "tcpa_title = '" . addslashes($tcpa_title) . "'," .
                        "date_updated = '" . date('Y-m-d H:i:s') . "'";
                    $q .= " WHERE id =  '" . $id . "'";
                    Query::execute($q, $lp);
                    // if current message is active deActive others
                    if ($is_active) {
                        $q = "UPDATE client_funnel_tcpa_security set " .
                            "is_active = '" . 0 . "'";

                        $q .= " WHERE domain_id =  '" . $domain_id . "'" .
                            " and client_Id =  '" . $clientId . "'" .
                            " and leadpop_version_id =  '" . $leadpop_version_id . "'" .
                            " and content_type =  '" . $this->content_type . "'" .
                            " and leadpop_version_seq =  '" . $version_seq . "'" .
                            " and tcpa_title !=  '" . addslashes($tcpa_title) . "'";
                        Query::execute($q, $lp);
                    }
                } else {
                    // alreadyExists will be based on tcpa_title
                    $alreadyExists = $tcpaMessages->where('domain_id', $clientDomain['clients_domain_id'])
                        ->where('leadpop_version_id', $leadpop_version_id)
                        ->where('tcpa_title', $tcpa_title)
                        ->where('leadpop_version_seq', $version_seq)->first();

                    // in case already exist need to update accordingly
                    if ($alreadyExists) {
                        // do update if following not matched
                        if ($alreadyExists['is_active'] != $is_active ||
                            $alreadyExists['is_required'] != $is_required ||
                            $alreadyExists['tcpa_text'] != $tcpa_title
                        ) {
                            $q = "UPDATE client_funnel_tcpa_security set " .
                                "is_active = '" . $is_active . "'," .
                                "is_required = '" . $is_required . "'," .
                                "tcpa_text = '" . addslashes($tcpa_text) . "'," .
                                "date_updated = '" . date('Y-m-d H:i:s') . "'";

                            $q .= " WHERE  tcpa_title = '" . addslashes($tcpa_title) . "'" .
                                " and client_Id =  '" . $clientId . "'" .
                                " and domain_id =  '" . $domain_id . "'" .
                                " and content_type =  '" . $this->content_type . "'" .
                                " and leadpop_version_id =  '" . $leadpop_version_id . "'" .
                                " and leadpop_version_seq =  '" . $version_seq . "'";
                            Query::execute($q, $lp);
                        }

                        // if not already exist need to insert
                    } else {
                        $insertData[] = [
                            'client_id' => $request->input('client_id'),
                            'is_active' => $is_active,
                            'is_required' => $is_required,
                            'tcpa_title' => $tcpa_title,
                            'domain_id' => $domain_id,
                            'tcpa_text' => $tcpa_text,
                            'leadpop_version_id' => $leadpop_version_id,
                            'leadpop_version_seq' => $version_seq,
                        ];
                    }

                    // if current message is active deActive others by tcpa_title
                    if ($is_active) {
                        $q = "UPDATE client_funnel_tcpa_security set " .
                            "is_active = '" . 0 . "'";

                        $q .= " WHERE domain_id =  '" . $domain_id . "'" .
                            " and client_Id =  '" . $clientId . "'" .
                            " and leadpop_version_id =  '" . $leadpop_version_id . "'" .
                            " and content_type =  '" . $this->content_type . "'" .
                            " and leadpop_version_seq =  '" . $version_seq . "'" .
                            " and tcpa_title !=  '" . addslashes($tcpa_title) . "'";
                        Query::execute($q, $lp);
                    }

                }

            }


            if ($insertData) {
                TcpaMessage::insert($insertData);
            }
            //  dd($lpListCollection, $clientDomains, $insertData);

            return $this->successResponse('TCPA message have been updated.');


        } catch (\Exception $e) {
            // return $this->errorResponse( 'Your request was not processed. Please try again.' );
            return $this->errorResponse($e->getMessage());
        }

    }


    public function deleteTcpaMessage(Request $request)
    {
        try {

            $currentFunnelKey = LP_Helper::getInstance()->getFunnelKeyStringFromHash($_POST['current_hash']);

            $id = $request->input('tcpa_message_id');
            $clientId = $request->input('client_id');
            $tcpaMessage = TcpaMessage::where('id', $id)->first();

            $tcpa_title = $tcpaMessage->tcpa_title;

            if ($request->has('selected_funnels')) {
                $lplist = explode(",", $_POST['selected_funnels']);
                $lplist = collect($lplist);
                // To ADD Source Funnel in Global QUE

                $lplist->prepend($currentFunnelKey);
                $lplist = $lplist->unique()->values()->all();

                // LpListCollection
                $lpListCollection = GlobalHelper::createLpCollectionFromLpList($lplist);

                $clientDomains = GlobalHelper::getClientDomains($lpListCollection, $clientId);

                $tcpaMessages = GlobalHelper::getTcpaMessages($lpListCollection, $clientId, $clientDomains, $this->content_type, $tcpa_title);

//                $tcpa_ids = implode(',', $tcpaMessages->pluck('id')->unique()->all());
                $tcpa_ids = $tcpaMessages->pluck('id')->unique()->all();

                //  dd($tcpa_ids);
                TcpaMessage::whereIn('id', $tcpa_ids)->delete();

            } else {

                TcpaMessage::where('id', $id)->delete();
            }


            return $this->successResponse('TCPA message have been deleted.');

        } catch (\Exception $e) {
            //  return $this->errorResponse( 'Your request was not processed. Please try again.' );
            return $this->errorResponse($e->getMessage());
        }
    }


    public function toggleTcpaMessage(Request $request)
    {
        try {

            $currentFunnelKey = LP_Helper::getInstance()->getFunnelKeyStringFromHash($_POST['current_hash']);

            $id = $request->input('tcpa_message_id');
            $clientId = $request->input('client_id');
            $tcpaMessage = TcpaMessage::where('id', $id)->first();

            $tcpa_title = $tcpaMessage->tcpa_title;

            if ($request->has('selected_funnels')) {
                $lplist = explode(",", $_POST['selected_funnels']);
                $lplist = collect($lplist);
                // To ADD Source Funnel in Global QUE

                $lplist->prepend($currentFunnelKey);
                $lplist = $lplist->unique()->values()->all();

                // LpListCollection
                $lpListCollection = GlobalHelper::createLpCollectionFromLpList($lplist);

                $clientDomains = GlobalHelper::getClientDomains($lpListCollection, $clientId);

                $tcpaMessages = GlobalHelper::getTcpaMessages($lpListCollection, $clientId, $clientDomains, $this->content_type, "");

//                $tcpa_ids = implode(',', $tcpaMessages->pluck('id')->unique()->all());
                $tcpa_ids = $tcpaMessages->pluck('id')->unique()->all();

//                dd($tcpa_ids);


                foreach ($lplist as $index => $lp) {
                    $lpconstt = explode("~", $lp);

                    $vertical_id = $lpconstt[0];
                    $subvertical_id = $lpconstt[1];
                    $leadpop_id = $lpconstt[2];
                    $version_seq = $lpconstt[3];

                    // Toggle Messges where title is not provided title

                    $lpres = $lpListCollection->where('leadpop_id', $leadpop_id)->first();

                    $leadpop_type_id = $lpres['leadpop_type_id'];
                    $leadpop_template_id = $lpres['leadpop_template_id'];
                    $leadpop_version_id = $lpres['leadpop_version_id'];


                    $clientDomain = $this->getClientDomain($clientDomains, $clientId,
                        $leadpop_id, $leadpop_type_id,
                        $vertical_id, $subvertical_id,
                        $leadpop_template_id, $leadpop_version_id, $version_seq);

                    $domain_id = $clientDomain['clients_domain_id'];


                    $messagesWithProvidedTcpaTitles = $tcpaMessages->where('leadpop_version_seq', $version_seq)
                        ->where('domain_id', $domain_id)
                        ->where('tcpa_title', $tcpa_title)
                        ->where('content_type', $this->content_type)
                        ->where('leadpop_version_id', $leadpop_version_id)->count();


                    if ($messagesWithProvidedTcpaTitles) {
                        // do inactive where messages exist with provided tcpa_title
                        /*TcpaMessage::where( 'tcpa_title', "!=", $tcpaMessage->tcpa_title )
                            ->where( 'leadpop_version_seq', $version_seq )
                            ->where( 'domain_id', $domain_id )
                            ->where( 'leadpop_version_id', $leadpop_version_id )
                            ->update( ['is_active' => 0] );*/


                        $q = "UPDATE client_funnel_tcpa_security set " .
                            "is_active = '" . 0 . "'";

                        $q .= " WHERE domain_id =  '" . $domain_id . "'" .
                            " and client_Id =  '" . $clientId . "'" .
                            " and leadpop_version_id =  '" . $leadpop_version_id . "'" .
                            " and leadpop_version_seq =  '" . $version_seq . "'" .
                            " and content_type =  '" . $this->content_type . "'" .
                            " and tcpa_title !=  '" . addslashes($tcpa_title) . "'";
                        Query::execute($q, $lp);
                    }

                    // Enable Messages with passed name
                    /*  TcpaMessage::where( 'tcpa_title',  $tcpaMessage->tcpa_title )
                          ->where( 'leadpop_version_seq', $version_seq )
                          ->where( 'domain_id', $domain_id )
                          ->where( 'leadpop_version_id', $leadpop_version_id )
                          ->update( ['is_active' => 1] );*/
                    $q = "UPDATE client_funnel_tcpa_security set " .
                        "is_active = '" . 1 . "'";

                    $q .= " WHERE domain_id =  '" . $domain_id . "'" .
                        " and client_Id =  '" . $clientId . "'" .
                        " and leadpop_version_id =  '" . $leadpop_version_id . "'" .
                        " and leadpop_version_seq =  '" . $version_seq . "'" .
                        " and content_type =  '" . $this->content_type . "'" .
                        " and tcpa_title =  '" . addslashes($tcpa_title) . "'";
                    Query::execute($q, $lp);
                }

            } else {
                // Disable all Messages
                TcpaMessage::where('domain_id', $tcpaMessage->domain_id)
                    ->where('client_id', $tcpaMessage->client_id)
                    ->where('leadpop_version_id', $tcpaMessage->leadpop_version_id)
                    ->where('leadpop_version_seq', $tcpaMessage->leadpop_version_seq)
                    ->where('content_type', $this->content_type)
                    ->update(['is_active' => 0]);

                // Enable passed Message id
                TcpaMessage::where('id', $id)->update([
                    'is_active' => 1
                ]);

                // where('tcpa_title', $tcpaMessage->tcpa_title)
            }

            return $this->successResponse('TCPA message have been activated.');

        } catch (\Exception $e) {
            //  return $this->errorResponse( 'Your request was not processed. Please try again.' );
            return $this->errorResponse($e->getMessage());
        }
    }


    private function getClientDomain($clientDomains, $clientId,
                                     $leadpop_id, $leadpop_type_id,
                                     $vertical_id, $subvertical_id,
                                     $leadpop_template_id, $leadpop_version_id, $version_seq)
    {


        return $clientDomains
            ->where("client_id", $clientId)
            ->where("leadpop_id", $leadpop_id)
            ->where("leadpop_type_id", $leadpop_type_id)
            ->where("leadpop_vertical_id", $vertical_id)
            ->where("leadpop_vertical_sub_id", $subvertical_id)
            ->where("leadpop_template_id", $leadpop_template_id)
            ->where("leadpop_version_id", $leadpop_version_id)
            ->where("leadpop_version_seq", $version_seq)
            ->first();

    }


}
