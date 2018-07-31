<?php
session_start();
include 'dbconnection.php';

if(isset($_SESSION["userid"]) && isset($_POST["kotityoid"])) {

	$userid = $_SESSION["userid"];
	$kotityoid = $_POST["kotityoid"];

	$query = "INSERT INTO tapahtuma (henkiloid, kotityoid, pvm) VALUES (" . $userid . "," . $kotityoid . ",now())";

	$conn->query($query);

	$query = "UPDATE kotityo SET tehty = curdate() WHERE kotityoid = " . $kotityoid;

	$conn->query($query);

}

header("Location: index.php");
?>
