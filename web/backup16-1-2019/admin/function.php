<?php
$server = "127.0.0.1";
$user = "sa";
$pass = "ata+ee&c";
$db_name = "nonburi";
$dsn = "Driver={SQL Server};Server=$server;Database=$db_name";
$connection = odbc_connect($dsn, $user, $pass);

function getstn($id ,$connection)
{
	$sql = "SELECT STN_ID, STN_CODE,STN_NAME_THAI FROM [dbo].[TM_STN]  order by LOC_ID";
	$result = odbc_exec($connection,$sql);
	while($row = odbc_fetch_array($result))
	{	
		$DID = $row['STN_ID'];
		$Dname = iconv('TIS-620', 'UTF-8', $row['STN_NAME_THAI']);
		if($DID==$id){ $x = "selected"; } else { $x = ""; }
		echo "<option value=\"".$DID."\"".$x.">".$Dname."</option>";
	}
}
function date_simple($value, $type = null)
{
	if($value=="")
	{
		$x="";
	}
	else
	{
		$year = substr(substr($value, 0, 4)+543, -4);
		$month = substr($value, 5, 2);
		$day = substr($value, 8, 2);
		$time = substr($value, 11, 5);

		if ( $type == "f" )
		{
			$x = $day."/".$month."/".$year." เวลา  ".$time." น.";
		}
		else if ( $type == "t" )
		{
			$x = $time;
		}
		else
		{
			$x = $day."/".$month."/".$year;
		}
	}


	return $x;
}
function date_thai($text, $type = null)
{		
	$thai_day_arr = array("อาทิตย์","จันทร์","อังคาร","พุธ","พฤหัสบดี","ศุกร์","เสาร์");
	$thai_month_arr = array(
		"0"=>"",
		"1"=>"มกราคม",
		"2"=>"กุมภาพันธ์",
		"3"=>"มีนาคม",
		"4"=>"เมษายน",
		"5"=>"พฤษภาคม",
		"6"=>"มิถุนายน",
		"7"=>"กรกฎาคม",
		"8"=>"สิงหาคม",
		"9"=>"กันยายน",
		"10"=>"ตุลาคม",
		"11"=>"พฤศจิกายน",
		"12"=>"ธันวาคม"
	);

	$w = $thai_day_arr[date("w", $text)];  
	$d = date("j", strtotime($text));
	$m = $thai_month_arr[date("n", strtotime($text))];
	$y = date('Y', strtotime($text)) + 543;
	
	if ( empty($type) )
	{
		return $d.' '.$m.' พ.ศ. '.$y;
	}
	else
	{
		return $y;
	}
}
function get_name($id ,$connection)
{
	$sql = odbc_exec($connection,"SELECT STN_NAME_THAI FROM TM_STN WHERE STN_ID = '".$id."' ");
	$arr = odbc_fetch_array($sql);
	$name= iconv('TIS-620', 'UTF-8', $arr['STN_NAME_THAI']);

	return $name;
}
function check_value($value)
{

	if ( $value ==" ")
	{
		//$x = '<IMG SRC="../../img/ic_down.png" WIDTH="16" HEIGHT="16" ALT="ต่ำกว่าปกติ">';
		$x = "-";
	}
	else 
	{
		$x = number_format($value, 3);
	}


	return $x;
}
function check_sensor($stn,$connection)
{    
	$sqlal = "SELECT  STN_ID, STN_CODE, STN_NAME_THAI, STN_NAME_EN, LOC_ID, Check_rf, Check_wl_up, Check_wl_dw
			  FROM  TM_STN  where STN_ID='".$stn."'";
	$resal = odbc_exec($connection, $sqlal);
	$rowal = odbc_fetch_array($resal); 

	$mm[0]=$rowal['Check_rf'];
	$mm[1]=$rowal['Check_wl_up'];
	$mm[2]=$rowal['Check_wl_dw'];

	return $mm;
}
?>