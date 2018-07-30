#This file will contain the footer displayed on every page. It will also
#close possible database connections

<?php
	if($conn) { $conn.close(); }
?>
