<FORM METHOD="post" ONSUBMIT="return confirmBox()">
	<TABLE CLASS="noborder">
		<TR>
			<TD ALIGN="right">รหัสสถานี</TD>
			<TD ALIGN="left"><INPUT TYPE="text" NAME="id" VALUE="<?php echo $_stn ?>" DISABLED /></TD>
		</TR>
		<TR>
			<TD ALIGN="right">ชื่อสถานี</TD>
			<TD ALIGN="left"><INPUT TYPE="text" NAME="stn_name" VALUE="<?php echo $_name ?>" DISABLED/></TD>
		</TR>
		<TR>
			<TD ALIGN="right">ปริมาณน้ำฝน</TD>
			<TD ALIGN="left"><INPUT TYPE="text" NAME="rfw" VALUE="<?php echo $rfw ?>" placeholder="เตือนภัย"/></TD>
			<TD ALIGN="left"><INPUT TYPE="text" NAME="rfd" VALUE="<?php echo $rfd ?>" placeholder="วิกฤต"/></TD>
		</TR>
		<TR>
			<TD ALIGN="right">ระดับน้ำหน้าประตู</TD>
			<TD ALIGN="left"><INPUT TYPE="text" NAME="wlw" VALUE="<?php echo $wlw ?>" placeholder="เตือนภัย"/></TD>
			<TD ALIGN="left"><INPUT TYPE="text" NAME="wld" VALUE="<?php echo $wld ?>" placeholder="วิกฤต"/></TD>
		</TR>
		<TR>
			<TD ALIGN="right">ระดับน้ำหลังประตู</TD>
			<TD ALIGN="left"><INPUT TYPE="text" NAME="wl2w" VALUE="<?php echo $wl2w ?>" placeholder="เตือนภัย"/></TD>
			<TD ALIGN="left"><INPUT TYPE="text" NAME="wl2d" VALUE="<?php echo $wl2d ?>" placeholder="วิกฤต"/></TD>
		</TR>
		<TR>
			<TD></TD>
			<TD ALIGN="left">
				<BR>
				<INPUT TYPE="hidden" NAME="id" VALUE="<?php echo $_id ?>" />
				<INPUT TYPE="submit" NAME="submit" CLASS="b_blue" VALUE="แก้ไข" />
				<INPUT TYPE="button" NAME="back" CLASS="b_gray" VALUE="ย้อนกลับ" ONCLICK="location.href='<?php echo$link."&view=alert"?>'" />
			</TD>
		</TR>
	</TABLE>
</FORM>
<?php
if( $_SERVER['REQUEST_METHOD'] === 'POST' )
{
	$_rfw = trim($_POST['rfw']);
	$_rfd = trim($_POST['rfd']);
	$_wlw = trim($_POST['wlw']);
	$_wld = trim($_POST['wld']);
	$_wl2w = trim($_POST['wl2w']);
	$_wl2d = trim($_POST['wl2d']);
	

	/*$sql_up =	"UPDATE TM_Alarm ".
						"SET ".
							"value = '".$_rfw."' ".
						"WHERE ".
							"STN_ID = '".$_POST['id']."' ".
							"AND Sensor_Type = '".$_POST['id']."' ".
							"AND Level_alarm = '".$_POST['id']."' ".;*/

	$update = odbc_exec($connection,$sql_up);
		
	if( $update )
	{
		echo '<META HTTP-EQUIV="refresh" CONTENT="0; url=./?sys=alert&view=alert">';
	}
	else
	{
		echo '<SPAN CLASS="msg f_red">พบข้อผิดพลาด!! กรุณา แก้ไข ให้ถูกต้อง</SPAN>';
	}
}

?>