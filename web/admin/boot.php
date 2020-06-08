<?php
session_start();

if ( $_GET['sign'] == "out" ) 
{
	session_destroy();
	header('location:../');
	exit();
}
if ( empty($_SESSION['ses_id']) )
{
	header('location:../?page=login');
	exit();
}
if ( empty($_GET['sys']) ) 
{
	header('location:./?sys=station');
	exit();
}

require(PATH_API.'class.php');

$_call = new app();
$_db = new sql();
$_db->connect($cfg['conn'],'odbc');

$loc = $_call->page_direct('admin', $_GET['sys']);

$link = "./?sys=".$_GET['sys'];
$link_add = $link."&act=add";
$link_edit = $link."&act=edit&id=";
$link_del = $link."&act=delete&id=";

$ic_yes = "<i class=\"fa fa-check text-green\"></i>";
$ic_no = "-";
?>