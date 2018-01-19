<?php
include"db.php";
$userId = $_SESSION['id'];
$sql = "SELECT * FROM user WHERE id='".$userId."'";
	$result = mysqli_query($link,$sql);
	if(mysqli_num_rows($result)>0){
		$row = mysqli_fetch_assoc($result);
	}else{
		$errorMsg = "Email and Password combination is Incorrect.";
	}
	$fetch = mysqli_query($link,"SELECT * FROM post where user_id = '".$userId."' order by id desc");
	if(mysqli_num_rows($fetch)>0){
		while($row1 = mysqli_fetch_assoc($fetch)){
			$content[] = $row1;
		}
	}
	$path = "files/";
	$dataArray = $_REQUEST;
	if(isset($dataArray['description']) && !empty($dataArray['description'])){
		$Post['user_id'] = $userId;
		$Post['description'] = $dataArray['description'];
		$Post['created_at'] = date('Y-m-d h:i:s'); 
		//if(isset($_FILES['image']) && !empty($_FILES['image'])){
			if($_FILES['image']['size']>0){
				$Post['image'] = uploadImage($_FILES['image'],$path);
			}
		//}
		$table_name = 'post';
		if(register($table_name,$Post)){
			$msg = '<script type="text/javascript">$(function () {$("#demoModal").modal("show");});</script>';
			//$succesMsg = "Post Added successfully..";
			header('location:profile.php');
		}else{
			$errorMsg = "There some error to Added Post..";
		}
	}

	//count
	$qu2 = "SELECT *  FROM addlike where user_id = '".$userId."'";
	$result12 = mysqli_query($link,$qu2);
		if(mysqli_num_rows($result12)>0){
		while ($likedata = mysqli_fetch_assoc($result12)):
			$totadata[] = $likedata;
		endwhile;
	}
	$i =0;
	if(isset($totadata) && !empty($totadata)){
		foreach ($totadata as $key => $value) {	
		$sql123 = "SELECT COUNT(*) as countlike,like_type FROM addlike WHERE user_id = '".$userId."' and like_type ='like' and post_id='".$value['post_id']."'";
			$res = mysqli_query($link,$sql123);
			$lidata = mysqli_fetch_assoc($res);
			$content[$i]['countlike'] = $lidata['countlike'];
			$content[$i]['like_type'] = $lidata['like_type'];
		$i++;}
	}
?>
<?php 
if($userId==''){
	header('location:login.php');
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Profile</title>
	<meta charset="utf-8"/>
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<script src="js/jquery.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
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
		.primary{
		    color: #1469e6 !important;
		    font-size: 14px;
		    text-transform: capitalize;
		}
		.like{
		    
		    font-size: 14px;
		    text-transform: capitalize;
		}
	</style>
</head>
<body>
<div class="container">
	<div class="col-md-10 col-md-offset-1">
	<table class="table">
		<tr>
			<th>Name:</th>
			<th>Email:</th>
			<th>Address:</th>
		</tr>
		<tr>
			<td><?php echo $row['firstname'].' '.$row['lastname'] ;?></td>
			<td><?php echo $row['email']; ?></td>
			<td><?php echo $row['address']; ?></td>
			<td><a href="logout.php" class="btn btn-danger">Logout</a></td>
		</tr>
	</table>
	<button class="btn btn-primary" type="button" id="button">Add Post</button><br>
	</div>
	<?php if(isset($succesMsg) && !empty($succesMsg)){?>
	<div class="col-md-8 col-md-offset-2">
		<div class="alert alert-success alert-dismissable">
		  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
		  <strong>Success!</strong> <?php  echo $succesMsg; ?>
		</div>
	</div>
	<?php } ?>
	<div class="col-md-6 col-md-offset-3" id="row">
		<form method="POST" enctype="multipart/form-data">
			<div class="form-group">
          		<textarea name="description" class="form-control" id="description"></textarea>
	  		</div>
			<div class="input-with-icon right">
                <img src="img/no-image.gif" class="img-thumbnail" id="imageUploadImg" alt="" style="width: 110px;">  
              <button type="button" class="btn btn-info btn-cons" id="imageUploadButton">Upload</button>
              <input name="image" class="required" extension="png|jpg|jpeg|gif" id="imageUploadFile" type="file">
              <br><label for="imageUploadFile" generated="true" class="error" style="display: none;"></label>
          	</div>
          	<button type="submit" class="btn btn-primary" style="float: right;">Post</button>
		</form>
	</div>
	<?php if(isset($content) && !empty($content)):?>
		<?php foreach($content as $list):?>
		<div class="col-md-8 col-md-offset-2">
			<?php if(isset($list['image']) && !empty($list['image'])){
				if(file_exists('files/'.$list['image'])){  ?>
			<div class="col-md-6">
				<img src="files/<?php echo $list['image']; ?>" class="img-thumbnail" />
			</div>
			<?php } ?>
			<?php } ?>
			<div class="col-md-6"><?php echo $list['description']; ?></div><br>
			<?php if(isset($list['like_type']) && $list['like_type']=='like'){?>
			<span style="padding-left: 12px;" id="<?php echo 'ylike_'.$list['id'];?>">you</span>
			<?php }?>
			<?php echo (isset($list['totallike']) && !empty($list['totallike']))?$list['totallike']:'' ?><button class="btn btn-sm like <?php echo (isset($list['countlike']) && $list['countlike']=='1')?'primary':'';?>" value="like" id="like_<?php echo $list['id']; ?>"><!-- <i class="glyphicon glyphicon-thumbs-up" style="border-color: blue 1px solid; background-color: white;"></i> -->Like</button>
		</div>
	<?php endforeach; ?>
	<?php endif;?>
	<!-- model -->
	<div class="modal fade" id="demoModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h4 class="modal-title" id="myModalLabel"></h4>
					</div>
				<div class="modal-body">
					<center><h3>Post Added successfully..</h3></center>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div>
	<!-- //model -->
</div>
<script>
$(document).ready(function(){
	$("#row").hide();
    $("#button").click(function(){
        $("#row").toggle();
    });
	$("#imageUploadImg").hide();
	$("#imageUploadButton").click(function(){
    $("#imageUploadFile").click();
  });
  $("#imageUploadFile").change(function(){
    if($("#imageUploadFile").valid()) {
      if(this.files && this.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
			$("#imageUploadImg").show();
			$("#imageUploadImg").attr("src", e.target.result).width(100);
        };
        reader.readAsDataURL(this.files[0]);
      }
    }
    else {
      $("#imageUploadImg").attr("src", "img/no-image.gif").width(100);
    }
  });
});
</script>
<?php if(isset($msg) && !empty($msg)){
	echo $msg;
}?>
<script type="text/javascript">
$(document).ready(function(e) {
    $(".like").click(function(e){
    //var file_data = $('#sortpicture').prop('files')[0]; 
    var id = this.id;
	var postId  = id.replace('like_','');  
    var form_data = new FormData();    
    //var userId =  $('#userId').val();
    //form_data.append('file', file_data);
    form_data.append('action','addlike');
    form_data.append('postId', postId);
    var likeval = $('#'+id).val();
   	$.ajax({
            url: 'addLike.php', // point to server-side PHP script 
            dataType: 'json',  // what to expect back from the PHP script, if anything
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,                         
            type: 'post',
            success: function(data){
            	console.log(data.response);
            	if(data.response=="success"){
            	$("#"+id).val(data.likevalue);
					if(data.likevalue =='like'){
						$("#"+id).addClass('primary');
						$("#"+id).before("<span style='padding-left: 12px' id='y"+id+"'>you</span>");
					}else{
						$("#"+id).removeClass('primary');
						$("#y"+id).remove(); // for removeing text
					}
            	}
            }
     });
});
});
</script>
</body>
</html>