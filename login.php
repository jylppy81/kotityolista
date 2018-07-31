<?php
session_start();
include 'dbconnection.php';

if(isset($_SESSION["userid"])) {
	header("Location: index.php");
}

if(isset($_POST["toiminto"])) { $toiminto = $_POST["toiminto"]; }
if(isset($_POST["username"])) { $username = htmlspecialchars($_POST["username"], ENT_QUOTES); }
if(isset($_POST["passwd"])) { $passwd = $_POST["passwd"]; }

if($toiminto == "login") {
	$query = "SELECT henkiloid, passwd FROM henkilo WHERE username = '".$username."'";
	$result = $conn->query($query);
	if($result->num_rows == 0) {
		$wrongcreds = 1;
	} else {
		$row = $result->fetch_row();
		$userid = $row[0];
		$hash = $row[1];
		if(password_verify($passwd, $hash)) {
			$_SESSION["userid"] = $userid;
			header("Location: index.php");
		} else {
			$wrongcreds = 1;
		}
	}
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Kirjaudu sisään</title>
<meta charset="UTF-8">
<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
</head>
<body>
<h1>Kirjaudu sisään</h1>
<?php

if($wrongcreds) {
	echo("<h2 style='color: red;'>Virheellinen käyttäjätunnus tai salasana</h2>");
}

?>
<form name="login-form" action="login.php" method="post">
<input name="username" type="text"><br>
<input type="password" name="passwd"><br>
<button type="submit" name="toiminto" value="login">Kirjaudu</button>
</form>
</body>
</html>
