
<?php
$dsn = "Driver={SQL Server};Server=127.0.0.1;Database=nonburi";
$conn = odbc_connect($dsn, 'sa', 'ata+ee&c');
$a=0;
foreach($_REQUEST['station'] as $stnn)
{
	if($a==0)
	{
		$stn=$stnn;
	}
	else
	{
		$stn = $stn.",".$stnn;
	}
$a++;
}
$query_insert="INSERT INTO [dbo].[bookmarks]([stn],[typeData],[typeReport],[name])VALUES('".$stn."','".$_REQUEST['typedata']."','".$_REQUEST['typereport']."','".$_REQUEST['name']."')";
$rs_insert=odbc_exec($conn,$query_insert);
if($rs_insert)
{echo 1;}else{echo 0;}

?>