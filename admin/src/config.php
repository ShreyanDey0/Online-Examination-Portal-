<?php 
	define("HOSTNAME", "localhost");
	define("USERNAME", "root");
	define("PASSWORD", "");
	define("DATABASENAME", "online_examination");

	$conn = mysqli_connect(HOSTNAME,USERNAME,PASSWORD,DATABASENAME) or die("cannot connect to databse!");

?>