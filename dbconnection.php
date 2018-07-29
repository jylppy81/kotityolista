<?php
$servername = "127.0.0.1:3307";
$username = "admin";
$password = "salasana";
$database = "kotityot";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error);
}

$conn->query("SET character_set_results=utf8");
mb_language('uni'); 
mb_internal_encoding('UTF-8');
$conn->query("set names 'utf8'");

?>
