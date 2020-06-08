
<?php
$dsn = "Driver={SQL Server};Server=127.0.0.1;Database=nonburi";
$conn = odbc_connect($dsn, 'sa', 'ata+ee&c');

	$fgroup_name =iconv('UTF-8', 'TIS-620',$_REQUEST['fgroup_name']);
	$fgroup_content=iconv('UTF-8', 'TIS-620',$_REQUEST['fgroup_content']);
	if($_REQUEST['chk']=='insert')
	{
	$query_insert="INSERT INTO [dbo].[group_user_sms]([group_name],[group_massage],[parameter],[alarm_level])VALUES('$fgroup_name','$fgroup_content',".$_REQUEST['para'].",".$_REQUEST['level'].")";
	}
	else
	{
	$query_insert="UPDATE [dbo].[group_user_sms] SET [group_name] ='".$fgroup_name."' ,[group_massage] ='".$fgroup_content."',parameter=".$_REQUEST['para'].",alarm_level=".$_REQUEST['level']."  WHERE group_id='".$_REQUEST['id']."'";
	}
	$rs_insert=odbc_exec($conn,$query_insert);


?>