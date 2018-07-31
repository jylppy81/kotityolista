<?php
// This file will contain the login functionality
session_start();
$_SESSION["userid"] = 1;
header("Location: index.php");

?>

