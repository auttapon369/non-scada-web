
<?php
$dsn = "Driver={SQL Server};Server=127.0.0.1;Database=nonburi";
$conn = odbc_connect($dsn, 'sa', 'ata+ee&c');

	if($_REQUEST['chk']=='insert')
	{
	$query_insert="INSERT INTO [dbo].[users_sms]([email],[telnum],[group_id],[status])VALUES('".$_REQUEST['email']."','".$_REQUEST['tel']."',".$_REQUEST['groupid'].",'".$_REQUEST['status']."')";
	}
	else
	{
	$query_insert="UPDATE [dbo].[users_sms] SET [email] ='".$_REQUEST['email']."' ,[telnum] ='".$_REQUEST['tel']."',group_id=".$_REQUEST['groupid'].",status='".$_REQUEST['status']."'  WHERE id='".$_REQUEST['id']."'";
	}
	echo $query_insert;
	$rs_insert=odbc_exec($conn,$query_insert);


?>