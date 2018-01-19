<?php 
include"db.php";
$title = "Login";
define('TITLE_FOR_LAYOUT',$title);
$dataArray = $_POST;
$status = 'Inactive';
if(isset($dataArray['email']) && !empty($dataArray['email']) && isset($dataArray['password']) && !empty($dataArray['password']) ){
	$dataArray['password'] = md5($dataArray['password']); 
	$sql = "SELECT * FROM user WHERE email='".$dataArray['email']."' AND password = '".$dataArray['password']."' AND status='Active'";
	$result = mysqli_query($link,$sql);
	if(mysqli_num_rows($result)>0){
		$row = mysqli_fetch_assoc($result);
		$_SESSION['id'] = $row['id'];
		header('location:profile.php');
	}else{
		$errorMsg = "Email and Password combination is Incorrect.";
	}
}
?>
<?php if(isset($_SESSION['id']) && !empty($_SESSION['id'])){
	header('location:profile.php');
}?>
<!DOCTYPE html>
<html>
<head>
	<title><?php echo TITLE_FOR_LAYOUT; ?></title>
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<script src="js/jquery.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/jquery.validate.min.js" type="text/javascript"></script>
	<style type="text/css">
		.error{
			color: red;
			font-size: 13px;
		}
	</style>

</head>
<body>
	<div class="container">
		<center><h1>User Login</h1></center>
		<div class="col-md-6 col-md-offset-3">
			<?php if(isset($errorMsg) && !empty($errorMsg)){?>
			<div class="alert alert-danger alert-dismissable">
			  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
			  <strong>Error! </strong> <?php  echo $errorMsg; ?>
			</div>
			<?php } ?>
			<form method="POST" id="loginForm">
				<div class="form-group">
				    <label for="email">Email Address :</label>
				    <input type="text" class="form-control required" name="email" id="email">
			  	</div>
			  	<div class="form-group">
		  			<label for="Password">Password :</label>
		  			<input type="Password" class="form-control required" name="password" id="password">
		  		</div>
		  		<center><button type="submit" class="btn btn-success">Login</button></center>
			</form>
		</div>	
	</div>
	<script src="js/custom.js" type="text/javascript"></script>
	<script type="text/javascript">
		$('.alert').delay(5000).fadeOut('slow');   
	</script>
</body>
</html>
