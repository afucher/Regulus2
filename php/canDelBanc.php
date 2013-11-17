<?php
include './db.php';

$id_banc = $_REQUEST['id']; // get the requested page


$stmt = null;

$stmt = $mysql_con->prepare("SELECT 1 FROM titulos WHERE id_banc = ?");
$stmt->bind_param('i',$id_banc);
$stmt->execute();
$stmt->bind_result($test);
if($stmt->fetch()){
	echo false;
}else{
	echo true;
}


?>