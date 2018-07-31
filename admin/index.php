<?php
$limit = "LIMIT 10";
if (isset($_POST["limit"])) {
	if ($_POST["limit"] == "kaikki") {
		$limit = "";
	} else {
		$limit = "LIMIT " . $_POST["limit"];
	}
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Ylläpito</title>
<meta charset="ISO-8859-1">
<meta http-equiv="Content-Type" content="text/html;charset=ISO-8859-1">
</head>
<body>
<h1>Kotityölistan ylläpito</h1>
<p>Mitä haluat säätää?</p>
<ul>
<li><a href="kotityo.php">Kotitöitä</a></li>
<li><a href="henkilo.php">Henkilöitä</a></li>
</ul>
<p>Alla lista tapahtumista. Oletuksena näytetään 10 viimeisintä</p>
<table>
<tr>
<th>Nimi</th><th>Kotityö</th><th>PVM</th>
</tr>

<?php
include '../dbconnection.php';

$query = "SELECT b.nimi, c.nimi, date_format(a.pvm, '%d.%m.%Y') FROM tapahtuma a, henkilo b, kotityo c 
	WHERE a.henkiloid = b.henkiloid and a.kotityoid = c.kotityoid 
	ORDER BY a.pvm DESC " . $limit;
$result = $conn->query($query);
while($row = $result->fetch_row()) {
	echo "<tr><td>" . $row[0] . "</td><td>" . $row[1] . "</td><td>" . $row[2] . "</td></tr>";
}
?>
</table>
<form action="index.php" method="post">
Kuinka monta tapahtumaa haluat näyttää?
<select name="limit">
<option value="10">10</option>
<option value="50">50</option>
<option value="100">100</option>
<option value="200">200</option>
<option value="kaikki">kaikki</option>
</select>
<button type="submit">Valitse</button>
</form>
<p>Tyhjentääksesi kaiken ja aloittaaksesi alusta, klikkaa <a href="initdb.php">tästä</a>.</p>
</body>
</html>
