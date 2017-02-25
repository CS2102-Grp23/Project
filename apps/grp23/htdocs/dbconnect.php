<?php

	$host = "host=localhost";
	$port = "port=5432";
	$dbname = "dbname=postgres";
	$credentials = "user=postgres password=cs2102";

	$dbconn = pg_connect("$host $port $dbname $credentials") or die('Could not connect: ' . pg_last_error());


?>
