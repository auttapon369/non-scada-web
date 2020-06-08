<?php

$id=$_GET['id'];
$o=0;
foreach ($id as $idstn)
{
	$v="'".$idstn."'";
	if($o==0)
	{
		$idn=$v;
	} else
	{
		$idn=$idn.",".$v;
	}
	$o++;
}


$data=$_GET['data'];
$format=$_GET['format'];
if($format=='15m') {
	$timesec=900;
} elseif ($format=='1h')
{
	$timesec=3600;
} else 
{
	$timesec=86400;
}
if(strlen($_GET['date1']) > 10)
{
$date1=($_GET['date1']=="")?date("Y-m-d"):$_GET['date1'];
$date2=($_GET['date2']=="")?date("Y-m-d"):$_GET['date2'];
}
else
{
$date1=($_GET['date1']=="")?date("Y-m-d"):$_GET['date1']." 00:00";
$date2=($_GET['date2']=="")?date("Y-m-d"):$_GET['date2']." 23:45";
}
$stn_id = $sys_arr["STN_ID"];
$name = iconv('TIS-620', 'UTF-8',$sys_arr["STN_NAME_THAI"]);

if ($format=='15m') 
{
	foreach ($id as $idd) 
	{
		$v = $idd;	
		$idnn="Sum(case when STN_ID='".$v."'  then RF_15MIN  end)".$v."_RF_15MIN, Sum(case when STN_ID='".$v."'  then WL_UP  end)".$v."_WL_UP,Sum(case when STN_ID='".$v."'  then WL_DOWN  end)".$v."_WL_DOWN";
		if (count($idd)==0) 
		{	
			$column=$idnn;
		} else 
		{	
			$column=$column.",".$idnn;
		}
	}

	$dt="CONVERT(varchar(16),DT,121) DT";
	$dtt="CONVERT(varchar(16),DT,121)";
	$columns=$column;
	$dp=" AND (DATEPART(MINUTE ,DT))%15='0' ";
	$between1=$date1;
	$between2=$date2;
} elseif ($format == '1h') 
{
	foreach ($id as $idd) 
	{
		$v=$idd;	
		if ($data =='rf' )
		{
			$idnn="Sum(case when STN_ID='".$v."'  then RF_15MIN  end)".$v."_RF_15MIN, Sum(case when STN_ID='".$v."'  then WL_UP  end)".$v."_WL_UP,Sum(case when STN_ID='".$v."'  then WL_DOWN  end)".$v."_WL_DOWN";
		} else {
			$idnn="AVG(case when STN_ID='".$v."'  then RF_15MIN  end)".$v."_RF_15MIN, AVG(case when STN_ID='".$v."'  then WL_UP  end)".$v."_WL_UP,AVG(case when STN_ID='".$v."'  then WL_DOWN  end)".$v."_WL_DOWN";
		}
		if(count($idd)==0)
		{	
			$column=$idnn;
		} else 
		{	
			$column=$column.",".$idnn;
		}
	}

	$dt="CONVERT(varchar(13),DT,121) DT";
	$dtt="CONVERT(varchar(13),DT,121)";
	$dp="";
	$columns=$column;
	$between1=$date1;
	$between2=$date2;
} elseif ($format=='mean')
{
	foreach ($id as $idd) 
	{
		$v=$idd;	
		if($data=='rf')
		{
			$idnn="Sum(case when STN_ID='".$v."'  then RF_15MIN  end)".$v."_RF_15MIN, Sum(case when STN_ID='".$v."'  then WL_UP  end)".$v."_WL_UP,Sum(case when STN_ID='".$v."'  then WL_DOWN  end)".$v."_WL_DOWN";
		} else
		{
			$idnn="AVG(case when STN_ID='".$v."'  then RF_15MIN  end)".$v."_RF_15MIN, AVG(case when STN_ID='".$v."'  then WL_UP  end)".$v."_WL_UP,AVG(case when STN_ID='".$v."'  then WL_DOWN  end)".$v."_WL_DOWN";
		}
		if(count($idd)==0)
		{	
			$column=$idnn;
		}else
		{	
			$column=$column.",".$idnn;
		}
	}

	$dt="CONVERT(varchar(10),DT,121) DT";
	$dtt="CONVERT(varchar(10),DT,121)";
	$columns=$column;
	$dp="";
	$between2=$date2;
	$between1=$date1;
} elseif($format=='min')
{
	foreach ($id as $idd) 
	{
		$v=$idd;	

		$idnn="MIN(case when STN_ID='".$v."'  then RF_15MIN  end)".$v."_RF_15MIN, MIN(case when STN_ID='".$v."'  then WL_UP  end)".$v."_WL_UP,MIN(case when STN_ID='".$v."'  then WL_DOWN  end)".$v."_WL_DOWN";

		if(count($idd)==0)
		{	
			$column=$idnn;
		}else
		{	
			$column=$column.",".$idnn;
		}
	}

	$dt="CONVERT(varchar(10),DT,121) DT";
	$dtt="CONVERT(varchar(10),DT,121)";
	$columns=$column;
	$dp="";
	$between2=$date2;
	$between1=$date1;
} elseif($format=='max')
{
	foreach ($id as $idd) 
	{
		$v=$idd;	
	
		$idnn="MAX(case when STN_ID='".$v."'  then RF_15MIN  end)".$v."_RF_15MIN, MAX(case when STN_ID='".$v."'  then WL_UP  end)".$v."_WL_UP,MAX(case when STN_ID='".$v."'  then WL_DOWN  end)".$v."_WL_DOWN";
		
		if(count($idd)==0)
		{	
			$column=$idnn;
		} else
		{	
			$column=$column.",".$idnn;
		}
	}

	$dt="CONVERT(varchar(10),DT,121) DT";
	$dtt="CONVERT(varchar(10),DT,121)";
	$columns=$column;
	$dp="";
	$between2=$date2;
	$between1=$date1;
}

$sqlreal = "SELECT  ".$dt.$columns."  FROM  row_data";
$sqlreal .=" where DT BETWEEN '".$between1."'AND'".$between2."' ".$dp." GROUP BY ".$dtt."  ORDER BY DT ASC";
$res = odbc_exec($conn, $sqlreal);
//$row = odbc_fetch_array($res);

$sql="SELECT * FROM TM_STN WHERE STN_ID in (".$idn.") order by zone,LOC_ID";

$result=odbc_exec($conn,$sql);
$fetch_stn=array();
while($ss = odbc_fetch_array($result))
{
	array_push($fetch_stn,$ss);
}

$outp = array();
$lists = array();
$lists2 = array();

while($row = odbc_fetch_array($res))
{
	while(strtotime($date1) < strtotime($row['DT']))
	{

		unset($lists);
		$lists = array();
		foreach($fetch_stn as $iss)
		{
		
			//$list=array("id"=>trim($iss['STN_ID']),"value1"=>null,"value2"=>null);
			$list=array("id"=>trim($iss['STN_ID']));
			//$list=array("id"=>trim($iss['STN_ID']),"code"=>trim($iss['STN_CODE']),"name"=>trim(iconv('TIS-620', 'UTF-8',$iss["STN_NAME_THAI"])),"value1"=>null,"value2"=>null);
			array_push($lists,$list);
		}
		
		$outpp = array("date"=>$date1,"stn"=>$lists);
		array_push($outp,$outpp);
		$date1=date("Y-m-d H:i",(strtotime($date1)+$timesec));
	}
	unset($lists);
	$lists = array();
	foreach($fetch_stn as $iss1)
	{	
		$val1=$iss1['STN_ID']."_RF_15MIN";
		$val2=$iss1['STN_ID']."_WL_UP";
		$val3=$iss1['STN_ID']."_WL_DOWN";
		/*if($data=='rf')
		{
			$v1=(float)$row[$val1];
			$v2=null;
		} else
		{
			$v1=(float)$row[$val2];
			$v2=(float)$row[$val3];
		}*/

		if ($data=='rf')
		{
			$v1=is_null($row[$val1]) ? null : (float)number_format($row[$val1],1);
			$v2=null;
		} else
		{
			$v1=is_null($row[$val2]) ? null : (float)number_format($row[$val2],3);
			$v2=is_null($row[$val3]) ? null : (float)number_format($row[$val3],3);
		}
		
		//$list=array("id"=>trim($iss1['STN_ID']),"code"=>trim($iss1['STN_CODE']),"name"=>trim(iconv('TIS-620', 'UTF-8',$iss1["STN_NAME_THAI"])),"value1"=>$v1,"value2"=>$v2);
		//$list=array("id"=>trim($iss1['STN_ID']),"value1"=>$v1,"value2"=>$v2);
		$list=array("id"=>trim($iss1['STN_ID']));
		if (!is_null($v1))
		{
			$list["value1"] = $v1;
		}
		if (!is_null($v2))
		{
			$list["value2"] = $v2;
		}
		array_push($lists,$list);
	}
	
	$outpp = array("date"=>$date1,"stn"=>$lists);
	array_push($outp,$outpp);
	$date1=date("Y-m-d H:i",(strtotime($date1)+$timesec));
	
}
while(strtotime($date1) <= strtotime($date2))
{		
	unset($lists);
	$lists = array();
	foreach($fetch_stn as $iss2)
	{
		//$list=array("id"=>trim($iss2['STN_ID']),"code"=>trim($iss2['STN_CODE']),"name"=>trim(iconv('TIS-620', 'UTF-8',$iss2["STN_NAME_THAI"])),"value1"=>null,"value2"=>null);
		//$list=array("id"=>trim($iss2['STN_ID']),"value1"=>null,"value2"=>null);
		$list=array("id"=>trim($iss2['STN_ID']));
		array_push($lists,$list);
	}
	$outpp = array("date"=>$date1,"stn"=>$lists);
	array_push($outp,$outpp);
	$date1=date("Y-m-d H:i",(strtotime($date1)+$timesec));
}
$_temp['search'] = $outp;
?>