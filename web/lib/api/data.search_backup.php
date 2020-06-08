<?php
$server = "127.0.0.1";
$user = "sa";
$pass = "ata+ee&c";
$db_name = "nonburi";
$dsn = "Driver={SQL Server};Server=$server;Database=$db_name";
$connection = odbc_connect($dsn, $user, $pass);

///////////////////////////////////////////////////////////

$id=$_GET['id'];
//$id=array('STN1','STN2','STN3');
$o=0;
foreach ($id as $idd) {
	$v="'".$idd."'";
	if($o==0)
	{
   $idn=$v;
	}else
	{
	$idn=$idn.",".$v;
	}
   $o++;
}

$data=$_GET['data'];
$format=$_GET['format'];
if($format=='15m'){$timesec=900;}elseif($format=='1h'){$timesec=3600;}else{$timesec=86400;}
$date1=$_GET['date1'];
$date2=$_GET['date2']." 23.45";

$outp = array();

for($a=strtotime($date1);$a<=strtotime($date2); $a += $timesec)
{
$datetime=date("Y-m-d H:i",$a);
$sql="SELECT * FROM TM_STN WHERE STN_ID in (".$idn.") order by zone,LOC_ID";
$result=odbc_exec($connection,$sql);


$lists = array();
$i = 0;
while ( $sys_arr = odbc_fetch_array($result) )
{


		$stn_id = $sys_arr["STN_ID"];
		$name = iconv('TIS-620', 'UTF-8',$sys_arr["STN_NAME_THAI"]);

			if($format=='15m')
			{
			$dt="CONVERT(varchar(16),DT,121) DT";
			$dtt="CONVERT(varchar(16),DT,121)";
			$columns="Sum(case when STN_ID='".$stn_id."'  then RF_15MIN  end)RF_15MIN, Sum(case when STN_ID='".$stn_id."'  then WL_UP  end)WL_UP,Sum(case when STN_ID='".$stn_id."'  then WL_DOWN  end)WL_DOWN";
			$dp=" AND (DATEPART(MINUTE ,DT))%15='0' ";
			$between1=$datetime;
			$between2=$datetime;
			}
		elseif($format=='1h')
		{
			$dt="CONVERT(varchar(16),DT,121) DT";
			$dtt="CONVERT(varchar(16),DT,121)";
			if($data=='rf')
			{
			$columns="Sum(case when STN_ID='".$stn_id."'  then RF_15MIN  end)RF_15MIN, Sum(case when STN_ID='".$stn_id."'  then WL_UP  end)WL_UP,Sum(case when STN_ID='".$stn_id."'  then WL_DOWN  end)WL_DOWN";
			}else
			{
			$columns="AVG(case when STN_ID='".$stn_id."'  then RF_15MIN  end)RF_15MIN, AVG(case when STN_ID='".$stn_id."'  then WL_UP  end)WL_UP,AVG(case when STN_ID='".$stn_id."'  then WL_DOWN  end)WL_DOWN";
			}
		
			$dp=" AND (DATEPART(MINUTE ,DT))='00' ";
			$between1="DATEADD(minute,-59,'".$datetime."')";
			$between2=$datetime;
		}
		elseif($format=='mean')
		{
			$dt="CONVERT(varchar(16),DT,121) DT";
			$dtt="CONVERT(varchar(16),DT,121)";
			$columns="AVG(case when STN_ID='".$stn_id."'  then RF_15MIN  end)RF_15MIN, AVG(case when STN_ID='".$stn_id."'  then WL_UP  end)WL_UP,AVG(case when STN_ID='".$stn_id."'  then WL_DOWN  end)WL_DOWN";
			$dp="";
			$between2=$datetime;
			$between1="DATEADD(minute,-1439,'".$datetime."')";
		}
		elseif($format=='min')
		{
			$dt="CONVERT(varchar(16),DT,121) DT";
			$dtt="CONVERT(varchar(16),DT,121)";
			$columns="MIN(case when STN_ID='".$stn_id."'  then RF_15MIN  end)RF_15MIN, MIN(case when STN_ID='".$stn_id."'  then WL_UP  end)WL_UP,MIN(case when STN_ID='".$stn_id."'  then WL_DOWN  end)WL_DOWN";
			$dp="";
			$between2=$datetime;
			$between1="DATEADD(minute,-1439,'".$datetime."')";
		}
		elseif($format=='max')
		{
			$dt="CONVERT(varchar(16),DT,121) DT";
			$dtt="CONVERT(varchar(16),DT,121)";
			$columns="MAX(case when STN_ID='".$stn_id."'  then RF_15MIN  end)RF_15MIN, MAX(case when STN_ID='".$stn_id."'  then WL_UP  end)WL_UP,MAX(case when STN_ID='".$stn_id."'  then WL_DOWN  end)WL_DOWN";
			$dp="";
			$$between2=$datetime;
			$between1="DATEADD(minute,-1439,'".$datetime."')";
		}



		$sqlreal = "SELECT  ".$dt.", ".$columns."  FROM  row_data";
		$sqlreal .=" where STN_ID='".$stn_id."' AND DT BETWEEN '".$datetime."'AND'".$datetime."' ".$dp." GROUP BY ".$dtt."  ORDER BY DT DESC";



		$res = odbc_exec($connection, $sqlreal);
		$row = odbc_fetch_array($res);
		
		if($data=='rf'){$v1=(float)$row['RF_15MIN'];$v2=null;}else{$v1=(float)$row['WL_UP'];$v2=(float)$row['WL_DOWN'];}

		$list=array("id"=>trim($sys_arr["STN_ID"]),"code"=>trim($sys_arr["STN_CODE"]),"name"=>trim($name),"value1"=>$v1,"value2"=>$v2);
		array_push($lists,$list);
		

		
}
		
		$outpp = array("date"=>$datetime,"stn"=>$lists);
		array_push($outp,$outpp);
}
		
$_temp['search'] = $outp;


?>