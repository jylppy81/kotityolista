<?php
include 'dbconnection.php';
session_start();

if(isset($_SESSION["userid"])) {
	$userid = $_SESSION["userid"];
	$query = "SELECT nimi, username, admin FROM henkilo WHERE henkiloid = $userid";
	$result = $conn->query($query);
	$row = $result->fetch_row();
	$nimi = $row[0];
	$username = $row[1];
	$admin = $row[2];
} else {
	$nimi = "ei kukaan";
	$username = "ei mikään";
	$admin = 0;
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Kotityölista</title>
</head>
<body>
<h1>Kotityölista</h1>
<p>Tähän tulee lista kotitöistä, kuka on tehnyt ja koska, sekä aikataulu koska pitää tehdä.</p>
<?php

if(!isset($_SESSION["userid"])) {

?>
<table>
<tr>
<th>Kotityö</th><th>Tehty viimeksi</th><th>Pitää tehdä mennessä</th>
</tr>
<?php

$query = "SELECT nimi, DATE_FORMAT(tehty, '%d.%m.%Y'), DATE_FORMAT(DATE_ADD(tehty, INTERVAL toistuvuus DAY), '%d.%m.%Y') AS takaraja FROM kotityo ORDER BY DATE_ADD(tehty, INTERVAL toistuvuus DAY)";
$result = $conn->query($query);
while($row = $result->fetch_row()) {
	echo "<tr><td>" . $row[0] . "</td><td>" . $row[1] . "</td><td>" . $row[2] . "</td></tr>";
}

?>
</table>
<?php

} else {

?>
<table>
<tr>
<th>Kotityö</th><th>Tehty viimeksi</th><th>Pitää tehdä mennessä</th><th>Merkkaa tehdyksi</th>
</tr>
<?php

$query = "SELECT kotityoid, nimi, DATE_FORMAT(tehty, '%d.%m.%Y'), DATE_FORMAT(DATE_ADD(tehty, INTERVAL toistuvuus DAY), '%d.%m.%Y') AS takaraja FROM kotityo ORDER BY DATE_ADD(tehty, INTERVAL toistuvuus DAY)";
$result = $conn->query($query);
while($row = $result->fetch_row()) {
        echo "<tr><form name='teekotityo' action='teekotityo.php' method='post'><input type='hidden' name='kotityoid' value='" . $row[0] . "'><td>" . $row[1] . "</td><td>" . $row[2] . "</td><td>" . $row[3] . "</td><td><button type='submit' name='toiminto' value='teekotityo'>Merkkaa tehdyksi</button></td></form></tr>";
}

?>
</table>

<?php

}

?>
<p>Sisään on kirjautunut</p>
<p>
<?php
echo($nimi."<br/>");
echo($username."<br/>");
echo("Admintaso ".$admin);
?>
</p>
<?php
	if(!isset($_SESSION["userid"])) {
?>
<p>Kirjaudu sisään <a href="login.php">tästä</a></p>
<?php
} else {
?>
<p>Kirjaudu ulos <a href="logout.php">tästä</a></p>
<?php
}
?>

</body>
</html>
