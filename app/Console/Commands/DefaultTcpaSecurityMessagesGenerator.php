<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use LP_Helper;
use App\Helpers\GlobalHelper;

class DefaultTcpaSecurityMessagesGenerator extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:default-messages';

    /**
     * The console command description.
     *
     * @var string
     */

    protected $description = 'Generate Default TCPA and Security messages for existing clients.';

    /** @var  \App\Services\DbService $db */
    private $db;

    /**
     * Create a new command instance.
     *
     * @return void
     */

    private $chunk = 100;
    private $tcpa_message_content_type = 1;
    private $security_message_content_type = 2;

    // TCPA MESSAGES
    // - DEFAULT
    private $default_tcpa_message_title = 'Default TCPA Language';
    private $default_tcpa_message_text = '<p style="text-align: center;"><span style="font-size: 11px;">I hereby consent to receive autodialed and/or pre-recorded telemarketing calls, and/or text messages, from or on behalf of <strong>[Marketer&rsquo;s Legal Name]</strong> at the telephone number provided above, including my wireless number, if applicable. I understand that consent is not a condition of purchase.</span></p>';

    // - MM
    private $mm_tcpa_message_title = 'Default TCPA Language';
    private $mm_tcpa_message_text = '<p style="text-align: center;"><span style="font-size: 11px;">I hereby consent to receive autodialed and/or pre-recorded telemarketing calls, and/or text messages, from or on behalf of <strong>[Marketer&rsquo;s Legal Name]</strong> at the telephone number provided above, including my wireless number, if applicable. I understand that consent is not a condition of purchase.</span></p>';

    // - FAIRWAY
    private $fairway_tcpa_message_title = 'Default TCPA Language';
    private $fairway_tcpa_message_text = '<p style="text-align: center;"><span style="font-size: 11px;">I hereby consent to receive autodialed and/or pre-recorded telemarketing calls, and/or text messages, from or on behalf of <strong>[Marketer&rsquo;s Legal Name]</strong> at the telephone number provided above, including my wireless number, if applicable. I understand that consent is not a condition of purchase.</span></p>';

    // - AIME
    private $aime_tcpa_message_title = 'Default TCPA Language';
    private $aime_tcpa_message_text = '<p style="text-align: center;"><span style="font-size: 11px;">I hereby consent to receive autodialed and/or pre-recorded telemarketing calls, and/or text messages, from or on behalf of <strong>[Marketer&rsquo;s Legal Name]</strong> at the telephone number provided above, including my wireless number, if applicable. I understand that consent is not a condition of purchase.</span></p>';

    // - THRVE
    private $thrive_tcpa_message_title = 'Default TCPA Language';
    private $thrive_tcpa_message_text = '<p style="text-align: center;"><span style="font-size: 11px;">I hereby consent to receive autodialed and/or pre-recorded telemarketing calls, and/or text messages, from or on behalf of <strong>[Marketer&rsquo;s Legal Name]</strong> at the telephone number provided above, including my wireless number, if applicable. I understand that consent is not a condition of purchase.</span></p>';


    // SECURITY MESSAGES
    // - DEFAULT
    private $default_security_message_title = 'Security Message';
    private $default_security_message_text = 'Privacy & Security Guaranteed';
    private $default_security_message_icon = '{"enabled":true,"icon":"ico ico-lock-2","color":"#ffa800","position":"Left Align","size":26}';
    private $default_security_message_text_style = '{"is_bold":false,"is_italic":false,"color":"#b4bbbc"}';

    // - MM
    private $mm_security_message_title = 'Security Message';
    private $mm_security_message_text = 'Privacy & Security Guaranteed'; // #ffa800  #24b928
    private $mm_security_message_icon = '{"enabled":true,"icon":"ico ico-lock-2","color":"#ffa800","position":"Left Align","size":26}';
    private $mm_security_message_text_style = '{"is_bold":false,"is_italic":false,"color":"#b4bbbc"}';

    // - FAIRWAY
    private $fairway_security_message_title = 'Security Message';
    private $fairway_security_message_text = 'Privacy & Security Guaranteed';
    private $fairway_security_message_icon = '{"enabled":true,"icon":"ico ico-lock-2","color":"#ffa800","position":"Left Align","size":26}';
    private $fairway_security_message_text_style = '{"is_bold":false,"is_italic":false,"color":"#b4bbbc"}';

    // - AIME
    private $aime_security_message_title = 'Security Message';
    private $aime_security_message_text = 'Privacy & Security Guaranteed';
    private $aime_security_message_icon = '{"enabled":true,"icon":"ico ico-lock-2","color":"#ffa800","position":"Left Align","size":26}';
    private $aime_security_message_text_style = '{"is_bold":false,"is_italic":false,"color":"#b4bbbc"}';


    // - THRIVE
    private $thrive_security_message_title = 'Security Message';
    private $thrive_security_message_text = 'Privacy & Security Guaranteed';
    private $thrive_security_message_icon = '{"enabled":true,"icon":"ico ico-lock-2","color":"#ffa800","position":"Left Align","size":26}';
    private $thrive_security_message_text_style = '{"is_bold":false,"is_italic":false,"color":"#b4bbbc"}';


    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $time_start = microtime(true);
        $funnel_builder_version_id = config("funnelbuilder.funnel_builder_version_id");
        $this->db = \App::make('App\Services\DbService');
        $clients = $this->ask("Enter client IDs range (Format: FirstId-LastId). Put same \"FirstID\" and \"LastID\" in case of single client.");
        $messageType = $this->ask("Enter Message Type \n 1 => TCPA \n 2 => Security Message \n 3 => Both \n Default => Both");
        $contentType = [1, 2];
        if ($messageType != null && is_numeric($messageType) && in_array($messageType, [1, 2, 3])) {
            switch ($messageType) {
                case 1:
                    $contentType = [1];
                    break;
                case 2:
                    $contentType = [2];
                    break;
                case 3:
                    $contentType = [1, 2];
                    break;
            }
        } elseif ($messageType == null) {
            $contentType = [1, 2];
        } elseif (!is_numeric($messageType) || !in_array($messageType, [1, 2, 3])) {
            $this->error("Message Type is invalid");
            exit;
        }


        if ($clients == "" || $clients == null) {
            $this->error("Client ID is required");
            exit;
        } else {
            $clientsRange = explode("-", $clients);
            if (count($clientsRange) == 2) {
                $startClient = $clientsRange[0];
                $lastClient = $clientsRange[1];
                if (is_numeric($startClient) && is_numeric($lastClient)) {
                    if ($startClient <= $lastClient) {

                        $sql = "SELECT clients.client_id, clients.active,clients.client_type,clients.is_mm,clients.is_fairway,clients.is_aime,clients.is_thrive,
                                clients_leadpops.id as clients_leadpops_id, clients_leadpops.leadpop_id, clients_leadpops.leadpop_version_id, clients_leadpops.leadpop_version_seq
                                FROM clients
                                INNER JOIN clients_leadpops ON clients.client_id = clients_leadpops.client_id
                               WHERE clients_leadpops.leadpop_version_id < '$funnel_builder_version_id'
                                AND clients.client_id  BETWEEN '$startClient' AND '$lastClient'";

                        $this->comment($sql);
                        $resultSet = $this->db->fetchAll($sql);

                        if (count($resultSet) == 0) {
                            $this->error("No record found");
                            exit;
                        }

                        $clientsList = collect($resultSet);
                        // generate comma separated "client Ids" to use in "WHERE IN" queries
                        $clientIds = $clientsList->pluck('client_id')->unique()->implode(',');
                        $this->comment("\n\n Client IDs: " . $clientIds);
                        // Get related records for "leadpops" table for further processing
                        $lpListCollection = GlobalHelper::createLpCollectionFromLpList($clientsList, false);
                        // Get Clients Domains records
                        $clientDomains = GlobalHelper::getClientDomains($lpListCollection, $clientIds);

                        $insertData = [];
                        foreach ($clientsList as $key => $client) {

                            $client = (object)$client;
                            $lpres = $lpListCollection->where('leadpop_id', $client->leadpop_id)->first();
                            $leadpop_type_id = $lpres['leadpop_type_id'];
                            $leadpop_template_id = $lpres['leadpop_template_id'];
                            $leadpop_version_id = $lpres['leadpop_version_id'];
                            $vertical_id = $lpres['leadpop_vertical_id'];
                            $subvertical_id = $lpres['leadpop_vertical_sub_id'];

                            $clientDomain = $this->getClientDomain($clientDomains, $client->client_id,
                                $client->leadpop_id, $leadpop_type_id,
                                $vertical_id, $subvertical_id,
                                $leadpop_template_id, $leadpop_version_id, $client->leadpop_version_seq);

                            $inserts = $this->createInsertData($contentType, $client, $clientDomain);
                            $this->comment("\n\n Insert Data: " . json_encode($inserts));
                            //   $this->comment(json_encode($inserts));
                            $insertData = array_merge($insertData, $inserts);
                        }

                        $insertDataCollection = collect($insertData);
                        $chunks = $insertDataCollection->chunk($this->chunk);
                        foreach ($chunks as $chunk) {
                            \DB::table("client_funnel_tcpa_security")->insert($chunk->toArray());
                        }

                        $time_end = microtime(true);
                        $execution_time = ($time_end - $time_start) / 60;
                        $this->comment("Total Execution Time: " . $execution_time . " Mins");
                        exit;
                    }
                }
            }
            $this->error("Client ID range format is not valid");
            exit;

        }
    }


    private function createInsertData($contentTypes, $client, $clientDomain)
    {
      //  dd($contentTypes, $client, $clientDomain);
        $insertData = [];

        $commonAttrs = [
            'client_id' => $client->client_id,
            'domain_id' => $clientDomain['clients_domain_id'],
            'leadpop_version_id' => $client->leadpop_version_id,
            'leadpop_version_seq' => $client->leadpop_version_seq,
        ];
        // Default Messages loop
        foreach ($contentTypes as $contentType) {
            $defaultMessageData = $commonAttrs;

            if ($contentType == $this->tcpa_message_content_type) { // TCPA
                $defaultMessageData['tcpa_title'] = $this->default_tcpa_message_title;
                $defaultMessageData['tcpa_text'] = $this->default_tcpa_message_text;
                $defaultMessageData['content_type'] = 1;
                $defaultMessageData['icon'] = '';
                $defaultMessageData['tcpa_text_style'] = '';

            } elseif ($contentType == $this->security_message_content_type) { // Security Message
                $defaultMessageData['tcpa_title'] = $this->default_security_message_title;
                $defaultMessageData['tcpa_text'] = $this->default_security_message_text;
                $defaultMessageData['content_type'] = 2;
                $defaultMessageData['icon'] = $this->default_security_message_icon;
                $defaultMessageData['tcpa_text_style'] = $this->default_security_message_text_style;
            }
            $insertData[] = $defaultMessageData;
        }

        // Enterprise Messages Loop
        foreach ($contentTypes as $contentType) {
            $enterpriseMessagedata = $commonAttrs;

            if ($contentType == $this->tcpa_message_content_type) { // TCPA
                $mm_tcpa_options = \DB::table('mm_tcpa_options')->where('client_id', $client->client_id)->first();
                if ($mm_tcpa_options) {
                    // if entry found in "mm_tcpa_options"
                    if ($client->client_type == 1)
                        $enterpriseMessagedata['tcpa_text'] = $mm_tcpa_options->realestate_tcpa_text;
                    elseif ($client->client_type == 3)
                        $enterpriseMessagedata['tcpa_text'] = $mm_tcpa_options->mortgage_tcpa_text;
                    else
                        $enterpriseMessagedata['tcpa_text'] = $this->default_tcpa_message_text;
                    $enterpriseMessagedata['tcpa_title'] = $this->default_tcpa_message_title;
                    $enterpriseMessagedata['content_type'] = 1;
                    $enterpriseMessagedata['icon'] = '';
                    $enterpriseMessagedata['tcpa_text_style'] = '';
                    $insertData[] = $enterpriseMessagedata;
                } else {
                   $res = $this->getTcpaMessageEnterpriseClient($client,$commonAttrs);
                   if($res)
                       $insertData[] = $res;
                }


            } elseif ($contentType == $this->security_message_content_type) { // Security Message
                $res = $this->getSecurityMessageEnterpriseClient($client,$commonAttrs);
                if($res)
                    $insertData[] = $res;
            }

        }

        return $insertData;
    }



    private function getTcpaMessageEnterpriseClient($client,$commonAttrs){
        $enterpriseMessagedata = $commonAttrs;
        if($client->is_mm){
            $enterpriseMessagedata['tcpa_text'] = $this->mm_tcpa_message_text;
            $enterpriseMessagedata['tcpa_title'] = $this->mm_tcpa_message_title;
        } elseif($client->is_fairway){
            $enterpriseMessagedata['tcpa_text'] = $this->fairway_tcpa_message_text;
            $enterpriseMessagedata['tcpa_title'] = $this->fairway_tcpa_message_title;
        } elseif($client->is_aime){
            $enterpriseMessagedata['tcpa_text'] = $this->aime_tcpa_message_text;
            $enterpriseMessagedata['tcpa_title'] = $this->aime_tcpa_message_title;
        } elseif($client->is_thrive){
            $enterpriseMessagedata['tcpa_text'] = $this->thrive_tcpa_message_text;
            $enterpriseMessagedata['tcpa_title'] = $this->thrive_tcpa_message_title;
        } else {
            return 0;
        }

        $enterpriseMessagedata['content_type'] = $this->tcpa_message_content_type;
        $enterpriseMessagedata['icon'] = '';
        $enterpriseMessagedata['tcpa_text_style'] = '';
        return $enterpriseMessagedata;

    }

    private function getSecurityMessageEnterpriseClient($client,$commonAttrs){
        $enterpriseMessagedata = $commonAttrs;
        if($client->is_mm){
            $enterpriseMessagedata['tcpa_text'] = $this->mm_security_message_text;
            $enterpriseMessagedata['tcpa_title'] = $this->mm_security_message_title;
            $enterpriseMessagedata['icon'] = $this->mm_security_message_icon;
            $enterpriseMessagedata['tcpa_text_style'] = $this->mm_security_message_text_style;
        } elseif($client->is_fairway){
            $enterpriseMessagedata['tcpa_text'] = $this->fairway_security_message_text;
            $enterpriseMessagedata['tcpa_title'] = $this->fairway_security_message_title;
            $enterpriseMessagedata['icon'] = $this->fairway_security_message_icon;
            $enterpriseMessagedata['tcpa_text_style'] = $this->fairway_security_message_text_style;
        } elseif($client->is_aime){
            $enterpriseMessagedata['tcpa_text'] = $this->aime_security_message_text;
            $enterpriseMessagedata['tcpa_title'] = $this->aime_security_message_title;
            $enterpriseMessagedata['icon'] = $this->aime_security_message_icon;
            $enterpriseMessagedata['tcpa_text_style'] = $this->aime_security_message_text_style;
        } elseif($client->is_thrive){
            $enterpriseMessagedata['tcpa_text'] = $this->thrive_security_message_text;
            $enterpriseMessagedata['tcpa_title'] = $this->thrive_security_message_title;
            $enterpriseMessagedata['icon'] = $this->thrive_security_message_icon;
            $enterpriseMessagedata['tcpa_text_style'] = $this->thrive_security_message_text_style;
        } else {
            return 0;
        }

        $enterpriseMessagedata['content_type'] = 2;

        return $enterpriseMessagedata;

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
