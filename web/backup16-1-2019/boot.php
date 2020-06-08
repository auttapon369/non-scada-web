<?php
session_start();

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