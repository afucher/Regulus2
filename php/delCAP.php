<?php
include "./basic.php";
include './db.php';

sec_session_start();
if(login_check($mysql_con) == true)
{
$num_tit = isset($_REQUEST['titulo']) ? $_REQUEST['titulo']: false;
$parcela = isset($_REQUEST['parcela']) ? $_REQUEST['parcela']: false;

if($parcela){
	delOne($num_tit,$parcela,$mysql_con);
}else{
	delAll($num_tit,$mysql_con);
}
//$query = "UPDATE titulos SET phone_number=?, street_name=?, city=?, county=?, zip_code=?, day_date=?, month_date=?, year_date=? WHERE account_id=?"
}

function delAll($num_tit,$mysql_con){
$query = "DELETE FROM titulos WHERE Num_tit = ?";
if(!$stmt = $mysql_con->prepare($query)){
	echo "Prepare failed: (" . $mysql_con->errno . ") " . $mysql_con->error;
}
$stmt->bind_param('s',$num_tit);
return $stmt->execute();
}

function delOne($num_tit, $num_par,$mysql_con){
$query = "DELETE FROM titulos WHERE Num_tit = ? AND Num_par = ?";
if(!$stmt = $mysql_con->prepare($query)){
	echo "Prepare failed: (" . $mysql_con->errno . ") " . $mysql_con->error;
}
$stmt->bind_param('ss',$num_tit,$num_par);
return $stmt->execute();

}

?>