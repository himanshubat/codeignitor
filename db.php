<?php
session_start();
define('DB_SERVER','localhost');
define('DB_USERNAME','root');
define('DB_PASSWORD','password');
define('DATABASE','test');

$link = mysqli_connect(DB_SERVER,DB_USERNAME,'',DATABASE);

if (!$link) {
    die('Could not connect: ' . mysqli_connect_error());
}
//echo 'Connected successfully';

function register($tableName=NULL,$dataArray=array()){
	$link = mysqli_connect(DB_SERVER,DB_USERNAME,'',DATABASE);
	if(isset($tableName) && !empty($tableName) && isset($dataArray) && !empty($dataArray)){
		$fields = array_keys($dataArray);
		$sql = "INSERT INTO ".$tableName."(".implode(',', $fields).")VALUES('".implode("','", $dataArray)."')";
		if(mysqli_query($link,$sql)){
			return 'success';
		}else{
			return 'sql error';
		}
	}
}
function uploadImage($data=array(),$path){
	if(isset($data) && !empty($data)){
		$fileName = $data['name'];
		$tempName = $data['tmp_name'];
		$fileSize = $data['size'];
		$file_ext = substr($fileName, strripos($fileName, '.'));
		$file_basename = substr($fileName, 0, strripos($fileName, '.')); 
		$imgname = md5(uniqid().$file_basename) . $file_ext;
		if($fileSize>0){
			move_uploaded_file($tempName,$path.$imgname);
		}
		return $imgname;
	}else{
		return 'fail';
	}
}
?>