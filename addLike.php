<?php
include"db.php";
$response ='fail';
$error = '';
$message = '';
$result = array();
$data = $_REQUEST;
if(isset($data['action']) && !empty($data['action'])){
	if($data['action']=='addlike'){
		$userId = $_SESSION['id'];
		$postId = $data['postId'];
		$created_at = date('Y-m-d h:i:s');
		$query = "SELECT COUNT(*) AS countLIke,like_type FROM addlike WHERE post_id='".$postId."' and user_id='".$userId."'";
		$result1 = mysqli_query($link,$query);
		if(mysqli_num_rows($result1)>0){
			$fetchdata = mysqli_fetch_assoc($result1);
			$like_type = $fetchdata['like_type'];
			$count = $fetchdata['countLIke'];
			if(isset($like_type) && !empty($like_type)){
				$like_type = 'dislike';
			}else{
				$like_type = 'like';
			}
		}
		if($count==0){
			$insertquery = "INSERT INTO addlike(user_id,post_id,like_type,created_at) values('".$userId."','".$postId."','".$like_type."','".$created_at."')";
	    	if(mysqli_query($link,$insertquery)){
	    		$response = 'success';
	    	}
		}else{
			if($fetchdata['like_type']=='dislike'){
				$like_type = 'like';
				$updatequery = "UPDATE addlike SET like_type ='".$like_type."',updated_at='".date('Y-m-d H:i:s')."' WHERE user_id ='".$userId."' and post_id='".$postId."'";
				mysqli_query($link,$updatequery);
				$response = 'success';
			}else{
				$updatequery1 = "UPDATE addlike SET like_type ='".$like_type."',updated_at='".date('Y-m-d H:i:s')."' WHERE user_id ='".$userId."' and post_id='".$postId."'";
				mysqli_query($link,$updatequery1);
				$response = 'success';
			}
		}
	}
}else{
	$error = 'action_not_found';
	$message = 'action not found';
}
echo json_encode(array('response'=>$response,'result'=>$result,'error'=>$error,'message'=>$message,'likevalue'=>$like_type));