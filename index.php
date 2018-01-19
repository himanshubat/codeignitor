<?php 
include"db.php";
$title = "Registration";
define('TITLE_FOR_LAYOUT',$title);
$dataArray = $_POST;
if(isset($dataArray['firstname']) && !empty($dataArray['firstname']) && isset($dataArray['lastname']) && !empty($dataArray['lastname']) && isset($dataArray['email']) && !empty($dataArray['email']) && isset($dataArray['password']) && !empty($dataArray['password']) && isset($dataArray['gender']) && !empty($dataArray['gender']) && isset($dataArray['address']) && !empty($dataArray['address'])){
	$dataArray['password'] = md5($dataArray['password']); 
	$dataArray['created_at'] = date('Y-m-d h:i:s'); 
	unset($dataArray['confpassword']);
	$table_name = 'user';
	if(register($table_name,$dataArray)){
		$succesMsg = "Registration successfully..";
	}else{
		$errorMsg = "There some error to registration..";
	}
}
?>
<!DOCTYPE html>
<html>
<head>
	<title><?php echo TITLE_FOR_LAYOUT; ?></title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<script src="js/jquery.validate.min.js" type="text/javascript"></script>
	<script src="js/additional-methods.min.js" type="text/javascript"></script>
	<style type="text/css">
		.error{
			color: red;
			font-size: 13px;
		}
		#imageUploadFile {
    		display: none;
		}
	</style>

</head>
<body>
	<div class="container">
		<center><h1>User Registration</h1></center>
		<div class="col-md-8 col-md-offset-2">
			<?php if(isset($succesMsg) && !empty($succesMsg)){?>
			<div class="alert alert-success alert-dismissable">
			  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
			  <strong>Success!</strong> <?php  echo $succesMsg; ?>
			</div>
			<?php } ?>
			<form method="POST" id="registerForm">
				<div class="form-group">
				    <label for="firstname">First Name :</label>
				    <input type="text" class="form-control required" name="firstname" id="firstname" />
			  	</div>
			  	<div class="form-group">
			  		<label for="lastName">Last Name :</label>
			  		<input  type="text" class="form-control required" name="lastname" id="lastname" />
		  		</div>
				<div class="form-group">
				    <label for="email">Email Address :</label>
				    <input type="text" class="form-control required" name="email" id="email">
			  	</div>
			  	<div class="form-group">
		  			<label for="Password">Password :</label>
		  			<input type="Password" class="form-control required" name="password" id="password">
		  		</div>
		  		<div class="form-group">
		  			<label for="Password">Confirm Password :</label>
		  			<input type="Password" class="form-control" name="confpassword" >
		  		</div>
		  		<div class="form-group">
			      <label class="radio-inline"><input type="radio" name="gender" value="Male" >Male </label>
			      <label class="radio-inline"><input type="radio" name="gender" value="Female" >Female </label>
			      <div><label for="gender" generated="true" class="error" style="display: none;">this field required.</label></div>
			    </div>
			    <div class="input-with-icon right">
                    <img src="img/no-image.gif" class="img-thumbnail" id="imageUploadImg" alt="" style="width: 110px;">  
                  <button type="button" class="btn btn-info btn-cons" id="imageUploadButton">Upload</button>
                  <input name="image" class="required" extension="png|jpg|jpeg|gif" id="imageUploadFile" type="file">
                  <br><label for="imageUploadFile" generated="true" class="error" style="display: none;"></label>
              	</div>
			    <div class="form-group">
			    	<label>Address :</label>
			    	<input type="text" class="form-control required" name="address" id="address">
			    </div>
			    <center><button type="submit" class="btn btn-success">Submit</button></center>
			</form>
		</div>	
	</div>
	<script src="js/custom.js" type="text/javascript"></script>
</body>
</html>