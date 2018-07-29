<?php
include '../dbconnection.php';

if(isset($_POST["toiminto"])) { $toiminto = $_POST["toiminto"]; }
if(isset($_POST["kotityoid"])) { 
	if(!is_numeric($_POST["kotityoid"])) {
		$kotityoid = ''; 
	} else { 
		$kotityoid = $_POST["kotityoid"]; 
	}
}
if(isset($_POST["nimi"])) { $nimi = htmlspecialchars($_POST["nimi"], ENT_QUOTES); }
if(isset($_POST["toistuvuus"])) { 
	if(!is_numeric($_POST["toistuvuus"])) {
		$toistuvuus = ''; 
	} else { 
		$toistuvuus = $_POST["toistuvuus"]; 
	}
}

if($toiminto == "add") {
	$query = "INSERT INTO kotityo (nimi, toistuvuus) VALUES ('" . $nimi . "','" . $toistuvuus . "')";
	if(!$result = $conn->query($query)) {
		die("Lisääminen epäonnistui");
	}
}

if($toiminto == "update") {
	$query = "UPDATE kotityo SET nimi = '".$nimi."', toistuvuus = '".$toistuvuus."' WHERE kotityoid = ".$kotityoid;
	if(!$result = $conn->query($query)) {
		die("Päivitys epäonnistui");
	}
}

if($toiminto == "delete") {
	$query = "DELETE FROM kotityo WHERE kotityoid = '".$kotityoid."'";
	if(!$result = $conn->query($query)) {
		die("Poistaminen epäonnistui");
	}
}

?>

<!DOCTYPE html>
<html>
<head>
<title>Kotitöiden ylläpito</title>
<meta charset="ISO-8859-1">
<meta http-equiv="Content-Type" content="text/html;charset=ISO-8859-1">
</head>
<body>
<h1>Kotitöiden hallinta</h1>
<p>Tässä näkymässä pääset hallitsemaan olemassaolevia kotitöitä ja lisäämään uusia.</p>
<table>
<tr>
<th>ID</th><th>Kotityö</th><th>Väli</th><th colspan="2">&nbsp;</th>
</tr>
<?php
$query = "SELECT kotityoid, nimi, toistuvuus FROM kotityo ORDER BY kotityoid";
$result = $conn->query($query);
while($row = $result->fetch_row()) {
	echo '<tr><form name="'.$row[0].'" action="kotityo.php" method="post"><td><input type="hidden" name="kotityoid" value="'.$row[0].'">'.$row[0].'</td><td><input type="text" size="50" value="'.$row[1].'" name="nimi"></td><td><input type="number" value="'.$row[2].'" name="toistuvuus"></td><td><button type="submit" name="toiminto" value="update">Päivitä</button></td><td><button type="submit" name="toiminto" value="delete" onClick="return confirm(\'haluatko varmasti poistaa kotityön?\')">Poista</button></td></form></tr>';
}
?>
<form action="kotityo.php" method="post"><tr><td>&nbsp;</td><td><input type="text" size="50" name="nimi"></td><td><input type="number" name="toistuvuus"></td><td colspan="2"><button type="submit" name="toiminto" value="add">Lisää</button></td></tr></form>
</table>
<br />
<a href="index.php">&raquo; Palaa</a>
<br />
</body>
</html>
