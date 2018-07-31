<?php

session_start();
if(isset($_SESSION["userid"])) {
  unset($_SESSION["userid"]);
  session_unset();
}

header("Location: index.php");

?>
