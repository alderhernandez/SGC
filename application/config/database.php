<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$active_group = 'default';
$query_builder = TRUE;

$db['default'] = array(
	'dsn'	=> '',
    'hostname' => '192.168.1.9',
	//'hostname' => '192.168.1.203',
	'username' => 'sa',
    //'password' => '123',
	'password' => 'Delmor2k18!',
	'database' => 'SGC',
	'dbdriver' => 'sqlsrv',
	'dbprefix' => '',
	'pconnect' => FALSE,
	'db_debug' => (ENVIRONMENT !== 'production'),
	'cache_on' => FALSE,
	'cachedir' => '',
	'char_set' => 'utf8',
	'dbcollat' => 'utf8_general_ci',
	'swap_pre' => '',
	'encrypt' => FALSE,
	'compress' => FALSE,
	'stricton' => FALSE,
	'failover' => array(),
	'save_queries' => TRUE
);


$db['dbpayroll'] = array(
	'dsn'	=> '',
	'hostname' => '192.168.1.5',//'192.168.1.5',
	'username' => 'ICGAdmin',
	'password' => 'masterkey',
	'database' => 'SCG_PayrollOne_Delmor',
	'dbdriver' => 'sqlsrv',
	'dbprefix' => '',
	'pconnect' => FALSE,
	'db_debug' => (ENVIRONMENT !== 'production'),
	'cache_on' => FALSE,
	'cachedir' => '',
	'char_set' => 'utf8',
	'dbcollat' => 'utf8_general_ci',
	'swap_pre' => '',
	'encrypt' => FALSE,
	'compress' => FALSE,
	'stricton' => FALSE,
	'failover' => array(),
	'save_queries' => TRUE
);
