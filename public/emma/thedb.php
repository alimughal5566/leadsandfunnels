<?php
global $db1;
$db1 = new mysqli('fca9ad8f97fc4927803a34ccb7d692e0.publb.rackspaceclouddb.com','leadpops_leadpop','DorisElaine1925', 'leadpops');

global $db;
require_once  'Zend/Db.php';
$params = array('host' => 'fca9ad8f97fc4927803a34ccb7d692e0.publb.rackspaceclouddb.com',
                'username' => 'leadpops_leadpop',
                'password' => 'DorisElaine1925',
                'dbname' => "leadpops" );

$db = Zend_Db::factory('PDO_Mysql', $params);	