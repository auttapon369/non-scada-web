<?php
if ( isset($token) )
{
	$_temp['debug'] = array();
	$sql = "";

	foreach ($_POST['cfg'] as $key => $value) 
	{
		// get data from POST
		$id = $value['id'];

		$rf_warning = $value['data']['rf']['value']['warning'];
		$rf_danger = $value['data']['rf']['value']['danger'];

		$wl_up_warning = $value['data']['wl_up']['value']['warning'];
		$wl_up_danger = $value['data']['wl_up']['value']['danger'];

		$wl_down_warning = $value['data']['wl_down']['value']['warning'];
		$wl_down_danger = $value['data']['wl_down']['value']['danger'];

		$obj = array($id,);


		// create sql
		$sql = "";


		// debug (comment this if no use)
		$obj = array($id,$rf_warning,$rf_danger,$wl_up_warning,$wl_up_danger,$wl_down_warning,$wl_down_warning);
		array_push($_temp['debug'], $obj);
	}


	// run sql update
	/*
		code here ...
		.............
		.............
		.............
	*/


	//output sql result ( true/false )
	if ( true )
	{
		$_temp['update'] = true;
	}
	else
	{
		$_temp['update'] = false;
	}
}
?>