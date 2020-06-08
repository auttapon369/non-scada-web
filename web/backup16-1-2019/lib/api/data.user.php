<?php
///////////////////////////////////////////////////////////
// $dsn = "Driver={SQL Server};Server=192.168.99.2;Database=nonburi";
			// $conn = odbc_connect($dsn, 'sa', 'ata+ee&c');
$sql="SELECT * FROM TM_STN order by zone,LOC_ID";
$result=odbc_exec($conn,$sql);


$outp = array();
$i = 0;
while ( $sys_arr = odbc_fetch_array($result) )
{
		$stn_id = $sys_arr["STN_ID"];
		$name = $sys_arr["STN_NAME_THAI"];
var_dump($name);
		$sqlreal = "SELECT TOP 1 STN_ID, CONVERT(varchar(16),DT,121) DT, RF_15MIN, WL_UP, WL_DOWN  FROM  row_data
		where STN_ID='".$stn_id."' ORDER BY DT DESC";
		$res = odbc_exec($conn, $sqlreal);
		$row = odbc_fetch_array($res);

		$sqlal = "SELECT stn.STN_ID, stn.STN_CODE, stn.STN_NAME_THAI
					,Sum(case when  Sensor_Type='100' and Level_alarm='1' then Value  end) rfw
					,Sum(case when  Sensor_Type='100' and Level_alarm='2' then Value  end) rfd
					,Sum(case when  Sensor_Type='200' and Level_alarm='1' then Value  end) wlw
					,Sum(case when  Sensor_Type='200' and Level_alarm='2' then Value  end) wld
					,Sum(case when  Sensor_Type='201' and Level_alarm='1' then Value  end) wl2w
					,Sum(case when  Sensor_Type='201' and Level_alarm='2' then Value  end) wl2d
					FROM TM_STN stn JOIN TM_Alarm al  
					on stn.STN_ID = al.STN_ID  
					where stn.STN_ID='".$stn_id."'
					Group by stn.STN_ID, stn.STN_CODE, stn.STN_NAME_THAI";
		$resal = odbc_exec($conn, $sqlal);
		$rowal = odbc_fetch_array($resal);

		$strf=gen_data($sys_arr['Check_rf'],$row['DT'],$row['RF_15MIN'],$rowal['rfw'],$rowal['rfd']);
		$stwl_u=gen_data($sys_arr['Check_wl_up'],$row['DT'],$row['WL_UP'],$rowal['wlw'],$rowal['wld']);
		$stwl_d=gen_data($sys_arr['Check_wl_dw'],$row['DT'],$row['WL_DOWN'],$rowal['wl2w'],$rowal['wl2d']);
		if($_GET['view'] == "scada")
		{
		$img1=$sys_arr['image_cctv'];
		$img2=$sys_arr['image_cctv2'];
		}
		else
		{
			$gdate=date('Y-m-d H:i');
		$p='http://182.52.224.70/MilestoneImageService/ImageService.svc/ImageService/GetImage?width=800&height=450&ondate='.$gdate.'&cameraname=';
		$img1=$p.$sys_arr["image_scada1"];
		$img2=$p.$sys_arr["image_scada2"];
		}
		
		$cctv=ch_camera($sys_arr['Check_camera'],$img1,$img2);

		$zone = trim($sys_arr["zone"]);
		$section_url = ($zone <> "C")? '/CrossSectionService/CrossSectionService.svc/SVGService/GetFloodGate?stnCode='.trim($sys_arr["STN_CODE"]).'&wlUp='.$stwl_u["value"]["now"].'&wlDown='.$stwl_d["value"]["now"].'&wlUpH='.$stwl_u["value"]["warning"].'&wlUpHH='.$stwl_u["value"]["danger"].'&wlDownH='.$stwl_d["value"]["warning"].'&wlDownHH='.$stwl_d["value"]["danger"].'&isBinding=true' : '/CrossSectionService/CrossSectionService.svc/SVGService/GetPavement?stnCode='.trim($sys_arr["STN_CODE"]).'&wl='.$stwl_u["value"]["now"].'&wlH='.$stwl_u["value"]["warning"].'&wlHH='.$stwl_u["value"]["danger"];
		//$section_url = "/scada/test.svg";

		$outpp = array("id"=>trim($sys_arr["STN_ID"]),"code"=>trim($sys_arr["STN_CODE"]),"zone"=>$zone,"name"=>trim($name),"address"=>"","cctv"=>$cctv,"location"=>array("lat"=> (float)$sys_arr['Lat'],"lng"=> (float)$sys_arr['Lng']),"terrain"=>array("bottom"=> (int)$sys_arr['bottom'],"top"=> (int)$sys_arr['topp']),"data"=>array("rf"=> $strf,"wl_up"=> $stwl_u,"wl_down"=> $stwl_d),"date"=>$row["DT"],"timeout"=>false,"door"=>true, "section_url"=>$section_url );

		
			
array_push($outp,$outpp);
}

$_temp['station'] = $outp;




function gen_data($che,$dt,$value,$warn,$dan)
{
	$value = $value;
	$warning = $warn;
	$danger = $dan;

	$DTNOW = date('Y-m-d H:i');
	$DTDiff = TimeDiff($dt, $DTNOW)."__";
	//$DTNOW."--".$dt."==".$DTDiff."<br>";

	if ( $value >= $danger )
	{
		if($DTDiff > 30 && $DTDiff <= 180 )
		{
			$status = "black";
		}
		elseif($DTDiff > 180 && $DTDiff <= 4320 )
		{
			$status = "gray";
		}
		elseif($DTDiff > 4320)
		{
			$status = "white";
		}
		else
		{
			$status = "danger";
		}
	}
	else if ( $value >= $warning )
	{
		if($DTDiff > 30 && $DTDiff <= 180 )
		{
			$status = "black";
		}
		elseif($DTDiff > 180 && $DTDiff <= 4320 )
		{
			$status = "gray";
		}
		elseif($DTDiff > 4320)
		{
			$status = "white";
		}
		else
		{
			$status = "warning";
		}
	}
	else
	{
		if($DTDiff > 30 && $DTDiff <= 180 )
		{
			$status = "black";
		}
		elseif($DTDiff > 180 && $DTDiff <= 4320 )
		{
			$status = "gray";
		}
		elseif($DTDiff > 4320)
		{
			$status = "white";
		}
		else
		{
			$status = "success";
		}
	}

	if($che=="1")
	{
		$arr = array
			(
				"enable" => true,
				"value"=>array("now"=> number_format(((float)$value),2),"warning"=> (float)$warn,"danger"=> (float)$dan,"status"=> $status)
			);
	}
	else
	{
		$arr = array
			(
				"enable" => false,
				"value"=> null
			);
	}

	return $arr;
}

function ch_camera($che,$cctv,$cctv2)
{
	if($che=="2")
	{
		$arr = array($cctv,$cctv2);
	}
	elseif($che=="1")
	{
		$arr = array($cctv);
	}
	else
	{
		$arr = [] ;
	}
	return $arr;
}

function TimeDiff($strTime1, $strTime2)
{
	return (strtotime($strTime2) - strtotime($strTime1))/  ( 60 ); // 1 Min =  60
}

?>