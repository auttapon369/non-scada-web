<?php

if ( isset($token) )
{
	$_temp['debug'] = array();
	//$sql = "";
	$er = 0;
	$sql="";
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

		//$obj = array($id,);

		$sql .= "UPDATE nonburi.dbo.TM_Alarm SET value = '".trim($rf_warning)."' where STN_ID = '".$id."' and Sensor_Type = '100' and Level_alarm = '1';";
		$sql .= " UPDATE nonburi.dbo.TM_Alarm SET value = '".trim($rf_danger)."' where STN_ID = '".$id."' and Sensor_Type = '100' and Level_alarm = '2';";
		$sql .= " UPDATE nonburi.dbo.TM_Alarm SET value = '".trim($wl_up_warning)."' where STN_ID = '".$id."' and Sensor_Type = '200' and Level_alarm = '1';";
		$sql .= " UPDATE nonburi.dbo.TM_Alarm SET value = '".trim($wl_up_danger)."' where STN_ID = '".$id."' and Sensor_Type = '200' and Level_alarm = '2';";
		$sql .= " UPDATE nonburi.dbo.TM_Alarm SET value = '".trim($wl_down_warning)."' where STN_ID = '".$id."' and Sensor_Type = '201' and Level_alarm = '1';";
		$sql .= " UPDATE nonburi.dbo.TM_Alarm SET value = '".trim($wl_down_danger)."' where STN_ID = '".$id."' and Sensor_Type = '201' and Level_alarm = '2';";
		$sql .= " UPDATE nonburi.dbo.stn_real SET rf_warning = '".trim($rf_warning)."',rf_danger = '".trim($rf_danger)."',wlu_warning = '".trim($wl_up_warning)."',wlu_danger = '".trim($wl_up_danger)."',wld_warning = '".trim($wl_down_warning)."',wld_danger = '".trim($wl_down_danger)."' WHERE stn_id = '".$id."';";

		
		// debug (comment this if no use)
		//$obj = array($id,$rf_warning,$rf_danger,$wl_up_warning,$wl_up_danger,$wl_down_warning,$wl_down_warning);
		//$obj = $sql;
		//array_push($_temp['debug'], $obj);
	
	}

	$res = odbc_exec($conn,$sql);
		if ( !$res )
		{
			$er = $er + 1;
			array_push($_temp['debug'],$id." ".odbc_errormsg($conn));
		}
	//output sql result ( true/false )
	if ( $er > 0 )
	{
		$_temp['update'] = $er;
	}
	else
	{
		$_temp['update'] = true;
	}
}

?>