<?php
$sql = "SELECT * FROM TM_STN ORDER BY LOC_ID";
$res = odbc_exec($connection, $sql);
$num = odbc_num_rows($res);

if ( $_POST['update'] )
{
	$sql=" ";
	while ( $arr_stn = odbc_fetch_array($res) )
	{	
		$stn_id = $arr_stn["STN_ID"];

		$nane = "name_".$stn_id."";
		$address = "address_".$stn_id."";
		$detail = "detail_".$stn_id."";
		$locid = "locid_".$stn_id."";

		$_name = iconv('UTF-8', 'TIS-620', trim($_POST[$nane]));
		$_add = iconv('UTF-8', 'TIS-620', trim($_POST[$address]));
		$_det = iconv('UTF-8', 'TIS-620', trim($_POST[$detail]));
		
		$sql .= " UPDATE TM_STN SET STN_NAME_THAI='".$_name."' , LOC_ID ='".trim($_POST[$locid])."' , STN_address ='".$_add."' , STN_DETAIL ='".$_det."' where STN_ID = '".$stn_id."' ";
	var_dump($sql);
	}
	
	//echo $sql ;
	
	$res = odbc_exec($connection,$sql);

	if( $res )
	{
		echo '<META HTTP-EQUIV="refresh" CONTENT="0; url=./?sys=station&view=site">';
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
		<TR> 
			<TH ></TH>
			<TH align="CENTER">รหัส</TH>
			<TH align="CENTER">ชื่อสถานี</TH>
			<TH align="CENTER">ที่ตั้ง</TH>
			<TH align="CENTER">ผู้ดูแลสถานนี</TH>
			<TH align="CENTER">ลำดับ</TH>
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
		$_address = iconv('TIS-620', 'UTF-8', $arr["STN_address"]);
		$_detail= iconv('TIS-620', 'UTF-8', $arr["STN_DETAIL"]);
		$_lat = $arr["Lat"];	
		$_long = $arr["Lng"];	

		$DTNOW = date('Y-m-d H:i');
        $DTSQL = get_dt($_id , $connection);

		if ( TimeDiff($DTSQL, $DTNOW) > 3 )
		{
			$f_conn = '<IMG SRC="../themes/img/circle_white.gif" WIDTH="16" HEIGHT="16" BORDER="0" ALT="ขาดการเชื่อมต่อ">';
		}
		else
		{
			$f_conn = '<IMG SRC="../themes/img/circle_green.gif" WIDTH="16" HEIGHT="16" BORDER="0" ALT="ปกติ">';
		}


		echo "<TR>\n";
		echo "<TH CLASS=\"bc_fade\">".$f_conn."</TH>\n";
		echo "<TH CLASS=\"bc_fade\">".$_stn."</TH>\n";

		echo "<TD><INPUT TYPE=\"text\" size=\"30\" NAME=\"name_".$_id."\" VALUE=\"".$_name."\" CLASS=\"left\" /><INPUT TYPE=\"hidden\" NAME=\"name_h\" VALUE=\"".$_name."\" /></TD>\n";
		echo "<TD><INPUT TYPE=\"text\" size=\"40\" NAME=\"address_".$_id."\" VALUE=\"".$_address."\" CLASS=\"left\" /><INPUT TYPE=\"hidden\" NAME=\"detail_h\" VALUE=\"".$_address."\" /></TD>\n";
		echo "<TD><INPUT TYPE=\"text\" size=\"40\" NAME=\"detail_".$_id."\" VALUE=\"".$_detail."\" CLASS=\"left\" /><INPUT TYPE=\"hidden\" NAME=\"detail_h\" VALUE=\"".$_detail."\" /></TD>\n";
		echo "<TD><INPUT TYPE=\"text\" size=\"10\" NAME=\"locid_".$_id."\" VALUE=\"".$_locid."\" CLASS=\"left\" /><INPUT TYPE=\"hidden\" NAME=\"detail_h\" VALUE=\"".$_locid."\" /></TD>\n";

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

<P>
	<BR>
	<IMG SRC="../themes/img/circle_green.gif" WIDTH="16" HEIGHT="16" BORDER="0" ALT="เชื่อมต่อปกติ"> เชื่อมต่อปกติ,  
	<IMG SRC="../themes/img/circle_white.gif" WIDTH="16" HEIGHT="16" BORDER="0" ALT="ขาดการเชื่อมต่อ"> ขาดการเชื่อมต่อ,
	<SPAN CLASS="f_red">**</SPAN> การแสดงผล หมายถึง การแสดงข้อมูลบนหน้าเว็บไซต์เท่านั้น (ระบบยังคงทำงานปกติ)
</P>
<?php
}
function TimeDiff($strTime1, $strTime2)
{
	return (strtotime($strTime2) - strtotime($strTime1))/  ( 60 * 60 ); // 1 Hour =  60*60
}
function get_dt($fc_site, $connection ,$fc_type = null)
{
	$sql_dt = "SELECT  top 1 STN_ID ,  DT  FROM  row_data WHERE STN_ID =  '".$fc_site."'  ORDER BY DT DESC ";
	$res_dt = odbc_exec($connection, $sql_dt);
	$arr_dt = odbc_fetch_array($res_dt);
	$xx=$arr_dt["DT"];
	$DTime = date("Y-m-d H:i",$xx);

	return $xx;
}
?>