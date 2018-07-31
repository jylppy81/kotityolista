<?php
session_start();
include '../dbconnection.php';

if(isset($_SESSION["userid"])) {
	$userid = $_SESSION["userid"];
}

if(isset($_POST["toiminto"])) { $toiminto = $_POST["toiminto"]; }
if(isset($_POST["henkiloid"])) {
        if(!is_numeric($_POST["henkiloid"])) {
                $henkiloid = '';
        } else {
                $henkiloid = $_POST["henkiloid"];
        }
}
if(isset($_POST["nimi"])) { $nimi = htmlspecialchars($_POST["nimi"], ENT_QUOTES); }
if(isset($_POST["username"])) { $username = htmlspecialchars($_POST["username"], ENT_QUOTES); }
if(isset($_POST["admin"])) {
        $admin = 1;
} else {
	$admin = 0;
}
if(isset($_POST["passwd"])) { $passwd = $_POST["passwd"]; }

if($toiminto == "add") {
        $query = "INSERT INTO henkilo (nimi, username, admin, passwd) VALUES ('" . $nimi . "','" . $username . "'," . $admin . ",'" . password_hash($passwd, PASSWORD_DEFAULT)  . "')";
        if(!$result = $conn->query($query)) {
                die("Lisääminen epäonnistui");
        }
}

if($toiminto == "update") {
	if($passwd == "") {
	        $query = "UPDATE henkilo SET nimi = '".$nimi."', username = '".$username."', admin = '".$admin."' WHERE henkiloid = ".$henkiloid;
	} else {
		$query = "UPDATE henkilo SET nimi = '".$nimi."', username = '".$username."', admin = '".$admin."', passwd = '". password_hash($passwd, PASSWORD_DEFAULT) ."' WHERE henkiloid = ".$henkiloid;
	}

	if(!$result = $conn->query($query)) {
		die("Päivitys epäonnistui");
	}
}

if($toiminto == "delete") {
        $query = "DELETE FROM henkilo WHERE henkiloid = ".$henkiloid;
        if(!$result = $conn->query($query)) {
                die("Poistaminen epäonnistui");
        }
}


?>

<!DOCTYPE html>
<html>
<head>
<title>Henkilöiden ylläpito</title>
<meta charset="ISO-8859-1">
<meta http-equiv="Content-Type" content="text/html;charset=ISO-8859-1">
</head>
<body>
<h1>Henkilöiden hallinta</h1>
<p>Tässä näkymässä pääset hallitsemaan olemassaolevia henkilöitä ja lisäämään uusia. Jos et halua muuttaa salasanaa päivityksen yhteydessä, jätä kenttä tyhjäksi.</p>
<table>
<tr>
<th>ID</th><th>Henkilö</th><th>Käyttäjätunnus</th><th>Admin</th><th>Salasana</th>
</tr>
<?php
$query = "SELECT henkiloid, nimi, username, admin FROM henkilo ORDER BY henkiloid";
$result = $conn->query($query);
while($row = $result->fetch_row()) {
	echo '<form action="henkilo.php" method="post"><input type="hidden" name="henkiloid" value="'.$row[0].'"><td>'.$row[0].'</td><td><input type="text" value="'.$row[1].'" name="nimi"></td><td><input type="text" value="'.$row[2].'" name="username"></td><td><input type="checkbox" name="admin" ';
	if($row[3] == 1) { echo 'checked'; }
	echo'></td><td><input type="password" name="passwd" value=""></td><td><button type="submit" name="toiminto" value="update">Päivitä</button></td><td><button type="submit" name="toiminto" value="delete" onClick="return confirm(\'haluatko varmasti poistaa henkilön?\')">Poista</button></td></tr></form>';
}
?>
<form action="henkilo.php" method="post"><td>&nbsp;</td><td><input type="text" name="nimi"></td><td><input type="text" name="username"></td><td><input type="checkbox" name="admin"></td><td><input type="password" name="passwd"></td><td colspan="2"><button type="submit" name="toiminto" value="add">Lisää</button></td></tr></form>
</table>
<br />
<a href="index.php">&raquo; Palaa</a>

</body>
</html>
