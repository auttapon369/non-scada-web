<?php
if ( $_SERVER['REQUEST_METHOD'] == "POST" )
{
	$_sign = new login();
	$_sign->login($_POST['email'], $_POST['password']);
	header('location:./');
}
else
{
?>
<!doctype html>
<html lang="en">
	<head>
		<title>Nonthaburi</title>
		<meta charset="utf-8">
		<link href="<?php echo PATH_SCRIPT; ?>bootstrap/css/bootstrap.min.css" rel="stylesheet"/>
		<style>
		html {
			overflow-y: hidden;
			background-color: gray; 
		}
		body {
			margin: 100px auto;
			width: 500px;
			background-color: transparent;
			color: white;
		}
		</style>
	</head>
	<body class="bg-main">
		<div class="row text-center">
			<h1>S C A D A</h1>
			<h6>เทศบาลนครนนทบุรี</h6>
		</div>
		<div class="row">
			<form name="signForm" method="post" class="col-lg-6 col-lg-offset-3">
				<div class="form-group">
					<label for="inp-1">Email</label>
					<input type="email" class="form-control" id="inp-1" name="email" placeholder="Username">
				</div>
				<div class="form-group">
		    		<label for="inp-2">Password</label>
		    		<input type="password" class="form-control" id="inp-2" name="password" placeholder="Password">
		  		</div>
		  		<input type="submit" name="submit" class="btn btn-primary pull-right" value="Sign In" />
			</form>
		</div>
	</body>
</html>
<?php } ?>