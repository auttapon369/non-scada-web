<?php
$sql="SELECT * FROM TM_STN order by LOC_ID";
$res=odbc_exec($connection,$sql);

if ( $_POST['update'] )
{
	$sql="";
	while ( $arr_stn = odbc_fetch_array($res) )
	{	
		$stn_id = $arr_stn["STN_ID"];

		$rfw = "a_".$stn_id."_100_1";
		$rfd = "a_".$stn_id."_100_2";
		$wlw = "a_".$stn_id."_200_1";
		$wld = "a_".$stn_id."_200_2";
		$wl2w = "a_".$stn_id."_201_1";
		$wl2d = "a_".$stn_id."_201_2";
		
		$sql .= " UPDATE TM_Alarm SET value = '".trim($_POST[$rfw])."' where STN_ID = '".$stn_id."' and Sensor_Type = '100' and Level_alarm = '1'";
		$sql .= " UPDATE TM_Alarm SET value = '".trim($_POST[$rfd])."' where STN_ID = '".$stn_id."' and Sensor_Type = '100' and Level_alarm = '2'";
		$sql .= " UPDATE TM_Alarm SET value = '".trim($_POST[$wlw])."' where STN_ID = '".$stn_id."' and Sensor_Type = '200' and Level_alarm = '1'";
		$sql .= " UPDATE TM_Alarm SET value = '".trim($_POST[$wld])."' where STN_ID = '".$stn_id."' and Sensor_Type = '200' and Level_alarm = '2'";
		$sql .= " UPDATE TM_Alarm SET value = '".trim($_POST[$wl2w])."' where STN_ID = '".$stn_id."' and Sensor_Type = '201' and Level_alarm = '1'";
		$sql .= " UPDATE TM_Alarm SET value = '".trim($_POST[$wl2d])."' where STN_ID = '".$stn_id."' and Sensor_Type = '201' and Level_alarm = '2'";
	}
	
	//echo $sql ;
	
	$res = odbc_exec($connection,$sql);

	if( $res )
	{
		echo '<META HTTP-EQUIV="refresh" CONTENT="0; url=./?sys=alert&view=alert">';
	}
	else
	{
		echo '<SPAN CLASS="msg f_red">พบข้อผิดพลาด!! กรุณา แก้ไข ให้ถูกต้อง</SPAN>';
	}	
}
else
{

?>
<FORM METHOD="post" ONSUBMIT="return confirmation()">
<TABLE class="table table-striped table-condensed table-hover text-center">
	<THEAD class="bg-black bd-fade">
		<TR align="CENTER"> 
			<TH ROWSPAN="2">รหัส</TH>
			<TH ROWSPAN="2">ชื่อสถานี</TH>
			<TH COLSPAN="2">ปริมาณน้ำฝน</TH>
			<TH COLSPAN="2">ระดับน้ำหน้าประตู</TH>
			<TH COLSPAN="2">ระดับน้ำหลังประตู</TH>
		</TR>
		<TR> 
			<TH>เฝ้าระวัง</TH>
			<TH>วิกฤต</TH>
			<TH>เฝ้าระวัง</TH>
			<TH>วิกฤต</TH>
			<TH>เฝ้าระวัง</TH>
			<TH>วิกฤต</TH>
		</TR>
	</THEAD>
	<TBODY>
	<?php
	while ( $arr = odbc_fetch_array($res) )
	{
		$stn_id = $arr["STN_ID"];
		
		$STN_CODE = $arr["STN_CODE"];
		$name = iconv('TIS-620', 'UTF-8',$arr["STN_NAME_THAI"]);

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
		$resal = odbc_exec($connection, $sqlal);
		$rowal = odbc_fetch_array($resal); 

		$ck_ss=check_sensor($stn_id,$connection);
		$ck_rf=$ck_ss[0];
		$ck_u=$ck_ss[1];
		$ck_d=$ck_ss[2];
		

		echo "<TR>\n";
		echo "<TH ALIGN=\"left\" >".$STN_CODE."</TH>\n";
		echo "<TH ALIGN=\"left\" >".$name."</TH>\n";

		if($ck_rf=="1")
		{
			echo "<TD><INPUT TYPE=\"text\" size=\"10\" NAME=\"a_".$stn_id."_100_1\" VALUE=\"".check_value($rowal['rfw'])."\" /></TD>\n";
			echo "<TD><INPUT TYPE=\"text\" size=\"10\" NAME=\"a_".$stn_id."_100_2\" VALUE=\"".check_value($rowal['rfd'])."\" /></TD>\n";
		}
		else
		{
			echo "<TD bgcolor=\"\"><INPUT TYPE=\"text\" size=\"10\" NAME=\"\" VALUE=\"\" DISABLED/></TD>\n";
			echo "<TD bgcolor=\"\"><INPUT TYPE=\"text\" size=\"10\" NAME=\"\" VALUE=\"\" DISABLED/></TD>\n";
		}
		if($ck_u=="1")
		{
			echo "<TD><INPUT TYPE=\"text\" size=\"15\" NAME=\"a_".$stn_id."_200_1\" VALUE=\"".check_value($rowal['wlw'])."\" /></TD>\n";
			echo "<TD><INPUT TYPE=\"text\" size=\"15\" NAME=\"a_".$stn_id."_200_2\" VALUE=\"".check_value($rowal['wld'])."\" /></TD>\n";
		}
		else
		{
			echo "<TD bgcolor=\"\"><INPUT TYPE=\"text\" size=\"15\" NAME=\"\" VALUE=\"\" DISABLED/></TD>\n";
			echo "<TD bgcolor=\"\"><INPUT TYPE=\"text\" size=\"15\" NAME=\"\" VALUE=\"\" DISABLED/></TD>\n";
		}
		if($ck_d=="1")
		{
			echo "<TD><INPUT TYPE=\"text\" size=\"15\" NAME=\"a_".$stn_id."_201_1\" VALUE=\"".check_value($rowal['wl2w'])."\" /></TD>\n";
			echo "<TD><INPUT TYPE=\"text\" size=\"15\" NAME=\"a_".$stn_id."_201_2\" VALUE=\"".check_value($rowal['wl2d'])."\" /></TD>\n";
		}
		else
		{
			echo "<TD bgcolor=\"\"><INPUT TYPE=\"text\" size=\"15\" NAME=\"\" VALUE=\"\" DISABLED/></TD>\n";
			echo "<TD bgcolor=\"\"><INPUT TYPE=\"text\" size=\"15\" NAME=\"\" VALUE=\"\" DISABLED/></TD>\n";
		}

		echo "</TR>\n";
	}
	?>
	</TBODY>
</TABLE>
<DIV CLASS="filter dc_gray">
		<TABLE>
			<TR>
				<TD>
					<LABEL CLASS="fs_small">&nbsp;</LABEL>
					<INPUT TYPE="submit" NAME="update" STYLE="height: 30px" CLASS="button bc_sec fc_white" VALUE="บันทึกข้อมูล" />
				</TD>
			</TR>
		</TABLE>
</DIV>
</FORM>
<?php
}
?>