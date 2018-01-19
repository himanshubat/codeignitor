<?php
include"db.php";
$userId = $_SESSION['id'];
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
	}else{
		$errorMsg = "There some error to Added Post..";
	}
}