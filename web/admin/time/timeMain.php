<?php
$sql = "SELECT * FROM settime ORDER BY id";
$res = odbc_exec($connection, $sql);
$num = odbc_num_rows($res);

if ( $_POST['update'] )
{
	$sql=" ";
	while ( $arr_stn = odbc_fetch_array($res) )
	{	
		$id = $arr_stn["id"];

		$nane = "s_".$id."";
		
		$sql .= " UPDATE settime SET times='".trim($_POST[$nane])."'  where id = '".$id."' ";
	}
	
	//echo $sql ;
	
	$res = odbc_exec($connection,$sql);

	if( $res )
	{
		echo '<META HTTP-EQUIV="refresh" CONTENT="0; url=./?sys=time&view=time">';
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
<TABLE class="table table-striped text-center">
	<THEAD class="bg-black bd-fade">
		<TR> 
			<TH ></TH>
			<TH >เวลา</TH>
		</TR>
	</THEAD>
	<TBODY>
	<?php
	while ( $arr = odbc_fetch_array($res) )
	{
		$_id = $arr["id"];	
		$_time = $arr["times"];	

		echo "<TR>\n";
		echo "<TH CLASS=\"bc_fade\">ตั้งค่าเวลา</TH>\n";

		echo "<TD><INPUT TYPE=\"text\" size=\"30\" NAME=\"s_".$_id."\" VALUE=\"".$_time."\" CLASS=\"\" /></TD>\n";

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
<?php }
?>