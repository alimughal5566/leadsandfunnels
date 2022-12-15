<?php
namespace App\Services\gm_process;
use Exception;
use DateTime;
use Illuminate\Support\Facades\Log;
use App\Services\gm_process\ReportingConstants;

//include_once('reporting-constants.php');
/**
 * MyLeadsEvents is a gearman client class
 *
 * MyLeadsEvents is a class that has no conenction to any database instance
 * but it formats the data to submit to gearman server for sending to database instance
 *
 * @Jazib Javed: This also handles all of the reporting portal stuff
 *
 * @author   Jazib Javed
 * @version  2.0
 */
class MyLeadsEvents {
	private $gmc;

	private $work_data = "";
	private $client_id = "";

	private $update_criteria = array();
	private $dependency = array();

	/**
	 * @return MyLeadsEvents
	 */
	public static function getInstance(){
		static $instance = null;
		if ($instance === null) {
			$instance = new MyLeadsEvents();
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
     * This function will send SQL Statement to Gearman and accept one SQL at a time
     * @param string $sql_statement
     */
    function gearmanQuery($sql_statement){
	    $this->runMyLeadsClient([$sql_statement]);
    }

    function runMyLeadsClient($data){
        $this->gmc->doBackground(ReportingConstants::EVENT_MYLEADS_CLIENT, serialize($data));
    }

    function updateStatsRedis($data){
        if(env('GEARMAN_ENABLE') == "1") {
            if (env('APP_ENV') === config('app.env_production')) {
                $this->gmc->doBackground(ReportingConstants::EVENT_REDIS_STATS, serialize($data));
            }
            else if (env('APP_ENV') === config('app.env_staging')) {
                $this->gmc->doBackground(ReportingConstants::EVENT_REDIS_STATS_STAGING, serialize($data));
            }
        }
    }

    function runVarnishClient($data){
        $this->gmc->doBackground(ReportingConstants::EVENT_VARNISH, serialize($data));
    }

    function executeRackspaceCDNClient($data){
        $this->gmc->doBackground(ReportingConstants::EVENT_RACKSPACE_UPLOADER, serialize($data));
    }


    function executeRackspaceToRackspaceCopyCdnClient($data){
        $this->gmc->doBackground(ReportingConstants::EVENT_RACKSPACE_TO_RACKSPACE_COPY, serialize($data));
    }

    function updateClientLauncherInfo($data){
	    if(env('GEARMAN_ENABLE') == "1") {
            $this->gmc->doBackground(ReportingConstants::EVENT_UPDATE_CLIENT_LAUNCHER_INFO, serialize($data));
        }
    }

    function clientCloneFunnel($data){
	    //Log::debug("[Funnel Clone][".$data['client_id']."] => " . $data['funnel_name'] . " == " . $data['topdomain'].".".$data['topdomain']);
        if (env('GEARMAN_ENABLE') == "1") {
            $this->gmc->doBackground(ReportingConstants::EVENT_FUNNEL_CLONE, serialize($data));
            if ($this->gmc->returnCode() != GEARMAN_SUCCESS) {
                Log::debug("[Funnel Clone][".$data['client_id']."] => Gearman doBackground Failed");
            }
            else{
                Log::debug("[Funnel Clone][".$data['client_id']."] => Success Gearman Call");
            }
        }
        else{
            Log::debug("[Funnel Clone][".$data['client_id']."] => Gearman Call not Allowed on ".env('APP_ENV'));
        }
    }

    function colorizeBasedOnAplhaChannnel($container, $srcFile, $targetRedColor, $targetGreenColor, $targetBlueColor, $targetFile, $clientId='', $trackingKeys=''){
        $data = array(
            'container' => $container,
            'srcFile' => $srcFile,
            'targetRedColor' => $targetRedColor,
            'targetGreenColor' => $targetGreenColor,
            'targetBlueColor' => $targetBlueColor,
            'targetFile' => $targetFile,
            'clientId' => $clientId,
            'trackingKeys' => $trackingKeys
        );
        if(@$_COOKIE['debug'] == 1){
            $this->gmc->doBackground(ReportingConstants::EVENT_RACKSPACE_CREATE_FUNNEL_ICONS, serialize($data));
            if ($this->gmc->returnCode() != GEARMAN_SUCCESS) {
                \Illuminate\Support\Facades\Log::debug("[colorizeBasedOnAplhaChannnel] Gearman Failed: ");
            }
            else{
                \Illuminate\Support\Facades\Log::debug("[colorizeBasedOnAplhaChannnel] Gearman Success: ");
            }
        }
        else {
            $this->gmc->doBackground(ReportingConstants::EVENT_RACKSPACE_CREATE_FUNNEL_ICONS, serialize($data));
        }
    }

	/* ** ** ** ** ** ** ** ** ** ** ** ** ** ** **
			   REPORTING PORTAL FUNCTIONS
	 ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** */

	function setClient($client_id){
		$this->client_id = $client_id;
	}

	function getClientInfo($client_id){
        //$myleads_db = new \mysqli(ReportingConstants::MYLEADS_DB_HOST, ReportingConstants::MYLEADS_DB_USER, ReportingConstants::MYLEADS_DB_PASSWORD, ReportingConstants::MYLEADS_DB_NAME);
        $myleads_db = new \mysqli(config('database.connections.mysql.host'), config('database.connections.mysql.username'), config('database.connections.mysql.password'), config('database.connections.mysql.database'));
        $rec = $myleads_db->query("SELECT * FROM clients WHERE client_id = ".$client_id." LIMIT 1");
        $userInfo = $rec->fetch_assoc();
		return $userInfo;
	}

	/**
	 * This method makes an associative array of all parameters required to get data from a dependent table
	 *
	 * @param string $source_table - Name of dependent table in reporting instance to get data
	 * @param array $source_table_columns - Name of all columns which are required from dependent table
	 * @param array $target_table_columns - Name of all columns which we want to update in source/actual table in reporting database
	 * @param array $criteria - Key/Value pair for where clause on dependent table / source table
	 *
	 * @return array
	 */
	private function build_dependency($source_table, $source_table_columns, $target_table_columns, $criteria){
		$dependency_arr = array();
		$mapping = array_combine($source_table_columns, $target_table_columns);
		$dependency_arr[$source_table]['map_columns'] = $mapping;
		$dependency_arr[$source_table]['where'] = $criteria;
		return $dependency_arr;
	}

	/**
	 * This method converts data into postable format to gearman server
	 *
	 * @param array $data - data in Key/Value pair format to update in table
	 * @param string $entity - Name of table to insert/update data in reporting database
	 * @param int $client_id - client id
	 * @param array $update_rec - Key/Value pair for where clause on table
	 * @param array $dependency - Associative array to get data from any dependent table
	 *
	 * @return void
	 */
	private function setData($data, $entity, $client_id=0){
		try{
			if (!is_array($data)){
				throw new Exception("Invalid data format.");
			}
			elseif (!$entity){
				throw new Exception("Entity not provided.");
			}
			elseif (!is_array($this->update_criteria)){
				throw new Exception("Invalid update criteria input format.");
			}
			else{
				$gmc_data = unserialize($this->work_data);

				$gmc_data['meta']['client_id'] = $client_id;
				$gmc_data[$entity]['data'] = $data;
				if(!empty($this->update_criteria)){
					$gmc_data[$entity]['update'] = $this->update_criteria;
				}
				if(!empty($this->dependency)){
					$gmc_data[$entity]['data_dependency'] = $this->dependency;
					$this->dependency = array();
				}
				$this->work_data = serialize($gmc_data);
			}
		}
		catch (Exception $ex){
			trigger_error($ex->getMessage(), E_USER_ERROR);
		}
	}

    /**
     * when pause and cancellation client account then website account isactive
     * @param $data
     * @author mzac90
     */
    function websiteClientAccountInactive($data){
        $this->gmc->doBackground(ReportingConstants::EVENT_WEBSITE_ACCOUNT_INACTIVE, serialize($data));
	}

	function createScreenshot($data){
        /**
         * $data["url"] = ""
         */
        $this->gmc->doBackground(ReportingConstants::EVENT_SCREENSHOT, serialize($data));
    }

    /**
     * create custom funnel event for call the gearman worker
     * @param $data
     */
    function createCustomFunnel($data){
        if (env('GEARMAN_ENABLE') == "1") {
            $this->gmc->doBackground(ReportingConstants::EVENT_CREATE_CUSTOM_FUNNEL, serialize($data));
            if ($this->gmc->returnCode() != GEARMAN_SUCCESS) {
                Log::debug("[Create Custom Funnel][".$data['client_id']."] => Gearman doBackground Failed");
            }
            else{
                Log::debug("[Create Custom Funnel][".$data['client_id']."] => Success Gearman Call");
            }
        }
        else{
            Log::debug("[Create Custom Funnel][".$data['client_id']."] => Gearman Call not Allowed on ".env('APP_ENV'));
        }
    }
}

/**
 * ReportSqlHelper is an helping class to make the required SQL statements as string.
 *
 * Purpose of this class to keep the all SQLs involved into reporting into a centeralized class
 * so implementation on verious project will be just calling required functions
 *
 * @author   Jazib Javed
 * @version  1.0
 */
class ReportSqlHelper{
	public static function Instance(){
		static $ins = null;
		if ($ins === null) {
			$ins = new ReportSqlHelper();
		}
		return $ins;
	}

	function funnels($client_id, $clients_leadpops_id=''){
		$sql = "SELECT CONCAT(clients_funnels_domains.subdomain_name,'.',clients_funnels_domains.top_level_domain) AS funnel, clients_leadpops.funnel_market, IF(clients_leadpops.leadpop_active=1,0,1) AS is_deleted, leadpops_verticals.vertical_label AS funnel_type, 0 AS has_stickybar, clients_leadpops.id AS client_leadpop_id, clients_funnels_domains.clients_domain_id AS source_domain_id ";
		$sql .= " FROM clients_funnels_domains ";
		$sql .= " INNER JOIN clients_leadpops ON clients_leadpops.client_id = clients_funnels_domains.client_id";
		$sql .= " AND clients_leadpops.leadpop_id = clients_funnels_domains.leadpop_id";
		$sql .= " AND clients_leadpops.leadpop_version_id = clients_funnels_domains.leadpop_version_id";
		$sql .= " AND clients_leadpops.leadpop_version_seq = clients_funnels_domains.leadpop_version_seq";
		$sql .= " INNER JOIN leadpops ON leadpops.id = clients_leadpops.leadpop_id";
		$sql .= " INNER JOIN leadpops_verticals ON leadpops_verticals.id = leadpops.leadpop_vertical_id";
		$sql .= " WHERE clients_funnels_domains.client_id = ".$client_id;
		if($clients_leadpops_id){
			$sql .= " AND clients_leadpops.id = ".$clients_leadpops_id;
		}
		$sql .= " GROUP BY funnel ";

		return $sql;
	}

	function get_client_leadpop_ids($client_id, $clients_leadpops_id=array(), $include_ids=true){
		$sql = "SELECT CONCAT(clients_funnels_domains.subdomain_name,'.',clients_funnels_domains.top_level_domain) AS funnel, clients_leadpops.funnel_market, IF(clients_leadpops.leadpop_active=1,0,1) AS is_deleted, leadpops_verticals.vertical_label AS funnel_type, 0 AS has_stickybar, clients_leadpops.id AS client_leadpop_id, clients_funnels_domains.clients_domain_id AS source_domain_id ";
		$sql .= " FROM clients_funnels_domains";
		$sql .= " INNER JOIN clients_leadpops ON clients_leadpops.client_id = clients_funnels_domains.client_id";
		$sql .= " AND clients_leadpops.leadpop_id = clients_funnels_domains.leadpop_id";
		$sql .= " AND clients_leadpops.leadpop_version_id = clients_funnels_domains.leadpop_version_id";
		$sql .= " AND clients_leadpops.leadpop_version_seq = clients_funnels_domains.leadpop_version_seq";
		$sql .= " INNER JOIN leadpops ON leadpops.id = clients_leadpops.leadpop_id";
		$sql .= " INNER JOIN leadpops_verticals ON leadpops_verticals.id = leadpops.leadpop_vertical_id";
		$sql .= " WHERE clients_funnels_domains.client_id = ".$client_id;
		if(!empty($clients_leadpops_id)){
			if($include_ids){
				$sql .= " AND clients_leadpops.id IN (".implode(",",$clients_leadpops_id).")";
			} else {
				$sql .= " AND clients_leadpops.id NOT IN (".implode(",",$clients_leadpops_id).")";
			}
		}
		$sql .= " GROUP BY funnel ";

		return $sql;
	}



	function stickyBars($client_id, $clients_leadpops_id){
		$sql = "SELECT COUNT(sticky_url) AS has_stickybar, GROUP_CONCAT(sticky_url) AS sticky_url FROM client_funnel_sticky ";
		$sql .= " WHERE client_id = $client_id AND clients_leadpops_id = $clients_leadpops_id";

		return $sql;
	}

	function reportingPortal__deleteFunnels($domain_id){
		$now = new \DateTime();
		$sql = "UPDATE funnels SET is_deleted = 1, update_date = '".$now->format('Y-m-d H:i:s')."'  WHERE source_domain_id = ".$domain_id;
		return $sql;
	}

	function getClientInfo($client_id){
		$sql = "SELECT is_mm, is_fairway FROM clients WHERE client_id = " . $client_id . " LIMIT 1 ";
		return $sql;
	}
}
