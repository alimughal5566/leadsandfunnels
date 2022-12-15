<?php
namespace App\Services\gm_process;
use Illuminate\Support\Facades\Log;
/**
 * ConditionalLogicEvents is a gearman client class
 *
 * ConditionalLogicEvents is a class that has no conenction to any database instance
 * but it formats the data to submit to gearman server for sending to database instance
 *
 * @Zainlp: This also handles all of the reporting portal stuff
 *
 * @author   Zainlp
 * @version  2.0
 */
class ConditionalLogicEvents {
    private $gmc;

    /**
     * @return ConditionalLogicEvents
     */
    public static function getInstance(){
        static $instance = null;
        if ($instance === null) {
            $instance = new ConditionalLogicEvents();
        }
        return $instance;
    }

    private function __construct(){
        if (env('GEARMAN_ENABLE') == "1") {
            $this->gmc = new \GearmanClient();

            $this->gmc->addServer(config('app.gearman_server'), config('app.gearman_port'));
        }
    }
    /**
     * This is temporary function which will communicate with gearman to upgrade JSON structure for conditions in funnel
     *
     * @param $data
     * @return void
     */
    function conditionalLogicUpdateMapData($data){
        $this->gmc->doBackground('upgrade-question-conditions-data', serialize($data));
        if ($this->gmc->returnCode() != GEARMAN_SUCCESS) {
            Log::channel('temp-log')->error("[Client Update Conditional Logic Data][".$data['clientid']."] => Gearman doBackground Failed");
        }
        else{
            Log::channel('temp-log')->info("[Client Update Conditional Logic Data][".$data['clientid']."] => Success Gearman Call");
        }
    }
}


