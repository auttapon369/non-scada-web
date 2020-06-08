<?php
require('config.php');
require('boot.php');
?>
<!doctype html>
<html xmlns="http://www.w3.org/1999/xhtml" prefix="og: http://ogp.me/ns# fb: http://www.facebook.com/2008/fbml" lang="th">
<head>
	<title><?php echo $cfg['title']; ?></title>
	<!-- meta -->
	<meta charset="utf-8" />
	<meta name="robots" content="index,follow" />
	<meta name="keywords" content="<?php echo $cfg['seo']['key']; ?>"/>	
	<meta name="description" content="<?php echo $cfg['seo']['desc']; ?>" />
	<meta name="copyright" content="<?php echo $cfg['license']; ?>" />
	<!-- style -->
	<link href="<?php echo PATH_IMG; ?>favicon.ico" rel="icon" type="image/x-icon"/>
	<link href="<?php echo PATH_SCRIPT; ?>bootstrap/css/bootstrap.min.css" rel="stylesheet"/>
	<!-- <link href="<?php echo PATH_SCRIPT; ?>bootstrap/css/bootstrap-theme.min.css" rel="stylesheet"/> -->
	<link href="<?php echo PATH_CSS; ?>main.css?v=16.6.13" rel="stylesheet"/>
	<!-- script -->
	<script src="<?php echo PATH_SCRIPT; ?>jquery/jquery-1.11.2.min.js"></script>
	<script src="<?php echo PATH_SCRIPT; ?>bootstrap/js/bootstrap.min.js"></script>
	<script src="<?php echo PATH_SCRIPT; ?>main.js?v=16.6.13"></script>
	<script src="<?php echo PATH_SCRIPT; ?>angular/angular.min.js"></script>
</head>

<body>

	<!-- nav -->
	<nav class="navbar navbar-default navbar-fixed-top">
		<div class="container">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navigationbar" aria-expanded="false">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a href="./" class="navbar-brand"><img src="<?php echo PATH_IMG; ?>logo-w.png" alt="Nonthaburi"/></a>
			</div>
			<div id="navigationbar" class="navbar-collapse collapse">
				<ul class="nav navbar-nav navbar-right">
					<li id="m-home">
						<a href="./?page=home"><span class="glyphicon glyphicon-home"></span> หน้าแรก</a>
					</li>
					<!-- <li id="m-table">
						<a href="./?page=table"><span class="glyphicon glyphicon-list-alt"></span> การตรวจวัด</a>
					</li> -->
					<li id="m-station" class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="glyphicon glyphicon-flag"></span> สถานี <span class="caret"></span></a>
						<ul id="station-list" class="dropdown-menu">
							<!-- <li><a href="#">Action</a></li>
							<li><a href="#">Another action</a></li>
							<li><a href="#">Something else here</a></li>
							<li role="separator" class="divider"></li>
							<li><a href="#">Separated link</a></li> -->
						</ul>
					</li>					
					<li id="m-cctv">
						<a href="./?page=cctv"><span class="glyphicon glyphicon-facetime-video"></span> CCTV</a>
					</li>
					<?php if ( empty($_SESSION['ses_id']) )
					{} else { ?>	
					
					<li id="m-report">
						<!-- <a href="./?page=report"><span class="glyphicon glyphicon-file"></span> รายงาน</a> -->
						<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="glyphicon glyphicon-file"></span> รายงาน <span class="caret"></span></a>
						<ul class="dropdown-menu">
							<li><a href="./?page=report">ค้นหาข้อมูล</a></li>
							<li><a href="./?page=report&view=stats">สถิติ</a></li>
						</ul>
					</li>

					<?php } ?>
					
					<!-- <li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="glyphicon glyphicon-list-alt"></span> รายงาน <span class="caret"></span></a>
						<ul class="dropdown-menu">
							<li><a href="#">Action</a></li>
							<li><a href="#">Another action</a></li>
							<li><a href="#">Something else here</a></li>
							<li role="separator" class="divider"></li>
							<li><a href="#">Separated link</a></li>
						</ul>
					</li> -->
					<!-- <li id="m-login">
						<a href="./?page=login"><span class="glyphicon glyphicon-lock"></span> เข้าสู่ระบบ</a>
					</li> -->
				</ul>
			</div>
		</div>
	</nav>

	<!-- content -->
	<div class="container h-min">
		<?php include($loc); ?>
	</div>

	<!-- footer -->
	<footer class="bg-gray text-primary text-center">
		<q><?php echo $cfg['title']; ?></q>
		<br>		
		<a href="./?page=login"><span class="glyphicon glyphicon-lock"></span></a>
		&nbsp;
		<small><?php echo $cfg['copy']; ?><small>
	</footer>

</body>
</html>