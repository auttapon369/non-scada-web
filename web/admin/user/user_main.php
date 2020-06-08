<?php
$sql = 'SELECT * FROM users ORDER BY id';
$res = odbc_exec($connection,$sql);
?>
<TABLE class="table table-striped table-condensed table-hover text-center">
	<THEAD class="bg-black bd-fade">
		<TR> 
			<TH ROWSPAN="2" COLSPAN="1">-</TH>
			<TH ROWSPAN="2">ชื่อ</TH>
			<TH ROWSPAN="2">อีเมล์</TH>
			<TH ROWSPAN="2">สถานะ</TH>
		</TR>
	</THEAD>
	<TBODY>
	<?php
	while ( $arr = odbc_fetch_array($res) )
	{
		$_id = $arr["id"];	
		$_name = iconv('TIS-620', 'UTF-8',$arr["name"]);
		$_email = $arr["email"];
		$_disable = $arr["disable"];
	
		if ( $_disable == "0" )
		{
			$_status = '<p style="color:green;">เปิดใช้งาน</p>';
		}
		else
		{
			$_status = '<p style="color:red;">ระงับการใช้งาน</p>';
		}

	?>
		<TR>
			<TD><A HREF="./?sys=user&view=user&page=edit&id=<?php echo $_id ?>"><IMG SRC="<?php echo $root ?>../themes/img/ic_edit.png" TITLE="แก้ไขข้อมูล"></A></TD>
			<TD><?php echo $_name ?></TD>
			<TD><?php echo $_email ?></TD>
			<TD><?php echo $_status ?></TD>
		</TR>
	<?php
	}
	?>
	</TBODY>
</TABLE>