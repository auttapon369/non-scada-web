<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
$dsn = "Driver={SQL Server};Server=127.0.0.1;Database=nonburi";
$conn = odbc_connect($dsn, 'sa', 'ata+ee&c');


$_temp = array();



if($_REQUEST['type']=='list')
{
$query_select="SELECT TOP 3 [id]  ,[name] FROM [nonburi].[dbo].[bookmarks] ORDER BY id DESC";
}
else
{
$query_select="SELECT  [stn]  ,[typeData]  ,[typeReport] ,[name] FROM [nonburi].[dbo].[bookmarks] WHERE id=".$_REQUEST['id']." ";
}
$rs_select=odbc_exec($conn,$query_select);

if($_REQUEST['type']=='list')
{
while($r=odbc_fetch_array($rs_select))
{
	$t = array("id"=>$r['id'],"name"=>iconv('TIS-620', 'UTF-8',$r['name']));
array_push($_temp,$t);
}

}
else
{
while($r=odbc_fetch_array($rs_select))
{
	$_temp = array("stn"=>trim($r['stn']),"typeData"=>trim($r['typeData']),"typeReport"=>trim($r['typeReport']),"name"=>iconv('TIS-620', 'UTF-8',trim($r['name'])));

}

}








echo json_encode($_temp);
?>