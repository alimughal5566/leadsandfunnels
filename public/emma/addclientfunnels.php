#!/usr/bin/php
<?php
//#!/usr/bin/php
error_reporting(255);
ini_set('memory_limit', '2024M');
ini_set('max_execution_time',300);
set_time_limit(0);
date_default_timezone_set('America/Los_Angeles');

/* connect to local leadpops */
require_once("thedb.php");
require_once("FunnelProcess.php");
FunnelProcess::getInstance()->setDb($db);
FunnelProcess::getInstance()->thissub_domain = 1;
FunnelProcess::getInstance()->thistop_domain = 2;
FunnelProcess::getInstance()->leadpoptype = 1;
FunnelProcess::getInstance()->createFunnel();