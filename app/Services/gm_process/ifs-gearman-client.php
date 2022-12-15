<?php
/**
 * InfusionsoftGearmanClient is a gearman client class
 *
 * @author   Jazib Javed
 * @version  1.0
 */
namespace App\Services\gm_process;
class InfusionsoftGearmanClient {
	private $gmc;

	/**
	 * @return InfusionsoftGearmanClient
	 */
	public static function getInstance(){
		static $instance = null;
		if ($instance === null) {
			$instance = new InfusionsoftGearmanClient();
		}
		return $instance;
	}

    private function __construct(){
	    $this->gmc = new \GearmanClient();
	    #$this->gmc->addServer(ReportingConstants::GM_SERVER_HOST,ReportingConstants::GM_SERVER_PORT);
	    $this->gmc->addServer(config('app.gearman_server'), config('app.gearman_port'));
    }


    function updateContact($data, $email){
    	$job_data = array();
    	$job_data['data'] = $data;
    	$job_data['email'] = $email;

        $this->gmc->doBackground(ReportingConstants::EVENT_HUBSPOT_UPDATE, serialize($job_data));
        if ($this->gmc->returnCode() != GEARMAN_SUCCESS) {
            \Illuminate\Support\Facades\Log::debug("[Survey Form] Gearman Failed: ".$email);
        }
        else{
            \Illuminate\Support\Facades\Log::debug("[Survey Form] Gearman Success: ".$email);
        }
    }

    function updateLoginReport($data){
	    $this->gmc->doBackground(ReportingConstants::EVENT_HUBSPOT_LOGIN_TRACKING, serialize($data));
    }

}
