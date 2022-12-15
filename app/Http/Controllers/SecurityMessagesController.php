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

class SecurityMessagesController extends BaseController
{
    private $Default_Model_Customize;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    protected $session;
    protected $content_type = 2;

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
        $this->active_menu = LP_Constants::SECURITY_MESSAGE;
        $this->data->funnelData = $hash_data["funnel"];
        array_push($this->assets_css, LP_BASE_URL . config('view.theme_assets') . "/css/security-message.css");

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

            $q = "SELECT client_funnel_tcpa_security.id as security_message_id,
                     client_funnel_tcpa_security.tcpa_title as security_message_title,
                     clients_leadpops.* FROM client_funnel_tcpa_security INNER JOIN clients_leadpops
                    ON client_funnel_tcpa_security.client_id = clients_leadpops.client_id
                    AND client_funnel_tcpa_security.leadpop_version_id = clients_leadpops.leadpop_version_id
                    AND client_funnel_tcpa_security.leadpop_version_seq = clients_leadpops.leadpop_version_seq
                    WHERE client_funnel_tcpa_security.client_id = '" . $client_id . "' ";
            $q .= " AND client_funnel_tcpa_security.leadpop_version_id = '" . $leadpop_version_id . "'";
            $q .= " AND client_funnel_tcpa_security.leadpop_version_seq = '" . $leadpop_version_seq . "'";
            $q .= " AND client_funnel_tcpa_security.content_type = '" . $this->content_type . "'";
            $q .= " AND client_funnel_tcpa_security.domain_id = '" . $clients_domain_id . "'";
            $q .= " AND clients_leadpops.leadpop_id = '" . $leadpop_id . "'";

            $messages = $this->db->fetchAll($q);
            if ($messages) {
                foreach ($messages as $index => $oneMessage) {
                    $funnel_questions = json_decode($oneMessage["funnel_questions"], 1);
                    $count = 0;
                    foreach ($funnel_questions as $key => $funnel_question) {
                        // check if current iteration is an array
                        // last entry found "funneltype" rather than question array
                        if (is_array($funnel_question)) {
                            if ($funnel_question["question-type"] == "contact") {
                                /*  echo "<pre>";
                                 print_r($funnel_question["options"]);
                                  echo "</pre>";*/
                                if ($funnel_question["options"]["activesteptype"]) {
                                    $activeStepTypeIndex = $funnel_question["options"]["activesteptype"] - 1;
                                    $activeStepType = @$funnel_question["options"]["all-step-types"][$activeStepTypeIndex];
                                    if ($activeStepType && @$activeStepType["steps"])
                                        foreach ($activeStepType["steps"] as $oneStep) {
                                            if (array_key_exists("enable-security-message", @$oneStep)) {
                                                if ($oneStep["enable-security-message"] == 1 &&
                                                    $oneStep["security-message-id"] == $oneMessage["security_message_id"]
                                                ) {
                                                    $count++;
                                                    $messages[$index]["used_in_questions"] = $count;
                                                }
                                            }
                                        }
                                }
                            } else {
                                if (array_key_exists("enable-security-message", $funnel_question["options"])) {
                                    if ($funnel_question["options"]["enable-security-message"] == 1 &&
                                        $funnel_question["options"]["security-message-id"] == $oneMessage["security_message_id"]
                                    ) {

                                        $count++;
                                        $messages[$index]["used_in_questions"] = $count;

                                    }

                                }
                            }
                        }

                    }
                }
                //  dd($messages);
                $this->data->messages = $messages ?? [];
            }
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
            $message = TcpaMessage::select("id", "icon", "tcpa_title", "tcpa_text", "tcpa_text_style")
                ->where('id', $id)
                ->first()
                ->toArray();
            $this->data->message = $message;
            $this->data->backgroundSwatches = $this->getLogoColors($hash_data["funnel"]);
            // Funnel Logo color
            $this->data->advancedfooteroptions = $this->Default_Model_Customize->getAdvancedFooteroptions($hash_data);

            //Load Question Preview
            $this->getQuestionPreviewData($hash_data);

            return $this->response();
        } else {
            return $this->_redirect();
        }
    }


    public function createSecurityMessage(Request $request)
    {
        try {
            $global = false;
            $clientId = $request->input('client_id');
            $currentFunnelKey = LP_Helper::getInstance()->getFunnelKeyStringFromHash($_POST['current_hash']);
            $title = $request->input('security_message_title');
            $lplist = collect([$currentFunnelKey]);
            if ($request->has('selected_funnels')) {
                $global = true;
                $lplist = explode(",", $_POST['selected_funnels']);
                $lplist = collect($lplist);
                // To ADD Source Funnel in Global QUE
                $lplist->prepend($currentFunnelKey);
                $lplist = $lplist->unique()->values()->all();
            }

            // LpListCollection
            $lpListCollection = GlobalHelper::createLpCollectionFromLpList($lplist);
            $clientDomains = GlobalHelper::getClientDomains($lpListCollection, $clientId);
            $messages = GlobalHelper::getTcpaMessages($lpListCollection, $clientId, $clientDomains, $this->content_type, $title);
            $insertData = [];
            $currentFunnelInsert = [];
            $defaultSecurityMessage = config('lp.security_message.defaults');
            $securityMessage = [
                'client_id' => $request->input('client_id'),
                'tcpa_title' => $request->input('security_message_title') ? $title : $defaultSecurityMessage["tcpa_title"],
                'tcpa_text' => $defaultSecurityMessage["tcpa_text"],
                'content_type' => $this->content_type,
                'icon' => json_encode($defaultSecurityMessage["icon"]),
                'tcpa_text_style' => json_encode($defaultSecurityMessage["tcpa_text_style"])
            ];
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

                $alreadyExists = $messages->where('domain_id', $clientDomain['clients_domain_id'])
                    ->where('leadpop_version_id', $leadpop_version_id)
                    ->where('tcpa_title', $title)
                    ->where('leadpop_version_seq', $version_seq)->count();

                if ($index == 0) {
                    // need first funnel insert after loop
                    $currentFunnelInsert = [
                        'client_id' => $request->input('client_id'),
                        'content_type' => $this->content_type,
                        'domain_id' => $clientDomain['clients_domain_id'],
                        'leadpop_version_id' => $leadpop_version_id,
                        'leadpop_version_seq' => $version_seq
                    ];
                }

                if ($alreadyExists) {
                    if ($global == false) {
                        return $this->errorResponse('Message is already exist.');
                    } else {
                        continue;
                    }
                }

                $insertData[] = array_merge($securityMessage , [
                    'domain_id' => $clientDomain['clients_domain_id'],
                    'leadpop_version_id' => $leadpop_version_id,
                    'leadpop_version_seq' => $version_seq
                ]);
            }

            TcpaMessage::insert($insertData);
            $currentMessage = TcpaMessage::where('domain_id', $currentFunnelInsert['domain_id'])
                ->where('client_id', $currentFunnelInsert['client_id'])
                ->where('content_type', $currentFunnelInsert['content_type'])
                ->where('leadpop_version_id', $currentFunnelInsert['leadpop_version_id'])
                ->where('leadpop_version_seq', $currentFunnelInsert['leadpop_version_seq'])
                ->orderBy('id', 'desc')
                ->first()->toArray();

            $currentMessage['current_hash'] = $_POST['current_hash'];
            return $this->successResponse('Security message have been saved.', $currentMessage);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }

    public function editMessage(Request $request, $id)
    {
        try {
            $clientId = $request->input('client_id');
            $currentFunnelKey = LP_Helper::getInstance()->getFunnelKeyStringFromHash($_POST['current_hash']);
            // in case of single funnle
            $lplist = collect([$currentFunnelKey]);

            $title = $request->input('tcpa_title');
            $is_active = ($request->has('is_active') && $request->input('is_active') == 'on') ? 1 : 0;
            $is_required = ($request->has('is_required') && $request->input('is_required') == 'on') ? 1 : 0;
            $text = $request->input('tcpa_text');
            $icon = $request->input('icon');
            $tcpa_text_style = $request->input('tcpa_text_style');

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
            $messages = GlobalHelper::getTcpaMessages($lpListCollection, $clientId, $clientDomains, $this->content_type, $title);
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
                        "tcpa_text = '" . $text . "'," .
                        "tcpa_text_style = '" . $tcpa_text_style . "'," .
                        "icon = '" . $icon . "'," .
                        "date_updated = '" . date('Y-m-d H:i:s') . "'";

                    $q .= " WHERE id =  '" . $id . "'";
                    Query::execute($q, $lp);
                } else {
                    // alreadyExists will be based on tcpa_title
                    $alreadyExists = $messages->where('domain_id', $clientDomain['clients_domain_id'])
                        ->where('leadpop_version_id', $leadpop_version_id)
                        ->where('tcpa_title', $title)
                        ->where('leadpop_version_seq', $version_seq)->first();

                    // in case already exist need to update accordingly
                    if ($alreadyExists) {
                        // do update if following not matched
                        if ($alreadyExists['is_active'] != $is_active ||
                            $alreadyExists['is_required'] != $is_required ||
                            $alreadyExists['tcpa_text'] != $title
                        ) {

                            $q = "UPDATE client_funnel_tcpa_security set " .
                                "is_active = '" . $is_active . "'," .
                                "is_required = '" . $is_required . "'," .
                                "tcpa_text = '" . addslashes($text) . "'," .
                                "tcpa_text_style = '" . $tcpa_text_style . "'," .
                                //  "tcpa_title = '" . $title . "'," .
                                "icon = '" . $icon . "'," .
                                "date_updated = '" . date('Y-m-d H:i:s') . "'";

                            $q .= " WHERE  tcpa_title = '" . $title . "'" .
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
                            'tcpa_title' => $title,
                            'domain_id' => $domain_id,
                            'tcpa_text' => $text,
                            'tcpa_text_style' => $tcpa_text_style,
                            'icon' => $icon,
                            'leadpop_version_id' => $leadpop_version_id,
                            'leadpop_version_seq' => $version_seq,
                        ];
                    }
                }
            }

            if ($insertData) {
                TcpaMessage::insert($insertData);
            }

            return $this->successResponse('Security message have been updated.');
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }

    public function deleteSecurityMessage(Request $request)
    {
        try {

            $currentFunnelKey = LP_Helper::getInstance()->getFunnelKeyStringFromHash($_POST['current_hash']);

            $id = $request->input('message_id');
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
                $tcpa_ids = $tcpaMessages->pluck('id')->unique()->all();
                TcpaMessage::whereIn('id', $tcpa_ids)->delete();
            } else {
                TcpaMessage::where('id', $id)->delete();
            }
            return $this->successResponse('Security message have been deleted.');
        } catch (\Exception $e) {
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

    public function getLogoColors($funnel_data)
    {
        // \DB::enableQueryLog();
        $colors = \DB::table("leadpop_background_swatches")
            ->select('id', 'swatch')
            ->where("client_id", $funnel_data['client_id'])
            ->where("leadpop_vertical_id", $funnel_data['leadpop_vertical_id'])
            ->where("leadpop_vertical_sub_id", $funnel_data['leadpop_vertical_sub_id'])
            ->where("leadpop_type_id", $funnel_data['leadpop_type_id'])
            ->where("leadpop_template_id", $funnel_data['leadpop_template_id'])
            ->where("leadpop_id", $funnel_data['leadpop_id'])
            ->where("leadpop_version_id", $funnel_data['leadpop_version_id'])
            ->where("leadpop_version_seq", $funnel_data['leadpop_version_seq'])
            ->get();
        return json_encode($colors);
    }
}
