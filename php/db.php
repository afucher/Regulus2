<?php

define("HOST", "localhost"); // The host you want to connect to.
define("USER", "root"); // The database username.
define("PASSWORD", "root"); // The database password. 
define("DATABASE", "regulus_db"); // The database name.
 
$mysql_con = new mysqli(HOST, USER, PASSWORD, DATABASE);


?>