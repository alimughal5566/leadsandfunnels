<?php
/**
 * ReportingConstants defines all of the constants
 *
 * @author   Jazib Javed
 * @version  1.0
 */
namespace App\Services\gm_process;
abstract class ReportingConstants {
	const GM_SERVER_HOST = "10.183.250.92";
	const GM_SERVER_PORT = 4730;

	/* Status Values for `tmp_import_lock` column */
	const IMPORT_HIDE = 0;          // This is for internal working to hide rows for system users like admin / leadpops
	const IMPORT_DISABLE = 3;       // Removed from Spreadsheet
	const IMPORT_LOCK = 1;          // Disables Update for row
	const IMPORT_UNLOCK = 2;        // Enables Update for row

	# Infusionsoft TAG IDs
	const TAG_ID_MOVEMENT = 2273;
	const TAG_ID_FAIREAY = 2279;
	const TAG_PRESIDENT_CLUB = 2390;
	const TAG_PAYROLL_DEDUCT = 2304;

	/* Status Labels in infusionsoft */
	const LIVE = "Live";
	const IN_PROCESS = "In Process";
	const CANCEL = "Cancel";
	const DISABLE = "Disabled";
	const NOT_WEB_CLIENT = "Not a Website Client";

	/* Status Values for `ifs_status` column */
	const IFS_LIVE = 1;
	const IFS_IN_PROCESS = 2;
	const IFS_CANCEL = 3;
	const IFS_DISABLE = 0;
	const IFS_NOT_WEBSITE_CLIENT = -1;

	/* Status Values for `acc_status` column */
	const MY_LEADS_NOT_EXIST = 0;
	const MY_LEADS_EXIST = 1;

	/* Status Values for `active` column */
	const ACC_NO_STATE = -1;            // Data imported from source-db in system setup but not uploaded from spreadsheet
	const ACC_DISABLED = 0;             // Account is deleted from spreadhseet
	const ACC_REGISTER_COMPLETE = 1;    // User signup on reporting portal
	const ACC_NOT_REGISTER = 2;         // User not signed up yet on reporting portal

    const EVENT_MYLEADS_CLIENT = "mysql_sql_worker";
    const EVENT_VARNISH = "varnish_worker";
	const EVENT_IFS_UPDATE = "infusionsoft_update_record";
    const EVENT_IFS_LOGIN_TRACKING = "infusionsoft_login_tracking";
    const EVENT_HUBSPOT_UPDATE = "hubspot_update_record";
    const EVENT_HUBSPOT_LOGIN_TRACKING = "hubspot_login_tracking";

	const EVENT_REDIS_STATS = "redis_stats_worker";
	const EVENT_REDIS_STATS_STAGING = "redis_stats_worker_staging";

	/* Table names in reporting instance */
	const REPOTING_TBL_USERS = "users";
	const REPOTING_TBL_FUNNELS = "funnels";
	const REPOTING_TBL_STATS = "statistics";
	const REPOTING_TBL_ROLES = "roles";
	const REPOTING_TBL_USER_ROLES = "role_user";

    const EVENT_RACKSPACE_UPLOADER = "rackspace_cdn";
    const EVENT_RACKSPACE_TO_RACKSPACE_COPY = "rackspace_to_rackspace_cdn_copy";
    const EVENT_RACKSPACE_CREATE_FUNNEL_ICONS = "rackspace_create_funnel_icons";

    const EVENT_WEBSITE_ACCOUNT_INACTIVE = "website_account_inactive";
    const GM_STAGING_SERVER_HOST = "127.0.0.1";

    const EVENT_UPDATE_CLIENT_LAUNCHER_INFO  = 'update_client_launcher_info';
	const EVENT_FUNNEL_CLONE  = 'client_clone_funnel';

	const EVENT_SCREENSHOT  = 'screenshot_service_worker';
    const EVENT_CREATE_CUSTOM_FUNNEL  = 'create_custom_funnel';

    const EVENT_UPDATE_CLIENT_CONDITIONAL_LOGIC_DATA  = 'update_client_conditional_logic_data';
}
