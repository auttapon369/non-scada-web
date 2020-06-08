<?php
$sql = "SELECT * FROM users WHERE id = '".$_GET['id']."'";
$res = odbc_exec($connection,$sql);
$arr = odbc_fetch_array($res);

$_id = $arr["id"];	
$_name = iconv('TIS-620', 'UTF-8',$arr["name"]);
$_email = $arr["email"];
$_pass = $arr["password"];
$_status = ( $arr['disable'] == "0" ) ? "CHECKED" : "";
?>
<FORM METHOD="post" ONSUBMIT="return confirmBox()">
	<TABLE CLASS="noborder">
		<!-- <TR>
			<TD ALIGN="right">อีเมล์</TD>
			<TD ALIGN="left"><INPUT TYPE="text" SIZE="20" VALUE="<?php echo $_mail ?>" DISABLED /></TD>
		</TR> -->
		<TR>
			<TD ALIGN="right">ชื่อ</TD>
			<TD ALIGN="left"><INPUT TYPE="text" NAME="u_name" SIZE="50" VALUE="<?php echo $_name ?>" /></TD>
		</TR>
		<TR>
			<TD ALIGN="right">อีเมล์</TD>
			<TD ALIGN="left"><INPUT TYPE="email" NAME="u_mail" SIZE="50" VALUE="<?php echo $_email ?>" /></TD>
		</TR>
		<TR>
			<TD ALIGN="right">เปลี่ยนรหัสผ่าน</TD>
			<TD ALIGN="left"><INPUT TYPE="password" NAME="u_pass" SIZE="20" VALUE="<?php echo $_pass ?>" /></TD>
		</TR>
		<TR>
			<TD></TD>
			<TD ALIGN="left"><INPUT TYPE="checkbox" NAME="u_status" VALUE="0"<?php echo $_status ?> />เปิดการใช้งาน</TD>
		</TR>
		<TR>
			<TD></TD>
			<TD ALIGN="left">
				<BR>
				<INPUT TYPE="hidden" NAME="id" VALUE="<?php echo $_GET['id'] ?>" />
				<INPUT TYPE="submit" NAME="submit" CLASS="b_blue" VALUE="แก้ไข" />
				<INPUT TYPE="button" NAME="back" CLASS="b_gray" VALUE="ย้อนกลับ" ONCLICK="location.href='./?sys=user&view=user'" />
			</TD>
		</TR>
	</TABLE>
</FORM>
<?php
if ( $_SERVER['REQUEST_METHOD'] === 'POST' )
{
	$u_name = iconv('UTF-8', 'TIS-620', trim($_POST['u_name']));
	$u_mail = trim($_POST['u_mail']);
	$u_pass = trim($_POST['u_pass']);
	$status = ( $_POST['u_status'] == "0" ) ? "0" : "1";

	
	$sql_up =	"UPDATE users ".
				"SET ".
					"name = '".$u_name."', ".
					"email = '".$u_mail."', ".
					"password = '".md5($u_pass)."', ".
					"disable = '".$status."' ".
				"WHERE ".
					"id = '".$_POST['id']."' ";
	
	
	$update = odbc_exec($connection,$sql_up);
		
	if( $update )
	{
		echo '<META HTTP-EQUIV="refresh" CONTENT="0; url=./?sys=user&view=user">';
	}
	else
	{
		echo '<SPAN CLASS="msg f_red">พบข้อผิดพลาด!! กรุณา แก้ไข ให้ถูกต้อง</SPAN>';
	}
}
?>