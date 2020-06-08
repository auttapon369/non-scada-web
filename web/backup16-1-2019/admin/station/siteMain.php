<?php
$server = "192.168.99.2";
$user = "sa";
$pass = "ata+ee&c";
$db_name = "nonburi";
$dsn = "Driver={SQL Server};Server=$server;Database=$db_name";
$connection = odbc_connect($dsn, $user, $pass);


$sql = 'SELECT * FROM TM_STN ORDER BY LOC_ID';
$res = odbc_exec($connection, $sql);
?>
<TABLE class="table table-striped table-condensed table-hover text-center">
	<THEAD class="bg-black bd-fade">
		<TR> 
			<TH  COLSPAN="2">-</TH>
			<TH >รหัส</TH>
			<TH >ชื่อสถานี</TH>
			<TH>ลำดับ</TH>
		</TR>
	</THEAD>
	<TBODY>
	<?php
	while ( $arr = odbc_fetch_array($res) )
	{
		$_id = $arr["STN_ID"];
		$_stn = $arr["STN_CODE"];
		$_name = iconv('TIS-620', 'UTF-8', $arr["STN_NAME_THAI"]);
		$_locid = $arr["LOC_ID"];
		$_lat = $arr["Lat"];	
		$_long = $arr["Lng"];	
		$_active = $arr["status"];

		$DTNOW = date('Y-m-d H:i');
        $DTSQL = get_dt($_id);

		if ( TimeDiff($DTSQL, $DTNOW) > 3 )
		{
			$f_conn = '<IMG SRC="'.$root.'/img/circle_white.gif" WIDTH="16" HEIGHT="16" BORDER="0" ALT="ขาดการเชื่อมต่อ">';
		}
		else
		{
			$f_conn = '<IMG SRC="'.$root.'/img/circle_green.gif" WIDTH="16" HEIGHT="16" BORDER="0" ALT="ปกติ">';
		}
							 	
		/*if ( $_active == "Y" )
		{
			$on_web = '<SPAN CLASS="f_green">แสดง</SPAN>';
		}
		else
		{
			$on_web = '<SPAN CLASS="f_red">ซ่อน</SPAN>';
		}*/
	?>
		<TR>
			<TD><A HREF="./?menu=<?php echo $_GET['menu'] ?>&page=edit&id=<?php echo $_id ?>"><IMG SRC="<?php echo $root ?>/img/ic_edit.png" TITLE="แก้ไขข้อมูล"></A></TD>
			<TD><?php echo $f_conn ?></TD>
			<TD><?php echo $_stn ?></TD>
			<TD ALIGN="left"><?php echo $_name ?></TD>
			<TD><?php echo $_locid ?></TD>
			<!-- <TD><?php echo $on_web ?></TD> -->
		</TR>
	<?php
	}
	?>
	</TBODY>
</TABLE>
<P>
	<BR>
	<IMG SRC="<?php echo $link ?>/img/circle_green.gif" WIDTH="16" HEIGHT="16" BORDER="0" ALT="เชื่อมต่อปกติ"> เชื่อมต่อปกติ,  
	<IMG SRC="<?php echo $link ?>/img/circle_white.gif" WIDTH="16" HEIGHT="16" BORDER="0" ALT="ขาดการเชื่อมต่อ"> ขาดการเชื่อมต่อ,
	<SPAN CLASS="f_red">**</SPAN> การแสดงผล หมายถึง การแสดงข้อมูลบนหน้าเว็บไซต์เท่านั้น (ระบบยังคงทำงานปกติ)
</P>
<?php
function TimeDiff($strTime1, $strTime2)
{
	return (strtotime($strTime2) - strtotime($strTime1))/  ( 60 * 60 ); // 1 Hour =  60*60
}
function get_dt($fc_site, $fc_type = null)
{
	$sql_dt = "SELECT  top 1 STN_ID ,  DT  FROM  row_data WHERE STN_ID =  '".$fc_site."'  ORDER BY DATE DESC ";
	$res_dt = odbc_exec($connection, $sql_dt);
	$arr_dt = odbc_fetch_array($res_dt);
	$xx=$arr_dt["DT"];
	$DTime = date("Y-m-d H:i",$xx);

	return $xx;
}
?>