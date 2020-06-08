<?
$conn = connDB("odbc");

/*$arr_alarm = array();
$sql_alarm="SELECT STN_ID, alarm_WL1, alarm_WL2 FROM [dbo].[TM_STN] ORDER BY LOC_ID";
$rs_am=odbc_exec($conn, $sql_alarm);
while($row_am = odbc_fetch_array($rs_am))
{
	$a_stn=$row_am['STN_ID'];
	$a_wl1=numm($row_am['alarm_WL1']);
	$a_wl2 = numm($row_am['alarm_WL2']);
		
	$arr_alarm[] = array($a_stn , $a_wl1, $a_wl2);
}*/

function search($array, $key, $value)
{
    $results = array();

    if (is_array($array)) {
        if (isset($array[$key]) && $array[$key] == $value) {
            $results[] = $array;
        }

        foreach ($array as $subarray) {
            $results = array_merge($results, search($subarray, $key, $value));
        }
    }

    return $results;
}

//exit();

?>

<TABLE CLASS="tb_report tb_margin bc_white">
	<THEAD CLASS="bc_pri fc_white dc_black">
					<tr> 
						<th rowspan="3">วันที่</th>
					</tr>
					<tr> 
						<?php if($p_rain=="Y" && $nrf<>""){?><th colspan="<?php echo $nrf?>">ปริมาณน้ำฝน<Q CLASS="fs_small">(มม.)</Q></th><?php }else{}?>
						<?php if($p_water=="Y" && $nwl<>""){?><th colspan="<?php echo $nwl?>">ระดับน้ำ<Q CLASS="fs_small">(ม.รทก)</Q></th><?php }else{}?>
					</tr>
					<tr>
					<?php
					foreach($p_stn as $id)
					{
						$_value = cut($id);
						$ssite = $_value[0];
						//$_code= $_value[4];
						$rf = C_rf($_value[1],$p_rain);

						if($rf=="show"){?><th rowspan="1"><?php echo $ssite?></th><?php }else{}
					}

					foreach($p_stn as $id)
					{
						$_value = cut($id);
						$ssite = $_value[0];
						//$_code= $_value[4];
						$wl = C_wl($_value[2],$p_water);

						if($wl=="show"){?><th rowspan="1"><?php echo $ssite?></th><?php }else{}
					}
					?>
					</tr>
				</thead>

<?php
if($p_format=="f_15")
{	
			
				$strQuery = "SELECT CONVERT(varchar(16),dtm,121) DT ";
						
				foreach($p_stn as $id)
				{
					$_value = cut($id);
					$ssite = $_value[0];
					//$nname = $_value[4];

					$strQuery .=",Sum(case when stn='".$ssite."'  then rf  end) RF_".$ssite." ";
				}
				foreach($p_stn as $id)
				{
					$_value = cut($id);
					$ssite = $_value[0];
					//$nname = $_value[4];

					$strQuery .=",Sum(case when stn='".$ssite."'  then wl  end) WL_".$ssite." ";
				}
				
				$strQuery .="FROM [dbo].[Daily]
					WHERE 
					CONVERT(varchar(16),dtm,121) between '".$p_day1." 00:00' and '".$p_day2." 23:45' AND (DATEPART(MINUTE ,dtm))%15='0'
					GROUP BY 
						CONVERT(varchar(16),dtm,121)
					ORDER BY 
						CONVERT(varchar(16),dtm,121)	";

				//echo $strQuery;

					$objExec = odbc_exec($conn,$strQuery);
					while($objResult = odbc_fetch_array($objExec))
					{
						?>
							<tr>
								<td><?php echo date("d-m-Y H:i",strtotime($objResult['DT']));?></td>
								<?php
								foreach($p_stn as $id)
								{
									$_value = cut($id);
									$ssite = $_value[0];
									$rf = C_rf($_value[1],$p_rain);
									//$nname = $_value[4];

									if($rf=="show"){ ?><td><?php echo numm($objResult['RF_'.$ssite.'']) ?></td><?php }else{}
								}
								foreach($p_stn as $id)
								{
									$_value = cut($id);
									$ssite = $_value[0];
									$wl = C_wl($_value[2],$p_water);
									//$nname = $_value[4];

									//$r_am=search($arr_alarm, 0, $ssite);
									//$wl1 = $r_am[0][1];
									//$wl2= $r_am[0][2];

									//$bg_c=check_limit($objResult['WL_'.$ssite.''],$wl1,$wl2);
									$bg_c="White";

									if($wl=="show"){ ?><td>
									<?php echo numm($objResult['WL_'.$ssite.'']) ?></td><?php }else{}
								}
								?>
							</tr>
						<?php
					}


}
else if($p_format=="f_hr")
{	
				$strQuery = "SELECT CONVERT(varchar(16),dtm,121) DT ";	
				foreach($p_stn as $id)
				{
					$_value = cut($id);
					$ssite = $_value[0];
					//$nname = $_value[4];

					$strQuery .=",Sum(case when stn='".$ssite."'  then rf  end) RF_".$ssite." ";
				}
				foreach($p_stn as $id)
				{
					$_value = cut($id);
					$ssite = $_value[0];
					//$nname = $_value[4];

					$strQuery .=",Sum(case when stn='".$ssite."'  then wl  end) WL_".$ssite." ";
				}
				$strQuery .=" FROM [dbo].[Daily]
							WHERE CONVERT(varchar(16),dtm,121) between '".$p_day1." 00:00' and '".$p_day2." 23:45' 
								AND (DATEPART(MINUTE ,dtm))='00'
							GROUP BY 
								CONVERT(varchar(16),dtm,121)
							ORDER BY 
								CONVERT(varchar(16),dtm,121)	";

				$objExec = odbc_exec($conn,$strQuery);
				while($objResult = odbc_fetch_array($objExec))
				{

						$starhour=date("Y-m-d H:15",strtotime('-1 hour',strtotime($objResult['DT'])));
						$endhour=date("Y-m-d H:00",strtotime($objResult['DT']));
						
						//echo $starhour."<BR>";
						//echo $endhour."<BR>";

						$sumrain = "SELECT Sum(case when stn='' then rf end) aa";	
						foreach($p_stn as $id)
						{
							$_value = cut($id);
							$ssite = $_value[0];
							//$nname = $_value[4];

							$sumrain .=" ,CONVERT(decimal(38,2),SUM(case when stn='".$ssite."' then rf  end)) vhour_".$ssite." ";
						}					
						$sumrain .="FROM [dbo].[Daily] WHERE CONVERT(varchar(16),dtm,121) between '".$starhour."' and '".$endhour."'";

						$sumrf =odbc_exec($conn,$sumrain);
						$sumrfh=odbc_fetch_array($sumrf);

						?>
							<tr>
								<td><?php echo $objResult['DT'];?></td>
								<?php
								foreach($p_stn as $id)
								{
									$_value = cut($id);
									$ssite = $_value[0];
									$rf = C_rf($_value[1],$p_rain);
									//$nname = $_value[4];

									if($rf=="show"){?><td><?php echo numm($sumrfh['vhour_'.$ssite.''])?></td><?php }else{}
								}
								foreach($p_stn as $id)
								{
									$_value = cut($id);
									$ssite = $_value[0];
									$wl = C_wl($_value[2],$p_water);
									//$nname = $_value[4];

									//$r_am=search($arr_alarm, 0, $ssite);
									//$wl1 = $r_am[0][1];
									//$wl2= $r_am[0][2];

									//$bg_c=check_limit($objResult['WL_'.$ssite.''],$wl1,$wl2);
									$bg_c="White";

									if($wl=="show"){?><td style="background-color:<?php echo $bg_c; ?>"><?php echo numm($objResult['WL_'.$ssite.''])?></td><?php }else{}
								}
								?>
							</tr>
						<?php
					}
}
else if($p_format=="f_mean")
{	
				$start = strtotime($p_day1);
				$end = strtotime($p_day2);
				for ( $a = $start; $a <= $end; $a += 86400 )
				{	
					$dt=date("Y-m-d",$a);

					$strQuery = "SELECT Sum(case when stn='' then rf end) aa";	
					foreach($p_stn as $id)
					{
						$_value = cut($id);
						$ssite = $_value[0];
						//$nname = $_value[4];

						$strQuery .=" ,Sum(case when stn='".$ssite."' then rf  end) RF_".$ssite." ";
					}
					foreach($p_stn as $id)
					{
						$_value = cut($id);
						$ssite = $_value[0];
						//$nname = $_value[4];

						$strQuery .=" ,avg(case when stn='".$ssite."' then wl  end) WL_".$ssite." ";
					}
					
					$strQuery .=" FROM 	[dbo].[Daily]
							WHERE dtm between (select convert(varchar(16),(convert(varchar(10),'".$dt."',120)+' 07:01'),120)) 
							and dateAdd(dd, 1, (select convert(varchar(16),(convert(varchar(10),'".$dt."',120)+' 07:01'),120)))	";
				
					$objExec = odbc_exec($conn,$strQuery);
					//$checkrow=odbc_num_rows($objExec);
					$date_now = $dt.' 07:00';
					while($objResult = odbc_fetch_array($objExec))
					{
						?>
							<tr>
								<td><?php echo $date_now;?></td>
								<?php
								foreach($p_stn as $id)
								{
									$_value = cut($id);
									$ssite = $_value[0];
									$rf = C_rf($_value[1],$p_rain);
									//$nname = $_value[4];

									if($rf=="show"){?><td><?php echo numm($objResult['RF_'.$ssite.''])?></td><?php }else{}
								}
								foreach($p_stn as $id)
								{
									$_value = cut($id);
									$ssite = $_value[0];
									$wl = C_wl($_value[2],$p_water);
									//$nname = $_value[4];

									if($wl=="show"){?><td ><?php echo numm($objResult['WL_'.$ssite.''])?></td><?php }else{}
								}
								?>
							</tr>
						<?php
					}	
				}
}
else if($p_format=="f_min")
{	
				$start = strtotime($p_day1);
				$end = strtotime($p_day2);
				for ( $a = $start; $a <= $end; $a += 86400 )
				{	
					$dt=date("Y-m-d",$a);

					$strQuery = "SELECT min(case when stn='' then rf end) aa";	
					foreach($p_stn as $id)
					{
						$_value = cut($id);
						$ssite = $_value[0];
						//$nname = $_value[4];

						$strQuery .=" ,min(case when stn='".$ssite."' then rf  end) RF_".$ssite." ";
					}
					foreach($p_stn as $id)
					{
						$_value = cut($id);
						$ssite = $_value[0];
						//$nname = $_value[4];

						$strQuery .=" ,min(case when stn='".$ssite."' then wl  end) WL_".$ssite." ";
					}
					
					$strQuery .=" FROM 	[dbo].[Daily]
							WHERE dtm between (select convert(varchar(16),(convert(varchar(10),'".$dt."',120)+' 07:01'),120)) 
							and dateAdd(dd, 1, (select convert(varchar(16),(convert(varchar(10),'".$dt."',120)+' 07:01'),120)))	";
				
					$objExec = odbc_exec($conn,$strQuery);
					//$checkrow=odbc_num_rows($objExec);
					$date_now = $dt.' 07:00';
					while($objResult = odbc_fetch_array($objExec))
					{
						?>
							<tr>
								<td><?php echo $date_now;?></td>
								<?php
								foreach($p_stn as $id)
								{
									$_value = cut($id);
									$ssite = $_value[0];
									$rf = C_rf($_value[1],$p_rain);
									//$nname = $_value[4];

									if($rf=="show"){?><td><?php echo numm($objResult['RF_'.$ssite.''])?></td><?php }else{}
								}
								foreach($p_stn as $id)
								{
									$_value = cut($id);
									$ssite = $_value[0];
									$wl = C_wl($_value[2],$p_water);
									//$nname = $_value[4];

									if($wl=="show"){?><td><?php echo numm($objResult['WL_'.$ssite.''])?></td><?php }else{}
								}
								?>
							</tr>
						<?php
					}	
				}
}
else if($p_format=="f_max")
{	
				$start = strtotime($p_day1);
				$end = strtotime($p_day2);
				for ( $a = $start; $a <= $end; $a += 86400 )
				{	
					$dt=date("Y-m-d",$a);

					$strQuery = "SELECT max(case when stn='' then rf end) aa";	
					foreach($p_stn as $id)
					{
						$_value = cut($id);
						$ssite = $_value[0];
						//$nname = $_value[4];

						$strQuery .=" ,max(case when stn='".$ssite."' then rf  end) RF_".$ssite." ";
					}
					foreach($p_stn as $id)
					{
						$_value = cut($id);
						$ssite = $_value[0];
						//$nname = $_value[4];

						$strQuery .=" ,max(case when stn='".$ssite."' then wl  end) WL_".$ssite." ";
					}
					
					$strQuery .=" FROM 	[dbo].[Daily]
							WHERE dtm between (select convert(varchar(16),(convert(varchar(10),'".$dt."',120)+' 07:01'),120)) 
							and dateAdd(dd, 1, (select convert(varchar(16),(convert(varchar(10),'".$dt."',120)+' 07:01'),120)))	";
				
					$objExec = odbc_exec($conn,$strQuery);
					//$checkrow=odbc_num_rows($objExec);
					$date_now = $dt.' 07:00';
					while($objResult = odbc_fetch_array($objExec))
					{
						?>
							<tr>
								<td><?php echo $date_now;?></td>
								<?php
								foreach($p_stn as $id)
								{
									$_value = cut($id);
									$ssite = $_value[0];
									$rf = C_rf($_value[1],$p_rain);
									//$nname = $_value[4];

									if($rf=="show"){?><td><?php echo numm($objResult['RF_'.$ssite.''])?></td><?php }else{}
								}
								foreach($p_stn as $id)
								{
									$_value = cut($id);
									$ssite = $_value[0];
									$wl = C_wl($_value[2],$p_water);
									//$nname = $_value[4];

									if($wl=="show"){?><td><?php echo numm($objResult['WL_'.$ssite.''])?></td><?php }else{}
								}
								?>
							</tr>
						<?php
					}	
				}
}
else {}

///else///

?>
</table>
<?php
function check_limit($value, $min ,$max)
{

	if ( $value > $min && $value < $max)
	{
		$x = "Yellow";
	}
	else if ( $value > $max )
	{
		$x = "Red";
	}
	else
	{
		$x = '';
	}


	return $x;
}
?>