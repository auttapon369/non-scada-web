<?php
// define path
$current_path = basename(getcwd());

switch ( $current_path )
{
	case 'web':
		define('PATH_ROOT', './');
		break;

	case 'admin':
		define('PATH_ROOT', '../');
		break;

	default:
		define('PATH_ROOT', './web/');
		break;
}


// define connection
$sv = array();
$sv['host'] = $_SERVER["SERVER_NAME"];

switch ( $sv['host'] )
{
	case 'localhost':
		$sv['user'] = '';
		$sv['pass'] = '';
		$sv['db'] = '';
		//define('HTML', 'http://localhost:8080/non/');
		//define('PATH_SIGNALR', '');
		//define('PATH_SIGNALR', 'http://cctvexpert.dyndns.org/scadahost/signalr/hubs');
		define('PATH_SIGNALR', 'http://182.52.224.70/scadahost/signalr/hubs');
		break;

	default:
		$sv['user'] = 'sa';
		$sv['pass'] = 'ata+ee&c';
		$sv['db'] = 'nonburi';
		//define('HTML', 'http://cctvexpert.dyndns.org:8080/eweb/project/non2016/');
		//define('PATH_SIGNALR', 'http://cctvexpert.dyndns.org/scadahost/signalr/hubs');
		define('PATH_SIGNALR', 'http://182.52.224.70/scadahost/signalr/hubs');
		break;
}


// variable
define('TITLE', 'SCADA-Nonthaburi');

// path
define('PAGE', PATH_ROOT.'pages/');
define('PATH_LIB', PATH_ROOT.'lib/');
define('PATH_API', PATH_LIB.'api/');
define('PATH_SCRIPT', PATH_LIB.'script/');
define('PATH_PLUGIN', PATH_LIB.'plugins/');
define('PATH_CSS', PATH_ROOT.'themes/css/');
define('PATH_IMG', PATH_ROOT.'themes/img/');
define('PATH_PAGE', PATH_ROOT.'themes/page/');

// scada
define('PATH_SCADA', './scada/');
define('PATH_SCADA_APP', PATH_SCADA.'app/');
define('PATH_SCADA_COMPONENT', PATH_SCADA.'component/');
define('PATH_SCADA_VIEW', PATH_SCADA.'view/');

// text
define('TXT_JSON_SS', 'Success');
define('TXT_JSON_ER', 'Data not found.');

// angular
define('NG_APP', 'myApp');
define('NG_CONTROLLER', 'mainCtrl');


// setup
$cfg = array
(
	"conn" => $sv,
	//"page" => array("home","table","station","cctv","report","login"),
	"title" => "โครงการติดตั้งระบบศูนย์ป้องกันและแก้ไขปัญหาน้ำท่วมภายในเขตเทศบาลนครนนทบุรี",
	"name" => "ศูนย์ป้องกันและแก้ไขปัญหาน้ำท่วม",
	"seo" => array
	(
		"key" => "ระบบศูนย์ป้องกัน, น้ำท่วม, เขตเทศบาล, นนทบุรี",
		"desc" => "โครงการติดตั้งระบบศูนย์ป้องกันและแก้ไขปัญหาน้ำท่วมภายในเขตเทศบาลนครนนทบุรี"
	),
	"copy" => "&copy 2016 เทศบาลนครนนทบุรี - Powered by Expert Engineering & Com.",
	"license" => "ATA"
);

global $cfg;

//echo PATH_API;

// unset
// unset($current_path);
// unset($sv);
?>