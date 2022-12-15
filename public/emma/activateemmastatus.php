<?php
error_reporting(-1);
date_default_timezone_set('America/Los_Angeles');
require_once("thedb.php");

$client_id = $_POST["client_id"];

$s = "UPDATE client_emma_account set status = 1 WHERE client_id = " . $client_id;
$db->query($s);

$s = "SELECT * from client_emma_account WHERE client_id = " . $client_id . " limit 1 ";
$geaccount = $db->fetchRow($s);

if ($geaccount) {
	$text = '<h3> Client ID #' .$client_id . '</h3>';
	$text .= '<ul class="list-group"><li class="list-group-item">Account Name : '.$geaccount["account_name"].'</li>';
	$text .= '<li class="list-group-item">Status : '.$geaccount["status"].'</li>';
	$text .= '<li class="list-group-item">User Name : '.$geaccount["username"].'</li>';
	$text .= '<li class="list-group-item">Password : '.$geaccount["password"].'</li>';
	$text .= '</ul>';
	$text .= '<button class="btn btn-success" onClick="window.location.href=window.location.href"><span class="glyphicon glyphicon-refresh"></span>Refresh Page</button>';
	$text .= '<button class="btn btn-info float-right btn-success activatestatus" data-id="'.$client_id.'" onclick="activatestatus()">Active Status</button>';
	$text .=  "<a class='btn btn-info active_emma' target='_blank' href='https://settings.e2ma.net/subaccounts'>Activate Emma Subaccount</a>";
	print($text);
	return;
} else {
	$text = '<h3> The client #' .$client_id . ' does not have Emma Account</h3>';
	$text .= '<button type="button" class="btn btn-default btn-md"><span class="glyphicon glyphicon-refresh"></span> Refresh</button>';
	print($text);
	return;
}
?>