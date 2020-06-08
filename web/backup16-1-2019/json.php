<?php
//session_start();
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
require('config.php');
require(PATH_API.'class.php');
$_call = new app();
$_temp = array();
//$_temp['results'] = TXT_JSON_ER;
$_temp['results'] = TXT_JSON_SS;
$_stack = array("station", "search","report");

if ( in_array($_GET['app'], $_stack) )
{
	$_db = new sql();
	$conn = $_db->connect($cfg['conn'], 'odbc');
	
}

if ( $_SERVER['REQUEST_METHOD'] == "POST" )
{
	$token = date('YmdHis');
	if ( $_GET['app'] == "config" )
	{
		include(PATH_API.'post.config.php');
	}
	else
	{
		$_temp['results'] = TXT_JSON_ER;
	}
}
else
{
	if ( $_GET['app'] == "station" )
	{
		include(PATH_API.'data.station.php');
	}
	else if ( $_GET['app'] == "search" )
	{
		include(PATH_API.'data.search.php');
	}
	else if ( $_GET['app'] == "search-test" )
	{
		$_temp['search'] = $_call->get_search($_GET['id'], $_GET['data'], $_GET['format'], $_GET['date1'], $_GET['date2']);
	}
	else if ( $_GET['app'] == "user" )
	{
		include(PATH_API.'data.user.php');
	}	
	else if ( $_GET['app'] == "report" )
	{
		include(PATH_API.'data.report.php');
	}	
	else
	{
		$_temp['station'] = $_call->get_station();
	}
}
//echo 435345354;
//print_r($_temp);
//echo json_encode($_temp, JSON_NUMERIC_CHECK);
echo json_encode($_temp);
?>