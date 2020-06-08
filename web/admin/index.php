<?php
require('../config.php');
require('boot.php');
include('function.php');
?>
<!doctype html>
<html lang="en">
<head>
	<title>GCP</title>
	<meta charset="utf-8">
	<link href="<?php echo PATH_SCRIPT; ?>bootstrap/css/bootstrap.min.css" rel="stylesheet"/>
    <link href="<?php echo PATH_SCRIPT; ?>bootstrap/css/bootstrap-datepicker.min.css" rel="stylesheet"/>   
	<link href="<?php echo PATH_CSS; ?>admin.css" rel="stylesheet">
    <script src="<?php echo PATH_SCRIPT; ?>jquery/jquery-1.11.2.min.js"></script>
    <script src="<?php echo PATH_SCRIPT; ?>bootstrap/js/bootstrap.min.js"></script>
    <script src="<?php echo PATH_SCRIPT; ?>bootstrap/js/bootstrap-datepicker.min.js"></script>
	<script src="<?php echo PATH_SCRIPT; ?>bootstrap/js/bootstrap-datepicker.th.min.js"></script>
</head>
<body>
		
    <div id="wrapper">

        <!-- Navigation -->
        <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="./">G-ControlPanel</a>
            </div>
            
            <!-- Top Menu Items -->
            <ul class="nav navbar-right top-nav">
                <li><a href="#">Hi, <?php echo$_SESSION['ses_name']?></a></li>
                <li><a href="../"><span class="glyphicon glyphicon-home text-primary"></span></a></li>
                <li><a href="./?sign=out" onclick="return confBox('Log out ?')"><span class="glyphicon glyphicon-off text-danger"></span></a></li>
                <!--<li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-envelope"></i> <b class="caret"></b></a>
                    <ul class="dropdown-menu message-dropdown">
                        <li class="message-preview">
                            <a href="#">
                                <div class="media">
                                    <span class="pull-left">
                                        <img class="media-object" src="http://placehold.it/50x50" alt="">
                                    </span>
                                    <div class="media-body">
                                        <h5 class="media-heading"><strong>Kasama Nilsak</strong>
                                        </h5>
                                        <p class="small text-muted"><i class="fa fa-clock-o"></i> Yesterday at 4:32 PM</p>
                                        <p>Lorem ipsum dolor sit amet, consectetur...</p>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li class="message-preview">
                            <a href="#">
                                <div class="media">
                                    <span class="pull-left">
                                        <img class="media-object" src="http://placehold.it/50x50" alt="">
                                    </span>
                                    <div class="media-body">
                                        <h5 class="media-heading"><strong>John Smith</strong>
                                        </h5>
                                        <p class="small text-muted"><i class="fa fa-clock-o"></i> Yesterday at 4:32 PM</p>
                                        <p>Lorem ipsum dolor sit amet, consectetur...</p>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li class="message-preview">
                            <a href="#">
                                <div class="media">
                                    <span class="pull-left">
                                        <img class="media-object" src="http://placehold.it/50x50" alt="">
                                    </span>
                                    <div class="media-body">
                                        <h5 class="media-heading"><strong>John Smith</strong>
                                        </h5>
                                        <p class="small text-muted"><i class="fa fa-clock-o"></i> Yesterday at 4:32 PM</p>
                                        <p>Lorem ipsum dolor sit amet, consectetur...</p>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li class="message-footer">
                            <a href="#">Read All New Messages</a>
                        </li>
                    </ul>
                </li>-->
                <!--<li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-bell"></i> <b class="caret"></b></a>
                    <ul class="dropdown-menu alert-dropdown">
                        <li>
                            <a href="#">Alert Name <span class="label label-default">Alert Badge</span></a>
                        </li>
                        <li>
                            <a href="#">Alert Name <span class="label label-primary">Alert Badge</span></a>
                        </li>
                        <li>
                            <a href="#">Alert Name <span class="label label-success">Alert Badge</span></a>
                        </li>
                        <li>
                            <a href="#">Alert Name <span class="label label-info">Alert Badge</span></a>
                        </li>
                        <li>
                            <a href="#">Alert Name <span class="label label-warning">Alert Badge</span></a>
                        </li>
                        <li>
                            <a href="#">Alert Name <span class="label label-danger">Alert Badge</span></a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="#">View All</a>
                        </li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Kasama Nilsak <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li>
                            <a href="#"><i class="fa fa-fw fa-user"></i> Profile</a>
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-fw fa-envelope"></i> Inbox</a>
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-fw fa-gear"></i> Settings</a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="#"><i class="fa fa-fw fa-power-off"></i> Log Out</a>
                        </li>
                    </ul>
                </li>-->
            </ul>
			
			<!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
            <div class="collapse navbar-collapse navbar-ex1-collapse">
                <ul class="nav navbar-nav side-nav">
                    <li id="m-station">
                        <a href="./?sys=station"><span class="glyphicon glyphicon-flag"></span> ข้อมูลสถานี</a>
                    </li>
                    <li id="m-alert">
                        <a href="./?sys=alert"><span class="glyphicon glyphicon-cog"></span> ตั้งค่าระดับเตือนภัย</a>
                    </li>
					 <li id="m-alert">
                        <a href="./?sys=time"><span class="glyphicon glyphicon-time"></span> ความถี่การบันทึกข้อมูล</a>
                    </li>
                    <li id="m-sms">
                        <a href="./?sys=sms"><span class="glyphicon glyphicon-send"></span> การส่ง SMS</a>
                    </li>
                    <li id="m-filter" class="divider">
                        <a href="./?sys=filter"><span class="glyphicon glyphicon-filter"></span> การกรองข้อมูล</a>
                    </li>		
                    <li id="m-user">
                        <a href="./?sys=user"><span class="glyphicon glyphicon-user"></span>  ระบบผู้ใช้งาน</a>
                    </li>
                </ul>
            </div>
            <!-- /.navbar-collapse -->

        </nav>

        <div id="page-wrapper">

            <div class="container-fluid h-min">
				<?php include($loc); ?>
            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

    </div>
	
	<!-- script -->
    <script>
    function linkAct(c)
    {
        var selected = location.href.split(c);
        if (selected.length > 1) 
        {
            return selected[1].split("&")[0];
        }
        else 
        {
            return false;
        }
    }
    function confBox(txt)
    {
        if ( !confirm(txt) )
        {
            return false;
        }
    }
	$(document).ready
    (
		function() 
        {
            var active = linkAct("?sys=");
            $('#m-'+active).addClass('active');
            
            var activesub = linkAct("&view=") || '1';
            $('#m-sub-'+activesub).addClass('active');
		}
	);
	</script>

</body>
</html>