<?php
session_start();
$userId = $_SESSION['id'];
	session_unset($userId);
	session_destroy($userId);
	header('location:login.php');
?>