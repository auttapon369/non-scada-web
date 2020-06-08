<?php
$sqlu = "SELECT * FROM TM_STN WHERE STN_ID = '".$_GET['id']."'";
$resu = odbc_exec($connection, $sqlu);
$arru = odbc_fetch_array($resu);
$_id = $arru["STN_ID"];
$_stn = $arru["STN_CODE"];
$_name = iconv('TIS-620', 'UTF-8', $arru["STN_NAME_THAI"]);
$_locid = $arru["LOC_ID"];
$_lat = $arru["Lat"];	
$_long = $arru["Lng"];
//$_status = ( $_active == "Y" ) ? " CHECKED" : "";


?>
<FORM METHOD="post" ONSUBMIT="return confirmBox()">
	<TABLE CLASS="noborder">
		<TR>
			<TD ALIGN="right">รหัสสถานี</TD>
			<TD ALIGN="left"><INPUT TYPE="text" NAME="id" VALUE="<?php echo $_stn ?>" DISABLED /></TD>
		</TR>
		<TR>
			<TD ALIGN="right">ชื่อสถานี</TD>
			<TD ALIGN="left"><INPUT TYPE="text" NAME="stn_name" VALUE="<?php echo $_name ?>" /></TD>
		</TR>
		<TR>
			<TD ALIGN="right">ละติจูด</TD>
			<TD ALIGN="left"><INPUT TYPE="text" NAME="stn_lat" VALUE="<?php echo $_lat ?>" /></TD>
		</TR>
		<TR>
			<TD ALIGN="right">ลองติจูด</TD>
			<TD ALIGN="left"><INPUT TYPE="text" NAME="stn_long" VALUE="<?php echo $_long ?>" /></TD>
		</TR>
		<TR>
			<TD ALIGN="right">ลำดับ</TD>
			<TD ALIGN="left"><INPUT TYPE="text" NAME="stn_order" SIZE="2" MAXLENGTH="2" VALUE="<?php echo $_locid ?>" /></TD>
		</TR>
		<!-- <TR>
			<TD ALIGN="right"><INPUT TYPE="checkbox" NAME="stn_active" VALUE="Y"<?php echo $_status ?> /></TD>
			<TD ALIGN="left">แสดงบนเว็บไซต์</TD>
		</TR> -->
		<TR>
			<TD></TD>
			<TD ALIGN="left">
				<BR>
				<INPUT TYPE="hidden" NAME="id" VALUE="<?php echo $_GET['id'] ?>" />
				<INPUT TYPE="submit" NAME="submit" CLASS="b_blue" VALUE="แก้ไข" />
				<INPUT TYPE="button" NAME="back" CLASS="b_gray" VALUE="ย้อนกลับ" ONCLICK="location.href='<?php echo$link."&view=site"?>'" />
			</TD>
		</TR>
	</TABLE>
</FORM>
<?php
if( $_SERVER['REQUEST_METHOD'] === 'POST' )
{
	$_order = (int) preg_replace('/\D/', '', $_POST['stn_order']);
	$_name = iconv('UTF-8', 'TIS-620', trim($_POST['stn_name']));
	$_lat = trim($_POST['stn_lat']);
	$_long = trim($_POST['stn_long']);
	//$status = ( empty($_POST['stn_active']) ) ? 'N' : 'Y';

	if ( empty($_name) OR empty($_lat) OR empty($_long) )
	{
		echo '<SPAN CLASS="msg f_red">กรุณากรอกข้อมูล!!</SPAN>';
	}
	else
	{
		$sql_up =	"UPDATE TM_STN ".
							"SET ".
								"STN_NAME_THAI = '".$_name."', ".
								"Lat = '".$_lat."', ".
								"Lng = '".$_long."', ".
								"LOC_ID = '".$_order."' ".
							"WHERE ".
								"STN_ID = '".$_POST['id']."'";

		$update = odbc_exec($connection,$sql_up);
		
		if( $update )
		{
			echo '<META HTTP-EQUIV="refresh" CONTENT="0; url=./?sys=station&view=site">';
		}
		else
		{
			echo '<SPAN CLASS="msg f_red">พบข้อผิดพลาด!! กรุณา แก้ไข ให้ถูกต้อง</SPAN>';
		}
	}
}
?>