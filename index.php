<?php
require('boot.php');
?>
<!doctype html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" ng-app="<?php echo NG_APP; ?>">
<head>
<title><?php echo TITLE; ?></title>
<meta name="viewport" content="initial-scale=1.0, user-scalable=no">
<meta charset="utf-8">
<!-- style -->
<link href="<?php echo PATH_IMG; ?>favicon.ico" rel="icon" type="image/x-icon"/>
<link href="<?php echo PATH_SCRIPT; ?>bootstrap/css/bootstrap.min.css" rel="stylesheet"/>
<link href="<?php echo PATH_SCRIPT; ?>font-awesome/css/font-awesome.min.css" rel="stylesheet"/>
<link href="<?php echo PATH_SCRIPT; ?>angular/rzslider/rzslider.min.css" rel="stylesheet"/>
<link href="<?php echo PATH_CSS; ?>scada.css" rel="stylesheet"/>
<!-- script -->
<script src="<?php echo PATH_SCRIPT; ?>jquery/jquery-1.11.2.min.js"></script>
<script src="<?php echo PATH_SCRIPT; ?>jquery/jquery.signalr-1.2.2.min.js"></script>
<script src="<?php echo PATH_SCRIPT; ?>bootstrap/js/bootstrap.min.js"></script>
<script src="<?php echo PATH_SCRIPT; ?>angular/angular.min.js"></script>
<script src="<?php echo PATH_SCRIPT; ?>angular/angular-route.min.js"></script>
<script src="<?php echo PATH_SCRIPT; ?>angular/rzslider/rzslider.min.js"></script>
<script src="<?php echo PATH_SCRIPT; ?>angular/scrollglue.js"></script>
<script src="<?php echo PATH_PLUGIN; ?>highcharts/highcharts.js"></script>
<script src="<?php echo PATH_PLUGIN; ?>highcharts/modules/exporting.js"></script>
<script src="<?php echo PATH_SCADA_APP; ?>app.js"></script>
<script src="<?php echo PATH_SCADA_APP; ?>controller.js"></script>
<script src="<?php echo PATH_SCADA_APP; ?>graph.js"></script>
<script src="<?php echo PATH_SIGNALR; ?>"></script>
</head>

<body ng-controller="<?php echo NG_CONTROLLER; ?>">

<!-- nav -->
<nav class="navbar navbar-default navbar-fixed-top"></nav>

<!-- content -->
<div class="container-fluid h-100 bg" ng-view></div>

<!-- console -->
<console class="navbar navbar-fixed-bottom"></console>

<!-- notify -->
<DIV ID="notify"></DIV>
<AUDIO ID="audio">
	<!-- <SOURCE SRC="notify/notify.ogg" TYPE="audio/ogg">
	<SOURCE SRC="notify/notify.mp3" TYPE="audio/mpeg">
	<SOURCE SRC="notify/notify.wav" TYPE="audio/wav"> -->
	<!--<EMBED SRC="notify/notify.mp3">-->
</AUDIO>

<!-- loader -->
<loader></loader>

<!-- error -->
<p class="error"></p>
<p class="error-conn" ng-hide="online" ng-bind="txtOnline"></p>

</body>
</html>