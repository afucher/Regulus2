<?php

 include "./basic.php";
 include './db.php';

$bkp_file = isset($_POST["bkp_file"]) ? $_POST["bkp_file"] : false;

if(!$bkp_file){
	die("Parametros errados");
}

$bkp_file = "." . $bkp_file;

//$bkp_file = "..\backup\db-backup-1386019129-38af6859d8d47a2704787eaa399b6aab.sql";

$sqlFileContents = file($bkp_file);

mysql_query("BEGIN");

$lRet = true;

// Loop through our array, show HTML source as HTML source; and line numbers too.
foreach ($sqlFileContents as $line) {
  $line = trim($line);

  if ($line != "" && substr($line, 0, 2) != '--') {
    $query .= $line;

    if (substr($line, -1) == ';') {
      $lRet = $mysql_con->query($query);

      //echo ($query."<br>");
      if(!$lRet){
      	mysql_query("ROLLBACK");
      	die("error!!");
      }
      /*if ($connection->errno) {
        echo ("\n".$connection->errno . ": ");
        echo ($connection->error."\n");
      }*/

      $query = "";
    }
  }
}

if($lRet){
	mysql_query("COMMIT");
}

?>