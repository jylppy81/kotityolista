<html>
<head>
<title>Database initialization</title>
<meta charset="UTF-8">
<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
</head>
<body>
<?php
include '../dbconnection.php';

#database is defined in dbconnection.php and must exist before running this file.

if(isset($_POST["toiminto"])) { $toiminto = $_POST["toiminto"]; }

if($toiminto == "initialize") {
  $query = "DROP TABLE henkilo, kotityo, tapahtuma, maarays";

  $conn->query($query);

  $query = "CREATE TABLE `henkilo` (
  `henkiloid` int(6) unsigned NOT NULL AUTO_INCREMENT,
  `nimi` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `username` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `admin` tinyint(1) DEFAULT NULL,
  `passwd` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`henkiloid`)
  ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci";

  $conn->query($query);

  $query = "CREATE TABLE `kotityo` (
  `kotityoid` int(6) unsigned NOT NULL AUTO_INCREMENT,
  `nimi` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
  `toistuvuus` int(11) DEFAULT NULL,
  PRIMARY KEY (`kotityoid`)
  ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci";

  $conn->query($query);

  $query = "CREATE TABLE `tapahtuma` (
  `tapahtumaid` int(6) unsigned NOT NULL AUTO_INCREMENT,
  `henkiloid` int(6) NOT NULL,
  `kotityoid` int(6) NOT NULL,
  `pvm` datetime NOT NULL,
  PRIMARY KEY (`tapahtumaid`)
  ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci";

  $conn->query($query);

  $query = "CREATE TABLE `maarays` (
  `maaraysid` int(6) unsigned NOT NULL AUTO_INCREMENT,
  `henkiloid` int(6) unsigned NOT NULL,
  `kotityoid` int(6) unsigned NOT NULL,
  `duedate` date DEFAULT NULL,
  `tehty` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`maaraysid`)
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci";

  $conn->query($query);

?>

<h1>Tietokanta alustettu</h1>
<?php
} else {
?>
<h1>Tietokannan alustus</h1>
<p>Allaolevalla napilla voit alustaa tietokantasi. Tämä tyhjentää kaiken olemassaolevan datan ja luo uudet tyhjät tietokantataulut.</p>
<form action="initdb.php" method="post">
<button type="submit" name="toiminto" value="initialize" onclick="return confirm('Kaikki olemassaoleva data poistetaan. Jatketaanko?')">Alusta</button>
</form>
<?php
}
?>
<a href="index.php">&raquo; Palaa</a>
</body>
</html>
