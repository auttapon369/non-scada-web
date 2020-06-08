<?php
session_start();

//set headers to NOT cache a page
/*
header("Cache-Control: no-cache, must-revalidate"); //HTTP 1.1
header("Pragma: no-cache"); //HTTP 1.0
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); // Date in the past
*/
//DO want a file to cache, use:
header("Cache-Control: max-age=2592000"); //30days (60sec * 60min * 24hours * 30days)

if ( empty($_GET['page']) )
{
	header('location:./?page=home');
	exit();
}

require(PATH_API.'class.php');
$page_admin = '<META http-equiv="refresh" content="0;URL=./admin">';

if ( $_SERVER['REQUEST_METHOD'] == "POST" && $_GET['page'] == "login" )
{
	$_sign = new login();

	if ( $_sign->login($_POST['email'], $_POST['password']) )
	{
		echo $page_admin;
	}
	else
	{
		$loc = PATH_PAGE."login_failed.html";
	}
}
else if ( isset($_SESSION['ses_id']) && $_GET['page'] == "login" )
{
	echo $page_admin;
}
else 
{
	$call = new app();
	$loc = $call->page_direct('', $_GET['page'], $_GET['view']);
}
?>